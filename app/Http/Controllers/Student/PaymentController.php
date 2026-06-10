<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $student = Student::where('user_id', $user->id)->with('licenseCategory')->first();

        $payments = Payment::where('student_id', $student->id)
                        ->latest()
                        ->paginate(20);

        return view('student.payments', compact('student', 'payments'));
    }
}