<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'branch_name',
        'location',
        'phone',
        'email',
        'manager_name',
        'is_active',
    ];

    // A branch has many students
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // A branch has many instructors
    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }

    // A branch has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // A branch has many lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
