<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'time_based', 'reps_based', 'published', 'avatar'];

    public static $requiredFields = ['name', 'time_based', 'reps_based', 'published'];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'time_based' => 'boolean',
        'reps_based' => 'boolean',
        'published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
