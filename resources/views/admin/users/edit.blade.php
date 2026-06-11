@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
    <p class="text-gray-500">Update account details for {{ $user->name }}</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Role *</label>
                <select name="role" class="w-full border rounded px-3 py-2 text-sm focus:outline-none">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="branch_manager" {{ $user->role === 'branch_manager' ? 'selected' : '' }}>Branch Manager</option>
                    <option value="instructor" {{ $user->role === 'instructor' ? 'selected' : '' }}>Instructor</option>
                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="Leave blank to keep current">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="Leave blank to keep current">
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                class="px-6 py-2 text-white rounded font-semibold text-sm"
                style="background-color: #800020;">
                Update User
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