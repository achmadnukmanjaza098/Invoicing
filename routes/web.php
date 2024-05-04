<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MonitoringInvoiceController;
use App\Http\Controllers\MonthlyTargerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('/', [HomeController::class, 'root'])->name('root');

    // user
    Route::get('user', [UserController::class, 'user'])->name('user');
    Route::get('showFormUser/{id?}', [UserController::class, 'showFormUser'])->name('showFormUser');
    Route::post('storeUser', [UserController::class, 'storeUser'])->name('storeUser');
    Route::post('updateUser/{id}', [UserController::class, 'updateUser'])->name('updateUser');
    Route::get('deleteUser/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');

    // brand
    Route::get('brand', [BrandController::class, 'brand'])->name('brand');
    Route::get('showFormBrand/{id?}', [BrandController::class, 'showFormBrand'])->name('showFormBrand');
    Route::post('storeBrand', [BrandController::class, 'storeBrand'])->name('storeBrand');
    Route::post('updateBrand/{id}', [BrandController::class, 'updateBrand'])->name('updateBrand');
    Route::get('deleteBrand/{id}', [BrandController::class, 'deleteBrand'])->name('deleteBrand');

    // item
    Route::get('item', [ItemController::class, 'item'])->name('item');
    Route::get('showFormItem/{id?}', [ItemController::class, 'showFormItem'])->name('showFormItem');
    Route::post('storeItem', [ItemController::class, 'storeItem'])->name('storeItem');
    Route::post('updateItem/{id}', [ItemController::class, 'updateItem'])->name('updateItem');
    Route::get('deleteItem/{id}', [ItemController::class, 'deleteItem'])->name('deleteItem');

    // customer
    Route::get('customer', [CustomerController::class, 'customer'])->name('customer');
    Route::get('showFormCustomer/{id?}', [CustomerController::class, 'showFormCustomer'])->name('showFormCustomer');
    Route::post('storeCustomer', [CustomerController::class, 'storeCustomer'])->name('storeCustomer');
    Route::post('updateCustomer/{id}', [CustomerController::class, 'updateCustomer'])->name('updateCustomer');
    Route::get('deleteCustomer/{id}', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');

    // ivoice
    Route::get('invoice', [InvoiceController::class, 'invoice'])->name('invoice');
    Route::get('showFormInvoice/{id?}', [InvoiceController::class, 'showFormInvoice'])->name('showFormInvoice');
    Route::post('storeInvoice', [InvoiceController::class, 'storeInvoice'])->name('storeInvoice');
    Route::post('updateInvoice/{id}', [InvoiceController::class, 'updateInvoice'])->name('updateInvoice');
    Route::get('deleteInvoice/{id}', [InvoiceController::class, 'deleteInvoice'])->name('deleteInvoice');
    Route::get('downloadInvoice/{id}', [InvoiceController::class, 'downloadInvoice'])->name('downloadInvoice');

    // monitoring-ivoice
    Route::get('monitoring-invoice', [MonitoringInvoiceController::class, 'monitoringInvoice'])->name('monitoring-invoice');

    // monthly-target
    Route::get('monthly-target', [MonthlyTargerController::class, 'monthly-target'])->name('monthly-target');

    // report
    Route::get('report', [ReportController::class, 'report'])->name('report');
    Route::post('filterReport', [ReportController::class, 'filterReport'])->name('filterReport');
    Route::get('exportReport', [ReportController::class, 'exportReport'])->name('exportReport');
});

Route::post('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('index', [HomeController::class, 'index'])->name('index');
Route::post('index', [HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [HomeController::class, 'lang']);
