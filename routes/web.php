<?php

use App\Http\Controllers\AdminCalendarController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/admin/calendar/dates', [AdminCalendarController::class, 'getDates'])->name('calendar.dates');
    Route::post('/admin/calendar/save', [AdminCalendarController::class, 'saveDates'])->name('calendar.save');
});

