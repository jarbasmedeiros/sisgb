<?php
namespace Modules\JuntaMedica\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\DashboardJpmsService;
use Dompdf\Dompdf;
use App\utis\Msg;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Api\Services\JuntaMedicaService;

class DashboardJpmsController extends Controller
{
    public function __construct(DashboardJpmsService $DashboardJpmsService, JuntaMedicaService $JuntaMedicaService ){
        $this->middleware('auth');
        $this->dashboardService = $DashboardJpmsService;
        $this->juntaMedicaService = $JuntaMedicaService;
    }
    
    public function getDados()
    {
        try{
            $dashboard = $this->dashboardService->getDados();
            return view('juntamedica::dash.dashboardJuntaMedica', compact('dashboard'));      
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    public function getMaisInformacoes($renderizacao)
    {
        try{
            if ($renderizacao == 'emAcompanhamento') {
                $prontuariosEmAcompanhamento = $this->juntaMedicaService->getProntuariosEmAcompanhamentoJPMS($renderizacao);
                $tipoProntuario = 'Pacientes em acompanhamento pela JPMS';
                return view('juntamedica::dash.listaProntuariosEmAcompanhamentoJPMS', compact('prontuariosEmAcompanhamento', 'tipoProntuario'));
            } elseif ($renderizacao == 'clinicaMedica') {
                $prontuariosEmAcompanhamento = $this->juntaMedicaService->getProntuariosEmAcompanhamentoJPMS($renderizacao);
                $tipoProntuario = 'Pacientes em acompanhamento pela Clínica Médica - JPMS';
                return view('juntamedica::dash.listaProntuariosEmAcompanhamentoJPMS', compact('prontuariosEmAcompanhamento', 'tipoProntuario'));
            } elseif ($renderizacao == 'ortopedia') {
                $prontuariosEmAcompanhamento = $this->juntaMedicaService->getProntuariosEmAcompanhamentoJPMS($renderizacao);
                $tipoProntuario = 'Pacientes em acompanhamento pela Ortopedia - JPMS';
                return view('juntamedica::dash.listaProntuariosEmAcompanhamentoJPMS', compact('prontuariosEmAcompanhamento', 'tipoProntuario'));
            } elseif ($renderizacao == 'psiquiatria') {
                $prontuariosEmAcompanhamento = $this->juntaMedicaService->getProntuariosEmAcompanhamentoJPMS($renderizacao);
                $tipoProntuario = 'Pacientes em acompanhamento pela Psiquiatria - JPMS';
                return view('juntamedica::dash.listaProntuariosEmAcompanhamentoJPMS', compact('prontuariosEmAcompanhamento', 'tipoProntuario'));
            } else {
                return redirect()->back()->with('erroMsg', MSG::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }



 
   
}
