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

//Route::get('/rh/identidades/validacao/{localizador}', 'ValidacaoController@validarRg');

/** rodas do módulo de rg para validar identidades */
Route::get('/validacao/identidade/{localizador}', 'ValidacaoController@validarRg');

Auth::routes();
/** rotas do sisgp */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

//Route::get('/home', 'HomeController@listaFeriasLicencas15Dias');
Route::get('/desenvolvimento', 'HomeController@emDesenvolvimento');
Route::get('/scriptCID', 'ScriptController@getCIDs');


/* Route::get('/home', 'HomeController@listaFeriasLicencas15Dias')->name('home');
Route::get('/', 'HomeController@listaFeriasLicencas15Dias')->name('home'); 

Auth::routes();
*/

//rota para alterar o vínculo do usuário
Route::post('/usuario/alterar_vinculo', 'UsuarioController@alterarVinculo'); //@juan_mojica - #437