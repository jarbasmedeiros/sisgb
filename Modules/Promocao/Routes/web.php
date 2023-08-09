<?php

use Illuminate\Support\Facades\Route;

Route::prefix('promocao')->group(function() {
    Route::get('/', 'PromocaoController@index');
    Route::get('/listadequadrodeacesso','QuadroDeAcessoController@listaQuadrosDeAcesso');
    Route::get('/listadequadrodeacesso/competencia/{competencia}','QuadroDeAcessoController@index');
  
    Route::get('quantitativodevagas','QuadroDeVagaController@listarVagas');
    Route::post('atualizaquantitativovagas','QuadroDeVagaController@atualizaVagas');

    Route::post('/quadro/adicionar','QuadroDeAcessoController@adicionar');
    Route::post('quadrodeacesso/update/{id}','QuadroDeAcessoController@update');
    Route::get('quadro/cronograma/{idQuadro}/competencia/{competencia}','QuadroDeAcessoController@listaCronograma');
    Route::post('quadro/cronograma/adicionaratividade/{idQuadro}','QuadroDeAcessoController@adicionarAtvidadeNoCronogramaDoQA');
    Route::get('quadro/cronograma/removeratividade/{idQuadro}/{idAtividade}','QuadroDeAcessoController@removerAtvidadeNoCronogramaDoQA');
    Route::get('quadro/divulgarquadrovagas/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@calcularQuadroDeVagas');
   /*  Route::get('quadro/calcularvagas/{idQuadro}/{idAtividade}/nota','QuadroDeAcessoController@gerarNotaContendoQuadroDeVagas'); */
    Route::post('quadro/calcularvagas/{idQuadro}/{idAtividade}/nota/{tipoRenderizacao}','QuadroDeAcessoController@gerarNotaContendoQuadroDeVagas');
    Route::post('quadro/{idQuadro}/atividade/{idAtividade}/policial/comissao','QuadroDeAcessoController@cadastrarPolicialNaComissao');
    Route::post('quadro/{idQuadro}/atividade/{idAtividade}/deleta/policial/{idPolicial}/comissao','QuadroDeAcessoController@deletarMembroDaComissao');
    Route::post('quadro/{idQuadro}/atividade/{idAtividade}/cadastra/portaria/quadroDeVagas','QuadroDeAcessoController@cadastrarPortariaDivulgarQuadroDeVagas');
    Route::post('quadro/{idQuadro}/atividade/{idAtividade}/comissao/assinatura/portaria','QuadroDeAcessoController@assinarPortariaDoQuadro');

    Route::get('quadro/cronograma/{idQuadro}/competencia/{competencia}','QuadroDeAcessoController@listaCronograma');
    

    Route::any('buscapolicialparainspecaodesaude/{idQuadro}/{idAtividade}/competencia/{competencia}','PromocaoController@buscaPolicialParaInspecaoDeSaude');
    Route::post('parcererjpms/{idPolicialNoQuardo}/{idQuadro}/{idAtividade}/competencia/{competencia}','PromocaoController@parecerJPMS');
    Route::post('concluirInspecaojpms/{idQuadro}/{idAtividade}','PromocaoController@concluirInspecaojpms');
    Route::get('resultadodaInpecaodesaude/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@convocarParaInspecaoSaude');
    Route::post('resultadodaInpecaodesaude/{idQuadro}/{idAtividade}/gerarNota/{tiporenderizacao}','QuadroDeAcessoController@concluirResultadoJpms');
    Route::post('gerarnotarconvocacaoextra/{idQuadro}/{idAtividade}/gerarNota/competencia/{competencia}','QuadroDeAcessoController@gerarNotaConvocacaoExtra');

    Route::get('concluirelacaoefetivo/{idAtividade}','QuadroDeAcessoController@concluirRelacaoEfetivoParaQA');
    Route::get('listaefetivoparaquadro/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listaefetivoParaQuadroAcesso');
    Route::get('/quadrodeacesso/addpolicialnalistadoqudro/{idQuadro}/{idPolicial}', 'QuadroDeAcessoController@adicionarPolicialParaQuadroAcesso');
    Route::get('removerpolicialdoquadro/{idPolicialnoquadro}/{idQuadroDeAcesso}/{idAtividade}', 'QuadroDeAcessoController@removerPolicialDoQuadroAcesso');
    Route::get('removerpolicialdoqa/{idPolicial}/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@removerPolicialDoQA');

    Route::get('convocarparataf/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@convocarParaTaf');
    Route::post('convocarparataf/convocacao/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@cadastrarPortariaNoCronogrma');
    Route::post('/gerarnota/convocacaotaf/{idQuadroDeAcesso}/{idAtividade}', 'QuadroDeAcessoController@gerarNotaConvocarTaf');

    Route::post('resultadoinspecaodesaude/{idQuadroDeAcesso}/{idAtividade}', 'QuadroDeAcessoController@cadastrarPortariaNoCronogrmaInspecaoSaude');
    
    
    Route::get('quadro/convocarparajpms/{idQuadro}','QuadroDeAcessoController@convocarSoldadoJpms');
    Route::get('quadroDeAcesso/convocarJpms/{idQuadro}/{idAtividade}','QuadroDeAcessoController@convocarSoldadoJpms');
    
    Route::get('convocarparajpms/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@convocarSoldadoJpms');
    
    /* Rota para Realizar pré-análise (JPMS) - @aggeu */
    Route::get('preanalisejpms/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@preanalisejpms');
    Route::get('compendencianajpms/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@compendencianajpms');
    Route::get('sempendencianajpms/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@sempendencianajpms');
    Route::post('quadrosacessos/{idQuadro}/policiais/{idPolicial}/preanalise/{boSituacao}','QuadroDeAcessoController@realizarpreanalisejpms');
    Route::any('buscapolicialparapreanalisejpms/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@buscaPolicialParaPreanaliseJpms');

    /* Rota para resolver Pendências da CPP*/
    Route::get('pendencias/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@consultarPolicialParaResolverPendenciasCpp');
    Route::post('pendencias/{idQuadro}/{idAtividade}/competencia/{competencia}','QuadroDeAcessoController@listarPolicialParaResolverPendenciasCpp');
    Route::post('pendencias/{idQuadro}/{idAtividade}/{idPolicial}/competencia/{competencia}','QuadroDeAcessoController@salvarAtualizacaoDoPolicialPendenciasCpp');
    Route::get('pendencias/{idQuadro}/{idAtividade}/{idPolicial}/competencia/{competencia}','QuadroDeAcessoController@listarPolicialComPedenciaResolvidaCpp');
    
    /* Rotas para Convocação de Inspeção de Saúde */
    Route::get('convocarparajpms/soldado/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@convocarSoldadoJpms');
    Route::get('convocarparajpms/cabo/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@convocarCaboJpms');
    Route::get('convocarparajpms/sargento/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@convocarSargentoJpms');
    Route::post('convocarparajpms/storeSoldado/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@convocarSoldadoJpmsStore');
    Route::post('convocarparajpms/storeCabo/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@convocarCaboJpmsStore');
    Route::post('convocarparajpms/storeSargento/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@convocarSargentoJpmsStore');
    Route::post('convocarparajpms/gerarNota/{idQuadro}/{idAtividade}', 'QuadroDeAcessoController@gerarNotaConvocacaoJpms');

    /* Rota para Convocação extra de Inspeção de Saúde */
    Route::get('convocacaoextra/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@convocarInspExtraJpms');
   // Route::post('convocacaoextra/gerarNota/{idQuadroAcesso}/{idAtividade}/{competencia}', 'QuadroDeAcessoController@gerarNotaConvocacaoExtra');
    Route::get('convocacaoextra/gerarNota/{idQuadroAcesso}/{idAtividade}/{competencia}', 'QuadroDeAcessoController@gerarNotaConvocacaoExtra');
    Route::post('convocacaoextra/portaria/salvar/{idQuadroAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@salvarMateriaConvocacaoExtra');
    Route::post('convocacaoextra/portaria/salvar/{idQuadroAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@salvarMateriaConvocacaoExtra');
    Route::get('removerpolicialdaconvocaoextra/{idPolicial}/{idQuadroDeAcesso}/{idAtividade}', 'QuadroDeAcessoController@removerPolicialDaConvocacoExtra');
    
    
    Route::get('policiaisinspecionados/{idQuadro}/{idAtividade}/competencia/{competencia}','PromocaoController@policiaisInspecionadosJpms');
    /* Rota para Inspeção de Saúde */
    Route::get('inspecaoparapromocaojpms/{idQuadro}/{idAtividade}/competencia/{competencia}','PromocaoController@inspecaoParaPromocaoJpms');

    /* Rota para Escriturar Ficha de Reconhecimento */
    Route::get('fichasgtnaoenviada/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listaSgtEscriturarNaoEnviada');
    Route::get('fichasgtenviada/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listaSgtEscriturarEnviada');
    Route::post('fichasgtnaoenviada/buscasgt/{idQuadroDeAcesso}/{idAtividade}/{enviada}/competencia/{competencia}', 'QuadroDeAcessoController@buscaSgtCpfMatriculaNome');
    Route::get('fichasgtnaoenviada/importa/policiais/QA/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@importaPoliciaisDaUnidadeParaQA')->name('importaPoliciaisDaUnidadeParaQA');
    Route::get('fichasgtnaoenviada/importa/dados/policial/QA/{idQuadro}/{idAtividade}/competencia/{competencia}/{idPolicial}', 'QuadroDeAcessoController@importaDadosPolicialEscriturarFicha')->name('importaDadosPolicialEscriturarFicha');
    Route::post('fichasgtenviada/buscasgt/{idQuadroDeAcesso}/{idAtividade}/{enviada}/competencia/{competencia}', 'QuadroDeAcessoController@buscaSgtCpfMatriculaNome');
    Route::get('escriturarfichadereconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@escriturarFichaReconhecimento');
    Route::get('escriturarfichadereconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}/ficha/{idFicha}', 'QuadroDeAcessoController@escriturarFichaReconhecimentoselecionada');
    Route::post('escriturarfichadereconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}/ficha/{idFicha}', 'QuadroDeAcessoController@atualizaFichaReconhecimento');
    Route::get('escriturarfichadereconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}/pdf/ficha/{idFicha}', 'QuadroDeAcessoController@escriturarFichaReconhecimentoPdf');
    Route::post('enviarFichaEscriturada/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/{competencia}', 'QuadroDeAcessoController@enviarFichaEscriturada');
    Route::post('retornarFichaEscrituradaParaEdicao/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/{competencia}', 'QuadroDeAcessoController@retornarFichaEscrituradaParaEdicao');
    Route::get('escrituradaFicha/arquivo/{idArquivo}/policial/{idPolicial}', 'QuadroDeAcessoController@downloadArquivoFichaReconhecimento');
    Route::post('escrituradaFicha/atividade/{idAtividade}/arquivo/{idArquivo}/policial/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@deleteArquivoId');
    Route::post('fichaReconhecimento/assina/{idQuadro}/{idPolicial}', 'QuadroDeAcessoController@assinaFichaReconhecimento')->name('assinaFichaReconhecimento');
    Route::get('inserirpolicial/qa/{idQuadro}/{idPolicial}', 'QuadroDeAcessoController@inserirPolicialNoQA');
    
    Route::get('visualizarpdffichadereconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}/ficha/{idFicha}', 'QuadroDeAcessoController@visualizarPdfFichaReconhecimento');
    //Route::get('fichas/visualizar/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@visualizarFichasReconhecimento');
    Route::get('fichas/visualizarenviadas/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@consultarFichasReconhecimento');
    Route::get('fichas/visualizarhomologadas/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@consultarFichasReconhecimento');
    Route::get('fichaselecionada/visualizarhomologadas/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}/ficha/{idFicha}', 'QuadroDeAcessoController@consultarFichasReconhecimentoSelecionada');

    /* Rota para Homologar Ficha de Reconhecimento */
    Route::get('homologarfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listaPoliciaisNaoHomologadosFicha');
    Route::get('homologarfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}/graduacao/{graduacao}', 'QuadroDeAcessoController@listaPoliciaisNaoHomologadosGraduacaoFicha');
    Route::get('homologadosfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listaPoliciaisHomologadosFicha');
    Route::get('homologarfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@validarFichaReconhecimento');
    Route::get('homologarfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}/ficha/{idFicha}', 'QuadroDeAcessoController@validarFichaReconhecimentoSelecionada');
    Route::post('salvarhomologarfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}', 'QuadroDeAcessoController@salvarValidacaoFichaReconhecimento');
    Route::post('homologarfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/ficha/{idFicha}', 'QuadroDeAcessoController@homologarValidacaoFichaReconhecimento');
    Route::post('retornarfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}', 'QuadroDeAcessoController@retornarFichaReconhecimento');
    Route::post('buscapolicialfichaaba/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}/{aba}', 'QuadroDeAcessoController@buscaPolicialFichaReconhecimentoAba');
    Route::post('buscapolicialparahomologar/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@buscaPolicialValidarFichaReconhecimento');
    Route::post('deshomologar/fichadereconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@reabrirHomologacaoFichaReconhecimento');
    Route::post('dependencias/fichadereconhecimento/{idQuadroDeAcesso}/{idAtividade}/{idPolicial}', 'QuadroDeAcessoController@cadastrarDependenciasFichaReconhecimento');
    
    //Rotas para exporta listagem em formato excel
    Route::get('fichasreconhecimento/validadas/excel/{idQuadro}/{idAtividade}', 'QuadroDeAcessoController@geraExcelFichaReconhecimento');
    Route::get('fichasreconhecimento/excel/pendencias/{status}/{idQuadro}/{idAtividade}', 'QuadroDeAcessoController@geraExcelFichaReconhecimentoPendencias');
    Route::get('fichasreconhecimento/excel/ausentes/qa/{idQuadro}', 'QuadroDeAcessoController@geraExcelFichaReconhecimentoAusentes');
    
    // Recurso
    Route::get('escrituradaFicha/recurso/{idQuadro}/atividade/{idAtividade}/policial/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@recursoFichaReconhecimento');
    Route::post('escrituradaFicha/recurso/{idQuadro}/atividade/{idAtividade}/policial/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@salvaRecursoFichaReconhecimento');
    Route::get('escrituradaFicha/recurso/{idQuadro}/atividade/{idAtividade}/policial/{idPolicial}/competencia/{competencia}/pdf', 'QuadroDeAcessoController@recursoFichaReconhecimentoPdf');
    Route::get('listaanalisarrecurso/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listaAnalisarRecurso');
    Route::get('listarecursosavaliados/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listaRecursosAvaliados');
    Route::get('analisarrecurso/{idQuadro}/atividade/{idAtividade}/policial/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@AnalisarRecurso');
    Route::post('analisarrecurso/{idQuadro}/atividade/{idAtividade}/policial/{idPolicial}/competencia/{competencia}', 'QuadroDeAcessoController@salvarAnaliseRecurso');
    Route::post('finalizaanalisarrecurso/{idQuadro}/atividade/{idAtividade}/policial/{idPolicial}', 'QuadroDeAcessoController@finalizarAnaliseRecurso');
    Route::post('listaanalisarrecurso/buscasgt/{idQuadroDeAcesso}/{idAtividade}/{enviada}/competencia/{competencia}', 'QuadroDeAcessoController@buscaSgtCpfMatriculaNomeRecurso');
    Route::post('listarecursosavaliados/buscasgt/{idQuadroDeAcesso}/{idAtividade}/{enviada}/competencia/{competencia}', 'QuadroDeAcessoController@buscaSgtCpfMatriculaNomeRecurso');
    Route::get('/alterarrecurso/qa/{idQuadro}/{idAtividade}/competencia/{competencia}/{status}', 'QuadroDeAcessoController@alterarRecursoQA');
    Route::get('/alterarescriturar/qa/{idQuadro}/{idAtividade}/competencia/{competencia}/{status}', 'QuadroDeAcessoController@alterarEscriturarQA');
    Route::get('/alterarstatusrecurso/policial/{idPolicial}/{idQuadro}/{idAtividade}', 'QuadroDeAcessoController@alterarStatusRecursoPolicial');
    Route::get('/alterarstatusanaliserecurso/policial/{idPolicial}/{idQuadro}/{idAtividade}', 'QuadroDeAcessoController@alterarStatusAnaliseRecursoPolicial');
    Route::get('/fichasreconhecimento/policiais/recorreram/{idQuadro}', 'QuadroDeAcessoController@exportaPoliciaisRecorreram');
    Route::get('recursosfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}/graduacao/{graduacao}', 'QuadroDeAcessoController@listaPoliciaisRecorreramFicha');
    Route::get('recursosanalisadosfichareconhecimento/{idQuadroDeAcesso}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listaPoliciaisRecursosAnalisadosFicha');


    // Rotas de Realizar TAF
    Route::get('realizartaf/{idQuadro}/{idAtividade}/competencia/{competencia}', 'PromocaoController@realizarTaf');
    Route::get('realizartafinspecionado/{idQuadro}/{idAtividade}/competencia/{competencia}', 'PromocaoController@realizarTafPoliciaisInspecionados');
    Route::post('realizartafpolicial/{idQuadro}/{idAtividade}/{idPolicial}/competencia/{competencia}', 'PromocaoController@realizarTafPolicial');
    Route::post('buscapolicialparataf/{tafInspecionados}/{idQuadro}/{idAtividade}/competencia/{competencia}', 'PromocaoController@findPmTaf');
    Route::post('concluirtaf/{idQuadro}/{idAtividade}', 'PromocaoController@concluirTaf');
    Route::get('resultadodotaf/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@resultadoTaf');
    Route::post('resultadotaf/{idQuadroDeAcesso}/{idAtividade}', 'QuadroDeAcessoController@cadastrarPortariaNoCronogrmaDivulgarTaf');
    Route::post('divulgarTaf/{idQuadroDeAcesso}/{idAtividade}/gerarNota/{tiporenderizacao}', 'QuadroDeAcessoController@gerarNotaDivulgarTaf');
    Route::post('divulgarTaf/{idQuadroDeAcesso}/{idAtividade}/visualizarNota', 'QuadroDeAcessoController@visualizarNotaDivulgarTaf');
    
    //Rotas de Cadastrar comissão e assinar portaria de divulgar resultado do taf
    Route::post('quadrosacessos/{idQuadro}/atividade/{idAtividade}/cadastra/policial/assinatura/portaria', 'QuadroDeAcessoController@cadastraPolicialAssinaturaPortaria'); /* Autor: @aggeu. Issue 215. */
    Route::get('quadrosacessos/{idQuadro}/atividade/{idAtividade}/cadastra/policial/assinatura/portaria', 'QuadroDeAcessoController@formCadastraPolicialAssinaturaPortaria'); /* Autor: @aggeu. Issue 215. */
    Route::post('comissao/{idQuadro}/{idAtividade}/cadastro', 'QuadroDeAcessoController@cadastraPolicialAssinaturaPortaria'); /* Autor: @aggeu. Issue 215. */
    Route::get('quadrosacessos/{idQuadro}/atividade/{idAtividade}/deleta/policial/{idPolicial}/assinatura/portaria', 'QuadroDeAcessoController@excluiPolicialAssinaturaPortaria'); /* Autor: @aggeu. Issue 215. */
    Route::put('comissao/{idQuadro}/{idAtividade}/assinatura', 'QuadroDeAcessoController@finalizarPolicialAssinaturaPortaria'); /* Autor: @aggeu. Issue 215. */
 

    /* Rotas de finalizar escrituração */
    Route::post('finalizarescrituracao/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@finalizarEscrituracao');

     /* Rotas de divulgar QA */
     Route::get('divulgarqapreliminar/{idQuadro}/{idAtividade}/competencia/{competencia}', 'QuadroDeAcessoController@listarPoliciaisQaPreliminar');
     Route::post('cadastrarportariadivulgarqapreliminar/{idQuadro}/{idAtividade}', 'QuadroDeAcessoController@cadastrarPortariaDivulgarQaPreliminar');
     Route::post('gerarnotadivulgarqapreliminar/{idQuadro}/{idAtividade}/gerarNota/{tiporenderizacao}', 'QuadroDeAcessoController@gerarNotaQaPreliminar');

    /* Rota para consultar policial por cpf ou matrícula */
    Route::get('consultarpolicial/{cpfOuMatricula}', 'QuadroDeAcessoController@buscarPolicialPorCpfOuMatricula');

    //Rotas para consultar históricos
    Route::get('historico/quadrosacessos/{idQuadro}/{idPolicial}', 'QuadroDeAcessoController@listaHistoricoPolicialQA');

    //Rotas para importar policiais em lote
    Route::post('/qa/addpoliciaisaoqaexcel', 'QuadroDeAcessoController@addPoliciaisAoQaEmLoteExcel')->name("addPolicialAoQaEmLoteExcell");
    Route::post('/qa/importarpoliciaisinspecionados/jpms/taf/excel', 'QuadroDeAcessoController@importarPoliciaisInspecionadosJpmsTafExcel')->name("importarPoliciaisInspecionadosJpmsTafExcel");

    Route::get('dashoboard/qa/{idQuadro}/{idAtividade}', 'QuadroDeAcessoController@exibeDashboardQA');

    Route::post('editarpolicial/{idPolicial}/qa/{idQuadro}/{statusFicha}', 'QuadroDeAcessoController@editaPolicialNoQA');

});

