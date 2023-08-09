<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use DB;
use App\utis\Msg;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Role;
use Modules\Admin\Entities\Permission;
use Modules\Api\Services\PermissionService;
use Auth;
use App\utis\MyLog;


class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PermissionService $PermissionService)
    {
        $this->middleware('auth');
        $this->PermissionService = $PermissionService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //Lista todos os usuarios ativos do sistema
    public function index()
    {
        try{

            $permissions = $this->PermissionService->listaTodasPermissoes();
            
            return view('admin::permission.Listapermission', compact('permissions')); 

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    //Chama o formulário de cadastro de usuarios
    public function create()
    {
        try{
         
         return view('admin::permission.Form_cad_permission'); 

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //Chama o formulário de cadastro de usuarios
    public function edit($id)
    {
        try{
            
            $permission = $this->PermissionService->consultaPermissaoPorId($id);

            return view('admin::permission.Form_edita_permission', compact('permission'));

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //realizar o cadastro dos usuário
    public function store(Request $request)
    {
       try{
        //recebendo os dados do formulário
        $dadosForm = $request->all();
      
        //validando os dados
        $validator = validator($dadosForm, [
            'st_nome' => 'required|max:50',
            'st_label' => 'required|max:50',
            'st_modulo' => 'required|max:50'
          
    
        ]);

        if($validator->fails()){
                
            return redirect()->back()
            //          Mensagem de Erro
                    ->withErrors($validator)
           //          Preenchendo o Formulário
                    ->withInput();
        }
        //Inserindo um usuário
        $cadastra = $this->PermissionService->cadastraPermissao($dadosForm);  
            
        return redirect('admin/permissions')->with('sucessoMsg', MSG::PERMISSAO_CADASTRADA);
    
    }catch(Exception $e){
        return redirect()->back()->with('erroMsg', MSG::ERRO_CADASTRAR_PERMISSAO);
    }
}
       
             
 

    public function update(Request $request, $id)
    {
      
        try{
            
            $dadosForm = $request->all();
            //validando os dados
            $validator = validator($dadosForm, [
                'st_nome' => 'required|max:50',
                'st_label' => 'required|max:50',
                'st_modulo' => 'required|max:50'
              
        
            ]);
        
            if($validator->fails()){
            
                return redirect()->back()
                //          Mensagem de Erro
                        ->withErrors($validator)
            //          Preenchendo o Formulário
                        ->withInput();
            }
            
            $update = $this->PermissionService->editaPermissao($id, $dadosForm);
              
            return redirect('admin/permissions')->with('sucessoMsg', MSG::ATUALIZADO_SUCESSO);

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
             
    }
    
    
}
