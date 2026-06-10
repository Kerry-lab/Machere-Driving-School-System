<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $instructor = Auth::user()->instructor;

        $data = [
            'instructor'        => $instructor,
            'todays_lessons'    => Lesson::where('instructor_id', $instructor->id)
                                    ->whereDate('lesson_date', today())
                                    ->with('student')
                                    ->get(),
            'upcoming_lessons'  => Lesson::where('instructor_id', $instructor->id)
                                    ->where('status', 'scheduled')
                                    ->whereDate('lesson_date', '>=', today())
                                    ->with('student')
                                    ->latest('lesson_date')
                                    ->take(10)
                                    ->get(),
            'total_lessons'     => Lesson::where('instructor_id', $instructor->id)->count(),
            'completed_lessons' => Lesson::where('instructor_id', $instructor->id)
                                    ->where('status', 'completed')
                                    ->count(),
            'total_students'    => Lesson::where('instructor_id', $instructor->id)
                                    ->distinct('student_id')
                                    ->count('student_id'),
        ];

        return view('instructor.dashboard', $data);
    }
}