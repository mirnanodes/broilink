<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    
    public $timestamps = true; 

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class, 'farm_id', 'farm_id');
    }
    
    public function userInput(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_input', 'user_id');
    }
}