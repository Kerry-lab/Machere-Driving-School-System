@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Add New User</h1>
    <p class="text-gray-500">Create a new system user account</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. John Doe">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="e.g. john@machere.co.ke">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Role *</label>
                <select name="role" class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                    <option value="">-- Select Role --</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="branch_manager" {{ old('role') === 'branch_manager' ? 'selected' : '' }}>Branch Manager</option>
                    <option value="instructor" {{ old('role') === 'instructor' ? 'selected' : '' }}>Instructor</option>
                    <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password *</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="Minimum 8 characters">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password *</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="Repeat password">
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                class="px-6 py-2 text-white rounded font-semibold text-sm"
                style="background-color: #800020;">
                Create User
            </button>
            <a href="{{ route('admin.users.index') }}"
                class="px-6 py-2 rounded font-semibold text-sm border"
                style="color: #800020; border-color: #800020;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection