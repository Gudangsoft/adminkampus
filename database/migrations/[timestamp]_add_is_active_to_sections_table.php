<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->boolean('is_active')->default(1);
        });
        
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        
        Schema::dropIfExists('settings');
    }
};


Route::prefix('admin')->name('admin.')->group(function () {
    // ...existing admin routes...
    
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
    
    // Or if you have a SettingsController:
    // Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
});
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Settings</h1>
    <!-- Your settings content here -->
</div>
@endsection