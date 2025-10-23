<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'farm_id',
        'user_id_input',
        'report_date',
        'konsumsi_pakan',
        'konsumsi_air',
        'jumlah_kematian',
    ];

    // Relasi Many-to-One: Banyak ManualData dimiliki oleh satu Farm
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
    
    // Relasi Many-to-One: Data diinput oleh satu User
    public function userInput()
    {
        return $this->belongsTo(User::class, 'user_id_input', 'user_id');
    }
}