<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CvsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;

// Route to get the authenticated user's information, protected by Sanctum middleware
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API resource routes for JobOfferController
Route::apiResource('offers', JobOfferController::class);

// Route to register a new user
Route::post('/register', [AuthController::class, 'register']);

// Route to login a user
Route::post('/login', [AuthController::class, 'login']);

// Group of routes protected by the custom AuthMiddleware
Route::middleware(['auth:api'])->group(function () {
    // Route to get the authenticated user's information
    Route::get('user', [AuthController::class, 'getUser']);
    // Route to logout the authenticated user
    Route::post('logout', [AuthController::class, 'logout']);
    // Route to update the authenticated user's profile
    Route::put('updateprofile', [AuthController::class, 'updateProfile']);
 // Route to apply to a job offer with an existing CV
 Route::post('/apply', [ApplicationController::class, 'apply']);
 // Route to apply to multiple job offers with an existing CV
 Route::post('/apply-multiple', [ApplicationController::class, 'applyToMultipleOffers']);
    // Route to upload a CV
    Route::post('/upload-cv', [CvsController::class, 'upload']);
});
