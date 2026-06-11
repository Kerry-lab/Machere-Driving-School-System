@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Branch</h1>
    <p class="text-gray-500">Update details for {{ $branch->branch_name }}</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.branches.update', $branch) }}">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Branch Name *</label>
                <input type="text" name="branch_name" value="{{ old('branch_name', $branch->branch_name) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('branch_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Location *</label>
                <input type="text" name="location" value="{{ old('location', $branch->location) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $branch->email) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Manager Name</label>
                <input type="text" name="manager_name" value="{{ old('manager_name', $branch->manager_name) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('manager_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="is_active" class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                    <option value="1" {{ $branch->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$branch->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                class="px-6 py-2 text-white rounded font-semibold text-sm"
                style="background-color: #800020;">
                Update Branch
            </button>
            <a href="{{ route('admin.branches.index') }}"
                class="px-6 py-2 rounded font-semibold text-sm border"
                style="color: #800020; border-color: #800020;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection