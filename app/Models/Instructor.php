<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'user_id',
        'branch_id',
        'full_name',
        'phone',
        'id_number',
        'license_no',
        'license_classes',
        'date_of_birth',
        'address',
        'employment_date',
        'is_active',
    ];

    // An instructor belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // An instructor belongs to a user account
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An instructor has many lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    // Get all students assigned to this instructor
    public function students()
    {
        return $this->hasManyThrough(Student::class, Lesson::class, 'instructor_id', 'id', 'id', 'student_id');
    }
}
