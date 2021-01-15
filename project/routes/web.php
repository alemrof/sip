<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Company;
use App\Models\Warehouse;
use Grimzy\LaravelMysqlSpatial\Types\Point;


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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [App\Http\Controllers\AdminsController::class, 'index'])->name('admin.index');
Route::get('/warehouse/{warehouse}', [App\Http\Controllers\WarehouseController::class, 'show'])->name('warehouse');
// Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/generatedata', function() {
    User::create(['name'=>'Tomasz Formela', 'email'=>'tomek@tomek.com', 'password'=>'tomek123']);
    Company::create(['name'=>'Castorama']);
    Company::create(['name'=>'Leroy Merlin']);
    Warehouse::create(['name'=>'Castorama - sklep 1', 'company_id'=>1, 'location'=>new Point(54.396006808244124, 18.577674827404387)]);
    Warehouse::create(['name'=>'Castorama - sklep 2', 'company_id'=>1, 'location'=>new Point(54.43233463765607, 18.486433086502654)]);
    Warehouse::create(['name'=>'Leroy Merlin - sklep 1', 'company_id'=>2, 'location'=>new Point(54.39463073834571, 18.58101521551848)]);
    Warehouse::create(['name'=>'Leroy Merlin - sklep 2', 'company_id'=>2, 'location'=> new Point(54.35313340101314, 18.521470337609315)]);
    echo 'data generated';
});

