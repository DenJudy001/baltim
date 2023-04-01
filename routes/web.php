<?php

use App\Models\Stuff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchSuppDdController;
use App\Http\Controllers\PurchStuffDdController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\FoodNBeveragesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard.index');
})->middleware('auth');

Route::delete('stuff/{stuff}', function (Stuff $stuff) {
    Stuff::destroy($stuff->id);

    return response()->json([
        'success' => 'Data Barang Berhasil Dihapus'
    ]);
});

Route::get('purchsupp-dropdown',PurchSuppDdController::class);
Route::get('purchstuff-dropdown',PurchStuffDdController::class);

Route::get('/login',[LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout',[LoginController::class, 'logout']);

Route::resource('/supplier', SupplierController::class)->middleware('auth');
Route::resource('/purchase', PurchaseController::class)->middleware('auth');
Route::resource('/pos', PosController::class)->middleware('auth');
Route::get('pos/add-to-cart/{menu}', [PosController::class, 'addToCart'])->middleware('auth');
Route::post('pos/update-qty', [PosController::class, 'updateQty'])->middleware('auth');
Route::post('pos/remove-from-cart', [PosController::class, 'remove'])->name('remove.from.cart')->middleware('auth');
Route::resource('/fnb', FoodNBeveragesController::class, ['parameters' => ['fnb' => 'foodNBeverages']])->middleware('auth');
Route::resource('/salary', EmployeeSalaryController::class , ['parameters' => ['salary' => 'employeeSalary']])->middleware('auth');
Route::resource('/employee', EmployeeController::class, ['parameters' => ['employee' => 'user']])->middleware('auth');
Route::get('/account', [AccountController::class, 'index'])->middleware('auth');
