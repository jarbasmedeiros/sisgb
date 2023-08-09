<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Role;
use App\Permission;
use PDO;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //Lista todos os usuarios ativos do sistema
    public function index()
    {
        $this->authorize('Admin');
         $roles = DB::table('roles')
         ->orderby('st_nome')
         ->get();

        
        
        return view('role.Listarole', compact('roles')); 
    }

    //Chama o formulário de cadastro de usuarios
    public function form_role()
    {
        $this->authorize('Admin');
        return view('role.Form_cad_role'); 
    }

    //Chama o formulário de cadastro de usuarios
    public function fom_edita($id)
    {
        $this->authorize('Admin');
        $role = Role::find($id);
        $permissoes = Permission::get();
        $permissoescadastradas  = DB::table('permission_role')->where('role_id', '=',$id)->get();
        return view('role.Form_edita_role', compact('role', 'permissoes', 'permissoescadastradas'));
    }

    //realizar o cadastro dos usuário
    public function cad_role(Request $request)
    {
        $this->authorize('Admin');
       
        DB:: beginTransaction();
        //recebendo os dados do formulário
        $dadosForm = $request->all();
      
        //validando os dados
        $validator = validator($dadosForm, [
            'st_nome' => 'required',
            'st_sigla' => 'required',
            'st_label' => 'required',
          
    
        ]);
    
        
          
        if($validator->fails()){
                
            return redirect()->back()
            //          Mensagem de Erro
                    ->withErrors($validator)
           //          Preenchendo o Formulário
                    ->withInput();
        }
        //Inserindo um usuário
       // $insert = User::create($dadosForm);
       $insert = Role::create($dadosForm) ;
       
       
        
        if($insert){
         DB::commit();
         return redirect('/roles');
        }else{
            DB::rollback();
         //   return 'Falha ao Cadastrar os Dados!';
         
         return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar o perfil');  
        }
             
    }

    public function update(Request $request, $id)
    {
        $this->authorize('Admin');
        DB:: beginTransaction();
        //recebendo os dados do formulário
        $dadosForm = $request->all();
       
        //validando os dados
        $validator = validator($dadosForm, [
            'st_nome' => 'required|max:255',
            'st_label' => 'required',
        ]);
      
        if($validator->fails()){
            return redirect()->back()
            //          Mensagem de Erro
                    ->withErrors($validator)
           //          Preenchendo o Formulário
                    ->withInput();
        }
        $role= Role::find($id);
        $permissoes = $dadosForm['permissao'];
       
        
        $permissoescadastradas  = DB::table('permission_role')->where('role_id', '=',$id)
                                    ->select('permission_role.permission_id')
                                    ->get();

/* 
        $deletepermissions = $permissoescadastradas ->destroy();   

        $permissoescad = $permissoescadastradas->toArray();
      
        foreach($permissoes as $key => $val){
            if (in_array($val, $permissoescad)) { 
                echo "existe o valor".$val. '<br/>';
            }else{
                echo "Não existe existe o valor".$val. '<br/>';

            }

        }
        exit;
        dd($permissoescadastradas ); */
 
       $alterarole = $role->update($dadosForm) ;
        //         recuperando as novas permissões para edição
        $permissoes = $request->input('permissao');
        
        //     //editando as permissões do perfil   
             if($permissoes != null){
             $permissoes = $role->permissions()->sync($permissoes);
             }else {
                return redirect()->back()->with('erroMsg', 'Você deve Selecionar pelo menos uma permissão ');
             }  
    
        
        if($alterarole){
         DB::commit();
         return redirect('/roles');
        }else{
            DB::rollback();
         
         return redirect()->back()->with('erroMsg', 'Falha ao Alterar o Perfil');  
        }
             
    }

    public function show($id)
    {
       
        $this->authorize('Admin');
        $role = Role::find($id);
        $permissoes = $role->permissions;
        $permissions = "";
        if(!empty($permissoes)){
            foreach($permissoes as $p){
                if($permissions == ""){
                    $permissions = $p->st_nome;
                }else{

                    $permissions = $permissions.','.$p->st_nome;     
                }
            }
        }
         return view('role.Role_detalhe', compact('role', 'permissions'));  
        
             
    }
    
    
}
