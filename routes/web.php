<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administrar\CategoriaController;
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

Route::get('/cajero', 'App\Http\Controllers\Cajero\CajeroController@index');

Route::get('/cajero/getMenuByCategoria/{categoria_id}', 'App\Http\Controllers\Cajero\CajeroController@getMenuByCategoria');

Route::get('/cajero/getMesa','App\Http\Controllers\Cajero\CajeroController@getMesas');

Route::post('/cajero/ordenComanda','App\Http\Controllers\Cajero\CajeroController@ordenComanda');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('administrar',function(){
    return view('administrar.index');
});

Route::resource('administrar/categoria','App\Http\Controllers\Administrar\CategoriaController');
Route::resource('administrar/menu','App\Http\Controllers\Administrar\MenuController');
Route::resource('administrar/mesa','App\Http\Controllers\Administrar\MesaController');