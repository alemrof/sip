<?php

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WarehouseController;

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
Route::resource('/companies', CompanyController::class);
Route::resource('/warehouses', WarehouseController::class);
Route::get('/warehouses/{id}/editMap', [WarehouseController::class, 'editMap'])->name('warehouses.editMap');
Route::post('/warehouses/{id}/updateMap', [WarehouseController::class, 'updateMap'])->name('warehouses.updateMap');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/generate-data', function() {
    (new DatabaseSeeder())->run();
    echo 'data generated';
});
