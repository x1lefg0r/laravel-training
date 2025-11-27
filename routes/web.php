<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contacts', function () {
    $contacts = [
        [
            'title' => 'Телефон',
            'value' => '+7 (888) 000-67-45'
        ],
        [
            'title' => 'Email',
            'value' => 'x1lefg0r@example.com'
        ],
        [
            'title' => 'Адрес',
            'value' => 'г. Владимир, ул. Парадная, д. 404'
        ],
        [
            'title' => 'Telegram',
            'value' => '@canyouhearsilence'
        ]
    ];
    
    return view('contacts', ['contacts' => $contacts]);
});