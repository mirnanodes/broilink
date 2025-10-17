<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmData extends Model
{
    use HasFactory;

    protected $table = 'farm_data';
    protected $primaryKey = 'data_id';
    public $timestamps = false; // Berdasarkan migrasi 2025_10_17_051509

    protected $fillable = [
        'farm_id',
        'user_id_input',
        'timestamp',
        'report_date',
        'temperature',
        'humidity',
        'ammonia',
        'konsumsi_pakan',
        'konsumsi_air',
        'jumlah_kematian',
        'data_source',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'report_date' => 'date',
        'temperature' => 'decimal:2',
        'humidity' => 'decimal:2',
        'ammonia' => 'decimal:2',
        'konsumsi_pakan' => 'decimal:2',
        'konsumsi_air' => 'decimal:2',
        'jumlah_kematian' => 'integer',
    ];

    // Relasi ke Farm
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class, 'farm_id', 'farm_id');
    }

    // Relasi ke User (Input Data)
    public function userInputUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_input', 'user_id');
    }
}