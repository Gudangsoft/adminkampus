<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SEOController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'SEOController index method is working',
            'controller' => 'App\Http\Controllers\Admin\SEOController',
            'method' => 'index'
        ], 200);
    }
    
    public function create()
    {
        return response()->json([
            'status' => 'success', 
            'message' => 'SEOController create method is working',
            'controller' => 'App\Http\Controllers\Admin\SEOController',
            'method' => 'create'
        ], 200);
    }
    
    public function store(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'SEOController store method is working',
            'controller' => 'App\Http\Controllers\Admin\SEOController',
            'method' => 'store',
            'data' => $request->all()
        ], 200);
    }
    
    public function show($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'SEOController show method is working',
            'controller' => 'App\Http\Controllers\Admin\SEOController',
            'method' => 'show',
            'id' => $id
        ], 200);
    }
    
    public function edit($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'SEOController edit method is working', 
            'controller' => 'App\Http\Controllers\Admin\SEOController',
            'method' => 'edit',
            'id' => $id
        ], 200);
    }
    
    public function update(Request $request, $id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'SEOController update method is working',
            'controller' => 'App\Http\Controllers\Admin\SEOController',
            'method' => 'update',
            'id' => $id,
            'data' => $request->all()
        ], 200);
    }
    
    public function destroy($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'SEOController destroy method is working',
            'controller' => 'App\Http\Controllers\Admin\SEOController',
            'method' => 'destroy',
            'id' => $id
        ], 200);
    }
}
