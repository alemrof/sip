<?php

use App\Http\Controllers\SearchController;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductWarehouseController;

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
Route::resource('/categories', CategoryController::class);
Route::resource('/products', ProductController::class);
Route::resource('/warehouses', WarehouseController::class);
Route::resource('/search', SearchController::class);
Route::get('/warehouses/{id}/editMap', [WarehouseController::class, 'editMap'])->name('warehouses.editMap');
Route::post('/warehouses/{id}/updateMap', [WarehouseController::class, 'updateMap'])->name('warehouses.updateMap');

Route::get('/warehouses/{id}/offer', [ProductWarehouseController::class, 'index'])->name('offers.index');
Route::get('/warehouses/{warehouse_id}/offer/{id}', [ProductWarehouseController::class, 'show'])->name('offers.show');
Route::get('/warehouses/{id}/offer/create', [ProductWarehouseController::class, 'create'])->name('offers.create');
Route::post('/warehouses/{id}/offer/store', [ProductWarehouseController::class, 'store'])->name('offers.store');
Route::get('/warehouses/{warehouse_id}/offer/{id}/edit', [ProductWarehouseController::class, 'edit'])->name('offers.edit');
Route::put('/warehouses/{warehouse_id}/offer/{id}', [ProductWarehouseController::class, 'update'])->name('offers.update');
Route::delete('/warehouses/{warehouse_id}/offer/{id}', [ProductWarehouseController::class, 'destroy'])->name('offers.destroy');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/generate-data', function() {
    (new DatabaseSeeder())->run();
    echo 'data generated';
});
