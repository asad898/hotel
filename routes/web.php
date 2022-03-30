<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDeController;
use App\Http\Controllers\BillDetaController;
use App\Http\Controllers\BondController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ClotheController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\LaBillController;
use App\Http\Controllers\LaDetacontroller;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\MainAccountController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ReBillControler;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestBillController;
use App\Http\Controllers\RoomPriceController;
use App\Http\Controllers\StoreBillController;
use App\Http\Controllers\StoreBillDetaController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SubAccountController;
use App\Http\Controllers\UserProfileController;
use App\Models\StoreBill;

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

    // Add partenr
    Route::put('/add/partner/{room}', [RoomController::class, 'addPartner'])->name('room.add.partner');

    // Remove partenr
    Route::put('/remove/partner/{room}', [RoomController::class, 'removePartner'])->name('room.remove.partner');

    // Change User with Partner
    Route::put('/change/partner/{room}', [RoomController::class, 'pchange'])->name('room.change.partner');

    // Update All Rooms
    Route::post('/rooms/all', [RoomController::class, 'updateAll'])->name('room.updateAll');
    
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
    Route::get('/bill/edit/{id}', [BillController::class, 'edit'])->name('bill.edit');
    Route::put('/bill/update/{id}', [BillController::class, 'update'])->name('bill.update');
    Route::get('/bills/trashed', [BillController::class, 'trashedBill'])->name('trashedBills');
    Route::get('/bills/{id}', [BillController::class, 'show'])->name('bill.show');
    Route::get('/bills/trashed/{id}', [BillController::class, 'showTrashed'])->name('bill.show.trashed');
    Route::delete('/bills/{bill}', [BillController::class, 'destroy'])->name('bill.delete');
    //Bill Details Routes
    Route::get('/bills/details', [BillDetaController::class, 'index'])->name('details');
    Route::get('/bills/edit/{id}', [BillDetaController::class, 'edit'])->name('details.edit'); // Admin midd
    Route::put('/bills/update/{id}', [BillDetaController::class, 'update'])->name('details.update');// Admin midd
    Route::post('/bills/details', [BillDetaController::class, 'store'])->name('detail.store');
    Route::post('/bills/details1', [BillDetaController::class, 'store1'])->name('detail.store1');
    Route::post('/bills/payment', [RoomController::class, 'payment'])->name('detail.payment');
    Route::delete('/bills/delete/{id}', [BillDetaController::class, 'destroy'])->name('bill.deta.delete');
    
    # Restaurant Routes

    
    // Meals
    Route::get('/meals', [MealController::class, 'index'])->name('meals');
    Route::post('/meals', [MealController::class, 'store'])->name('meal.store');
    Route::put('/meals/{meal}', [MealController::class, 'update'])->name('meal.update');
    Route::delete('/meals/{meal}', [MealController::class, 'delete'])->name('meal.delete');
    
    // Meal Tax
    Route::put('/tax/{id}', [MealController::class, 'taxUpdate'])->name('tax.update');
    
    // Bills
    Route::get('/restaurants', [RestBillController::class, 'index'])->name('restaurants');
    Route::get('/restaurants/trashed', [RestBillController::class, 'trashed'])->name('restaurant.trashed');
    Route::get('/restaurants/{id}', [RestBillController::class, 'show'])->name('restaurants.show');
    Route::get('/restaurants/trashed/{id}', [RestBillController::class, 'showTrashed'])->name('restaurants.show.trashed');
    Route::post('/bills/restBillStore', [BillDetaController::class, 'restBillStore'])->name('detail.restBillStore');
    
    // New bill style
    Route::get('/restaurants/bills/new', [ReBillControler::class, 'index'])->name('restaurants.bills');
    Route::get('/restaurants/bills1/new', [ReBillControler::class, 'index1'])->name('restaurants.bills1');
    Route::post('/rebill', [ReBillControler::class, 'store'])->name('rebill.store');
    Route::get('/rebill/{id}', [ReBillControler::class, 'show'])->name('rebill.show');
    Route::put('/rebill/update/{id}', [ReBillControler::class, 'update'])->name('rebill.update');
    Route::put('/rebill/save/{id}', [ReBillControler::class, 'saveReBill'])->name('rebill.store.save');
    Route::delete('/bill/deta/{id}', [BillDeController::class, 'destroy'])->name('store.billde.delete');
    Route::put('/cash/save/{id}', [ReBillControler::class, 'saveCash'])->name('cash.store.save');
    Route::delete('/rebill/{id}', [ReBillControler::class, 'destroy'])->name('store.rebill.delete');
    // Add details to restaurant bill
    Route::post('/billde', [BillDeController::class, 'store'])->name('billde.store');

    # Store Routes

    Route::get('/stores', [StoreController::class, 'index'])->name('stores');
    Route::post('/stores', [StoreController::class, 'store'])->name('store.store');
    Route::put('/stores/{store}', [StoreController::class, 'update'])->name('store.update');
    
    // Store pay bills
    Route::put('/stores/pay/{store}', [StoreController::class, 'payItem'])->name('store.payItem');
    Route::post('/bills/move1/{storeBill}', [StoreBillController::class, 'destroy1'])->name('detail.move1');
    Route::delete('/store/deta/{storeDeta}', [StoreBillDetaController::class, 'destroy'])->name('store.deta.delete');

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
    // الموافقة على الفواتير من الادارة
    Route::put('/admin/conf{storeBill}', [StoreBillController::class, 'adminConf'])->name('admin.conf.store');
    // عرض الفواتير قبل الموافقة
    Route::get('/admin/index/store', [StoreBillController::class, 'adminindex'])->name('admin.index.store');
    Route::get('/am/index/store', [StoreBillController::class, 'am'])->name('am.index.store');
    // Store Bill details
    Route::post('/store/detail', [StoreBillDetaController::class, 'store'])->name('deta.bill.store');

    # Laundry Routes

    // Clothes
    Route::get('/clothes', [ClotheController::class, 'index'])->name('clothes');
    Route::post('/clothes', [ClotheController::class, 'store'])->name('clothe.store');
    Route::put('/clothes/{clothe}', [ClotheController::class, 'update'])->name('clothe.update');
    Route::delete('/clothes/{clothe}', [ClotheController::class, 'destroy'])->name('clothe.delete');

    // Laundry Tax
    Route::put('/tax/clothe/{id}', [ClotheController::class, 'taxUpdate'])->name('tax.clothe.update');

    // Laundry New Style
    Route::get('/laundry/bills', [LaBillController::class, 'index'])->name('laundry.bills');
    Route::get('/laundry/bills1', [LaBillController::class, 'index1'])->name('laundry1.bills');
    Route::post('/labill', [LaBillController::class, 'store'])->name('labill.store');
    Route::get('/labill/{id}', [LaBillController::class, 'show'])->name('labill.show');
    Route::put('/labill/save/{id}', [LaBillController::class, 'savelabill'])->name('labill.store.save');
    Route::delete('/labilleta/{id}', [LaBillController::class, 'destroy'])->name('store.labill.delete');
    Route::put('/lacash/save/{id}', [LaBillController::class, 'saveCash'])->name('lacash.store.save');

    // Add details to laundry bill
    Route::post('/ladeta', [LaDetacontroller::class, 'store'])->name('ladeta.store');
    Route::delete('/labill/deta/{id}', [LaDetacontroller::class, 'destroy'])->name('la.billde.delete');

    // Bills
    Route::get('/laundries', [LaundryController::class, 'index'])->name('laundries');
    Route::get('/laundries/trashed', [LaundryController::class, 'trashed'])->name('laundries.trashed');
    Route::get('/laundries/{id}', [LaundryController::class, 'show'])->name('laundries.show');
    Route::get('/laundries/trashed/{id}', [LaundryController::class, 'showTrashed'])->name('laundries.show.trashed');
    Route::post('/laundries/store', [BillDetaController::class, 'laundryBill'])->name('laundries.store');

    # Users
    
    // Users Profiles Routes
    Route::get('/users', [UserProfileController::class, 'index'])->name('users');
    Route::get('/users/{user:username}', [UserProfileController::class, 'show'])->name('users.show');
    Route::get('/users/edit/{user:username}', [UserProfileController::class, 'edit'])->name('users.edit');
    Route::put('/users/edit/{user:username}', [UserProfileController::class, 'update'])->name('users.update')->middleware('auth');
    Route::delete('/users/{user:username}', [UserProfileController::class, 'destroy'])->name('users.destroy');

    # Change Passowrd Routes
    Route::get('change-password', [ChangePasswordController::class, 'index']);
    Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');

    // User Roles
    Route::put('/users/roles/edit/{user:username}', [UserProfileController::class, 'roles'])->name('users.update.roles')->middleware('auth');

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

    # Comments
    Route::get('/index/{room}', [CommentController::class, 'index'])->name('comments');    
    Route::get('/edit/{comment}', [CommentController::class, 'edit'])->name('comment.edit');    
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');    
    Route::put('/comment/edit/{comment}', [CommentController::class, 'update'])->name('comment.update');  
    Route::delete('/comment/delete/{comment}', [CommentController::class, 'destroy'])->name('comment.delete');

    # Open Bond
    Route::post('/bond/store', [BondController::class, 'store'])->name('bond.store');    
    Route::get('/create', [BondController::class, 'create'])->name('bond.create');
    Route::get('/admin/show', [BondController::class, 'admin'])->name('bond.admin');
    Route::get('/am/show', [BondController::class, 'am'])->name('bond.am');
    Route::get('/old/show', [BondController::class, 'old'])->name('bond.old');
    Route::get('/create/edit/{bond}', [BondController::class, 'edit'])->name('bond.edit');    
    Route::put('/bond/update/{bond}', [BondController::class, 'update'])->name('bond.update');
    Route::delete('/bond/delete/{bond}', [BondController::class, 'destroy'])->name('bond.delete');

    // Reports Route
    # Leaving guest report
    Route::get('/rooms/status/report', [ReportController::class, 'rooms_status_show'])->name('rooms.status');
    # Live guest report
    Route::get('/guests/rent/report', [ReportController::class, 'guests_Status'])->name('guest.live');
    # Cash Rooms report
    Route::get('/rooms/cash/report', [ReportController::class, 'rooms_cash_show'])->name('rooms.cash');

});