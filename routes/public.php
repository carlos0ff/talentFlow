<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/** Controllers  */

/**
 *
 */
Route::get('/', function () {
     return Inertia::render('Welcome');
})->name('home');
