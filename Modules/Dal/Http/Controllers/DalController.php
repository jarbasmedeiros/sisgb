<?php

namespace Modules\Dal\Http\Controllers;

use Modules\Api\Services\UnidadeService;
use Modules\Api\Services\DalService;
use Modules\Api\Services\PolicialService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Exception;
use Dompdf\Dompdf;
use App\utis\Msg;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Cast\Object_;

use function GuzzleHttp\Promise\all;

class DalController extends Controller
{
    public function __construct(DalService $DalService, PolicialService $policialService){
        $this->middleware('auth');
        $this->DalService = $DalService;
        $this->PolicialService = $policialService;
        
    }
    
   //@author Alexia Tuane
    //retorna a blade de pesquisa e listagem de recurso por unidade
    // issue: #343
    public function getRecursos(Request $request)
    {
        try{
         
            $dadosForm = $request->all(); 
                $validator = validator($dadosForm, [
                    'ce_unidade ' => 'required',
                    'ce_categoria' => 'required',
                    ]);

                $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
                $p = new PolicialService;
                $policial = $p->findPolicialByCpfMatricula($cpf);
               

                if(isset($dadosForm['ce_unidade'])){
                    $idUnidade = $dadosForm['ce_unidade'];
                }else{
                    $idUnidade = $policial->ce_unidade; 
                }if(empty($policial->ce_unidade)){
                    throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
                }
                
                if(isset($dadosForm['ce_categoria'])){
                    $categoriauni = $this->DalService->categoriaUni($idUnidade);
                }else{
                    $dadosForm['ce_unidade'] = [];
                    array_push($dadosForm['ce_unidade'], $idUnidade);
                    $recursouni = $this->DalService->recursoUni($dadosForm);
                 }
       
            $unidadeService = new UnidadeService();
            $unidade =   $unidadeService->getunidadesfilhasNome($policial->ce_unidade);
            $categoria = $this->DalService->getCategoria();
            $recurso = $this->DalService->getRecurso($dadosForm, $idUnidade);
   
           return  view('dal::recursos.lista_Recurso', compact('recurso','unidade','categoria'));   
           } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }


