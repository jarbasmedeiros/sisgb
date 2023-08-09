<?php

namespace Modules\Rh\Http\Controllers;
use App\Http\Controllers\Controller;
use App\utis\Msg;
use Illuminate\Http\Request;
use Exception;
use Auth;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\FeriasService;
use Modules\Api\Services\CursoService;
use Response;
use Illuminate\Support\Facades\Validator;
use Modules\Api\Services\UnidadeService;

class CursoController extends Controller{

    public function __construct(PolicialService $PolicialService, CursoService $cursoService){
        $this->middleware('auth');
        $this->PolicialService = $PolicialService;
        $this->CursoService = $cursoService;
    }



     //Autor: @Medeiros
    //Lista na view as férias dos policiais da unidade do policial logado
    public function listaCursosPorUnidade($renderizacao){      
        $this->authorize('Relatorios_rh');
        try {
            $unidades = Auth::user()->unidadesvinculadas; 
            $policial = auth()->user();
            if(!isset($policial->ce_unidade)){
                throw new Exception('Usuário sem unidade.');
            }
            $unidaeService = new UnidadeService();
            $unidade = $unidaeService->getunidadesfilhasNome($policial->ce_unidade);
            $cursos = $this->CursoService->listaCursosPorUnidade($policial->ce_unidade, $renderizacao);
          
            if($renderizacao == 'excel'){
                return view('rh::relatorio.ListaCursos_por_unidade_excel', compact('cursos','dados'));
        }
        return view('rh::curso.ListaCursos_por_unidade', compact('cursos','unidade'));
       
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
          


    
     //Autor: @Medeiros
    //Lista na view as férias dos policiais da unidade e perido passados por parâmetro
    public function listaCursosPorUnidadeENome(Request $request, $rederizacao){      
        $this->authorize('Relatorios_rh');
        try {
            $dados = $request->all();
               // Validando os dados
               $validator = validator($dados, [
                "ce_unidade" => "required",
                "st_curso"   => "required",
            ]);
             
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->with('erroMsg', 'Preencha os parâmetros para consulta.');  
            }  

            
            $policial = auth()->user();
            $unidaeService = new UnidadeService();
            $unidade = $unidaeService->getunidadesfilhasNome($policial->ce_unidade);
            $cursos = $this->CursoService->listaCursosPorUnidadeENome($dados, $rederizacao);


          /*   $ferias = $this->PolicialService->listaFeriasAtivas();
 */       //dd($rederizacao);
        if($rederizacao == 'excel'){
           
                return view('rh::relatorio.ListaCursos_por_unidade_excel', compact('cursos','dados')); 
        }
        return view('rh::curso.ListaCursos_por_unidade', compact('cursos', 'unidade','dados')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
}

?>