<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Instructor;
use App\Models\LicenseCategory;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_branches'    => Branch::count(),
            'total_students'    => Student::count(),
            'total_instructors' => Instructor::count(),
            'total_revenue'     => Payment::where('status', 'verified')->sum('amount'),
            'pending_payments'  => Payment::where('status', 'pending')->count(),
            'active_students'   => Student::where('status', 'active')->count(),
            'cleared_students'  => Student::where('ntsa_clearance', 'cleared')->count(),
            'branches'          => Branch::withCount('students')->get(),
            'recent_payments'   => Payment::with('student', 'branch')
                                    ->latest()
                                    ->take(10)
                                    ->get(),
            'license_categories' => LicenseCategory::withCount('students')->get(),
        ];

        return view('admin.dashboard', $data);
    }
}