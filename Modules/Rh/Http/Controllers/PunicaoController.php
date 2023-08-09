<?php

namespace Modules\Rh\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\User;
use App\Utis\Msg;
use Auth;

use Modules\Api\Services\PolicialService;
use Modules\Api\Services\RgService;
use Modules\Api\Services\PunicaoService;
use Modules\Api\Services\ArquivoBancoService;
use App\utis\Funcoes;

use LaravelQRCode\Facades\QRCode;
use Exception;

class PunicaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   
    
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PunicaoService $punicaoService, RgService $rgService, PolicialService $policialService){
        $this->middleware('auth');
        $this->policialService = $policialService;
        $this->rgService = $rgService;  
        $this->punicaoService = $punicaoService;  
        
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
   


    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('rh::show');
    }


    
    /**
     * @medeiros - #303
     * retorna os dados do prontuário do rg
     * @param int $id
     */
    public function GetPunicoesPolicial($idPolicial)
    {
      
       try {
        $permissoes = Auth::user()->permissoes;
        $policial = $this->policialService->findPolicialById($idPolicial);
        $punicaoService = new PunicaoService();
      $punicoes = $punicaoService->GetPunicoesPolicial($idPolicial);

        if( auth()->user()->can('Edita_rh')){
            if( in_array('qualquerUnidade',$permissoes)){
                return view('rh::policial.ListaPunicoes', compact('punicoes', 'policial')); 
            }else{
            Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
            return view('rh::policial.ListaPunicoes', compact('punicoes', 'policial'));  
            }
        }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
            return view('rh::policial.ListaPunicoes', compact('punicoes', 'policial'));
        }else{
            throw new Exception('Este perfil não tem permissão para acessar esta página');
            
        }
          
       } catch (Exception $e) {
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
    }
    /*Autor: @medieros. 
    Abre o formulário para cadastrar uma nova punição
    
    */
    public function formCadPunicao($idPolicial){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->policialService->findPolicialById($idPolicial);
            return view('rh::policial.FormCadPunicao', compact('policial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*Autor: @medeiros. 
    Cadastra uma nova Punição do policial
    */
    public function cadastraPunicao(Request $request, $idPolicial){
        $this->authorize('Edita_rh');
        try{
            $this->authorize('Edita_rh');
            $dados =$request->all();
            $validator = validator($dados, [
                'st_tipo' => 'required',
                'dt_punicao' => 'required',
                'st_boletim' => 'required',
                'dt_boletim' => 'required',
                'st_gravidade' => 'required',
                'st_comportamento' => 'required',
                'st_materia' => 'required',
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
           

          /*   $punicaoService = new PunicaoService();
            $punicaoService->cadastraPunicao($idPolicial, $dados);        
          dd('vkl'); */
            $this->punicaoService->cadastraPunicao($idPolicial, $dados);
            //$this->PolicialService->cadastraPublicacao($idPolicial, $dados);

            return redirect('rh/policiais/'.$idPolicial.'/punicoes')->with('sucessoMsg', Msg::SALVO_SUCESSO);
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }
    /*Autor: @medieros. 
    Abre o formulário para editar uma  punição
    Busca um objeto policial pelo ID e passa esse objeto para a view de Edição
    */
    public function formEditaPunicao($idPolicial, $idPunicao){
        $this->authorize('Edita_rh');
        try{
            $policial = $this->policialService->findPolicialById($idPolicial);
            $punicao = $this->punicaoService->findPunicaoById($idPolicial, $idPunicao);
            return view('rh::policial.FormEditaPunicao', compact('policial', 'punicao'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
   
    /*Autor: @medeiros. 
     uma nova Punição do policial
    */
    public function editaPunicao(Request $request, $idPolicial, $idPunicao){
        $this->authorize('Edita_rh');
        try{
            $this->authorize('Edita_rh');
            $dados =$request->all();
            $validator = validator($dados, [
                'st_tipo' => 'required',
                'dt_punicao' => 'required',
                'st_boletim' => 'required',
                'dt_boletim' => 'required',
                'st_gravidade' => 'required',
                'st_comportamento' => 'required',
                'st_materia' => 'required',
                'st_status' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if($dados['st_status'] != 'ATIVA' ){
                $validator = validator($dados, [
                    'st_boletimcancelamentoanulacao' => 'required',
                    'dt_boletimcancelamentoanulacao' => 'required',
                    'dt_cancelamentoanulacao' => 'required',
                ]);
    
                if($validator->fails()){
                    // Mensagem de erro com o formulário preenchido
                    return redirect()->back()->withErrors($validator)->withInput();
                }

            }elseif((!empty($dados['st_boletimcancelamentoanulacao']))|| (!empty($dados['dt_boletimcancelamentoanulacao']))|| (!empty($dados['dt_cancelamentoanulacao']))){
                return redirect()->back()->with('erroMsg', 'Para salvar as informações da punicão com status ativa os campos BOLETIM DE CANCELAMENTO, DATA DO BOLETIM DE CANCELAMENTO e DATA DO CANCELAMENTO devem está sem informação.');
            }
          /*   $punicaoService = new PunicaoService();
            $punicaoService->cadastraPunicao($idPolicial, $dados);        
          dd('vkl'); */
            $this->punicaoService->editaPunicao($idPolicial, $idPunicao, $dados);
            //$this->PolicialService->cadastraPublicacao($idPolicial, $dados);
            
            return redirect('rh/policiais/'.$idPolicial.'/punicoes')->with('sucessoMsg', Msg::SALVO_SUCESSO);
           
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());

        }

    }
   
      /*issue:365-criar-aba-dependentes
         * exclui uma punicao
         * Alexia 
         */
    public function excluirPunicao($idPolicial, $idPunicao){
        try{
            $msg = $this->punicaoService->excluirPunicao($idPolicial, $idPunicao);
            return redirect('rh/policiais/'.$idPolicial.'/punicoes')->with('sucessoMsg', $msg); 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }     
    }
   
}
        