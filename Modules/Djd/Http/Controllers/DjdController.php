<?php

namespace Modules\Djd\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Api\Services\DjdService;
use Exception;
use App\utis\Msg;
use Auth;


class DjdController extends Controller
{

    public function __construct(DjdService $djdService){
        $this->middleware('auth');
        $this-> djdService = $djdService;


    }
    /**
     * @author Carolina Praxedes
     * @issue 466
     */
    public function getDadosDash(){
        $this->authorize('DASHBOARD_DJD');
        try{
            $tituloDash='Diretoria de Justiça e Disciplina';            
            $dadosDash = $this->djdService->getDadosDash();
            $procedimentos = $this->djdService->consultarProcedimentos();
            
            return view('djd::dash.dashboardDjd',compact('dadosDash','tituloDash','procedimentos'));      
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    



    /**
     * @author Carolina Praxedes
     * @issue 459
     */
    public function listarNovosProcedimentos(){
        $this->authorize('PROCEDIMENTOS_INSTAURADOS');
        try{
            $procedimentos = $this->djdService->consultarProcedimentos();
            $msgResultado = 'Nenhum procedimento instaurado recentemente.';
            return view('djd::ListaProcedimento', compact('procedimentos','msgResultado'));     
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * 
     * @author Carolina Praxedes
     * @issue 459
     * método para redicionar a requisição get da tela de pesquisa de procedimentos
     */
    public function getBuscarProcedimentos(){
        $this->authorize('PROCEDIMENTOS_INSTAURADOS');
        try {
            return redirect('djd/procedimentos');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    /**
     * @author Carolina Praxedes
     * @issue 459
     */
    public function buscarProcedimentos(Request $request){
        $this->authorize('PROCEDIMENTOS_INSTAURADOS');
        try {   
         
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_criterio' => 'required',
                'st_filtro' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
               // return redirect()->back()->withErrors($validator)->withInput();
               throw new Exception("Preencher os campos");
            }
            $procedimentos = $this->djdService->buscarProcedimentos($dadosForm);
            
            if(empty($procedimentos)){
                $msgResultado = 'Nenhum procedimento encontrado na buscas. Redefina uma nova pesquisa!';
            }else{
                $msgResultado = 'Nenhum procedimento instaurado recentemente';
            }
            return view('djd::ListaProcedimento', compact('procedimentos','msgResultado'));             
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    /**
     * @author Carolina Praxedes
     * @issue 459
     */

    public function registrarProcedimentos($id){
        $this->authorize('PROCEDIMENTOS_INSTAURADOS');
        try {
            $retorno = $this->djdService->registrarProcedimentos($id);                 
            return redirect('djd/procedimentos')->with('sucessoMsg',$retorno);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    /**
     * @author Carolina Praxedes
     * @issue 459
     */

    public function gerarExtratoProcedimento($id){
        $this->authorize('PROCEDIMENTOS_INSTAURADOS');
        try {  
            
            $extratoProcedimento = $this->djdService->getExtratoById($id);
            if (isset($extratoProcedimento)){
                return \PDF::loadView('djd::pdf.extratoProcedimentoPDF',
                    compact('extratoProcedimento'))
                    ->stream('extratoProcedimentoPDF.pdf');
            }
        } catch (Exception $e) {
            
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }



}
