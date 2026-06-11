@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Branches</h1>
        <p class="text-gray-500">Manage all Machere Driving School branches</p>
    </div>
    <a href="{{ route('admin.branches.create') }}" 
        class="px-4 py-2 text-white rounded font-semibold text-sm shadow"
        style="background-color: #800020;">
        + Add New Branch
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color: #800020; color: white;">
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Branch Name</th>
                <th class="px-6 py-3 text-left">Location</th>
                <th class="px-6 py-3 text-left">Phone</th>
                <th class="px-6 py-3 text-left">Manager</th>
                <th class="px-6 py-3 text-left">Students</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($branches as $branch)
            <tr class="border-b hover:bg-blue-50">
                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                <td class="px-6 py-3 font-semibold">{{ $branch->branch_name }}</td>
                <td class="px-6 py-3">{{ $branch->location }}</td>
                <td class="px-6 py-3">{{ $branch->phone }}</td>
                <td class="px-6 py-3">{{ $branch->manager_name ?? 'Not assigned' }}</td>
                <td class="px-6 py-3">{{ $branch->students_count }}</td>
                <td class="px-6 py-3">
                    @if($branch->is_active)
                        <span class="px-2 py-1 rounded text-xs font-semibold"
                            style="background-color: #d1fae5; color: #065f46;">Active</span>
                    @else
                        <span class="px-2 py-1 rounded text-xs font-semibold"
                            style="background-color: #fee2e2; color: #991b1b;">Inactive</span>
                    @endif
                </td>
                <td class="px-6 py-3 flex gap-2">
                    <a href="{{ route('admin.branches.edit', $branch) }}"
                        class="px-3 py-1 rounded text-xs text-white font-semibold"
                        style="background-color: #5B9EC9;">Edit</a>
                    <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}"
                        onsubmit="return confirm('Delete this branch?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 rounded text-xs text-white font-semibold"
                            style="background-color: #800020;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-gray-400">No branches found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection