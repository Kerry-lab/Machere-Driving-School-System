<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'branch_id',
        'receipt_number',
        'amount',
        'payment_method',
        'mpesa_code',
        'balance_before',
        'balance_after',
        'payment_date',
        'status',
        'recorded_by',
        'notes',
    ];

    // A payment belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // A payment belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // A payment was recorded by a user
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Generate a unique receipt number
    public static function generateReceiptNumber()
    {
        $prefix = 'MDS';
        $date = now()->format('Ymd');
        $last = self::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}