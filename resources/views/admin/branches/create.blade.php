@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Add New Branch</h1>
    <p class="text-gray-500">Fill in the details to create a new branch</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.branches.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Branch Name *</label>
                <input type="text" name="branch_name" value="{{ old('branch_name') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2"
                    style="focus:ring-color: #800020;"
                    placeholder="e.g. Kerugoya Branch">
                @error('branch_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Location *</label>
                <input type="text" name="location" value="{{ old('location') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. Kerugoya Town">
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. 0712345678">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. kerugoya@machere.co.ke">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Manager Name</label>
                <input type="text" name="manager_name" value="{{ old('manager_name') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. John Doe">
                @error('manager_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                class="px-6 py-2 text-white rounded font-semibold text-sm"
                style="background-color: #800020;">
                Create Branch
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