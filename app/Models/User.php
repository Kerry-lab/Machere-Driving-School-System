<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Check user roles
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isBranchManager()
    {
        return $this->role === 'branch_manager';
    }

    public function isInstructor()
    {
        return $this->role === 'instructor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    // A user can be a student
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // A user can be an instructor
    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }
}