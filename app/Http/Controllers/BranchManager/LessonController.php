<?php

namespace App\Http\Controllers\BranchManager;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index()
    {
        $branchId = Auth::user()->instructor?->branch_id ?? Branch::first()->id;
        $lessons = Lesson::where('branch_id', $branchId)
                        ->with('student', 'instructor')
                        ->latest()
                        ->paginate(20);
        return view('branch.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $branchId = Auth::user()->instructor?->branch_id ?? Branch::first()->id;
        $students = Student::where('branch_id', $branchId)
                        ->where('status', 'active')
                        ->get();
        $instructors = Instructor::where('branch_id', $branchId)
                        ->where('is_active', true)
                        ->get();
        return view('branch.lessons.create', compact('students', 'instructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'    => 'required|exists:students,id',
            'instructor_id' => 'required|exists:instructors,id',
            'lesson_type'   => 'required|in:theory,practical',
            'lesson_date'   => 'required|date',
            'start_time'    => 'nullable',
            'end_time'      => 'nullable',
            'notes'         => 'nullable|string',
        ]);

        $branchId = Student::find($request->student_id)->branch_id;

        Lesson::create([
            'student_id'    => $request->student_id,
            'instructor_id' => $request->instructor_id,
            'branch_id'     => $branchId,
            'lesson_type'   => $request->lesson_type,
            'lesson_date'   => $request->lesson_date,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
            'status'        => 'scheduled',
            'notes'         => $request->notes,
        ]);

        return redirect()->route('branch.lessons.index')
            ->with('success', 'Lesson scheduled successfully!');
    }

    public function show(Lesson $lesson)
    {
        $lesson->load('student', 'instructor');
        return view('branch.lessons.show', compact('lesson'));
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

        return redirect()->route('branch.lessons.show', $lesson)
            ->with('success', 'Lesson updated successfully!');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('branch.lessons.index')
            ->with('success', 'Lesson deleted successfully!');
    }
}