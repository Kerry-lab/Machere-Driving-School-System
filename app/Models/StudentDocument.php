<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    protected $fillable = [
        'student_id',
        'document_type',
        'file_path',
        'file_name',
        'status',
        'verified_by',
        'verified_at',
        'notes',
    ];

    // A document belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // A document was verified by a user
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}