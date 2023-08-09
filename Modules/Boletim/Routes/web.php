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

use Modules\Boletim\Http\Controllers\BoletimController;

Route::prefix('boletim')->group(function() {
    Route::get('/consulta', 'BoletimController@index')->name("consultaBoletim");
    Route::match(['get', 'post'], '/busca', 'BoletimController@findBoletim');
    Route::get('/consultarpolicial/{id}', 'BoletimController@consultarpolicial');
    Route::get('buscapolicialparanota/{dadoPolicial}', 'NotaController@buscaPolicialParaNota');
    Route::get('/{idBoletim}/listanotas', 'BoletimController@viewLista');
    Route::post('/{idBoletim}/cancelarpublicacao', 'BoletimController@cancelarPublicacao');

    /** pesquisa dinâmica conforme o tipo de nota */
    Route::get('/tiponota/listarpolicialparacadatiponotas', 'NotaController@listarPolicialParaCadaTipoNotas');
    Route::post('/tiponota/addpolicialparacadatiponota', 'NotaController@addPolicialParaCadaTipoNota');
    Route::post('/tiponota/delpolicialparacadatiponota', 'NotaController@delPolicialParaCadaTipoNota');
    Route::post('/tiponota/addpoliciaisemloteparacadatiponota', 'NotaController@addPoliciaisEmLoteParaCadaTipoNota');
    Route::post('/tiponota/addpoliciaisemloteexcelparacadatiponota', 'NotaController@addPoliciaisEmLoteExcelParaCadaTipoNota')->name("addPolicialExcell");

    Route::get('/create', 'BoletimController@create');
    Route::get('/{idBoletim}/createaditamento', 'BoletimController@createAditamentoAoBoletim');
    Route::post('/create', 'BoletimController@store');
    Route::get('/edit/{id}', 'BoletimController@edit')->name("editaBoletim");
    Route::get('/exclui/{id}', 'BoletimController@destroy');
    Route::post('/assinar/{id}', 'BoletimController@assinar');
    Route::get('/finalizar/{id}', 'BoletimController@finalizarBoletim');
    Route::post('/publicar/{id}', 'BoletimController@publicarBoletim');
    Route::get('/retornarparaelaboracao/{id}', 'BoletimController@retornaBoletimParaElaboracao');
    Route::get('/publicados', 'BoletimController@boletinsPublidados');
    Route::post('/update', 'BoletimController@update');
    Route::get('/visualizar/{id}', 'BoletimController@visualizaBoletim')->name("visualizaBoletim");
    Route::get('/lista_boletim_pendente/{idUnidadeVinculadaSelecionada?}', 'BoletimController@lista_boletim_pendente')->name('boletinsemelaboacao');
    Route::get('/atribuirnotas/{id}', 'BoletimController@selecionaNotasParaBoletim');
    Route::post('/atribuirnotas/{idobletim}/{idnota}', 'BoletimController@atribuirNota');
    Route::get('/removernota/{idnota}/{idobletim}', 'BoletimController@removerNota');
    Route::get('/alterapartenota/{idNota}/{parte}/{idBoletim}', 'BoletimController@alteraParteNota');
    Route::get('/bg_elaboracao', 'BoletimController@getBGElaboracao');

    Route::post('/adicionapolicial', 'NotaController@adicionapolicial');
    Route::get('adicionarpolicialparanota/{idnota}/{idPolicial}/{tipoNota}', 'NotaController@adicionarpolicialparanota');
    Route::post('removerpolicialdanota', 'NotaController@removerpolicialdanota');

    Route::get('/notas', 'NotaController@index');
    Route::post('/nota/verificartiponota', 'NotaController@verificaTipoNota');
    Route::get('/notas/recebidas', 'NotaController@notasEnvidasParaBg');
    Route::get('/nota/create/{tipoNota}', 'NotaController@create');
    Route::post('/nota/store', 'NotaController@store');
    Route::get('/nota/edit/{id}/{tipoNota}', 'NotaController@edit');
    Route::post('/nota/update/{id}', 'NotaController@update');
    Route::post('/nota/exclui', 'NotaController@destroy');
    Route::get('/nota/finalizar/{id}', 'NotaController@finalizarEdicaoNota');
    Route::get('/nota/corrigir/{id}', 'NotaController@corrigirNota');
    Route::post('/nota/assinar/{id}', 'NotaController@assinarNota');
    Route::get('/nota/enviar/{id}', 'NotaController@enviarNota');
    Route::get('/nota/visualizar/{id}', 'NotaController@visualizarNota');
    Route::post('/nota/recusar/{id}', 'NotaController@recusarNota');
    Route::get('/nota/aceitar/{id}', 'NotaController@aceitarNota');
    Route::get('/nota/historico/{id}', 'NotaController@notaHistorico');
    Route::get('/notaprocesso/excluir/{id}', 'NotaController@excluirNotaProcesso');
    Route::get('/notas/tramitadas', 'NotaController@getNotasTramitadas');
    Route::get('/nota/devolver/{idNota}/{autorizada}', 'NotaController@devolverNotaTramitada');
    Route::get('/nota/editdevolvernotatramitada/{id}/{tipoNota}', 'NotaController@editDevolverNotaTramitada');
    Route::post('/nota/tramitar', 'NotaController@tramitarNota');
    //Route::get('/nota/consultarprocedimento/{idProcedimento}', 'NotaController@consultarProcedimento');
    Route::get('/nota/consultarprocedimento/{numSEI}', 'NotaController@consultarProcedimento');

    Route::post('/ckeditor/upload', 'NotaController@uploadImagemNota')->name('uploadImagemNota');
    

    Route::get('/capa/edit/{idBoletim}/{tipoBoletim}', 'BoletimController@editCapaBoletim');
    Route::post('/capa/update/{idBoletim}/{idCapa}', 'BoletimController@updateCapaBoletim');
    Route::post('/capa/store/{tipoBoletim}', 'BoletimController@storeCapaBoletim');

    Route::get('/promocao/Quadroacesso', 'NotaController@index');
    
    Route::get('/integrador/agendamentos', 'IntegradorController@listaAgendamentos');
    Route::get('/integrador/integrarboletim/{idIntegrador}', 'IntegradorController@integrarBoletim');
    Route::get('/integrador/integrarboletim/{idIntegrador}/checagem', 'IntegradorController@checarIntegracoes');

    Route::get('/topico/create', 'TopicoController@create');
    Route::post('/topico/create', 'TopicoController@store');
    Route::get('/topicos/lista', 'TopicoController@getTopicos');
    Route::get('/topicos/pesquisa', 'TopicoController@pesquisarTopicos');
    Route::post('/topicos/pesquisa', 'TopicoController@pesquisarTopicos');
    Route::get('/topico/edit/{idTopico}', 'TopicoController@edit');
    Route::post('/topico/update/{idTopico}', 'TopicoController@updateTopicoBoletim');
    Route::get('/topicos/deleta/{idTopico}', 'TopicoController@destroy');

    //Rotas para BG Prático
    Route::get('/bgpratico', 'BoletimController@formPesquisarBGPratico');
    Route::post('/bgpratico/pesquisar', 'BoletimController@pesquisarBGPratico')->name('pesquisarBGPratico');

    //Rotas para mover boletins
    Route::get('/mover', 'BoletimController@viewMoverBoletim');
    Route::post('/mover/pesquisar_unidades', 'BoletimController@pesquisarUnidadesMoverBoletim')->name('pesquisarUnidadesMoverBoletim');
    Route::post('/mover/movimentar_boletim', 'BoletimController@MoverBoletim')->name('MoverBoletim');

   



});