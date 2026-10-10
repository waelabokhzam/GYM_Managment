<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\Attendance\AttendanceService;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    app(AttendanceService::class)->autoCloseExpiredAttendances();
})
    ->name('attendance-auto-close')
    ->everyMinute()
    ->withoutOverlapping();

Schedule::command('subscriptions:notify-expiring')
    ->everyMinute()
    ->withoutOverlapping();