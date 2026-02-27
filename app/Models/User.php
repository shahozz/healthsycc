<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'chronic_conditions',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'chronic_conditions' => 'array', 
    ];

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }

    public function aiAnalyses()
    {
        return $this->hasMany(AIAnalysis::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}