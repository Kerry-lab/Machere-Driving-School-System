<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'student_id',
        'instructor_id',
        'branch_id',
        'lesson_type',
        'lesson_date',
        'start_time',
        'end_time',
        'hours_logged',
        'status',
        'notes',
    ];

    // A lesson belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // A lesson belongs to an instructor
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    // A lesson belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}