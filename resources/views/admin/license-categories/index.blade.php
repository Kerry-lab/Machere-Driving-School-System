@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">License Categories</h1>
        <p class="text-gray-500">Manage license types and their fee structures</p>
    </div>
    <a href="{{ route('admin.license-categories.create') }}"
        class="px-4 py-2 text-white rounded font-semibold text-sm shadow"
        style="background-color: #800020;">
        + Add Category
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @forelse($categories as $category)
    <div class="bg-white rounded-lg shadow p-6 border-t-4" style="border-color: #800020;">
        <div class="flex justify-between items-start mb-3">
            <h2 class="text-xl font-bold" style="color: #800020;">{{ $category->name }}</h2>
            @if($category->is_active)
                <span class="px-2 py-1 rounded text-xs font-semibold"
                    style="background-color: #d1fae5; color: #065f46;">Active</span>
            @else
                <span class="px-2 py-1 rounded text-xs font-semibold"
                    style="background-color: #fee2e2; color: #991b1b;">Inactive</span>
            @endif
        </div>

        <p class="text-gray-500 text-sm mb-4">{{ $category->description ?? 'No description' }}</p>

        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Total Fee:</span>
                <span class="font-bold" style="color: #800020;">KES {{ number_format($category->total_fee, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Practical Hours:</span>
                <span class="font-semibold">{{ $category->required_practical_hours }} hrs</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Theory Lessons:</span>
                <span class="font-semibold">{{ $category->required_theory_lessons }} lessons</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Enrolled Students:</span>
                <span class="font-semibold">{{ $category->students_count }}</span>
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <a href="{{ route('admin.license-categories.edit', $category) }}"
                class="flex-1 text-center px-3 py-2 rounded text-xs text-white font-semibold"
                style="background-color: #5B9EC9;">Edit</a>
            <form method="POST" action="{{ route('admin.license-categories.destroy', $category) }}"
                onsubmit="return confirm('Delete this category?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-3 py-2 rounded text-xs text-white font-semibold"
                    style="background-color: #800020;">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-8 text-gray-400">No license categories found.</div>
    @endforelse
</div>
@endsection