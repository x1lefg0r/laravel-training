<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

// Главная страница через контроллер
Route::get('/', [MainController::class, 'index']);

// Страница "О нас"
Route::get('/about', function () {
    return view('about');
});

// Страница "Контакты" с передачей данных
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

// Страница галереи (отдельное изображение)
Route::get('/gallery/{index}', [MainController::class, 'gallery']);