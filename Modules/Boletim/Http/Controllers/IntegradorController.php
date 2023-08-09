<?php

    namespace Modules\Boletim\Http\Controllers;

    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use App\Http\Controllers\Controller;
    use Modules\Api\Services\IntegradorService;
    use Modules\Api\Services\PolicialService;
    use Auth;
    use App\utis\Status;
    use App\utis\Msg;
    use App\Ldap\Authldap;
    use Modules\Boletim\Entities\Capa;
    use Modules\Boletim\Http\Providers\BoletimServiceProvider;
    use Illuminate\Support\Facades\Storage;

    class IntegradorController extends Controller
    {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function __construct(IntegradorService $IntegradorService, PolicialService $PolicialService){
            $this->middleware('auth');
            $this->IntegradorService = $IntegradorService;
            $this->PolicialService = $PolicialService;
        }

        public function listaAgendamentos()
        {
            try{
                $this->authorize('elabora_boletim');
                $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
                $policial = $this->PolicialService->buscaPolicialcpf($cpf);
                $integracoes = $this->IntegradorService->listaAgendamentos();
                return view('boletim::integrador/agendamentos', compact('integracoes', 'policial'));
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        public function integrarBoletim($idIntegrador){
            try{
                $this->authorize('Admin');
                $integracao = $this->IntegradorService->integrarBoletim($idIntegrador);
                return redirect('boletim/integrador/integrarboletim/'.$idIntegrador.'/checagem')->with('sucessoMsg', $integracao);
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }
        public function checarIntegracoes($idIntegrador){
            try{
                $this->authorize('Admin');
                $integracoes = $this->IntegradorService->checarIntegracao($idIntegrador);
                return view('boletim::integrador/agendamentoschecagem', compact('integracoes'));
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

    }

?>