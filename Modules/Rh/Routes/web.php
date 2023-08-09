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

Route::prefix('rh')->group(function() {

// Rotas para identidades
Route::get('rg/dashboard', 'RgController@getDashboard');
Route::get('rg/pesquisa', 'RgController@pesquisarRg');
Route::get('rg/gerarqrcode/{localizador}', 'RgController@gerarQrCode')->name('qrcode');
Route::get('rg/config', 'RgController@getConfiguracoesModuloRg');
Route::post('rg/config/edit', 'RgController@setConfiguracaoModuloRg');
Route::get('rg/atendimentos', 'RgController@getAtendimentos');
Route::post('rg/atendimentos', 'RgController@buscaAtendimentos');

//rota do Dashboard do Recursos Humanos
Route::get('dash', 'RhController@getDados');

//Rota do Dashboard do senso religioso
Route::get('censoreligioso/dashboard', 'RhController@DashboardCensoReligioso');
Route::get('censoreligioso/pdf/{donominacoes}', 'RhController@PdfCensoReligioso');


//crud de rg

Route::get('policiais/{idPolicial}/rg/prontuario', 'RgController@getProntuario');
Route::post('policiais/{idPolicial}/rg/prontuario', 'RgController@setProntuario');
Route::get('policiais/{idPolicial}/rg/new', 'RgController@showFormRg');
Route::post('policiais/{idPolicial}/rg/new', 'RgController@criarRg');

Route::get('policiais/{idPolicial}/rg/{idRg}/edit', 'RgController@getRg');//->where('idRg','[0-9]');
Route::post('policiais/{idPolicial}/rg/{idRg}/edit', 'RgController@saveRg');//->where('idRg','[0-9]');
Route::post('policiais/{idPolicial}/rg/{idRg}/imagens', 'RgController@savarImagens');
Route::post('policiais/{idPolicial}/rg/{idRg}/cedula', 'RgController@atualizarCedula');
Route::get('policiais/{idPolicial}/rg/{idRg}/preview', 'RgController@imprimirRg');
Route::post('policiais/{idPolicial}/rg/{idRg}/print', 'RgController@confirmarImprimirRg');
Route::get('policiais/{idPolicial}/rg/{idRg}/entrega', 'RgController@entregarRg');
Route::get('policiais/{idPolicial}/rg/{idRg}/devolucao', 'RgController@devolverRg');
//impressões
/* Route::get('policiais/{idPolicial}/rg/ficha', 'RgController@getFichaDatiloscopica');

Route::get('rg/validacao/{localizador}', 'RgController@validarIdentidade'); */







    Route::get('/', 'RhController@index');


Route::get('registros/{tiporegistro}/{tiporenderizacao}', 'CadernetaController@index')->name('registros');
Route::post('registros/{tiporegistro}/{tiporenderizacao}', 'CadernetaController@index')->name('registros');
Route::get('feriasativas/{tiporenderizacao}', 'CadernetaController@listaFeriasAtivas');
Route::post('feriasativas/{tiporenderizacao}', 'CadernetaController@listaFeriasAtivas');
/* Route::get('licencasativas/{tiporenderizacao}', 'CadernetaController@listaLicencasAtivas'); */
Route::get('licencasativas/{tiporenderizacao}', 'PolicialController@listaLicencasAtivas');/* Autor: @aggeu. Issue 201, Listar Licenças Ativas por unidade. */
Route::post('licencasativas/{tiporenderizacao}', 'PolicialController@geraPdfExcelLicencasAtivas');/* Autor: @aggeu. Issue 201, Listar Licenças Ativas por unidade. */
/* Route::post('licencasativas/{tiporenderizacao}', 'CadernetaController@listaLicencasAtivas'); */
Route::get('feriaselicencas/unidade/{idUnidade}', 'PolicialController@listaFeriasLicencas15Dias');/* Autor: @aggeu. Issue 207, Implementar listagem de ferias e licença para os proximos quinze dias (Tela home). */
	
	//rotas para gestão de status de funções
Route::get('statusfuncoes', 'StatusFuncaoController@index');
Route::get('statusfuncao/create', 'StatusFuncaoController@create');
Route::get('statusfuncao/edita/{id}', 'StatusFuncaoController@edit');
Route::post('statusfuncao/edita/{id}', 'StatusFuncaoController@update');
Route::post('statusfuncao/deleta/{id}', 'StatusFuncaoController@deleta');
Route::post('statusfuncoes', 'StatusFuncaoController@store');

//rotas para gestão de Setores
Route::get('setores/{tiporenderizacao}', 'SetorController@index');/* ->name('setores'); */
Route::get('setor/create', 'SetorController@create');
Route::get('setor/edita/{id}', 'SetorController@edit');
Route::post('setor/edita/{id}', 'SetorController@update');
Route::post('setor/destroy/{id}', 'SetorController@destroy');
Route::post('setores', 'SetorController@store');

//rotas para gestão de Unidade
Route::get('unidades/{tiporenderizacao}', 'UnidadeController@index');/* ->name('setores'); */
Route::get('unidade/create', 'UnidadeController@create');
Route::get('unidade/edita/{id}', 'UnidadeController@edit');
Route::post('unidade/edita/{id}', 'UnidadeController@update');
Route::post('unidade/destroy/{id}', 'UnidadeController@destroy');
Route::post('unidade', 'UnidadeController@store');
Route::get('unidadesfilhas/{idUnidadePai}', 'UnidadeController@UnidadessubordinadasAoPolicialLogado');

//rotas para gestão de cargos
Route::get('cargos', 'CargoController@index');
Route::get('cargo/create', 'CargoController@create');
Route::get('cargo/edita/{id}', 'CargoController@edit');
Route::post('cargo/edita/{id}', 'CargoController@update');
Route::post('cargo/deleta/{id}', 'CargoController@deleta');
Route::post('cargos', 'CargoController@store');

//rotas para gestão de funções
Route::get('funcoes', 'FuncaoController@index');
Route::get('funcao/create', 'FuncaoController@create');
Route::get('funcao/edita/{id}', 'FuncaoController@edit');
Route::post('funcao/edita/{id}', 'FuncaoController@update');
Route::post('funcao/destroy/{id}', 'FuncaoController@destroy');
Route::post('funcoes', 'FuncaoController@store');

//rotas para gestão de status de funções
Route::get('statusfuncoes', 'StatusFuncaoController@index');
Route::get('statusfuncao/create', 'StatusFuncaoController@create');
Route::get('statusfuncao/edita/{id}', 'StatusFuncaoController@edit');
Route::post('statusfuncao/edita/{id}', 'StatusFuncaoController@update');
Route::post('statusfuncao/deleta/{id}', 'StatusFuncaoController@deleta');
Route::post('statusfuncoes', 'StatusFuncaoController@store');

//rotas para tipo de registro
Route::get('tiporegistros', 'TipoRegistroController@index')->name('tiporegistros');
Route::get('tiporegistro/create', 'TipoRegistroController@form_tiporegistro');
Route::post('tiporegistro', 'TipoRegistroController@cad_tiporegistro');
Route::get('tiporegistro/edita/{id}', 'TipoRegistroController@form_edita');
Route::post('tiporegistro/edita/{id}', 'TipoRegistroController@update');
Route::post('tiporegistro/desativa/{id}', 'TipoRegistroController@desativa');


/* //rotas para registro
Route::get('registro/{usuario}/{tiporegistro}', 'RegistroController@show');
Route::post('registro/{usuario}/{tiporegistro}', 'RegistroController@store');
Route::get('listaregistro/{funcionario}', 'RegistroController@listaregistro');
Route::get('listaferias/{funcionario}/{tiporegistro}', 'RegistroController@listaferias'); */

//rotas para registro
Route::get('registro/{usuario}/{tiporegistro}', 'RegistroController@show');
Route::post('registro/{usuario}/{tiporegistro}', 'RegistroController@store');
Route::get('listaregistro/{funcionario}', 'RegistroController@listaregistro');
Route::get('listacrportipo/{funcionario}/{tiporegistro}/{listagemouimpressao}', 'RegistroController@listacrportipo')->name('listacrportipo');
Route::post('editaferias/{funcionario}/{registro}', 'RegistroController@editaferias');
Route::post('cr/destroy/{tiporegistro}', 'RegistroController@destroyferias');
Route::get('cr/edita/{funcionario}/{tiporegistro}/{cr}', 'RegistroController@editaferias');
Route::post('cr/edita/{funcionario}/{tiporegistro}/{cr}', 'RegistroController@updateferias');

//rotas para tipo de item
Route::get('tipoitens', 'TipoItemController@index')->name('tipoitens');
Route::get('tipoitens/create', 'TipoItemController@form_tipoitem');
Route::post('tipoitens', 'TipoItemController@cad_tipoitem');
Route::get('tipoitens/edita/{id}', 'TipoItemController@form_edita');
Route::post('tipoitens/edita/{id}', 'TipoItemController@update');
Route::post('tipoitens/desativa/{id}', 'TipoItemController@desativa');

//rotas para órgão
Route::get('orgaos/{tiporenderizacao}', 'OrgaoController@index');
Route::get('orgao/create', 'OrgaoController@create');
Route::get('orgao/edita/{id}', 'OrgaoController@edit');
Route::post('orgao/edita/{id}', 'OrgaoController@update');
Route::post('orgao/destroy/{id}', 'OrgaoController@destroy');
Route::post('orgaos', 'OrgaoController@store');

//rotas para itens
Route::get('itens', 'ItemController@formConsultaItens');
Route::post('listaitens', 'ItemController@index');
Route::get('item/create', 'ItemController@create');
Route::get('item/edita/{id}', 'ItemController@edit');
Route::post('item/edita/{id}', 'ItemController@update');
Route::post('item/deleta/{id}', 'ItemController@destroy');
Route::post('itens', 'ItemController@store');





//rotas para Policiaiis

Route::get('policiais/cadastro/novo', 'PolicialController@formCadastraPolicial');
Route::post('policiais/cadastro/novo', 'PolicialController@cadastraPolicial');
Route::get('policiais/{status}', 'PolicialController@getPoliciaisPorUnidade');
Route::get('policiais/efetivogeral/{tiporenderizacao}/{status}', 'PolicialController@getEfetivoGeral');
Route::post('policiais/efetivogeral/{tiporenderizacao}/{status}', 'PolicialController@getEfetivoGeral');
Route::get('policiais/unidade/perfis/{renderizacao}', 'PolicialController@getPolicialUnidadeEUnidadeSubordinadasPerfis');
Route::get('policiais/unidadesubordinada/{status}', 'PolicialController@getPoliciaisPorUnidadeEUnidadeSubordinadas');
Route::post('policiais/{status}/{tiporenderizacao}', 'PolicialController@geraPdfExcelPoliciaisPorUnidade');
Route::post('policiais/unidadesubordinada/{status}/{tiporenderizacao}', 'PolicialController@geraPdfExcelPoliciaisPorUnidadeSubordinadas');
Route::get('policiais/{id}/cadernetaDeRegistro', 'PolicialController@geraCadernetaDeRegistroPdf');
Route::get('policiais/{id}/caderneta_de_registros_reservado', 'PolicialController@geraCadernetaDeRegistroReservadoPdf')->name('geraCadernetaDeRegistroReservadoPdf');
Route::get('policiais/{id}/fichaDisciplinar', 'PolicialController@geraFichaDisciplinar');
Route::get('policiais/{id}/fichaDisciplinarPdf', 'PolicialController@geraFichaDisciplinarPdf');
Route::get('policiais/edita/{id}/dados_pessoais', 'PolicialController@formEditaDadosPessoais');
Route::put('policiais/edita/{id}/dados_pessoais', 'PolicialController@updateDadosPessoais');
Route::get('policiais/edita/{id}/dados_academicos', 'PolicialController@formEditaDadosAcademicos');
Route::put('policiais/edita/{id}/dados_academicos', 'PolicialController@updateDadosAcademicos');
Route::get('policiais/{id}/movimentacoes', 'PolicialController@listaMovimentacoesDoPolicial');
Route::get('policiais/{id}/movimentacao/create', 'PolicialController@formCadMovimentacao');
Route::post('policiais/{id}/movimentacao/cadastra', 'PolicialController@cadastraMovimentacao');
Route::get('policiais/{id}/movimentacao/{idMovimentacao}', 'PolicialController@formEditaMovimentacao');
Route::post('policiais/{idPolicial}/movimentacao/{idMovimentacao}/edita', 'PolicialController@editaMovimentacao');
Route::get('policiais/{idPolicial}/movimentacao/{idMovimentacao}/deleta', 'PolicialController@excluiMovimentacao');
Route::get('policiais/{idPolicial}/certidao_de_tempo_de_servico', 'PolicialController@geraCertidaoDeTempoDeServicoPdf')->name('geraCertidaoDeTempoDeServicoPdf');
Route::get('policiais/{idPolicial}/extrato_de_assentamentos', 'PolicialController@geraExtratoDeAssentamentosPdf')->name('geraExtratoDeAssentamentosPdf');
Route::get('policiais/{id}/movimentacoes/listagem', 'PolicialController@listaMovimentacoesProntuario');
Route::get('policiais/movimentacoes/importa_excel', 'PolicialController@viewImportaEfetivoParaMovimentacaoExcel'); //importa arquivo excel com o efetivo a ser movimentado - @juan_mojica #428
Route::post('policiais/movimentacoes/importa_excel/envia_planilha', 'PolicialController@importaEfetivoParaMovimentacaoExcel')->name('importaEfetivoParaMovimentacaoExcel'); //importa arquivo excel com o efetivo a ser movimentado - @juan_mojica #428

//ROTAS PARA ABA DEPENDENTES 
Route::get('policiais/edita/{id}/dependentes','PolicialController@listaDependente');
Route::post('policiais/edita/{id}/cadastra/dependentes','PolicialController@cadatraDependente');
Route::get('policiais/edita/{id}/dependente/{idDependente}', 'PolicialController@viewEditaDependente'); //retorna blade de edição de dependentes
Route::get('policiais/edita/{idPolicial}/dependentes/{idDependente}','PolicialController@editaDependente');//edita os dependentes
Route::post('policiais/exclui/{idPolicial}/dependentes/{idDependente}', 'PolicialController@excluirDependente'); //exclui dependente
Route::get('policiais/{idPolicial}/cadastra/dependentes', 'PolicialController@viewCadastroDependente');

//ROTAS PARA ABA BENEFICIÁRIOS (NO PRONTUARIO DO POLICIAL) 
Route::get('policiais/{id}/cadastra/declaracaoanual','PolicialController@criaDeclaracaoBeneficiario');
Route::get('policiais/edita/{id}/beneficiarios','PolicialController@viewBeneficiarios');
Route::get('policiais/{id}/cadastra/beneficiarios/{idCertidao}','PolicialController@viewCadastraBeneficiarios');
Route::post('policiais/cadastrar/{idPolicial}/beneficiarios/{idCertidao}','PolicialController@cadastrarBeneficiario');
Route::post('policiais/cadastrar/beneficiarios/upload/{idbeneficiario}/{idCertidao}/{tipo}','PolicialController@uploadDocumentoBeneficiario')->name('uploadDocumentoBeneficiario');
Route::get('policiais/pessoa/ajax/{cpf}','PolicialController@buscaPessoaCpfAjax');
Route::get('policiais/beneficiarios/certidao/{idPolicial}/{idCertidao}','PolicialController@imprimeCertidaoBeneficiario')->name('imprimeCertidao');
Route::get('policiais/beneficiarios/documento/{idCertidao}/{idBeneficiario}/{tipo}','PolicialController@downloadDocumentoBeneficiario')->name('downloadDocumentoBeneficiario');
Route::post('policiais/beneficiarios/assinar/{idCertidao}','PolicialController@assinarCertidao');
Route::get('policiais/reabrir/declaracao/{idPolicial}/{idDeclaracao}','PolicialController@reabrirDeclaracao')->name('reabrirDeclaracao');
Route::post('policiais/beneficiario/editar/{idDeclaracao}/{idbeneficiario}/{idPessoa}','PolicialController@editarBeneficiario');
Route::post('policiais/beneficiario/excluir/{idPolicial}/{idDeclaracao}/{idBeneficiario}','PolicialController@excluirBeneficiario')->name('excluirBeneficiario');



//**ABA PROVA DE VIDA**//
Route::get('policiais/edita/{id}/provadevida','PolicialController@abaProvadeVida');
Route::get('policiais/edita/{id}/cadastra/provadevida','PolicialController@FormcadastrarProvadeVida');
Route::post('policiais/edita/{id}/cadastra','PolicialController@cadastrarProvadeVida');
Route::get('policiais/{id}/declaracao/{idDeclaracao}/reabre','PolicialController@reabrirDeclaracaoProvadeVida')->name('reabrirDeclaracaoProvadeVida');
Route::post('policiais/{idPolicial}/upload/{idDeclaracao}/assinatura','PolicialController@uploadDocAssinatura')->name('uploadDocAssinatura');
Route::get('policiais/provadevida/download/{registroId}/{idpolicial}','PolicialController@baixarDeclaracaoAssinada');
//PDF prova de vida
Route::get('policiais/{idPolicial}/declaração/{idDeclaracao}/certidao/provadevida','PolicialController@viewCertidaoProvadeVida');
//beneficiario prova de vida
Route::get('policiais/{id}/cadastra/provadevida/{idDeclaracao}','PolicialController@FormcadastrarPessoaProvadeVida');
Route::post('policiais/cadastra/{idPolicial}/{idDeclaracao}','PolicialController@cadastrarPessoaProvadeVida');
Route::get('policiais/pessoa/ajax/{cpf}','PolicialController@buscaPessoaCpfAjax');
Route::get('policiais/beneficiario/excluir/{idPolicial}/{idDeclaracao}/{idBeneficiario}','PolicialController@excluirBeneficiarioProvadeVida')->name('excluirBeneficiarioProvadeVida');
Route::post('policiais/beneficiario/editar/{idDeclaracao}/{idBeneficiario}/{idPessoa}','PolicialController@editarBeneficiarioProvadeVida');
//assina prova de vida
Route::post('policiais/declaracao/{idPolicial}/beneficiarios/{idDeclaracao}/assinar','PolicialController@assinarProvadeVida');
//Documentos prova de vida
Route::post('policiais/beneficiarios/upload/{idBeneficiario}/{idDeclaracao}/{tipo}','PolicialController@uploadDocBeneficiario')->name('uploadDocBeneficiario');
Route::get('policiais/beneficiarios/documento/{idDeclaracao}/{idBeneficiario}/{tipo}','PolicialController@downloadDocBeneficiario')->name('downloadDocBeneficiario');


//**FIM ABA PROVA DE VIDA**//



//ROTAS PARA ABA PROCEDIMENTOS 
Route::get('policiais/edita/{id}/procedimentos','PolicialController@listarProcedimentos');

//ROTAS PARA PENSIONISTAS
Route::get('policiais/edita/{id}/pensionistas','PolicialController@listarPensionistas');

//ROTAS PARA CERTIDÕES
Route::get('policiais/edita/{idPolicial}/certidao','PolicialController@listarCertidao');
Route::get('policiais/edita/{id}/certidoes/{idCertidao}', 'PolicialController@viewCertidao'); //retorna blade de edição de dependentes
Route::post('policiais/{idPolicial}/cadastra/certidao', 'PolicialController@cadastrarCertidao');
Route::post('policiais/{idPolicial}/assinacertidao/{idCertidao}', 'PolicialController@assinarCertidaonadaConsta');


//rotas para Comportamento
Route::get('policiais/edita/{id}/comportamento', 'PolicialController@listarComportamento');
Route::get('policiais/{idPolicial}/cadastra/comportamento', 'PolicialController@viewCadastrarComportamento');
Route::post('policiais/{idPolicial}/comportamentos/cadastrar', 'PolicialController@cadastrarComportamento');
Route::get('policiais/edita/{id}/comportamento/{idComportamento}', 'PolicialController@viewEditaComportamento'); 
Route::get('policiais/{idPolicial}/comportamentos/{idComportamento}/editar', 'PolicialController@editarComportamento');
Route::post('policiais/exclui/{idPolicial}/comportamento/{idComportamento}', 'PolicialController@excluirComportamento'); 

Route::get('policiais/{idPolicial}/fichas', 'PolicialController@listaFichas');
Route::get('policiais/{idPolicial}/punicoes', 'PunicaoController@GetPunicoesPolicial');
Route::get('policiais/{idPolicial}/punicao/create', 'PunicaoController@formCadPunicao');
Route::get('policiais/{idPolicial}/punicao/edita/{idPunicao}', 'PunicaoController@formEditaPunicao');
Route::post('policiais/{idPolicial}/punicao/cadastra', 'PunicaoController@cadastraPunicao');
Route::post('policiais/{idPolicial}/punicao/edita/{idPunicao}', 'PunicaoController@editaPunicao');
Route::post('policiais/{idPolicial}/exclui/{idPunicao}/punicao', 'PunicaoController@excluirPunicao');



Route::get('policiais/{id}/publicacoes/listagem', 'PolicialController@listaPublicacoesDoPolicial');
Route::get('policiais/{id}/publicacoesreservadas/listagem', 'PolicialController@listaPublicacoesReservadasDoPolicial');
Route::get('policiais/{id}/publicacoes/create', 'PolicialController@formCadPublicacao');
Route::post('policiais/{id}/publicacao/cadastra', 'PolicialController@cadastraPublicacao');
Route::get('policiais/{id}/publicacao/{idPublicacao}', 'PolicialController@formEditaPublicacao');
Route::put('policiais/{id}/publicacao/{idPublicacao}/edita', 'PolicialController@editaPublicacao');
Route::get('policiais/{id}/publicacao/{idPublicacao}/deleta', 'PolicialController@deletaPublicacao');
Route::get('feriasAtivas', 'PolicialController@listaFeriasAtivas');
Route::post('feriasAtivas/{tiporenderizacao}', 'PolicialController@geraPdfExcelFeriasAtivas');
Route::get('policiais/{id}/arquivo/listagem', 'PolicialController@listaArquivos');
Route::post('policiais/{id}/arquivo/cadastra', 'PolicialController@cadastraArquivo');
Route::get('policiais/{idPolicial}/arquivo/{idArquivo}/download', 'PolicialController@downloadArquivo');
Route::post('policiais/{idPolicial}/arquivo/{idArquivo}/deleta', 'PolicialController@deletaArquivo');

//rotas para Férias
Route::get('policiais/edita/{idPolcial}/ferias', 'FeriasController@getFeriasPolicial');
Route::post('policiais/cria/{idPolcial}/ferias', 'FeriasController@criaFeriasPolicial');
Route::post('policiais/update/{idPolcial}/{idFerias}/ferias', 'FeriasController@updateFeriasPolicial');
Route::get('historicoferias/lista/{idPolcial}/{idFerias}', 'HistoricoFeriasController@lista');
Route::get('historicoferias/create/{idPolcial}/{idFerias}', 'HistoricoFeriasController@create');
Route::get('historicoferias/edit/{idPolcial}/{idFerias}/{idHistorico}', 'HistoricoFeriasController@edit');
Route::post('historicoferias/store/{tipo}/{idHistorico}/{idFerias}', 'HistoricoFeriasController@store');
Route::post('historicoferias/update/{idPolcial}/{idFerias}/{idHistorico}', 'HistoricoFeriasController@update');
Route::post('historicoferias/destroy/{id}', 'HistoricoFeriasController@destroy');


//Rotas para plano de ferias
Route::get('planoferias', 'PlanoFeriasController@index');
Route::get('planoferias/criar', 'PlanoFeriasController@criarPlano');
Route::post('planoferias/enviar', 'PlanoFeriasController@enviarPlano');
Route::get('planoferias/{ano}/turma/{st_turma}', 'PlanoFeriasController@listarPlano');//listar
Route::get('planoferias/efetivo/sem_plano_ferias/{ano}', 'PlanoFeriasController@listarEfetivoSemPlanoFerias')->name('efetivo_sem_plano_ferias');//Exibe a lista do efetivo que não está no plano de férias
Route::get('planoferias/{ano}/turma/{st_turma}/pesquisar', 'PlanoFeriasController@pesquisarTurmaFerias');

//Rota para distribuição de efetivo em plano de ferias
Route::get('planoferias/{ano}/distibuirefetivo', 'PlanoFeriasController@distribuirEfetivo');//Mostra a tela com o form do efetivo
Route::post('planoferias/{ano}/distibuirefetivo', 'PlanoFeriasController@enviarEfetivo');//Envia para a serviçe os dados para cadastro
Route::get('planoferias/{ano}/trocarturma/{ce_policial}', 'PlanoFeriasController@trocarTurma');//Envia para a serviçe os dados para cadastro
Route::post('planoferias/{ano}/trocarturma', 'PlanoFeriasController@enviarTrocaTurma');

Route::get('planoferias/{idPlano}/editar', 'PlanoFeriasController@editarPlano');//listar
Route::post('planoferias/{ano}/turma/{st_turma}/portaria', 'PlanoFeriasController@salvarPortaria');
Route::post('planoferias/{ano}/gerarnotabg/{idPlanoFerias}', 'PlanoFeriasController@gerarNotaBgFerias');
Route::get('planoferias/{ano}/exportarergon', 'PlanoFeriasController@exportarPlanoFeriasErgon');
Route::post('planoferias/{ano}/finalizar', 'PlanoFeriasController@finalizarPlanoFerias');
//Route::post('planoferias/{ano}', 'PlanoFeriasController@criarTurmas');//listar

//Route::get('planoferias/{ano}/turma/{idTurma}', 'PlanoFeriasController@verTurma');

//rotas para licenças
Route::get('policiais/edita/{idPolcial}/licencas', 'LicencaController@getLicencaPolicial');
Route::post('policiais/cria/{idPolcial}/licenca', 'LicencaController@criaLicencaPolicial');
Route::post('policiais/update/{idPolcial}/{idLicenca}/licenca', 'LicencaController@updateLicencaPolicial');
Route::get('historicolicenca/lista/{idPolcial}/{idLicenca}', 'HistoricoLicencaController@lista');
Route::get('historicolicenca/create/{idPolcial}/{idLicenca}', 'HistoricoLicencaController@create');
Route::get('historicolicenca/edit/{idPolcial}/{idLicenca}/{idHistorico}', 'HistoricoLicencaController@edit');
Route::post('historicolicenca/store/{tipo}/{idHistorico}/{idLicenca}', 'HistoricoLicencaController@store');
Route::post('historicolicenca/update/{idPolcial}/{idLicenca}/{idHistorico}', 'HistoricoLicencaController@update');
Route::post('historicolicenca/destroy/{id}', 'HistoricoLicencaController@destroy');
Route::post('policiais/exclui/{idPolicial}/licenca/{idLicenca}','LicencaController@excluirLicenca'); //exclui dependente

//rotas para auditorias de diarias
Route::get('diarias/listapoliciaisferais', 'DiariasController@forAuditoriaCdo');
Route::post('diarias/listapoliciaisferias', 'DiariasController@realizarAuditoriaCdo');


Route::any('policiais/buscar', 'PolicialController@buscar'); /* autor: @aggeu. Rota referente a issue 179, consultar policiais. */
Route::get('policiais/edita/{id}/dados_funcionais', 'PolicialController@form_edita_dados_funcionais'); /* autor: @aggeu. Rota referente a issue 184, editar dados funcionais. */
Route::put('policiais/edita/{id}/dados_funcionais', 'PolicialController@updateDadosFuncionais');/* autor: @aggeu. Rota referente a issue 184, editar dados funcionais. */
Route::get('policiais/edita/{id}/documentos', 'PolicialController@formEditaDocumentos'); /* autor: @aggeu. Issue 188, editar documentos do Policial. */
Route::put('policiais/edita/{id}/documentos', 'PolicialController@updateDocumentos');/* autor: @aggeu. Issue 188, editar documentos do Policial. */
Route::get('policiais/edita/{id}/dados_medalhas', 'PolicialController@listaMedalhasPolicial'); /* autor: @aggeu. Issue 194, listar medalhas do policial. */
Route::get('policiais/edita/{id}/tempo_servico', 'PolicialController@form_lista_tempo_servico'); /* autor: @cbAraujo. Rota referente a edição de tempo de serviço. */
Route::post('policiais/edita/{id}/tempo_servico/salvar', 'PolicialController@formSalvaTempoServico'); /* autor: @cbAraujo. salva dados de tempo de serviço. */
Route::post('policiais/tempo_servico_apagar/{id}/apagar/{idtemposervico}', 'PolicialController@formExcluirTempoServico'); /* autor: @cbAraujo. Rota referente a exclusao de tempo de serviço. */
Route::post('policiais/assina_certidao/tempo_servico/{idPolicial}', 'PolicialController@assinaCertidaoTempoServico')->name('assinaCertidaoTempoServico'); /* author: @juanmojica. Rota referente a assinatura da certidão de tempo de serviço. */
Route::post('policiais/cancela_assinatura_certidao/tempo_servico/{idPolicial}/{idAssinatura}', 'PolicialController@cancelaAssinaturaCertidaoTempoServico')->name('cancelaAssinaturaCertidaoTempoServico'); /* author: @juanmojica. Rota referente a assinatura da certidão de tempo de serviço. */

Route::get('policiais/edita/{idPolicial}/promocoes/listagem', 'PolicialController@listaPromocoesPolicial'); /* autor: @aggeu. Issue 193, implementar aba de promoções. */
Route::get('policiais/{idPolicial}/promocoes/cadastra', 'PolicialController@formCadastraPromocao'); /* autor: @aggeu. Issue 193, implementar aba de promoções. */
Route::post('policiais/{idPolicial}/promocoes/cadastra', 'PolicialController@cadastrarPromocao'); /* autor: @aggeu. Issue 193, implementar aba de promoções. */
Route::get('policiais/{idPolicial}/promocao/{idPromocao}/deleta', 'PolicialController@excluirPromocao'); /* autor: @aggeu. Issue 193, implementar aba de promoções. */
Route::get('policiais/{idPolicial}/promocoes/{idPromocao}', 'PolicialController@formEditaPromocao'); /* autor: @aggeu. Issue 193, implementar aba de promoções. */
Route::put('policiais/{idPolicial}/promocoes/{idPromocao}', 'PolicialController@editarPromocao'); /* autor: @aggeu. Issue 193, implementar aba de promoções. */

Route::post('policiais/{id}/medalha/cadastra', 'PolicialController@cadastrarMedalha'); /* autor: @aggeu. Issue 197, crude de medalhas de um policial. */
Route::get('policiais/{id}/medalha/cadastra', 'PolicialController@formCadastraMedalha'); /* autor: @aggeu. Issue 197, crude de medalhas de um policial. */
Route::put('policiais/{idPolicial}/medalha/{idMedalha}/edita', 'PolicialController@editarMedalha'); /* autor: @aggeu. Issue 197, crude de medalhas de um policial. */
Route::get('policiais/{idPolicial}/medalha/{idMedalha}/edita', 'PolicialController@formEditaMedalha'); /* autor: @aggeu. Issue 197, crude de medalhas de um policial. */
Route::get('policiais/{idPolicial}/medalha/{idMedalha}/exclui', 'PolicialController@excluirMedalha'); /* autor: @aggeu. Issue 197, crude de medalhas de um policial. */


Route::get('policiais/edita/{id}/cursos', 'PolicialController@listaCursosPolicial');
Route::get('policiais/edita/{id}/curso/create', 'PolicialController@forCadCurso');
Route::post('policiais/{id}/cadastra/curso', 'PolicialController@cadastrarCurso');
Route::get('policiais/{id}/edita/curso/{idcurso}', 'PolicialController@formEditaCurso');
Route::post('policiais/{id}/curso/{idcurso}/edita', 'PolicialController@EditaCurso');
Route::get('policiais/{id}/curso/{idCurso}/deleta', 'PolicialController@deletaCurso');
Route::get('/relatorios/cursos/unidade/{parametro}', 'CursoController@listaCursosPorUnidade');//Parâmetro deve ser: paginado ou excel                     
Route::post('/relatorios/cursos/unidade/nome/{parametro}', 'CursoController@listaCursosPorUnidadeENome');//Parâmetro deve ser: paginado ou excel
Route::get('/relatorios/cursos/unidade/nome/{parametro}', 'CursoController@listaCursosPorUnidadeENome');//Parâmetro deve ser: paginado ou excel



//rotas para servidores/funcionarios
Route::post('servidores/{status}/{tiporenderizacao}', 'FuncionarioController@index');
Route::get('servidor/create', 'FuncionarioController@form_funcionario');
Route::post('servidor', 'FuncionarioController@cad_funcionario');
Route::get('servidor/edita/{id}/dados_pessoais', 'PolicialController@form_edita_dados_pessoais');
Route::get('servidor/edita/{id}/dados_funcionais', 'FuncionarioController@form_edita_dados_funcionais');
Route::get('servidor/edita/{id}/documentos', 'FuncionarioController@form_edita_documentos');
Route::get('servidor/edita/{id}/dados_academicos', 'FuncionarioController@form_edita_dados_academicos');
Route::post('servidor/edita/{id}', 'FuncionarioController@update');
Route::post('servidor/desativa/{id}', 'FuncionarioController@desativa');
Route::post('servidor/ativa/{id}', 'FuncionarioController@ativa');
Route::get('servidor/sumario', 'FuncionarioController@sumario');
Route::get('servidores/sumario/orgaos/{id}', 'FuncionarioController@listaServidoresOrgao');
Route::get('servidores/sumario/funcoes/{id}', 'FuncionarioController@listaServidoresFuncao');
Route::get('servidores/sumario/graduacao/{id}', 'FuncionarioController@listaServidoresGraduacao');
Route::get('servidores/sumario/status/{id}', 'FuncionarioController@listaServidoresStatus');
Route::get('servidores/sumario/cargos/{id}', 'FuncionarioController@listaServidoresCargos');
Route::get('servidor/aniversarios/{tiporenderizacao}', 'FuncionarioController@list_aniversario');
Route::post('servidor/aniversarios/{listagem}', 'FuncionarioController@list_aniversario');
Route::get('servidor/idade', 'FuncionarioController@idade');
Route::get('servidor/imprimirficha/{id}', 'FuncionarioController@imprimirficha');
Route::any('servidores/buscar', 'FuncionarioController@buscar');
Route::get('buscapolicialparanota/{parametro}', 'PolicialController@findPolicialByCpfMatricula');



//rotas para gratificação
Route::get('gratificacoes/{tiporenderizacao}', 'GratificacaoController@index');
Route::get('gratificacao/create', 'GratificacaoController@create');
Route::get('gratificacao/edita/{id}', 'GratificacaoController@edit');
Route::post('gratificacao/edita/{id}', 'GratificacaoController@update');
Route::post('gratificacao/destroy/{id}', 'GratificacaoController@destroy');
Route::post('gratificacoes', 'GratificacaoController@store');

 //Rotas para tela de mapa de força
 Route::get('/mapaforca', 'MapaForcaController@listar');
 Route::get('/mapaforcaPDF', 'MapaForcaController@getPdf');
 
// Rotas para relatórios de ferias
Route::get('/relatorios', 'RelatorioController@index');
Route::post('/relatorios/filtro', 'RelatorioController@filtro');
Route::get('/relatorios/result', 'RelatorioController@list');
Route::get('/relatorios/ferias/unidade', 'FeriasController@listaFeriasPorUnidade');
Route::post('/relatorios/ferias/unidade/{parametro}', 'FeriasController@listaFeriasPorUnidadeEperiodo');//Parâmetro deve ser: paginado ou excel
Route::get('/relatorios/ferias/unidade/{parametro}', 'FeriasController@listaFeriasPorUnidadeEperiodo');//Parâmetro deve ser: paginado ou excel

Route::get('/relatorios/licencas/unidade', 'LicencaController@listaLicencasPorUnidade');
Route::post('/relatorios/licencas/unidade/{parametro}', 'PolicialController@listaLicencaPorUnidadeEperiodo');//Parâmetro deve ser: paginado ou excel
Route::get('/relatorios/licencas/unidade/{parametro}', 'PolicialController@listaLicencaPorUnidadeEperiodo');//Parâmetro deve ser: paginado ou excel
 

Route::get('/relatorios/medalhas/unidade', 'PolicialController@listaMedalhaUnidade');
Route::post('/relatorios/medalhas/unidade/{parametro}', 'PolicialController@listaMedalhasPorVariasUnidades');//Parâmetro deve ser: paginado ou excel
Route::get('/relatorios/medalhas/unidade/{parametro}', 'PolicialController@listaMedalhasPorVariasUnidades');//Parâmetro deve ser: paginado ou excel
Route::put('/relatorios/medalhas/unidade/{parametro}', 'PolicialController@listaMedalhasPorVariasUnidades');//Parâmetro deve ser: paginado ou excel

// Rotas para arquivos
Route::get('servidor/edita/{id}/lista_arquivos', 'ArquivoController@lista_arquivos');
Route::post('servidor/edita/{id}/lista_arquivos', 'ArquivoController@uploadArquivo');
Route::post('servidor/edita/{id}/foto', 'ArquivoController@uploadFoto');
Route::post('arquivo/destroy/{id}', 'ArquivoController@destroy');
Route::get('arquivo/openArquivo/{id}', 'ArquivoController@openArquivo');
Route::get('imagem/Fotos/{slug}', [
    'as' => 'images.show',
    'uses' => 'ArquivoController@showImage',
    'middleware' => 'auth',
]);

//rotas para o sumário
Route::get('/sumario', 'PolicialController@PoliciaisPorUnidade');
Route::get('/sumario/paginado', 'PolicialController@PoliciaisPorUnidade');
Route::get('policiais/listaPoliciais/{idGraduacao}/unidade/{idUnidade}/{renderizacao}', 'PolicialController@ListaPoliciaisPorUnidade');
// Rotas para arquivos

//Rotas para fardamentos
Route::get('policial/fardamentos/{renderizacao}', 'PolicialController@getFardamentos');
Route::get('policiais/edita/{id}/uniformes', 'PolicialController@getFardamentos');
Route::put('policial/edita/{id}/fardamentos/{renderizacao}', 'PolicialController@updateFardamentos');
Route::get('policiais/sem/fardamentos', 'PolicialController@getPoliciaisSemFardamento');

//rotas para o classificador
Route::get('/classificador', 'PolicialController@showClassificador');
Route::get('/classificador/ordenar/{sentido}/{idPolicial}', 'PolicialController@ordenarAntiguidade');
Route::post('/classificador/novaclassificacaoemlote', 'PolicialController@atualizarClassificadorEmLote')->name("addNovaClassificacao");

//Religião
//censo policial logado
Route::get('/religiao/censo', 'PolicialController@formCensoReligioso');
Route::get('/religiao/censo/{idDenominacao}', 'PolicialController@formCensoReligiosoComDenominacoes');
Route::put('/religiao/censo', 'PolicialController@cadastraCensoReligioso');
Route::get('/religiao/denomincao/{idCategoria}', 'PolicialController@getDenominacoesCategoria');
/* Route::get('/religiao/{idCategoria}/denomincao/{idDenominacao}', 'PolicialController@getDenominacaoByCategoria'); */
Route::post('/religiao/categoria/{idCategoria}/denominacao', 'PolicialController@getDenominacaoByidCategoriaNome');
Route::get('/religiao/categoria/{idCategoria}/denominacao', 'PolicialController@getDenominacaoByidCategoriaNome');
Route::get('/religiao/categoria/denominacao', 'PolicialController@getDenominacaoByidCategoriaNome');
Route::get('/religiao/censocensoreligiosodetalhado/{idCategoria}', 'RhController@categoriaReligiosaDetalhada');
//censo sgt diante
Route::get('/policiais/{idPolicial}/censoreligioso', 'PolicialController@formEditaCensoReligioso');
Route::post('/religiao/censosgtdiante', 'PolicialController@buscaPolicialCensoReligioso');
Route::put('/religiao/censo/policial/{idPolicial}/cadastra', 'PolicialController@cadastraCensoReligiosoAdm');
//Route::put('/religiao/censo/sgtdiante', 'PolicialController@cadastraCensoReligiosoSgtDiante');
//Lista censo dos policiais
Route::get('/religiao/listaPoliciais/censo/{realizaram}/{unidades}', 'PolicialController@listaPoliciasCensoReligioso');

//ROTA ABA INATIVIDADE 
Route::get('policiais/edita/{id}/inatividade','PolicialController@abaInatividade');
Route::post('policiais/{idPolicial}/aba/inatividade', 'PolicialController@setAbaInatividade');
});
 