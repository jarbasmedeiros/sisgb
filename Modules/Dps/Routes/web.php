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

use Modules\Dps\Http\Controllers\DpsController;
use Modules\Dps\Http\Controllers\Prontuario\PensionistaProntuarioFrontController;
use Modules\Dps\Http\Controllers\PensionistaController;

Route::prefix('dps')->group(function() {
    Route::get('/', 'DpsController@index');
    //rota do menu lateral
    Route::get('dash', 'DpsController@getDados');
    //rota mais informações
    Route::get('/dash/prontuarios/{renderizacao}', 'DpsController@getMaisInformacoes');
    //rota dados especificos de agendamento de mes especifico
    Route::get('/agendamentos/{situacao}/{mes}', 'DpsController@getAgendamentos');
    //relatórios da DPS
    Route::get('relatorios', 'DpsController@getRelatorios');
    //busca relatorio por filtros
    Route::post('/relatorios/filtro', 'DpsController@filtro');

    //Rotas das telas de habilitação do módulo dps
    Route::get('habilitacoes', 'DpsController@listarHabilitacoesPorUnidade')
        ->name('dps_tela_habilitacoes');
    Route::get('/habilitacoes/cadastro/1', 'DpsController@findPMParaNovaHabilitacao')
        ->name('dps_tela_pesquisar_policial');
    Route::get('/habilitacoes/cadastro/2/solicitante/{idPolicial}', 'DpsController@telaNovoSolicitante')
        ->name('dps_tela_novo_solicitante');
    Route::get('/habilitacoes/cadastro/2/solicitante/editar/{cpf}/{idHabilitacao}', 'DpsController@telaEditarSolicitante')
        ->name('dps_tela_editar_solicitante');
    Route::get('/habilitacoes/cadastro/2/{id}', 'DpsController@listarBeneficiariosPorPolicial')
        ->name('dps_tela_beneficiarios_policial');
    Route::get('/habilitacoes/cadastro/3/{idPolicial}/{idPessoa}', 'DpsController@telaDadosPolicial')
        ->name('dps_tela_dados_solicitacao');
    Route::get('/habilitacoes/cadastro/3', 'DpsController@addArquivosHabilitacao')
        ->name('dps_tela_arquivos_solicitacao');
    Route::get('/habilitacao/comprovante/{idHabilitacao}', 'DpsController@gerarComprovanteHabilitacao')
        ->name('dps_tela_pdf_cadastro');

    //Rotas de acesso aos serviços
    Route::get('habilitacoes/historico/{idHabilitacao}', 'DpsController@getHistoricoByHabId')
        ->name('get_historico_habilitacao');
    Route::get('habilitacoes/pessoa/', 'DpsController@getPessoaByCPF')
        ->name('get_pessoa_cpf');
    Route::post('habilitacoes/pessoa/{idPolicial}/', 'DpsController@createPessoa')
        ->name('create_pessoa');
    Route::post('habilitacoes/pessoa/editar/{idPessoa}/{idHabilitacao}', 'DpsController@updatePessoa')
        ->name('update_pessoa');
    Route::get('habilitacoes/{idHabilitacao}', 'DpsController@getHabilitacaoById')
        ->name('get_habilitacao_id');
    Route::get('habilitacoes/{idHabilitacao}/registrar', 'DpsController@finalizaCadastroHabilitacao')
        ->name('finaliza_habilitacao_id');
    Route::post('habilitacoes/policial/', 'DpsController@getPolicialByCpfMatriculaParaHabilitacao')
        ->name('get_dados_policial');
    Route::post('habilitacoes/cadastro/dados/{idPolicial}/{idPessoa}', 'DpsController@createHabilitacao')
        ->name('create_habilitacao');
    Route::post('habilitacoes/cadastro/arquivos/criar/{idHabilitacao}', 'DpsController@createArquivoHabilitacao')
        ->name('create_arquivo_habilitacao');
    Route::get('habilitacoes/arquivos/{idHabilitacao}/{ano}/{nomeArquivo}', 'DpsController@getArquivoHabilitacao')
        ->name('get_arquivo_habilitacao');
    Route::get('habilitacoes/arquivos/baixar/{idHabilitacao}/{ano}/{nomeArquivo}', 'DpsController@downloadArquivoHabilitacao')
        ->name('download_arquivo_habilitacao');
    Route::get('habilitacoes/arquivos/excluir/{idHabilitacao}/{ano}/{nomeArquivo}/{idArquivo}', 'DpsController@deleteArquivoHabilitacao')
        ->name('delete_arquivo_habilitacao');

    // Rotas do prontuário dos pensionistas
    Route::prefix('pensionistas')->group(function() {
        
        // Rotas das telas 
        Route::get('/', 'PensionistaController@telaPesquisarPensionista')
            ->name('tela_pesquisar_pensionista');
        
        Route::post('/{pensionistaId}/{aba}/{acao}', 'Prontuario\PensionistaProntuarioFrontController@executar')
            ->name('salvar_prontuario_pensionista');

        Route::get('/{pensionistaId}/{aba}/{acao}', 'Prontuario\PensionistaProntuarioFrontController@executar')
            ->name('prontuario_pensionista');

        Route::get('/{pensionistaId}/{aba}/{acao}/{idRegistro}', 'Prontuario\PensionistaProntuarioFrontController@executar')
            ->name('prontuario_pensionista_id');

        Route::post('/{pensionistaId}/{aba}/{acao}/{idRegistro}', 'Prontuario\PensionistaProntuarioFrontController@executar')
            ->name('prontuario_pensionista_id');

        // rotas de acesso a api
        Route::prefix('acesso')->group(function() {
            
            Route::post('/pensionista', 'PensionistaController@pesquisarPensionista')
                ->name('pesquisar_pensionista');

            Route::get('/{pensionistaId}/aba/{aba}', 'PensionistaController@telaDadosPensionista')
                ->name('tela_dados_pessoais_pensionista');
        });
        
        
    });

    
});
