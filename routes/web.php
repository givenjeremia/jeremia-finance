<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramWebhookController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post( '/telegram/webhook', TelegramWebhookController::class);

Route::get('/test-token', function () {
    return config('services.telegram.token');
});