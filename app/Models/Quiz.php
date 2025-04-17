<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'time_limit',
        'passing_score',
        'is_active'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
