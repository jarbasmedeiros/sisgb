<?php

namespace Modules\Rh\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\utis\Msg;
use App\utis\Funcoes;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\RhService;
use Modules\Api\Services\MedalhaService;
use Modules\Api\Services\PromocaoService;
use Modules\Api\Services\UnidadeService;
use Modules\Api\Services\SetorService;
use Modules\Api\Services\CargoService;
use Modules\Api\Services\OrgaoService;
use Modules\Api\Services\StatusfuncaoService;
use Modules\Api\Services\FuncaoService;
use Modules\Api\Services\GratificacaoService;
use Modules\Api\Services\GraduacaoService;
use Modules\Api\Services\QpmpService;
use Modules\Api\Services\EscolaridadeService;
use Modules\Api\Services\ArquivoBancoService;
use Modules\Api\Services\DalService;
use Modules\Api\Services\DpsService;
use Modules\Api\Services\PlanoFeriasService;
use Exception;
use Auth;
use App\utis\MyLog;
use Modules\Rh\Entities\StatusFuncao;
use DB;
use FontLib\Table\Type\name;
use Modules\Rh\Entities\Policial;
use Response;
use Modules\Api\Services\MapaForcaService;
use App\Ldap\Authldap;
use App\utis\Status;
use PHPExcel; 
use PHPExcel_IOFactory;



