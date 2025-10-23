<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IotData extends Model
{
    use HasFactory;
    
    // Matikan timestamps karena tabel ini hanya untuk data sensor
    public $timestamps = false;
    
    protected $fillable = [
        'farm_id',
        'timestamp',
        'temperature',
        'humidity',
        'ammonia',
        'data_source',
    ];
    
    // Relasi Many-to-One: Banyak IotData dimiliki oleh satu Farm
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}