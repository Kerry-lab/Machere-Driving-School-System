<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount(['students', 'instructors'])->get();
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email',
            'manager_name' => 'nullable|string|max:255',
        ]);

        Branch::create($request->all());

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch created successfully!');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email',
            'manager_name' => 'nullable|string|max:255',
        ]);

        $branch->update($request->all());

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch updated successfully!');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully!');
    }
}