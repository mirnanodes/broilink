<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // --- Penyesuaian Berdasarkan Migrasi (2025_10_17_051503) ---

    // Menggunakan 'user_id' sebagai Primary Key
    protected $primaryKey = 'user_id';

    // Menonaktifkan timestamps karena tidak ada kolom created_at/updated_at di migrasi
    public $timestamps = false;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
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
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Mendapatkan atribut yang harus di-cast ke tipe data tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_joined' => 'date',
            'last_login' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // --- Relasi ---

    public function ownedFarms(): HasMany
    {
        // Relasi untuk farm yang dimiliki (owner_id)
        return $this->hasMany(Farm::class, 'owner_id', 'user_id');
    }

    public function workingFarms(): HasMany
    {
        // Relasi untuk farm di mana user ini adalah peternak (peternak_id)
        return $this->hasMany(Farm::class, 'peternak_id', 'user_id');
    }

    public function farmDataInputs(): HasMany
    {
        // Relasi untuk data farm yang diinput oleh user ini
        return $this->hasMany(FarmData::class, 'user_id_input', 'user_id');
    }
}