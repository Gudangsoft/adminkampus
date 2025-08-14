<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Global Search API
Route::get('/search', [GlobalSearchController::class, 'search']);
Route::get('/search/suggestions', [GlobalSearchController::class, 'suggestions']);

// Chatbot API
Route::prefix('chat')->group(function () {
    Route::post('/message', [ChatbotController::class, 'sendMessage']);
    Route::get('/session/{sessionId}', [ChatbotController::class, 'getSession']);
    Route::delete('/session/{sessionId}', [ChatbotController::class, 'clearSession']);
});

// FAQ API
Route::prefix('faqs')->group(function () {
    Route::get('/', function (Request $request) {
        $query = $request->get('search');
        $category = $request->get('category');
        
        $faqs = \App\Models\FAQ::active();
        
        if ($query) {
            $faqs = $faqs->search($query);
        }
        
        if ($category) {
            $faqs = $faqs->byCategory($category);
        }
        
        $faqs = $faqs->ordered()->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $faqs,
            'categories' => \App\Models\FAQ::distinct('category')->pluck('category')
        ]);
    });
    
    Route::get('/{id}', function ($id) {
        $faq = \App\Models\FAQ::findOrFail($id);
        $faq->incrementViews();
        
        return response()->json([
            'status' => 'success',
            'data' => $faq
        ]);
    });
    
    Route::get('/popular/list', function () {
        $faqs = \App\Models\FAQ::popular()->limit(10)->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $faqs
        ]);
    });
});
