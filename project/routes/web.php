<?php

use Illuminate\Support\Facades\Route;
use Database\Seeders\DatabaseSeeder;


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
Route::resource('/companies', App\Http\Controllers\CompanyController::class);
Route::resource('/warehouses', App\Http\Controllers\WarehouseController::class);
Route::get('/warehouses/{id}/editMap', [App\Http\Controllers\WarehouseController::class, 'editMap'])->name('warehouses.editMap');
Route::post('/warehouses/{id}/updateMap', [App\Http\Controllers\WarehouseController::class, 'updateMap'])->name('warehouses.updateMap');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/generate-data', function() {
    (new DatabaseSeeder())->run();
    echo 'data generated';
});
