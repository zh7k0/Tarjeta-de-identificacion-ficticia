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

Route::redirect('/', 'empresas');

Route::get('/empresas', 'ContribuyenteController@index')->name('lista_contribuyentes');
Route::get('/empresas/new', 'ContribuyenteController@create')->name('nuevo_contribuyente');
Route::post('/empresas', 'ContribuyenteController@store')->name('guardar_contribuyente');
Route::put('/empresas/{contribuyente}', 'ContribuyenteController@update')->name('contribuyente.update');
Route::get('/empresas/{contribuyente}/edit', 'ContribuyenteController@edit')->name('editar_contribuyente');
Route::get('/empresas/{contribuyente}', 'ContribuyenteController@show')->name('mostrar_contribuyente');
Route::delete('/empresas/{contribuyente}', 'ContribuyenteController@destroy');
Route::get('/empresas/{contribuyente}/credencial', 'ContribuyenteController@renderPdf');


Route::resource('giros', 'GiroController');

Route::resource('/servicios', 'ServicioController')->except('show');

Route::get('/empresas/{contribuyente}/servicios', 'ServicioContratadoController@index');
Route::get('/empresas/{contribuyente}/contratar_servicio/', 'ServicioContratadoController@contratarServicio');
Route::post('/empresas/{contribuyente}', 'ServicioContratadoController@store');
Route::delete('/empresas/{contribuyente}/servicio/{servicio}', 'ServicioContratadoController@destroy');

Route::post('/servicios/{servicio}', 'ConfigFacturaController@store');
Route::get('/servicios/{servicio}/config_factura', 'ConfigFacturaController@create');

Route::get('/empresas/{contribuyente}/facturar/{servicio}', 'FacturaController@store');
Route::get('/facturas/{rut?}', 'FacturaController@index');
Route::get('/facturas/{servicio}/{folio}', 'FacturaController@show');
