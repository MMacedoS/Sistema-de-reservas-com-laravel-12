<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function (Request $request) {
    return response()->json(['status' => 'API is running']);
});

Route::prefix('v1')->group(function () {
    require __DIR__ . '/v1/user/userRoute.php';
});
