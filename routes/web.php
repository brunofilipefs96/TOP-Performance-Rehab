<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionTypeController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/users', UserController::class)->only(['index', 'show', 'destroy']);
    Route::get('/users/{user}/membership/create', [MembershipController::class, 'create'])->name('users.memberships.create');
    Route::post('/users/{user}/membership', [MembershipController::class, 'store'])->name('users.memberships.store');
    Route::resource('/memberships', MembershipController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

    Route::resource('/products', ProductController::class);
    Route::resource('/rooms', RoomController::class);
    Route::resource('/training-types', TrainingTypeController::class);
    Route::resource('/packs', PackController::class);
    Route::resource('/insurances', InsuranceController::class);
    Route::resource('/questionnaires', QuestionnaireController::class);
    Route::resource('/question-types', QuestionTypeController::class);
    Route::resource('/questions', QuestionController::class);
    Route::resource('/responses', ResponseController::class);
});


require __DIR__.'/auth.php';





