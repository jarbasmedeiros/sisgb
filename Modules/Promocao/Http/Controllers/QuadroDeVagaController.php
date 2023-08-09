<?php 
namespace Modules\Promocao\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;


use Modules\Api\Services\QuadroDeVagaService;

class QuadroDeVagaController extends Controller{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct( QuadroDeVagaService $QuadroDeVagaService){        
        $this->QuadroDeVagaService = $QuadroDeVagaService;
    }

    /**
    * Método para listar o quantitativo de vagas
    */
    public function listarVagas(){
        try{        
            $this->authorize('ATUALIZAR_QUANTITATIVO_VAGAS');   
            $vagas = $this->QuadroDeVagaService->getQuantitativoDeVagas();
            return view('promocao::quadroDeVagas.quantitativoDeVagas', compact('vagas'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
    * Método para Atualizar o quantitativo de vagas
    */
    public function atualizaVagas(Request $request){
        try{
            $this->authorize('ATUALIZAR_QUANTITATIVO_VAGAS');   
            $dadosForm = $request->all();
            $atualizados = $this->QuadroDeVagaService->atualizaQuantitativoDeVagas($dadosForm);
            return redirect()->back()->with('sucessoMsg', $atualizados);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
   
}