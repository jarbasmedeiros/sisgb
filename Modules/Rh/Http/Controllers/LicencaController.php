<?php

namespace Modules\Rh\Http\Controllers;
use App\Http\Controllers\Controller;
use App\utis\Msg;
use App\utis\Funcoes;
use Illuminate\Http\Request;
use Exception;
use Auth;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\LicencaService;

class LicencaController extends Controller{

    public function __construct(PolicialService $PolicialService, LicencaService $LicencaService){
        $this->middleware('auth');
        $this->PolicialService = $PolicialService;
        $this->LicencaService = $LicencaService;
    }

    /* 
    Autor: @higormelo. 
    Issue 205, refatorar licencas de policial
    A função retorna lista com todas as licenças do policial e seus respectivos históricos. 
    */
    public function getLicencaPolicial($idPolicial)
    {
        try{
            $permissoes = Auth::user()->permissoes;
            $policial = $this->PolicialService->findPolicialById($idPolicial);
            $licenca =  $this->LicencaService->getLicencaPolicial($idPolicial);
           // dd($licenca);
            $tiposLicenca =  $this->LicencaService->getAllTipos();
            try {
                if( auth()->user()->can('Edita_rh')){
                    if( in_array('qualquerUnidade',$permissoes)){
                        return view('rh::licenca.ListaLicenca', compact('policial', 'licenca', 'tiposLicenca'));
                    }else{
                    Funcoes:: verificaVinculoDoUsuarioComUnidade( $policial->ce_unidade);
                    return view('rh::licenca.ListaLicenca', compact('policial', 'licenca', 'tiposLicenca'));  
                    }
                }elseif(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::licenca.ExibirLicenca', compact('policial', 'licenca', 'tiposLicenca'));  
                   // return view('rh::policial.ExibirDadosPessoais', compact('policial'));              
                }else{
                    throw new Exception('Este perfil não tem permissão para acessar esta página');
                    
                }
                return view('rh::licenca.ListaLicenca', compact('policial', 'licenca', 'tiposLicenca')); 
            
            } catch (Exception $e) {
              
                if(auth()->user()->can('CONSULTA_QUALQUER _UNIDADE')){
                    return view('rh::licenca.ExibirLicenca', compact('policial', 'licenca', 'tiposLicenca')); 
                }else{
                    throw new Exception($e->getMessage()); 
                }
            }  
            return view('rh::licenca.ListaLicenca', compact('policial', 'licenca', 'tiposLicenca')); 
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /* 
    Autor: @higormelo. 
    Issue 205, refatorar licencas de policial
    A função cria a licença do policial e seus respectivos históricos. 
    */
    public function criaLicencaPolicial($idPolicial, Request $request)
    {
        try{
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'ce_tipo' => 'required',
                'dt_inicio' => 'required',
                'dt_termino' => 'required',
                'nu_dias' => 'required',
                'st_publicacao' => 'required',
                'dt_publicacao' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $this->LicencaService->criaLicencaPolicial($idPolicial, $dadosForm);
            return redirect()->back()->with('sucessoMsg', Msg::SALVO_SUCESSO); 
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /* 
    Autor: @higormelo. 
    Issue 205, refatorar licencas de policial
    A função cria as férias do policial e seus respectivos históricos. 
    */
    public function updateLicencaPolicial($idPolicial, $idLicenca, Request $request)
    {
        try{
            // Recebendo os dados do formulário
            $dadosForm = $request->all();
            // Validando os dados
            $validator = validator($dadosForm, [
                'ce_tipo' => 'required',
                'dt_inicio' => 'required',
                'dt_termino' => 'required',
                'nu_dias' => 'required',
                'st_publicacao' => 'required',
                'dt_publicacao' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $this->LicencaService->updateLicencaPolicial($idPolicial, $idLicenca, $dadosForm);
            return redirect()->back()->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO); 
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     //Autor: @Medeiros
    //Lista na view as férias dos policiais da unidade do policial logado
    public function listaLicencasPorUnidade(){      
        $this->authorize('Relatorios_rh');
        try {
            
            $unidades = Auth::user()->unidadesvinculadas; 
            $licencas = $this->LicencaService->listaLicencasPorUnidade();
          /*   $ferias = $this->PolicialService->listaFeriasAtivas();
 */
            return view('rh::licenca.ListaLicenca_por_unidade', compact('licencas', 'unidades')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

     //Autor: @Medeiros
    //Lista na view as licenças dos policiais da unidade e perido passados por parâmetro
    public function listaLicencasPorUnidadeEperiodo(Request $request, $rederizacao){      
        $this->authorize('Relatorios_rh');
        try {
            $dados = $request->all();

               // Validando os dados
               $validator = validator($dados, [
                "ce_unidade" => "required",
                "dt_inicio"   => "required",
                "dt_final"   => "required",
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->with('erroMsg', 'Preencha os parâmetros para consulta.');  
            }  

           
            $unidades = Auth::user()->unidadesvinculadas; 
            $licencas = $this->LicencaService->listaLicencasPorUnidadeEperiodo($dados, $rederizacao);
       
        if($rederizacao == 'excel'){
                return view('rh::relatorio.ListaLicencas_por_unidade_excel', compact('licencas')); 
        }
            return view('rh::licenca.ListaLicenca_por_unidade', compact('licencas', 'unidades', 'dados')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

     //Autor: @Alexia
    //exclui licença
    //issue: #379
    public function excluirLicenca( Request $request,  $idPolicial, $idLicenca){
        try{
           
            //recebe os dados
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_motivoexclusao' => 'required'
                ]);
            //faz a validacao
                if($validator->fails()){
                    // Mensagem de erro com o formulário preenchido
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            
            $response = $this->LicencaService->excluiLicenca($idPolicial, $idLicenca, $dadosForm);

            //redireciona para a tela de dependentes e retorna erro ou sucesso
            return redirect('rh/policiais/edita/'.$idPolicial.'/licencas')->with('sucessoMsg', $response); 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }         
    }
}

?>