<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

Route::get('/', [MainController::class, 'index']);

Route::get('/about', function () {
    return view('about');
});

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

Route::get('/gallery/{index}', [MainController::class, 'gallery']);

Route::get('/signin', [AuthController::class, 'create'])->name('signin');
Route::post('/signin', [AuthController::class, 'registration'])->name('registration');