<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

// Главная страница
Route::get('/', [MainController::class, 'index']);

// Страница "О нас"
Route::get('/about', function () {
    return view('about');
});

// Страница "Контакты"
Route::get('/contacts', function () {
    $contacts = [
        [
            'title' => 'Телефон',
            'value' => '+7 (999) 123-45-67'
        ],
        [
            'title' => 'Email',
            'value' => 'info@example.com'
        ],
        [
            'title' => 'Адрес',
            'value' => 'г. Москва, ул. Примерная, д. 123'
        ],
        [
            'title' => 'Telegram',
            'value' => '@example_company'
        ]
    ];
    
    return view('contacts', ['contacts' => $contacts]);
});

// Галерея
Route::get('/gallery/{index}', [MainController::class, 'gallery']);

// ===== Авторизация и регистрация (доступны всем) =====
Route::get('/register', [AuthController::class, 'createRegister'])->name('register.create');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ===== Новости (только чтение для всех) =====
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
});
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// ===== Защищённые маршруты (только для авторизованных) =====
Route::middleware('auth:sanctum')->group(function () {
    // Управление статьями
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    
    // Управление комментариями
    Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Модерация комментариев (только для модераторов)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/comments/moderation', [CommentController::class, 'moderation'])->name('comments.moderation');
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
});

// Модерация комментариев (только для модераторов)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/comments/moderation', [CommentController::class, 'moderation'])->name('comments.moderation');
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
});

// Просмотр статьи с логированием
Route::get('/articles/{article}', [ArticleController::class, 'show'])
    ->name('articles.show')
    ->middleware('log.page.view');