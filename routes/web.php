<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => 200,
        'message' => 'Application loaded successfully !'
    ], 200);
});
