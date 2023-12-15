<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\RentoutController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\VisitLog;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [MainController::class, 'Dashboard'])->name('Dashboard')->middleware(VisitLog::class);
    Route::get('/', [MainController::class, 'Dashboard'])->name('home')->middleware(VisitLog::class);
    Route::name('User::')->prefix('User')->group(function () {
        Route::get('View/{id}', [UserController::class, 'View'])->name('View')->middleware('permission:User.Edit');
        Route::get('List', [UserController::class, 'List'])->name('List')->middleware('permission:User.Read');
        Route::get('roles', [UserController::class, 'roles'])->name('roles')->middleware('permission:Role.Read');
        Route::post('DataTable', [UserController::class, 'DataTable'])->name('DataTable');
    });
    Route::name('Agent::')->prefix('Agent')->group(function () {
        Route::get('View/{id}', [AgentController::class, 'View'])->name('View');
        Route::get('List', [AgentController::class, 'List'])->name('List')->middleware('permission:Agent.Read');
        Route::post('DataTable', [AgentController::class, 'DataTable'])->name('DataTable');
        Route::post('GetList', [AgentController::class, 'GetAgentDropDownList'])->name('GetList');
    });
    Route::name('Collection::')->prefix('Collection')->group(function () {
        Route::get('', [UserController::class, 'collection'])->name('collection')->middleware('permission:Collection');
        Route::post('DataTable', [UserController::class, 'collectionDataTable'])->name('DataTable');
    });
    Route::name('Building::')->prefix('Building')->group(function () {
        Route::get('View/{id}', [BuildingController::class, 'View'])->name('View')->middleware('permission:Building.Edit');
        Route::get('List', [BuildingController::class, 'List'])->name('List')->middleware('permission:Building.Read');
        Route::post('DataTable', [BuildingController::class, 'DataTable'])->name('DataTable');
        Route::post('GetList', [BuildingController::class, 'GetBuildingDropDownList'])->name('GetList');
        Route::name('Room::')->prefix('Room')->group(function () {
            Route::get('List', [BuildingController::class, 'RoomList'])->name('List')->middleware('permission:Room.Read');
            Route::post('DataTable', [BuildingController::class, 'RoomDataTable'])->name('DataTable');
            Route::post('GetList', [BuildingController::class, 'GetRoomDropDownList'])->name('GetList');
            Route::name('Status::')->prefix('Status')->group(function () {
                Route::get('/', [BuildingController::class, 'RoomStatus'])->name('Page')->middleware('permission:Room Status.Table View|Room Status.Grid View');
                Route::get('print', [BuildingController::class, 'RoomStatusPrint'])->name('Print')->middleware('permission:Room Status.Table View|Room Status.Grid View');
            });
            Route::name('Plan::')->prefix('Plan')->group(function () {
                Route::get('/', [BuildingController::class, 'RoomPlan'])->name('Page')->middleware('permission:Room Plan');
                Route::get('print/{date}', [BuildingController::class, 'RoomPlanPrint'])->name('Print')->middleware('permission:Room Plan');
                Route::post('DataTable', [BuildingController::class, 'RoomPlanDataTable'])->name('DataTable');
            });
        });
    });
    Route::name('Customer::')->prefix('Customer')->group(function () {
        Route::get('View/{id}', [CustomerController::class, 'View'])->name('View');
        Route::get('List', [CustomerController::class, 'List'])->name('List')->middleware('permission:Customer.Read');
        Route::post('DataTable', [CustomerController::class, 'DataTable'])->name('DataTable');
        Route::post('GetList', [CustomerController::class, 'GetCustomerDropDownList'])->name('GetList');
    });
    Route::name('coupons::')->prefix('coupons')->group(function () {
        Route::get('list', [CouponController::class, 'index'])->name('list')->middleware('permission:Coupon.Read');
        Route::post('datatable', [\App\Http\Livewire\Admin\Coupon\Table::class, 'datatable'])->name('datatable');
    });
    Route::name('offers::')->prefix('offers')->group(function () {
        Route::get('list', [OfferController::class, 'index'])->name('list')->middleware('permission:Offer.Read');
        Route::post('datatable', [\App\Http\Livewire\Admin\Offer\Table::class, 'datatable'])->name('datatable');
    });
    Route::name('settings::')->prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('page')->middleware('permission:Settings');
    });
    Route::name('roles::')->prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('page')->middleware('permission:Role.Read');
        Route::post('datatable', [\App\Http\Livewire\Admin\Roles\Table::class, 'datatable'])->name('datatable');
    });
    Route::name('Rentout::')->prefix('Rentout')->group(function () {
        Route::get('create', [RentoutController::class, 'create'])->name('create'); //->middleware('permission:Booking|Checkin');
        Route::get('checkout-report', [RentoutController::class, 'bills'])->name('bills'); //->middleware('permission:Checkout Report');
        Route::post('DataTable', [RentoutController::class, 'DataTable'])->name('DataTable');
        Route::get('edit/{id}', [RentoutController::class, 'create'])->name('edit'); //->middleware('permission:Booking|Checkin');
        Route::get('view/{id}', [RentoutController::class, 'view'])->name('view'); //->middleware('permission:Booking|Checkin');
        Route::get('pending/{id}', [RentoutController::class, 'pending'])->name('pending'); //->middleware('permission:Reservation Pending Check');
        Route::get('checkin/{id}', [RentoutController::class, 'checkin'])->name('checkin'); //->middleware('permission:Booking|Checkin');
        Route::get('single_checkout/{id}', [RentoutController::class, 'single_checkout'])->name('single_checkout'); //->middleware('permission:Booking|Checkin');
        Route::get('print/{id}', [RentoutController::class, 'print'])->name('print'); //->middleware('permission:Booking|Checkin');
        Route::get('bookingContractPrint/{id}', [RentoutController::class, 'bookingContractPrint'])->name('bookingContractPrint'); //->middleware('permission:Booking|Checkin');
        Route::get('bookingSummaryPrint/{id}', [RentoutController::class, 'bookingSummaryPrint'])->name('bookingSummaryPrint'); //->middleware('permission:Booking|Checkin');
        Route::get('List/{status?}/{flag?}', [RentoutController::class, 'List'])->name('List'); //->middleware('permission:Booking|Checkin|Checkout');
        Route::post('DataTable', [RentoutController::class, 'DataTable'])->name('DataTable');
        Route::name('checkout::')->prefix('checkout')->group(function () {
            Route::get('', [RentoutController::class, 'checkout'])->name('page'); //->middleware('permission:Checkout');
            Route::get('/{id}', [RentoutController::class, 'checkout'])->name('edit'); //->middleware('permission:Checkout');
            Route::post('datatable', [RentoutController::class, 'CheckoutDataTable'])->name('datatable');
            Route::get('balance_payment/{id}', [RentoutController::class, 'balance_payment'])->name('balance_payment'); //->middleware('permission:Checkout');
            Route::get('checkout_print/{id}', [RentoutController::class, 'checkout_print'])->name('checkout_print'); //->middleware('permission:Checkout');
            Route::get('receipt_print/{id}', [RentoutController::class, 'receiptPrint'])->name('receipt_print'); //->middleware('permission:Checkout');
        });
        Route::name('availableroom::')->prefix('availableroom')->group(function () {
            Route::post('datatable', [\App\Http\Livewire\Admin\Rentout\Register\SelectRoom::class, 'AvailableRoomDataTable'])->name('datatable');
        });
        Route::name('selectedRoom::')->prefix('selectedRoom')->group(function () {
            Route::post('datatable', [\App\Http\Livewire\Admin\Rentout\Register\SelectRoom::class, 'SelectedRoomDataTable'])->name('datatable');
        });
    });
    Route::name('report::')->prefix('report')->group(function () {
        Route::name('payment::')->prefix('payment')->group(function () {
            Route::get('', [ReportController::class, 'payment'])->name('page')->middleware('permission:Payment Report');
            Route::post('datatable', [\App\Http\Livewire\Admin\Report\Payment::class, 'tableData'])->name('datatable');
        });
    });
});
