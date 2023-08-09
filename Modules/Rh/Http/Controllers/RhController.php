<?php

namespace Modules\Rh\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\User;
use DB;
use Modules\Api\Services\RhService;


class RhController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function __construct(RhService $RhService){
        $this->middleware('auth');
        $this->RhService = $RhService;
    }    

    /**
     * cb Araújo
     * 01-02-2022
     * Dashboard do menu lateral do Recursos Humanos
     */
    public function getDados(){
        $this->authorize('DASHBOARD_RH');//<<MUDAR ESTA AUTORIZAÇÃO
        try{
            
            $dashboard = $this->RhService->getDashboard();

            return view('rh::dash.dashboardRh', compact('dashboard'));      
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Alexia Tuane
     * issue: 487 - criar-tela-de-dashboard-censo-religioso
     * Dashboard do menu lateral do Recursos Humanos
     */
    public function DashboardCensoReligioso(){
        try{
            $this->authorize('LISTA_EFETIVO_GERAL');
            
            $dashboard = $this->RhService->getDashboardCensoReligioso();
            return view('rh::policial.DashboardCensoReligioso', compact('dashboard'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Alexia Tuane
     * issue: 487 - criar-tela-de-dashboard-censo-religioso
     * Dashboard do menu lateral do Recursos Humanos
     */
    public function categoriaReligiosaDetalhada($idCategoria){
        try{
            $this->authorize('LISTA_EFETIVO_GERAL');
            $denominacoesReligiosas = $this->RhService->categoriaReligiosaDetalhada($idCategoria);
            $tipo = 'categoriadetalhada';
            return view('rh::pdf.CensoReligiosoPdf', compact('denominacoesReligiosas', 'tipo'));
           /*  return view('rh::policial.DashboardCensoReligioso', compact('dashboard')); */
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
 /**
     * Alexia Tuane
     * issue: 487 - criar-tela-de-dashboard-censo-religioso
     * Dashboard do menu lateral do Recursos Humanos
     */
    public function PdfCensoReligioso($tipo){
        try{
            $this->authorize('LISTA_EFETIVO_GERAL');
            $censoReligioso = $this->RhService->getDashboardCensoReligioso();
            return view('rh::pdf.CensoReligiosoPdf', compact('censoReligioso', 'tipo'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
}
