<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'time_based', 'reps_based', 'published', 'avatar'];

    protected $casts = [
        'name' => 'string',
        'avatar' => 'string',
        'time_based' => 'boolean',
        'reps_based' => 'boolean',
        'published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
