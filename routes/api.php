<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Публичные маршруты (без авторизации)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Статьи (публичный доступ)
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);

// Защищённые маршруты (требуют авторизации)
Route::middleware('auth:sanctum')->group(function () {
    // Аутентификация
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Статьи (управление)
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);
    
    // Комментарии
    Route::post('/articles/{article}/comments', [CommentController::class, 'store']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    
    // Модерация комментариев
    Route::get('/comments/moderation', [CommentController::class, 'moderation']);
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve']);
    Route::delete('/comments/{comment}/reject', [CommentController::class, 'reject']);
});