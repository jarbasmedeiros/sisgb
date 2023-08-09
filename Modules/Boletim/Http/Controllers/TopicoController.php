<?php

namespace Modules\Boletim\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
/* use Illuminate\Routing\Controller; */
use App\Http\Controllers\Controller;
use Modules\Boletim\Entities\Tiposboletim;
use Modules\Api\Services\BoletimService;
use Modules\Api\Services\TopicoService;
use Modules\Api\Services\NotaService;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\Policiaisdasnota;
use Exception;
use Auth;
use DB;
use App\utis\MyLog;
use App\utis\Msg;
use App\utis\Status;
use App\utis\Funcoes;

class TopicoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct(TopicoService $topicoService, BoletimService $BoletimService, PolicialService $PolicialService, NotaService $NotaService){
        $this->middleware('auth');
        $this->BoletimService = $BoletimService;
        $this->PolicialService = $PolicialService;
        $this->NotaService = $NotaService;
        $this->topicoService = $topicoService;
    }

    public function getTopicos(){
        try
        {
            $this->authorize('elabora_nota_boletim');
            $topicos =  $this->topicoService->getTopicos();
            return view('boletim::topicos/lista_topicos', compact('topicos'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function pesquisarTopicos(Request $request){
        try{       
           // dd('fdsafd');     
            $this->authorize('elabora_nota_boletim');
            $dadosForm =   $this->removerTokenDoRequest($request->all());
          //  dd($dadosForm);
            $topicos =  $this->topicoService->pesquisarTopicos($dadosForm);
            return view('boletim::topicos/lista_topicos', compact('topicos','dadosForm'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    public function create(){
        try{
            $this->authorize('elabora_nota_boletim');
            //buscando os tipos de notas
            $tipos =  $this->NotaService->getTiposNotas();
            //busca o tipo de nota específico
           // $tipoNota = $this->NotaService->getTiposNotaId($idTipoNota);
            return view('boletim::topicos/cad_topico');        
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* @Medeiros. Issue 262.  */
    public function store(Request $request){
        try{
          
            $this->authorize('elabora_nota_boletim');
            $dadosform = $request->all();
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            $policial = $this->PolicialService->buscaPolicialcpf($cpf);
            if(!isset($policial) || empty(auth()->user()->ce_unidade)){
                return redirect()->back()->with('erroMsg', 'O policial logado não está cadastrado ou vinculado a unidade operacional.');
            }
         
            //validadndo os dados do formulário
                $validator = validator($dadosform, [
                    'st_parte' => "required",
                    'st_topico' => "required"
                    ]);
                if ($validator->fails()) {
                    return redirect()->back()
                    //mostrando o erro no form Create
                    ->withErrors($validator)
                    //retornando os dados do formulário deixand-o preenchido
                    ->withInput();
                }

            $criatopico =  $this->topicoService->store($dadosform);
                     
                return redirect('/boletim/topicos/lista')->with('sucessoMsg', MSG::NOTA_GERADA_COM_SUCESSO);
            
    
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function findTopicoId($idTopico){
        //busca nota pelo id
        try{
            $this->authorize('elabora_nota_boletim');
                $topico =  $this->topicoService->findTopicoId($idTopico);
                return redirect('/boletim/topicos/show', compact('topico'));
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg',$e->getMessage());
            }

    }
    /**
     * Formulario para editar o tópico de boletim.
     */
    public function edit($idTopico){
        //busca nota pelo id
        try{
            $this->authorize('elabora_nota_boletim');
            $topico =  $this->topicoService->findTopicoId($idTopico);
            return view('boletim::topicos/edit_topico', compact('topico'));   
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

    public function updateTopicoBoletim(Request $request, $idTopico){
        try{
            $this->authorize('elabora_nota_boletim');
            $dadosform = $request->all();
            $topico =  $this->topicoService->updateTopicoBoletim($dadosform, $idTopico);
            return redirect('/boletim/topicos/lista')->with('sucessoMsg', MSG::NOTA_ALTERADA_COM_SUCESSO);

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    // Alterar futuramente para apenas atualizar o bo_ativo
    // ataíde
    public function destroy($idTopico){
        try{
            $this->authorize('elabora_nota_boletim');
            $topico =  $this->topicoService->destroy($idTopico);
            return redirect('/boletim/topicos/lista')->with('sucessoMsg', MSG::EXCLUIDO_SUCESSO);

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

            //verifica se o usuário logado está vinculado a unidade da nota
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);

            $assinarNota =  $this->NotaService->assinarNota($idNota, $dados); // assina a nota
            
            if($assinarNota){ // verifica se o status foi alterado
                return redirect('boletim/nota/edit/' . $nota->id . '/' . $nota->ce_tipo)->with('sucessoMsg', MSG::NOTA_ASSINADA);
            }else{
                return redirect()->back()->with('erroMsg', MSG::ERRO_AO_ASSINAR_NOTA);
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
            return redirect('boletim/notas')->with('sucessoMsg', MSG::NOTA_ENVIADA);
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

    //Método para visualizar o pdf da Nota
    public function visualizarNota($id){
       try{
            $this->authorize('elabora_nota_boletim');
            $dados =  $this->NotaService->visualizaNota($id);
            $nota =  $dados->nota;
            if(!isset($nota)){
                return redirect()->back()->with('erroMsg', Msg::NOTA_NAO_ENCONTRADA);
            }
            //verifica se o usuário logado está vinculado a unidade da nota
            $funcao = new Funcoes;
            $funcao->verificaVinculoDoUsuarioComUnidade($nota->ce_unidade);
            //buscando os tipos de notas
            $tipos =  $dados->tipos;
            if($nota->bo_policial == '1'){
                if(isset($nota->policiais)){
                    $policiaisDaNota = $nota->policiais;
                    return \PDF::loadView('boletim::notas/pdf_nota', compact('tipos', 'nota', 'policiaisDaNota'))->stream('nota.pdf');
                }
            }
            
            return \PDF::loadView('boletim::notas/pdf_nota', compact('tipos', 'nota'))->stream('nota.pdf');

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
}
