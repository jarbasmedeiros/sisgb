<?php

namespace Modules\Boletim\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Api\Services\BoletimService;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\NotaService;
use Modules\Api\Services\ArquivoBancoService;
use Modules\Api\Services\UnidadeService;
use Auth;
use App\utis\Status;
use App\utis\Msg;
use App\utis\Funcoes;
use App\Ldap\Authldap;
use Modules\Boletim\Entities\Capa;
use Modules\Boletim\Http\Providers\BoletimServiceProvider;
use Modules\Promocao\Http\Controllers\QuadroDeAcessoController;
use Illuminate\Support\Facades\Storage;
use Session;
use Dompdf\Dompdf;
use Dompdf\Options;
//use Spatie\Async\Pool; para apagar mais tarde

class BoletimController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct(BoletimService $BoletimService, PolicialService $PolicialService, NotaService $notaService, ArquivoBancoService $ArquivoBancoService, Authldap $Authldap){
        $this->middleware('auth');
        $this->BoletimService = $BoletimService;
        $this->PolicialService = $PolicialService;
        $this->ArquivoBancoService = $ArquivoBancoService;
        $this->notaService = $notaService;
        $this->Authldap = $Authldap;
      //  $this->QuadroDeAcessoController = $QuadroDeAcessoController;
        
    }
    /**
     * Método que lista os boletins gerais em elaboração (criada para o cmdte geral)
     * @author Jazon #363
     */
    public function getBGElaboracao(){
        $this->authorize('elabora_bg');
        try{  
            $boletins = $this->BoletimService->getBGElaboracao();
            return view('boletim::boletim/lista_bg_elaboracao', compact('boletins'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
        
        
    }
    /**
     * Método que lista os boletins abertos na unidade.
     */
    public function lista_boletim_pendente($idUnidade=null){
        $this->authorize('elabora_boletim');
        try{        

            $vinculos = auth()->user()->unidadesvinculadas;   
            
            //caso não tenha ou só tenha 1 vinculo oculta o combo
            if(count($vinculos)<=1){
                $vinculos = null;
            }
            $vinculos = null; //retirar isso daqui
            if(empty($idUnidade)) {
                $policial = auth()->user();            
                if(empty($policial->ce_unidade)){
                    throw new Exception(Msg::POLICIAL_SEM_UNIDADE); 
                } 
                $idUnidade = $policial->ce_unidade;                  
            }    
            
            $boletins = $this->BoletimService->lista_boletim_pendente($idUnidade);
            
            return view('boletim::boletim/lista_boletins_elaboracao', compact('boletins','vinculos','idUnidade'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function index($boletins = null, $dadosForm = null){
        try {
            if(empty($boletins)){
                $boletins = $this->BoletimService->listaBoletimPublicados();
            }
            $tiposBoletins = $this->BoletimService->gettiposboletins();
            $unidades = $this->BoletimService->listaUnidadesOperacionais();
            if(empty(auth()->user()->ce_unidade)){
                return redirect()->back()->with('erroMsg', 'Policial sem unidade vinculada.');
            }
            if(isset($dadosForm['page'])){
                $dadosForm = Session::get('dadosForm');
            }
            
            return view('boletim::index', compact('boletins', 'tiposBoletins', 'unidades', 'dadosForm'));

        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function cancelarPublicacao(Request $request){ //aqui
        try{
            $idBoletim = $request->idBoletim;
            $st_motivocancelamento = $request->st_motivocancelamento;
            $dadosForm = array(
                "idBoletim" => $idBoletim,
                "st_motivocancelamento" => $st_motivocancelamento
            );
            //dd($dadosForm);
            $msg =  $this->BoletimService->cancelarBoletim($idBoletim,$dadosForm);
            //dd($resposta);
            return redirect('/boletim/consulta')->with('sucessoMsg',$msg);            
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    /**
     * Busca os boletins de acordo com os criterios de filltros apresentados
     * Retorna a action index() com uma nova lista de boletins
     * @autor: Talysson
     */
    public function findBoletim(Request $request){
        try {
                        
            $dadosForm = $request->all();
            foreach ($dadosForm as $key => $value) {
                if(empty($value)){
                    unset($dadosForm[$key]);
                }
            }
            
            $permissoes = auth()->user()->permissoes;
            $policialLogado = auth()->user();
           
            if ($dadosForm['ce_tipo'] == '3' || $dadosForm['ce_tipo'] == '6') {
                if (in_array('PUBLICACOES_RESERVADAS', $permissoes)) {
                    //segue o fluxo
                } elseif (in_array('PUBLICACOES_RESERVADAS_DA_OPM', $permissoes)) {
                    if ($dadosForm['ce_unidade'] == $policialLogado->ce_unidade) {
                        //segue o fluxo
                    } else {
                        throw new Exception('Sem permissão para acessar boletim reservado de outra unidade.');
                    }
                } else {
                    throw new Exception('Sem permissão para acessar boletim reservado.');
                }
                
            } 
            
            $boletins = $this->BoletimService->findBoletinsPublicadosPaginado($dadosForm);
            
            if(empty($boletins)){
                $boletins = ["vazio"];
            }
            if(!isset($dadosForm['page'])){
                Session::put('dadosForm', $dadosForm);
            }

            return $this->index($boletins, $dadosForm, $policialLogado);

        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(){

        $this->authorize('elabora_boletim');
        try{
            //buscando os tipos de boletins
            $tipos = $this->BoletimService->gettiposboletins();
            $data = date("Y-m-d");
            return view('boletim::boletim/form_boletim', compact('tipos','data'));
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }

    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function createAditamentoAoBoletim($idBoletim){

        $this->authorize('elabora_boletim');
        try{
            //buscando os tipos de boletins
            $tipos = $this->BoletimService->gettiposboletins();
            $data = date("Y-m-d");
            return view('boletim::boletim/form_boletim', compact('tipos', 'idBoletim','data'));
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }

    }
   
    //Cria um novo boletim
    public function store(Request $request){
        $this->authorize('elabora_boletim');
        try{
            $dadosform = $request->all();
            $validator = validator($dadosform, [
                'ce_tipo' => "required",
                ]);                
            if ($validator->fails()) {
                return redirect()->back()
                //mostrando o erro no form Create
                ->withErrors($validator)
                //retornando os dados do formulário deixando preenchido
                ->withInput();
            }
            if($dadosform['ce_tipo'] == 7){
                if(!isset( $dadosform['ce_pai'])){

                    return redirect()->back()->with('erroMsg', 'Por favor informe o boletim ao qual o aditamento é vinculuado');
                }
            }
            
            $policial = auth()->user();
            
            if(empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', MSG::POLICIAL_SEM_UNIDADE);
            }
             $this->BoletimService->criarBoletim($dadosform, $policial->ce_unidade);
            return redirect()->route('boletinsemelaboacao')->with('sucessoMsg', MSG::BOLETIM_GERADO);
           
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id){ 
        $this->authorize('elabora_boletim'); 
        try{
           
            //Verifica se existe o boletim
            $boletim =  $this->BoletimService->getBoletimId($id);
            if($boletim->tipo->st_sigla == 'BG'){
                $this->authorize('elabora_bg'); 
            }elseif($boletim->tipo->st_sigla == 'BR'){
                $this->authorize('elabora_boletim_reservado'); 

           }
            if(empty($boletim)){
                return redirect()->back()->with('erroMsg', MSG::BOLETIM_NAO_ENCONTRADO);
            }elseif($boletim->st_status == Status::BOLETIM_PUBLICADO){
                
                return redirect()->back()->with('erroMsg', MSG::BOLETIM_JA_PUBLICADO);
            }
           
            //Verifica se o boletim é da unidade operacional do usuário logado
            if($boletim->tipo->st_sigla != 'BG'){
                $funcao = new Funcoes;
                $funcao->verificaVinculoDoUsuarioComUnidade($boletim->ce_unidade);
            }

            // lista as notas atribuídas ao boletim
            $notas = $this->BoletimService->getNotasAtribuidasBoletim($id);
            $topicos = $this->BoletimService->getTopicosBoletim();
            return view('boletim::boletim/elaborar', compact('notas', 'boletim', 'topicos'));
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    

    //método que atritui notas ao boletim
    public function selecionaNotasParaBoletim($idBoletim){
        $this->authorize('elabora_boletim');
        try{
            $boletim =  $this->BoletimService->getBoletimId($idBoletim);
            if(isset($boletim->retorno)){
                return redirect()->back()->with('erroMsg', MSG::BOLETIM_NAO_ENCONTRADO);
            }elseif(($boletim->st_status == Status::BOLETIM_PUBLICADO) || ($boletim->st_status == Status::BOLETIM_ASSINADO)) {
                return redirect()->back()->with('erroMsg', MSG::BOLETIM_JA_PUBLICADO);
            }
            
            //Verifica se o boletim é da unidade operacional do usuário logado
            $policial = auth()->user();
            if(empty($policial)){
            return redirect()->back()->with('erroMsg', MSG::USUARIO_NAO_E_POLICIAL);
            }
            //verifica se o policial é vincualdo a Unidade do boletim
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($boletim->ce_unidade);
            // lista as notas atribuídas ao boletim
            $notas = $this->notaService->listaNotasParaAtribuir($policial->ce_unidade, $idBoletim);
            $topicos = $this->BoletimService->getTopicosBoletim();
          
            return view('boletim::notas/atribuir', compact('idBoletim', 'notas', 'topicos'));
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }
        //Verifica se existe o boletim
        
    }

    //Atribui nota ao Boletim
    public function atribuirNota(Request $request, $idBoletim, $idNota){  
        $this->authorize('elabora_boletim');
        try{
            if(!$request->input('ce_topico') || empty($request->input('ce_topico'))){
                return redirect()->back()->with('erroMsg', 'Informe o tópico do boletim ao qual a nota é vinculada');
            }
            
            $boletim =  $this->BoletimService->getBoletimId($idBoletim);
            if(isset($boletim->retorno)){ //Verifica se existe o boletim
                return redirect()->back()->with('erroMsg', $boletim->msg);
            }
            //verifica se o policial é vincualdo a Unidade do boletim
           // $funcao = new Funcoes;
            //$funcao->verificaVinculoDoUsuarioComUnidade($boletim->ce_unidade);
            
            $nota =  $this->notaService->getNotaId($idNota);
            if(isset($nota->retorno)){ //Verifica se existe a nota
                return redirect()->back()->with('erroMsg', $nota->msg);
            }
            $topico = $request->input('ce_topico');
            //Atribui a nota ao boletim
            $this->BoletimService->atribuirNotaAoBoletim($idBoletim, $nota->id, $topico);
            return redirect('boletim/atribuirnotas/'.$idBoletim)->with('sucessoMsg', MSG::NOTA_ATRIBUIDA);
           
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        

    }

    //Remove nota do Boletim
    public function removerNota($idNota, $idBoletim){  
        $this->authorize('elabora_boletim');
        try{
            $dados = ['idUsuario' => Auth::User()->id];
            //Remove a nota do boletim
             $this->notaService->removeNotasDoboletim($idBoletim, $idNota, $dados);
                return redirect('boletim/edit/'.$idBoletim)->with('sucessoMsg', MSG::NOTA_REMOVIDA); 
            
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    //altera parte da nota
    public function alteraParteNota($idNota, $topico, $idBoletim){
        $this->authorize('elabora_boletim');
        try
        {
            $alteraPartenota =  $this->notaService->alteraParteNotasDoboletim($idBoletim, $idNota, $topico);
            return 1;
           
        }catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id){
        $this->authorize('elabora_boletim');
        try
        {
            $boletim = $this->BoletimService->getBoletimId($id);
            if(empty($boletim)){
                return redirect()->back()->with('erroMsg', MSG::BOLETIM_NAO_ENCONTRADO);
            }elseif($boletim->st_status == Status::BOLETIM_PUBLICADO){
                return redirect()->back()->with('erroMsg', MSG::ERRO_AO_EXCLUIR_BOLETIM);

            }
            
            //verificando se o boletim tem unidade atribuida
            $notasAtribuidas =  $this->BoletimService->getNotasAtribuidasBoletim($id);
            
            foreach( $notasAtribuidas as $n){
                if(count($n) > 0){
                    return redirect()->back()->with('erroMsg', MSG::ERRO_AO_EXCLUIR_BOLETIM);
                    //throw new Exception($response->msg);
                }
            }
        
            //verifica se o policial é vincualdo a Unidade do boletim
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($boletim->ce_unidade);

            $deleta =  $this->BoletimService->deletaBoletim($id);
                return redirect()->route('boletinsemelaboacao')->with('sucessoMsg', MSG::BOLETIM_EXCLUIDO);
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    

    //método que assina  boletim
    public function assinar(Request $request, $idBoletim){
        try
        {
            $boletim = $this->BoletimService->getBoletimId($idBoletim);
            if($boletim->tipo->st_sigla == 'BG'){
                $this->authorize('assina_bg');
            }else{
                $this->authorize('assina_boletim');
                //verifica se o policial é vincualdo a Unidade do boletim
            //  $funcao = new Funcoes;
             //   $funcao->verificaVinculoDoUsuarioComUnidade($boletim->ce_unidade);
            }
           

            $cpf = Auth::user()->st_cpf;
            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', MSG::SENHA_OBRIGATORIA); 
            }
            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', MSG::SENHA_INVALIDA); 
            }
            $dados = ['st_cpf' => $cpf, 'st_password' => $request['password']];
           
            
            $assinaBoletim =  $this->BoletimService->AssinaBoletim($idBoletim, $dados);
            return redirect()->back()->with('sucessoMsg', MSG::BOLETIM_ASSINADO);

        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

    public function visualizaBoletim($id){
        try{
            $dados =  $this->BoletimService->visualizaBoletim($id);
            $boletim = $dados->boletim;
            if($boletim->st_status == Status::BOLETIM_PUBLICADO){
                $this->authorize('Leitura');
                return Storage::disk('ftp')->response($boletim->st_caminho . $boletim->st_arquivo . '.pdf');
            }
            //dd($dados);
            if( $boletim->ce_tipo == 7){
                if(!empty($boletim->pai)){

                    $boletim->pai->nu_sequencial = str_pad($boletim->pai->nu_sequencial, 3 , '0' , STR_PAD_LEFT);
                }else{
                    throw new Exception("Boletim pai do aditamento não encontrado.");
                }
            }else{
                $boletim->nu_sequencial = str_pad($boletim->nu_sequencial, 3 , '0' , STR_PAD_LEFT);
            }
            $this->authorize('elabora_boletim');

            //verifica se o policial é vincualdo a Unidade do boletim
            if($boletim->ce_tipo ==1){
                $this->authorize('elabora_bg');
            }else{
                $funcao = new Funcoes;
                $funcao->verificaVinculoDoUsuarioComUnidade($boletim->ce_unidade);
            }
            $capa = $dados->capa;
            if(empty($capa)){
                throw new Exception(Msg::BOLETIM_CAPA_NAO_ENCONTRADA);
            }
            $img = "";
            //Verifica se existe o brasão na capa e caso exista, o atribui a $img
            if(!empty($capa) && Storage::disk('ftp')->exists($capa->st_brasao)){
                $image = Storage::disk('ftp')->get($capa->st_brasao); // ftp
                $img = base64_encode($image);
            }
       
            //Elabora o nome do boletim
            if( $boletim->ce_tipo == 7){
                $boletim->st_nome = $boletim->tipo->st_tipo. " AO ". $boletim->pai->tipo->st_tipo  . " N°". sprintf('%03d', $boletim->pai->nu_sequencial);
                //Elabora a sigla a ser exibida a partir da página 02
                $boletim->st_siglaCabecalho = $boletim->tipo->st_sigla. " ao ". $boletim->pai->st_sigla  . " N° ". sprintf('%03d', $boletim->pai->nu_sequencial);
               // $boletim->st_siglaCabecalho = $boletim->tipo->st_sigla . " Nº " . sprintf('%03d', $boletim->nu_sequencial);

            }else{

                $boletim->st_nome = $boletim->tipo->st_tipo . " Nº " . sprintf('%03d', $boletim->nu_sequencial);
                //Elabora a sigla a ser exibida a partir da página 02
                $boletim->st_siglaCabecalho = $boletim->tipo->st_sigla . " Nº " . sprintf('%03d', $boletim->nu_sequencial);
            }

            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
            //formata a data do boletim para ser exibida por extenso
            $boletim->dt_porExtenso =Funcoes::titleCase( utf8_encode(strftime("%d de %B de %Y" , strtotime($boletim->dt_boletim))));
            //Resgata o dia da semana da data do boletim
            $boletim->dt_diaDaSemana =  ucwords(utf8_encode(strftime("%A" ,strtotime($boletim->dt_boletim))));
            $notas = $dados->notas;
            $contador = 1;
            $marcadagua = "";
            if($boletim->st_status != Status::BOLETIM_PUBLICADO && $boletim->st_status != Status::BOLETIM_ASSINADO){
                $marcadagua = "Rascunho por: " .Auth::user()->st_cpf;
            }elseif ($boletim->st_status != Status::BOLETIM_PUBLICADO && $boletim->st_status == Status::BOLETIM_ASSINADO) {
                $marcadagua = Auth::user()->st_cpf;
            }
          // dd($marcadagua);
            return View('boletim::boletim/visualiza_pdf_domPdf', compact('boletim', 'notas', 'contador', 'marcadagua', 'capa', 'img'));

        }catch(Exception $e) {
            return redirect('boletim/consulta')->with('erroMsg', $e->getMessage());
        }
    }
    
    public function consultarpolicial($userParam)
    {
        try {
         $consultar = $this->BoletimService->consultarPolicial($userParam);
         
         return response()->json($consultar);
         
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
            }
    }

    //@marcos_paulo #311 22/04/21
    //separando em um método a geração do pdf para retornar o arquivo salvo localmente
    function gerarPDF($caminhoFinalArquivo, $boletim, $notas, $contador, $marcadagua, $capa, $img){
        function numberToRoman($num){    
            // Be sure to convert the given parameter into an integer
            $n = intval($num);
          
            $result = ''; 
            // Declare a lookup array that we will use to traverse the number: 
            $lookup = array(
                'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 
                'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 
                'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
            ); 
            
            foreach ($lookup as $roman => $value){
                // Look for number of matches
                $matches = intval($n / $value); 
              
                // Concatenate characters
                $result .= str_repeat($roman, $matches); 
               
                // Substract that from the number 
                $n = $n % $value; 
              
                
            } 
           
            return $result; 
        }
      
        function desenharNotasDeUmaParte($parte,$numParte){
            $topicoAtual = '';
            global $contadorTopicos ;
            if(empty($contadorTopicos)){
                $contadorTopicos =1;
            }   
            $tituloParte = array(
                1=>'(Serviços Diários)',
                2=>'(Ensino e Instrução)',
                3=>'(Assuntos Gerais e Administrativos)',
                4=>'(Justiça e Disciplina)');
    
            $txtNotas = '<div class="parte" style="font-family: "Times New Roman", Times, serif;">
                <div class="centralizado tituloParte">'.$numParte.'ªPARTE</div>
                <div class="centralizado">'.$tituloParte[$numParte].'</div>';
    
            if(count($parte) > 0){
                foreach($parte as $nota){
                //  dd($nota->st_topico);
                    if($topicoAtual != $nota->st_topico){
                        $txtNotas = $txtNotas.'<br/><div class="assunto_nota" style="font-weight:bold;"><div class="row"><div class="col" style="width: 30px; float: left; display: inline-block;"><div class="col" style="width: 12px; float: left; display: inline-block; letter-spacing: -1px;">'.numberToRoman($contadorTopicos).'</div><div class="col" style="width: 20px; float: left; display: inline-block; text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-</div></div><div class="col" style="float: left; display: inline-block;">&nbsp;&nbsp;&nbsp;<span style="text-decoration: underline;">'.$nota->st_topico.'</span></div></div></div>';
                            
                        $topicoAtual = $nota->st_topico;
                        $contadorTopicos++;
                        
                    }
                    $txtNotas = $txtNotas.'<div class="notaCompleta" style="font-size: 11pt">'.$nota->st_notacompleta.'</div>';
                    
                    $txtNotas = $txtNotas.'<br/>';
                }
                //$contadorTopicos++;
            }else{                    
                $txtNotas = $txtNotas.'<div class="titulo_parte" style="text-align:center;">Sem Alteração</div><br/>';
            }
            $txtNotas = $txtNotas.'</div>';
            
            return $txtNotas;
        }
    
        ini_set("pcre.backtrack_limit", "5000000");//aumenta o limite de caracteres na string
        ob_clean();//limpa o buffer de saída
    
        $parteCapa = '<div class="capa">
        <br/>
            <div class="cabecalho">'
                .$capa->st_cabecalho
            .'</div><br/>
            <div class="centralizado" >
                <img src="data:image/jpg/jpeg/png;base64,'.$img.'" alt="Brasão PMRN" height="327" width="290" style="margin: 0px 0px 0px 0px;">
            </div><br/>
            <div class="centralizado">'
                . strtoupper($boletim->st_nome)        
            .'</div><br/>
            <div class="centralizado">'
                . $capa->st_cidade.'/RN, '.$boletim->dt_porExtenso.'</div><br/>
            <div class="centralizado">('.$boletim->dt_diaDaSemana.')</div><br/>
            <div class="line-heigt-10">'
                .$capa->st_funcoes
            .'</div></div>';
            
            $pageno = '{PAGENO}';
            
            $paginacao = str_pad('{PAGENO}' , 3 , '0' , STR_PAD_LEFT);
            if($paginacao < 10){
                $paginacao = '00'.$paginacao;
            }elseif($paginacao>=10 && $paginacao<100){
                $paginacao = '0'.$paginacao;
            }
            //dd($paginacao);
            $header = '
            <htmlpageheader name="myHeader1">
                <div style="position: absolute; top: 120px; width: 72%;" width="100%">
                    <div style="display: inline; width: 100%; text-align: center;">'.$boletim->st_siglaCabecalho.', de '.$boletim->dt_porExtenso.'</div>
                    <div class="paginacao" style="display: inline; width: 2%; text-align: right;">'.$pageno.'</div>
                </div>
            </htmlpageheader>
            <htmlpageheader name="myHeader2">
                <table width="100%">
                    <tr>
                    </tr>
                </table>
            </htmlpageheader>';
    
        $txtAberturaBg = '<div style="text-align:center;"><strong>Para conhecimento e devida execução, torno público o seguinte:</strong></div><br/>';
        $assinaturaBoletim = '<div style="text-align:center;">Assinado eletronicamente por <br/>'.$boletim->st_responsavelassinatura.', '.$boletim->st_postograduacaoassinante.'<br/>'.$boletim->st_funcaoassinante.'</div>';
     
        $contador = 1;
        $contadorTopicos = 1;

        //início do pdf
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkText($marcadagua,0.2);
        $mpdf->showWatermarkText  = true;
        
        //funções que reduzem o tempo de processamento do pdf
        $mpdf->useSubstitutions=false; 
        $mpdf->simpleTables = true;
        
        $css = file_get_contents('assets/css/pdf_boletim.css');
        $mpdf->WriteHTML($css, 1); 
        
        $mpdf->setTitle( $boletim->st_siglaCabecalho.'/'.$boletim->nu_ano);
        //$mpdf->setAuthor('SisGp_PM_RN');
        $mpdf->WriteHTML($header);
        $mpdf->WriteHTML($parteCapa);
        //$mpdf->AddPage();
    
        //$mpdf->AddPage('', '', 1, '', 'on');
        //$mpdf->WriteHTML($txtDaPaginacao);
        $mpdf->WriteHTML($txtAberturaBg);   
    
        $mpdf->WriteHTML(desenharNotasDeUmaParte($notas->parte1,1));
        $mpdf->WriteHTML(desenharNotasDeUmaParte($notas->parte2,2));
        $mpdf->WriteHTML(desenharNotasDeUmaParte($notas->parte3,3));
        $mpdf->WriteHTML(desenharNotasDeUmaParte($notas->parte4,4)); 
        if($boletim->st_status != 'ABERTO' && $boletim->st_status != 'FINALIZADO'){
            $mpdf->WriteHTML($assinaturaBoletim);  
        }
      
    
        ob_end_clean();//limpa o buffer
    
        /*
        * ESSA LINHA DE CÓDIGO SALVA O PDF NA PASTA STORAGE
        */
        $salvarBoletimPdf = explode('public', public_path())[0].'storage/app/'.$caminhoFinalArquivo;
    
        $mpdf->Output($salvarBoletimPdf, 'F');      //salva o pdf na pasta storage/app/
                             
        $arquivo_boletim_pdf = Storage::disk('local')->exists($caminhoFinalArquivo);      // recupera o arquivo pdf

        //testa se o arquivo está realmente na pasta e prepara para gerenciar os erros
        if($arquivo_boletim_pdf){
            $erro = false;
        }else{
            $erro = 'Falha ao salvar o arquivo no local, verifique as permissões da pasta do projeto.';
            $request->session()->flash('erroMsg', $erro);
        }

        return $erro;
//        exit();
    }


    //método que Publica  boletim
    public function publicarBoletim(Request $request, $idBoletim){
        try{
            $cpf = Auth::user()->st_cpf;
            if(!isset($request['password'])){
                throw new Exception(MSG::SENHA_OBRIGATORIA);
            }
            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                throw new Exception(MSG::SENHA_INVALIDA);
            }
            $boletim = $this->BoletimService->getBoletimId($idBoletim);
            //dd($boletim);
            if(empty($boletim)){
                throw new Exception(MSG::BOLETIM_NAO_ENCONTRADO);
            }elseif($boletim->st_status != Status::BOLETIM_ASSINADO) {
                throw new Exception("O boletim só pode ser Publicado se estiver com status de Assinado");
            }

            //VERIFICANDO PERMISSÕES
            if($boletim->tipo->st_sigla == 'BG'){
                $this->authorize('publica_bg');
            }else{
                $this->authorize('publica_boletim');
               
                //verifica se o policial é vincualdo a Unidade do boletim
                //$funcao = new Funcoes;
               // $funcao->verificaVinculoDoUsuarioComUnidade($boletim->ce_unidade);
            }
            $policial = auth()->user();
            /*
            if( $boletim->ce_unidade != $policial->ce_unidade){
                throw new Exception(MSG::USUARIO_DE_OUTRA_UNIDADE);
            } */

            $capa = $this->BoletimService->getCapaBoletim($boletim->ce_tipo, $boletim->ce_unidade);
            if(empty($capa)){
                throw new Exception(Msg::BOLETIM_CAPA_NAO_ENCONTRADA);
            }
            $img = "";
            //Verifica se existe o brasão na capa e caso exista, o atribui a $img
            if(!empty($capa) && Storage::disk('ftp')->exists($capa->st_brasao)){
                $image = Storage::disk('ftp')->get($capa->st_brasao); // ftp
                $img = base64_encode($image);
            }

            //Elabora o nome do boletim
            if( $boletim->ce_tipo == 7){
                $boletim->st_nome = $boletim->tipo->st_tipo. " AO ". $boletim->pai->tipo->st_tipo  . " N° ". sprintf('%03d', $boletim->pai->nu_sequencial);

                 //Elabora a sigla a ser exibida a partir da página 02
                 $boletim->st_siglaCabecalho = $boletim->tipo->st_sigla. " ao ". $boletim->pai->st_sigla  . " N° ". sprintf('%03d', $boletim->pai->nu_sequencial);
            }else{

                $boletim->st_nome = $boletim->tipo->st_tipo . " Nº " . sprintf('%03d', $boletim->nu_sequencial);
            
                //Elabora a sigla a ser exibida a partir da página 02
                $boletim->st_siglaCabecalho = $boletim->tipo->st_sigla . " Nº " . sprintf('%03d', $boletim->nu_sequencial);
            }
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
            //formata a data do boletim para ser exibida por extenso
            $boletim->dt_porExtenso = Funcoes::titleCase( utf8_encode(strftime("%d de %B de %Y" , strtotime($boletim->dt_boletim))));
            //Resgata o dia da semana da data do boletim
            $boletim->dt_diaDaSemana =  ucwords(utf8_encode(strftime("%A" ,strtotime($boletim->dt_boletim))));
            $notas = $this->BoletimService->getNotasAtribuidasBoletimComPolicial($idBoletim);

            $contador = 1;
            $marcadagua = "";
            set_time_limit(0);//remove limite de espera
            
            $caminho_armazenamento = date('Y')."/boletim/".$boletim->tipo->st_sigla."/".$policial->ce_unidade."/".date('m')."/"; //Ano/boletim/siglatipoboletim/idunidade/mes/nomedoboletim
            $extensao = "pdf";
            //testa se existe o diretorio do funcionario
            if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                //creates directory
                Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
            }
            
            if(!Storage::disk('local')->exists($caminho_armazenamento)){ 
                //creates directory
                Storage::disk('local')->makeDirectory($caminho_armazenamento, 0775, true); 
            }
            
            $stringhash = $policial->matricula.date("Y-m-d H:i:s");
            $hashNome = hash('md5', strval($stringhash));
            
            //novo nome do arquivo com base no hash
            $novoNome = $hashNome.'.'.$extensao;
            $dadosArquivo = [
                'st_modulo' => 'BOLETIM',
                'st_motivo' => 'PUBLICAR_BOLETIM',
                'dt_envio' => date('Y-d-m H:i:s'),
                'st_arquivo' => $hashNome,
                'st_extensao' => $extensao,
                'st_descricao' => $boletim->st_nome,
                'st_pasta' => $caminho_armazenamento,
            ];
            // salva o pdf no ftp
            $caminhoFinalArquivo = $caminho_armazenamento.$novoNome;

            $dados = ['st_cpf' => $cpf, 'st_password' => $request['password'], 'st_caminho' => $caminho_armazenamento, 'st_arquivo' => $hashNome, 'dadosArquivo' => $dadosArquivo];
            
            //erro recebe o gerarPDF, pois o return é a var '$erro' que a cada etapa do publicar pode receber a str do erro encontrado
            $erro = $this->gerarPDF($caminhoFinalArquivo, $boletim, $notas, $contador, $marcadagua, $capa, $img);
    
            //se erro igual a false, entra no if
            if($erro != true){
                try{
                    $arquivo_boletim_pdf = Storage::get($caminhoFinalArquivo);      //recupera o arquivo pdf da pasta local

                    Storage::disk('ftp')->put($caminhoFinalArquivo, $arquivo_boletim_pdf, 'private'); //pega o pdf na pasta local e copia para o servidor ftp

                    $msgPublicaBoletim = $this->BoletimService->publicarBoletim($idBoletim, $dados);

                    Storage::delete($caminhoFinalArquivo);    //apaga da pasta o arquivo local, depois de enviado ao ftp

                    $request->session()->flash('sucessoMsg', $msgPublicaBoletim);
                    return response()->json(['success'=>true, 'message' => $msgPublicaBoletim,'url'=> route('editaBoletim', ['id' => $idBoletim])]);
                } catch(Exception $e) {
                    $erro = "Houve algum erro no upload do pdf para o servidor de arquivos ".$e->getMessage();
                    throw new Exception($erro);
                }
            }
            
        }catch(Exception $e) {
            $request->session()->flash('erroMsg', $e->getMessage());
            return response()->json(['success' => false, 'message' => $e, 'url' => route('editaBoletim', ['id' => $idBoletim])]);
        }
    }

    //método que Retorna boletim para Elaboração
    public function retornaBoletimParaElaboracao($idBoletim){
        $this->authorize('elabora_boletim');
        
        try{
            $retornaBoletim = $this->BoletimService->RetornaBoletimParaElaboracao($idBoletim);
            
            return redirect()->back()->with('sucessoMsg', MSG::ATUALIZADO_SUCESSO);
            
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

    
        /**
         * Método que finaliza o boletim
         * @Autor: Ataíde
         */   
    public function finalizarBoletim($idBoletim){
        $this->authorize('elabora_boletim');
        try{
            $boletim = $this->BoletimService->getBoletimId($idBoletim);
            $capa = $this->BoletimService->getCapaBoletim($boletim->ce_tipo, $boletim->ce_unidade);
            if(empty($capa)){
                throw new Exception(Msg::BOLETIM_CAPA_NAO_ENCONTRADA);
            }

            $finalizaBoletim = $this->BoletimService->finalizaBoletim($idBoletim);
            
            return redirect()->back()->with('sucessoMsg', MSG::ATUALIZADO_SUCESSO);
            
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        
    }

    public function editCapaBoletim($idBoletim, $tipoBoletim){
        $this->authorize('elabora_boletim');
        try{
            //Retorna o policial que está logado no momento
            $policial = auth()->user();
            //Busca capa com base nos dados do policial logado
            $capa = $this->BoletimService->getCapaBoletim($tipoBoletim, $policial->ce_unidade);
            //verifica se o policial é vincualdo a Unidade do boletim
            $img = "";
            $funcao = new Funcoes;
            if($capa != ''){
                $funcao->verificaVinculoDoUsuarioComUnidade($capa->ce_unidade);
                // Pegando imagem do ftp para exibir no pdf
                    if(!empty($capa) && Storage::disk('ftp')->exists($capa->st_brasao)){
                        $image = Storage::disk('ftp')->get($capa->st_brasao); // ftp
                        $img = base64_encode($image);
                    }
    
            }

                
           
            return view('boletim::boletim/capa', compact('capa', 'idBoletim', 'tipoBoletim', 'img'));
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function updateCapaBoletim(Request $request, $idBoletim, $idCapa){
        $this->authorize('elabora_boletim');
        try{
           $dadosForm = $request->all();
           
            //Recupera a capa
            $capa =  $this->BoletimService->getCapaId($idCapa);
            //Validadação dos requestes
            $validator = validator($dadosForm, [
                "st_cabecalho" => "required",
                "st_funcoes"   => "required",
                "st_cidade"   => "required",
            ]);
            //Verifica se ocorreu erro nas validações
            if ($validator->fails()) {
                return redirect()->back()->with('erroMsg', 'Preencher os campos obrigatórios')
                //mostrando o erro no form
                ->withErrors($validator)
                //retornando os dados do formulário deixando-o preenchido
                ->withInput();
            } 
          
            //upload da imagem
            $arquivo = $request->file('input_img');
            if(!$request->file() == null){
                //testa se o arquivo tem o tipo como null, se for null o upload excedeu o limite de 2MB
                if($arquivo->gettype()){
                    //mesmo que se chame getSize, é um teste de arquivo corrompido, exemplo: se criar um txt vazio e nomear como txt.jpg
                    if($arquivo->getSize()){
                        if($arquivo->isValid()){ 
                            $extensao = $arquivo->getClientOriginalExtension();
                            // verifica se é imagem
                            if($extensao == 'jpeg' || $extensao == 'jpg' || $extensao == 'png' || $extensao == 'PNG'){
                                $caminho_armazenamento = "boletim/tipo_" . $capa->ce_tipoboletim . "/unidade_" . $capa->ce_unidade . "/";
                                //testa se existe o diretorio do funcionario
                                if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                                    //creates directory
                                    Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                                }
                                //gera hash a partir do arquivo
                                $hashNome = hash('md5', strval($capa->ce_unidade));
                                //novo nome do arquivo com base no hash
                                $novoNome = $hashNome.'.'.$extensao;
                                //checa se o arquivo ja existe

                                try{
                                    Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen($arquivo, 'r+'));
                                    $dadosForm['st_brasao'] = $caminho_armazenamento.$novoNome;
                                }catch(Exception $e){
                                    throw new Exception('Falha ao realizar o upload, erro na base de dados.');
                                }
                            }else{
                                throw new Exception('Falha ao realizar o upload, os formatos permitidos são jpg, jpeg ou png');
                            }
                        }else{
                            throw new Exception('Falha ao realizar o upload, o arquivo não é válido');
                        }
                    }else{
                        throw new Exception('Falha ao realizar o upload, o arquivo está corrompido');
                    }
                }else{
                    throw new Exception('Falha ao realizar o upload, o arquivo excede o tamanho de upload de 2MB');
                }
            }
            $capaAtualizada = $this->BoletimService->updateCapaBoletim($dadosForm, $capa->id);
            return redirect('/boletim/edit/' . $idBoletim)->with('sucessoMsg', MSG::CAPA_ATUALIZADA);
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    

    public function storeCapaBoletim(Request $request, $tipoBoletim){
        $this->authorize('elabora_boletim');
        try{
            //Retorna o policial que está logado no momento
            $policial = auth()->user();
            $dadosForm = $request->all();
            //Validadação dos requestes
            $validator = validator($dadosForm, [
                "st_cabecalho" => "required",
                "st_funcoes"   => "required",
                "input_img"    => "required",
                ]);

            //Verifica se ocorreu erro nas validações
            if ($validator->fails()) {
                return redirect()->back()
                //mostrando o erro no form
                ->withErrors($validator)
                //retornando os dados do formulário deixando-o preenchido
                ->withInput();
            }    

            //upload da imagem
            $arquivo = $request->file('input_img');
            //Validação do input da imagem
            if(!$request->file() == null){
                //testa se o arquivo tem o tipo como null, se for null o upload excedeu o limite de 2MB
                if($arquivo->gettype()){
                    //mesmo que se chame getSize, é um teste de arquivo corrompido, exemplo: se criar um txt vazio e nomear como txt.jpg
                    if($arquivo->getSize()){
                        if($arquivo->isValid()){ 
                            $extensao = $arquivo->getClientOriginalExtension();
                            // verifica se é imagem
                            if($extensao == 'jpeg' || $extensao == 'jpg' || $extensao == 'png' || $extensao == 'PNG'){
                                $caminho_armazenamento = "boletim/tipo_" . $tipoBoletim . "/unidade_" . $policial->ce_unidade . "/";
                                //testa se existe o diretorio do funcionario
                                if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                                    //creates directory
                                    Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                                }
                                //gera hash a partir do arquivo
                                $hashNome = hash('md5', strval($policial->ce_unidade)); 
                                //novo nome do arquivo com base no hash
                                $novoNome = $hashNome.'.'.$extensao; 
                                try{ 
                                    //salva arquivo no ftp
                                    Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+'));
                                    $dadosForm += ["st_brasao" => $caminho_armazenamento.$novoNome];
                                }catch(Exception $e){
                                    throw new Exception('Falha ao realizar o upload, erro na base de dados.');
                                }
                            }else{
                                throw new Exception('Falha ao realizar o upload, os formatos permitidos são jpg, jpeg ou png');
                            }
                        }else{
                            throw new Exception('Falha ao realizar o upload, o arquivo não é válido');
                        }
                    }else{
                        throw new Exception('Falha ao realizar o upload, o arquivo está corrompido');
                    }
                }else{
                    throw new Exception('Falha ao realizar o upload, o arquivo excede o tamanho de upload de 2MB');
                }
            }
            $dadosForm += ["ce_unidade" => $policial->ce_unidade];
            $dadosForm += ["ce_tipoboletim" => $tipoBoletim];
            

            $capaCriada = $this->BoletimService->createCapaBoletim($tipoBoletim, $policial->ce_unidade, $dadosForm);

            return redirect('boletim/lista_boletim_pendente')->with('sucessoMsg', MSG::CAPA_CRIADA);
        }catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function viewLista($idBoletim){
        try{
            $notas = $this->BoletimService->getListarNotasPorBoletim($idBoletim);
            //dd($notas);
         //Ordena mantendo a associação entre índices e valores
            asort($notas);
      	    return view('boletim::listaNotaBoletim', compact('notas')); 
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        
    }

    /**
     * @author juanmojica - #386
     */
    public function formPesquisarBGPratico(){
        try {
            return view('boletim::bg_pratico/Form_pesquisa_bg_pratico');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juanmojica - #386
     */
    public function pesquisarBGPratico(Request $request){
        try {
            throw new Exception("Temporariamente desabilitado");
            
            $dadosForm = $request->all();
            
            $validator = validator($dadosForm, 
                [
                    'st_criterio' => "required",
                    'st_policial' => "required",
                    'st_policial' => "nullable|numeric"
                ],
                [
                    'numeric' => 'Este campo aceita apenas números.',
                ]
            );     

            if ($validator->fails()) {
                return redirect()->back()
                //mostrando o erro no form Create
                ->withErrors($validator)
                //retornando os dados do formulário deixando preenchido
                ->withInput();
            }
            
            $publicacoes = $this->BoletimService->pesquisarBGPratico($dadosForm);
            
            //Concatena a mensagem para exibir na view de acordo com os critérios de pesquisa repassados
            $msgTopicos = 'Tópicos encontrados para Critério de Busca: "' . $dadosForm["st_criterio"] . '"';
            if (isset($dadosForm['st_policial'])) {
                $msgTopicos .= ', Dados do Policiail: "' . $dadosForm['st_policial'] . '"'; 
            } elseif (isset($dadosForm['dt_inicio'])){
                $msgTopicos .= ', Início: "' . date('d/m/Y', strtotime($dadosForm['dt_inicio'])) . '"';
            } elseif (isset($dadosForm['dt_fim'])){
                $msgTopicos .= ', Fim: "' . date('d/m/Y', strtotime($dadosForm['dt_fim'])) . '".';
            }             
            
            return view('boletim::bg_pratico/Form_pesquisa_bg_pratico', compact('publicacoes', 'msgTopicos'));
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juanmojica - #436
     * @return Form (view com o formulário para movimentação do boletim)
     */
    public function viewMoverBoletim(){
        try {
            $this->authorize('Admin');

            return view('boletim::boletim/form_mover_boletim');

        } catch (Exception $e) {
            return redirect('/home')->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juanmojica - #436
     * @param Request (id_unidade_origem, id_unidade_destino)
     * @return Colection (dados das unidades de origem e destino)
     */
    public function pesquisarUnidadesMoverBoletim(Request $request){
        try {
            $this->authorize('Admin');
            
            $validator = validator($request->all(), [
                'st_origem' => "required",
                'st_destino' => "required",
                ],
            [
                //costumiza a msg a ser exibida no tipo de validação
                'required' => 'Campo obrigatório!'
            ]);    

            if ($validator->fails()) {
                //retornando os dados do formulário deixando preenchido
                return redirect('boletim/mover')->withErrors($validator);
            } 

            $unidadeService = new UnidadeService();
            $unidadeOrigem = $unidadeService->getUnidadeById($request->st_origem);
            $unidadeDestino = $unidadeService->getUnidadeById($request->st_destino);

            //verifica se alguma das unidades pesquisadas não foi encontrada
            if (empty($unidadeOrigem)) {
                throw new Exception('Unidade de origem não encontrada!');
            }
            if (empty($unidadeDestino)) {
                throw new Exception('Unidade de destino não encontrada!');
            }

            return view('boletim::boletim/form_mover_boletim', compact('unidadeOrigem', 'unidadeDestino'));

        } catch (Exception $e) {
            return redirect('boletim/mover')->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juanmojica - #436
     * @param Request (dados da unidades de origem e destino)
     * @return Response (mensagem de sucesso!)
     */
    public function MoverBoletim(Request $request){
        try {
            $this->authorize('Admin');

            //prepara os dados para o serviço
            $dadosForm['ce_unidadeorigem'] = $request->id_origem;
            $dadosForm['ce_unidadedestino'] = $request->id_destino;

            $msg = $this->BoletimService->moverBoletim($dadosForm);

            return redirect('boletim/mover')->with('sucessoMsg', $msg);

        } catch (Exception $e) {
            return redirect('boletim/mover')->with('erroMsg', $e->getMessage());
        }
    }

 
}