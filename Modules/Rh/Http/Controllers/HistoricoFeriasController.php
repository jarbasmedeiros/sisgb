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
    use App\Utis\Msg;

class HistoricoFeriasController extends Controller{
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct(PolicialService $PolicialService, FeriasService $FeriasService, HistoricoFeriasService $HistoricoFeriasService){
            $this->middleware('auth');
            $this->PolicialService = $PolicialService;
            $this->FeriasService = $FeriasService;
            $this->HistoricoFeriasService = $HistoricoFeriasService;
        }

        public function lista($idPolicial, $idFerias){ //Página de listagem do histórico de férias de férias específica
            try{
                $policial = $this->PolicialService->findPolicialById($idPolicial);
                $ferias =  $this->HistoricoFeriasService->getHistoricoFeriasPolicial($idPolicial, $idFerias);
                $faltaAgendar = 0;



                $diasGozados = 0;

                foreach($ferias->historicos as $h){
                    if(($h->st_tipo == "Ferias"  || $h->st_tipo == "FÉRIAS") && $h->st_status != "Assegurado" && $h->st_status != "Cancelado"){
                        $faltaAgendar += $h->nu_dias;
                   
                   
                        if($h->dt_fim <= date('Y-m-d')){
                            $diasGozados += $h->nu_dias;
                        }elseif($h->dt_inicio <= date('Y-m-d')){
                            $agora = new DateTime();
                            $dt_inicio = new DateTime($h->dt_inicio);
                            $diferenca = $dt_inicio->diff($agora)->format("%a");
                            $diasGozados += $diferenca;
                        }
                    }
                }
                $ferias->nu_dias_gozadas = $diasGozados;

                $faltaAgendar = $ferias->nu_dias - $faltaAgendar;
                return view('rh::ferias.Historico', compact('policial', 'ferias', 'faltaAgendar'));
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        public function create($idPolicial, $idFerias){ //Abre página de criação de novo histórico de férias
            $this->authorize('Edita');
            return view('rh::ferias.Form_cad_historico', compact('idPolicial', 'idFerias'));
        }

        public function edit($idPolicial, $idFerias, $idHistorico){ //Abre página de edição de histórico de férias
            $this->authorize('Edita');
                
            $historico = $this->HistoricoFeriasService->getHistoricoFerias($idHistorico);

            return view('rh::ferias.Form_edit_historico', compact('idPolicial', 'idFerias', 'historico'));
        }

        public function store(Request $request, $tipo, $idHistorico, $idFerias){ // Salva novo Histórico de férias
            $this->authorize('Edita');
            try{
                $dadosForm = $request->all();
                if($tipo == "assegurar"){
                    $msg = $this->HistoricoFeriasService->assegurar($idHistorico, $idFerias, $dadosForm);
                    return redirect()->back()->with('sucessoMsg', $msg);
                }elseif($tipo == "ferias"){
                    $msg = $this->HistoricoFeriasService->create($idFerias, $dadosForm);
                    // Neste caso $idHistorico sera o id do policial
                    return redirect('/rh/historicoferias/lista/' . $idHistorico . '/' . $idFerias)->with('sucessoMsg', $msg);
                }elseif($tipo == "cancelar"){
                    $msg = $this->HistoricoFeriasService->cancelar($idHistorico, $idFerias, $dadosForm);
                    return redirect()->back()->with('sucessoMsg', $msg);
                }else{
                    return redirect()->back()->with('erroMsg', Msg::HISTORICO_FERIAS_TIPO_ERRADO);
                }
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        public function update(Request $request, $idPolicial, $idFerias, $idHistorico){ // Edita histórico de férias
            $this->authorize('Edita');
            $dadosForm = $request->all();
            try{
                $msg = $this->HistoricoFeriasService->update($idHistorico, $dadosForm);
                return redirect('/rh/historicoferias/lista/' . $idPolicial . '/' . $idFerias)->with('sucessoMsg', $msg);
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        public function destroy($id){ // Deleta histórico de férias
            $this->authorize('Edita');

            DB::beginTransaction();
            try{
                $hist = HistoricoFerias::find($id); // Busca o histórico
                $delete = $hist->update(['bo_ativo' => 0]);
                $cr = $hist->ce_crs; // Necessário saber a cr para qual vai ser redirecionado a view em caso de sucesso
                if($delete) { // Deleta o histórico
                    $acao = "Delete";      
                    $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' deletou o historico de id = ' . $id;
                    // Chamando a classe para registra a alteração na tabela logs.
                    MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                    DB::commit();
                    // Se deu certo, redireciona para tela de listagem de funcionario
                    return redirect('/rh/historicoferias/lista/'. $cr)->with('sucessoMsg', 'Historico deletado com sucesso!');
                } else {
                    DB::rollback();
                    $acao = "Delete";      
                    $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' tentou deletar o historico e não conseguiu.';
                    // Chamando a classe para registra a alteração na tabela logs.
                    MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                    return redirect()->back()->with('erroMsg', 'Falha ao deletar o historico');
                }
            }catch(Exception $e){
                DB::rollback();
                return redirect()->back()->with('erroMsg', 'Falha ao deletar o Histórico.');
            }
        }
    }
?>