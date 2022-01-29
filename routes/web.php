<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDetaController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ClotheController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\MainAccountController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestBillController;
use App\Http\Controllers\RoomPriceController;
use App\Http\Controllers\StoreBillController;
use App\Http\Controllers\StoreBillDetaController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SubAccountController;
use App\Http\Controllers\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    # Room

    // Rooms Routes
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms');
    Route::post('/rooms', [RoomController::class, 'store'])->name('room.store');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('room.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('room.delete');

    // Change Room
    Route::put('/rooms/change/{room}', [RoomController::class, 'changeRoom'])->name('room.change');
    
    //change Room Price
    Route::put('/rooms/price/{room}', [RoomController::class, 'changePrice'])->name('room.price');
    
    // Room pricing Routes
    Route::get('/roomsprices', [RoomPriceController::class, 'index'])->name('roomsprices');
    Route::post('/roomsprices', [RoomPriceController::class, 'store'])->name('roomprice.store');
    Route::put('/roomsprices/{roomprice}', [RoomPriceController::class, 'update'])->name('roomprice.update');
    Route::delete('/roomsprices/{roomprice}', [RoomPriceController::class, 'destroy'])->name('roomprice.delete');

    // Institutions Routes
    Route::get('/institutions', [InstitutionController::class, 'index'])->name('institutions');
    Route::post('/institutions', [InstitutionController::class, 'store'])->name('institution.store');
    Route::put('/institutions/{institution}', [InstitutionController::class, 'update'])->name('institution.update');
    
    # Guests

    // Guests Routes
    Route::get('/guests', [GuestController::class, 'index'])->name('guests');
    Route::post('/guests', [GuestController::class, 'store'])->name('guest.store');
    Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guest.update');
    Route::delete('/guests/{guest}', [GuestController::class, 'destroy'])->name('guest.delete');


    # Rooms Bills

    // Bills Routes
    Route::get('/bills', [BillController::class, 'index'])->name('bills');
    Route::get('/bills/trashed', [BillController::class, 'trashedBill'])->name('trashedBills');
    Route::get('/bills/{id}', [BillController::class, 'show'])->name('bill.show');
    Route::get('/bills/trashed/{id}', [BillController::class, 'showTrashed'])->name('bill.show.trashed');
    Route::delete('/bills/{bill}', [BillController::class, 'destroy'])->name('bill.delete');
    //Bill Details Routes
    Route::get('/bills/details', [BillDetaController::class, 'index'])->name('details');
    Route::post('/bills/details', [BillDetaController::class, 'store'])->name('detail.store');
    
    # Restaurant Routes
    
    // Meals
    Route::get('/meals', [MealController::class, 'index'])->name('meals');
    Route::post('/meals', [MealController::class, 'store'])->name('meal.store');
    Route::put('/meals/{meal}', [MealController::class, 'update'])->name('meal.update');
    Route::delete('/meals/{meal}', [MealController::class, 'delete'])->name('meal.delete');
    
    // Bills
    Route::get('/restaurants', [RestBillController::class, 'index'])->name('restaurants');
    Route::get('/restaurants/trashed', [RestBillController::class, 'trashed'])->name('restaurant.trashed');
    Route::get('/restaurants/{id}', [RestBillController::class, 'show'])->name('restaurants.show');
    Route::get('/restaurants/trashed/{id}', [RestBillController::class, 'showTrashed'])->name('restaurants.show.trashed');
    Route::post('/bills/restBillStore', [BillDetaController::class, 'restBillStore'])->name('detail.restBillStore');

    # Store Routes

    Route::get('/stores', [StoreController::class, 'index'])->name('stores');
    Route::post('/stores', [StoreController::class, 'store'])->name('store.store');
    Route::put('/stores/{store}', [StoreController::class, 'update'])->name('store.update');
    
    // Store pay bills
    Route::put('/stores/pay/{store}', [StoreController::class, 'payItem'])->name('store.payItem');

    // Store sell Bills
    Route::get('/sell', [StoreController::class, 'sell'])->name('sell.create');
    Route::post('/store', [StoreBillController::class, 'store'])->name('store.bill.store');
    Route::get('/store/{storeBill}', [StoreBillController::class, 'show'])->name('store.bill.show');
    // ترحيل فواتير المخزن
    Route::delete('/store/move/{storeBill}', [StoreBillController::class, 'destroy'])->name('store.bill.delete');
    // فواتير مرحلة
    Route::get('/store/saved/bill', [StoreBillController::class, 'trashed'])->name('store.bill.trashed');
    Route::get('/store/show/saved/{id}', [StoreBillController::class, 'trashedShow'])->name('store.bill.trashed.show');
    // فواتير غير مرحلة
    Route::get('/store/unsaved/bill', [StoreBillController::class, 'unsaved'])->name('store.bill.unsaved');
    Route::get('/store/show/unsaved/{id}', [StoreBillController::class, 'unsavedShow'])->name('store.bill.unsaved.show');
    // حذف الفواتير غير المرحلة
    Route::delete('/store/delete/{storeBill}', [StoreBillController::class, 'unsavedDelete'])->name('store.unsaved.delete');

    // Store Bill details
    Route::post('/store/detail', [StoreBillDetaController::class, 'store'])->name('deta.bill.store');

    # Laundry Routes

    // Clothes
    Route::get('/clothes', [ClotheController::class, 'index'])->name('clothes');
    Route::post('/clothes', [ClotheController::class, 'store'])->name('clothe.store');
    Route::put('/clothes/{clothe}', [ClotheController::class, 'update'])->name('clothe.update');
    Route::delete('/clothes/{clothe}', [ClotheController::class, 'destroy'])->name('clothe.delete');

    // Bills
    Route::get('/laundries', [LaundryController::class, 'index'])->name('laundries');
    Route::get('/laundries/trashed', [LaundryController::class, 'trashed'])->name('laundries.trashed');
    Route::get('/laundries/{id}', [LaundryController::class, 'show'])->name('laundries.show');
    Route::get('/laundries/trashed/{id}', [LaundryController::class, 'showTrashed'])->name('laundries.show.trashed');
    Route::post('/laundries/store', [BillDetaController::class, 'laundryBill'])->name('laundries.store');

    # User Profile Routes
    Route::get('/users', [UserProfileController::class, 'index'])->name('users');
    Route::get('/users/{user:username}', [UserProfileController::class, 'show'])->name('users.show');
    Route::get('/users/edit/{user:username}', [UserProfileController::class, 'edit'])->name('users.edit');
    Route::put('/users/edit/{user:username}', [UserProfileController::class, 'update'])->name('users.update');
    Route::delete('/users/{user:username}', [UserProfileController::class, 'destroy'])->name('users.destroy');

    # Change Passowrd Routes
    Route::get('change-password', [ChangePasswordController::class, 'index']);
    Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');


    // Accounting Route

    # Main Account Route
    Route::get('/main/account', [MainAccountController::class, 'index'])->name('main.accounts');
    Route::get('/main/accounts/{mainAccount}', [MainAccountController::class, 'show'])->name('main.accounts.show');
    # Sub Account Route
    Route::post('/sub/accounts', [SubAccountController::class, 'store'])->name('sub.store');
    Route::put('/sub/update/{subAccount}', [SubAccountController::class, 'update'])->name('sub.update');
    # Budget Equation
    Route::get('/budget/account', [MainAccountController::class, 'budget'])->name('budget.accounts');
    #Pay Route قيد صرف او دفع
    Route::get('/pay', [LedgerController::class, 'createPay'])->name('pay.create');
    Route::post('/pay/store', [LedgerController::class, 'pay'])->name('pay.store');
    # delete pay حذف قيد
    Route::delete('/delete/pay/{ledger}', [LedgerController::class, 'destroy'])->name('pay.destroy');
    # دفتر اليومية
    Route::get('/journal', [LedgerController::class, 'index'])->name('journal.index');
    # دفتر الاستاذ
    Route::get('/single', [LedgerController::class, 'single'])->name('journal.single');
    # الميزان
    Route::get('/balance', [LedgerController::class, 'balance'])->name('journal.balance');
    #قائمة الدخل
    Route::get('/income', [LedgerController::class, 'income'])->name('journal.income');
    # قائمة المركز المالي
    Route::get('/income/statement', [LedgerController::class, 'incomeStatement'])->name('statement.income');

});