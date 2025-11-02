<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManualData extends Model
{
    use HasFactory;
    
    // Migrasi 2025_10_23_155101_create_manual_data_table.php menunjukkan penggunaan $table->id();
    
    protected $fillable = [
        'farm_id',
        'user_id_input',
        'report_date',
        'konsumsi_pakan',
        'konsumsi_air',
        'jumlah_kematian',
    ];
    
    // Tambahkan timestamps jika migrasi menggunakannya (2025_10_23_155101_create_manual_data_table.php ada timestamps)
    public $timestamps = true; 

    // Relasi Many-to-One: Banyak ManualData dimiliki oleh satu Farm
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class, 'farm_id', 'farm_id');
    }
    
    // Relasi Many-to-One: Data diinput oleh satu User
    public function userInput(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_input', 'user_id');
    }
}