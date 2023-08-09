<?php
namespace Modules\JuntaMedica\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\JuntaMedicaService;
use Dompdf\Dompdf;
use App\utis\Msg;
use Maatwebsite\Excel\Facades\Excel;




class JuntaMedicaController extends Controller
{
    public function __construct(JuntaMedicaService $juntaMedicaService ){
        $this->middleware('auth');
        $this->juntaMedicaService = $juntaMedicaService;
        
    }
    
    public function showFormProntuario()
    {
        return view('juntamedica::prontuario.buscaprontuario');      
    }

    public function buscaProntuario(Request $request)
    {
        try{
            $dadosForm = $request->all();            
            //Validando os dados
            $validator = validator($dadosForm, [
                'criterio' => 'required',
                ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $policialService = new PolicialService();
            $policiais = $policialService->buscaPolicialNomeCpfMatricula($dadosForm['criterio']);
            return view('juntamedica::prontuario.buscaprontuario',compact('policiais'));      
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }



    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('juntamedica::index');
  /*       $totalPorparecer =  DashboardService::getTotalParecer();
        $totalMotivos =  DashboardService::getTotalMotivos();
 
        
         return view('home', compact('totalPorparecer', 'totalMotivos', 'licencaFim', 'licencaInicio')); */
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('juntamedica::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($idPolicial)
    {    
        try {
            $policialService = new PolicialService();
            $policial = $policialService->findPolicialById($idPolicial);
            $crs = $this->juntaMedicaService->listaAtendimentos($idPolicial);
            return view('juntamedica::prontuario.prontuario_show_frm',compact('crs', 'policial')); 
        } catch (Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
             
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('juntamedica::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        
    }

    /* @aggeu. Issue 241: Implementar crud de atendimento pela comissão de acompanhamento da JPMS. */
    public function showFormAtendimento($idPolicial)
    {
        try{
            $policialService = new PolicialService();
            $policial = $policialService->findPolicialById($idPolicial);
            return view('juntamedica::prontuario.atendimento_new_frm', compact('policial'));   
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }  
    }

    /* @aggeu. Issue 241: Implementar crud de atendimento pela comissão de acompanhamento da JPMS. */
    public function showFormEditaAtendimento($idAtendimento)
    {
        try{
            $atendimento = $this->juntaMedicaService->getAtendimento($idAtendimento);
            return view('juntamedica::prontuario.atendimento_edit_frm', compact('atendimento'));   
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }  
    }

    /* @aggeu. Issue 241: Implementar crud de atendimento pela comissão de acompanhamento da JPMS. */
    public function cadastraAtendimento(Request $request, $idPolicial)
    {
        try{
            $dados = $request->all();
                if($dados['st_parecer'] == "APTO COM RESTRIÇÃO"){
                $validator = validator($dados, [
                    'dt_atendimento' => 'required',
                    'st_parecer' => 'required',
                    'st_restricao' => 'required',
                    'st_medico' => 'required'
                ]);
            }else{
                $validator = validator($dados, [
                    'dt_atendimento' => 'required',
                    'st_parecer' => 'required',
                    'st_medico' => 'required'
                ]);
            }

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }          

            $this->juntaMedicaService->cadastraAtendimento($idPolicial, $dados);
            return redirect('juntamedica/prontuario/show/'.$idPolicial)->with('sucessoMsg', Msg::SALVO_SUCESSO); 
        
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    /* @aggeu. Issue 241: Implementar crud de atendimento pela comissão de acompanhamento da JPMS. */
    public function excluiAtendimento($idAtendimento){
        try{       
            $this->juntaMedicaService->excluiAtendimento($idAtendimento);
            return redirect()->back()->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
        } catch (\Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* @aggeu. Issue 241: Implementar crud de atendimento pela comissão de acompanhamento da JPMS. */
    public function atualizaAtendimento(Request $request, $idAtendimento)
    {
        try{
            $dados = $request->all();
            if($dados['st_parecer'] == "APTO COM RESTRIÇÃO"){
                $validator = validator($dados, [
                    'dt_atendimento' => 'required',
                    'st_parecer' => 'required',
                    'st_restricao' => 'required',
                    'st_medico' => 'required'
                ]);
            }else{
                $validator = validator($dados, [
                    'dt_atendimento' => 'required',
                    'st_parecer' => 'required',
                    'st_medico' => 'required'
                ]);
            }

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            } 
            $atendimento = $this->juntaMedicaService->getAtendimento($idAtendimento);
               
                  
            $this->juntaMedicaService->atualizaAtendimento($atendimento->id, $dados);
            return redirect('juntamedica/prontuario/show/'.$atendimento->ce_policial)->with('sucessoMsg', MSG::ATUALIZADO_SUCESSO); 
        
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }
    //@author Juan Mojica
    //Retorna a lista de atendimentos do dia registrados pela CMAPM aguardando publicação em BG 
    public function getAguardandoPublicacaoCMAPM($renderizacao){
        try {
            $atendimentosAguardandoPublicacao = $this->juntaMedicaService->getAguardandoPublicacaoCMAPM();
            if($renderizacao == 'show'){
                return view('juntamedica::atendimentos.listaAtendimentosAguardandoPublicacaoCMAPM', compact('atendimentosAguardandoPublicacao'));
            }elseif($renderizacao == 'pdf'){
                $restricoesConcatenadas = ' ';
                return \PDF::loadView('juntamedica::pdf.pdfListaAtendimentosAguardandoPublicacaoCMAPM', compact('atendimentosAguardandoPublicacao', 'restricoesConcatenadas'))->stream('atendimentosAguardandoPublicacao.pdf');
            }else{
                throw new Exception (Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }          
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }   
    
    //@author Juan Mojica
    //Retorna a lista de atendimentos do dia registrados pela CMAPM 
    public function getAtendimentosDiariosCMAPM($renderizacao){
        try {
            $atendimentos = $this->juntaMedicaService->getAtendimentosDiariosCMAPM();
            if($renderizacao == 'show'){
                return view('juntamedica::atendimentos.listaAtendimentosDiariosCMAPM', compact('atendimentos'));
            }elseif($renderizacao == 'pdf'){
                $restricoesConcatenadas = ' ';
                return \PDF::loadView('juntamedica::pdf.pdfListaAtendimentosDiariosCMAPM', compact('atendimentos', 'restricoesConcatenadas'))->stream('atendimentos.pdf');
            }else{
                throw new Exception (Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }          
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }

    //@author Juan Mojica
    //Retorna a lista de policiais em acompanhamento pela CMAPM 
    public function getPoliciaisEmAcompanhamentoCMAPM(){
        try {
            $policiaisEmAcompanhamento = $this->juntaMedicaService->getPoliciaisEmAcompanhamentoCMAPM();
            return view('juntamedica::atendimentos.listaPoliciaisEmAcompanhamentoCMAPM', compact('policiaisEmAcompanhamento')); 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }

    //@author Juan Mojica
    //Retorna o pdf com a lista de policiais em acompanhamento pela CMAPM 
    public function getPdfExcelPoliciaisEmAcompanhamentoCMAPM($renderizacao){
        try {
            $policiaisEmAcompanhamento = $this->juntaMedicaService->getPdfPoliciaisEmAcompanhamentoCMAPM(); 
            if($renderizacao == 'pdf'){
                return \PDF::loadView('juntamedica::pdf.pdfListaPoliciaisEmAcompanhamentoCMAPM', compact('policiaisEmAcompanhamento'))->stream('PoliciaisEmAcompanhamentoCMAPM.pdf');
            }elseif($renderizacao == 'excel'){
                return view('juntamedica::excel.ExcelListaPoliciaisEmAcompanhamentoCMAPM', compact('policiaisEmAcompanhamento'));
            }else{
                throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            } 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }        
    }

//@author Alexia
//Retorna a lista de policiais em acompanhamento pela JPMS
public function getRelatorioAcompanhamentoJPMS(){
    try {
        $policiaisEmAcompanhamento = $this->juntaMedicaService->getRelatorioAcompanhamentoJPMS();
        return view('juntamedica::cmapm.relatorioacompanhamento', compact('policiaisEmAcompanhamento')); 
    } catch (Exception $e) {
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }        
}
 
public function getExcelPoliciaisEmAcompanhamentoJPMS($idGraduacao, $renderizacao){
    try { 
        $policiaisEmAcompanhamento = $this->juntaMedicaService->getExcelPoliciaisEmAcompanhamentoJPMS($idGraduacao, $renderizacao);
       if($renderizacao == 'listagem'){
            return view('juntamedica::cmapm.listacompanhamento', compact('policiaisEmAcompanhamento', 'idGraduacao')); 
        }elseif($renderizacao == 'excel'){

            return view('juntamedica::excel.ExcelListaPoliciaisEmAcompanhamentoJPMS', compact('policiaisEmAcompanhamento' , 'idGraduacao'));
        }else{
            throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
        } 
    } catch (Exception $e) {
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }        
}

//@author Alexia
//ISSUE:337  Retona a lista de cids

public function getrelatorioAtendimento(){
    try {
        $relatorioAtendimento = $this->juntaMedicaService->getrelatorioAtendimento();
         return view('juntamedica::atendimentos.relatorioAtendimentoJPMS', compact('relatorioAtendimento'));
    } catch (Exception $e) {
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }        
}

//@author Alexia
//ISSUE:337 retorna a lista de atendimento medicos da JPMS por periodo e cids 
public function atendimentoPeriodo(Request $request, $renderizacao){
    try{
        $dadosForm = $request->all();
        $validator = validator($dadosForm,[
            'dt_inicio ' => 'required',
            'dt_termino' => 'required',
            'ce_cid'  => 'required',
            ]);
    
        $dados = $this->juntaMedicaService->atendimentoPeriodo($dadosForm); 
        if($renderizacao == 'lista'){
            return view('juntamedica::atendimentos.listaRelatorioAtendimento', compact('dados',  'dadosForm')); 
        }elseif($renderizacao == 'excel'){
           return view('juntamedica::atendimentos.excelAtendimento', compact('dados'));
        }else{
            throw new Exception(Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
        } 
    } catch (Exception $e) {
        return redirect()->back()->with('erroMsg', $e->getMessage());
    }        
}

}
