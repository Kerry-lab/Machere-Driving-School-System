<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'total_fee',
        'required_practical_hours',
        'required_theory_lessons',
        'is_active',
    ];

    // A license category has many students
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}