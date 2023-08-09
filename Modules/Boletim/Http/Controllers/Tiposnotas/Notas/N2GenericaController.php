<?php

namespace Modules\Boletim\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
/* use Illuminate\Routing\Controller; */
use App\Http\Controllers\Controller;
use Modules\Boletim\Entities\Tiposboletim;

use Modules\Boletim\Http\Controllers\Tiposnotas\TipoNotaFacadeController;

use Modules\Api\Services\BoletimService;
use Modules\Api\Services\NotaService;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\Policiaisdasnota;
use Modules\Api\Services\UnidadeService;
use Modules\Api\Services\FuncaoService;
use Modules\Api\Services\ArquivoBancoService;
use Exception;
use Auth;
//use DB;
use App\utis\MyLog;
use App\utis\Msg;
use App\utis\Status;
use App\utis\Funcoes;
use PHPExcel; 
use PHPExcel_IOFactory;
use App\Ldap\Authldap;
use Illuminate\Support\Facades\Storage;


class N2GenericaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct(BoletimService $BoletimService, PolicialService $PolicialService, NotaService $NotaService, ArquivoBancoService $ArquivoBancoService){
        $this->middleware('auth');
        $this->BoletimService = $BoletimService;
        $this->PolicialService = $PolicialService;
        $this->NotaService = $NotaService;
        $this->ArquivoBancoService = $ArquivoBancoService;
    }

    public function index(){
        try
        {
            $this->authorize('elabora_nota_boletim');
            $policial = auth()->user();
            if(!isset($policial->ce_unidade)){
                throw new Exception("Policial sem unidade de lotação");                
            }
            $notas = $this->NotaService->listaNotas($policial->ce_unidade);
            return view('boletim::notas/lista_notas', compact('notas'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Adiciona um policial a nota
     * ataíde
     **/

    public function adicionaPolicial(Request $request)
    {
        try {
            $this->authorize('elabora_nota_boletim');
           
            //return json_encode($request->all());
            
            $idNota = $request->idNota;
            $idPolicial = $request->idPolicial;
            $adiciona =  $this->NotaService->adicionarPolicialParaNota($idNota, $idPolicial);
           return 1;
        }catch(Exception $e){
           
            return  $e->getMessage();
        }
    }

    public function create($idNota){
        try{
            $this->authorize('elabora_nota_boletim');
            //buscando os tipos de notas
            $tipos =  $this->NotaService->getTiposNotas();
            //busca o tipo de nota específico
            $tipoNota = $this->NotaService->getTiposNotaId($idNota);
            //dd($tipoNota);
            $titulo = 'testando o título';
            switch ($tipoNota->id) {
                case 1:
                    return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('tipos', 'tipoNota','titulo'));                           
                    break;
                case 2:
                    return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('tipos', 'tipoNota','titulo'));                           
                    break;
                case 17: 
                    $unidadeService = new UnidadeService();
                    $unidades =  $unidadeService->getUnidade();
                    $funcaoService = new FuncaoService();
                    $funcoes = $funcaoService->getFuncoes();
                    return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('tipos', 'tipoNota','unidades', 'funcoes'));                           
                    break;
                case 18: 
                    $unidadeService = new UnidadeService();
                    $unidades =  $unidadeService->getUnidade();
                    $funcaoService = new FuncaoService();
                    $funcoes = $funcaoService->getFuncoes();
                    return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('tipos', 'tipoNota','unidades','funcoes'));                           
                    break;
                case 23:
                    return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('tipos', 'tipoNota','titulo'));                           
                    break;
                case 24: 
                //dd('chegou');
                    $unidadeService = new UnidadeService();
                    $unidades =  $unidadeService->getUnidade();
                    $funcaoService = new FuncaoService();
                    $funcoes = $funcaoService->getFuncoes();
                    return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('tipos', 'tipoNota','unidades', 'funcoes'));                           
                    break;
                default:
                    # code...
                    //tirei o dd @M6rc0sp
                    break;
            }
                   
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    /* @aggeu. Issue 225. Ao criar a nota, o usuário deve ser redirecionado para a tela de edição da nota criada */
    public function store(Request $request){
        try{
           
            $this->authorize('elabora_nota_boletim');
            $dadosForm = $request->all();
            $policial = auth()->user();
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', 'O policial logado não está cadastrado ou vinculado a unidade operacional.');
            }
            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['st_status'] = Status::NOTA_RASCUNHO;
            $dadosForm['nu_ano'] = date('Y');
            $dadosForm['idUsuario'] = Auth::user()->id;
            //validadndo os dados do formulário
                $validator = validator($dadosForm, [
                    'ce_tipo' => "required",
                    'ce_unidade' => "required"
                    ]);
                if ($validator->fails()) {
                    return redirect()->back()
                    //mostrando o erro no form Create
                    ->withErrors($validator)
                    //retornando os dados do formulário deixand-o preenchido
                    ->withInput();
                }

            $notaCriada =  $this->NotaService->criarNota($dadosForm);
         //dd($notaCriada);
            return redirect('boletim/nota/edit/'.$notaCriada->id.'/'.$notaCriada->ce_tipo)->with('sucessoMsg', MSG::NOTA_GERADA_COM_SUCESSO);
        
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

   
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id, $idTipoNota){
        try{
            // $unidadeService = new UnidadeService();
            $this->authorize('elabora_nota_boletim');
            
            //busca nota pelo id
            $nota =  $this->NotaService->getNotaId($id);
            
            //trata para não permitir que usuário mude o tipo para altera o texto
            if($nota->ce_tipo != $idTipoNota){
                throw new Exception("Não é possível alterar o tipo da Nota");
            }
            //localiza o policial para recupar a unidade dele
            /* $cpf = Funcoes::limpaCPF_CNPJ(Auth::user()->st_cpf);
            $policial = $this->PolicialService->buscaPolicialcpf($cpf);
            if(empty($policial)){
                throw new Exception("Policial não localizado");                
            }
           // dd($policial);
            $nota->ce_unidadedopolicial = $policial->ce_unidade; */
           // dd($nota);
            $policiaisDaNota = [];
   
          //  $funcao = new Funcoes;
           // $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
           /**
            * tratar essa verificação após implantação do bg
            */

          $tipoNota =  null;
      
          //buscando os tipos de notas
          $tipos =  $this->NotaService->getTiposNotas();
          foreach ($tipos as $key => $tipo) {
              if($tipo->id == $idTipoNota){
                  $tipoNota = $tipo;
              }
          }
          if(empty($tipoNota)){
              throw new Exception("Ops, tipo de nota inexistente");              
          }
         
            $dadosDaNota = array('ce_nota'=> $id,'ce_tipo'=> $idTipoNota,'bo_paginado'=>1);
            $unidadeService = new UnidadeService();
            $unidades =  $unidadeService->getUnidade();
            //dd($unidades);
           $titulo = "testando título";
           //busca a blade específica do tipo de nota
                    switch ($tipoNota->id) {
                        case 1:
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela,  compact('nota','tipos', 'tipoNota','unidades','titulo'));                           
                            break;
                        case 2:
                             $policiaisDaNota = $this->NotaService->listarPolicialParaCadaTipoNotas($dadosDaNota);
                             return view('boletim::notas/tipos/'.$tipoNota->st_nometela,compact('tipos', 'nota', 'tipoNota','unidades', 'policiaisDaNota'));                           
                            break;
                        case 13:
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('nota', 'tipos','tipoNota','unidades')); 
                            break;
                        case 17:
                            $policiaisDaNota = $this->NotaService->listarPolicialParaCadaTipoNotas($dadosDaNota);
                            $funcaoService = new FuncaoService();
                            $funcoes = $funcaoService->getFuncoes();
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela,compact('tipos', 'nota', 'tipoNota', 'policiaisDaNota','unidades','funcoes')); 
                            break;
                        case 18:
                            $policiaisDaNota = $this->NotaService->listarPolicialParaCadaTipoNotas($dadosDaNota);
                            $funcaoService = new FuncaoService();
                            $funcoes = $funcaoService->getFuncoes();
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela,compact('tipos', 'nota', 'tipoNota', 'policiaisDaNota','unidades','funcoes')); 
                            break;
                        case 20:
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('nota', 'tipos','tipoNota','unidades')); 
                            break;
                        case 23:
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela,  compact('nota','tipos', 'tipoNota','unidades','titulo'));                           
                            break;
                        case 24:
                            $policiaisDaNota = $this->NotaService->listarPolicialParaCadaTipoNotas($dadosDaNota);
                            //dd($policiaisDaNota);
                            $funcaoService = new FuncaoService();
                            $funcoes = $funcaoService->getFuncoes();
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela,compact('tipos', 'nota', 'tipoNota', 'policiaisDaNota','unidades','funcoes')); 
                            break;
                        default:
                            throw new Exception("Não pode editar nota ".$tipoNota->id." sem blade");    
                            break;
                    } 
            
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg',$e->getMessage());
            }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     * @ataide
     * */

    public function update(Request $request, $id){
        try{
            $this->authorize('elabora_nota_boletim');
            $dadosform = $request->all();
           if(isset($dadosform['ce_tipo'])){
            $mensages = [
                       'ce_tipo.required' => 'A seleção do tipo da nota é obrigatório!',
                       'st_assunto.required' => 'O campo assunto é de preencrimento obrigatório!',
                       'st_materia.required' => 'O campo materia é de preencrimento obrigatório!',
                   ];
                   //validadndo os dados do formulário
                   $validator = validator($dadosform, [
                       'ce_tipo'    => "required",
                       'st_assunto' => "required",
                       'st_materia' => "required",
                   ],$mensages);
           }else{
               $mensages = [            
                   'st_assunto.required' => 'O campo assunto é de preencrimento obrigatório!',
                   'st_materia.required' => 'O campo materia é de preencrimento obrigatório!',
               ];
               //validadndo os dados do formulário
               $validator = validator($dadosform, [            
                   'st_assunto' => "required",
                   'st_materia' => "required",
               ],$mensages);
           }
            
            if ($validator->fails()) {
             //   dd($validator);
                return redirect()->back()
                //mostrando o erro no form Create
                ->withErrors($validator)
                //retornando os dados do formulário deixand-o preenchido
                ->withInput();
                //busca nota pelo id
            }
            $nota =  $this->NotaService->getNotaId($id);

            if(empty($nota)){
                throw new Exception("Nota não localizada");
            }
            //verifica se o usuário logado está vinculado a unidade da nota
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
            
            if(!isset($dadosform['ce_tipo'])){
                $dadosform['ce_tipo'] = $dadosform['ce_tipobkp'];
            }

            if($dadosform['ce_tipo']==24){
               dd('é tipo 24');
                //$tiposNotaController = new TipoNotaFacadeController($dadosForm['ce_tipo']);
              //  $resultado = $tiposNotaController->atualizarNotaParaCadaTipoNota($dadosForm);
            }
            // Edita a Nota
            $editanota =  $this->NotaService->atualizarNota($dadosform, $nota);
            return redirect('/boletim/nota/edit/'.$nota->id."/".$dadosform['ce_tipo'])->with('sucessoMsg', MSG::NOTA_ALTERADA_COM_SUCESSO);

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    // Alterar futuramente para apenas atualizar o bo_ativo
    // ataíde
    public function destroy(Request $request){
        try{
            $this->authorize('elabora_nota_boletim');
            $dados = ['idUsuario' => Auth::User()->id, 'st_obs' => $request->st_obs];
            $nota =  $this->NotaService->getNotaId($request->idNota);
            if(empty($nota)){
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENCONTRADA);
            }elseif($nota->st_status != Status::NOTA_RASCUNHO){
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_RASCUNHO);
            }
            //verifica se o usuário logado está vinculado a unidade da nota
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
            //resgata a unidade operacional do policial
           
            
            //$deleta =  $this->NotaService->removeNotasDoboletim($request->idNota, $dados);
            $deleta =  $this->NotaService->deletaNota($request->idNota, $dados);
            
            if($deleta){
                return redirect('/boletim/notas')->with('sucessoMsg', MSG::NOTA_EXCLUIDA);
            }else{
                return redirect()->back()->with('erroMsg', MSG::ERRO_EXCLUIR_NOTA);
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }

    
    // Envia nota para correção
    // Altera o status da nota para rascunho
    // Ataíde
    public function corrigirNota($idNota){
        try {
            $this->authorize('elabora_nota_boletim');
            $nota =  $this->NotaService->getNotaId($idNota); // cria objeto nota
            if(empty($nota)){ // verifica se nota existe
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENCONTRADA);
            }elseif($nota->st_status != Status::NOTA_FINALIZADA && $nota->st_status != Status::NOTA_ASSINADA && $nota->st_status != Status::NOTA_RECUSADA) { // verifica se a nota tem o status de finalizada ou assinada
                return redirect()->back()->with('erroMsg', MSG::ERRO_CORRIGIR_NOTA);
            }
            //verifica se o usuário logado está vinculado a unidade da nota
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);

            $corrigeNota =  $this->NotaService->corrigeNota($nota); // altera o status da nota
            //dd($corrigeNota);
            if($corrigeNota){ // verifica se o status foi alterado
                return redirect('boletim/nota/edit/' . $nota->id . '/' . $nota->ce_tipo)->with('sucessoMsg', MSG::NOTA_ENVIADA_PARA_CORRECAO);
            }else{
                return redirect()->back()->with('erroMsg', MSG::ERRO_ENVIAR_NOTA_A_CORRECAO);
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    /**
     * finaliza edição da nota
     * @author Jazon #290
     * Altera o status da nota para FINALIZADO
     **/
    public function finalizarEdicaoNota(Request $request, $idNota){
        try {
            $idUsuario = Auth::User()->id;
            $this->authorize('elabora_nota_boletim');
            $nota =  $this->NotaService->getNotaId($idNota); // cria objeto nota
            //dd($nota);
            if(empty($nota)){ // verifica se nota existe
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENCONTRADA);
            }elseif($nota->st_status != Status::NOTA_RASCUNHO) { 
                // verifica se a nota tem o status RASCUNHO
                return redirect()->back()->with('erroMsg','Só pode finalizar a nota que está com status RASCUNHO');
            }
            //verifica se o usuário logado está vinculado a unidade da nota
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
            
            $msgRetorno =  $this->NotaService->finalizarEdicaoNota($idNota, $idUsuario); // altera o status da nota
            //dd($msgRetorno);
            //if($corrigeNota){ // verifica se o status foi alterado
                return redirect('boletim/nota/edit/' . $nota->id . '/' . $nota->ce_tipo)->with('sucessoMsg', $msgRetorno);
            /* }else{
                return redirect()->back()->with('erroMsg', 'Falha para finalizar a nota');
            }
        */        
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }
   
    // Assina a nota
    // Altera o status da nota para assinada e o bo_assinada
    // Ataíde
    public function assinarNota(Request $request, $idNota){
        try{
            $this->authorize('assina_nota_boletim');
            $dados['st_password'] = $request->st_password;

            $nota =  $this->NotaService->getNotaId($idNota); // cria objeto nota
            if(empty($nota)){ // verifica se nota existe
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENCONTRADA);
            }

            if(empty($nota->ce_unidadetramitada)){
                //verifica se o usuário logado está vinculado a unidade da nota
                $funcao = new Funcoes;
                $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
            }

            $cpfUsuario = Auth::User()->st_cpf;
            /***Verifica se existe o usuário no AD com as credenciais passadas como parâmetro */
            $authldap = new Authldap();
            $credenciais = array('st_cpf' => $cpfUsuario, 'password' =>  $dados['st_password']);
            $ldap = $authldap->autentica($credenciais);
            if($ldap == false){
                throw new Exception(Msg::SENHA_INVALIDA);
            }
            $assinarNota =  $this->NotaService->assinarNota($idNota, $dados); // assina a nota
            
            if($assinarNota){ // verifica se o status foi alterado
                return redirect('boletim/nota/edit/' . $nota->id . '/' . $nota->ce_tipo)->with('sucessoMsg', MSG::NOTA_ASSINADA);
            }else{
                return redirect()->back()->with('erroMsg', MSG::ERRO_AO_ASSINAR_NOTA.'--'.$aceitarNota);
            }
        }catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    // Envia a nota
    // Altera o status da nota para enviada e o bo_enviado
    public function enviarNota($idNota){
        $this->authorize('elabora_nota_boletim');
        $nota =  $this->NotaService->getNotaId($idNota); // cria objeto nota
        if(empty($nota)){ // verifica se nota existe
            return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENCONTRADA);
        }elseif($nota->st_status != Status::NOTA_ASSINADA){ // verifica se a nota tem o status de assinada
            return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ASSINADA);
        }
        //verifica se o usuário logado está vinculado a unidade da nota
        $funcao = new Funcoes;
        $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
        $enviarNota =  $this->NotaService->enviarNota($nota); // altera o status da nota
        
        if($enviarNota){ // verifica se o status foi alterado           
            return redirect()->back()->with('sucessoMsg', MSG::NOTA_ENVIADA);
        }else{
            return redirect()->back()->with('erroMsg', MSG::ERRO_AO_ENVIAR_NOTA);
        }
    }

    public function recusarNota(Request $request, $idNota){
        try{
            $this->authorize('elabora_bg'); 
            $dadosform = $request->all();
            $dadosform['st_status'] = Status::NOTA_RECUSADA;
            $dadosform['bo_enviado'] = 0;
            $dadosform['idUsuario'] = Auth::User()->id;
            //validadndo os dados do formulário
            $validator = validator($dadosform, ['st_obs' => "required"]);
            if ($validator->fails()) {
                return redirect()->back()
                //mostrando o erro no form Create
                ->withErrors($validator)
                //retornando os dados do formulário deixando preenchido
                ->withInput();
            }

            $nota =  $this->NotaService->getNotaId($idNota); // cria objeto nota
            if(empty($nota)){ // verifica se nota existe
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENCONTRADA);
            }elseif(($nota->st_status != Status::NOTA_ENVIADA) && ($nota->st_status != Status::NOTA_RECEBIDA)) { // verifica se a nota tem o status de assinada
               
                return redirect()->back()->with('erroMsg', MSG::ERRO_RECUSAR_STATUS);
            }
          $this->NotaService->recusarNota($dadosform, $nota); // altera o status da nota
          return redirect('boletim/notas/recebidas')->with('sucessoMsg', MSG::NOTA_RECUSADA);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }

    }

    public function aceitarNota($idNota){
        try{
            $this->authorize('elabora_bg'); 
            
            $nota =  $this->NotaService->getNotaId($idNota); // cria objeto nota
            if(empty($nota)){ // verifica se nota existe
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENCONTRADA);
            }elseif($nota->st_status != Status::NOTA_ENVIADA && $nota->bo_enviado == 0) { // verifica se a nota tem o status de enviada e bo_enviado
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENVIADA);
            }


            $aceitarNota =  $this->NotaService->aceitarNota($nota); // altera o status da nota
                return redirect('boletim/notas/recebidas')->with('sucessoMsg', MSG::NOTA_ACEITA);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }
    }

      /**
       * excluir logicamente uma nota, além de excluir o id da nota nos processo se for o caso
       * @issue #290
       * @author jazon
       */
    public function excluirNotaProcesso($idNota){
        try{
            $this->authorize('elabora_nota_boletim');
            $dados = ['idUsuario' => Auth::User()->id,'ce_nota'=>$idNota];
            //dd($dados);
            $nota =  $this->NotaService->getNotaId($idNota);
         //  dd($nota);
            if(empty($nota)){
                return redirect()->back()->with('erroMsg', MSG::NOTA_NAO_ENCONTRADA);
            }elseif(in_array($nota->st_status,array('ATRIBUIDA','PUBLICADA','ENVIADA','RECEBIDA'))){
                return redirect()->back()->with('erroMsg', 'Exclusão da nota bloqueada pelo status');
            }elseif($nota->bo_ativo != 1 ){
                return redirect()->back()->with('erroMsg', 'Nota já foi excluída');
            };
           //verifica se o usuário logado está vinculado a unidade da nota
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
           //resgata a unidade operacional do policial
           //dd('aqui');
            //$deleta =  $this->NotaService->removeNotasDoboletim($request->idNota, $dados);
            $msg =  $this->NotaService->excluirNotaProcesso($idNota, $dados);
            
           // if($deleta){
                return redirect('/boletim/notas')->with('sucessoMsg', $msg);
           // }else{
           // }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getmessage());
           // throw new Exception($e->getMessage());
        }
        
    }
    //Método para visualizar o pdf da Nota
    public function visualizarNota($id){
       try{
            
            $dados =  $this->NotaService->visualizaNota($id);
            $nota =  $dados->nota;
            if(!isset($nota)){
                return redirect()->back()->with('erroMsg', Msg::NOTA_NAO_ENCONTRADA);
            }
            //verifica se o usuário logado está vinculado a unidade da nota
           // $funcao = new Funcoes;

            // @marcos_paulo - #310
            // testa se existe um boletim, se o status é 'PUBLICADA' e se tem bo_integrada em TRUE/1
           /*  if(!empty($nota->st_boletim) && $nota->st_status=='PUBLICADA' && $nota->bo_integrada==1){
            }else{
                $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
            } */

            //buscando os tipos de notas
            if($nota->bo_policial == '1'){
                if(isset($nota->policiais)){
                    $policiaisDaNota = $nota->policiais;
                    if($nota->st_status=='RASCUNHO'){
                        $this->authorize('elabora_nota_boletim');
                        return View('boletim::notas/web_nota', compact('nota', 'policiaisDaNota'));
                    }else{
                        return \PDF::loadView('boletim::notas/pdf_nota', compact('nota', 'policiaisDaNota'))->stream('nota.pdf');
                        
                    }
                }
            }
            
            if($nota->st_status=='RASCUNHO'){
                $this->authorize('elabora_nota_boletim');
                return View('boletim::notas/web_nota', compact('nota'));
            }else{
                return \PDF::loadView('boletim::notas/pdf_nota', compact('nota'))->stream('nota.pdf');
                
            }

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }
    }

    
    //Adiciona um policial para adicionar a uma nota para boletim    
    /**
        * remove um policial de uma nota para boletim
        *ataíde
    * */

    public function removerpolicialdanota(Request $request){
        
        try {
            $this->authorize('elabora_nota_boletim');
                $idNota = $request->idNota;
                $idPolicial = $request->idPolicial;
                if(!empty($idNota) && !empty($idPolicial)){
                    $remove = $this->NotaService->removerPolicialDaNota($idNota, $idPolicial);
                    
                    if($remove){
                        return $remove;
                    }else{
                        return 0;
                    }
                }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }   

    public function notasEnvidasParaBg(){
        try{
            $this->authorize('elabora_bg');
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            $policial = $this->PolicialService->buscaPolicialcpf($cpf);
            if(empty($policial)){
                return redirect()->back()->with('erroMsg', MSG::USUARIO_NAO_E_POLICIAL);
            }
            $notas = $this->NotaService->notasEnvidasParaBg();
            
            return view('boletim::notas/notas_enviadas_bg', compact('notas'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    //Entra com o id da nota
    //Saída - lista os históricos das notas com todos os seus campos em formato json
    public function notaHistorico($id){
        try{
            $this->authorize('elabora_nota_boletim');
            $historicoNotas = $this->NotaService->getHistoricoNota($id);
            if(empty($historicoNotas)){
                return 0;
            }else{
                //$jasonHistorico = json_decode($historicoNotas, true);
                return $historicoNotas;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }


      /* 
        * @falecomjazon - #286
        * Busca os policiais conforme o tipo de nota
        * entradas: tipoNota, matrículacpf
        * retorno lista de policiais compatível com o tipo de nota
        */
    public function listarPolicialParaCadaTipoNotas(Request $request){
        try{  
                 //echo $request->all();
                 dd('sem uso');
            $this->authorize('elabora_nota_boletim');
           // $dadosForm = $this->removerTokenDoRequest($request->all());
           $dadosForm = $request->all();
          // dd($dadosForm);
            $policiais = $this->NotaService->listarPolicialParaCadaTipoNotas($dadosForm);
            if(empty($policiais)){
                return null;
            }else{
                //$jasonHistorico = json_decode($historicoNotas, true);
                dd($policiais);
                return $policiais;
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
      /* 
        * @falecomjazon - #286
        * add um policial ao tipo de nota específico
        * entradas obrigatórias: ce_tipo,ce_nota,ce_policial 
        * retorno true or false
        */          
    public function addPolicialParaCadaTipoNota(Request $request){
        try{  
            $this->authorize('elabora_nota_boletim');
            $dadosForm = $this->removerTokenDoRequest($request->all());
            $resultado = $this->NotaService->addPolicialParaCadaTipoNotas($dadosForm);
            //o retorno é um json
            return $resultado;

        } catch (Exception $e) {
            //o retorno é um json
            return $e->getmessage();
        }
    }

    /* 
        * @falecomcbaraujo - #84-981346783
        * add policiais em lote ao tipo de nota específico
        */  
    public function addPoliciaisEmLoteParaCadaTipoNota(Request $request){
        try{ 
           // return('chegou ao controler') ;
           // json_encode($request->all());
            $this->authorize('elabora_nota_boletim');
            $dadosForm = $this->removerTokenDoRequest($request->all());
            $idNota = $request->idNota;
            $msg = $this->NotaService->addPoliciaisEmLoteParaCadaTipoNota($idNota,$dadosForm);
            //o retorno é um string
            return $msg;

        } catch (Exception $e) {
            //o retorno é um json
            return $e->getmessage();
        }
    }

    /* 
    * @falecomcbaraujo - #84-981346783
    * add policiais em lote ao tipo de nota específico usando planilhas Excel xlsx
    */  
    public function addPoliciaisEmLoteExcelParaCadaTipoNota(Request $request){
        try{ 
            //captura idnota
            $idNota = $request->idNota;
            //captura tipo nota                
            $tipoNota = $request->tipoNota;
            //prepara upload
            $uploaddir = 'planilhas/';//public/planilhas
            $uploadfile = $uploaddir . basename($_FILES['arquivo']['name']);
            $tipodearquivo = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));
            
            //verifica se é excel
            if ($tipodearquivo == 'xlsx') {
                if (basename($_FILES['arquivo']['name']) == 'planilha_generica_com_pm.xlsx') {
                    //verifica se fez o upload
                    if (move_uploaded_file($_FILES["arquivo"]["tmp_name"],$uploadfile )) {
                        //captura os dados do excel
                        $tmpfname = "planilhas/planilha_generica_com_pm.xlsx";//foi la na public/planilhas
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
                            $matricula = trim($worksheet->getCell('A'.$row)->getValue());
                            $matricula = str_replace(".","",$matricula);
                            $matricula = str_replace("-","",$matricula);
                            $matricula = str_replace(",","",$matricula);
                            //$campo_personalizado = trim($worksheet->getCell('B'.$row)->getValue());
                            if(!empty(trim($matricula))){
                                $st_policiais[] = $matricula;
                                //$st_policiais[]= [$matricula,$campo_personalizado];
                            } else {
                                break;
                            }
                        }
                        //dd($st_policiais);
                        //concatena a string
                        //cria um array com idnota e o st_policiais e manda pro service
                        $dadosForm = array(
                            "ce_nota" => $idNota,
                            "ce_tipo" => $tipoNota,
                            "lotepoliciais" => $st_policiais
                        );
                        $msg = $this->NotaService->addPoliciaisEmLoteParaCadaTipoNota($dadosForm);
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
                    return redirect()->back()->with('erroMsg','O nome do arquivo que você deve fazer o upload deve ser o mesmo que do arquivo você baixou (planilhapadrao.xlsx).');
                }
            } else {
                return redirect()->back()->with('erroMsg','O arquivo que você está tentando enviar não é um Excel xlsx!');
            }
        } catch (Exception $e) {
            //o retorno é um json
            return redirect()->back()->with('erroMsg',$e->getmessage());
        }
    }

      /* 
        * @falecomjazon - #286
        * excluir um policial ao tipo de nota específico
        * entradas: ce_tipo,ce_nota,ce_policial
        * retorno true or false
        */          
    public function delPolicialParaCadaTipoNota(Request $request){
        try{  
            //return json_encode($request->all());
            $this->authorize('elabora_nota_boletim');
            $dadosForm = $this->removerTokenDoRequest($request->all());
           
            $resultado = $this->NotaService->delPolicialEmLoteParaCadaTipoNotas($dadosForm);
            
            return $resultado;

        } catch (Exception $e) {
            //dd($e->getMessage());
            //throw new Exception($e->getMessage());
            return $e->getmessage();
        }
    }
      /* 
        * @falecomjazon - #356
        * exibe a lista de notas tramitadas para a unidade do usuário logado
        * retorno listsa de notas
        */          
    public function getNotasTramitadas(){
        try{
            //return json_encode($request->all());
           // $this->authorize('elabora_nota_boletim');
           // $dadosForm = $this->removerTokenDoRequest($request->all());
            $cpf = Funcoes::limpaCPF_CNPJ(Auth::user()->st_cpf);
            $notas = $this->NotaService->getNotasTramitadas($cpf);
           // dd($notas);
           // dd($notas);
            //return $resultado;
             return view('boletim::notas/notas_tramitadas', compact('notas'));

        } catch (Exception $e) {
            dd('111'.$e->getMessage());
            //throw new Exception($e->getMessage());
           // return $e->getmessage();
         //  return redirect()->back()->with('erroMsg',$e->getMessage());
        }
    }
      /* 
        * @falecomjazon - #356
        * exibe a lista de notas tramitadas para a unidade do usuário logado
        * retorno listsa de notas
        */          
    public function devolverNotaTramitada($idNota,$autorizada){
        try{
          //  dd($idNota.'/'.$autorizada);
          //nota/devolvernota/{idNota}/{autorizada}

            $this->authorize('elabora_nota_boletim');
            $cpf = Funcoes::limpaCPF_CNPJ(Auth::user()->st_cpf);
            $dadosForm = array('ce_nota'=>$idNota,'bo_autorizada'=>$autorizada,'st_cpf'=>$cpf);
            $msg = $this->NotaService->devolverNotaTramitada($dadosForm);
            return redirect('boletim/notas/tramitadas')->with('sucessoMsg', $msg);
           // v1/notas/devolvertramitadas
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }
    }

     /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function editDevolverNotaTramitada($id, $idTipoNota){
        try{
            // $unidadeService = new UnidadeService();
            $this->authorize('elabora_nota_boletim');
           
            //busca nota pelo id
            $nota =  $this->NotaService->getNotaId($id);

            //localiza o policial para recupar a unidade dele
            $policial = auth()->user();
            if(empty($policial)){
                throw new Exception("Policial não localizado");                
            }
            $nota->ce_unidadedopolicial = $policial->ce_unidade;
           // dd($nota);
            //trata para não permitir que usuário mude o tipo para altera o texto
            if($nota->ce_tipo != $idTipoNota){
                throw new Exception("Não é possível alterar o tipo da Nota");
            }

            $policiaisDaNota = [];
   
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidadetramitada);

          $tipoNota =  null;
      
          //buscando os tipos de notas
          $tipos =  $this->NotaService->getTiposNotas();
          foreach ($tipos as $key => $tipo) {
              if($tipo->id == $idTipoNota){
                  $tipoNota = $tipo;
              }
          }
          if(empty($tipoNota)){
              throw new Exception("Ops, tipo de nota inexistente");              
          }
    
            $dadosDaNota = array('ce_nota'=> $id,'ce_tipo'=> $idTipoNota,'bo_paginado'=>1);

            $unidadeService = new UnidadeService();
            $unidades =  $unidadeService->getUnidade();
            //dd($unidades);
           $titulo = "testando título";
           //busca a blade específica do tipo de nota
                    switch ($tipoNota->id) {
                        case 1:
                           // dd(__LINE__);
                          return view('boletim::notas/tipos/'.$tipoNota->st_nometela,  compact('nota','tipos', 'tipoNota','unidades','titulo'));                           
                            break;
                        case 2:
                             $policiaisDaNota = $this->NotaService->listarPolicialParaCadaTipoNotas($dadosDaNota);
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela,compact('tipos', 'nota', 'tipoNota','unidades', 'policiaisDaNota'));                           
                            break;
                        case 13:
                          //  dd('fdsakfd');
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('nota', 'tipos','tipoNota','unidades')); 
                            break;
                        case 17:
                            $policiaisDaNota = $this->NotaService->listarPolicialParaCadaTipoNotas($dadosDaNota);
                          //  $unidadeService = new UnidadeService();
                       // $unidades =  $unidadeService->getUnidade();
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela,compact('tipos', 'nota', 'tipoNota', 'policiaisDaNota','unidades')); 
                            break;
                        case 18:
                            $policiaisDaNota = $this->NotaService->listarPolicialParaCadaTipoNotas($dadosDaNota);
                           
                            $funcaoService = new FuncaoService();
                            $funcoes = $funcaoService->getFuncoes();
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela,compact('tipos', 'nota', 'tipoNota', 'policiaisDaNota','unidades','funcoes')); 
                            break;
                        case 20:
                            //dd('aqui');
                            return view('boletim::notas/tipos/'.$tipoNota->st_nometela, compact('nota', 'tipos','tipoNota','unidades')); 
                            break;
                        default:
                            throw new Exception("Não pode editar nota ".$tipoNota->id." sem blade");    
                            break;
                    } 
            
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg',$e->getMessage());
            }

    }
     /**
     * tramita uma nota entre unidades
     * @param int $id
     * @return Response 
     */
    public function tramitarNota(Request $request){
        try{
            
            
            $this->authorize('elabora_nota_boletim');
           
            //valida os campos
            $dadosForm = $request->all();
            
            if(!isset($dadosForm['ce_unidade'])){
                throw new Exception("Informe a unidade de destino");
            } else {
                if ($dadosForm['ce_unidade'] == auth()->user()->ce_unidade) {
                    throw new Exception("Não é possível tramitar a nota para a própria unidade em que ela está");
                }
            }
            //busca nota pelo id
            $nota =  $this->NotaService->getNotaId($dadosForm['id']);
            //dd($nota);
            if(empty($nota)){
                throw new Exception("Nota não localizada");                
            }
            
            //atribui o policial logado para recupar a unidade dele
            $policial = auth()->user();
            if(empty($policial)){
                throw new Exception("Policial não localizado");                
            }

            //valida se o usuário está na unidade da nota
            if(($policial->ce_unidade != $nota->ce_unidade) && ($policial->ce_unidade != $nota->ce_unidadetramitada)){
                throw new Exception("Só pode tramitar notas da sua unidade");  
            }
            
            $msg =  $this->NotaService->tramitarNota($dadosForm);
            
            return redirect('boletim/notas')->with('sucessoMsg', $msg);
        
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }
    }

    /**
     * @author @juanmojica
     * Faz o upload de imagem na nota
     *  */  
    public function uploadImagemNota(Request $request) {
        try {
            //recebe o id da nota enviado na requisição
            $notaId = $request['amp;nota_id'];
            if ($notaId > 0) {
                //verifica se o arquivo existe
                if($request->hasFile('upload')) {
                    $arquivo = $request->file('upload');

                    if(!$request->file() == null){
                        //testa se o arquivo tem o tipo como null, se for null o upload excedeu o limite de 2MB
                        if($arquivo->gettype()){
                            //mesmo que se chame getSize, é um teste de arquivo corrompido, exemplo: se criar um txt vazio e nomear como txt.jpg
                            if($arquivo->getSize()){
                                //verifica se o arquivo é válido
                                if($arquivo->isValid()){ 
                                    //busca a extensão do arquivo
                                    $extensao = $arquivo->getClientOriginalExtension();
                                    // verifica se é imagem nos formatos jpeg, jpg, png ou PNG
                                    if($extensao == 'jpeg' || $extensao == 'jpg' || $extensao == 'png' || $extensao == 'PNG'){
                                        //recebe o caminho onde a imagem será salva no servidor ftp
                                        $caminho_armazenamento = 'imagens_upload/notas/' . $notaId . '/';
                                        //testa se existe o diretorio no caminho indicado
                                        if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                                            //se não existir, cria o diretório
                                            Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                                        }
                                        //gera hash a partir do arquivo
                                        $hashNome = hash('md5', strval($arquivo));
                                        //recebe nome do arquivo com base no hash
                                        $novoNome = $hashNome.'.'.$extensao;
                                        //checa se o arquivo ja existe
                                        if(!Storage::disk('ftp')->exists($caminho_armazenamento.$novoNome)){
                                            //salva arquivo no ftp
                                            $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                                            if(!$salvouNoFtp){
                                                throw new Exception('Falha ao realizar o upload, erro na base de dados de arquivos FTP.');
                                            }
                                        }
                                        //busca a imagem no servidor ftp    
                                        $image = Storage::disk('ftp')->get($caminho_armazenamento.$novoNome); // ftp
                                        //codifica o arquivo para base64
                                        $img = base64_encode($image);
                                        //concatena a tag para exibir arquivo em base64 com a imagem em base64
                                        $url = 'data:image/' . $extensao . ';base64,' . $img;
                                        //recebe o número pela requisição para ser enviado na função de resposta do CKEditor
                                        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                                        //mensagem de retorno da função
                                        $msg = Msg::SALVO_SUCESSO; 
                                        //função de resposta para o CKeditor
                                        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                                        @header('Content-type: text/html; charset=utf-8'); 
                                        echo $response; 
                                    }else{
                                        throw new Exception('Falha ao realizar o upload, os formatos permitidos são jpg, jpeg ou png');
                                    }
                                }else{
                                    throw new Exception('Falha ao realizar o upload, o arquivo não é válido.');
                                }
                            }else{
                                throw new Exception('Falha ao realizar o upload, o arquivo está corrompido.');
                            }
                        }else{
                            throw new Exception('Falha ao realizar o upload, o arquivo excede o tamanho de upload de 2MB');
                        }
                    }
        
                } else {
                    throw new Exception('Falha ao realizar upload, o arquivo não foi enviado.');
                }
            } else {
                throw new Exception('Falha ao realizar upload! Salve a nota para poder inserir uma imagem.');
            }
        } catch (Exception $e) {
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = ''; 
            $msg = $e->getMessage(); 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response; 
        }
    }

    
}
