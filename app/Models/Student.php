<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'dob',
        'email',
        'phone',
        'course',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * Get the courses enrolled by the student.
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'student_courses', 'student_id', 'course_id')
            ->withTimestamps()
            ->withPivot('status', 'progress');
    }
    
    /**
     * Get the quizzes attempted by the student.
     */
    public function quizAttempts()
    {
        return $this->belongsToMany(Quiz::class, 'student_quizzes', 'student_id', 'quiz_id')
            ->withTimestamps()
            ->withPivot('score', 'status', 'attempt_count');
    }
} 