<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'student_id',
        'phone_number',
        'message',
        'type',
        'status',
        'sms_reference',
        'sent_at',
    ];

    // A notification belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}