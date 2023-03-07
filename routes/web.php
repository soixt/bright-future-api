<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return redirect()->away(config('app.api_url'));
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
