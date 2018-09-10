<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//proveedor Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('proveedor','\App\Http\Controllers\ProveedorController');
  Route::post('proveedor/import','\App\Http\Controllers\ProveedorController@import');
  Route::post('proveedor/load', '\App\Http\Controllers\ProveedorController@load');
  Route::post('proveedor/{id}/update','\App\Http\Controllers\ProveedorController@update');
  Route::get('proveedor/{id}/delete','\App\Http\Controllers\ProveedorController@destroy');
  Route::get('proveedor/{id}/deleteMsg','\App\Http\Controllers\ProveedorController@DeleteMsg');
});

//tienda Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('tienda','\App\Http\Controllers\TiendaController');
  Route::post('tienda/{id}/update','\App\Http\Controllers\TiendaController@update');
  Route::get('tienda/{id}/delete','\App\Http\Controllers\TiendaController@destroy');
  Route::get('tienda/{id}/deleteMsg','\App\Http\Controllers\TiendaController@DeleteMsg');
});

//nivel_servicio Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('nivel_servicio','\App\Http\Controllers\Nivel_servicioController');
  Route::post('nivel_servicio/{id}/update','\App\Http\Controllers\Nivel_servicioController@update');
  Route::get('nivel_servicio/{id}/delete','\App\Http\Controllers\Nivel_servicioController@destroy');
  Route::get('nivel_servicio/{id}/deleteMsg','\App\Http\Controllers\Nivel_servicioController@DeleteMsg');
});

//semana Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('semana','\App\Http\Controllers\SemanaController');
  Route::post('semana/{id}/update','\App\Http\Controllers\SemanaController@update');
  Route::get('semana/{id}/delete','\App\Http\Controllers\SemanaController@destroy');
  Route::get('semana/{id}/deleteMsg','\App\Http\Controllers\SemanaController@DeleteMsg');
});

//calendario Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('calendario','\App\Http\Controllers\CalendarioController');
  Route::post('calendario/import','\App\Http\Controllers\CalendarioController@import');
  Route::post('calendario/load', '\App\Http\Controllers\CalendarioController@load');
  Route::post('calendario/{id}/update','\App\Http\Controllers\CalendarioController@update');
  Route::get('calendario/{id}/delete','\App\Http\Controllers\CalendarioController@destroy');
  Route::get('calendario/{id}/deleteMsg','\App\Http\Controllers\CalendarioController@DeleteMsg');
});



//tran Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('tran','\App\Http\Controllers\TranController');
  Route::post('tran','\App\Http\Controllers\TranController@calculo');
});

// Route::get('ajax',function(){
//   return view('tran');
// });
Route::post('marcas','\App\Http\Controllers\TranController@selectAjax')->name('marcas');
// Route::post('marcas', '\App\Http\Controllers\AjaxMarcasController@selectAjax')->name('marcas');

// Route::resource('excel','ExcelController');

//marca Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('marca','\App\Http\Controllers\MarcaController');
  Route::post('marca/{id}/update','\App\Http\Controllers\MarcaController@update');
  Route::get('marca/{id}/delete','\App\Http\Controllers\MarcaController@destroy');
  Route::get('marca/{id}/deleteMsg','\App\Http\Controllers\MarcaController@DeleteMsg');
});

	
// $router->post('import', 'ImportController@import');