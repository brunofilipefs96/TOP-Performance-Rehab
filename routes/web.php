<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FreeTrainingController;
use App\Http\Controllers\GymClosureController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RenewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckGymSettings;
use App\Http\Middleware\CheckUserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

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
    Route::get('/settings/closures', [GymClosureController::class, 'index'])->name('settings.closures');
    Route::post('/settings/closures/update', [GymClosureController::class, 'update'])->name('settings.closures.update');
    Route::view('unavailable', 'unavailable')->name('unavailable');
    Route::view('/no-roles', 'no-roles')->name('no-roles');
});


Route::middleware(['auth', CheckGymSettings::class, 'verified', CheckUserRole::class])->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');


    Route::patch('/users/{user}/client-type', [UserController::class, 'updateClientType'])->name('user.client-type.update');
    Route::post('/users/{user}/roles', [UserController::class, 'storeRole'])->name('user.roles.store');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'destroyRole'])->name('user.roles.destroy');
    Route::get('/change-role', [RoleController::class, 'changeRole'])->name('change-role');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::delete('/profile/remove-image', [ProfileController::class, 'removeImage'])->name('profile.removeImage');
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

    Route::post('insurances/{insurance}/documents', [InsuranceController::class, 'addDocument'])->name('insurances.addDocument');
    Route::delete('insurances/{insurance}/documents/{document}', [InsuranceController::class, 'deleteDocument'])->name('insurances.deleteDocument');
    Route::post('/profile/insurance', [InsuranceController::class, 'store'])->name('insurance.store');
    Route::put('/profile/insurance/{insurance}', [InsuranceController::class, 'update'])->name('insurance.update');
    Route::delete('/profile/insurance/{insurance}', [InsuranceController::class, 'destroy'])->name('insurance.destroy');

    Route::post('memberships/{membership}/documents', [MembershipController::class, 'addDocument'])->name('memberships.addDocument');
    Route::delete('memberships/{membership}/documents/{document}', [MembershipController::class, 'deleteDocument'])->name('memberships.deleteDocument');
    Route::get('/memberships/{membership}/evaluations/create', [EvaluationController::class, 'create'])->name('memberships.evaluations.create');
    Route::post('/memberships/{membership}/evaluations', [EvaluationController::class, 'store'])->name('memberships.evaluations.store');
    Route::get('/memberships/{membership}/evaluations/{evaluation}', [EvaluationController::class, 'show'])->name('memberships.evaluations.show');
    Route::delete('/memberships/{membership}/evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('memberships.evaluations.destroy');
    Route::get('/memberships/{membership}/evaluations', [EvaluationController::class, 'listForMembership'])->name('memberships.evaluations.list');

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

    Route::get('/renew', [RenewController::class, 'renew'])->name('renew');
    Route::get('/renew/renewMembership', [RenewController::class, 'renewMembership'])->name('renew.renewMembership');
    Route::get('/renew/renewInsurance', [RenewController::class, 'renewInsurance'])->name('renew.renewInsurance');
    Route::get('/renew/renewAwaiting', [RenewController::class, 'renewAwaiting'])->name('renew.renewAwaiting');
    Route::get('/renew/renewPayment', [RenewController::class, 'renewPayment'])->name('renew.renewPayment');
    Route::post('/renew/processRenew', [RenewController::class, 'processRenew'])->name('renew.processRenew');
    Route::post('/renew/renewMembership/{membership}', [RenewController::class, 'updateMembership'])->name('renew.updateMembership');
    Route::post('/renew/updateInsurance/{insurance}', [RenewController::class, 'updateInsurance'])->name('renew.updateInsurance');


    Route::get('trainings/multi-delete', [TrainingController::class, 'showMultiDelete'])->name('trainings.showMultiDelete');
    Route::delete('trainings/multi-delete', [TrainingController::class, 'multiDelete'])->name('trainings.multiDelete');

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

    Route::get('free-trainings/multi-delete', [FreeTrainingController::class, 'showMultiDelete'])->name('free-trainings.showMultiDelete');
    Route::delete('free-trainings/multi-delete', [FreeTrainingController::class, 'multiDelete'])->name('free-trainings.multiDelete');
    Route::post('/dashboard/change-week', [DashboardController::class, 'changeWeek'])->name('dashboard.changeWeek');
    Route::post('/free-trainings/change-week', [FreeTrainingController::class, 'changeWeek'])->name('free-trainings.changeWeek');
    Route::get('/free-trainings/select-day/{day}', [FreeTrainingController::class, 'selectDay'])->name('free-trainings.selectDay');
    Route::resource('free-trainings', FreeTrainingController::class)->except(['edit', 'update']);
    Route::post('free-trainings/{freeTraining}/enroll', [FreeTrainingController::class, 'enroll'])->name('free-trainings.enroll');
    Route::post('free-trainings/{freeTraining}/cancel', [FreeTrainingController::class, 'cancel'])->name('free-trainings.cancel');
    Route::post('free-trainings/{freeTraining}/mark-presence', [FreeTrainingController::class, 'markPresence'])->name('free-trainings.markPresence');


    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add-product', [CartController::class, 'addProductToCart'])->name('cart.addProduct');
    Route::post('cart/add-pack', [CartController::class, 'addPackToCart'])->name('cart.addPack');
    Route::patch('cart/increase-product/{id}', [CartController::class, 'increaseProductQuantity'])->name('cart.increaseProduct');
    Route::patch('cart/decrease-product/{id}', [CartController::class, 'decreaseProductQuantity'])->name('cart.decreaseProduct');
    Route::delete('cart/remove-product/{id}', [CartController::class, 'removeProductFromCart'])->name('cart.removeProduct');
    Route::delete('cart/remove-pack/{id}', [CartController::class, 'removePackFromCart'])->name('cart.removePack');
    Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');

    Route::patch('/sales/{id}/updateStatus', [SaleController::class, 'updateStatus'])->name('sales.updateStatus');
    Route::post('/sales/{sale}/documents', [SaleController::class, 'addDocument'])->name('sales.addDocument');
    Route::delete('/sales/{sale}/documents/{document}', [SaleController::class, 'deleteDocument'])->name('sales.deleteDocument');
    Route::resource('/sales', SaleController::class)->only(['index', 'show']);
    Route::get('/sales/{sale}/payment-reference', [SaleController::class, 'showPaymentReference'])->name('sales.showPaymentReference');

    Route::get('/faq', function () {
        return view('pages.faq.index');
    })->name('faq.index');

    Route::get('/calendar', [DashboardController::class, 'showCalendar'])->name('calendar');
});

Route::post('/webhook/stripe', [SaleController::class, 'handleWebhook'])->name('webhook.stripe');


require __DIR__.'/auth.php';





