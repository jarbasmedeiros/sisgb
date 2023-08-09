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

Route::prefix('djd')->group(function() {

    Route::get('/dash','DjdController@getDadosDash');

    Route::get('/procedimentos', 'DjdController@listarNovosProcedimentos');
  
    Route::get('/buscarprocedimentos','DjdController@getBuscarProcedimentos');
    Route::post('/buscarprocedimentos','DjdController@buscarProcedimentos');
  
    Route::post('/procedimentos/registrar/{id}','DjdController@registrarProcedimentos');
    Route::get('/procedimentos/{id}/extrato','DjdController@gerarExtratoProcedimento');

});
