<?php

namespace App\Services\Telegram;
use Illuminate\Support\Facades\Http;


class TelegramService
{
    public function send(string $chatId,string $message): bool {

        return Http::post(
            'https://api.telegram.org/bot' .
            config('services.telegram.token') .
            '/sendMessage',
            [
                'chat_id' => $chatId,
                'text' => $message,
            ]
        )->successful();
    }
}