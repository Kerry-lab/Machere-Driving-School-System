<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenseCategory;
use Illuminate\Http\Request;

class LicenseCategoryController extends Controller
{
    public function index()
    {
        $categories = LicenseCategory::withCount('students')->get();
        return view('admin.license-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.license-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                     => 'required|string|max:255',
            'description'              => 'nullable|string',
            'total_fee'                => 'required|numeric|min:0',
            'required_practical_hours' => 'required|integer|min:1',
            'required_theory_lessons'  => 'required|integer|min:1',
        ]);

        LicenseCategory::create($request->all());

        return redirect()->route('admin.license-categories.index')
            ->with('success', 'License category created successfully!');
    }

    public function edit(LicenseCategory $licenseCategory)
    {
        return view('admin.license-categories.edit', compact('licenseCategory'));
    }

    public function update(Request $request, LicenseCategory $licenseCategory)
    {
        $request->validate([
            'name'                     => 'required|string|max:255',
            'description'              => 'nullable|string',
            'total_fee'                => 'required|numeric|min:0',
            'required_practical_hours' => 'required|integer|min:1',
            'required_theory_lessons'  => 'required|integer|min:1',
        ]);

        $licenseCategory->update($request->all());

        return redirect()->route('admin.license-categories.index')
            ->with('success', 'License category updated successfully!');
    }

    public function destroy(LicenseCategory $licenseCategory)
    {
        $licenseCategory->delete();
        return redirect()->route('admin.license-categories.index')
            ->with('success', 'License category deleted successfully!');
    }
}