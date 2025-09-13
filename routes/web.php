<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AnswerReportController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {
    Route::resource('questions', QuestionController::class);
    Route::resource('answers', AnswerController::class);
    Route::resource('report-answers', AnswerReportController::class);

    Route::get('/candidates', [UserController::class, 'candidate'])->name('candidate.index');

});
