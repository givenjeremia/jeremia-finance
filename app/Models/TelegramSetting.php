<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramSetting extends Model
{
    protected $fillable = [
        'user_id',
        'bot_token',
        'chat_id',
        'is_enabled',
        'daily_summary',
        'monthly_summary',
        'budget_alert',
        'debt_reminder',
        'telegram_username',
        'telegram_chat_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
