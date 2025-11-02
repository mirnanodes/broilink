<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Farm extends Model
{
    use HasFactory;

    protected $primaryKey = 'farm_id';
    public $timestamps = false; 

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
    
    // Relasi ke NotificationLog
    public function notifications(): HasMany
    {
        return $this->hasMany(NotificationLog::class, 'farm_id', 'farm_id');
    }
    
    // =========================================================
    // RELASI BARU UNTUK DATA DASHBOARD (IOT & MANUAL)
    // =========================================================

    // Relasi ke seluruh data sensor (IotData)
    public function iotData(): HasMany
    {
        return $this->hasMany(IotData::class, 'farm_id', 'farm_id');
    }
    
    /**
     * Relasi untuk mengambil SATU data IoT terbaru
     */
    public function latestIotData(): HasOne
    {
        return $this->hasOne(IotData::class, 'farm_id', 'farm_id')->latest('timestamp');
    }

    // Relasi ke seluruh data laporan manual (ManualData)
    public function manualData(): HasMany
    {
        return $this->hasMany(ManualData::class, 'farm_id', 'farm_id');
    }
}