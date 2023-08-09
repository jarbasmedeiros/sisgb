<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use DB;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Role;
use Illuminate\Support\Facades\Validator;
use App\utis\MyLog;
use Auth;
use App\utis\Msg;
use Exception;
use Modules\Api\Services\UnidadeService;



class UnidadeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UnidadeService $unidadeService )
    {
        $this->middleware('auth');
   
        $this->unidadeService = $unidadeService;

       
    }


    #Página inicial das unidades
    public function index()
    {
       try {
            $this->authorize('Leitura');
            $unidades = $this->unidadeService->getUnidadesPaginadas();   
            
            return view('admin::unidades.listagem',compact('unidades'));
       } catch (Exception $e) {
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
    }


    #Formulário de criação de novas unidades
    public function create()
    {
       try {
            $this->authorize('Administrador');
            $unidades=$this->unidadeService->getUnidade();
            return view('admin::unidades.create',compact('unidades'));
       } catch (Exception $e) {
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
    }
    /*@autor: Carolina Praxedes
    Branch: 474-demandas-da-cel-pettra
    Mostra todas as informações da unidade do id  */ 
    public function showDetalhesUnidades($id){
        
        try{
            $this->authorize('Leitura');
            
            $unidades=$this->unidadeService->getUnidade();
            
            $unidade=null;
            foreach ($unidades as $obj) {
                if($obj->id == $id){
                    $unidade = $obj;
                }
            }
            //dd($unidade);
            if(empty($unidade)){
                throw new Exception("Unidade não localizada");
            }
            
            // dd($unidade);
            return view('admin::unidades.detalhes',compact('unidade','unidades'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }
    }
    /*@autor: Carolina Praxedes
    Branch: 474-demandas-da-cel-pettra
    Mostra a pagina de editar informações da unidade do id. Dependendo do perfil as informações mudam  */ 
    public function showFormEditaUnidade($id)
    {
        
        if(auth()->user()->can('Relatorios_rh')){
            $this->authorize('Relatorios_rh');
        }elseif(auth()->user()->can('Administrador')){
            $this->authorize('Administrador');
        }
            
       try {   
             
            $unidade = null;
            $unidades=$this->unidadeService->getUnidade();
            //dd($unidades);
            foreach ($unidades as $obj) {
                if($obj->id == $id){
                    $unidade = $obj;
                }
            }
            //dd($unidade);
            if(empty($unidade)){
                throw new Exception("Unidade não localizada");
            }
            return view('admin::unidades.edit',compact('unidade','unidades'));
       } catch (Exception $e) {
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
    }
 
    
    /*@autor: Carolina Praxedes
    Branch: 474-demandas-da-cel-pettra
    Ação de salvar os dados alterados da unidade do id com o perfil de administrador  */
    public function saveEditaUnidade($id, Request $request)
    {       
       // dd($request->all());
        // dd(__LINE__);
       try {
            if(auth()->user()->can('Relatorios_rh')){
                
                
                $this->authorize('Relatorios_rh');  
                       
                $dadosForm = $request->all();              
            //Validando os dados                
                $validator = validator($dadosForm, [
                    
                    'st_comandante' => 'required|max:300',                    
                    'st_contato' => 'required|max:20',
                    'st_cidade' => 'required',    
              
                ]);
                //dd($dadosForm);
                if($validator->fails()){        
                
                    // Mensagem de erro com o formulário preenchido
                    return redirect()->back()->withErrors($validator)->withInput();
                }

               
                
                $retorno = $this->unidadeService->updateUnidadeAuxiliar($id,$dadosForm);
               
                return redirect('admin/unidades')->with('sucessoMsg',$retorno);
                
            }elseif(auth()->user()->can('Administrador')){
                
                $this->authorize('Administrador');
                $dadosForm = $request->all();
                $validator = validator($dadosForm, [
                    'st_sigla' => 'required',
                    'st_descricao' => 'required|max:100',
                    'st_cidade' => 'required|max:30',     
                    'bo_ativo' => 'required',
                    'bo_organograma' => 'required',
                    'st_tipo' => 'required',   

                    'st_comandante' => 'required|max:300',                    
                    'st_contato' => 'required|max:20',
                    'st_cidade' => 'required',
                                             
                ]);


            }          
            if($validator->fails()){        
                
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
           
            $retorno = $this->unidadeService->updateUnidade($id,$dadosForm);
                       
            return redirect('admin/unidades')->with('sucessoMsg',$retorno);
          //  return view('admin::unidades.edit',compact('unidade','unidades'));
       } catch (Exception $e) {
           //dd($e->getMessage());
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
    }

    

    public function updateUnidade($id, Request $request)
    {   
       
       try {
            
            $dadosForm =   $this->removerTokenDoRequest($request->all());           
            $retorno= $this->unidadeService->updateUnidade($id,$dadosForm);
            $unidades=$this->unidadeService->getUnidade();
            
            return view('admin::unidades.listagem',compact('unidades'))->with('erroMsg',$retorno);;
       } catch (\Exception $e) {
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
    }


    #Salva os dados do formulário no banco de dados unidades
    public function store(Request $request)
    {
        try {
            //validação dos campos

            $dadosForm =   $this->removerTokenDoRequest($request->all());
            $retorno = $this->unidadeService->createunidade($dadosForm);
            return view('admin::unidades.listagem',compact('unidades'))->with('erroMsg',$retorno);
       } catch (Exception $e) {
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
     
    }
    

    /**
     * @author Jazon #296
     * Busca por nome ou sigla da unidade
     * */
    public function search(Request $request)
    {
        try {
            $dadosForm =   $this->removerTokenDoRequest($request->all());
            $unidades=$this->unidadeService->searchUnidade($dadosForm);
            return view('admin::unidades.listagem',compact('unidades','dadosForm'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg',$e->getMessage());
        }     
  
    }

    /**Por CB Araújo
     * 411-criar-organograma
     * 22-12-2021
     */
    public function showOrganograma()
    {
       try {
            $tipo = 'a';
            $unidades=$this->unidadeService->showOrganograma($tipo);
            return view('admin::unidades.organograma',compact('unidades'));
       } catch (Exception $e) {
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
    }

    public function showNovoOrganograma()
    {
       $this->authorize('MANUTENCAO_SISTEMA');
       try {
            $tipo = 'n';
            $unidades=$this->unidadeService->showOrganograma($tipo);
            return view('admin::unidades.organograma',compact('unidades'));
       } catch (Exception $e) {
           return redirect()->back()->with('erroMsg',$e->getMessage());
       }     
    }


}
