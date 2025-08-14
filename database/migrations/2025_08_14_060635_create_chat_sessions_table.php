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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('user_ip', 45);
            $table->string('user_agent')->nullable();
            $table->json('messages'); // Store chat history
            $table->enum('status', ['active', 'closed', 'transferred'])->default('active');
            $table->timestamp('last_activity');
            $table->timestamps();
            
            $table->index(['session_id', 'status']);
            $table->index(['user_ip', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
    }
};
