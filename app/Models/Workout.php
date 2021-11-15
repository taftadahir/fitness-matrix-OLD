<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prevable_type', 'prevable_id', 'day', 'reps_based', 'reps', 'time_based', 'time', 'set', 'rest_time'
    ];

    public static $requiredFields = [
        'exercise_id', 'program_id'
    ];

    protected $attributes = [];

    protected $casts = [];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
