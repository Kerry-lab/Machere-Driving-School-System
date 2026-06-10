<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LicenseCategoryController;
use App\Http\Controllers\BranchManager\DashboardController as BranchDashboard;
use App\Http\Controllers\BranchManager\StudentController;
use App\Http\Controllers\BranchManager\PaymentController;
use App\Http\Controllers\BranchManager\LessonController;
use App\Http\Controllers\BranchManager\ReportController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboard;
use App\Http\Controllers\Instructor\LessonController as InstructorLessonController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\PaymentController as StudentPaymentController;

// Home route - redirect based on role after login
Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('branches', BranchController::class);
    Route::resource('users', UserController::class);
    Route::resource('license-categories', LicenseCategoryController::class);
});

// Branch Manager routes
Route::middleware(['auth', 'role:branch_manager'])->prefix('branch')->name('branch.')->group(function () {
    Route::get('/dashboard', [BranchDashboard::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('lessons', LessonController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// Instructor routes
Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorDashboard::class, 'index'])->name('dashboard');
    Route::resource('lessons', InstructorLessonController::class);
});

// Student routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
    Route::get('/payments', [StudentPaymentController::class, 'index'])->name('payments');
});

// Profile routes (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';