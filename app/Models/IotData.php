<?php
namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IotData extends Model
{
    use HasFactory;
    
    public $timestamps = false; 
    
    protected $fillable = [
        'farm_id',
        'timestamp',
        'temperature',
        'humidity',
        'ammonia',
        'data_source',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'temperature' => 'decimal:2',
        'humidity' => 'decimal:2',
        'ammonia' => 'decimal:2',
    ];
    
    // Relasi Many-to-One: Banyak IotData dimiliki oleh satu Farm
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class, 'farm_id', 'farm_id');
    }
}