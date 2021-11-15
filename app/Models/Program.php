<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    public static $requiredFields = ['name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published'];

    protected $fillable = [
        'name', 'image', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published'
    ];

    protected $attributes = [];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'days' => 'integer',
        'use_warm_up' => 'boolean',
        'use_program_set' => 'boolean',
        'use_workout_set' => 'boolean',
        'published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }
}
