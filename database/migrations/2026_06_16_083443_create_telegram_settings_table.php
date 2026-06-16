<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        
            $table->string('bot_token')->nullable();
        
            $table->string('chat_id')->nullable();
        
            $table->boolean('is_enabled')->default(false);
        
            $table->boolean('daily_summary')->default(false);
        
            $table->boolean('monthly_summary')->default(false);
        
            $table->boolean('budget_alert')->default(false);
        
            $table->boolean('debt_reminder')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_settings');
    }
};
