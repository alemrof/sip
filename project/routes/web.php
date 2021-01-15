<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Company;
use App\Models\Warehouse;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Hash;


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
Route::resource('/admin/companies', App\Http\Controllers\CompanyController::class);
Route::resource('/admin/warehouses', App\Http\Controllers\WarehouseController::class);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [App\Http\Controllers\AdminsController::class, 'index'])->name('admin.index');
Route::get('/warehouse/{warehouse}', [App\Http\Controllers\WarehouseController::class, 'show'])->name('warehouse');
// Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/generatedata', function() {
    User::create(['name'=>'Tomasz Formela', 'email'=>'tomek@tomek.com', 'password'=>Hash::make('tomek123')]);
    Company::create(['name'=>'Castorama']);
    Company::create(['name'=>'Leroy Merlin']);
    Warehouse::create(['name'=>'Skład 1', 'company_id'=>1, 'address'=>'ul. Grunwaldzka 149, 81-450 Gdańsk', 'location'=>new Point(54.396006808244124, 18.577674827404387)]);
    Warehouse::create(['name'=>'Skład 2', 'company_id'=>1, 'address'=>'ul. Grunwaldzka 149, 81-450 Gdańsk', 'location'=>new Point(54.43233463765607, 18.486433086502654)]);
    Warehouse::create(['name'=>'Skład 1', 'company_id'=>2, 'address'=>'ul. Grunwaldzka 149, 81-450 Gdańsk', 'location'=>new Point(54.39463073834571, 18.58101521551848)]);
    Warehouse::create(['name'=>'Skład 2', 'company_id'=>2, 'address'=>'ul. Grunwaldzka 149, 81-450 Gdańsk', 'location'=> new Point(54.35313340101314, 18.521470337609315)]);
    echo 'data generated';
});

// Hash::make($data['password'])