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

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index');

    //rotas para gestão de usuarios
    Route::get('usuarios', 'UsuarioController@index')->name('usuarios');
    Route::get('usuario/create', 'UsuarioController@create');
    Route::get('usuario/edit/{id}', 'UsuarioController@edit');
    Route::post('usuario/edit/{id}', 'UsuarioController@update');
    Route::post('usuario/destroy/{id}', 'UsuarioController@destroy');
    Route::post('usuarios', 'UsuarioController@store');
   // Route::post('usuarios/consulta/buscarUsuario', 'UsuarioController@recuperarUsuarioPorNomeCPF');
    //Route::get('usuarios/consulta/buscarUsuario/{nomeCPF}', 'UsuarioController@buscarUsuarioPorNomeCPF');
    Route::get('usuarios/consulta/buscarUsuario', 'UsuarioController@buscarUsuarioPorNomeCPF')->name('buscarUsuario');
  

  
    
    
    Route::get('usuario/alterasenha/{id}', 'UsuarioController@formularioalterasenha');
    Route::post('usuario/alterasenha/{id}', 'UsuarioController@alterasenha');
    Route::get('usuario/vinculos/{id}', 'UsuarioController@form_vinculausuariounidade');
    Route::post('usuario/vinculos/{id}', 'UsuarioController@vinculausuariounidade');
    
    Route::get('usuario/vinculos/{idUsuario}/perfil', 'UsuarioController@FormvinculaUsuarioPerfil');
    Route::post('usuario/vinculos/{idUsuario}/perfil', 'UsuarioController@vinculausuarioPerfil');

    Route::get('usuario/vinculos/{idUsuario}/edita', 'UsuarioController@formEditaVinculos')->name('formEditaVinculos');
    Route::post('usuario/vinculo/{idUsuario}/adiciona', 'UsuarioController@adicionaVinculo')->name('adicionaVinculoUsuario');
    Route::post('usuario/vinculo/{idUsuario}/deletar/{idVinculo}', 'UsuarioController@deletaVinculo');

    //rotas para gestão de Perfis
    Route::get('perfis', 'RoleController@index')->name('listarole'); 
    Route::get('role/create', 'RoleController@create');
    Route::post('perfil', 'RoleController@store');
    Route::post('role/adicionarpermissao', 'RoleController@addpermission');
    Route::post('role/removerpermissaodoperfil', 'RoleController@removepermission');
    Route::get('role/edita/{id}', 'RoleController@edit');
    Route::post('role/edita/{id}', 'RoleController@update');
    Route::get('role/{id}', 'RoleController@show');

    //rotas para gestão de Permissões
    Route::get('permissions', 'PermissionController@index')->name('listapermission');
    Route::get('permission/create', 'PermissionController@create');
    Route::post('permission', 'PermissionController@store');
    Route::get('permission/edita/{id}', 'PermissionController@edit');
    Route::post('permission/edita/{id}', 'PermissionController@update');

    //rotas para unidades
    Route::get('unidades','UnidadeController@index');
    Route::get('unidades/create','UnidadeController@create');
    Route::get('unidades/edit/{idUnidade}','UnidadeController@showFormEditaUnidade');
    Route::post('unidades/edit/{idUnidade}','UnidadeController@saveEditaUnidade');
    Route::post('unidades/{idUnidade}','UnidadeController@updateUnidade');
 
    
    Route::post('unidades','UnidadeController@store');
    Route::post('unidade/consulta','UnidadeController@search');
    Route::get('unidade/consulta','UnidadeController@search');
    Route::get('unidade/organograma/tipo/a','UnidadeController@showOrganograma');
    Route::get('unidade/organograma/tipo/n','UnidadeController@showNovoOrganograma');
    Route::get('unidades/detalhes/{idUnidade}','UnidadeController@showDetalhesUnidades');


    //rotas para gestão do mural
    Route::get('noticias', 'MuralController@listarNoticias');
    Route::get('noticia/criar', 'MuralController@criandoNoticia');
    Route::post('noticia', 'MuralController@criarNoticia');
    Route::get('noticia/editar/{id}', 'MuralController@editandoNoticia');
    Route::post('noticia/editar/{id}', 'MuralController@updateNoticia');

    //rotas para Atualizacao
    Route::get('sobre', 'MuralController@historicoAtualizacao');

    //rotas para sugestões
    Route::get('sugestoes', 'SugestoesController@index')->name('sugestoes');
    Route::post('sugestoes/cadastra', 'SugestoesController@store')->name('cadastraSugestao');
    Route::get('sugestoes/voto/{idSugestao}/{voto}', 'SugestoesController@storeVoto')->name('votarSugestao');
});
