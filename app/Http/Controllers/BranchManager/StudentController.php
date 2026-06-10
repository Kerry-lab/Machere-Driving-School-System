<?php

namespace App\Http\Controllers\BranchManager;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Branch;
use App\Models\LicenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    private function getBranchId()
    {
        return Auth::user()->branch_manager_branch_id ?? 
               Branch::first()->id;
    }

    public function index()
    {
        $branchId = $this->getBranchId();
        $students = Student::where('branch_id', $branchId)
                        ->with('licenseCategory')
                        ->latest()
                        ->paginate(20);
        return view('branch.students.index', compact('students'));
    }

    public function create()
    {
        $licenseCategories = LicenseCategory::where('is_active', true)->get();
        return view('branch.students.create', compact('licenseCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'           => 'required|string|max:255',
            'phone'               => 'required|string|max:20',
            'id_number'           => 'required|string|unique:students',
            'date_of_birth'       => 'nullable|date',
            'gender'              => 'nullable|in:male,female,other',
            'address'             => 'nullable|string',
            'emergency_contact'   => 'nullable|string',
            'license_category_id' => 'required|exists:license_categories,id',
            'email'               => 'required|email|unique:users',
            'enrollment_date'     => 'required|date',
        ]);

        // Create user account for student
        $user = User::create([
            'name'     => $request->full_name,
            'email'    => $request->email,
            'password' => Hash::make('password123'),
            'role'     => 'student',
        ]);

        $licenseCategory = LicenseCategory::find($request->license_category_id);
        $branchId = $this->getBranchId();

        // Generate unique student number
        $studentNumber = 'MDS-' . strtoupper(Str::random(6));

        Student::create([
            'user_id'             => $user->id,
            'branch_id'           => $branchId,
            'license_category_id' => $request->license_category_id,
            'full_name'           => $request->full_name,
            'phone'               => $request->phone,
            'id_number'           => $request->id_number,
            'student_number'      => $studentNumber,
            'date_of_birth'       => $request->date_of_birth,
            'gender'              => $request->gender,
            'address'             => $request->address,
            'emergency_contact'   => $request->emergency_contact,
            'agreed_total_fee'    => $licenseCategory->total_fee,
            'amount_paid'         => 0,
            'outstanding_balance' => $licenseCategory->total_fee,
            'enrollment_date'     => $request->enrollment_date,
        ]);

        return redirect()->route('branch.students.index')
            ->with('success', 'Student enrolled successfully! Default password is password123');
    }

    public function show(Student $student)
    {
        $student->load('licenseCategory', 'payments', 'lessons.instructor', 'documents');
        return view('branch.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $licenseCategories = LicenseCategory::where('is_active', true)->get();
        return view('branch.students.edit', compact('student', 'licenseCategories'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'full_name'           => 'required|string|max:255',
            'phone'               => 'required|string|max:20',
            'address'             => 'nullable|string',
            'emergency_contact'   => 'nullable|string',
            'status'              => 'required|in:active,suspended,completed,withdrawn',
        ]);

        $student->update($request->only([
            'full_name', 'phone', 'address', 
            'emergency_contact', 'status'
        ]));

        return redirect()->route('branch.students.show', $student)
            ->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('branch.students.index')
            ->with('success', 'Student removed successfully!');
    }
}