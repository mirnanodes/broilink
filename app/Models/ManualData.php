<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManualData extends Model
{
    use HasFactory;

    protected $table = 'manual_data';
    protected $primaryKey = 'manual_data_id';
    public $timestamps = false;

    protected $fillable = [
        'farm_id',
        'user_id_input',
        'report_date',
        'konsumsi_pakan',
        'konsumsi_air',
        'jumlah_kematian',
    ];

    protected $casts = [
        'report_date' => 'date',
        'konsumsi_pakan' => 'decimal:2',
        'konsumsi_air' => 'decimal:2',
        'jumlah_kematian' => 'integer',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class, 'farm_id', 'farm_id');
    }

    public function userInput(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_input', 'user_id');
    }
}
