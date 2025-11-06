<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\ManualData;

class User extends Authenticatable
{
    protected $fillable = [
        'role_id',
        'username',
        'email',
        'password',
        'name',
        'phone_number',
        'profile_pic',
        'status',
        'date_joined',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_joined' => 'date',
            'last_login' => 'datetime',
        ];
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class); 
    }

    public function manualDataInputs()
    {
        return $this->hasMany(ManualData::class, 'user_id_input', 'user_id');
    }
}