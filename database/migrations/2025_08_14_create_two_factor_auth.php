<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('two_factor_enabled')->default(false)->after('is_active');
            $table->string('two_factor_secret')->nullable()->after('two_factor_enabled');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
        });

        Schema::create('user_login_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->string('user_agent');
            $table->enum('result', ['success', 'failed', 'blocked']);
            $table->enum('reason', ['invalid_credentials', 'two_factor_required', 'two_factor_failed', 'account_locked'])->nullable();
            $table->timestamp('attempted_at');
            $table->timestamps();
            
            $table->index(['user_id', 'attempted_at']);
            $table->index(['ip_address', 'attempted_at']);
        });

        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('session_id');
            $table->string('ip_address', 45);
            $table->string('user_agent');
            $table->timestamp('last_activity');
            $table->timestamps();
            
            $table->index(['user_id', 'session_id']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_enabled',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at'
            ]);
        });
        
        Schema::dropIfExists('user_login_attempts');
        Schema::dropIfExists('user_sessions');
    }
};
