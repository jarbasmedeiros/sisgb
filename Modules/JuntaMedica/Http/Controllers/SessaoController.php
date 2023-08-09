<?php
namespace Modules\JuntaMedica\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\JuntaMedica\SessaoService;
use Dompdf\Dompdf;
use App\utis\Msg;
use App\Sessao;
use Maatwebsite\Excel\Facades\Excel;
use App\Ldap\Authldap;

class SessaoController extends Controller{

    public function __construct(SessaoService $SessaoService, Authldap $Authldap){
        $this->middleware('auth');
        $this->sessaoService = $SessaoService;
        $this->Authldap = $Authldap;
    }
    
    
    //@author  Alexia Tuane
    //Retorna a lista Sessoes da JPMS
    // issue: #331
    public function getSessoes(){
        try {
            $sessoes = $this->sessaoService->getSessao();
            $tipos = $this->sessaoService->tipoSessao();
          
           return View('juntamedica::sessao.listaSessoesjpms', compact('sessoes','tipos'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    } 


   //@author  Alexia Tuane
    //Cadastra uma sessao
    // issue: #331
    public function cadastraSessao(Request $request ){
        try {
            $dadosForm = $request->all();
            //Verifica se o 'bo_sessaovirtual' existe. Ele só existirá se tiver sido marcado na blade
            if (!isset($dadosForm['bo_sessaovirtual'])) {
                $dadosForm['bo_sessaovirtual'] = 0;
            }
                $validator = validator($dadosForm, [
                    'st_tipo' => 'required',
                    'dt_sessao' => 'required',
                ]);
           $sessao  = $this->sessaoService->cadastraSessao($dadosForm);
           return redirect('/juntamedica/sessoes')->with('sucessoMsg',  $sessao);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    } 

    //@author Alexia Tuane
    //Retorna o form de edição da sessao
    // issue: #331
    public function forEditaSessao($idSessao){
        try {
             $tipos = $this->sessaoService->tipoSessao();
             $sessao = $this->sessaoService->findSessaoById($idSessao);
             //dd($sessao);
             return view('juntamedica::sessao.formEditaSessaoJpms', compact('sessao','tipos'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }   
    //@author Alexia Tuane
    //edita a sessao
    // issue: #331
    public function editaSessao(Request $request, $idSessao){
        try{
            $dadosForm  = $request->all();
            //Verifica se o 'bo_sessaovirtual' existe. Ele só existirá se tiver sido marcado na blade
            if (!isset($dadosForm['bo_sessaovirtual'])) {
                $dadosForm['bo_sessaovirtual'] = 0;
                //dd($dadosForm);
            }
            //dd($dadosForm);
            $validator = validator($dadosForm, [
                'ce_tipo' => 'required',
                'dt_sessao' => 'required',
            ]);
            $sessao = $this->sessaoService->editaSessao($idSessao,$dadosForm);  
            return redirect('/juntamedica/sessoes')->with('sucessoMsg', Msg::SALVO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }

    //@author Alexia
    //Retorna a lista de policiais em acompanhamento pela JPMS
    public function getRelatorioAcompanhamentoJPMS(){
        try {
            $policiaisEmAcompanhamento = $this->juntaMedicaService->getRelatorioAcompanhamentoJPMS();
            return view('juntamedica::cmapm.relatorioacompanhamento', compact('policiaisEmAcompanhamento')); 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }
    
    public function getExcelPoliciaisEmAcompanhamentoJPMS($idGraduacao, $renderizacao){
        try { 
            $policiaisEmAcompanhamento = $this->juntaMedicaService->getExcelPoliciaisEmAcompanhamentoJPMS($idGraduacao, $renderizacao);
            if($renderizacao == 'listagem'){
                return view('juntamedica::cmapm.listacompanhamento', compact('policiaisEmAcompanhamento', 'idGraduacao')); 

            }elseif($renderizacao == 'excel'){
                
                return view('juntamedica::excel.ExcelListaPoliciaisEmAcompanhamentoJPMS', compact('policiaisEmAcompanhamento' , 'idGraduacao'));
            }else{
                throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            } 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }

    /**
     * @author juanMojica - issue 334
     * @param int $idSessao
     * Retorna os dados da sessão da JPMS
     */    
    public function getSessao($idSessao, $renderizacao){
        try {
            $sessao = $this->sessaoService->findSessaoById($idSessao);
            //dd($sessao);
            $assinaturasSessao = $this->sessaoService->getAssinaturasSessao($idSessao);
            if ($renderizacao == 'pdf') {
                return view('juntamedica::pdf.pdfListaAtendimentosSessao', compact('sessao', 'assinaturasSessao'));
            }
            return view('juntamedica::sessao.listaAtendimentosSessaoJPMS', compact('sessao', 'assinaturasSessao'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
      
    /**
     * @author juanMojica - issue 334
     * Assina a sessão da JPMS
     */
    public function assinaSessao($idSessao, Request $request){
        try {
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
            $response = $this->sessaoService->assinaSessao($idSessao, $dados);
            return redirect()->back()->with('sucessoMsg', "Assinada com sucesso.");
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    /**
     * @author juanMojica - issue 334
     * @param int $idSessao
     * @param int $idAssinatura
     * Deleta uma assinatura de uma sessão da JPMS
     */
    public function excluiAssinaturaSessao($idSessao, $idAssinatura){
        try {
            $response = $this->sessaoService->excluiAssinaturaSessao($idSessao, $idAssinatura);
            return redirect()->back()->with('sucessoMsg', $response->msg);
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * @author medeiros - issue 334
     * @param int $idSessao
     * @param int $idAssinatura
     * Deleta uma assinatura de uma sessão da JPMS
     */
    public function exportaAtendimentosSessaoExcel($idSessao, $orgao){
        try {
            $sessao = $this->sessaoService->exportaAtendimentosSessaoExcel($idSessao, $orgao);
            return view('juntamedica::sessao.exportaAtendimentosSessaoExcel', compact('sessao'));
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author Alexia Tuane - issue 331
     * Exclui uma sessao
     */
    public function excluiSessao($idSessao){
        try {
            //dd('asaqaaaaaaaaa');
            $response = $this->sessaoService->excluiSessao($idSessao);
            return redirect()->back()->with('sucessoMsg', $response->msg);
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     /**
     * @author Alexia Tuane - issue 331
     * Finaliza uma sessao
     */
    public function finalizaSessao($idSessao){
        try {
            $response = $this->sessaoService->finalizaSessao($idSessao);
            //dd($response);
           return redirect()->back()->with('sucessoMsg', $response->msg);
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
}
