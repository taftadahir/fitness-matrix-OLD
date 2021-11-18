<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'email', 'gender', 'avatar', 'password'];

    public static $requiredFields = ['email', 'password'];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'password' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'gender' => 'string',
        'avatar' => 'string',
    ];

    protected $cascadeDeletes = ['exercises', 'programs', 'userStats'];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function userStats()
    {
        return $this->hasMany(UserStat::class);
    }
}
