<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'price',
        'educator_id',
        'level',
        'is_active'
    ];

    public function educator()
    {
        return $this->belongsTo(Educator::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
