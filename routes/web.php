<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    else{
        return view('welcome');
    }
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


    Route::resource('/products', ProductController::class);
    Route::resource('/rooms', RoomController::class);
    Route::resource('/training-types', TrainingTypeController::class);
    Route::resource('/packs', PackController::class);
    Route::resource('/insurances', InsuranceController::class);
    Route::resource('/services', ServiceController::class);
    Route::resource('/memberships', MembershipController::class);

    Route::get('/entries/{survey}/fill', [EntryController::class, 'fill'])->name('entries.fill');
    Route::post('/entries/{survey}', [EntryController::class, 'store'])->name('entries.store');
    Route::get('/entries/{survey}', [EntryController::class, 'show'])->name('entries.show');

    Route::post('/profile/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/profile/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/profile/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::post('/profile/insurance', [InsuranceController::class, 'store'])->name('insurance.store');
    Route::put('/profile/insurance/{insurance}', [InsuranceController::class, 'update'])->name('insurance.update');
    Route::delete('/profile/insurance/{insurance}', [InsuranceController::class, 'destroy'])->name('insurance.destroy');

    Route::post('trainings/{training}/enroll', [TrainingController::class, 'enroll'])->name('trainings.enroll');
    Route::post('trainings/{training}/cancel', [TrainingController::class, 'cancel'])->name('trainings.cancel');
    Route::delete('/trainings/multiDelete', [TrainingController::class, 'multiDelete'])->name('trainings.multiDelete');
    Route::resource('trainings', TrainingController::class);

    Route::post('/dashboard/change-week', [DashboardController::class, 'changeWeek'])->name('dashboard.changeWeek');

    Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [ProductController::class, 'cart'])->name('cart.index');
    Route::delete('cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

    Route::patch('cart/increase/{id}', [ProductController::class, 'increaseQuantity'])->name('cart.increase');
    Route::patch('cart/decrease/{id}', [ProductController::class, 'decreaseQuantity'])->name('cart.decrease');


});


require __DIR__.'/auth.php';





