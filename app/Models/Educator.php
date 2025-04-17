<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Educator extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'qualification',
        'bio',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
