<?php

use App\Http\Controllers\Api\v1\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
