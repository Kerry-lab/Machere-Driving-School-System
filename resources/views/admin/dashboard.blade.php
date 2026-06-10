@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
    <p class="text-gray-500">Welcome back, {{ Auth::user()->name }}. Here's what's happening across all branches.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
        <p class="text-sm text-gray-500">Total Branches</p>
        <p class="text-3xl font-bold text-gray-800">{{ $total_branches }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Students</p>
        <p class="text-3xl font-bold text-gray-800">{{ $total_students }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Total Revenue</p>
        <p class="text-3xl font-bold text-gray-800">KES {{ number_format($total_revenue, 2) }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Pending Payments</p>
        <p class="text-3xl font-bold text-gray-800">{{ $pending_payments }}</p>
    </div>
</div>

<!-- Second Row Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
        <p class="text-sm text-gray-500">Total Instructors</p>
        <p class="text-3xl font-bold text-gray-800">{{ $total_instructors }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-indigo-500">
        <p class="text-sm text-gray-500">Active Students</p>
        <p class="text-3xl font-bold text-gray-800">{{ $active_students }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-700">
        <p class="text-sm text-gray-500">NTSA Cleared Students</p>
        <p class="text-3xl font-bold text-gray-800">{{ $cleared_students }}</p>
    </div>
</div>

<!-- Branch Performance Table -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Branch Performance</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Branch</th>
                <th class="px-4 py-2">Location</th>
                <th class="px-4 py-2">Students</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($branches as $branch)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 font-medium">{{ $branch->branch_name }}</td>
                <td class="px-4 py-2">{{ $branch->location }}</td>
                <td class="px-4 py-2">{{ $branch->students_count }}</td>
                <td class="px-4 py-2">
                    @if($branch->is_active)
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Active</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Inactive</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Recent Payments -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Payments</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Receipt</th>
                <th class="px-4 py-2">Student</th>
                <th class="px-4 py-2">Branch</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Method</th>
                <th class="px-4 py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recent_payments as $payment)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 font-mono text-xs">{{ $payment->receipt_number }}</td>
                <td class="px-4 py-2">{{ $payment->student->full_name ?? 'N/A' }}</td>
                <td class="px-4 py-2">{{ $payment->branch->branch_name ?? 'N/A' }}</td>
                <td class="px-4 py-2 font-semibold">KES {{ number_format($payment->amount, 2) }}</td>
                <td class="px-4 py-2">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs uppercase">{{ $payment->payment_method }}</span>
                </td>
                <td class="px-4 py-2">{{ $payment->payment_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection