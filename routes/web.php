<?php
use App\Http\Controllers\HomeController;
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

Route::get('/',[App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
Auth::routes(['register'=>false,'reset'=>false]);

Route::middleware(['auth'])->group(function(){
    Route::get('/cajero', 'App\Http\Controllers\Cajero\CajeroController@index');

    Route::get('/cajero/getMenuByCategoria/{categoria_id}', 'App\Http\Controllers\Cajero\CajeroController@getMenuByCategoria');
    
    Route::get('/cajero/getMesa','App\Http\Controllers\Cajero\CajeroController@getMesas');
    
    Route::get('/cajero/getDetallesVentaByMesa/{mesa_id}','App\Http\Controllers\Cajero\CajeroController@getDetallesVentaByMesa');
    
    Route::post('/cajero/ordenComanda','App\Http\Controllers\Cajero\CajeroController@ordenComanda');
    
    Route::post('/Cajero/ConfirmarOrdenEstado','App\Http\Controllers\Cajero\CajeroController@ConfirmarOrdenEstado');
    
    Route::post('/Cajero/EliminarDetalleVenta','App\Http\Controllers\Cajero\CajeroController@EliminarDetalleVenta');
    
    Route::post('/Cajero/increase-quantity','App\Http\Controllers\Cajero\CajeroController@increaseQuantity');
    
    Route::post('/Cajero/decrease-quantity','App\Http\Controllers\Cajero\CajeroController@decreaseQuantity');

    Route::post('/Cajero/GuardarPago','App\Http\Controllers\Cajero\CajeroController@GuardarPago');
    
    Route::get('/cajero/mostrarRecibo/{saleID}','App\Http\Controllers\Cajero\CajeroController@mostrarRecibo');
    
});

Route::middleware(['auth','VerifyAdmin'])->group(function(){

    
    Route::get('administrar',function(){
        return view('administrar.index');
    });
    
    Route::resource('administrar/categoria','App\Http\Controllers\Administrar\CategoriaController');
    Route::resource('administrar/menu','App\Http\Controllers\Administrar\MenuController');
    Route::resource('administrar/mesa','App\Http\Controllers\Administrar\MesaController');
    
    Route::resource('administrar/user','App\Http\Controllers\Administrar\UserController');

    Route::get('/reporte','App\Http\Controllers\Reporte\ReporteController@index');
    
    Route::get('/reporte/mostrar','App\Http\Controllers\Reporte\ReporteController@mostrar');
    
    Route::get('/reporte/mostrar/exportar','App\Http\Controllers\Reporte\ReporteController@exportar');
    
});



//Auth::routes();


Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
