<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvancedSearchController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'AdvancedSearchController index method is working',
            'controller' => 'App\Http\Controllers\AdvancedSearchController',
            'method' => 'index'
        ], 200);
    }
    
    public function suggestions()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'AdvancedSearchController suggestions method is working',
            'controller' => 'App\Http\Controllers\AdvancedSearchController',
            'method' => 'suggestions'
        ], 200);
    }
}
