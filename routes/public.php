<?php

use Illuminate\Support\Facades\Route;

/**
 * Routes - Home
 */

Route::get("/", WebController::class)->name("home");

