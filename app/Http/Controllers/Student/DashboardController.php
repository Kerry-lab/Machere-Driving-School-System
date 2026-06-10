<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $student = Student::where('user_id', $user->id)->with('licenseCategory')->first();

        $completedPractical = Lesson::where('student_id', $student->id)
                                ->where('status', 'completed')
                                ->where('lesson_type', 'practical')
                                ->sum('hours_logged');

        $completedTheory = Lesson::where('student_id', $student->id)
                                ->where('status', 'completed')
                                ->where('lesson_type', 'theory')
                                ->count();

        $upcomingLessons = Lesson::where('student_id', $student->id)
                                ->where('status', 'scheduled')
                                ->whereDate('lesson_date', '>=', today())
                                ->with('instructor')
                                ->get();

        $recentPayments = $student->payments()->latest()->take(5)->get();
        $isEligible     = $student->isNtsaEligible();

        return view('student.dashboard', compact(
            'student',
            'recentPayments',
            'upcomingLessons',
            'completedPractical',
            'completedTheory',
            'isEligible'
        ));
    }
}