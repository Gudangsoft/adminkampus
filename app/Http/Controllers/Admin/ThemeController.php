<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'ThemeController index method is working',
            'controller' => 'App\Http\Controllers\Admin\ThemeController',
            'method' => 'index'
        ], 200);
    }
    
    public function create()
    {
        return response()->json([
            'status' => 'success', 
            'message' => 'ThemeController create method is working',
            'controller' => 'App\Http\Controllers\Admin\ThemeController',
            'method' => 'create'
        ], 200);
    }
    
    public function store(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'ThemeController store method is working',
            'controller' => 'App\Http\Controllers\Admin\ThemeController',
            'method' => 'store',
            'data' => $request->all()
        ], 200);
    }
    
    public function show($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'ThemeController show method is working',
            'controller' => 'App\Http\Controllers\Admin\ThemeController',
            'method' => 'show',
            'id' => $id
        ], 200);
    }
    
    public function edit($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'ThemeController edit method is working', 
            'controller' => 'App\Http\Controllers\Admin\ThemeController',
            'method' => 'edit',
            'id' => $id
        ], 200);
    }
    
    public function update(Request $request, $id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'ThemeController update method is working',
            'controller' => 'App\Http\Controllers\Admin\ThemeController',
            'method' => 'update',
            'id' => $id,
            'data' => $request->all()
        ], 200);
    }
    
    public function destroy($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'ThemeController destroy method is working',
            'controller' => 'App\Http\Controllers\Admin\ThemeController',
            'method' => 'destroy',
            'id' => $id
        ], 200);
    }
}
