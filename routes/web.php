<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\GameMatchController;
use App\Http\Controllers\InjuryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sports
    Route::resource('sports', SportController::class);

    // Teams
    Route::resource('teams', TeamController::class);

    // Players
    Route::resource('players', PlayerController::class);

    // Trainings
    Route::resource('trainings', TrainingController::class);
    Route::post('/trainings/{training}/attendance', [TrainingController::class, 'updateAttendance'])
        ->name('trainings.attendance');

    // Matches (using GameMatch model)
    Route::resource('matches', GameMatchController::class);

    // Injuries
    Route::resource('injuries', InjuryController::class);
});

require __DIR__ . '/auth.php';
