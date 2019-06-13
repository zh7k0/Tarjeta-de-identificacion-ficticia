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


Route::get('/empresas', 'ContribuyenteController@index')->name('lista_contribuyentes');
Route::get('/empresas/new', 'ContribuyenteController@create')->name('nuevo_contribuyente');
Route::post('/empresas', 'ContribuyenteController@store')->name('guardar_contribuyente');
Route::put('/empresas/{contribuyente}', 'ContribuyenteController@update')->name('contribuyente.update');
Route::get('/empresas/{contribuyente}/edit', 'ContribuyenteController@edit')->name('editar_contribuyente');
Route::get('/empresas/{contribuyente}', 'ContribuyenteController@show')->name('mostrar_contribuyente');
Route::delete('/empresas/{contribuyente}', 'ContribuyenteController@destroy');
Route::get('/empresas/{contribuyente}/render', 'ContribuyenteController@renderPdf');
Route::get('rut/{rut}', 'Rut@calcularRut');

Route::resource('giros', 'GiroController');
Route::get('/pdf', 'ContribuyenteController@pdf');

Route::redirect('/', 'empresas');