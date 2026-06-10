<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index()
    {
        $instructor = Auth::user()->instructor;
        $lessons = Lesson::where('instructor_id', $instructor->id)
                        ->with('student')
                        ->latest('lesson_date')
                        ->paginate(20);
        return view('instructor.lessons.index', compact('lessons'));
    }

    public function show(Lesson $lesson)
    {
        $lesson->load('student', 'instructor');
        return view('instructor.lessons.show', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'status'       => 'required|in:scheduled,completed,cancelled,no_show',
            'hours_logged' => 'required_if:status,completed|numeric|min:0',
            'notes'        => 'nullable|string',
        ]);

        $lesson->update($request->only(['status', 'hours_logged', 'notes']));

        // Check NTSA eligibility after lesson completion
        if ($request->status === 'completed') {
            $student = $lesson->student;
            if ($student->isNtsaEligible()) {
                $student->update(['ntsa_clearance' => 'cleared']);
            }
        }

        return redirect()->route('instructor.lessons.index')
            ->with('success', 'Lesson updated successfully!');
    }
}
