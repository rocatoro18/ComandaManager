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

Route::get('/cajero/getDetallesVentaByMesa/{mesa_id}','App\Http\Controllers\Cajero\CajeroController@getDetallesVentaByMesa');

Route::post('/cajero/ordenComanda','App\Http\Controllers\Cajero\CajeroController@ordenComanda');

Route::post('/Cajero/ConfirmarOrdenEstado','App\Http\Controllers\Cajero\CajeroController@ConfirmarOrdenEstado');

Route::post('/Cajero/EliminarDetalleVenta','App\Http\Controllers\Cajero\CajeroController@EliminarDetalleVenta');

Route::post('/Cajero/GuardarPago','App\Http\Controllers\Cajero\CajeroController@GuardarPago');

Route::get('/cajero/mostrarRecibo/{saleID}','App\Http\Controllers\Cajero\CajeroController@mostrarRecibo');


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

Route::get('/reporte','App\Http\Controllers\Reporte\ReporteController@index');

Route::get('/reporte/mostrar','App\Http\Controllers\Reporte\ReporteController@mostrar');


Route::get('/reporte/mostrar/exportar','App\Http\Controllers\Reporte\ReporteController@exportar');

