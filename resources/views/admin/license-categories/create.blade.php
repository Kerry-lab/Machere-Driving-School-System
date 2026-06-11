@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Add License Category</h1>
    <p class="text-gray-500">Define a new license type and its requirements</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.license-categories.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. Class B">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Total Fee (KES) *</label>
                <input type="number" name="total_fee" value="{{ old('total_fee') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. 15000">
                @error('total_fee')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Required Practical Hours *</label>
                <input type="number" name="required_practical_hours" value="{{ old('required_practical_hours') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. 15">
                @error('required_practical_hours')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Required Theory Lessons *</label>
                <input type="number" name="required_theory_lessons" value="{{ old('required_theory_lessons') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. 5">
                @error('required_theory_lessons')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. Light motor vehicles up to 3,500kg">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                class="px-6 py-2 text-white rounded font-semibold text-sm"
                style="background-color: #800020;">
                Create Category
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