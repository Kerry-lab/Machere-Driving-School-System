@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">System Users</h1>
        <p class="text-gray-500">Manage all user accounts and their roles</p>
    </div>
    <a href="{{ route('admin.users.create') }}"
        class="px-4 py-2 text-white rounded font-semibold text-sm shadow"
        style="background-color: #800020;">
        + Add New User
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color: #800020; color: white;">
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Role</th>
                <th class="px-6 py-3 text-left">Created</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-b hover:bg-blue-50">
                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                <td class="px-6 py-3 font-semibold">{{ $user->name }}</td>
                <td class="px-6 py-3">{{ $user->email }}</td>
                <td class="px-6 py-3">
                    @if($user->role === 'admin')
                        <span class="px-2 py-1 rounded text-xs font-semibold"
                            style="background-color: #800020; color: white;">Admin</span>
                    @elseif($user->role === 'branch_manager')
                        <span class="px-2 py-1 rounded text-xs font-semibold"
                            style="background-color: #5B9EC9; color: white;">Branch Manager</span>
                    @elseif($user->role === 'instructor')
                        <span class="px-2 py-1 rounded text-xs font-semibold"
                            style="background-color: #f59e0b; color: white;">Instructor</span>
                    @elseif($user->role === 'student')
                        <span class="px-2 py-1 rounded text-xs font-semibold"
                            style="background-color: #10b981; color: white;">Student</span>
                    @endif
                </td>
                <td class="px-6 py-3">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-3 flex gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="px-3 py-1 rounded text-xs text-white font-semibold"
                        style="background-color: #5B9EC9;">Edit</a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                        onsubmit="return confirm('Delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 rounded text-xs text-white font-semibold"
                            style="background-color: #800020;">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection