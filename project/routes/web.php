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
use App\Http\Controllers\WarehouseCommentController;
use App\Http\Controllers\WarehouseImageController;
use App\Http\Controllers\ProductCommentController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\UserController;


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
Route::get('/warehouses/{id}/offer/create', [ProductWarehouseController::class, 'create'])->name('offers.create');
Route::get('/warehouses/{warehouse_id}/offer/{id}', [ProductWarehouseController::class, 'show'])->name('offers.show');

Route::post('/warehouses/{id}/offer/store', [ProductWarehouseController::class, 'store'])->name('offers.store');

Route::get('/warehouses/{warehouse_id}/offer/{id}/edit', [ProductWarehouseController::class, 'edit'])->name('offers.edit');
Route::put('/warehouses/{warehouse_id}/offer/{id}', [ProductWarehouseController::class, 'update'])->name('offers.update');
Route::delete('/warehouses/{warehouse_id}/offer/{id}', [ProductWarehouseController::class, 'destroy'])->name('offers.destroy');

Route::post('/warehouses/{warehouse_id}/comment/store', [WarehouseCommentController::class, 'store'])->name('warehouse.comment.store');
Route::delete('/warehouses/{warehouse_id}/comment/{id}', [WarehouseCommentController::class, 'destroy'])->name('warehouse.comment.destroy');

Route::post('/warehouses/{id}/image/store', [WarehouseImageController::class, 'store'])->name('warehouse.image.store');
Route::delete('/warehouses/{warehouse_id}/image/{id}', [WarehouseImageController::class, 'destroy'])->name('warehouse.image.destroy');

Route::post('/products/{product_id}/comment/store', [ProductCommentController::class, 'store'])->name('product.comment.store');
Route::delete('/products/{product_id}/comment/{id}', [ProductCommentController::class, 'destroy'])->name('product.comment.destroy');

Route::post('/products/{id}/image/store', [ProductImageController::class, 'store'])->name('product.image.store');
Route::delete('/products/{products_id}/image/{id}', [ProductImageController::class, 'destroy'])->name('product.image.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/Home/updateCoords', [HomeController::class, 'updateCoords'])->name('updateCoords');

Route::get('/generate-data', function() {
    (new DatabaseSeeder())->run();
    echo 'data generated';
});
