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
use Modules\Api\Services\RoleService;
use Modules\Api\Services\PermissionService;
use PDO;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleService $RoleService, PermissionService $PermissionService)
    {
        $this->middleware('auth');
        $this->RoleService = $RoleService;
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
        try
        {
            $roles = $this->RoleService->listaPerfisDeUsuario();
            return view('admin::role.Listarole', compact('roles')); 

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }
    //remove permissao ao perfil específico
    //passa o id do perfil e o id da permissão

    public function removepermission(Request $request)
    {
        try{
            
            $aux = explode('-', $request->todas);
           
            if(count($aux) > 1){
                $dados = [];
                foreach($aux as $k => $v){
                    if($v != $request->PermissaoRemover){
                        $dados[] = $v;
                    }
                }
            }else{
                $dados = $aux;
            }
            
            $idPerfil = $request->idPerfil;
            $role = $this->RoleService->consultaPerfisPorId($request->idPerfil);
            
            $addPermissao = $this->PermissionService->adicionaPermissaoAoPerfil($idPerfil, $dados);
            return $addPermissao;
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }
    
    //adiciona permissao ao perfil específico
    //passa o id do perfil e o id da permissão

    public function addpermission(Request $request)
    {
        try{
            
            $dados = explode(',', $request->idsPermissoes);
                 
            $idPerfil = $request->idPerfil;
            $role = $this->RoleService->consultaPerfisPorId($request->idPerfil);
            
            $addPermissao = $this->PermissionService->adicionaPermissaoAoPerfil($idPerfil, $dados);
            return $addPermissao;
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    //Chama o formulário de cadastro de usuarios
    public function create()
    {
        try{

            return view('admin::role.Form_cad_role'); 

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    public function store(Request $request)
    {
        try{

            $dados = $request->all();
            //validando os dados
            $validator = validator($dados, [
                'st_nome' => 'required|max:255',
                'st_label' => 'required|max:255'
            ]);
            
            if($validator->fails()){

                return redirect()->back()
                //          Mensagem de Erro
                        ->withErrors($validator)
            //          Preenchendo o Formulário
                        ->withInput();
            }
            
            $dadosForm = ['st_nome' => $request->st_nome, 'st_label' => $request->st_label];
            $cadastra = $this->RoleService->cadastraPerfisDeUsuario($dadosForm);
            
            //return view('admin::role.Listarole', compact('roles')); 
            return redirect('admin/perfis')->with('sucessoMsg', MSG::SALVO_SUCESSO);

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());

        }
        
    }

    //Chama o formulário de cadastro de usuarios
    public function edit($id)
    {
        try{
            $todasPermissoes = $this->PermissionService->listaTodasPermissoes();

            $role = $this->RoleService->consultaPerfisPorId($id);
                        
            foreach($todasPermissoes as $key => $p)
            {
                foreach($role->permissions as $k => $rp)
                {
                    if($p->id == $rp->id){
                        $todasPermissoes[$key]->existe = 1;
                    }
                }
            }
            
            return view('admin::role.Form_edita_role', compact('role','todasPermissoes'));

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $dados = $request->all();
            //validando os dados
            $validator = validator($dados, [
                'st_nome' => 'required|max:255',
                'st_label' => 'required|max:255'
            ]);
            
            if($validator->fails()){
            
                return redirect()->back()
                //          Mensagem de Erro
                        ->withErrors($validator)
            //          Preenchendo o Formulário
                        ->withInput();
            }
            
            $dadosForm = ['st_nome' => $request->st_nome, 'st_label' => $request->st_label];
            $atualiza = $this->RoleService->editaPerfisDeUsuario($dadosForm, $id);
            
            return redirect('admin/perfis')->with('sucessoMsg', MSG::SALVO_SUCESSO);
            

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

}
