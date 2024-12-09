<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Đừng quên import AuthController

// Route cho đăng ký
Route::post('/register', [AuthController::class, 'register']);

// Route cho đăng nhập
Route::post('/login', [AuthController::class, 'login']);

// Route để lấy thông tin người dùng đang đăng nhập
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');