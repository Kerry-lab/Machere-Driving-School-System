<?php

namespace App\Http\Controllers\BranchManager;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Lesson;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $branchId = Auth::user()->instructor?->branch_id ?? Branch::first()->id;
        $branch   = Branch::find($branchId);

        $data = [
            'branch'              => $branch,
            'total_students'      => Student::where('branch_id', $branchId)->count(),
            'active_students'     => Student::where('branch_id', $branchId)->where('status', 'active')->count(),
            'completed_students'  => Student::where('branch_id', $branchId)->where('status', 'completed')->count(),
            'cleared_students'    => Student::where('branch_id', $branchId)->where('ntsa_clearance', 'cleared')->count(),
            'total_revenue'       => Payment::where('branch_id', $branchId)->where('status', 'verified')->sum('amount'),
            'pending_balance'     => Student::where('branch_id', $branchId)->sum('outstanding_balance'),
            'this_month_revenue'  => Payment::where('branch_id', $branchId)
                                        ->where('status', 'verified')
                                        ->whereMonth('payment_date', now()->month)
                                        ->sum('amount'),
            'total_lessons'       => Lesson::where('branch_id', $branchId)->count(),
            'completed_lessons'   => Lesson::where('branch_id', $branchId)->where('status', 'completed')->count(),
            'students_with_balance' => Student::where('branch_id', $branchId)
                                        ->where('outstanding_balance', '>', 0)
                                        ->with('licenseCategory')
                                        ->get(),
            'monthly_payments'    => Payment::where('branch_id', $branchId)
                                        ->where('status', 'verified')
                                        ->whereYear('payment_date', now()->year)
                                        ->selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
                                        ->groupBy('month')
                                        ->orderBy('month')
                                        ->get(),
        ];

        return view('branch.reports.index', $data);
    }

    public function export()
    {
        $branchId = Auth::user()->instructor?->branch_id ?? Branch::first()->id;
        $students = Student::where('branch_id', $branchId)
                        ->with('licenseCategory', 'payments')
                        ->get();

        $filename = 'branch_report_' . now()->format('Y_m_d') . '.csv';
        $headers  = ['Content-Type' => 'text/csv'];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Student No', 'Name', 'Phone', 'License', 'Total Fee', 'Amount Paid', 'Balance', 'Status', 'NTSA']);

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_number,
                    $student->full_name,
                    $student->phone,
                    $student->licenseCategory->name ?? 'N/A',
                    $student->agreed_total_fee,
                    $student->amount_paid,
                    $student->outstanding_balance,
                    $student->status,
                    $student->ntsa_clearance,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers + ['Content-Disposition' => "attachment; filename={$filename}"]);
    }
}