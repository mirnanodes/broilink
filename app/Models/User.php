<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\ManualData;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // --- PROPERTY UTAMA ---
    // Sesuai migrasi Anda
    protected $primaryKey = 'user_id'; 
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Kolom yang dapat diisi massal.
     * Menggabungkan kolom wajib dari migrasi lama dan FK baru 'role_id'.
     */
    protected $fillable = [
        'role_id', // FK baru
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

    /**
     * Kolom yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting untuk tipe data.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_joined' => 'date',
            'last_login' => 'datetime',
        ];
    }
    
    // --- RELASI BARU ---

    /**
     * Relasi Many-to-One: User memiliki satu Role
     */
    public function role()
    {
        // Menunjuk ke role_id di tabel users
        return $this->belongsTo(Role::class); 
    }

    /**
     * Relasi One-to-Many: User menginput banyak Manual Data
     */
    public function manualDataInputs()
    {
        // Foreign Key di manual_data adalah 'user_id_input', PK di users adalah 'user_id'
        return $this->hasMany(ManualData::class, 'user_id_input', 'user_id');
    }
}