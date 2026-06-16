<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\TelegramSetting;
use App\Models\Transaction;
use App\Services\Telegram\TelegramService;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // \Log::info('TELEGRAM WEBHOOK', $request->all());
            $message = trim($request->input('message.text', ''));
    
            $chatId = $request->input('message.chat.id');
    
            $username = $request->input('message.from.username');
 
    
            if ( empty($message)|| empty($chatId)) {
                return response()->json([
                    'ok' => true,
                ]);
            }
    
            $this->syncTelegramUser($username,$chatId);
    
            $this->handleMessage($chatId, $username ,$message);
    
            return response()->json([
                'ok' => true,
            ]);
        } catch (\Throwable $e) {
            // \Log::error($e->getMessage());

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
  
    }

    private function syncTelegramUser(?string $username,string $chatId): void {
        if (!$username) {
            return;
        }
        TelegramSetting::query()
            ->where(
                'telegram_username',
                $username
            )
            ->update([
                'telegram_chat_id' => $chatId,
            ]);
    }

    private function handleMessage(string $chatId, string $username ,string $message): void {

        switch (true) {

            case $message === '/start':
                $this->start($chatId, $username );
                break;

            case $message === '/help':
                $this->help($chatId, $username );
                break;

            case $message === '/saldo':
                $this->saldo($chatId, $username );
                break;

            case $message === '/ringkasan':
                $this->ringkasan($chatId, $username );
                break;

            case $message === '/riwayat':
                $this->riwayat($chatId, $username );
                break;

            case $message === '/masuk':
                $this->masuk($chatId, $username );
                break;

            case $message === '/keluar':
                $this->keluar($chatId, $username);
                break;

            case preg_match('/^\+\d+/', $message):
                $this->saveIncome(
                    $chatId,
                    $message
                );
                break;

            case preg_match('/^-\d+/', $message):
                $this->saveExpense(
                    $chatId,
                    $message
                );
                break;

            default:
                $this->send(
                    $chatId,
                    "❌ Command tidak dikenali.\n
                    Ketik /help"
                );
        }
    }

    private function start(string $chatId, string $username): void {
    
        $this->send(
            $chatId,
            "👋 Welcome Finance Bot {$username}
            Commands:
            /help
            /saldo
            /ringkasan
            /riwayat
            /masuk
            /keluar
            Contoh:
            +100000 bca gaji
            -25000 bca kopi"
        );
    }

    private function help(string $chatId, string $username): void {

        $this->send(
            $chatId,
            "📚 Available Commands Untuk Kamu {$username}
            /star
            /help
            /saldo
            /ringkasan
            /riwayat
            /masuk
            /keluar"
        );
    }

    private function saldo(string $chatId,string $username): void {
        $income = Transaction::query()
            ->where('type', 'income')
            ->sum('amount');

        $expense = Transaction::query()
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $income - $expense;

        $this->send(
            $chatId,
            "💰 Current Balance Kamu {$username}
            Rp " . number_format(
                $balance,
                0,
                ',',
                '.'
            )
        );
    }

    private function ringkasan(string $chatId,string $username): void {

        $income = Transaction::query()
            ->where('type', 'income')
            ->whereDate(
                'transaction_date',
                today()
            )
            ->sum('amount');

        $expense = Transaction::query()
            ->where('type', 'expense')
            ->whereDate(
                'transaction_date',
                today()
            )
            ->sum('amount');

        $this->send(
            $chatId,
            "📊 Today Summary Kamu {$username}
            Income: Rp " . number_format(
                $income,
                0,
                ',',
                '.'
            ) . "
            Expense: Rp " . number_format(
                $expense,
                0,
                ',',
                '.'
            )
        );
    }

    private function riwayat(string $chatId,string $username): void {

        $transactions = Transaction::query()->latest()->take(5)->get();

        $message = "📝 Last Transactions Kamu {$username}\n\n";

        foreach ($transactions as $transaction) {

            $message .=
                ($transaction->type === 'income'
                    ? '+'
                    : '-') .

                number_format(
                    $transaction->amount,
                    0,
                    ',',
                    '.'
                ) .

                ' ' .

                $transaction->description .

                "\n";
        }

        $this->send(
            $chatId,
            $message
        );
    }

    private function masuk(string $chatId): void {

        $accounts = Account::query()
            ->pluck('name')
            ->implode("\n");

        $categories = Category::query()
            ->where('type', 'income')
            ->pluck('name')
            ->implode("\n");

        $this->send(
            $chatId,
            "📥 FORMAT INCOME
            +100000 bca gaji
            Accounts:
            {$accounts}
            Categories:
            {$categories}"
        );
    }

    private function keluar(string $chatId): void {

        $accounts = Account::query()
            ->pluck('name')
            ->implode("\n");

        $categories = Category::query()
            ->where('type', 'expense')
            ->pluck('name')
            ->implode("\n");

        $this->send(
            $chatId,
            "📤 FORMAT EXPENSE
            -25000 bca kopi
            Accounts:
            {$accounts}
            Categories:
            {$categories}"
        );
    }

    private function saveIncome(string $chatId,string $message): void {
        $this->saveTransaction(
            $chatId,
            $message,
            'income'
        );
    }

    private function saveExpense(string $chatId,string $message ): void {

        $this->saveTransaction(
            $chatId,
            $message,
            'expense'
        );
    }

    private function saveTransaction(string $chatId,string $message,string $type): void {

        preg_match(
            '/^[+-](\d+)\s+(\S+)\s+(.+)$/',
            $message,
            $matches
        );

        if (!isset($matches[3])) {

            $this->send(
                $chatId,
                '❌ Format salah'
            );

            return;
        }

        $amount = $matches[1];

        $accountName = $matches[2];

        $description = $matches[3];

        $account = Account::query()
            ->whereRaw(
                'LOWER(name)=?',
                [strtolower($accountName)]
            )
            ->first();

        if (!$account) {

            $this->send($chatId,"❌ Account {$accountName} tidak ditemukan");

            return;
        }

        Transaction::create([
            'account_id' => $account->id,
            'type' => $type,
            'amount' => $amount,
            'description' => $description,
            'transaction_date' => now(),
        ]);

        $this->send(
            $chatId,
            "✅ Transaction Saved
            Type: {$type}
            Account: {$account->name}
            Amount: Rp " .
            number_format(
                $amount,
                0,
                ',',
                '.'
            ) .

            "
            Description: {$description}"
        );
    }

    private function send(string $chatId,string $message): void {
        app(TelegramService::class)->send($chatId,$message);
    }
}