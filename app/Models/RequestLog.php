<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestLog extends Model
{
    use HasFactory;

    protected $table = 'request_log';
    protected $primaryKey = 'request_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sender_name',
        'request_type',
        'request_content',
        'status',
        'sent_time',
    ];

    protected $casts = [
        'sent_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}