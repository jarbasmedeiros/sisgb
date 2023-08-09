<?php

    namespace Modules\Rh\Http\Controllers;

    use App\Http\Controllers\Controller;    

    use DB;
    use Auth;
    use DateTime;
    use Modules\Rh\Entities\Cr;
    use Modules\Rh\Entities\HistoricoFerias;
    use Illuminate\Http\Request;
    use App\utis\MyLog;
    use Exception;
    use Modules\Api\Services\PolicialService;
    use Modules\Api\Services\FeriasService;
    use Modules\Api\Services\HistoricoFeriasService;
    use Modules\Api\Services\DiariasService;
    use App\Utis\Msg;

class DiariasController extends Controller{
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct( DiariasService $diariasService, PolicialService $PolicialService, FeriasService $FeriasService, HistoricoFeriasService $HistoricoFeriasService){
            $this->middleware('auth');
            $this->PolicialService = $PolicialService;
            $this->FeriasService = $FeriasService;
            $this->HistoricoFeriasService = $HistoricoFeriasService;
            $this->DiariasService = $diariasService;
        }


        public function forAuditoriaCdo(){ // Lista os policiais de férias de acordo com a lista de mátriculas e datas passada no request
            $this->authorize('AUDITORIA_CDO');
            try{
                $dados = ['st_tipo'=>null, 'st_matricula'=>null, 'dt_inicio'=>null, 'dt_final'=>null];
                return view('rh::diarias.ListaFerias_por_unidade', compact('dados'));
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        public function realizarAuditoriaCdo(Request $request){ // Lista os policiais de férias de acordo com a lista de mátriculas e datas passada no request
            $this->authorize('AUDITORIA_CDO');
          
            try{
                $dadosForm = $request->all();
                $dados = $dadosForm;
                if($dadosForm['st_tipo']!= 'unidade'){

                    $validator = validator($dadosForm, [
                        'st_tipo' => 'required',
                        'st_matricula' => 'required',
                        'dt_inicio' => 'required',
                        'dt_final' => 'required'
                    ]);
                }else{
                    $validator = validator($dadosForm, [
                        'st_tipo' => 'required',
                        'st_matricula' => 'required',
                       
                    ]);

                }

                if($validator->fails()){
                    // Mensagem de erro com o formulário preenchido
                    return redirect()->back()->withErrors($validator)->withInput();
                }
              // dd(explode(',', $dadosForm['st_matricula']));

               $dadosForm['st_matricula'] = explode(',', $dadosForm['st_matricula']);
               if($dadosForm['st_tipo'] == 'ferias'){
                   $consulta = $this->DiariasService->listapoliciaisFerias($dadosForm);          
               }elseif($dadosForm['st_tipo'] == 'licenca'){
                $consulta = $this->DiariasService->listapoliciaisLicenca($dadosForm);
            }else{
                $consulta = $this->DiariasService->listaPoliciaisMatricula($dadosForm);
               }
               if(isset( $dados['renderizacao'])){
                   return view('rh::diarias.ExportaConsultaExcel',compact('consulta', 'dados'));
               }
                return view('rh::diarias.ListaFerias_por_unidade',compact('consulta', 'dados'));
      
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }
        

    }
?>