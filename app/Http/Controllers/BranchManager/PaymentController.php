<?php

namespace App\Http\Controllers\BranchManager;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Branch;
use App\Models\Notification;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $branchId = Auth::user()->instructor?->branch_id ?? Branch::first()->id;
        $payments = Payment::where('branch_id', $branchId)
                        ->with('student', 'recordedBy')
                        ->latest()
                        ->paginate(20);
        return view('branch.payments.index', compact('payments'));
    }

    public function create()
    {
        $branchId = Auth::user()->instructor?->branch_id ?? 1;
        $students = Student::where('branch_id', $branchId)
                        ->where('status', 'active')
                        ->get();
        return view('branch.payments.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'amount'         => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,mpesa',
            'mpesa_code'     => 'required_if:payment_method,mpesa|nullable|string',
            'payment_date'   => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        $student = Student::find($request->student_id);
        $branchId = $student->branch_id;

        $balanceBefore = $student->outstanding_balance;
        $balanceAfter  = $balanceBefore - $request->amount;

        $receiptNumber = Payment::generateReceiptNumber();

        $payment = Payment::create([
            'student_id'     => $request->student_id,
            'branch_id'      => $branchId,
            'receipt_number' => $receiptNumber,
            'amount'         => $request->amount,
            'payment_method' => $request->payment_method,
            'mpesa_code'     => $request->mpesa_code,
            'balance_before' => $balanceBefore,
            'balance_after'  => $balanceAfter,
            'payment_date'   => $request->payment_date,
            'status'         => 'verified',
            'recorded_by'    => Auth::id(),
            'notes'          => $request->notes,
        ]);

        $student->update([
            'amount_paid'         => $student->amount_paid + $request->amount,
            'outstanding_balance' => $balanceAfter,
        ]);

        if ($student->fresh()->isNtsaEligible()) {
            $student->update(['ntsa_clearance' => 'cleared']);
        }

        Notification::create([
            'student_id'   => $student->id,
            'phone_number' => $student->phone,
            'message'      => "Dear {$student->full_name}, payment of KES {$request->amount} received. Receipt: {$receiptNumber}. Balance: KES {$balanceAfter}. Thank you - Machere Driving School.",
            'type'         => 'payment_receipt',
            'status'       => 'pending',
        ]);

        AuditLog::record(
            "Recorded payment of KES {$request->amount} for student {$student->full_name}",
            'Payment',
            $payment->id
        );

        return redirect()->route('branch.payments.index')
            ->with('success', "Payment recorded! Receipt: {$receiptNumber}");
    }

    public function show(Payment $payment)
    {
        $payment->load('student', 'recordedBy');
        return view('branch.payments.show', compact('payment'));
    }
}