    //@author Alexia Tuane
    //cadastra um novo recurso
    // issue: #343   
    public function cadastraRecurso(Request $request ){
        try { 
           
           $dadosForm = $request->all();
           $validator = validator($dadosForm, [
                    'ce_unidade' => 'required',
                    'ce_categoria' => 'required',
                    'ce_aquisicao' => 'required',
                    'ce_situacao' => 'required',
                    'st_tipo' => 'required',
                    'st_material' => 'required',
                    'st_marca ' => 'required',
                    'st_modelo' => 'required',
                    'st_serial' => 'required',
                    'st_tombo' => 'required',
                    'st_medida' => 'required',
                    'nu_quantidade' => 'required',
                    'nu_carga' => 'required',
                    'vl_preco' => 'required',
                    'st_codigo' => 'required',
                    'st_obs' => 'required',
                ]);
             
           $unidadeService = new UnidadeService();
           $unidade = $unidadeService->getUnidade();
           $recurso = $this->DalService->cadastraRecurso($dadosForm);
           //dd($recurso);
            return redirect('dal/recursos')->with('sucessoMsg', Msg::SALVO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
     //@author Alexia Tuane
    //retorna o form de edicao do recurso por id
    // issue: #343
    public function editaRecurso($idRecurso){
        try {
            
            $unidadeService = new UnidadeService();
            $unidade = $unidadeService->getUnidade();
            $categoria = $this->DalService->getCategoria();
            $recurso = $this->DalService->retornaRecursoPorId($idRecurso);
         
            return view('dal::recursos.form_edita_recurso', compact('recurso','unidade', 'categoria'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }
    
    
     //@author Alexia Tuane
    //edita recurso
    // issue: #343
    public function forEditaRecurso(Request $request, $idRecurso){
        try{
            $dadosForm  = $request->all();
            $validator = validator($dadosForm, [
                'ce_unidade' => 'required',
                'ce_categoria' => 'required',
                'ce_aquisicao' => 'required',
                'ce_situacao' => 'required',
                'st_tipo' => 'required',
                'st_material' => 'required',
                'st_marca ' => 'required',
                'st_modelo' => 'required',
                'st_serial' => 'required',
                'st_tombo' => 'required',
                'st_medida' => 'required',
                'nu_quantidade' => 'required',
                'nu_carga' => 'required',
                'vl_preco' => 'required',
                'st_codigo' => 'required',
                'st_obs' => 'required',
            ]);
                
            $recurso = $this->DalService->editaRecurso($idRecurso, $dadosForm);  
           return redirect('dal/recursos')->with('sucessoMsg', Msg::SALVO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }
    
    /**
     * @author juanmojica - Issue 342
     * @param void
     * @return object $quantitativoFardamentos
     * */
    public function getQuantitativoFardamentos(){
        try {
            $quantitativoFardamentos = $this->DalService->getQuantitativoFardamentos();
            $unidadeService = new UnidadeService();
            $unidades = $unidadeService->getUnidade();
            $unidadeConsultada = 'todas';
            $dados['ce_unidade'][0] = 'todas';
            return view('dal::fardamentos.lista_quantitativo_de_fardamentos', compact('quantitativoFardamentos', 'unidades', 'unidadeConsultada', 'dados'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juanmojica - Issue 342
     * @param void
     * @return object $quantitativoFardamentosPorUnidades
     * */
    public function getQuantitativoFardamentosPorUnidades(Request $request, $renderizacao){
        try {
            $dados = $request->all();
            $ce_unidadeTemp = $dados['ce_unidade'];
            $validator = validator($dados, [
                'ce_unidade' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('erroMsg', 'Escolha pelo menos uma unidade operacional.');
            }
           
            $unidadeService = new UnidadeService();

            if ($renderizacao == 'pdf') {
                if ($dados['ce_unidade'][0] == 'todas') {
                    $quantitativoFardamentos = $this->DalService->getQuantitativoFardamentos();
                    $unidadeConsultada = 'Todas as Unidades';
                } elseif ($dados['ce_unidade'][0] == 'subordinadas') {
                    $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
                    $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
                    if(empty($policial->ce_unidade)){
                        throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
                    }
                    $unidade = $unidadeService->getUnidadeById($policial->ce_unidade);
                    $unidadesSubordinadas = $unidadeService->getunidadesfilhas($policial->ce_unidade);
                    $dados['ce_unidade'] = $unidadesSubordinadas;
                    $quantitativoFardamentos = $this->DalService->getQuantitativoFardamentosPorUnidades($dados); 
                    $unidadeConsultada = ' Unidades Subordinadas - ' . $unidade->hierarquia;
                } else {
                    $unidadesSubordinadas = $unidadeService->getunidadesfilhas($dados['ce_unidade'][0]);
                    $dados['ce_unidade'] = $unidadesSubordinadas;
                    $quantitativoFardamentos = $this->DalService->getQuantitativoFardamentosPorUnidades($dados);   
                    $unidade = $unidadeService->getUnidadeById($ce_unidadeTemp[0]);
                    $unidadeConsultada = $unidade->hierarquia;
                }
                return view ('dal::pdf.pdf_lista_quantitativo_fardamentos', compact('quantitativoFardamentos', 'unidadeConsultada'));
            }
            
            $unidades = $unidadeService->getUnidade();

            if($dados['ce_unidade'][0] == 'subordinadas'){
                $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
                $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
                if(empty($policial->ce_unidade)){
                    throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
                }
                $unidade = $unidadeService->getUnidadeById($policial->ce_unidade);
                $unidadesSubordinadas = $unidadeService->getunidadesfilhas($policial->ce_unidade);
                $dados['ce_unidade'] = $unidadesSubordinadas;
                $quantitativoFardamentos = $this->DalService->getQuantitativoFardamentosPorUnidades($dados); 
                $unidadeConsultada = ' Unidades Subordinadas - ' . $unidade->hierarquia;
                $dados['ce_unidade'] = $ce_unidadeTemp; 
            }else{
                $unidadesSubordinadas = $unidadeService->getunidadesfilhas($dados['ce_unidade'][0]);
                $dados['ce_unidade'] = $unidadesSubordinadas;
                $quantitativoFardamentos = $this->DalService->getQuantitativoFardamentosPorUnidades($dados);   
                $unidade = $unidadeService->getUnidadeById($ce_unidadeTemp[0]);
                $unidadeConsultada = $unidade->hierarquia;
                $dados['ce_unidade'] = $ce_unidadeTemp;
            }
            return view('dal::fardamentos.lista_quantitativo_de_fardamentos', compact('quantitativoFardamentos', 'unidades', 'unidadeConsultada', 'dados'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //@author Alexia Tuane
     //exclui recurso
     // issue: #343
     public function excluiRecurso($idRecurso){
        try{
            $response = $this->DalService->excluiRecurso($idRecurso);
          return redirect('dal/recursos')->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
   

}

       