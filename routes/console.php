<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Ежедневная статистика
Schedule::command('statistics:send-daily')
    ->everyMinute(); // Для тестирования - каждую минуту
    // ->dailyAt('09:00'); // В продакшне - каждый день в 9:00