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

Route::prefix('juntamedica')->group(function() {
    Route::get('/', 'JuntaMedicaController@index');
    Route::get('/atendimentosabertos', 'ProntuarioJPMSController@listarAtendimentos');
    Route::get('/atendimentosAbertos/imprimirPdf/{idAtendimento}', 'ProntuarioJPMSController@imprimirPdfAtendimentos');
    Route::get('/atendimento/editar/{idAtendimento}', 'ProntuarioJPMSController@showFormAtendimento');
    Route::get('/atendimento/corrigir/{idSessao}/{idAtendimento}', 'ProntuarioJPMSController@corrigirAtendimento');
    Route::post('/atendimento/update/{idSessao}/{idProntuario}/{idAtendimento}', 'ProntuarioJPMSController@updateAtendimento');
    Route::get('/atendimento/criar/preatendimento/{idProntuario}', 'ProntuarioJPMSController@showPreAtendimento');
    Route::post('/atendimento/criar/{idProntuario}', 'ProntuarioJPMSController@cadastrarAtendimento');
    Route::get('/atendimento/{idProntuario}/{idAtendimento}/concluir', 'ProntuarioJPMSController@concluirAtendimento');
    Route::post('/atendimento/{idProntuario}/{idAtendimento}/salvar', 'ProntuarioJPMSController@salvarAtendimento');
    Route::post('/atendimento/{idProntuario}/{idAtendimento}/{idPolicial}/salvar/anexo', 'ProntuarioJPMSController@salvarAnexoAtendimento');
    Route::get('/atendimento/deletar/anexo/{idAtendimento}/{idArquivo}', 'ProntuarioJPMSController@deletarArquivo')->name('deletarAnexo');
    Route::get('/atendimento/ver/anexo/{idArquivo}', 'ProntuarioJPMSController@verAnexo')->name('verAnexo');
    Route::post('/atendimento/excluir/{idAtendimento}', 'ProntuarioJPMSController@excluirAtendimento');
    Route::get('/atendimento/{idAtendimento}/visualizar', 'ProntuarioJPMSController@showAtendimento');
    Route::get('/prontuario/sincronizar/{idProntuario}/{cpf}', 'ProntuarioJPMSController@sincronizarProntuario')->name('sincronizarProntuario');
    Route::post('/prontuario', 'ProntuarioJPMSController@buscarProntuario');
    Route::get('/prontuario', 'ProntuarioJPMSController@showFormProntuario');
    Route::get('/prontuario/show/{idProntuario}', 'ProntuarioJPMSController@showProntuario');
    Route::get('/prontuario/criar/', 'ProntuarioJPMSController@criarProntuario');
    Route::get('/prontuario/policial/{cpfPM}', 'ProntuarioJPMSController@buscarPM');
    Route::post('/prontuario/cadastrar/', 'ProntuarioJPMSController@cadastrarProntuario');
    Route::get('/prontuario/imprimir_pdf/ficha_de_evolucao/{idProntuario}', 'ProntuarioJPMSController@imprimirPdfFichaDeEvolucao')->name('imprimirPdfFichaDeEvolucao');
    
    //Rotas de restrições
    Route::get('/restricoes', 'RestricaoController@getRestricoes');
    Route::post('/restricao/criar', 'RestricaoController@criarRestricao');
    Route::get('/restricao/editar/{idRestricao}', 'RestricaoController@editarRestricao');
    Route::post('/restricao/update/{idRestricao}', 'RestricaoController@updateRestricao');
    Route::get('/restricao/deletar/{idRestricao}', 'RestricaoController@deletarRestricao');
    
    /* Route::get('/atendimento/{idAtendimento}/deleta', 'JuntaMedicaController@excluiAtendimento');
    Route::get('/atendimento/{idAtendimento}/edita', 'JuntaMedicaController@showFormEditaAtendimento');
    Route::post('/atendimento/{idAtendimento}/edita', 'JuntaMedicaController@atualizaAtendimento'); */


    //Rotas do JUNTA MÉDICA
    Route::get('/dash', 'DashboardJpmsController@getDados');
    Route::get('/dash/prontuarios/{renderizacao}', 'DashboardJpmsController@getMaisInformacoes');
    
    //Rotas do CMAPM
    Route::get('/aguardandoPublicacao/{renderizacao}', 'JuntaMedicaController@getAguardandoPublicacaoCMAPM');
    Route::get('/pendenciaMedica', 'JuntaMedicaController@getPoliciaisEmAcompanhamentoCMAPM');
    Route::get('/pendenciaMedica/{renderizacao}', 'JuntaMedicaController@getPdfExcelPoliciaisEmAcompanhamentoCMAPM');
    Route::get('/atendimentos/{renderizacao}', 'JuntaMedicaController@getAtendimentosDiariosCMAPM');
    Route::get('/relatorioacompanhamentojpms', 'JuntaMedicaController@getRelatorioAcompanhamentoJPMS');
    Route::get('/relatorioacompanhamentojpms/listacompanhamentojpms/{idGraduacao}', 'JuntaMedicaController@getListaAcompanhamentoJPMS');
    Route::get('/listacompanhamentojpms/{idGraduacao}/{renderizacao}', 'JuntaMedicaController@getExcelPoliciaisEmAcompanhamentoJPMS');
    
    
    //Rotas para SESSOES
    Route::get('/sessoes','SessaoController@getSessoes');
    Route::post('/sessoes/novasessao','SessaoController@cadastraSessao');
    Route::post('/sessoes/edita/{idSessao}','SessaoController@editaSessao');
    Route::get('/sessoes/edita/{idSessao}', 'SessaoController@forEditaSessao');
    Route::get('/sessoes/{idSessao}/{renderizacao}', 'SessaoController@getSessao');
    Route::get('/sessoes/finaliza/sessao/{idSessao}', 'SessaoController@finalizaSessao');
    Route::get('/sessoes/exclui/{idSessao}','SessaoController@excluiSessao');
    Route::delete('/sessoes/exclui/{idSessao}','SessaoController@excluiSessao');
    Route::post('/sessoes/{idSessao}/assina', 'SessaoController@assinaSessao');
    Route::get('/sessoes/exclui/{idSessao}','SessaoController@excluiSessao');
    Route::get('/sessoes/exclui/sessao/{idSessao}','SessaoController@excluiSessao');
    Route::get('/sessoes/{idSessao}/atendimentos/{orgao}/excel', 'SessaoController@exportaAtendimentosSessaoExcel');
    Route::post('/sessoes/{idSessao}/assinatura/{idAssinatura}/exclui', 'SessaoController@excluiAssinaturaSessao');
    
    //Rotas para RELATÓRIO ATENDIMENTO
    Route::get('/relatorio/atendimentos','JuntaMedicaController@getrelatorioAtendimento');
    Route::get('/relatorio/atendimentos/listagem/atendimento/{renderizacao}','JuntaMedicaController@atendimentoPeriodo');
    Route::post('/relatorio/atendimentos/listagem/atendimento/{renderizacao}','JuntaMedicaController@atendimentoPeriodo');
    
    //Rotas dashboard
    Route::get('/dashboard', 'DashboardJpmsController@getDados');
});
