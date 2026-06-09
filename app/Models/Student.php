<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'branch_id',
        'license_category_id',
        'full_name',
        'phone',
        'id_number',
        'student_number',
        'date_of_birth',
        'gender',
        'address',
        'emergency_contact',
        'agreed_total_fee',
        'amount_paid',
        'outstanding_balance',
        'status',
        'ntsa_clearance',
        'enrollment_date',
    ];

    // A student belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // A student belongs to a license category
    public function licenseCategory()
    {
        return $this->belongsTo(LicenseCategory::class);
    }

    // A student belongs to a user account
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A student has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // A student has many lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    // A student has many documents
    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }

    // A student has many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Calculate if student is eligible for NTSA exam
    public function isNtsaEligible()
    {
        $hoursCompleted = $this->lessons()
            ->where('status', 'completed')
            ->where('lesson_type', 'practical')
            ->sum('hours_logged');

        $theoryCompleted = $this->lessons()
            ->where('status', 'completed')
            ->where('lesson_type', 'theory')
            ->count();

        return $this->outstanding_balance == 0
            && $hoursCompleted >= $this->licenseCategory->required_practical_hours
            && $theoryCompleted >= $this->licenseCategory->required_theory_lessons;
    }
}
