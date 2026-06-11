@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit License Category</h1>
    <p class="text-gray-500">Update details for {{ $licenseCategory->name }}</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.license-categories.update', $licenseCategory) }}">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category Name *</label>
                <input type="text" name="name" value="{{ old('name', $licenseCategory->name) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Total Fee (KES) *</label>
                <input type="number" name="total_fee" value="{{ old('total_fee', $licenseCategory->total_fee) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('total_fee')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Required Practical Hours *</label>
                <input type="number" name="required_practical_hours" 
                    value="{{ old('required_practical_hours', $licenseCategory->required_practical_hours) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('required_practical_hours')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Required Theory Lessons *</label>
                <input type="number" name="required_theory_lessons" 
                    value="{{ old('required_theory_lessons', $licenseCategory->required_theory_lessons) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('required_theory_lessons')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">{{ old('description', $licenseCategory->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="is_active" class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                    <option value="1" {{ $licenseCategory->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$licenseCategory->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                class="px-6 py-2 text-white rounded font-semibold text-sm"
                style="background-color: #800020;">
                Update Category
            </button>
            <a href="{{ route('admin.license-categories.index') }}"
                class="px-6 py-2 rounded font-semibold text-sm border"
                style="color: #800020; border-color: #800020;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection