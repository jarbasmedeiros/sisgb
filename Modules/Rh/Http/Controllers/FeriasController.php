<?php

namespace Modules\Rh\Http\Controllers;
use App\Http\Controllers\Controller;
use App\utis\Msg;
use App\utis\Funcoes;
use Illuminate\Http\Request;
use Exception;
use Auth;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\FeriasService;
use Modules\Api\Services\UnidadeService;
use Response;
use Illuminate\Support\Facades\Validator;


class FeriasController extends Controller{

    public function __construct(PolicialService $PolicialService, FeriasService $feriasService){
        $this->middleware('auth');
        $this->PolicialService = $PolicialService;
        $this->FeriasService = $feriasService;
    }

    /* 
    Autor: @higormelo. 
    Issue 190, Implementar funcionalidades para a aba férias do policials. 
    A função retorna lista com todas as férias do policial e seus respectivos históricos. 
    */
    public function getFeriasPolicial($idPolicial)
    {
        try {
            
            $permissoes = Auth::user()->permissoes;
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $ferias =  $this->FeriasService->getFeriasPolicial($idPolicial);
        
            if( auth()->user()->can('Edita_rh')){
                if( in_array('qualquerUnidade',$permissoes)){
                    return view('rh::ferias.ListaFerias', compact('policial', 'ferias')); 
                }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::ferias.ListaFerias', compact('policial', 'ferias')); 
                }
            }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                return view('rh::ferias.ExibirFerias', compact('policial', 'ferias')); 
            }else{
                throw new Exception('Este perfil não tem permissão para acessar esta página');
                
            }            
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /* 
    Autor: @higormelo. 
    Issue 190, Implementar funcionalidades para a aba férias do policials. 
    A função cria as férias do policial e seus respectivos históricos. 
    */
    public function criaFeriasPolicial($idPolicial, Request $request)
    {
        try{
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'dt_inicio' => 'required|date',
                'dt_termino' => 'required|date',
                'st_anoreferencia' => 'required',
                'st_publicacao' => 'required',
                'nu_dias' => 'required',
                'st_obs' => 'nullable'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $this->FeriasService->criaFeriasPolicial($idPolicial, $dadosForm);
            return redirect()->back()->with('sucessoMsg', Msg::SALVO_SUCESSO); 
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /* 
    Autor: @higormelo. 
    Issue 190, Implementar funcionalidades para a aba férias do policials. 
    A função cria as férias do policial e seus respectivos históricos. 
    */
    public function updateFeriasPolicial($idPolicial, $idFerias, Request $request)
    {
        try{
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'dt_inicio' => 'required|date',
                'dt_termino' => 'required|date',
                'st_anoreferencia' => 'required',
                'st_publicacao' => 'required',
                'nu_dias' => 'required',
                'st_obs' => 'nullable'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $this->FeriasService->updateFeriasPolicial($idPolicial, $idFerias, $dadosForm);
            return redirect()->back()->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO); 
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     //Autor: @Medeiros
    //Lista na view as férias dos policiais da unidade do policial logado
    public function listaFeriasPorUnidade(Request $request){      
        $this->authorize('Relatorios_rh');
        try {

            $policial = auth()->user();
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $unidaeService = new UnidadeService();
            $unidades = $unidaeService->getunidadesfilhasNome($policial->ce_unidade);
            $ferias = $this->FeriasService->listaFeriasPorUnidade($policial->ce_unidade);

            $contador_incial = 0;
            if(method_exists($ferias,'currentPage')){
                $contador_incial =($ferias->currentPage()-1) * 50;
            }
            return view('rh::ferias.ListaFeriasUnidade', compact('ferias', 'unidades', 'contador_incial')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
     //Autor: @Medeiros
    //Lista na view as férias dos policiais da unidade e perido passados por parâmetro
    public function listaFeriasPorUnidadeEperiodo(Request $request, $rederizacao){      
        $this->authorize('Relatorios_rh');
        try {
            $dados = $request->all();
            $ce_unidadeTemp = $dados['ce_unidade'];
            // Validando os dados
            $validator = validator($dados, [
            "ce_unidade" => "required",
            "dt_inicio"   => "required",
            "dt_final"   => "required",
            ]);
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->with('erroMsg', 'Preencha os parâmetros para consulta.');  
            }
            $policial = auth()->user();
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $unidaeService = new UnidadeService();
            if($dados['ce_unidade'][0] == 'subordinadas'){
                $unidadesSubordinadas = $unidaeService->getunidadesfilhas($policial->ce_unidade);
                $dados['ce_unidade'] = $unidadesSubordinadas;
            }else{
                $unidadesSubordinadas = $unidaeService->getunidadesfilhas($dados['ce_unidade'][0]);
                $dados['ce_unidade'] = $unidadesSubordinadas;
            }

           
            $unidades = $unidaeService->getunidadesfilhasNome($policial->ce_unidade);
        
            $ferias = $this->FeriasService->listaFeriasPorUnidadeEperiodo($dados, $rederizacao);
            $contador_incial = 0;
            if(method_exists($ferias,'currentPage')){
                $contador_incial =($ferias->currentPage()-1) * 50;
            }

            $dados['ce_unidade'] = $ce_unidadeTemp;
                  
            if($rederizacao == 'excel'){
                    return view('rh::relatorio.ListaFerias_por_unidade_excel', compact('ferias')); 
            }
                return view('rh::ferias.ListaFeriasUnidade', compact('ferias', 'unidades', 'dados', 'contador_incial')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
}

?>