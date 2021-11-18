<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Set extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prevable_type', 'prevable_id', 'name', 'day', 'set', 'rest_time', 'warm_up_set'
    ];

    public static $requiredFields = [
        'name', 'program_id'
    ];

    protected $attributes = [];

    protected $casts = [];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
