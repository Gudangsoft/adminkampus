<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'LanguageController index method is working',
            'controller' => 'App\Http\Controllers\Admin\LanguageController',
            'method' => 'index'
        ], 200);
    }
    
    public function create()
    {
        return response()->json([
            'status' => 'success', 
            'message' => 'LanguageController create method is working',
            'controller' => 'App\Http\Controllers\Admin\LanguageController',
            'method' => 'create'
        ], 200);
    }
    
    public function store(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'LanguageController store method is working',
            'controller' => 'App\Http\Controllers\Admin\LanguageController',
            'method' => 'store',
            'data' => $request->all()
        ], 200);
    }
    
    public function show($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'LanguageController show method is working',
            'controller' => 'App\Http\Controllers\Admin\LanguageController',
            'method' => 'show',
            'id' => $id
        ], 200);
    }
    
    public function edit($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'LanguageController edit method is working', 
            'controller' => 'App\Http\Controllers\Admin\LanguageController',
            'method' => 'edit',
            'id' => $id
        ], 200);
    }
    
    public function update(Request $request, $id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'LanguageController update method is working',
            'controller' => 'App\Http\Controllers\Admin\LanguageController',
            'method' => 'update',
            'id' => $id,
            'data' => $request->all()
        ], 200);
    }
    
    public function destroy($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'LanguageController destroy method is working',
            'controller' => 'App\Http\Controllers\Admin\LanguageController',
            'method' => 'destroy',
            'id' => $id
        ], 200);
    }
}