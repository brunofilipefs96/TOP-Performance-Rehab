<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FreeTrainingController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckGymSettings;
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


Route::middleware(['auth'])->group(function () {
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::view('unavailable', 'unavailable')->name('unavailable');
});


Route::middleware(['auth', CheckGymSettings::class, 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    Route::get('/entries/{entry}', [EntryController::class, 'show'])->name('entries.show');

    Route::post('/profile/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/profile/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/profile/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::post('/profile/insurance', [InsuranceController::class, 'store'])->name('insurance.store');
    Route::put('/profile/insurance/{insurance}', [InsuranceController::class, 'update'])->name('insurance.update');
    Route::delete('/profile/insurance/{insurance}', [InsuranceController::class, 'destroy'])->name('insurance.destroy');

    Route::get('/setup', [SetupController::class, 'setup'])->name('setup');
    Route::get('/setup/address', [SetupController::class, 'addressShow'])->name('setup.addressShow');
    Route::post('/setup/address/store', [SetupController::class, 'storeAddress'])->name('setup.address.store');
    Route::get('/setup/membership', [SetupController::class, 'membershipShow'])->name('setup.membershipShow');
    Route::get('/setup/training-types', [SetupController::class, 'trainingTypesShow'])->name('setup.trainingTypesShow');
    Route::post('/setup/training-types', [SetupController::class, 'storeTrainingTypes'])->name('setup.storeTrainingTypes');
    Route::put('/setup/training-types', [SetupController::class, 'updateTrainingTypes'])->name('setup.updateTrainingTypes');
    Route::get('/setup/insurance', [SetupController::class, 'insuranceShow'])->name('setup.insuranceShow');
    Route::get('/setup/awaiting', [SetupController::class, 'awaitingShow'])->name('setup.awaitingShow');
    Route::get('/setup/payment', [SetupController::class, 'paymentShow'])->name('setup.paymentShow');
    Route::post('/setup/process', [SetupController::class, 'processSetup'])->name('setup.process');


    // Rotas para TrainingController
    Route::get('trainings', [TrainingController::class, 'index'])->name('trainings.index');
    Route::get('trainings/create', [TrainingController::class, 'create'])->name('trainings.create');
    Route::post('trainings', [TrainingController::class, 'store'])->name('trainings.store');
    Route::get('trainings/{training}', [TrainingController::class, 'show'])->name('trainings.show');
    Route::get('trainings/{training}/edit', [TrainingController::class, 'edit'])->name('trainings.edit');
    Route::put('trainings/{training}', [TrainingController::class, 'update'])->name('trainings.update');
    Route::delete('trainings/{training}', [TrainingController::class, 'destroy'])->name('trainings.destroy');
    Route::post('trainings/{training}/enroll', [TrainingController::class, 'enroll'])->name('trainings.enroll');
    Route::post('trainings/{training}/cancel', [TrainingController::class, 'cancel'])->name('trainings.cancel');
    Route::post('trainings/{training}/mark-presence', [TrainingController::class, 'markPresence'])->name('trainings.markPresence');
    Route::delete('trainings/multiDelete', [TrainingController::class, 'multiDelete'])->name('trainings.multiDelete');

    // Rotas para FreeTrainingController
    Route::get('free-trainings', [FreeTrainingController::class, 'index'])->name('free_trainings.index');
    Route::post('free-trainings/{freeTraining}/enroll', [FreeTrainingController::class, 'enroll'])->name('free_trainings.enroll');
    Route::post('free-trainings/{freeTraining}/cancel', [FreeTrainingController::class, 'cancel'])->name('free_trainings.cancel');
    Route::post('/dashboard/change-week', [DashboardController::class, 'changeWeek'])->name('dashboard.changeWeek');

    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add-product', [CartController::class, 'addProductToCart'])->name('cart.addProduct');
    Route::post('cart/add-pack', [CartController::class, 'addPackToCart'])->name('cart.addPack');
    Route::patch('cart/increase-product/{id}', [CartController::class, 'increaseProductQuantity'])->name('cart.increaseProduct');
    Route::patch('cart/decrease-product/{id}', [CartController::class, 'decreaseProductQuantity'])->name('cart.decreaseProduct');
    Route::delete('cart/remove-product/{id}', [CartController::class, 'removeProductFromCart'])->name('cart.removeProduct');
    Route::delete('cart/remove-pack/{id}', [CartController::class, 'removePackFromCart'])->name('cart.removePack');
    Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');

    Route::resource('/sales', SaleController::class)->only(['index', 'show']);
    Route::get('/sales/{sale}/payment-reference', [SaleController::class, 'showPaymentReference'])->name('sales.showPaymentReference');

    Route::get('/faq', function () {
        return view('pages.faq.index');
    })->name('faq.index');

    Route::get('/calendar', [DashboardController::class, 'showCalendar'])->name('calendar');
});

Route::post('/webhook/stripe', [SaleController::class, 'handleWebhook'])->name('webhook.stripe');


require __DIR__.'/auth.php';





