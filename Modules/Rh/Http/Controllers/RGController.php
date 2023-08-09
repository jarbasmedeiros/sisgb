<?php

namespace Modules\Rh\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

use DateTime;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\User;
use App\Utis\Msg;

use Modules\Api\Services\PolicialService;
use Modules\Api\Services\RgService;
use Modules\Api\Services\ArquivoBancoService;

use LaravelQRCode\Facades\QRCode;
use Exception;

class RgController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   
    
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RgService $rgService, PolicialService $policialService){
        $this->middleware('auth');
        $this->policialService = $policialService;
        $this->rgService = $rgService;  
        
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->authorize('Administrador');
      //  $usuario = User::get();
    
   
   
        return view('rh::index');
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('rh::show');
    }


    /**
     * @jazon - #267
     * Lista os identidades emitidas
     * @param int $id
     * @return Response
     */
    public function getDashboard()
    {
        $this->authorize('IDENTIFICAR_PM');
        $cedulasDisponiveis = rand(1,1000);
        $rgProntos = rand(1,1000);
        $dashboard =  $this->rgService->getDashboard();
        return view('rh::rg/dashboardRg', compact('dashboard'));
       return view('listarRg');
    }
    /**
     * @jazon - #267
     * retorna os dados do prontuário do rg
     * @param int $id
     */
    public function getProntuario($idPolicial)
    {
        try {
            if (auth()->user()->can('EMITIR_RG') || auth()->user()->can('IDENTIFICAR_PM')) {

                $rgService = new RGService();

                $policial = $rgService->getProntuario($idPolicial);
                //dd($policial);
                return view('rh::rg.ListaRG', compact('policial'));
                
            } else {
                throw new Exception('Este perfil não tem permissão para acessar esta página');
            }   
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }     
    }
    /**
     * @jazon - #267
     * retorna os dados do prontuário do rg
     * @param int $id
     * @return Response
     */
    public function getFichaDatiloscopica($idPolicial)
    {
     dd('getFichaDatiloscopica');
        $policialService = new PolicialService();
        $rgService = new RGService();
        
        $policial = $policialService->findPolicialById($idPolicial);
        
        $rgs = $rgService->listarRGs($idPolicial);
       // $policial = null;
      //  $promocao = null;
        return view('rh::rg.ListaRG', compact('policial', 'rgs'));
      //  return view('rh::rg/listarRG', compact('cronograma', 'idQuadro', 'competencia'));
     
    }

   /**
     * @jazon - #267
     * retorna os dados do prontuário do rg
     * @param int $id
     * @return Response
     */
    public function showFormRg($idPolicial)
    {        
        $this->authorize('EMITIR_RG');
        $policialService = new PolicialService();
        $policial = $policialService->findPolicialById($idPolicial);
        $configuracao = $this->rgService->getConfiguracao();
      //  dd($configuracao);
      //  $policial = $rgService->getRg($idPolicial);
      //  dd($policial->rgs);
     // $qrCode = 'http://detran.rj.gov.br/imagem_noticia.asp?id=125';
    
        return view('rh::rg.CriaRG', compact('policial','configuracao'));
    }
   /**
     * @jazon - #267
     * retorna os dados do prontuário do rg
     * @param int $id
     * @return Response
     */
    public function criarRg($idPolicial, Request $request)
    {     
        try {
         //   dd
            $this->authorize('EMITIR_RG');

         //  dd($request->all());
             // Caso o token existe ele é removido
            $dadosForm =   $this->removerTokenDoRequest($request->all());
            /*  if(isset($dadosForm['_token'])){
                unset($dadosForm['_token']);
            } */
                    
            $validator = validator($dadosForm, [
                'st_rgmilitar' => 'required',
                'st_cedula' => 'required',
                'st_motivo' => 'required'            
            ]);
    
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            } 
 

            $rgRetorno = $this->rgService->criarRg($idPolicial, $dadosForm);
            
            
            return redirect('rh/policiais/'.$idPolicial.'/rg/'.$rgRetorno->id.'/edit')->with('sucessoMsg',Msg::SALVO_SUCESSO);
        } catch (\Throwable $e) {
          //  dd('errro'. $e->getmessage());
           // return view('promocao::quadroDeAcesso/inspecaoTaf', compact('policial'))->with('sucessoMsg', $rgRetorno);            
           return redirect()->back()->with('erroMsg', $e->getMessage());
            //throw $th;
        }
    }
   /**
     * @jazon - #267
     * retorna os dados do prontuário do rg
     * @param int $id
     * @return Response
     */
    public function saveRg($idPolicial,$idRg, Request $request)
    {     
        try {
            $this->authorize('EMITIR_RG');
             // Caso o token existe ele é removido
            $this->removerTokenDoRequest($request->all());
            $dadosForm  = $validator = validator($dadosForm, [
                'st_rgmilitar' => 'required',
                'st_cedula' => 'required',
                'st_motivo' => 'required'            
            ]);
    
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $rgRetorno = $this->rgService->salvarRg($idPolicial, $dadosForm);
            return redirect('rh/policiais/'.$idPolicial.'/rg/'.$rgRetorno->id.'/edit')->with('sucessoMsg',Msg::SALVO_SUCESSO);
        } catch (\Throwable $e) {
          //  dd('errro'. $e->getmessage());
           // return view('promocao::quadroDeAcesso/inspecaoTaf', compact('policial'))->with('sucessoMsg', $rgRetorno);            
           return redirect()->back()->with('erroMsg', $e->getMessage());
            //throw $th;
        }
    }

    /**
     * @jazon - #267
     * imprime uma prévia da identidade
     * @param int $idPolicial
     * @param int $idRg
     */
    public function imprimirRg($idPolicial,$idRg)
    {
       // return 'imprimirrg';
       try {
            $this->authorize('EMITIR_RG');
            $dadosDaIdentidade = $this->rgService->getIdentidadeParaImpressao($idPolicial,$idRg);
            if(empty($dadosDaIdentidade)){
                throw new Exception(Msg::REGISTRO_NAO_ENCONTRADO);
            }
            // dd($dadosDaIdentidade);
            //$qrCode = 'imageqrcode';
            //  $qrCode = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=https://www5.defesasocial.rn.gov.br/sisgp/identidades/validacao/".$dadosDaIdentidade->st_localizador;
            
            //gerando o qrCode de validação do rg
            /* $qrCode =  QRCode::url("https://www5.defesasocial.rn.gov.br/sisgp/identidades/validacao/".$dadosDaIdentidade->st_localizador)
            ->setSize(8)
            ->setMargin(2)
            ->png(); */
            $path = env('PATH_URL_VALIDACAO');
            if(empty($path)){
                throw new Exception("URl padrão de validação não encontrada no ambiente!");
            }
            $urlValidacao = $path."/identidade/".$dadosDaIdentidade->st_localizador;
            //$urlValidacao = env('PATH_URL')."validacao/identidade/".$dadosDaIdentidade->st_localizador;
            $localizador = $dadosDaIdentidade->st_localizador;
            return view('rh::rg.ImprimePreviaRG2', compact('dadosDaIdentidade','idPolicial','idRg','urlValidacao','localizador'));
       } catch (\Exception $e) {
           //throw $th;
          // dd('error: '.$th->getmessage());
          return redirect()->back()->with('erroMsg', $e->getMessage());

       }
    }
    public function validarIdentidade($localizador)
    {
        return 'localizador '.$localizador;
    }

    /**
     * @jazon - #267
     * retorna os dados necessários para a exibir um rg selecionado
     * @param int $idPolicial
     * @param int $idRg
     */
    public function getRg($idPolicial,$idRg)
    {
        try {   
            $this->authorize('EMITIR_RG');
            $policial = $this->policialService->findPolicialById($idPolicial);
            if(empty($policial)){
                throw new Exception(Msg::POLICIAL_NAO_LOCALIZADO);
            }
            $rg = $this->rgService->getRgById($idRg);
            if(empty($rg)){
                throw new Exception("RG do policial não localizado");
            }
            $qrCode = 'teste.png';
            return view('rh::rg.EditaRG', compact('policial','qrCode','rg'));
        } catch (\Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }


    /**
         * @jazon - #267
        * salva o status da impressãode um rg selecionado          
        * @param int $idRg
        */
    public function confirmarImprimirRg($idPolicial,$idRg,Request $request)
    {
       try {   
        $this->authorize('EMITIR_RG');
         //  dd('confirmarImprimirRg');         
            $dadosForm = $this->removerTokenDoRequest($request->all());
        //  dd($dadosForm);
           $confirmacao =  $this->rgService->confirmarImpressao($idPolicial,$idRg,$dadosForm);

            $policial = $this->policialService->findPolicialById($idPolicial);

            $rg = $this->rgService->getRgById($idRg);


            return redirect('rh/policiais/'.$idPolicial.'/rg/'.$idRg.'/edit')->with('sucessoMsg', $confirmacao);;
        } catch (\Throwable $e) {
          //  return view('rh::rg.EditaRG', compact('policial','qrCode','rg'))->with('errMsg', $confirmacao);;
            //throw $th;
            return redirect()->back()->with('erroMsg', $e->getMessage());
            //dd('error: '.$th->getmessage());
        }
    }

    /**
         * @jazon - #267
        * salva a data de entrega ao policial          
        * @param int $idPolicial
        * @param int $idRg
        */
    public function entregarRg($idPolicial,$idRg)
    {
       try {   
        // dd('fdfd');
           $confirmacao =  $this->rgService->entregarRg($idRg);

            return redirect('rh/policiais/'.$idPolicial.'/rg/'.$idRg.'/edit')->with('sucessoMsg', $confirmacao);;
        } catch (\Exception $e) {
          //  return view('rh::rg.EditaRG', compact('policial','qrCode','rg'))->with('errMsg', $confirmacao);;
            //throw $th;
            return redirect()->back()->with('erroMsg', $e->getMessage());
            //dd('error: '.$th->getmessage());
        }
    }

    /**
         * @jazon - #267
        * salva a data de entrega ao policial          
        * @param int $idPolicial
        * @param int $idRg
        */
    public function devolverRg($idPolicial,$idRg)
    {
       try {   
      // dd('devolver');
           $confirmacao =  $this->rgService->devolverRg($idRg);

            return redirect('rh/policiais/'.$idPolicial.'/rg/'.$idRg.'/edit')->with('sucessoMsg', $confirmacao);
        } catch (\Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());

        }
    }

    /**
    * @jazon - #267
    * salva a imagens do rg, foto atual do policial    
    */
    public function savarImagens($idPolicial,$idRg,Request $request)
    {     
        try {          
            //   $this->authorize('Edita_rh');  
           // $dadosForm = $request->all();
           $dadosForm =   $this->removerTokenDoRequest($request->all());
          //dd($nomeImagem);
            $imagem = $request->st_fotorg;

            if(isset($imagem)){
 
                //verifica se o arquivo é válido
                if($imagem->isValid()){ 
                    $extensao = $imagem->getClientOriginalExtension();
                    //verifica se é pdf
                    if($extensao != 'png' && $extensao != 'jpeg' && $extensao != 'jpg'){ 
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload. A imagem a ser cadastrada deve está em formato PNG, JPEG ou JPG.');
                    }elseif($imagem->getClientSize() > 2048000){
                        return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload. A imagem excede o tamanho de 2 MB.');
                    }
                   // dd('chegou adadafd');
                    $policial = $this->policialService->findPolicialById($idPolicial);
                    $caminho_armazenamento = 'RH/' . str_replace(" ", "", $policial->st_cpf) . '/Imagens/rg/cedulas';
                    //nome do arquivo com o número da cédula do RG do policial
                   
                   

                    $rg = $this->rgService->getRgById($idRg);
                    if(empty($rg)){
                        throw new Exception("RG do policial não localizado");                     
                    }
                    try{
                       // dd(Storage::disk('ftp')->exists($caminho_armazenamento));
                       // dd($caminho_armazenamento);
                        //testa se existe o diretorio do funcionario
                        if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                         //   dd('fdsafsdf1111111111111');
                            //creates directory
                            Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                        }
                        $nomeImagem = $request->st_cedula; 
                        if(Storage::disk('ftp')->exists($caminho_armazenamento.$nomeImagem . '.jpeg')){
                            Storage::disk('ftp')->delete($caminho_armazenamento.$nomeImagem . '.jpeg');
                        }
                        if(Storage::disk('ftp')->exists($caminho_armazenamento.$nomeImagem . '.png')){
                            Storage::disk('ftp')->delete($caminho_armazenamento.$nomeImagem . '.png');
                        } 
                        if(Storage::disk('ftp')->exists($caminho_armazenamento.$nomeImagem . '.jpg')){
                            Storage::disk('ftp')->delete($caminho_armazenamento.$nomeImagem . '.jpg');
                        }  
                                
                        //popula os atributos a serem salvos no banco
                        $dadosImagem = [
                            'st_modulo' => 'RH_RG',
                            'st_motivo' => 'FOTO_RG',
                            'dt_envio' => date('Y-d-m H:i:s'),
                            'st_arquivo' => $nomeImagem,
                            'st_extensao' => $extensao,
                            'st_descricao' => 'foto do cédula do RG do policial',
                            'st_pasta' => $caminho_armazenamento
                        ];
    
                        //salva arquivo no ftp
                        $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$nomeImagem.'.'.$extensao, fopen( $imagem, 'r+')); 
                        if($salvouNoFtp){
                           // dd('ddd');
                            $arquivoBancoService = new ArquivoBancoService();
                           
                            if(isset($rg->st_fotorg)){
                              //  dd('tem');
                                //atualiza dados do arquivo no banco
                                $confirmacao =   $arquivoBancoService->updateArquivo($rg->st_fotorg, $policial->id, $dadosImagem); 
                              
                              //$confirmacao = 'salvou com sucesso';
                            }else{
                                //salva dados do arquivo no banco
                                $confirmacao =  $arquivoBancoService->createArquivo($idPolicial, $dadosImagem);
                               // dd('2222');
                            }
                            //monta o path da imagem no ftp
                            $pathFotoRg = $caminho_armazenamento.'/'.$nomeImagem.'.'.$extensao;
                          
                            $foto = array('st_fotorg'=>$pathFotoRg);
                            $this->rgService->salvarImagemCedulaRg($idRg,$foto);
                            
                            return redirect('rh/policiais/'.$idPolicial.'/rg/'.$idRg.'/edit')->with('sucessoMsg', $confirmacao);
                            
                        }else{
                            return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload da imagem. Erro na base de dados de arquivos');
                        }
                    }catch(Exception $e){
                      
                        throw new Exception($e->getMessage());
                    }
                }else{
                    return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo não é válido');
                }
            }else{
                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, faltou anexar a imagem');              
            }
        } catch (\Exception $e) {
            dd($e->getmessage());
            return redirect()->back()->with('erroMsg', $e->getMessage());

        }
    }


    /**
     * @jazon - #267
    * salva os dados da ficha datiloscópica  do policial          
    
    */
    public function setProntuario($idPolicial,Request $request)
    {
        try {  
        $this->authorize('Leitura'); 
        $dadosForm =   $this->removerTokenDoRequest($request->all());
        // dd($dadosForm);
        $confirmacao =  $this->rgService->setProntuario($idPolicial,$dadosForm);

            return redirect('rh/policiais/'.$idPolicial.'/rg/prontuario')->with('sucessoMsg', $confirmacao);
        } catch (\Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());      
        }
    }

    /**
     * @jazon - #267
    * gera um qrcode para o rg do policial          
    
    */
    public function gerarQrCode($localizador)
    {
        try {  
        $caminho = url("/validacao/identidade/".$localizador);
        return  QRCode::url($caminho)
        ->setSize(10)
        ->setMargin(1)
        ->png();
        } catch (\Exception $e) {
            return $e->getmessage();
        //  return redirect()->back()->with('erroMsg', $e->getMessage());      
        }
    }

    /**
     * @jazon - #286
    * atualiza número da cedula e motivo da impressão
    
    */
    public function atualizarCedula($idPolicial, $idRg, Request $request)
    {
        try {  
            $dadosForm = $request->all();
            if(!isset($dadosForm['id_cedula'])){       
                throw new Exception("Informar o id da cédula");                     
            }
            if(!isset($dadosForm['st_cedula'])){                   
                throw new Exception("Informar o id da cédula");                     
            }

            $confirmacao =  $this->rgService->atualizarCedula($idRg, $dadosForm);
            return redirect('rh/policiais/'.$idPolicial.'/rg/'.$idRg.'/edit')->with('sucessoMsg', $confirmacao);  
        } catch (\Exception $e) {
        //  return $e->getmessage();
            return redirect()->back()->with('erroMsg', $e->getMessage());      
        }
    }


    /**
     * @jazon - #286
    * atualiza número da cedula e motivo da impressão
    
    */
    public function pesquisarRg(Request $request)
    {
        //     dd(__LINE__);
        $this->authorize('EMITIR_RG');
        
        $rgs = null;                  
        $filtro = null;              
        $criterio = null;                  
        
        try {
            
            $dadosForm = $this->removerTokenDoRequest($request->all());
            if(!empty($dadosForm)){
                
                $validator = validator($dadosForm, [
                    
                    'st_criterio' => 'required',           
                ]);
                if($validator->fails()){
                    // Mensagem de erro com o formulário preenchido
                    return redirect()->back()->with('erroMsg','Preencher campos obrigatórios');   

                } 
                // dd($dadosForm);
                // $filtro = $dadosForm['st_filtro'];
                $criterio = $dadosForm['st_criterio'];
                //  dd(__LINE__);
                $rgs = $this->rgService->pesquisarRg($dadosForm);      
            }
            //dd($rgs);
            return view('rh::rg.PesquisarRg', compact('rgs','criterio'));  
        } catch (\Throwable $th) {
            // dd($th->getmessage());
            return view('rh::rg.PesquisarRg', compact('rgs','criterio'))->with('erroMsg', $th->getMessage());    
        }
    }

    /**
     * @jazon - #355
    * exibe as configurações do módulo de rg
    
    */
    public function getConfiguracoesModuloRg()
    {
        $this->authorize('IDENTIFICAR_PM');
        try {
            $configuracoes = $this->rgService->getConfiguracoesModuloRg();      
            //dd($configuracoes);
            return view('rh::rg.ListaConfiguracoesModuloRg', compact('configuracoes'));  
        } catch (\Throwable $th) {
            return redirect()->back()->with('erroMsg',$th->getmessage());   
            // dd($th->getmessage());
            //   return view('rh::rg.PesquisarRg', compact('rgs','criterio'))->with('erroMsg', $th->getMessage());    
        }          
    }

    /**
     * @jazon - #355
    * exibe as configurações do módulo de rg
    
    */
    public function setConfiguracaoModuloRg(Request $request)
    {
        $this->authorize('IDENTIFICAR_PM');
        try {
            // Recebendo os dados do formulário
            $dadosForm = $this->removerTokenDoRequest($request->all());
            // dd($dadosForm);
            // Validando os dados obrigatórios
            $validator = validator($dadosForm, [
                'st_chave' => 'required',
                'st_valor' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //remove campos desnecessários
            unset($dadosForm['btnSalvar']) ;
            //adiciona campos obrigatórios
            $dadosForm['st_modulo']= 'RG';
            //envia para salvar
            $msg = $this->rgService->setConfiguracaoModuloRg($dadosForm);      
            //dd($configuracoes);
            // return view('rh::rg.ListaConfiguracoesModuloRg', compact('configuracoes'));  
            return redirect('rh/rg/config')->with('sucessoMsg',$msg);
        } catch (\Throwable $th) {
            return redirect()->back()->with('erroMsg',$th->getmessage());   
            //   return view('rh::rg.PesquisarRg', compact('rgs','criterio'))->with('erroMsg', $th->getMessage());    
        }          
    }

    //*527-resolver-bug-do-rg
    //cb Araújo
    public function getAtendimentos(){
        $this->authorize('EMITIR_RG');
        try {
            $dataInicio = date('Y-m-d');
            $calculoDataMinima = new DateTime('now -1 month');
            $dataMinima = $calculoDataMinima->format('Y-m-d');
            $dadosForm['dt_inicio'] = $dataInicio;
            $dadosForm['dt_fim'] = null;
            $dados =  $this->rgService->listaAgendamento($dadosForm);
            //dd($dados);
            return view('rh::rg.AtendimentosRg', compact('dados','dataInicio','dataMinima'));  
        } catch (\Throwable $th) {
            return redirect()->back()->with('erroMsg',$th->getmessage());   
        }
    }

    //*527-resolver-bug-do-rg
    //cb Araújo
    public function buscaAtendimentos(Request $request){
        $this->authorize('IDENTIFICAR_PM');
        try {
            $dadosForm = $request->all();
            if(strtotime($dadosForm['dt_fim']) < strtotime($dadosForm['dt_inicio'])){
                return redirect()->back()->with('erroMsg',"A data final não pode ser menor do que a data inicial!");
            }
            $dados =  $this->rgService->listaAgendamento($dadosForm);
            //dd($dadosForm);
            $dataInicio = date('Y-m-d');
            $calculoDataMinima = new DateTime('now -1 month');
            $dataMinima = $calculoDataMinima->format('Y-m-d');
            if(count($dados) == 0){
                return redirect()->back()->with('erroMsg',"Nenhum valor encontrado para as datas solicitadas!");
            }
            return view('rh::rg.AtendimentosRg', compact('dados','dataInicio','dataMinima','dadosForm'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('erroMsg',$th->getmessage());   
        }
    }
    
   
}        