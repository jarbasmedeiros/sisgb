<?php

    namespace Modules\Rh\Http\Controllers;

    use App\Http\Controllers\Controller;    

    use Illuminate\Http\Request;
    use Exception;
    use Modules\Api\Services\PolicialService;
    use Modules\Api\Services\LicencaService;
    use Modules\Api\Services\HistoricoLicencaService;
    use App\Utis\Msg;

class HistoricoLicencaController extends Controller{
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct(PolicialService $PolicialService, LicencaService $LicencaService, HistoricoLicencaService $HistoricoLicencaService){
            $this->middleware('auth');
            $this->PolicialService = $PolicialService;
            $this->LicencaService = $LicencaService;
            $this->HistoricoLicencaService = $HistoricoLicencaService;
        }

        public function lista($idPolicial, $idLicenca){ //Página de listagem do histórico de licença de licença específica
            try{
                $policial = $this->PolicialService->findPolicialById($idPolicial);
                $licenca =  $this->HistoricoLicencaService->getHistoricoLicencaPolicial($idPolicial, $idLicenca);
                $faltaAgendar = 0;
                foreach($licenca->historicos as $h){
                    if($h->st_tipo == "Licenca" && $h->st_status != "Assegurado" && $h->st_status != "Cancelado"){
                        $faltaAgendar += $h->nu_dias;
                    }
                }
                $faltaAgendar = $licenca->nu_dias - $faltaAgendar;
                return view('rh::licenca.Historico', compact('policial', 'licenca', 'faltaAgendar'));
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        public function create($idPolicial, $idLicenca){ //Abre página de criação de novo histórico de licença
            $this->authorize('Edita');
            return view('rh::licenca.Form_cad_historico', compact('idPolicial', 'idLicenca'));
        }

        public function edit($idPolicial, $idLicenca, $idHistorico){ //Abre página de edição de histórico de licença
            $this->authorize('Edita');
                
            $historico = $this->HistoricoLicencaService->getHistoricoLicenca($idHistorico);

            return view('rh::licenca.Form_edit_historico', compact('idPolicial', 'idLicenca', 'historico'));
        }

        public function store(Request $request, $tipo, $idHistorico, $idLicenca){ // Salva novo Histórico de licença
            $this->authorize('Edita');
            try{
                $dadosForm = $request->all();
                if($tipo == "assegurar"){
                    $msg = $this->HistoricoLicencaService->assegurar($idHistorico, $idLicenca, $dadosForm);
                    return redirect()->back()->with('sucessoMsg', $msg);
                }elseif($tipo == "licenca"){
                    $msg = $this->HistoricoLicencaService->create($idLicenca, $dadosForm);
                    // Neste caso $idHistorico sera o id do policial
                    return redirect('/rh/historicolicenca/lista/' . $idHistorico . '/' . $idLicenca)->with('sucessoMsg', $msg);
                }elseif($tipo == "cancelar"){
                    $msg = $this->HistoricoLicencaService->cancelar($idHistorico, $idLicenca, $dadosForm);
                    return redirect()->back()->with('sucessoMsg', $msg);
                }else{
                    return redirect()->back()->with('erroMsg', Msg::HISTORICO_LICENCA_TIPO_ERRADO);
                }
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        public function update(Request $request, $idPolicial, $idLicenca, $idHistorico){ // Edita histórico de licença
            $this->authorize('Edita');
            $dadosForm = $request->all();
            try{
                $msg = $this->HistoricoLicencaService->update($idHistorico, $dadosForm);
                return redirect('/rh/historicolicenca/lista/' . $idPolicial . '/' . $idLicenca)->with('sucessoMsg', $msg);
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        // public function destroy($id){ // Deleta histórico de licença
        //     $this->authorize('Edita');

        //     DB::beginTransaction();
        //     try{
        //         $hist = HistoricoFerias::find($id); // Busca o histórico
        //         $delete = $hist->update(['bo_ativo' => 0]);
        //         $cr = $hist->ce_crs; // Necessário saber a cr para qual vai ser redirecionado a view em caso de sucesso
        //         if($delete) { // Deleta o histórico
        //             $acao = "Delete";      
        //             $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' deletou o historico de id = ' . $id;
        //             // Chamando a classe para registra a alteração na tabela logs.
        //             MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        //             DB::commit();
        //             // Se deu certo, redireciona para tela de listagem de funcionario
        //             return redirect('/rh/historicoferias/lista/'. $cr)->with('sucessoMsg', 'Historico deletado com sucesso!');
        //         } else {
        //             DB::rollback();
        //             $acao = "Delete";      
        //             $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' tentou deletar o historico e não conseguiu.';
        //             // Chamando a classe para registra a alteração na tabela logs.
        //             MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        //             return redirect()->back()->with('erroMsg', 'Falha ao deletar o historico');
        //         }
        //     }catch(Exception $e){
        //         DB::rollback();
        //         return redirect()->back()->with('erroMsg', 'Falha ao deletar o Histórico.');
        //     }
        // }
    }
?>