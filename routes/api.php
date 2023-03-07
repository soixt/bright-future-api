<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::domain('https://api.brightfuture.rs')->group(function () {
    // Auth routes

    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/signup/athlete', [AuthController::class, 'signupathlete']);
    Route::post('/auth/signup/recruiter', [AuthController::class, 'signuprecruiter']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/forgot-password', [AuthController::class, 'forgot']);
    Route::post('/auth/reset-password', [AuthController::class, 'reset']);
    Route::get('/auth/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/auth/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // Basic website routes

    Route::get('/sports', [WebsiteController::class, 'sports']);
    Route::get('/schools', [WebsiteController::class, 'schools']);
    Route::get('/configurations', [WebsiteController::class, 'configurations']);
    Route::post('/stop-emails', [WebsiteController::class, 'stop']);

    // Athlete routes

    Route::get('/athletes', [AthleteController::class, 'index']);
    Route::post('/athletes/favorite/{user:username}', [AthleteController::class, 'favorite']);
    Route::post('/athletes/unfavorite/{user:username}', [AthleteController::class, 'unfavorite']);
    Route::get('/athlete/{username}', [AthleteController::class, 'show']);

    Route::post('/new-video', [VideosController::class, 'store']);
    Route::post('/delete-video', [VideosController::class, 'destroy']);

    // Settings routes

    Route::post('/settings/account', [SettingsController::class, 'account']);
    Route::post('/settings/avatar', [SettingsController::class, 'avatar']);
    Route::post('/settings/general', [SettingsController::class, 'general']);
    Route::post('/settings/secretcode', [SettingsController::class, 'secretcode']);
    Route::post('/settings/present', [SettingsController::class, 'present']);

    Route::post('/message/new/{user:username}', [MessageController::class, 'send']);

});