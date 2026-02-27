<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AIAnalysisController;
use App\Http\Controllers\Api\VitalSignController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\NotificationController;

// مسارات عامة (لا تحتاج توكن)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// كل المسارات داخل هذه المجموعة محمية بالتوكن (Sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // إدارة المؤشرات الحيوية
    Route::post('/vitals', [VitalSignController::class, 'store']);
    Route::get('/vitals', [VitalSignController::class, 'index']);

    // تحليل الذكاء الاصطناعي
    Route::get('/ai-analysis', [AIAnalysisController::class, 'analyze']);

    // البروفايل والداتشبورد
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    
});

