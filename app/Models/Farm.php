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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'user_id');
    }

    public function peternak(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peternak_id', 'user_id');
    }

    public function config(): HasMany
    {
        return $this->hasMany(FarmConfig::class, 'farm_id', 'farm_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(NotificationLog::class, 'farm_id', 'farm_id');
    }

    public function latestIotData(): HasOne
    {
        return $this->hasOne(IotData::class, 'farm_id', 'farm_id')->latest('timestamp');
    }

    public function manualData(): HasMany
    {
        return $this->hasMany(ManualData::class, 'farm_id', 'farm_id');
    }
}
