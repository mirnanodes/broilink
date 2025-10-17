<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farm extends Model
{
    use HasFactory;

    protected $primaryKey = 'farm_id';
    public $timestamps = false; // Berdasarkan migrasi 2025_10_17_051506

    protected $fillable = [
        'owner_id',
        'peternak_id',
        'farm_name',
        'location',
        'initial_population',
        'initial_weight',
        'farm_area',
    ];

    protected $casts = [
        'initial_population' => 'integer',
        'initial_weight' => 'decimal:2',
        'farm_area' => 'integer',
    ];

    // Relasi ke User (Owner)
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'user_id');
    }

    // Relasi ke User (Peternak)
    public function peternak(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peternak_id', 'user_id');
    }

    // Relasi ke FarmConfig
    public function config(): HasMany
    {
        return $this->hasMany(FarmConfig::class, 'farm_id', 'farm_id');
    }

    // Relasi ke FarmData
    public function data(): HasMany
    {
        return $this->hasMany(FarmData::class, 'farm_id', 'farm_id');
    }
    
    // Relasi ke NotificationLog
    public function notifications(): HasMany
    {
        return $this->hasMany(NotificationLog::class, 'farm_id', 'farm_id');
    }
}