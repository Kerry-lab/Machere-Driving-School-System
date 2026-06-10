<?php

namespace App\Http\Controllers\BranchManager;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Lesson;
use App\Models\Instructor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $branchId = $user->instructor?->branch_id ?? 
                    Student::where('user_id', $user->id)->value('branch_id');

        $data = [
            'total_students'    => Student::where('branch_id', $branchId)->count(),
            'active_students'   => Student::where('branch_id', $branchId)->where('status', 'active')->count(),
            'total_instructors' => Instructor::where('branch_id', $branchId)->count(),
            'branch_revenue'    => Payment::where('branch_id', $branchId)->where('status', 'verified')->sum('amount'),
            'pending_payments'  => Payment::where('branch_id', $branchId)->where('status', 'pending')->count(),
            'cleared_students'  => Student::where('branch_id', $branchId)->where('ntsa_clearance', 'cleared')->count(),
            'todays_lessons'    => Lesson::where('branch_id', $branchId)->whereDate('lesson_date', today())->count(),
            'recent_students'   => Student::where('branch_id', $branchId)->with('licenseCategory')->latest()->take(5)->get(),
            'recent_payments'   => Payment::where('branch_id', $branchId)->with('student')->latest()->take(5)->get(),
        ];

        return view('branch.dashboard', $data);
    }
}