class PolicialController extends Controller{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PromocaoService $PromocaoService, MedalhaService $MedalhaService, PolicialService $PolicialService, RhService $RhService, UnidadeService $UnidadeService, SetorService $SetorService, CargoService $CargoService, OrgaoService $OrgaoService, StatusfuncaoService $StatusfuncaoService, FuncaoService $FuncaoService, GratificacaoService $GratificacaoService, GraduacaoService $GraduacaoService, QpmpService $QpmpService, EscolaridadeService $EscolaridadeService, ArquivoBancoService $ArquivoBancoService, MapaForcaService $MapaForcaService, DalService $DalService, Authldap $Authldap, DpsService $DpsService){
        $this->middleware('auth');
        $this->PolicialService = $PolicialService;
        $this->RhService = $RhService;
        $this->DpsService = $DpsService;
        $this->UnidadeService = $UnidadeService;
        $this->SetorService = $SetorService;
        $this->CargoService = $CargoService;
        $this->OrgaoService = $OrgaoService;
        $this->StatusfuncaoService = $StatusfuncaoService;
        $this->FuncaoService = $FuncaoService;
        $this->GratificacaoService = $GratificacaoService; 
        $this->GraduacaoService = $GraduacaoService;
        $this->QpmpService = $QpmpService;
        $this->EscolaridadeService = $EscolaridadeService;
        $this->MedalhaService = $MedalhaService;
        $this->PromocaoService = $PromocaoService;
        $this->ArquivoBancoService = $ArquivoBancoService;
        $this->MapaForcaService = $MapaForcaService;
        $this->DalService = $DalService;
        $this->Authldap = $Authldap;
        $this->DpsService = $DpsService;
        
    }

    //Autor: @medeiros
    //Busca todo efetivo ativos ou inativos
    //Requer o status 
    //O status deve ser ativo ou inativo 
    public function getEfetivoGeral($renderizacao,$status){        
        $this->authorize('LISTA_EFETIVO_GERAL');
        try {
            $policiais = $this->PolicialService->getEfetivoGeral($renderizacao,$status);
            if($renderizacao == 'listagem'){
                $efetivoGeral = 'efetivoGeral';
                $contador_incial = 0;
                if(method_exists($policiais,'currentPage')){
                    $contador_incial =($policiais->currentPage()-1) * 50;
                }
                return view('rh::policial.ListaPolicial', compact('policiais', 'status', 'contador_incial', 'efetivoGeral'));
                
            }elseif($renderizacao == 'pdf'){
                $nomeTabela = "Lista de Policiais";
                return \PDF::loadView('rh::pdf.ListaPolicialPdf', compact('policiais', 'nomeTabela', 'status'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('lista_policiais.pdf');
            }elseif($renderizacao == 'excel'){
                $nomeTabela = "Lista de Policiais";
                return view('rh::policial.ExportaPolicialexcel', compact('policiais', 'nomeTabela', 'status'));
            }else{
                throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }            
           
       
       
       
       
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
    //Autor: @juanmojica
    //Busca policiais ativos ou inativos
    //Requer o status 
    //O status deve ser ativo ou inativo 
    public function getPoliciaisPorUnidade($status){        
        $this->authorize('Relatorios_rh');
        try {
           
            $unidadesFilhasPolicialLogado = auth()->user()->unidadesvinculadas;

            $policiais = $this->PolicialService->getPoliciaisPorUnidade($status);
            $contador_incial = 0;
            if(method_exists($policiais,'currentPage')){
              $contador_incial =($policiais->currentPage()-1) * 50;
            }
            return view('rh::policial.ListaPolicial', compact('policiais', 'status', 'contador_incial', 'unidadesFilhasPolicialLogado'));
                        
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
    //Autor: @medeiros
    //Busca todos os policiais ativos ou inativos em todas as unidades subordinas
    //Requer o status 
    //O status deve ser ativo ou inativo 
    public function getPoliciaisPorUnidadeEUnidadeSubordinadas($status){        
        $this->authorize('Relatorios_rh');
        try {
           
            $unidadesFilhasPolicialLogado = auth()->user()->unidadesvinculadas;

            $unidadesubordinada = 'unidadesubordinada';
            $policiais = $this->PolicialService->getPoliciaisPorUnidadeEUnidadeSubordinadas($status);
            $contador_incial = 0;
            if(method_exists($policiais,'currentPage')){
              $contador_incial =($policiais->currentPage()-1) * 50;
            }
            return view('rh::policial.ListaPolicial', compact('policiais', 'status', 'unidadesubordinada', 'contador_incial', 'unidadesFilhasPolicialLogado'));
                        
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    //Autor: @juanmojica
    //Busca policiais ativos ou inativos
    //Requer o status e o tipo de renderização
    //O status deve ser ativo ou inativo - A renderização dever ser "listagem", "excel" ou "pdf"
    public function geraPdfExcelPoliciaisPorUnidade($status, $renderizacao){        
        $this->authorize('Relatorios_rh');
        try {
           
            $policiais = $this->PolicialService->geraPdfExcelPoliciaisPorUnidade($status, $renderizacao);
            
            if($renderizacao == 'pdf'){
                $nomeTabela = "Lista de Policiais";
                return \PDF::loadView('rh::pdf.ListaPolicialPdf', compact('policiais', 'nomeTabela', 'status'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('lista_policiais.pdf');
            }elseif($renderizacao == 'excel'){
                $nomeTabela = "Lista de Policiais";
                return view('rh::policial.ExportaPolicialexcel', compact('policiais', 'nomeTabela', 'status'));
            }else{
                throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }            
           
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
    
    //Autor: @juanmojica
    //Busca policiais ativos ou inativos por unidades subordinadas
    //Requer o status e o tipo de renderização
    //O status deve ser ativo ou inativo - A renderização dever ser "listagem", "excel" ou "pdf"
    public function geraPdfExcelPoliciaisPorUnidadeSubordinadas($status, $renderizacao){        
        $this->authorize('Relatorios_rh');
        try {
            $policiais = $this->PolicialService->geraPdfExcelPoliciaisPorUnidadeSubordinadas($status, $renderizacao);
            if($renderizacao == 'pdf'){
                $nomeTabela = "Lista de Policiais";
                return \PDF::loadView('rh::pdf.ListaPolicialPdf', compact('policiais', 'nomeTabela', 'status'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('lista_policiais.pdf');
            }elseif($renderizacao == 'excel'){
                $nomeTabela = "Lista de Policiais";
                return view('rh::policial.ExportaPolicialexcel', compact('policiais', 'nomeTabela', 'status'));
            }else{
                throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }            
           
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
    
    // Busca funcionario por nome, cpf ou matrícula
    public function findPolicialByCpfMatricula($parametro){
        $this->authorize('Leitura');
        //Consulta o policial para Nota de Boletim
        try {
            $policial = $this->PolicialService->findPolicialByCpfMatricula($parametro);
            return response()->json($policial);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
       
    }

    /* 
    Autor: @aggeu. 
    Issue 179 Consultar policial. 
    Função buscar do PolicialController. 
    Ela busca o policial cadastrado por nome, cpf ou matrícula e retorna uma view com o resultado da busca.
    */
    public function buscar(request $parametro){
        $this->authorize('Leitura');
        try {
            
            $unidadesFilhasPolicialLogado = auth()->user()->unidadesvinculadas;
           

            
            $policiais = $this->PolicialService->buscaPolicialNomeCpfMatricula($parametro->busca);
            return view('rh::policial.ListaPolicial', compact('policiais', 'unidadesFilhasPolicialLogado'));              
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //Autor: @medeiros
    //Chama o formulário para Inserir um novo policial no Efetivo da PM
    
    public function formCadastraPolicial(){
        $this->authorize('INSERIR_EFETIVO');
        $permissoes = Auth::user()->permissoes;
        // dd($todas);
        try {
            throw new Exception('Entre em contato com a CTINF via SEI para solicitar o cadastro de novos policiais.');
             /* Selecionando unidades */
             $unidades = $this->UnidadeService->getUnidade();
             /* Selecionando graduacoes */
             $graduacoes = $this->GraduacaoService->getGraduacao();
             /* Selecionando quadros */
             $quadro = $this->QpmpService->getQpmp();
 
             
              /* Selecionando status */
             $status = $this->StatusfuncaoService->getStatus();
              /* Selecionando funcoes */
             $funcao = $this->StatusfuncaoService->getFuncoes();
            return view('rh::policial.Form_cadastraPolicial', compact('unidades','graduacoes', 'quadro', 'funcao', 'status'));              
        } catch (Exception $e) { 
            return redirect('rh/policiais/ativo')->with('erroMsg', $e->getMessage());
        }
    }
    //Autor: @medeiros
    //Chama o formulário para Inserir um novo policial no Efetivo da PM
    
    public function cadastraPolicial(Request $request){
        $dadosForm = $request->all();
        $this->authorize('INSERIR_EFETIVO');
        $permissoes = Auth::user()->permissoes;
        try {
            throw new Exception('Entre em contato com a CTINF via SEI para solicitar o cadastro de novos policiais.');
            // Validando os dados
            $validator = validator($dadosForm, [
                'st_nome' => 'required|max:300',
                'st_cpf' => 'required|max:14',
                'st_nomeguerra' => 'required',
                'dt_incorporacao' => 'required',
                'ce_graduacao' => 'required',
                'ce_unidade' => 'required',
                'ce_status' => 'required',
                'ce_qpmp' => 'required',
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            } 
             /* Selecionando unidades */
             $unidades = $this->UnidadeService->getUnidade();
             /* Selecionando graduacoes */
             $graduacoes = $this->GraduacaoService->getGraduacao();
             /* Selecionando quadros */
             $quadro = $this->QpmpService->getQpmp();
 
             
              /* Selecionando status */
             $status = $this->StatusfuncaoService->getStatus();
              /* Selecionando funcoes */
             $funcao = $this->StatusfuncaoService->getFuncoes();
             $this->PolicialService->cadastraPolicial( $dadosForm);
            //return view('rh::policial.Form_cadastraPolicial', compact('unidades','graduacoes', 'quadro', 'funcao', 'status'));              
            return redirect('rh/policiais/cadastro/novo') ->with('sucessoMsg', MSG::SALVO_SUCESSO);
        } catch (Exception $e) { 
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    //Autor: @juanmojica
    //Busca policial por id para edição
    //Requer o id do policial
    public function formEditaDadosPessoais($idPolicial){
       // $this->authorize('admin');
        $permissoes = Auth::user()->permissoes;
        try {
            try {
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        $policial = $this->PolicialService->findPolicialById($idPolicial);
                    }else{
                        $policial = $this->PolicialService->findPolicialById($idPolicial);
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    $policial = $this->PolicialService->findPolicialById($idPolicial);
                    return view('rh::policial.ExibirDadosPessoais', compact('policial'));              
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                    
                }
                return view('rh::policial.EditaDadosPessoais', compact('policial'));
            
            } catch (Exception $e) {
                if(($e->getMessage() == 'Usuário sem vinculo com a unidade do objeto') && (auth()->user()->can('CONSULTA_QUALQUER _UNIDADE'))){
                    return view('rh::policial.ExibirDadosPessoais', compact('policial'));  
                }else{
                    throw new Exception($e->getMessage()); 
                }
            }
            } catch (Exception $e) {
                return redirect('rh/policiais/ativo')->with('erroMsg', $e->getMessage());
        }
    }

    //Autor: @juanmojica
    //Atualiza dados do policial
    //Requer o id, status e unidade do policial
    public function updateDadosPessoais(Request $request, $idPolicial){
        $this->authorize('Edita_rh');
        try {
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            //dd($dadosForm);
            //Regras para a validação dos dados recebidos do formulário
            $regrasValidacao = [
                'st_nome' => 'required|max:300',
                'dt_nascimento' => 'required|date',
                'st_sexo' => 'required|max:50',
                'st_tiposanguineo' => 'nullable|max:10',
                'st_fatorrh' => 'nullable|max:10',
                'st_naturalidade' => 'required|max:50',
                'st_ufnaturalidade' => 'required|size:2',
                'st_pai' => 'nullable|max:250',
                'st_mae' => 'nullable|max:250',
                'st_altura' => 'nullable',
                'st_cor' => 'nullable',
                'st_olhos' => 'nullable',
                'st_cabelos' => 'nullable',
                'st_estadocivil' => 'nullable|max:50',
                'st_conjuge' => 'nullable|max:300',
                'st_cep' => 'nullable|max:15',
                'st_endereco' => 'nullable|max:250',
                'st_numeroresidencia' => 'nullable|max:10',
                'st_bairro' => 'nullable|max:250',
                'st_cidade' => 'nullable|max:255',
                'st_ufendereco' => 'nullable|max:10',
                'st_complemento' => 'nullable|max:3000',
                'st_telefonefixo' => 'nullable|max:15',
                'st_telefonecelular' => 'nullable|max:15',
                'st_email' => 'nullable|max:255',            
                'st_codigobanco' => 'nullable|max:10',
                'st_banco' => 'nullable|max:50',
                'st_agencia' => 'nullable|max:10',
                'st_conta' => 'nullable|max:20',
            ];
            
            // Validando os dados
            $validator = validator($dadosForm, $regrasValidacao);
            
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            } 
            
            $this->PolicialService->atualizaDadosPessoais($idPolicial, $dadosForm);
            return redirect()->back()->with('sucessoMsg', MSG::ATUALIZADO_SUCESSO);
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg',$e->getMessage());
            }
    }
        
    /* 
    Autor: @aggeu. 
    Issue 184, Editar dados funcionais. 
    A função recupera o policial e suas informaçoes funcionais, retornando as mesmas em uma view. 
    */
    public function form_edita_dados_funcionais($idPolicial){
        $permissoes = Auth::user()->permissoes;

        try{

            $policial = $this->PolicialService->findPolicialById($idPolicial);
            if(!$policial){ /* caso o policial não seja encontrado */
                return redirect()->back()->with('erroMsg', 'Policial não encontrado');
            }
            /* Selecionando unidades */
            $unidades = $this->UnidadeService->getUnidade();
            /* Selecionando graduacoes */
            $graduacoes = $this->GraduacaoService->getGraduacao();
            /* Selecionando quadros */
            $quadro = $this->QpmpService->getQpmp();

            $imagem = null;
            if(isset($policial->foto)){
                $caminhoImagem = $policial->foto->st_pasta . $policial->foto->st_arquivo . '.' . $policial->foto->st_extensao;
                if(Storage::disk('ftp')->exists($caminhoImagem)){ 
                    $img = Storage::disk('ftp')->get($caminhoImagem);
                    $imagem = base64_encode($img); 
                }
            }
            /* Selecionando status */
            $status = $this->StatusfuncaoService->getStatus();
            /* Selecionando funcoes */
            $funcao = $this->StatusfuncaoService->getFuncoes();
            //dd($funcao);
        /*     
            $dadosUsuario = $this->getUnidadesDoUsuario();
            $vagas = $this->MapaForcaService->getInformacoesPorUnidade($dadosUsuario["id"]);
            dd($vagas);
            $result = $vagas;
            dd('ok'); */
           
            /** 
             * Alexia
             * brach:358
             * fluxo para calcular tempo de servico 
             */
            $temp_ini = new DateTime($policial->dt_incorporacao);
          
            //quando inativo
            if($policial->bo_ativo == "0"){
                
               $temp_fim = new DateTime($policial->dt_inatividade);
              //Retorna a diferença entre os dois objetos DateTime
              $tempo = $temp_ini->diff($temp_fim);
            //quando ativo
            }else{
               //data atual
                $atual = date('Y/m/d');
                //converte o tipo para data
                $hj = new DateTime($atual);
               
               //Retorna a diferença entre os dois objetos DateTime
               $tempo= $hj->diff($temp_ini); 
              

            }     
            //formata  o resultado 
            $policial->dt_tempo = $tempo->format('%Y anos, %m meses e %d dias');

            try {
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::policial.Edita_dados_funcionais', compact('policial', 'unidades', 'graduacoes', 'quadro', 'status', 'funcao', 'imagem'));
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::policial.Edita_dados_funcionais', compact('policial', 'unidades', 'graduacoes', 'quadro', 'status', 'funcao', 'imagem' ));
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.Exibir_dados_funcionais', compact('policial', 'unidades', 'graduacoes', 'quadro', 'status', 'funcao', 'imagem'));             
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                }
            } catch (Exception $e) {
              
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.Exibir_dados_funcionais', compact('policial', 'unidades', 'graduacoes', 'quadro', 'status', 'funcao', 'imagem'));
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página'); 
                }
            }
            return view('rh::policial.Edita_dados_funcionais', compact('policial', 'unidades', 'graduacoes', 'quadro', 'status', 'funcao', 'imagem'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @cbAraújo. 
    Issue 184, Editar/Ler Tempo de Serviço. 
    A função recupera o policial e suas informaçoes funcionais, lê ou edita os dados de tempo de serviço. 
    */
    public function form_lista_tempo_servico($idPolicial){
        $this->authorize('admin');
        $permissoes = Auth::user()->permissoes;

        try{
            
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            //dd($policial);
          
            if(!$policial){ // caso o policial não seja encontrado 
                return redirect()->back()->with('erroMsg', 'Policial não encontrado');
            }
            //captura dados do tempo de serviço
            $dadostemposervico = $this->PolicialService->getCertidaoDeTempoDeServico($idPolicial);
            //dd($dadostemposervico);

            try {
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::policial.Edita_tempo_servico', compact('policial','dadostemposervico'));
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::policial.Edita_tempo_servico', compact('policial','dadostemposervico'));
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER_UNIDADE')){
                    return view('rh::policial.Exibir_tempo_servico', compact('policial','dadostemposervico'));             
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                }
            } catch (Exception $e) {
              
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.Exibir_tempo_servico', compact('policial',$dadostemposervico));
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página'); 
                }
            }
            return view('rh::policial.Edita_tempo_servico', compact('policial',$dadostemposervico));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @cb Araújo. Issue 396, salva dados do tempo de serviço
    data: 29-11-2021
    */
    public function formSalvaTempoServico($idPolicial, Request $request){
        $permissoes = Auth::user()->permissoes;
        $dadosForm = $request->all();
        $dadosForm['ce_pessoa'] =  $idPolicial;
        //dd($dadosForm);
        try{            
            $msg = $this->PolicialService->salvaTempoServico($idPolicial, $dadosForm);
            //dd($msg);
            return redirect('rh/policiais/edita/'.$idPolicial.'/tempo_servico')->with('sucessoMsg', $msg);
        } catch (Exception $e) {
            //dd($e->getMessage());
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function formExcluirTempoServico($idPolicial,$idTempoServico, Request $request){
        $permissoes = Auth::user()->permissoes;
        $dadosForm = $request->all();
        $dadosForm['ce_pessoa'] =  $idPolicial;
        //dd($dadosForm);
        //dd($dadosForm);
        try{            
            $msg = $this->PolicialService->excluirTempoServico($idPolicial,$idTempoServico,$dadosForm);
            //dd($msg);
            return redirect('rh/policiais/edita/'.$idPolicial.'/tempo_servico')->with('sucessoMsg', $msg);
        } catch (Exception $e) {
            //dd($e->getMessage());
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    /* 
    Autor: @aggeu. 
    Issue 188, Editar documentos dos policiais. 
    A função recupera o policial e suas informaçoes, retornando as mesmas em uma view. 
    */
    public function formEditaDocumentos($id){
        //$this->authorize('Edita_rh');
        try{
            $permissoes = Auth::user()->permissoes;
            $policial = $this->PolicialService->findPolicialById($id);
            try {
                if( auth()->user()->can('Edita_rh')){
                   
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::policial.EditaDocumentos', compact('policial'));
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::policial.EditaDocumentos', compact('policial'));
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.ExibirDocumentos', compact('policial'));
                   // return view('rh::policial.ExibirDadosPessoais', compact('policial'));              
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                    
                }
                return view('rh::policial.EditaDadosPessoais', compact('policial'));
            
            } catch (Exception $e) {
              
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.ExibirDocumentos', compact('policial'));
                }else{
                    throw new Exception($e->getMessage()); 
                }
            }  
            return view('rh::policial.EditaDocumentos', compact('policial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. 
    Issue 194, implementar aba medalhas. 
    Recupera os objetos policial e medalha e envia para uma view.
    */
    public function listaMedalhasPolicial($id){
        try{
            $permissoes = Auth::user()->permissoes;
            $policial = $this->PolicialService->findPolicialById($id);
            $medalha = $this->MedalhaService->ListaMedalhas($id);
            try {
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::policial.ListaMedalhas', compact('policial', 'medalha'));
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::policial.ListaMedalhas', compact('policial', 'medalha'));
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.Exibir_Medalhas', compact('policial', 'medalha'));
                   // return view('rh::policial.ExibirDadosPessoais', compact('policial'));              
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                    
                }
                return view('rh::policial.ListaMedalhas', compact('policial', 'medalha'));
            
            } catch (Exception $e) {
              
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.Exibir_Medalhas', compact('policial', 'medalha'));
                }else{
                    throw new Exception($e->getMessage()); 
                }
            }  
            return view('rh::policial.ListaMedalhas', compact('policial', 'medalha'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. Issue 193, implementar aba de promoções
    */
    public function listaPromocoesPolicial($idPolicial){
        $permissoes = Auth::user()->permissoes;
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $promocao = $this->PromocaoService->listaPromocoes($idPolicial);
            try {
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::policial.ListaPromocoes', compact('policial', 'promocao'));
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::policial.ListaPromocoes', compact('policial', 'promocao'));
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.ExibirPromocoes', compact('policial', 'promocao'));
                   // return view('rh::policial.ExibirDadosPessoais', compact('policial'));              
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                    
                }
                return view('rh::policial.ListaPromocoes', compact('policial', 'promocao'));
            
            } catch (Exception $e) {
              
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.ExibirPromocoes', compact('policial', 'promocao'));
                }else{
                    throw new Exception($e->getMessage()); 
                }
            }  

            return view('rh::policial.ListaPromocoes', compact('policial', 'promocao'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }    

    /* 
    Autor: @aggeu. 
    Issue 197, crude de medalhas de um policial. 
    Recupera os objetos policial e medalha e envia para uma view.
    */
    public function formEditaMedalha($idPolicial, $idMedalha){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $medalha = $this->MedalhaService->ListaMedalhas($idPolicial);
            return view('rh::policial.EditaMedalha', compact('policial', 'medalha', 'idMedalha'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. Issue 193, implementar aba de promoções
    */
    public function formEditaPromocao($idPolicial, $idPromocao){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $graduacoes = $this->GraduacaoService->getGraduacao();
            $promocao = $this->PromocaoService->recuperaPromocao($idPolicial, $idPromocao);
            return view('rh::policial.EditaPromocao', compact('policial', 'graduacoes', 'promocao'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. 
    Issue 197, crude de medalhas de um policial. 
    */
    public function formCadastraMedalha($idPolicial){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            return view('rh::policial.CadastraMedalha', compact('policial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. Issue 193, implementar aba de promoções
    */
    public function formCadastraPromocao($idPolicial){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $graduacoes = $this->GraduacaoService->getGraduacao();
            return view('rh::policial.CadastraPromocao', compact('policial', 'graduacoes'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. 
    Issue 197, crude de medalhas de um policial. 
    Recupera os objetos policial e medalha e envia para uma view.
    */
    public function editarMedalha(Request $request, $idPolicial, $idMedalha){
        $this->authorize('Edita_rh');
        try{
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'dt_medalha' => 'required',
                'st_tipo' => 'required',
                'st_nome' => 'required',
                'st_publicacao' => 'required',
                'dt_publicacao' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }           
            $this->MedalhaService->atualizaMedalha($idPolicial, $idMedalha, $dadosForm);
            return redirect('rh/policiais/edita/'.$idPolicial.'/dados_medalhas')->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. Issue 193, implementar aba de promoções
    */
    public function editarPromocao(Request $request, $idPolicial, $idMedalha){
        $this->authorize('Edita_rh');
        try{
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_promocao' => 'required',
                'dt_promocao' => 'required',
                'st_boletim' => 'required',
                'dt_boletim' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }           
            $this->PromocaoService->atualizaPromocao($idPolicial, $idMedalha, $dadosForm);
            return redirect('rh/policiais/edita/'.$idPolicial.'/promocoes/listagem')->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }


    /* 
    Autor: @aggeu. 
    Issue 197, crude de medalhas de um policial. 
    Recupera os objetos policial e medalha e envia para uma view.
    */
    public function excluirMedalha($idPolicial, $idMedalha){
        $this->authorize('Edita_rh');
        try{
            $this->MedalhaService->excluiMedalha($idPolicial, $idMedalha);
            return redirect('rh/policiais/edita/'.$idPolicial.'/dados_medalhas')->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /* 
    Autor: @aggeu. Issue 193, implementar aba de promoções
    */
    public function excluirPromocao($idPolicial, $idPromocao){
        $this->authorize('Edita_rh');
        try{
            $this->PromocaoService->excluiPromocao($idPolicial, $idPromocao);
            return redirect('rh/policiais/edita/'.$idPolicial.'/promocoes/listagem')->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. 
    Issue 197, crude de medalhas de um policial. 
    Recupera os objetos policial e medalha e envia para uma view.
    */
    public function cadastrarMedalha(Request $request, $idPolicial){
        $this->authorize('Edita_rh');
        try{
            $dadosForm = $request->all();

            $validator = validator($dadosForm, [
                'dt_medalha' => 'required',
                'st_tipo' => 'required',
                'st_nome' => 'required',
                'st_publicacao' => 'required',
                'dt_publicacao' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $this->MedalhaService->cadastraMedalha($policial->id, $dadosForm);
            return redirect('rh/policiais/edita/'.$idPolicial.'/dados_medalhas')->with('sucessoMsg', Msg::SALVO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. Issue 193, implementar aba de promoções
    */
    public function cadastrarPromocao(Request $request, $idPolicial){
        $this->authorize('Edita_rh');
        try{
            $dadosForm = $request->all();
            //dd($dadosForm);

            $validator = validator($dadosForm, [
                'st_promocao' => 'required',
                'dt_promocao' => 'required',
                'st_boletim' => 'required',
                'dt_boletim' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $this->PromocaoService->cadastraPromocao($policial->id, $dadosForm);
            return redirect('rh/policiais/edita/'.$policial->id.'/promocoes/listagem')->with('sucessoMsg', Msg::SALVO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* 
    Autor: @aggeu. 
    Issue 184, Editar dados funcionais. Refatorado na Issue 211.
    A função atualiza as informaçoes funcionais do policial. 
    */
    public function updateDadosFuncionais(Request $request, $id){
        $this->authorize('Edita_rh');
        try{
            $this->authorize('Edita_rh');
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'ce_graduacao' => 'required|integer',
                'ce_qpmp' => 'required|integer',
            ]);
               
            if($validator->fails())
            {
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $policial =  $this->PolicialService->findPolicialById($id);

            if(isset($request->imagem)){
               PolicialController::cadastraImagemPolicial($request->imagem, $id);
            }

            $atualiza = $this->PolicialService->atualizaPolicialDadosFuncionais($policial, $dadosForm);
            return redirect()->back()->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     //Autor: @juanmojica
    //Busca policial por id para edição
    //Requer o id do policial
    public function formEditaDadosAcademicos($idPolicial){
        try {
            $permissoes = Auth::user()->permissoes;
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $cursos = $this->EscolaridadeService->listaCursosAcademicos($idPolicial);
            
            try {
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::policial.EditaEscolaridade', compact('policial', 'cursos'));  
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::policial.EditaEscolaridade', compact('policial', 'cursos'));  
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.ExibirEscolaridade', compact('policial', 'cursos'));  
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                    
                }
                return view('rh::policial.EditaEscolaridade', compact('policial', 'cursos'));
            
            } catch (Exception $e) {
              
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.ExibirEscolaridade', compact('policial', 'cursos'));  
                }else{
                    throw new Exception($e->getMessage()); 
                }
            }  


            return view('rh::policial.EditaEscolaridade', compact('policial', 'cursos'));              
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
     //Autor: @juanmojica
    //Atualiza a escolaridade do policial
    //Requer o id do policial
    public function updateDadosAcademicos(Request $request, $idPolicial){
        $this->authorize('Edita_rh');
        try {
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'st_escolaridade' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            } 

            $this->PolicialService->atualizaDadosPessoais($idPolicial, $dadosForm);
            return redirect()->back()->with('sucessoMsg', MSG::ATUALIZADO_SUCESSO);

            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }
        /* 
    Autor: @aggeu. 
    Issue 188, Editar documentos dos policiais. 
    A função atualiza os documentos do policial. 
    */
    public function updateDocumentos(Request $request, $id){
        $this->authorize('Edita_rh');
        try{
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados            
            $validator = validator($dadosForm, [
                'st_cpf' => 'required|max:20',
                'st_rgcivil' => 'max:20',
                'st_orgaorgcivil' => 'max:50',
                'st_rgmilitar' => 'required|max:20',
                'st_registrocivil' => 'max:300',
                'st_titulo' => 'max:20',
                'st_zonatitulo' => 'max:20',
                'st_secaotitulo' => 'max:20',
                'st_municipiotitulo' => 'max:200',
                'st_uftitulo' => 'max:2',
                'st_cnh' => 'max:50',
                'st_categoriacnh' => 'max:10',
                'st_ufcnh' => 'max:2',
                'st_carteiratrabalho' => 'max:50',
                'st_seriecarteiratrabalho' => 'max:20',
                'st_ufcarteiratrabalho' => 'max:2',
                'st_pispasep' => 'max:20',
                'st_certificadomilitar' => 'max:50',
                'st_reservista' => 'max:50',
            ]);
               
            if($validator->fails())
            {
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $policial =  $this->PolicialService->findPolicialById($id);

            $atualiza = $this->PolicialService->atualizaPolicialDocumentos($policial, $dadosForm);
            return redirect()->back()->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }


             /* 
    Autor: @medeiros. 
    Lista os cursos do policial. 
    A função recupera o policial e seus cursos que não são acadêmicos, retornando uma lista de curso e o objeto do tiipo policial. 
    */
    public function listaCursosPolicial($idPolicial){
        try{
            $permissoes = Auth::user()->permissoes;
            /* $this->authorize('Edita_rh'); */
            /* Selecionando policial */
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $cursos = $this->PolicialService->listaCursosPolicial($idPolicial);
            try{
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::policial.Lista_cursos', compact('policial', 'cursos'));  
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::policial.Lista_cursos', compact('policial', 'cursos'));  
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.Exibir_cursos', compact('policial', 'cursos'));  
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                    
                }
                return view('rh::policial.Lista_cursos', compact('policial', 'cursos'));
        
            } catch (Exception $e) {
            
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.Exibir_cursos', compact('policial', 'cursos'));  
                }else{
                    throw new Exception($e->getMessage()); 
                }
            }

            return view('rh::policial.Lista_cursos', compact('policial', 'cursos'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*Autor: @medeiros. 
    Lista os cursos do policial. 
    A função recupera o policial e seus cursos que não são acadêmicos, retornando uma lista de curso e o objeto do tiipo policial. 
    */
    public function forCadCurso($idPolicial){
        $this->authorize('Edita_rh');
        try{
            /* $this->authorize('Edita_rh'); */
            /* Selecionando policial */
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            return view('rh::curso.Form_cad_curso', compact('policial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

             /* 
    Autor: @medeiros. 
    Cadastra um curso para um policial. 
    */
    public function cadastrarCurso(Request $request, $idPolicial){
        $this->authorize('Edita_rh');
        try{
           
            $dados =$request->all();

            $validator = validator($dados, [
                'st_categoria' => 'required',
                'st_curso' => 'required',
                'st_boletim'=> 'required',
                'st_instituicao'=> 'required',
                'dt_conclusao'=> 'required',
                'dt_publicacao'=> 'required',
                'st_boletim'=> 'required'
            
            ]);
            
            if($validator->fails()){
               
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }      
             $this->PolicialService->cadastrarCurso($idPolicial,$dados);
           
             if($dados['st_categoria'] == 'ACADEMICO'){
             
                 return redirect('rh/policiais/edita/'.$idPolicial.'/dados_academicos')->with('sucessoMsg', Msg::SALVO_SUCESSO);
                }else{
                  
                    return redirect('rh/policiais/edita/'.$idPolicial.'/cursos')->with('sucessoMsg', Msg::SALVO_SUCESSO);
             }

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }


    /*Autor: @medeiros. 
    Lista os cursos do policial. 
    A função recupera o policial e seus cursos que não são acadêmicos, retornando uma lista de curso e o objeto do tiipo policial. 
    */
    public function formEditaCurso($idPolicial, $idCurso){
        $this->authorize('Edita_rh');
        try{
            /* $this->authorize('Edita_rh'); */
            /* Selecionando policial */
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $curso = $this->PolicialService->findCursoPolicialByid($idPolicial, $idCurso);
            return view('rh::curso.Form_edita_curso', compact('policial', 'curso'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*Autor: @medeiros. 
     Edita um curso do policial. 
    */
    public function EditaCurso($idPolicial, $idCurso, Request $request){
        $this->authorize('Edita_rh');
        try{
            /* $this->authorize('Edita_rh'); */
            /* Selecionando policial */
            $dados = $request->all();
            $this->PolicialService->EditaCurso($idPolicial, $idCurso,$dados);
            if($dados['st_categoria'] == 'ACADEMICO'){
                return redirect('rh/policiais/edita/'.$idPolicial.'/dados_academicos')->with('sucessoMsg', Msg::SALVO_SUCESSO);
               }else{
                   return redirect('rh/policiais/edita/'.$idPolicial.'/cursos')->with('sucessoMsg', Msg::SALVO_SUCESSO);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*Autor: @medeiros. 
     Edita um curso do policial. 
    */
    public function deletaCurso($idPolicial, $idCurso){
        $this->authorize('Edita_rh');
        try{
            /* $this->authorize('Edita_rh'); */
            
            $this->PolicialService->deletaCurso($idPolicial, $idCurso);
            return redirect()->back()->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //Autor: @medeiros
    //Lista as movimentações do policial
    //Requer o id do policial
    public function listaMovimentacoesDoPolicial($idPolicial){
        $this->authorize('Edita_rh');
        try {
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $movimentacoes = $this->PolicialService->listaMovimentacoesDoPolicial($idPolicial);
            return view('rh::policial.ListaMovimentacoes', compact('policial', 'movimentacoes'));              
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //Autor: @cbAraujo
    //Lista as movimentações do policial no prontuario
    //Requer o id do policial
    public function listaMovimentacoesProntuario($idPolicial){
        try {
            if (auth()->user()->can('Edita_rh') || auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')) {
                $policial = $this->PolicialService->findPolicialById($idPolicial);
                $movimentacoes = $this->PolicialService->listaMovimentacoesDoPolicial($idPolicial);
                
                $unidades = $this->UnidadeService->getUnidade();
                
                return view('rh::policial.ListaMovimentacoesProntuario', compact('policial', 'movimentacoes','unidades'));
            } else {
                throw new Exception('O seu perfil de Usuário não tem permissão para exibir a aba Movimentações!');
            }
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     /*Autor: @medeiros. 
    Abre o formulário para cadastrar uma nova movimentação de policial
    Busca um objeto policial pelo ID e passa esse objeto para a view de cadastro
    */
    public function formCadMovimentacao($idPolicial){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $unidades = $this->UnidadeService->getUnidade();
            return view('rh::policial.FormCadMovimentacoes', compact('policial', 'unidades'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    /*Autor: @medeiros. 
    Cadastra uma nova publicação do policial
    */
    public function cadastraMovimentacao(Request $request, $idPolicial){
        $this->authorize('Edita_rh');
        //dd($request);
        try{
            $dados =$request->all();
            $validator = validator($dados, [
                'dt_movimentacao' => 'required',
                'st_publicacao' => 'required|max:50',
                'dt_publicacao' => 'required',
                'ce_unidadeorigem' => 'required',
                'ce_unidadedestino' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }             
          
            $this->PolicialService->cadastraMovimentacao($idPolicial, $dados);

            //return redirect('rh/policiais/'.$idPolicial.'/movimentacoes')->with('sucessoMsg', Msg::SALVO_SUCESSO);
            return redirect('rh/policiais/'.$idPolicial.'/movimentacoes/listagem')->with('sucessoMsg', Msg::SALVO_SUCESSO);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

     /*Autor: @juanmojica. 
    Abre o formulário para editar uma nova publicação
    Busca um objeto policial e um objeto publicação, ambos pelos IDs e passam esses objetos para a view de edição
    */
    public function formEditaMovimentacao($idPolicial, $idMovimentacao){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $movimentacao = $this->PolicialService->findMovimentacaoPolicialByid($idMovimentacao);
            $unidades = $this->UnidadeService->getUnidade();

            return view('rh::policial.FormEditaMovimentacao', compact('policial', 'movimentacao', 'unidades'));

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    

     /*Autor: @medeiros. 
     Edita uma movimentação  policial. 
    */
    public function editaMovimentacao($idpolicial, $idMovimentacao, Request $request){
        //dd($request);
        $this->authorize('Edita_rh');
        try{
            $this->authorize('Edita_rh'); 
            $dados = $request->all();
            $validator = validator($dados, [
                'dt_movimentacao' => 'required',
                'st_publicacao' => 'required|max:50',
                'dt_publicacao' => 'required',
                'ce_unidadeorigem' => 'required',
                'ce_unidadedestino' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }  
         
            $this->PolicialService->editaMovimentacao($idpolicial, $idMovimentacao, $dados);

            return redirect('rh/policiais/'.$idpolicial.'/movimentacoes/listagem')->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
     /*Autor: @medeiros. 
     Edita uma movimentação  policial. 
    */
    public function excluiMovimentacao($idpolicial, $idMovimentacao){
        $this->authorize('Edita_rh');
        try{
            $this->authorize('Edita_rh'); 
            $this->PolicialService->excluiMovimentacao($idpolicial, $idMovimentacao);

            return redirect('rh/policiais/'.$idpolicial.'/movimentacoes/listagem')->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //Autor: @juanmojica
    //Lista as publicações do policial
    //Requer o id do policial
    public function listaPublicacoesDoPolicial($idPolicial){
        $permissoes = Auth::user()->permissoes;
        try {
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $publicacoes = $this->PolicialService->listaPublicacoesDoPolicial($idPolicial);
            
            try{
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::policial.ListaPublicacoes', compact('policial', 'publicacoes'));   
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::policial.ListaPublicacoes', compact('policial', 'publicacoes'));   
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.ExibirPublicacoes', compact('policial', 'publicacoes'));  
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                    
                }
                return view('rh::policial.ListaPublicacoes', compact('policial', 'publicacoes')); 
        
            } catch (Exception $e) {
            
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::policial.ListaPublicacoes', compact('policial', 'publicacoes'));   
                }else{
                    throw new Exception($e->getMessage()); 
                }
            }
            return view('rh::policial.ListaPublicacoes', compact('policial', 'publicacoes'));              
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    //Autor: @Medeiros
    //Lista as publicações reservadas do policial
    //Requer o id do policial
    public function listaPublicacoesReservadasDoPolicial($idPolicial){
        $this->authorize('PUBLICACOES_RESERVADAS');
        try {
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $publicacoes = $this->PolicialService->listaPublicacoesDoPolicial($idPolicial);
            return view('rh::policial.ListaPublicacoesReservadasDoPolicial', compact('policial', 'publicacoes'));              
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    
    /*Autor: @juanmojica. 
    Abre o formulário para cadastrar uma nova publicação
    Busca um objeto policial pelo ID e passa esse objeto para a view de cadastro
    */
    public function formCadPublicacao($idPolicial){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            return view('rh::policial.FormCadPublicacoes', compact('policial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*Autor: @juanmojica. 
    Cadastra uma nova publicação do policial
    */
    public function cadastraPublicacao(Request $request, $idPolicial){
        $this->authorize('Edita_rh');
        try{
            $this->authorize('Edita_rh');
            $dados =$request->all();
            $validator = validator($dados, [
                'st_assunto' => 'required',
                'st_boletim' => 'required',
                'dt_publicacao' => 'required',
                'st_comportamento' => 'required',
                'st_materia' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }             
          
            $this->PolicialService->cadastraPublicacao($idPolicial, $dados);

            return redirect('rh/policiais/'.$idPolicial.'/publicacoes/listagem')->with('sucessoMsg', Msg::SALVO_SUCESSO);
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    /*Autor: @juanmojica. 
    Abre o formulário para editar uma nova publicação
    Busca um objeto policial e um objeto publicação, ambos pelos IDs e passam esses objetos para a view de edição
    */
    public function formEditaPublicacao($idPolicial, $idPublicacao){
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $publicacao = $this->PolicialService->findPublicacaoById($idPolicial, $idPublicacao);

            return view('rh::policial.FormEditaPublicacao', compact('policial', 'publicacao'));

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*Autor: @juanmojica. 
     Edita uma Publicação do policial. 
    */
    public function editaPublicacao($idPolicial, $idPublicacao, Request $request){
        $this->authorize('Edita_rh');
        try{
            $permissoes = Auth::user()->permissoes;
            $dados = $request->all();

            $validator = validator($dados, [
                'st_assunto' => 'required',
                'st_boletim' => 'required',
                'dt_publicacao' => 'required',
                'st_comportamento' => 'required',
                'st_materia' => 'required'
            ]);
            $policial = $this->PolicialService->findPolicialById($idPolicial);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if( in_array('qualquerUnidade',$permissoes)){
                $this->PolicialService->editaPublicacao($idPolicial, $idPublicacao, $dados);  
            }else{
                Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                $this->PolicialService->editaPublicacao($idPolicial, $idPublicacao, $dados);
            }           
          

            return redirect('rh/policiais/'.$idPolicial.'/publicacoes/listagem')->with('sucessoMsg', Msg::SALVO_SUCESSO);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*Autor: @juanmojica. 
     Deleta uma publicação do policial. 
    */
    public function deletaPublicacao($idPolicial, $idPublicacao){
        $this->authorize('Edita_rh');
        try{        
            $this->authorize('Deleta');
            $this->PolicialService->deletaPublicacao($idPolicial, $idPublicacao);

            return redirect()->back()->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //Autor: @juanmojica
    //Lista na view os policias de férias ativas
    public function listaFeriasAtivas(){     
        dd('ok');   
        $this->authorize('Relatorios_rh');
        try {

            $ferias = $this->PolicialService->listaFeriasAtivas();

            return view('rh::ferias.ListaFeriasAtivas', compact('ferias')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

   

    /* Autor: @aggeu. Issue 201, Listar Licenças Ativas por unidade. */
    public function listaLicencasAtivas(){        
        $this->authorize('Relatorios_rh');
        try {
            $policial = auth()->user();
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $unidaeService = new UnidadeService();
            $unidades = $unidaeService->getunidadesfilhasNome($policial->ce_unidade);
            $licencas = $this->PolicialService->listaLicencasAtivas();
            return view('rh::licenca.listaLicencasAtivas', compact('licencas', 'unidades')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
    /* Autor: @medeiros. Issue 289, Listar Licenças Ativas por unidades subordinadas. */
    public function listaLicencaPorUnidadeEperiodo(Request $request, $renderizacao){        
        $this->authorize('Relatorios_rh');
        try {
            $dados = $request->all();
            $policial = auth()->user();
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $unidaeService = new UnidadeService();
            $unidades = $unidaeService->getunidadesfilhasNome($policial->ce_unidade);
            if($dados['ce_unidade'][0] == 'subordinadas'){
                $unidadesSubordinadas = $unidaeService->getunidadesfilhas($policial->ce_unidade);
                $dados['ce_unidade'] = $unidadesSubordinadas;
            }
            $licencas = $this->PolicialService->listaLicencaPorUnidadeEperiodo($dados,  $renderizacao);
            $contador_incial = 0;
            if(method_exists($licencas,'currentPage')){
                $contador_incial =($licencas->currentPage()-1) * 50;
            }
            if( $renderizacao == 'paginado'){
                return view('rh::licenca.listaLicencasAtivas', compact('licencas', 'unidades', 'contador_incial', 'dados')); 

            }elseif($renderizacao == 'excel'){
                $nomeTabela = "Lista de Policiais de Licenças";
                    return view('rh::excel.ExportaLicencasAtivasExcel', compact('licencas', 'nomeTabela'));
            }elseif($renderizacao == 'pdf'){

                $nomeTabela = "Lista de Policiais de Licenças";
                return \PDF::loadView('rh::pdf.ExportaLicencasAtivasPdf', compact('licencas', 'nomeTabela'));
            }else{
                throw new Exception('Parâmetro de renderização inválido.'); 
            }

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /* Autor: @aggeu. Issue 207, Implementar listagem de ferias e licença para os proximos quinze dias (Tela home). */
    public function listaFeriasLicencas15Dias(){        
        $this->authorize('Leitura');
        try {
            
            $unidades = $this->UnidadeService->getUnidade();
            $feriaslicencas = $this->PolicialService->listaLFeriasLicencas15Dias($unidades->id);

            return view('rh::home', compact('feriaslicencas')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    //Autor: @juanmojica
    //Lista os policias de férias ativas
    //A renderização dever ser "listagem", "excel" ou "pdf"
    public function geraPdfExcelFeriasAtivas($renderizacao){ 
        $this->authorize('Relatorios_rh');  
        
        try {
          
            $ferias = $this->PolicialService->geraPdfExcelFeriasAtivas($renderizacao);
            
            if($renderizacao == 'pdf'){
                $nomeTabela = "Lista de Policiais de Férias";
                return \PDF::loadView('rh::pdf.ListaFeriasAtivasPdf', compact('ferias', 'nomeTabela'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('lista_policiais_de_ferias.pdf');
            }elseif($renderizacao == 'excel'){
                $nomeTabela = "Lista de Policiais de Férias";
                return view('rh::ferias.ExportaFeriasAtivasExcel', compact('ferias', 'nomeTabela'));
            }else{
                throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }            
           
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /* Autor: @aggeu. Issue 201, Listar Licenças Ativas por unidade. */
    public function geraPdfExcelLicencasAtivas($renderizacao){        
        $this->authorize('Relatorios_rh');  
        try {
          
            $licencas = $this->PolicialService->geraPdfExcelLicencasAtivas($renderizacao);
            if($renderizacao == 'pdf'){
                $nomeTabela = "Lista de Policiais de Licenças";
                return \PDF::loadView('rh::pdf.ExportaLicencasAtivasPdf', compact('licencas', 'nomeTabela'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('lista_policiais_de_licencas.pdf');
            }elseif($renderizacao == 'excel'){
                $nomeTabela = "Lista de Policiais de Licenças";
                return view('rh::excel.ExportaLicencasAtivasExcel', compact('licencas', 'nomeTabela'));
            }else{
                throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }            
           
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

     /* autor: @juanmojica 
       Gera Caderneta de Registro de um policial em pdf 
       Requer o id do policial*/
       public function geraCadernetaDeRegistroPdf($idPolicial){
        $this->authorize('Leitura');  
        try {

            $permissoes = Auth::user()->permissoes;
            $unidadesVinculadas = Auth::user()->unidadesvinculadas;
            $cadernetaRegistro = $this->PolicialService->geraCadernetaDeRegistroPdf($idPolicial);
            
            
              
            $imagem = null;
            if(isset($cadernetaRegistro->qualificacao->foto)){
                $caminhoImagem = $cadernetaRegistro->qualificacao->foto->st_pasta . $cadernetaRegistro->qualificacao->foto->st_arquivo . '.' . $cadernetaRegistro->qualificacao->foto->st_extensao;
                if(Storage::disk('ftp')->exists($caminhoImagem)){ 
                    $img = Storage::disk('ftp')->get($caminhoImagem);
                    $imagem = base64_encode($img); 
                } 
            }

            $nomeTabela = "Caderneta de Registros do Policial";

            
            if($cadernetaRegistro->qualificacao->st_cpf ==  preg_replace("/\D+/", "", Auth::user()->st_cpf)){
                // Se o usuário logado for o mesmo que ficha que será exibida
                return \PDF::loadView('rh::pdf.CadernetaRegistroPdf', compact('cadernetaRegistro', 'nomeTabela', 'imagem'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('caderneta_de_registros.pdf');
            }elseif( in_array('qualquerUnidade',$permissoes)){
                //Se o usário tiver a permissão me qualquer unidade e tiver a permissão consultar ficha
                $this->authorize('Consulta_ficha');
                return \PDF::loadView('rh::pdf.CadernetaRegistroPdf', compact('cadernetaRegistro', 'nomeTabela', 'imagem'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('caderneta_de_registros.pdf');
            }elseif (auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                //Se o usário tiver a permissão me qualquer unidade e tiver a permissão consultar ficha
                return \PDF::loadView('rh::pdf.CadernetaRegistroPdf', compact('cadernetaRegistro', 'nomeTabela', 'imagem'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('caderneta_de_registros.pdf');

            }else{
                //Se o usário tiver a permissão de edição no RH e estiver vinculado a unidade do policial
                $this->authorize('Edita_rh');
                Funcoes:: verificaVinculoDoUsuarioComUnidade( $cadernetaRegistro->qualificacao->ce_unidade);
                return \PDF::loadView('rh::pdf.CadernetaRegistroPdf', compact('cadernetaRegistro', 'nomeTabela', 'imagem'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('caderneta_de_registros.pdf');

            }
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
     /* autor: @medeiros 
       Gera Ficha disciplinar de um policial 
       Requer o id do policial*/
       public function geraFichaDisciplinar($idPolicial){
        $this->authorize('Leitura');  
        try {
            
            $permissoes = Auth::user()->permissoes;
            $unidadesVinculadas = Auth::user()->unidadesvinculadas;
            $fichaDisciplinar = $this->PolicialService->geraFichaDisciplinar($idPolicial);
            $imagem = null;
            if(isset($fichaDisciplinar->qualificacao->foto)){
                
                $caminhoImagem = $fichaDisciplinar->qualificacao->foto->st_pasta . $fichaDisciplinar->qualificacao->foto->st_arquivo . '.' . $fichaDisciplinar->qualificacao->foto->st_extensao;
                if(Storage::disk('ftp')->exists($caminhoImagem)){ 
                    $img = Storage::disk('ftp')->get($caminhoImagem);
                $imagem = base64_encode($img); 
                }
                
            }
           $nomeTabela = 'Ficha Dsiciplinar';
            
            if($fichaDisciplinar->qualificacao->st_cpf ==  preg_replace("/\D+/", "", Auth::user()->st_cpf)){
                // Se o usuário logado for o mesmo que ficha que será exibida
                //return view('rh::pdf.FichaDisciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
                return view('rh::pdf.FichaDisciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
            }elseif( in_array('qualquerUnidade',$permissoes)){

                //Se o usário tiver a permissão me qualquer unidade e tiver a permissão consultar ficha
                $this->authorize('Consulta_ficha');
               // return view('rh::pdf.FichaDisciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
               return view('rh::pdf.FichaDisciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
            }elseif (auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                //Se o usário tiver a permissão me qualquer unidade e tiver a permissão consultar ficha
                return view('rh::pdf.FichaDisciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));

            }else{
                //Se o usário tiver a permissão de edição no RH e estiver vinculado a unidade do policial
                $this->authorize('Edita_rh');
                Funcoes:: verificaVinculoDoUsuarioComUnidade( $fichaDisciplinar->qualificacao->ce_unidade);
                return \PDF::loadView('rh::pdf.FichaDisciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                ->stream('FichaDisciplinar.pdf');

            }
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* @autor: juanmojica
       Lista os arquivos anexados ao cadastro do polical 
     */
    public function listaArquivos($idPolicial){
        $this->authorize('Edita_rh');  
        try {
            
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $arquivos = $this->ArquivoBancoService->listaArquivos($idPolicial, "RH");
            return view('rh::policial.ListaArquivos', compact('policial', 'arquivos'));
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    /* @autor: juanmojica
       Cadastra um arquivo para um policial 
     */
    public function cadastraArquivo(Request $request, $idPolicial){
        $this->authorize('Edita_rh');  
        try {
            // Validação do envio do arquivo
            if(isset($request->arquivo)){
                $arquivo = $request->arquivo;
                //verifica se o arquivo é válido
                $nomeArquivo = $arquivo->getClientOriginalName();
                if($arquivo->isValid()){ 
                    $extensao = $arquivo->getClientOriginalExtension();
                    //verifica se é pdf
                    if($extensao != 'pdf'){ 
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload. O arquivo a ser enviado deve está em formato PDF.');
                    }elseif($arquivo->getClientSize() > 1000000){
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo "'.$nomeArquivo.'" excede o tamanho de 512 KB.');
                    }
                    $policial = $this->PolicialService->findPolicialById($idPolicial);
                    $caminho_armazenamento = "RH"."/".str_replace(" ", "", $policial->st_cpf)."/";
                    try{
                        //testa se existe o diretorio do funcionario
                        if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                            //creates directory
                            Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                        }
                        //gera hash a partir do arquivo
                        $hashNome = hash_file('md5', $arquivo); 
                        //novo nome do arquivo com base no hash
                        $novoNome = $hashNome.'.'.$extensao; 
                        //checa se o arquivo ja existe
                        if(!Storage::disk('ftp')->exists($caminho_armazenamento.$novoNome)){ 
                            //salva o arquivo no banco
                            $dadosForm = [
                                'st_modulo' => 'RH',
                                'st_motivo' => 'ANEXO_POLICIAL',
                                'dt_envio' => date('Y-d-m H:i:s'),
                                'st_arquivo' => $hashNome,
                                'st_extensao' => $extensao,
                                'st_descricao' => $request->st_descricao,
                                'st_pasta' => $caminho_armazenamento,
                            ];
                            //salva arquivo no ftp
                            $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                            if($salvouNoFtp){
                                //salva dados do arquivo no banco
                                $this->ArquivoBancoService->createArquivo($idPolicial, $dadosForm);
                            }else{
                                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, erro na base de dados de arquivos.');
                            }

                            return redirect('rh/policiais/'.$idPolicial.'/arquivo/listagem')->with('sucessoMsg', Msg::SALVO_SUCESSO);

                        }else{
                            return redirect()->back()->with('erroMsg', "Esse arquivo já está cadastrado para este policial com o nome: ". $nomeArquivo);
                        }
                    }catch(Exception $e){
                        return redirect()->back()->with('erroMsg', $e->getMessage());
                    }
                }else{
                    return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload do arquivo "'.$nomeArquivo.'", verifique se ele não está corrompido ou o seu tamanho excede 512 KB.');
                }
            }else{
                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo não é válido.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    /* @author: Juan Mojica 
     * Exclui um arquivo de um Policial 
     */
       public function deletaArquivo($idPolicial, $idArquivo)
       {
        $this->authorize('Edita_rh');  
           try {
                // Recupera o arquivo pelo id
               $arquivo = $this->ArquivoBancoService->getArquivoId($idArquivo, $idPolicial);
               if(!isset($arquivo)){
                   throw new Exception(Msg::ARQUIVO_NAO_ENCONTRADO);
               }
               $caminho = $arquivo->st_pasta . $arquivo->st_arquivo . '.' . $arquivo->st_extensao;
               if(Storage::disk('ftp')->exists($caminho)){
                    // Exclui do FTP
                    $deletouNoFtp = Storage::disk('ftp')->delete($caminho); 
                    if($deletouNoFtp){
                        // Exclui do banco
                        $arquivoDelete = $this->ArquivoBancoService->deleteArquivo($idArquivo, $idPolicial);
                    }else{
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar a exlusão, erro na base de dados de arquivos.');    
                    }               
                   // Chama a view para listar os arquivos do policial
                   return redirect('rh/policiais/'.$idPolicial.'/arquivo/listagem')->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
               }else{
                return redirect()->back()->with('erroMsg', Msg::ARQUIVO_NAO_ENCONTRADO);
               }
           } catch(Exception $e){
               return redirect()->back()->with('erroMsg', $e->getMessage());
           }
       }

    /**
     * Método que realiza o download do arquivo.
     * @autor: Juan Mojica
     * @return Response
     */
    public function downloadArquivo($idPolicial, $idArquivo)
    {
        $this->authorize('Edita_rh');  
        try {
            $arquivo = $this->ArquivoBancoService->getArquivoId($idArquivo, $idPolicial);
            if(!isset($arquivo)){
                return redirect()->back()->with('erroMsg', Msg::ARQUIVO_NAO_ENCONTRADO);
            }
            $caminho = $arquivo->st_pasta . $arquivo->st_arquivo . '.' . $arquivo->st_extensao;
            if(Storage::disk('ftp')->exists($caminho)){
                return Storage::disk('ftp')->download($caminho);
            }else{
                return redirect()->back()->with('erroMsg', Msg::ARQUIVO_NAO_ENCONTRADO);
            }
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* @autor: Juan Mojica
    *  Cadastra a imagem de um policial nos dados funcionais      
    */ 
    public function cadastraImagemPolicial($imagem, $idPolicial){
        try {
            $this->authorize('Edita_rh');  
            //verifica se o arquivo é válido
            if($imagem->isValid()){ 
                $extensao = $imagem->getClientOriginalExtension();
                //verifica se é pdf
                if($extensao != 'png' && $extensao != 'jpeg' && $extensao != 'jpg'){ 
                    return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload. A imagem a ser cadastrada deve está em formato PNG, JPEG ou JPG.');
                }elseif($imagem->getClientSize() > 2048000){
                    return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload. A imagem excede o tamanho de 2 MB.');
                }
                $policial = $this->PolicialService->findPolicialById($idPolicial);
                $caminho_armazenamento = 'RH/' . str_replace(" ", "", $policial->st_cpf) . '/Imagens/FotoFicha/';
                 //nome do arquivo com a matrícula do policial
                 $nomeImagem = str_replace(" ", "", $policial->st_matricula); 
                try{
                    //testa se existe o diretorio do funcionario
                    if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                        //creates directory
                        Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                    }
                    if(Storage::disk('ftp')->exists($caminho_armazenamento.$nomeImagem . '.jpeg')){
                        Storage::disk('ftp')->delete($caminho_armazenamento.$nomeImagem . '.jpeg');
                    }
                    if(Storage::disk('ftp')->exists($caminho_armazenamento.$nomeImagem . '.png')){
                        Storage::disk('ftp')->delete($caminho_armazenamento.$nomeImagem . '.png');
                    } 
                    if(Storage::disk('ftp')->exists($caminho_armazenamento.$nomeImagem . '.jpg')){
                        Storage::disk('ftp')->delete($caminho_armazenamento.$nomeImagem . '.jpg');
                    }  
                             
                    //povoa os atributos a serem salvos no banco
                    $dadosForm = [
                        'st_modulo' => 'RH_FOTO',
                        'st_motivo' => 'FOTO_POLICIAL',
                        'dt_envio' => date('Y-d-m H:i:s'),
                        'st_arquivo' => $nomeImagem,
                        'st_extensao' => $extensao,
                        'st_descricao' => 'foto do policial',
                        'st_pasta' => $caminho_armazenamento
                    ];
                    //salva arquivo no ftp
                    $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$nomeImagem.'.'.$extensao, fopen( $imagem, 'r+')); 
                    if($salvouNoFtp){
                        if(isset($policial->foto)){
                            //atualiza dados do arquivo no banco
                            $this->ArquivoBancoService->updateArquivo($policial->foto->id, $policial->id, $dadosForm); 
                        }else{
                            //salva dados do arquivo no banco
                            $this->ArquivoBancoService->createArquivo($idPolicial, $dadosForm);
                        }
                        
                    }else{
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload da imagem. Erro na base de dados de arquivos.');
                    }
                }catch(Exception $e){
                    throw new Exception($e->getMessage());
                }
            }else{
                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo não é válido.');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }
     //Autor: @Medeiros
    //Lista na view as férias dos policiais da unidade do policial logado
    public function listaMedalhaUnidade(){      
        $this->authorize('Relatorios_rh');
        try {
            $policial = auth()->user();
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $unidadeService = new UnidadeService();
            $unidades = $this->UnidadeService->getunidadesfilhasNome($policial->ce_unidade);
            $medalhas = $this->PolicialService->listaMedalhasPorUnidade();

            $contador_incial = 0;
            if(method_exists($medalhas,'currentPage')){
                $contador_incial =($medalhas->currentPage()-1) * 30;
            }

            return view('rh::policial.ListaMedalhas_por_unidade', compact('medalhas', 'unidades', 'contador_incial')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

     //Autor: @Medeiros
    //Retorna a view com a lista de fichas
    public function listaFichas($idPolicial){      
        $this->authorize('Consulta_ficha');
        try {
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            //invoca o serviço para buscar as assinaturas da certidão de tempo de serviço do policial
            $regrasFichas = $this->PolicialService->getRegrasFichas($idPolicial);
            return view('rh::policial.ListaFichas', compact('policial', 'regrasFichas')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }


   //Autor: @Medeiros
    //Lista na view os policiais que teem medalhas por unidade 
    public function listaMedalhasPorVariasUnidades(Request $request, $renderizacao){      
        $this->authorize('Relatorios_rh');
        try {
            $dados = $request->all();
            $ce_unidadeTemp = $dados['ce_unidade'];
            // Validando os dados
            $validator = validator($dados, [
                "ce_unidade" => "required"
                ]);
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->with('erroMsg', 'Escolha pelo menos uma unidade operacional.');  
            }  
            
            $policial = auth()->user();
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            
            $unidadeService = new UnidadeService();
            if($dados['ce_unidade'][0] == 'subordinadas'){
                $unidadesSubordinadas = $unidadeService->getunidadesfilhas($policial->ce_unidade);
                $dados['ce_unidade'] = $unidadesSubordinadas;
            }else{
                $unidadesSubordinadas = $unidadeService->getunidadesfilhas($dados['ce_unidade'][0]);
                $dados['ce_unidade'] = $unidadesSubordinadas;
            }
            $unidades = $unidadeService->getunidadesfilhasNome($policial->ce_unidade);
            $medalhas = $this->PolicialService->listaMedalhasPorVariasUnidades($dados, $renderizacao);
            $contador_incial = 0;
            if(method_exists($medalhas,'currentPage')){
                $contador_incial =($medalhas->currentPage()-1) * 30;
            }
            
            $dados['ce_unidade'] =  $ce_unidadeTemp;

            if($renderizacao == 'excel'){
                return view('rh::relatorio.ListaMedalhas_por_unidade_excel', compact('medalhas')); 
            }
        return view('rh::policial.ListaMedalhas_por_unidade', compact('medalhas', 'unidades', 'dados', 'contador_incial')); 

        } catch (Exception $e) {
            return redirect('rh/relatorios/medalhas/unidade')->with('erroMsg', $e->getMessage());  
        }
    }
    //Autor:@carlos_alberto
    //Situação do efetivo
    private function getUnidadesDoUsuario(){
        $unidadesViculadas = Auth()->user()->unidadesvinculadas;
        $dadosUsuario = $unidadesViculadas[count($unidadesViculadas)-1];
        //dd(Auth()->user()->name);
        $dadosUsuario["name"] = Auth()->user()->name;
        return $dadosUsuario;
    }



     // author: alexia tuane
    //issue: 317 - criar sumario e lista policiais por unidade

public function PoliciaisPorUnidade(Request $request){
    try {
        $dados = $request->all();
        $policial = auth()->user();
        //$unidaeService = new UnidadeService();
        $unidades = $this->UnidadeService->getunidadesfilhasNome($policial->ce_unidade);
        if(empty($policial->ce_unidade)){
            throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
        }
       
        if(isset($dados['ce_unidade'])){
            $idUnidade = $dados['ce_unidade'];
        }else{
            $idUnidade = $policial->ce_unidade; 
        }
        $policiaisagrupados = $this->PolicialService->PoliciaisPorUnidade($idUnidade);
        return view('rh::policial.PoliciaisPorUnidade', compact('policiaisagrupados', 'idUnidade', 'unidades')); 
    } catch (Exception $e) { 
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }        
}

public function ListaPoliciaisPorUnidade($idGraduacao, $idUnidade, $renderizacao){
    try {
        
     $this->authorize('Relatorios_rh');
     $status = 'ativo';
     $policiais  = $this->PolicialService->ListaPoliciaisPorUnidade($idGraduacao, $idUnidade);

        if($renderizacao == 'listagem'){
            $nomeTabela = "Lista de Policiais";
            $PoliciaisPorUnidade = 'PoliciaisPorUnidade';
            $PoliciaisPorUnidadePDF = "PoliciaisPorUnidadePDF";
            return view('rh::policial.ListaPolicial', compact('policiais', 'idUnidade', 'status','PoliciaisPorUnidade', 'idGraduacao','PoliciaisPorUnidadePDF')); 
        }
        elseif($renderizacao == 'pdf'){
            $nomeTabela = "Lista de Policiais";
            $PoliciaisPorUnidadePDF = "PoliciaisPorUnidadePDF";
            return \PDF::loadView('rh::pdf.ListaPolicialPdf', compact('policiais', 'idUnidade', 'status','PoliciaisPorUnidadePDF', 'nomeTabela'))
            ->stream('lista_policiais.pdf');
        }
        elseif($renderizacao == 'excel'){
            $nomeTabela = "Lista de Policiais";
            $PoliciaisPorUnidade = 'PoliciaisPorUnidade';
            return view('rh::policial.ExportaPolicialexcel', compact('policiais', 'idUnidade','status', 'PoliciaisPorUnidade', 'nomeTabela'));
            }
        else{
            throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            } 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }

public function getPolicialUnidadeEUnidadeSubordinadasPerfis($renderizacao, Request $request){
    try {
        $this->authorize('Relatorios_rh');
        $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
        $policial = $this->PolicialService->findPolicialByCpfMatricula( $cpf);
        if(empty($policial)){
            throw new Exception('O usuaário logado não é um policial ativo.');
        }
       $dadosForm = $request->all();
       if(isset( $dadosForm['ce_unidade'])){
           $idUnidade =  $dadosForm['ce_unidade'];
       }else{
          
               $idUnidade = $policial->ce_unidade;
       }
        $unidade = new UnidadeSErvice();
        $unidadesFilhas = $unidade->getunidadesfilhasNome($policial->ce_unidade);
    
     $policiais  = $this->PolicialService->getPolicialUnidadeEUnidadeSubordinadasPerfis($idUnidade);
     //return view('rh::policial.ListaPolicialPerfil', compact('policiais')); 

        if($renderizacao == 'listagem'){
            $nomeTabela = "Lista de Policiais";
            $PoliciaisPorUnidade = 'PoliciaisPorUnidade';
            $PoliciaisPorUnidadePDF = "PoliciaisPorUnidadePDF";
            return view('rh::policial.ListaPolicialPerfil', compact('policiais', 'unidadesFilhas', 'idUnidade')); 

        }
        elseif($renderizacao == 'pdf'){
            $nomeTabela = "Lista de Policiais";
            $PoliciaisPorUnidadePDF = "PoliciaisPorUnidadePDF";
            return \PDF::loadView('rh::policial.ListaPolicialPerfilPdf', compact('policiais'))
            ->stream('lista_policiais.pdf');
        }
        elseif($renderizacao == 'excel'){
            $nomeTabela = "Lista de Policiais";
            $PoliciaisPorUnidade = 'PoliciaisPorUnidade';
            return view('rh::policial.ExportaPolicialexcel', compact('policiais', 'idUnidade','status', 'PoliciaisPorUnidade', 'nomeTabela'));
            }
        else{
            throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            } 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }

    /**  
    * @author: @juanmojica. Issue 342 - implementar tela de cadastrar tela dados do fardamento
    * Método para buscar os fardamentos do policial 
    */
    public function getFardamentos($renderizacao){
        try {
            //Verifica se a requisição veio de "Meus Fardamentos"
            if ($renderizacao == 'meus_fardamentos') {
                $this->authorize('Leitura');
                $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
                $policial = $this->PolicialService->findPolicialByCpfMatricula( $cpf);
                //Verifa se o CPF do policial logado é igual ao CPF do policial a ser buscado os dados do fardamento
                if ($policial->st_cpf == $cpf) {
                    $cautelasFardamento = $this->DalService->getCautelasFardamento($policial->id);
                    return view('rh::policial.editaFardamento', compact('policial', 'cautelasFardamento', 'renderizacao'));
                } else {
                    return redirect()->back()->with('erroMsg', Msg::USUARIO_SEM_PERMISSAO_PARA_ACAO);
                }
            //Verifica se a requisição veio da aba "Uniformes" em Editar Policial
            }else {
                $idPolicial = $renderizacao;
                $permissoes = Auth::user()->permissoes;
                if( auth()->user()->can('Edita_rh') ){
                    if( in_array('qualquerUnidade', $permissoes) ){
                        $policial = $this->PolicialService->findPolicialById($idPolicial);
                    } else {
                        $policial = $this->PolicialService->findPolicialById($idPolicial);
                        Funcoes::verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    }
                    $cautelasFardamento = $this->DalService->getCautelasFardamento($policial->id);
                    $renderizacao = 'uniformes';
                    return view('rh::policial.EditaUniforme', compact('policial', 'cautelasFardamento', 'renderizacao'));
                }elseif ( auth()->user()->can('CONSULTA_QUALQUER _UNIDADE') ) {
                    $policial = $this->PolicialService->findPolicialById($idPolicial);
                    $cautelasFardamento = $this->DalService->getCautelasFardamento($policial->id);
                    $renderizacao = 'uniformes';
                    return view('rh::policial.ExibiUniforme', compact('policial', 'cautelasFardamento', 'renderizacao'));
                }else {
                    throw new Exception('O seu perfil de Usuário não tem permissão para exibir a aba Uniformes!');
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }

    /**  
    * @author: @juanmojica. Issue 342 - implementar tela de cadastrar tela dados do fardamento
    * Método para atualizar os fardamentos do policial 
    */
    public function updateFardamentos(Request $request, $idPolicial, $renderizacao){
        try{
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'st_cobertura' => 'required|min:52|max:64|integer',
                'st_gandolacanicola' => 'required|min:1|max:10|integer',
                'st_camisainterna' => 'required|min:1|max:3|alpha',
                'st_calcasaia' => 'required|min:35|max:70|integer',
                'st_coturnosapato' => 'required|min:33|max:50|integer',
                'st_cinto' => 'required|min:85|max:145|integer'
            ]);

            $dadosForm['dt_atualizouuniforme'] = date('Y/m/d');
               
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //Verifica se a requisição veio de "Meus Fardamentos"
            if ($renderizacao == 'meus_fardamentos') {
                $this->authorize('Leitura');
                $policial = $this->PolicialService->findPolicialById($idPolicial);
                //Verifa se o CPF do policial logado é igual ao CPF do policial a ser buscado os dados do fardamento
                if ($policial->st_cpf == preg_replace("/\D+/", "", Auth::user()->st_cpf)) {
                    $this->PolicialService->atualizaDadosPessoais($idPolicial, $dadosForm);
                    return redirect()->back()->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);
                } else {
                    return redirect()->back()->with('erroMsg', Msg::USUARIO_SEM_PERMISSAO_PARA_ACAO);
                }
            //Verifica se a requisição veio da aba "Uniformes" em Editar Policial    
            } elseif ($renderizacao == 'uniformes'){
                $this->authorize('Edita_rh');
                $this->PolicialService->atualizaDadosPessoais($idPolicial, $dadosForm);
                return redirect()->back()->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);
            } else {
                return redirect()->back()->with('erroMsg', Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* autor: @medeiros
       Gera Ficha disciplinar de um policial 
       Requer o id do policial*/
       public function geraFichaDisciplinarPdf($idPolicial){
        $this->authorize('Leitura');  
        try {
            
            $permissoes = Auth::user()->permissoes;
            $unidadesVinculadas = Auth::user()->unidadesvinculadas;
            $fichaDisciplinar = $this->PolicialService->geraFichaDisciplinar($idPolicial);
            $imagem = null;
            if(isset($fichaDisciplinar->qualificacao->foto)){
                
                $caminhoImagem = $fichaDisciplinar->qualificacao->foto->st_pasta . $fichaDisciplinar->qualificacao->foto->st_arquivo . '.' . $fichaDisciplinar->qualificacao->foto->st_extensao;
                if(Storage::disk('ftp')->exists($caminhoImagem)){ 
                    $img = Storage::disk('ftp')->get($caminhoImagem);
                $imagem = base64_encode($img); 
                }
                
            }
           $nomeTabela = 'Ficha Dsiciplinar';
            
            if($fichaDisciplinar->qualificacao->st_cpf ==  preg_replace("/\D+/", "", Auth::user()->st_cpf)){
                // Se o usuário logado for o mesmo que ficha que será exibida
                //return view('rh::pdf.FichaDisciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
                return view('rh::pdf.ficha_disciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
            }elseif( in_array('qualquerUnidade',$permissoes)){

                //Se o usário tiver a permissão me qualquer unidade e tiver a permissão consultar ficha
                $this->authorize('Consulta_ficha');
               // return view('rh::pdf.FichaDisciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
               return view('rh::pdf.ficha_disciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
            }elseif (auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                //Se o usário tiver a permissão me qualquer unidade e tiver a permissão consultar ficha
                return view('rh::pdf.ficha_disciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));

            }else{
                //Se o usário tiver a permissão de edição no RH e estiver vinculado a unidade do policial
                $this->authorize('Edita_rh');
                Funcoes:: verificaVinculoDoUsuarioComUnidade( $fichaDisciplinar->qualificacao->ce_unidade);
                return view('rh::pdf.ficha_disciplinar', compact('fichaDisciplinar', 'nomeTabela', 'imagem'));
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                

            }
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function getPoliciaisSemFardamento()
    {
        try {
            $policiaisSemFardamento = $this->DalService->getPoliciaisSemFardamentos();
            $contador_inicial = 0;
            if(method_exists($policiaisSemFardamento,'currentPage')){
                $contador_inicial =($policiaisSemFardamento->currentPage()-1) * 50;
            }
            return view('rh::policial.listaPoliciaisSemFardamentos', compact('policiaisSemFardamento', 'contador_inicial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    /**
     * @author @jazon - #370
     * @return (Retorna uma lista do efetivo para classificar)
    */
    public function showClassificador()
    {
        try {
            //verifica se existe uma graduação selecionada
            if (isset($_GET['grad'])) {
                $idGraduacao = $_GET['grad'];
            } else {
                $idGraduacao = 15;
            }
            $efetivo = $this->PolicialService->getListagemPmsClassificados($idGraduacao);
            return view('rh::classificador.listagem', compact('efetivo'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /**
     * @author @araujo - #486
     * @return (Retorna um formulário para salvar o censo religioso)
    */
    public function formCensoReligioso()
    {
        try {
            //categorias religiosas
            $categorias = $this->RhService->getCategoriasReligiosas();
            //captura o id do policial logado
            $cpfPolicial = Auth::user()->st_cpf;
            $policial = $this->PolicialService->buscaPolicialCpf($cpfPolicial); 
            $idPolicial = $policial->id;
            //verifica se já foi feito o censo deste policial
            $verificado = $this->RhService->verificaCensoReligioso($idPolicial);
            if(isset($verificado->ce_categoriareligiosa)){
                $idCategoria = $verificado->ce_categoriareligiosa;
                $denominacoes = $this->RhService->getDenominacoesReligiosas($idCategoria);
            } else {
                $idCategoria = '';
                $denominacoes = '';
            }
            return view('rh::censo.Form_censoReligioso', compact('categorias','denominacoes','idCategoria','verificado'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /**
     * @author @araujo - #486
     * @return (Retorna um formulário para salvar o censo religioso com as denominações)
    */
    public function formCensoReligiosoComDenominacoes($idCategoria)
    {
        try {
            //categorias religiosas
            $categorias = $this->RhService->getCategoriasReligiosas();
            //denominações religiosas
            $denominacoes = $this->RhService->getDenominacoesReligiosas($idCategoria);
            if(!$denominacoes){
                $denominacoes = [];
               // return redirect()->back()->with('erroMsg', "Denominação não encontrada!");
            }
           
            //captura o id do policial logado
            $cpfPolicial = Auth::user()->st_cpf;
            $policial = $this->PolicialService->buscaPolicialCpf($cpfPolicial);
            if(!$policial){
                return redirect()->back()->with('erroMsg', "Policial não encontrado!");
            }
            $idPolicial = $policial->id;
            //verifica se já foi feito o censo deste policial
            $verificado = $this->RhService->verificaCensoReligioso($idPolicial);
            return view('rh::censo.Form_censoReligioso', compact('categorias','denominacoes','idCategoria','verificado'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /**
     * @author @araujo - #486
     * @return (salva um formulário do censo religioso)
    */
    public function cadastraCensoReligioso(Request $request){
        try{
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'ce_categoriareligiosa' => 'required',
                'st_denominacaoreligiosa' => 'required',
            ]);
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //captura o id do policial logado
            $cpfPolicial = Auth::user()->st_cpf;
            $policial = $this->PolicialService->buscaPolicialCpf($cpfPolicial);
            if(!$policial){
                return redirect()->back()->with('erroMsg', "Policial não encontrado!");
            }
            $idPolicial = $policial->id;
            //prepara o formulario
           /*  $dadosFormFinal = array(
                "ce_categoriareligiosa" => $dadosForm['categoria'],
                "st_denominacaoreligiosa" => $dadosForm['denominacao'],
                "st_detalhe" => $dadosForm['st_detalhe']
            ); */
            //salva o censo deste policial
            $resposta = $this->RhService->cadastraCensoReligioso($idPolicial, $dadosForm);
            //redireciona pra página de formulário
            return redirect()->back()->with('sucessoMsg', $resposta);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * @author @araujo - #486
     * @return (salva um formulário do censo religioso)
    */
    public function cadastraCensoReligiosoAdm($idPolicial, Request $request){
        try{
            
            $this->authorize('Edita_rh');
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'ce_categoriareligiosa' => 'required',
                'st_denominacaoreligiosa' => 'required',
            ]);
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
          
            /* //prepara o formulario
            $dadosFormFinal = array(
                "ce_categoriareligiosa" => $dadosForm['ce_categoria'],
                "st_denominacaoreligiosa" => $dadosForm['st_denominacao']
            ); */
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            Funcoes:: verificaVinculoDoUsuarioComUnidade($policial->ce_unidade);
            
            //salva o censo deste policial
            $resposta = $this->RhService->cadastraCensoReligiosoAdm($idPolicial, $dadosForm);
            //redireciona pra página de formulário
            return redirect()->back()->with('sucessoMsg', $resposta);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author @araujo - #486
     * @return (tela de busca de policial pra censo religioso)
    */
    public function formEditaCensoReligioso($idPolicial)
    {
        try {
            $this->authorize('Edita_rh');
            //categorias religiosas
            $categorias = $this->RhService->getCategoriasReligiosas();
            //captura o id do policial logado
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            Funcoes:: verificaVinculoDoUsuarioComUnidade($policial->ce_unidade);
            //verifica se já foi feito o censo deste policial
            $censoRealizado = $this->RhService->verificaCensoReligioso($idPolicial);
           
           
            if(isset($censoRealizado->ce_categoriareligiosa)){
                $idCategoria = $censoRealizado->ce_categoriareligiosa;
                $denominacoes = $this->RhService->getDenominacoesReligiosas($idCategoria);
                $denominacoaReligiosa = $censoRealizado->st_denominacaoreligiosa;
            } else {
                $idCategoria = null;
                $denominacoaReligiosa = null;
                $denominacoes = [];
            }            
            return view('rh::policial.EditaCensoReligioso', compact('policial', 'categorias','denominacoes','idCategoria','censoRealizado', 'denominacoaReligiosa'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
       
    }

      /**
     * @author @araujo - #486
     * @return (tela de busca de policial pra censo religioso)
    */
    public function getDenominacoesCategoria($idCategoria)
    {
        try {
           $denominacoes = $this->RhService->getDenominacoesReligiosas($idCategoria);
            return $denominacoes;
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
       
    }
      /**
     * @author @araujo - #486
     * @return (tela de busca de policial pra censo religioso)
    */
    public function getDenominacaoByidCategoriaNome(Request $request)
    {
        try {
           $dadosForm =$request->all();
           if(isset( $dadosForm['idCategoria']) && isset( $dadosForm['st_denominacao'])){
               $denominacoes = $this->RhService->getDenominacaoByidCategoriaNome($dadosForm);
               return $denominacoes;
           }else{
               return 1;
           }
        } catch(Exception $e){
            return $e->getMessage();
        }
       
    }



    /**
     * @author @araujo - #486
     * @return (tela de busca de policial pra censo religioso)
    */
    public function formPolicialCensoReligiosoSgtDiante()
    {
        try {
            //verifica autorização do sgt diante para acessar esta tela

            return view('rh::censo.Busca_Policial_CensoReligioso');
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /**
     * @author @araujo - #486
     * @return (busca um policial para o censo religioso)
    */
    public function buscaPolicialCensoReligioso(Request $parametro){
        try {
            $unidadesFilhasPolicialLogado = auth()->user()->unidadesvinculadas;
            $policiais = $this->PolicialService->buscaPolicialNomeCpfMatricula($parametro->busca);
            return view('rh::censo.Busca_Policial_CensoReligioso.blade', compact('policiais', 'unidadesFilhasPolicialLogado'));              
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    

    /**
     * cb Araújo
     * 412-atualizar-antiguidade-do-efetivo
     */
    public function atualizarClassificadorEmLote(Request $request){
        $this->authorize('ATUALIZAR_ANTIGUIDADE');
        $dadosRequest = $request->all();
        try{ 
            //prepara upload
            $uploaddir = 'planilhas/';//public/planilhas
            $uploadfile = $uploaddir . basename($_FILES['arquivo']['name']);
            $tipodearquivo = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));
            
            //verifica se é excel
            if ($tipodearquivo == 'xlsx') {
                if (basename($_FILES['arquivo']['name']) == 'planilha_classificador_antiguidade.xlsx') {
                    //verifica se fez o upload
                    if (move_uploaded_file($_FILES["arquivo"]["tmp_name"],$uploadfile )) {
                        //captura os dados do excel
                        $tmpfname = "planilhas/planilha_classificador_antiguidade.xlsx";//foi la na public/planilhas
                        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
                        $excelObj = $excelReader->load($tmpfname);
                        $worksheet = $excelObj->getActiveSheet();
                        $lastRow = $worksheet->getHighestRow();
                        $lastCol = $worksheet->getHighestColumn();
                        //captura as matriculas
                        $st_policiais = array();
                        //começa da segunda linha pq pula o título
                        for ($row = 2; $row <= $lastRow; $row++) {
                            //captura linhas da coluna A
                            $matricula = trim(addslashes($worksheet->getCell('A'.$row)->getValue()));
                            $matricula = str_replace(".","",$matricula);
                            $matricula = str_replace("-","",$matricula);
                            $matricula = str_replace(",","",$matricula);
                            $antiguidade = trim(addslashes($worksheet->getCell('B'.$row)->getValue()));
                            if(empty(trim($matricula))){
                                break;
                            } else {
                                //$st_policiais[] = $matricula;
                                $st_policiais[]= [$matricula,$antiguidade];                                
                            }
                        }
                        //dd($st_policiais);
                        //concatena a string
                        //cria um array com idnota e o st_policiais e manda pro service
                        
                        $dadosForm = array(
                            "ce_graduacao" => $dadosRequest['ce_graduacao'],
                            "lotepoliciais" => $st_policiais
                        );
                        
                        $msg = $this->PolicialService->atualizarClassificador($dadosForm);
                        //dd("mensagem controller ".$msg);
                        //apaga a planilha do servidor
                        if (file_exists("planilhas/".basename($_FILES['arquivo']['name']))) {
                            unlink("planilhas/".basename($_FILES['arquivo']['name']));
                        }   
                        return redirect()->back()->with('sucessoMsg',$msg);                         
                    } else {
                        return redirect()->back()->with('erroMsg','Upload não foi concluído. Tente novamente!');
                    }                        
                } else {
                    return redirect()->back()->with('erroMsg','O nome do arquivo que você deve fazer o upload deve ser o mesmo que do arquivo você baixou (planilha_classificador_antiguidade.xlsx).');
                }
            } else {
                return redirect()->back()->with('erroMsg','O arquivo que você está tentando enviar não é um Excel xlsx!');
            }
        } catch (Exception $e) {
            //o retorno é um json
            return redirect()->back()->with('erroMsg',$e->getmessage());
        }
    }


    /**
     * @author @jazon - #370
     * @return (Retorna uma lista do efetivo para classificar)
    */
    public function ordenarAntiguidade($sentido,$idPolicial)
    {
        $this->authorize('ATUALIZAR_ANTIGUIDADE');
        try {
            $msg = $this->PolicialService->ordenarAntiguidade($sentido,$idPolicial);
            if(isset($_GET['grad'])){
                $idGraduacao = $_GET['grad'];
                return redirect('rh/classificador?grad='.$idGraduacao)->with('sucessoMsg', $msg);  
            }else{
                return redirect('rh/classificador')->with('sucessoMsg',  $msg);  
            }
                
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getmessage());  
        }
    }


      /*issue:365-criar-aba-dependentes
         * lista todos os dependentes relacionados a um policial
         * Alexia 
         */    
    public function listaDependente($idPolicial){
        try{
            
            $dependentes = $this->PolicialService->listaDependente($idPolicial);
            $policial = $this->PolicialService->findPolicialById($idPolicial);
          
            return view('rh::policial.Lista_dependentes', compact('policial', 'dependentes'));    
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    public function viewCadastroDependente($idPolicial){
            try{
                //dd('gthgt');
                $policial = $this->PolicialService->findPolicialById($idPolicial);
                return view('rh::policial.Edita_dependente', compact('policial'));
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }
    

      /*issue:365-criar-aba-dependentes
         * Cadastra um novo dependente 
         * Alexia 
         */
    public function cadatraDependente(Request $request,$idPolicial){
        $this->authorize('Edita_rh');
        try{
         
            $dadosForm = $request->all();
          
            $validator = validator($dadosForm, [
                'st_nome' => 'required',
                'st_parentesco' => 'required',
                'st_cpf' => 'required',
                'st_sexo'=> 'required',
                'dt_nascimento' => 'required'
            ]);
          
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }      
             //Se o ckeckbox for marcado ele recebe o valor '1' caso contrario recebe valor '0'.
            if(isset($dadosForm['bo_ergon'] )){
                $dadosForm['bo_ergon'] = 1;
            }else{
                $dadosForm['bo_ergon'] = 0;
            }
          
           $msg = $this->PolicialService->cadatrarDependente($idPolicial,$dadosForm);
          return redirect('rh/policiais/edita/'.$idPolicial.'/dependentes')->with('sucessoMsg',  $msg);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    } 

    /*issue:365-criar-aba-dependentes
         * retorna blade de edicao para novos 
         * Alexia 
    */
    public function viewEditaDependente($idPolicial,$idDependente){
        try{
            
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $dependentes = $this->PolicialService->findDependenteById($idPolicial,$idDependente);
            //dd($dependentes);
            return view('rh::policial.Editar_dados_dependente', compact('policial','dependentes'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*issue:365-criar-aba-dependentes
         * edita dependentes 
         * Alexia 
    */
    public function editaDependente(Request $request, $idPolicial, $idDependente){
        try{
          
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_nome' => 'required',
                'st_parentesco' => 'required',
                'st_cpf' => 'required',
                'st_sexo'=> 'required',
                'dt_nascimento' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(isset($dadosForm['bo_ergon'] )){
                $dadosForm['bo_ergon'] = 1;
            }else{
                $dadosForm['bo_ergon'] = 0;
            }
            
        $msg =  $this->PolicialService->editaDependente($idPolicial, $idDependente, $dadosForm);
        return redirect('rh/policiais/edita/'.$idPolicial.'/dependentes')->with('sucessoMsg', $msg); 
            
    } catch (Exception $e) {
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }
}        
   
    /*issue:365-criar-aba-dependentes
         * exclui dependentes
         * Alexia 
    */
   public function excluirDependente($idPolicial, $idDependente, Request $request){
    try{
        //recebe os dados
        $dadosForm = $request->all();
        $validator = validator($dadosForm, [
            'st_motivoexclusao' => 'required'
            ]);
        //faz a validacao
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
        $response = $this->PolicialService->excluirDependente($idPolicial, $idDependente, $dadosForm);
        //redireciona para a tela de dependentes e retorna erro ou sucesso
        return redirect('rh/policiais/edita/'.$idPolicial.'/dependentes')->with('sucessoMsg', $response); 
    } catch (Exception $e) {
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }         
} 

    /**
     * @author juan_mojica - #397
     * @param Integer
     * @return (array de objetos da certidão de tempo de serviço)
     */
    public function geraCertidaoDeTempoDeServicoPdf($idPolicial) {
        try{
            $this->authorize('IMPRIMIR_CERTIDAO_TEMPO_SERVICO');

            //invoca o serviço para buscar os dados da certidão de tempo de serviço
            $certidao = $this->PolicialService->getCertidaoDeTempoDeServico($idPolicial);

            if (count($certidao->assinaturas) < 2) {
                throw new Exception('Aguardando assinaturas');
            }

            $funcoes = new Funcoes();

            //invoca o método mask da classe funções para adicionar a máscara da matrícula
            $certidao->qualificacao->st_matricula = $funcoes->mask($certidao->qualificacao->st_matricula, '###.###-#');
            
            //invoca o método mask da classe funções para adicionar a máscara do cpf
            $certidao->qualificacao->st_cpf = $funcoes->mask($certidao->qualificacao->st_cpf, '###.###.###-##');

            //invoca o método mask da classe funções para adicionar a máscara do rg militar
            $certidao->qualificacao->st_rgmilitar = $funcoes->mask($certidao->qualificacao->st_rgmilitar, '##.###');

            //converte a data para o padrão brasileiro
            $certidao->qualificacao->dt_nascimento = date('d/m/Y', strtotime($certidao->qualificacao->dt_nascimento));
            $certidao->qualificacao->dt_incorporacao = date('d/m/Y', strtotime($certidao->qualificacao->dt_incorporacao));
            //verifa se é uma data no padrão A/m/d ou A-m-d e se sim a converte para o padrão brasileiro
            if ((date('Y/m/d', strtotime($certidao->dt_completoutempo)) == $certidao->dt_completoutempo) || (date('Y-m-d', strtotime($certidao->dt_completoutempo)) == $certidao->dt_completoutempo)) {
                $certidao->dt_completoutempo = date('d/m/Y', strtotime($certidao->dt_completoutempo));
            }

            //verifca se o militar está na graduação máxima de ST e atribui a respectiva DP
            if ($certidao->qualificacao->ce_graduacao < 8)  {
                $certidao->dp = 'DP/2';
            } else {
                $certidao->dp = 'DP/4';
            }

            //verifca se o militar está na graduação máxima de 1º Sgt e monta a string a ser exibida em cargo_efetivo
            if ($certidao->qualificacao->ce_graduacao < 7)  {
                $certidao->qualificacao->st_cargoefetivo = $certidao->qualificacao->st_postograduacao . ' PM Nº ' . $certidao->qualificacao->st_numpraca;
            } else {
                $certidao->qualificacao->st_cargoefetivo = $certidao->qualificacao->st_postograduacao . ' PM';
            }
            

            return view('rh::pdf.CertidaoDeTempoDeServicoPdf', compact('certidao'));

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }   
    }

    /**  
     * @author: @juanmojica - #403
     * @param Integer
     * @return (array de objetos da caderneta de registros) 
    */
       public function geraCadernetaDeRegistroReservadoPdf($idPolicial){
        $this->authorize('PUBLICACOES_RESERVADAS');  
        try {

            $cadernetaRegistro = $this->PolicialService->geraCadernetaDeRegistroPdf($idPolicial);
            
            $imagem = null;
            if(isset($cadernetaRegistro->qualificacao->foto)){
                $caminhoImagem = $cadernetaRegistro->qualificacao->foto->st_pasta . $cadernetaRegistro->qualificacao->foto->st_arquivo . '.' . $cadernetaRegistro->qualificacao->foto->st_extensao;
                if(Storage::disk('ftp')->exists($caminhoImagem)){ 
                    $img = Storage::disk('ftp')->get($caminhoImagem);
                    $imagem = base64_encode($img); 
                } 
            }
            
            return view('rh::pdf.CadernetaRegistroReservadoPdf', compact('cadernetaRegistro', 'imagem'));
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**  
     * @author: @juanmojica - #406
     * @param Integer
     * @return (array de objetos da caderneta de registros) 
    */
       public function geraExtratoDeAssentamentosPdf($idPolicial){
        $this->authorize('ABA_DEPENDENTES');  
        try {
           
            $cadernetaRegistro = $this->PolicialService->geraCadernetaDeRegistroPdf($idPolicial);
            //dd($cadernetaRegistro);

            $funcoes = new Funcoes();

            //invoca o método mask da classe funções para adicionar a máscara da matrícula
            $cadernetaRegistro->qualificacao->st_matricula = $funcoes->mask($cadernetaRegistro->qualificacao->st_matricula, '###.###-#');

            //invoca o método mask da classe funções para adicionar a máscara do número de praça
            if (isset($cadernetaRegistro->qualificacao->st_numpraca)) {
                $cadernetaRegistro->qualificacao->st_numpraca = $funcoes->mask($cadernetaRegistro->qualificacao->st_numpraca, '####.####');
            }
            
            return view('rh::pdf.ExtratoDeAssentamentosPdf', compact('cadernetaRegistro'));
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
 
    //Alexia Tuane 
    //issue:#398 criar aba comportamento
    //lista comportamento de  um policial
    public function listarComportamento($idPolicial){
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $comportamento = $this->PolicialService->listarComportamento($idPolicial);
           //dd($comportamento);
            return view('rh::policial.listaComportamento', compact('policial','comportamento'));    
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    //Alexia Tuane 
    //issue:#398 criar aba comportamento
    //cadastra comportamento de  um policial

    public function viewCadastrarComportamento($idPolicial){
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
          
            return view('rh::policial.FormComportamento', compact('policial'));    
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }



    public function cadastrarComportamento(Request $request, $idPolicial){
        
        try{
           
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_comportamento' => 'required',
                'dt_boletim' => 'required',
                'st_motivo' => 'required',
                'st_boletim'=> 'required'
                
            ]);
            
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }      
           
            $msg = $this->PolicialService->cadastrarComportamento($idPolicial,$dadosForm);
            
          return redirect('rh/policiais/edita/'.$idPolicial.'/comportamento')->with('sucessoMsg',  $msg);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    } 


    
   //Alexia Tuane 
    //issue:#398 criar aba comportamento
    //cadastra comportamento de  um policial
    public function viewEditaComportamento($idPolicial,$idComportamento){
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $comportamento = $this->PolicialService-> findComportamentoById($idPolicial,$idComportamento);
            return view('rh::policial.editaComportamento', compact('policial','comportamento'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function editarComportamento( $idPolicial, $idComportamento, Request $request){
        
        try{
           //recebe os dados
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_comportamento' => 'required',
                'dt_boletim' => 'required',
                'st_motivo' => 'required',
                'st_boletim'=> 'required',
               
            ]);
            //dd($dadosForm);
            //faz a validacao
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }    
            //retorna sucesso ou erro
            $msg = $this->PolicialService->editarComportamento($idPolicial, $idComportamento, $dadosForm);
            //dd($msg);
            return redirect('rh/policiais/edita/'.$idPolicial.'/comportamento')->with('sucessoMsg',  $msg);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    } 



    public function excluirComportamento($idPolicial, $idComportamento, Request $request){
        try{
           
            //recebe os dados
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_motivo' => 'required'
                ]);
              
            //faz a validacao
                if($validator->fails()){
                    // Mensagem de erro com o formulário preenchido
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            //retorna sucesso ou erro
            $msg = $this->PolicialService->excluirComportamento($idPolicial, $idComportamento, $dadosForm);
            //redireciona para a tela de que lista os comportamentos e retorna erro ou sucesso
            return redirect('rh/policiais/edita/'.$idPolicial.'/comportamento')->with('sucessoMsg', $msg); 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    }
    
    /**  
     * @author: @juanmojica - #410
     * @param Integer
     * @return (array de objetos da caderneta de registros) 
    */
    public function assinaCertidaoTempoServico(Request $request, $idPolicial){
        $this->authorize('IMPRIMIR_CERTIDAO_TEMPO_SERVICO');  
        try {
           
            $cpf = Auth::user()->st_cpf;

            //verifica se uma senha foi enviada na requisição
            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', MSG::SENHA_OBRIGATORIA); 
            }

            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', MSG::SENHA_INVALIDA); 
            }
            //prepara os dados para enviar ao serviço
            $dados = [ 
                'st_motivoassinatura' => Status::CERTIDAO_TEMPO_SERVICO,
                'st_funcaoassinante' => $request->funcao,
            ];

            $acao = 'ASSINAR';
            
            $assinaCertidao =  $this->PolicialService->AssinaDocumento($idPolicial, $acao, $dados);

            return redirect()->back()->with('sucessoMsg', $assinaCertidao);
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**  
     * @author: @juanmojica - #410
     * @param Integer
     * @return (array de objetos da caderneta de registros) 
    */
    public function cancelaAssinaturaCertidaoTempoServico(Request $request, $idPolicial, $idAssinatura){
        $this->authorize('IMPRIMIR_CERTIDAO_TEMPO_SERVICO');  
        try {
           
            $cpf = Auth::user()->st_cpf;

            //verifica se uma senha foi enviada na requisição
            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', MSG::SENHA_OBRIGATORIA); 
            }

            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', MSG::SENHA_INVALIDA); 
            }
            //prepara os dados para enviar ao serviço
            $dados = [ 
                'st_motivoassinatura' => Status::CERTIDAO_TEMPO_SERVICO,
                'st_funcaoassinante' => $request->funcao,
                'idAssinatura' => $idAssinatura,
            ];

            $acao = 'CANCELAR';
            
            $cancelaAssinaturaCertidao =  $this->PolicialService->AssinaDocumento($idPolicial, $acao, $dados);

            return redirect()->back()->with('sucessoMsg', $cancelaAssinaturaCertidao);
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**  
     * @author @juanmojica - #428
     * @return View ( tela para inserir o excel com o lote dos policiais a serem movimentados )  
    */
    public function viewImportaEfetivoParaMovimentacaoExcel(){
       $this->authorize('MANUTENCAO_SISTEMA'); 
        
        try {

            $estado = env('MANUTENCAO_SISTEMA');

            if (empty($estado)) {
                throw new Exception('A variável MANUTENCAO_SISTEMA não existe no arquivo ENV!');
            }
            if ($estado == 'MANUTENCAO') {
                return view('rh::movimentacoes.importaEfetivoParaMovimentacaoExcel');
            } else {
                throw new Exception('Sistema não está em manutenção para habilitar essa funcionalidade!');
            }
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getmessage());
        }
    }

    /**  
     * @author @juanmojica - #428
     * @param Request ( arquivo excel com o lote dos policiais a serem movimentados ) 
     * @return Response ( sucesso ou erro )
    */
    public function importaEfetivoParaMovimentacaoExcel(Request $request){
        $this->authorize('MANUTENCAO_SISTEMA');  
        
        try{ 
            //prepara upload
            $uploaddir = 'planilhas/';//public/planilhas/
            $uploadfile = $uploaddir . basename($_FILES['arquivo']['name']);
            $tipodearquivo = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));

            //verifica se é excel
            if ($tipodearquivo == 'xlsx') {
                //verifica se o nome do arquivo é "movimentacao_efetivo_em_lote.xlsx"
                if (basename($_FILES['arquivo']['name']) == 'movimentacao_efetivo_em_lote.xlsx') {
                    //verifica se fez o upload e movimenta o arquivo para a pasta public/planilhas
                    if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $uploadfile )) {
                        //captura os dados do excel
                        $excelReader = PHPExcel_IOFactory::createReaderForFile($uploadfile);
                        $excelObj = $excelReader->load($uploadfile);
                        $worksheet = $excelObj->getActiveSheet();
                        $lastRow = $worksheet->getHighestRow();
                        $lastCol = $worksheet->getHighestColumn();
                        //captura as matriculas e ids das unidades de destino
                        $lotepoliciais = [];
                        //começa da segunda linha pq pula o título
                        for ($row = 2; $row <= $lastRow; $row++) {
                            //captura linha da coluna A
                            $matricula = trim($worksheet->getCell('A'.$row)->getValue());
                            $matricula = str_replace(".","",$matricula);
                            $matricula = str_replace("-","",$matricula);
                            $matricula = str_replace(",","",$matricula);
                            //captura linha da coluna B
                            $id_unidade_destino = trim($worksheet->getCell('B'.$row)->getValue());

                            if(!empty(trim($matricula)) && !empty(trim($id_unidade_destino))){
                                $lotepoliciais[$row - 2] = [$matricula, $id_unidade_destino];
                            } 
                        }

                        //apaga a planilha do servidor
                        if (file_exists($uploadfile)) {
                            unlink($uploadfile);
                        }

                        //prepara os dados para enviar ao serviço
                        $dados['lotepoliciais'] = $lotepoliciais;

                        $msg = $this->PolicialService->movimentaPoliciaisEmLote($dados);

                        return redirect()->back()->with('sucessoMsg',$msg); 

                    } else {
                        return redirect()->back()->with('erroMsg','Upload não foi concluído. Tente novamente!');
                    }                        
                } else {
                    return redirect()->back()->with('erroMsg','O nome do arquivo para fazer o upload deve ser ( movimentacao_efetivo_em_lote.xlsx ).');
                }                       
            } else {
                return redirect()->back()->with('erroMsg','O arquivo que você está tentando enviar não é um Excel xlsx!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getmessage());
        }
    }
     /**  
     * @author @Alexia-
     *  issue: #457 
     *criar aba procedimentos
    */
    public function listarProcedimentos($idPolicial){
        try{
            $procedimentos = $this->PolicialService->listaProcedimentos($idPolicial);
            //dd($procedimentos);
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            return view('rh::policial.Edita_procedimentos', compact('policial','procedimentos'));    
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    

      /**  
     * @author @Alexia
     *  issue: #464 
     *criar-aba-pensionistas corrigido*
    */
    public function listarPensionistas($idPolicial){
        try{
            $pensionistas= $this->PolicialService->listarPensionistas($idPolicial);
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            return view('rh::policial.EditaPensionistas', compact('policial','pensionistas'));    
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    /**  
         * @author @Alexia
         *  issue: #465 
         * Listagem da certidao nada consta
         *criar-aba-nada-consta
    */
    public function listarCertidao($idPolicial){
            $this->authorize('ABAS_DJD');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $certidao = $this->PolicialService->listarCertidoes($idPolicial);
            //dd($certidao);
            //arsort($certidao);
            return view('rh::policial.ListaCertidoes', compact('policial','certidao'));    
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**  
         * @author @Alexia
         *  issue: #465 
         * recupera o Pdf da certidão
         *criar-aba-nada-consta
    */
    public function viewCertidao($idPolicial,$idCertidao){
            $this->authorize('ABAS_DJD');
        try{
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $certidao = $this->PolicialService->findCertidaoById($idPolicial,$idCertidao);
            //dd($certidao);
            return view('rh::pdf.Certidaopdf', compact('policial','certidao'));
        } catch (Exception $e) {
            
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**  
         * @author @Alexia
         *  issue: #465 
         * adiciona novas certidões
         *criar-aba-nada-consta
    */
    public function cadastrarCertidao(Request $request, $idPolicial){
        $this->authorize('ABAS_DJD');
        try{
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_tipo' => 'required',
            ]);
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }      
            $msg = $this->PolicialService->cadastrarCertidao($idPolicial,$dadosForm);
          return redirect('rh/policiais/edita/'.$idPolicial.'/certidao')->with('sucessoMsg',  $msg);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    } 
     /**  
         * @author @Alexia
         *  issue: #465 
         * Assina certidão nada consta
         *criar-aba-nada-consta
    */
    public function assinarCertidaonadaConsta(Request $request, $idPolicial,$idCertidao){
                $this->authorize('ABAS_DJD'); 
            try{
                $dados = $request->all();
                //dd($dados);
                $cpfUsuario = Auth::User()->st_cpf;
               
                /***Verifica se existe o usuário no AD com as credenciais passadas como parâmetro */
                $authldap = new Authldap();
                $credenciais = array('st_cpf' => $cpfUsuario, 'password' =>  $dados['st_password']);
               //verificando no AD as credenciais
                $ldap = $authldap->autentica($credenciais);
                if($ldap == false){
                    throw new Exception(Msg::SENHA_INVALIDA);
                }
                
                $certidao = $this->PolicialService->assinarCertidaoNadaConsta($idPolicial,$idCertidao,$dados);
               //dd($certidao);
                if($certidao){ // verifica se o status foi alterado
                    $msg = 'CERTIDÃO ASSINADA';
                    return redirect('rh/policiais/edita/'.$idPolicial.'/certidao')->with('sucessoMsg', $msg);
                }else{
                    return redirect()->back()->with('erroMsg', MSG::ERRO_AO_ASSINAR_CERTIDAO);
                }
            }catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        /**
         * @author juanmojica - #488
         * Lista policiais que fizeram ou não o censo religioso
         * @param string {'sim' ou 'nao'}
         * @return object { policiais e título da página }
         */
        public function listaPoliciasCensoReligioso($realizaram, $unidades) {
            try {
               
                $unidadesFilhas = $this->UnidadeService->getunidadesfilhas(auth()->user()->ce_unidade);

                $dadosForm['ce_unidade'] = $unidadesFilhas;
                
                if ( $realizaram == 'sim' ) {

                    $titulo = 'POLICIAIS QUE INFORMARAM A OPÇÃO RELIGIOSA';

                    if ($unidades == 'todas') {
                        $policiais = $this->PolicialService->getPoliciaisCensoReligioso('paginado');

                    } elseif ($unidades == 'filhas') {
                        $policiais = $this->PolicialService->getPoliciaisCensoReligiosoUnidadesFilhas('paginado', $dadosForm);

                    } else {
                        throw new Exception('Parâmetro inválido!');
                    }
                    
                } elseif ( $realizaram == 'nao' ) {
                    $titulo = 'POLICIAIS QUE NÃO INFORMARAM A OPÇÃO RELIGIOSA';

                    if ($unidades == 'todas') {
                        $policiais = $this->PolicialService->getPoliciaisSemCensoReligioso('paginado');

                    } elseif ($unidades == 'filhas') {
                        $policiais = $this->PolicialService->getPoliciaisSemCensoReligiosoUnidadesFilhas('paginado', $dadosForm);

                    } else {
                        throw new Exception('Parâmetro inválido!');
                    }

                } else {
                    throw new Exception('Parâmetro inválido!');
                }
                
                $contador_inicial = 0;

                if(method_exists($policiais,'currentPage')){
                    $contador_inicial =($policiais->currentPage()-1) * 50;
                }
               
                return view('rh::censo.ListaPoliciaisCensoReligioso', compact('titulo', 'policiais', 'contador_inicial', 'realizaram'));

            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }


     /**  
     * @author: @Alexia 
     * issue: #494 - criar-aba-inatividade
     * retorna a listagem da aba prova de vida 
    */
    public function  abaInatividade($idPolicial){
        $this->authorize('ABA_INATIVIDADE');
        try {
         //dd('chegou');
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            //dd($policial);
            return view('rh::policial.editaInatividade', compact( 'policial'));

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
     /**  
     * @author: @Jazon 
     * issue: #494- criar-aba-inatividade
    */
    public function  setAbaInatividade($idPolicial, Request $request){
        $this->authorize('ABA_INATIVIDADE');
        try {
            $dadosForm = $request->all();
            
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            
            $msg = $this->PolicialService->atualizaInatividade($idPolicial, $dadosForm);

            return redirect('rh/policiais/edita/'.$idPolicial.'/inatividade')->with('sucessoMsg', $msg);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**  
     * @author: @Alexia 
     * issue: #494 - criar-aba--prova-de-vida-dos-pm's
     * 
    */
    public function abaProvadeVida($idPolicial){
        try {
            $tipoDeclaracao = 'DEC_PROVA_DE_VIDA';
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $declaracoes = $this->PolicialService->abaProvadeVida($idPolicial,$tipoDeclaracao);
            //dd($declaracoes);
            return view('rh::policial.ProvadeVida', compact('policial','declaracoes'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*issue:496-criar-aba-declaracao-beneficiarios
    * lista todos os dependentes relacionados a um policial
    * Araujo 
    */
    public function viewBeneficiarios($idPolicial){
        try{
            $this->authorize('Relatorios_rh');
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $declaracoes = $this->PolicialService->listaDeclaracoes($idPolicial,'DEC_BENEFICIARIO');
            //dd($declaracoes);
            return view('rh::policial.Beneficiarios', compact('policial','declaracoes'));    
        }catch (Exception $e) {

            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

      /**  
     * @author: @Alexia 
     * issue: #494 - criar-aba--prova-de-vida-dos-pm's
     * retorna a blade de cadastro dea prova de vida
    */
    public function FormcadastrarProvadeVida($idPolicial){
        try {
            $policial = $this->PolicialService->findPolicialById($idPolicial);
          return view('rh::policial.CadastrarProvadeVida', compact( 'policial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    } 

    
    /**  
     * @author: @Alexia 
     * issue: #494 - criar-aba--prova-de-vida-dos-pm's
     * cadastrar prova de vida
    */
    public function cadastrarProvadeVida($idPolicial){
        $this->authorize('Relatorios_rh');
        try{
            $tipoDeclaracao = 'DEC_PROVA_DE_VIDA';
            $msg = $this->PolicialService->cadastrarProvadeVida($idPolicial,$tipoDeclaracao);           
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            if($msg=="Declaração cadastrada com sucesso"){
                return redirect()->back()->with('sucessoMsg', 'Declaração Anual cadastrada com sucesso!');
            } else {
                return redirect()->back()->with('erroMsg', $msg);
            }
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    } 
     /*issue:496-criar-aba-declaracao-beneficiarios
    * lista todos os dependentes relacionados a um policial
    * Araujo 
    */
    public function buscaPessoaCpfAjax($cpf){
        try{
            $this->authorize('Relatorios_rh');
            $pessoa = $this->DpsService->buscaPessoaCpfAjax($cpf);
     
            if(empty($pessoa)){
                return 0;
            }else{
                return $pessoa;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

      /**  
     * @author: @Alexia 
     * issue: #494 - criar-aba--prova-de-vida-dos-pm's
     * retorna a blade de cadastro pessoa para prova de vida
    */
    public function FormcadastrarPessoaProvadeVida($idPolicial,$idDeclaracao){
        try {
           $dadosCertidao = $this->PolicialService->listabeneficiariosProvadeVida($idDeclaracao);
           $policial = $dadosCertidao->policial;
           $beneficiarios = $dadosCertidao->beneficiarios;
           //dd($beneficiarios);
          return view('rh::policial.CadastrarPessoaProvadeVida', compact( 'policial','idDeclaracao','beneficiarios','dadosCertidao'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    } 
    /**  
     * @author: @Alexia 
     * issue: #494 - criar-aba--prova-de-vida-dos-pm's
     * cadastrar  pessoa para prova de vida
    */
    public function cadastrarPessoaProvadeVida(Request $request,$idPolicial,$idDeclaracao){
        try{
            $dadosForm = $request->all();
            //busca pessoa pelo cpf
            $pessoa = $this->DpsService->getPessoaByCPFnoException($dadosForm['st_cpf']);
            //dd($pessoa);
            if(empty($pessoa)){
                //salva  e recupera pessoa
                $pessoa = $this->DpsService->createPessoa($dadosForm);
            }
            //salva a pessoa como beneficiário
            $dadosForm['ce_pessoa'] = $pessoa->id;
            $msg = $this->PolicialService->cadastrarPVida($idPolicial,$idDeclaracao,$dadosForm);
            if(isset($msg->retorno) && $msg->retorno == 'erro'){
                return redirect()->back()->with('erroMsg', $msg->msg);
            } else {
                return redirect()->back()->with('sucessoMsg', 'Beneficiário cadastrado com sucesso!');
            }
        } catch (Exception $e) {
            
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    } 

    /**  
         * @author @Alexia
         *  issue: #498 
         * recupera o Pdf da DECLARAÇÃO de prova de vida
         *criar-aba-nada-consta
    */
    public function viewCertidaoProvadeVida($idPolicial,$idDeclaracao){
    try{
       
        $policial = $this->PolicialService->findPolicialById($idPolicial);
        $dadosCertidao = $this->PolicialService->listabeneficiariosProvadeVida($idDeclaracao);
        //dd($policial);
      
        return view('rh::pdf.DeclaracaoProvadeVidaPDF', compact('policial','dadosCertidao'));
    } catch (Exception $e) {
        
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }
}
    /**  
         * @author @Alexia
         *  issue: #498 
         * assina prova de vida
         * 
         *criar-aba-nada-consta
    */
public function assinarProvadeVida($idPolicial,$idDeclaracao,Request $request)
{
    try {
        
        $dados = $request->all();
        $dadosCertidao = $this->PolicialService->listabeneficiariosProvadeVida($idDeclaracao);
        $idPolicial = $dadosCertidao->policial->id;
        
        if($dados['assinante'] == 'responsavel'){
            //assina usando dados do Sargenteante que está logado e assinando
            $sargenteante = $this->PolicialService->findPolicialByCpfMatricula(auth()->user()->st_cpf);
            $idSargenteante = $sargenteante->id;
            /***Verifica se existe o usuário no AD com as credenciais passadas como parâmetro */
            $authldap = new Authldap();
            $credenciais = array('st_cpf' => auth()->user()->st_cpf, 'password' =>  $dados['senha']);
            $ldap = $authldap->autentica($credenciais);
            if($ldap == false){
                throw new Exception(Msg::SENHA_INVALIDA);
            }
            /*
            caso o sargenteante que assina for diferente do que iniciou a declaração o responsável
            passa a ser quem assina
            */
            $dados = [
                'ce_sargenteante' => $idSargenteante,
                'assinante' =>'required',
                'st_asinaturaresponsavel' => true,
            ];
            $this->PolicialService->assinarDeclaracaoProvadeVida($idDeclaracao,$idPolicial,'responsavel');
            return redirect()->back()->with('sucessoMsg', 'Declaração assinada pelo responsável com sucesso!');
        } else if($dados['assinante'] == 'policial'){
            //assina usando dados do $idPolicial
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            /***Verifica se existe o usuário no AD com as credenciais passadas como parâmetro */
            $authldap = new Authldap();
            $credenciais = array('st_cpf' => $policial->st_cpf, 'password' =>  $dados['senha']);
            $ldap = $authldap->autentica($credenciais);
            if($ldap == false){
                throw new Exception(Msg::SENHA_INVALIDA);
            }
            $dados = [
                'st_assinaturapolicial' => true,
            ];
            $this->PolicialService->assinarDeclaracaoProvadeVida($idDeclaracao,$idPolicial,'policial');
            return redirect()->back()->with('sucessoMsg', 'Declaração assinada pelo Policial com sucesso!');
        }
    } catch(Exception $e){
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }
}

public function uploadDocBeneficiario($idBeneficiario,$idDeclaracao,$tipo,Request $request){
    try {
        /**
         * tipo==1 => documento de vinculo familiar
         * tipo==2 => comprovante de residencia
         */
        // Validação do envio do arquivo
        $arquivo = $request->arquivo;
        $nomeArquivo = $arquivo->getClientOriginalName();
        if(isset($request->arquivo)){
            $arquivo = $request->arquivo;
            //verifica se o arquivo é válido
            if($arquivo->isValid()){ 
                $extensao = $arquivo->getClientOriginalExtension();
                //verifica se é pdf
                if($extensao != 'pdf' && $extensao != 'png' && $extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'gif'){ 
                    return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload. O arquivo a ser enviado deve está em formato PDF, PNG, JPG, JPEG ou GIF.');
                }elseif($arquivo->getClientSize() > 2000000){
                    return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo "'.$nomeArquivo.'" excede o tamanho de 2MB.');
                }
                $beneficiario = $this->PolicialService->getBeneficiarioById($idDeclaracao,$idBeneficiario);
                $dadosCertidao = $this->PolicialService->listabeneficiariosProvadeVida($idDeclaracao);
                $policial = $dadosCertidao->policial;
                
                $ano = date("Y");
                if($tipo == 1){
                    $caminho_armazenamento = "RH"."/".str_replace(" ", "", $policial->st_cpf)."/".$ano."/declaracaobeneficiarios/provadevida/".$beneficiario->pessoa->st_cpf."/documento/";
                    $beneficiario->st_caminhoanexo = $caminho_armazenamento;
                } elseif($tipo == 2){
                    $caminho_armazenamento = "RH"."/".str_replace(" ", "", $policial->st_cpf)."/".$ano."/declaracaobeneficiarios/provadevida/".$beneficiario->pessoa->st_cpf."/comprovante_residencia/";
                    $beneficiario->st_caminhocomprovanteresidencia = $caminho_armazenamento;
                }
                //testa se existe o diretorio do funcionario
                if(!Storage::disk('ftp')->exists($caminho_armazenamento)){
                    //creates directory
                    Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                }
                //gera hash a partir do arquivo
                $hashNome = hash_file('md5', $arquivo); 
                //novo nome do arquivo com base no hash
                $novoNome = $hashNome.'.'.$extensao; 
                //checa se o arquivo ja existe
                if(!Storage::disk('ftp')->exists($caminho_armazenamento.$novoNome)){
                    //salva arquivo no ftp
                    $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                    if($salvouNoFtp){
                        //salva dados do arquivo no banco atualizando o beneficiario
                        if($tipo == 1){
                            $dadosForm = [
                                'st_caminhoanexo' => $caminho_armazenamento.$novoNome,
                            ];
                        } elseif($tipo == 2){
                            $dadosForm = [
                                'st_caminhocomprovanteresidencia' => $caminho_armazenamento.$novoNome,
                            ];
                        }                            
                      
                        $this->PolicialService->editarBeneficiario($idDeclaracao,$idBeneficiario,$dadosForm);
                    }else{
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, erro na base de dados de arquivos.');
                    }
                    return redirect('rh/policiais/'.$policial->id.'/cadastra/provadevida/'.$idDeclaracao)->with('sucessoMsg', Msg::SALVO_SUCESSO);

                }else{
                    return redirect()->back()->with('erroMsg', "Esse arquivo já está cadastrado para este Beneficiário com o nome: ". $nomeArquivo);
                }
            }else{
                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload do arquivo "'.$nomeArquivo.'", verifique se ele não está corrompido ou o seu tamanho excede 2 MB.');
            }
        }else{
            return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo não é válido.');
        }
    } catch (Exception $e) {
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }
}



    /**
     * Método que realiza o download do arquivo.
     * @autor: Araujo
     * @return Response
     */
    public function downloadDocBeneficiario($idDeclaracao,$idBeneficiario,$tipo)
    {
        $this->authorize('Relatorios_rh');
        try {
            $beneficiario = $this->PolicialService->getBeneficiarioById($idDeclaracao,$idBeneficiario);
            
            if($tipo==1){
                $caminho = $beneficiario->st_caminhoanexo;
            } elseif($tipo==2){
                $caminho = $beneficiario->st_caminhocomprovanteresidencia;
            }  
            //TODO corrigir bug do download do documento formato invalido
            if(Storage::disk('ftp')->exists($caminho)){
                return Storage::disk('ftp')->download($caminho);
            }else{
                return redirect()->back()->with('erroMsg', Msg::ARQUIVO_NAO_ENCONTRADO);
            }
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function editarBeneficiarioProvadeVida($idDeclaracao, $idBeneficiario, $idPessoa, Request $request){
        $this->authorize('Relatorios_rh');
        try{
            $dadosForm = $request->all();
            $dados = [ 
                'st_cpf' => $dadosForm['st_cpf2'],
                'st_ordem' => $dadosForm['st_ordem2'],
                'st_nome' => $dadosForm['st_nome2'],
                'st_sexo' => $dadosForm['st_sexo2'],
                'dt_nascimento' => $dadosForm['dt_nascimento2'],
                'st_mae' => $dadosForm['st_mae2'],
                'st_telefone' => $dadosForm['st_telefone2'],
                'st_email' => $dadosForm['st_email2'],
            ];
            $resposta = $this->PolicialService->AtualizarBeneficiario($idDeclaracao, $idBeneficiario, $idPessoa, $dados);
            return redirect()->back()->with('sucessoMsg', 'Beneficiário atualizado com sucesso!');
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }



    public function excluirBeneficiarioProvadeVida($idPolicial,$idDeclaracao,$idBeneficiario){
        $this->authorize('Relatorios_rh');
        try{
           //acha o beneficiario
            $beneficiario = $this->PolicialService->getBeneficiarioById($idDeclaracao,$idBeneficiario);
            //dd($beneficiario);
            $caminhoDocumento = $beneficiario->st_caminhoanexo;
            $caminhoResidencia = $beneficiario->st_caminhocomprovanteresidencia;
            //exclui o beneficiario
            if($this->PolicialService->excluirBeneficiarioProvadeVida($idDeclaracao,$idBeneficiario)){
                //exclui os arquivos de ftp do beneficiario
                if(Storage::disk('ftp')->exists($caminhoResidencia)){
                    // Exclui do FTP
                    $deletouNoFtp = Storage::disk('ftp')->delete($caminhoResidencia);
                    if(!$deletouNoFtp){
                        throw new Exception("Erro ao excluir comprovante no FTP!");
                    }
                }
                if(Storage::disk('ftp')->exists($caminhoDocumento)){
                    // Exclui do FTP
                    $deletouNoFtp = Storage::disk('ftp')->delete($caminhoDocumento); 
                    if(!$deletouNoFtp){
                        throw new Exception("Erro ao excluir documento no FTP!");
                    }
                }
            }            
            return redirect()->back()->with('sucessoMsg', "Beneficiário excluído com sucesso!");
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    

     /*issue:496-criar-aba-declaracao-beneficiarios
    * lista todos os dependentes relacionados a um policial
    * Araujo 
    */
    public function reabrirDeclaracaoProvadeVida($idPolicial,$idDeclaracao){
        try{
            $this->PolicialService->reabreDeclaracaoProvadeVida($idPolicial,$idDeclaracao);
            return redirect()->back()->with('sucessoMsg', 'Declaração reaberta com sucesso!');
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function uploadDocAssinatura($idPolicial,$idDeclaracao,Request $request){
        try {
            // Validação do envio do arquivo
            $arquivo = $request->arquivo;
            $nomeArquivo = $arquivo->getClientOriginalName();
            if(isset($request->arquivo)){
                $arquivo = $request->arquivo;
                //verifica se o arquivo é válido
                if($arquivo->isValid()){ 
                    $extensao = $arquivo->getClientOriginalExtension();
                    //verifica se é pdf
                    if($extensao != 'pdf' && $extensao != 'png' && $extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'gif'){ 
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload. O arquivo a ser enviado deve está em formato PDF, PNG, JPG, JPEG ou GIF.');
                    }elseif($arquivo->getClientSize() > 2000000){
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo "'.$nomeArquivo.'" excede o tamanho de 2MB.');
                    }
                    $policial = $this->PolicialService->findPolicialById($idPolicial);
                    $ano = date("Y");
                    $caminho_armazenamento = "RH"."/".str_replace(" ", "", $policial->st_cpf)."/".$ano."/declaracao/provadevida/documentoassinado/";
                    //testa se existe o diretorio do funcionario
                    if(!Storage::disk('ftp')->exists($caminho_armazenamento)){
                        //creates directory
                        Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                    }
                    //gera hash a partir do arquivo
                    $hashNome = hash_file('md5', $arquivo); 
                    //novo nome do arquivo com base no hash
                    $novoNome = $hashNome.'.'.$extensao;
                    //salva arquivo no ftp
                    $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                    if($salvouNoFtp){
                            $dadosForm = [
                                'st_caminhoassinaturapolicial' => $caminho_armazenamento.$novoNome,
                                'ass_manual' => '1',
                            ];
                        $this->PolicialService->uploadDeclaracaoAssinada($idDeclaracao,$dadosForm);
                    }else{
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, erro na base de dados de arquivos.');
                    }
                    return redirect('rh/policiais/edita/'.$idPolicial.'/provadevida')->with('sucessoMsg', Msg::SALVO_SUCESSO);
                }else{
                    return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload do arquivo "'.$nomeArquivo.'", verifique se ele não está corrompido ou o seu tamanho excede 2 MB.');
                }
            }else{
                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo não é válido.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //cb araujo
    // branch - 498
    public function baixarDeclaracaoAssinada(int $registroId, int $idPolicial) {
        try {
            $declaracao = $this->PolicialService->listabeneficiariosProvadeVida($registroId);
            $caminhodocomprovante = $declaracao->st_caminhoassinaturapolicial;
            if(Storage::disk('ftp')->exists($caminhodocomprovante)){
                return Storage::disk('ftp')->download($caminhodocomprovante);
            }else{
                return redirect()->back()->with('erroMsg', Msg::ARQUIVO_NAO_ENCONTRADO);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     /*issue:496-criar-aba-declaracao-beneficiarios
    * lista todos os dependentes relacionados a um policial
    * Araujo 
    */
    public function criaDeclaracaoBeneficiario($idPolicial){
        try{
            $this->authorize('Relatorios_rh');
            $msg = $this->PolicialService->criaDeclaracao($idPolicial,'DEC_BENEFICIARIO');
            if($msg=="Declaração cadastrada com sucesso"){
                return redirect()->back()->with('sucessoMsg', 'Declaração Anual cadastrada com sucesso!');
            } else {
                return redirect()->back()->with('erroMsg', $msg);
            }
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    /*issue:496-criar-aba-declaracao-beneficiarios
    * lista todos os dependentes relacionados a um policial
    * Araujo
    */
    public function viewCadastraBeneficiarios($idPolicial,$idCertidao){
        try{
            $this->authorize('Relatorios_rh');
            $dadosCertidao = $this->PolicialService->CertidaoBeneficiarioById($idCertidao);
            $policial = $dadosCertidao->policial;
            $beneficiarios = $dadosCertidao->beneficiarios;
            return view('rh::policial.cadastrarBeneficiario', compact('policial','idCertidao','beneficiarios')); 
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     /**  
     * @author @Araujo
     *  issue: #496 
     * cadastra um beneficiario numa declaracao anual
    */
    public function cadastrarBeneficiario(Request $request, $idPolicial,$idCertidao){
        $this->authorize('Relatorios_rh');
        try{
            $dadosForm = $request->all();
            //valida form
            $validator = validator($dadosForm, [
                'st_ordem' => 'required',
                'st_nome' => 'required',
                'st_cpf' => 'required',
                'st_sexo' => 'required',
                'dt_nascimento' => 'required',
                'st_mae' => 'required',
                'st_telefone' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //arruma cpf
            $dadosForm['st_cpf'] = str_replace(".","",$dadosForm['st_cpf']);
            $dadosForm['st_cpf'] = str_replace("-","",$dadosForm['st_cpf']);
            //busca pessoa pelo cpf
            $pessoa = $this->DpsService->getPessoaByCPFnoException($dadosForm['st_cpf']);
            if(empty($pessoa)){
                //salva  e recupera pessoa
                $pessoa = $this->DpsService->createPessoa($dadosForm);
            }
            //salva a pessoa como beneficiário
            $dadosForm['ce_pessoa'] = $pessoa->id;
            $msg = $this->PolicialService->salvaBeneficiario($idPolicial,$idCertidao,$dadosForm);
            if(isset($msg->retorno) && $msg->retorno == 'erro'){
                return redirect()->back()->with('erroMsg', $msg->msg);
            } else {
                return redirect()->back()->with('sucessoMsg', 'Beneficiário cadastrado com sucesso!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('eroMsg', $e->getMessage());
        }         
    }


    /**
     * cb Araújo
     * branch: 496
     */
    public function uploadDocumentoBeneficiario($idbeneficiario,$idCertidao,$tipo,Request $request){
        $this->authorize('Relatorios_rh');
        try {
            /**
             * tipo==1 => documento de vinculo familiar
             * tipo==2 => comprovante de residencia
             */
            // Validação do envio do arquivo
            $arquivo = $request->arquivo;
            $nomeArquivo = $arquivo->getClientOriginalName();
            if(isset($request->arquivo)){
                $arquivo = $request->arquivo;
                //verifica se o arquivo é válido
                if($arquivo->isValid()){ 
                    $extensao = $arquivo->getClientOriginalExtension();
                    //verifica se é pdf
                    if($extensao != 'pdf' && $extensao != 'png' && $extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'gif'){ 
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload. O arquivo a ser enviado deve está em formato PDF, PNG, JPG, JPEG ou GIF.');
                    }elseif($arquivo->getClientSize() > 2000000){
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo "'.$nomeArquivo.'" excede o tamanho de 2MB.');
                    }
                    $beneficiario = $this->PolicialService->BeneficiarioById($idCertidao,$idbeneficiario);
                    $dadosCertidao = $this->PolicialService->CertidaoBeneficiarioById($idCertidao);
                    $policial = $dadosCertidao->policial;
                    $ano = date("Y");
                    if($tipo == 1){
                        $caminho_armazenamento = "RH"."/".str_replace(" ", "", $policial->st_cpf)."/".$ano."/declaracaobeneficiarios/".$beneficiario->pessoa->st_cpf."/documento/";
                        $beneficiario->st_caminhoanexo = $caminho_armazenamento;
                    } elseif($tipo == 2){
                        $caminho_armazenamento = "RH"."/".str_replace(" ", "", $policial->st_cpf)."/".$ano."/declaracaobeneficiarios/".$beneficiario->pessoa->st_cpf."/comprovante_residencia/";
                        $beneficiario->st_caminhocomprovanteresidencia = $caminho_armazenamento;
                    }
                    //testa se existe o diretorio do funcionario
                    if(!Storage::disk('ftp')->exists($caminho_armazenamento)){
                        //creates directory
                        Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                    }
                    //gera hash a partir do arquivo
                    $hashNome = hash_file('md5', $arquivo); 
                    //novo nome do arquivo com base no hash
                    $novoNome = $hashNome.'.'.$extensao; 
                    //checa se o arquivo ja existe
                    if(!Storage::disk('ftp')->exists($caminho_armazenamento.$novoNome)){
                        //salva arquivo no ftp
                        $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                        if($salvouNoFtp){
                            //salva dados do arquivo no banco atualizando o beneficiario
                            if($tipo == 1){
                                $dadosForm = [
                                    'st_caminhoanexo' => $caminho_armazenamento.$novoNome,
                                ];
                            } elseif($tipo == 2){
                                $dadosForm = [
                                    'st_caminhocomprovanteresidencia' => $caminho_armazenamento.$novoNome,
                                ];
                            }                            
                            $this->PolicialService->editarBeneficiario($idCertidao,$idbeneficiario,$dadosForm);
                        }else{
                            return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, erro na base de dados de arquivos.');
                        }

                        return redirect('rh/policiais/'.$policial->id.'/cadastra/beneficiarios/'.$idCertidao)->with('sucessoMsg', Msg::SALVO_SUCESSO);

                    }else{
                        return redirect()->back()->with('erroMsg', "Esse arquivo já está cadastrado para este Beneficiário com o nome: ". $nomeArquivo);
                    }
                }else{
                    return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload do arquivo "'.$nomeArquivo.'", verifique se ele não está corrompido ou o seu tamanho excede 2 MB.');
                }
            }else{
                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo não é válido.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }


    /**
     * Método que realiza o download do arquivo.
     * @autor: Araujo
     * @return Response
     */
    public function downloadDocumentoBeneficiario($idCertidao,$idbeneficiario,$tipo)
    {
        $this->authorize('Relatorios_rh');
        try {
            $beneficiario = $this->PolicialService->BeneficiarioById($idCertidao,$idbeneficiario);
            /**
             * tipo==1 => documento de vinculo familiar
             * tipo==2 => comprovante de residencia
             */
            if($tipo==1){
                $caminho = $beneficiario->st_caminhoanexo;
            } elseif($tipo==2){
                $caminho = $beneficiario->st_caminhocomprovanteresidencia;
            }
            //dd($caminho);
            if(Storage::disk('ftp')->exists($caminho)){
                return Storage::disk('ftp')->download($caminho);
            }else{
                return redirect()->back()->with('erroMsg', Msg::ARQUIVO_NAO_ENCONTRADO);
            }
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }


    /**
     * Método que assina a certidão do beneficiario
     * @autor: Araujo
     * @return Response
     */
    public function assinarCertidao($idCertidao, Request $request)
    {
        try {
            $dadosForm = $request->all();
            $dadosCertidao = $this->PolicialService->CertidaoBeneficiarioById($idCertidao);
            $idPolicial = $dadosCertidao->policial->id;            
            if($dadosForm['assinante'] == 'responsavel'){
                $this->authorize('Relatorios_rh');
                //assina usando dados do Sargenteante que está logado e assinando
                $sargenteante = $this->PolicialService->findPolicialByCpfMatricula(auth()->user()->st_cpf);
                $idSargenteante = $sargenteante->id;
                /***Verifica se existe o usuário no AD com as credenciais passadas como parâmetro */
                $authldap = new Authldap();
                $credenciais = array('st_cpf' => auth()->user()->st_cpf, 'password' =>  $dadosForm['senha']);
                $ldap = $authldap->autentica($credenciais);
                if($ldap == false){
                    throw new Exception(Msg::SENHA_INVALIDA);
                }
                /*
                caso o sargenteante que assina for diferente do que iniciou a declaração o responsável
                passa a ser quem assina
                */
                $this->PolicialService->assinaCertidao($idCertidao,$idSargenteante,'responsavel');
                return redirect()->back()->with('sucessoMsg', 'Declaração assinada pelo responsável com sucesso!');
            } else if($dadosForm['assinante'] == 'policial'){
                //assina usando dados do $idPolicial
                $policial = $this->PolicialService->findPolicialById($idPolicial);
                /***Verifica se existe o usuário no AD com as credenciais passadas como parâmetro */
                $authldap = new Authldap();
                $credenciais = array('st_cpf' => $policial->st_cpf, 'password' =>  $dadosForm['senha']);
                $ldap = $authldap->autentica($credenciais);
                if($ldap == false){
                    throw new Exception(Msg::SENHA_INVALIDA);
                }
                $this->PolicialService->assinaCertidao($idCertidao,$idPolicial,'policial');
                return redirect()->back()->with('sucessoMsg', 'Declaração assinada pelo Policial com sucesso!');
            }
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }


    /*issue:496-criar-aba-declaracao-beneficiarios
    * edita a pessoa e os dados do beneficiário
    * Araujo 
    */
    public function editarBeneficiario($idDeclaracao, $idBeneficiario, $idPessoa, Request $request){
        $this->authorize('Relatorios_rh');
        try{
            $dadosForm = $request->all();
            $dados = [ 
                'st_cpf' => $dadosForm['st_cpf2'],
                'st_ordem' => $dadosForm['st_ordem2'],
                'st_nome' => $dadosForm['st_nome2'],
                'st_sexo' => $dadosForm['st_sexo2'],
                'dt_nascimento' => $dadosForm['dt_nascimento2'],
                'st_mae' => $dadosForm['st_mae2'],
                'st_telefone' => $dadosForm['st_telefone2'],
                'st_email' => $dadosForm['st_email2'],
            ];
            $resposta = $this->PolicialService->AtualizarBeneficiario($idDeclaracao, $idBeneficiario, $idPessoa, $dados);
            return redirect()->back()->with('sucessoMsg', 'Beneficiário atualizado com sucesso!');
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

 /*issue:496-criar-aba-declaracao-beneficiarios
    * lista todos os dependentes relacionados a um policial
    * Araujo 
    */
    public function excluirBeneficiario($idPolicial,$idCertidao,$idBeneficiario){
        try{
            $this->authorize('Relatorios_rh');
            //acha o beneficiario
            $beneficiario = $this->PolicialService->BeneficiarioById($idCertidao,$idBeneficiario);
            $caminhoDocumento = $beneficiario->st_caminhoanexo;
            $caminhoResidencia = $beneficiario->st_caminhocomprovanteresidencia;
            //exclui o beneficiario
            if($this->PolicialService->excluirBeneficiario($idCertidao,$idBeneficiario)){
                //exclui os arquivos de ftp do beneficiario
                if(Storage::disk('ftp')->exists($caminhoResidencia)){
                    // Exclui do FTP
                    $deletouNoFtp = Storage::disk('ftp')->delete($caminhoResidencia);
                    if(!$deletouNoFtp){
                        throw new Exception("Erro ao excluir comprovante no FTP!");
                    }
                }
                if(Storage::disk('ftp')->exists($caminhoDocumento)){
                    // Exclui do FTP
                    $deletouNoFtp = Storage::disk('ftp')->delete($caminhoDocumento); 
                    if(!$deletouNoFtp){
                        throw new Exception("Erro ao excluir documento no FTP!");
                    }
                }
            }            
            return redirect()->back()->with('sucessoMsg', "Beneficiário excluído com sucesso!");
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*issue:496-criar-aba-declaracao-beneficiarios
    * imprime uma certidao anual de beneficiarios
    * Araujo 
    */
    public function imprimeCertidaoBeneficiario($idPolicial,$idCertidao){
        try{
            $this->authorize('Relatorios_rh');
            $orgao = 'PM';
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $cpfPolicial = $policial->st_cpf;
            $dadosCertidao = $this->PolicialService->CertidaoBeneficiarioById($idCertidao);
            if(env('ORGAO')){
                $orgao = env('ORGAO');
            }
            if(empty($dadosCertidao->dt_assinaturapolicial) || empty($dadosCertidao->dt_assinaturaresponsavel)){
                return redirect()->back()->with('erroMsg', "A certidão não possui data de assinatura do policial e do responsável.");
            }
            return view('rh::pdf.DeclaracaoAnualBeneficiariospdf', compact('policial','dadosCertidao','orgao')); 
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*issue:496-criar-aba-declaracao-beneficiarios
    * lista todos os dependentes relacionados a um policial
    * Araujo 
    */
    public function reabrirDeclaracao($idPolicial,$idDeclaracao){
        $this->authorize('Relatorios_rh');
        try{
            $this->PolicialService->reabreDeclaracao($idPolicial,$idDeclaracao);
            return redirect()->back()->with('sucessoMsg', 'Declaração reaberta com sucesso!');
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

}







