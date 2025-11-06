<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmConfig extends Model
{
    use HasFactory;

    protected $table = 'farm_config';
    protected $primaryKey = 'config_id';
    public $timestamps = false;

    protected $fillable = [
        'farm_id',
        'parameter_name',
        'value',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class, 'farm_id', 'farm_id');
    }
}