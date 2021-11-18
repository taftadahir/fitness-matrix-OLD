<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['reps', 'set', 'time'];

    public static $requiredFields = [
        'user_id', 'workout_id'
    ];

    protected $attributes = [];

    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
