<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', 'AuthController@login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
		'status' => 200,
		'is_authorized' => true,
		'user' => $request->user()
	], 200);
});
