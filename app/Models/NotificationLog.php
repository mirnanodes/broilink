<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notification_log';
    protected $primaryKey = 'notif_id';
    public $timestamps = false;

    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'farm_id',
        'notification_type',
        'message_content',
        'sent_at',
        'status',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id', 'user_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_user_id', 'user_id');
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class, 'farm_id', 'farm_id');
    }
}