<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlaylistController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/playlists', [PlaylistController::class, 'index'])
    ->middleware(\App\Http\Middleware\VerifyApiKey::class);
