<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Role;
use App\Permission;
use Auth;
use App\utis\MyLog;


class PermissionController extends Controller
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
         $permissions = DB::table('permissions')
         ->orderby('st_nome')
         ->get();
    
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' listou as permissões';
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        return view('permission.Listapermission', compact('permissions')); 
    }

    //Chama o formulário de cadastro de usuarios
    public function form_permission()
    {
        $this->authorize('Admin');
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou a página de cadastro de permissões';
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        return view('permission.Form_cad_permission'); 
    }

    //Chama o formulário de cadastro de usuarios
    public function fom_edita($id)
    {
        $this->authorize('Admin');
        $permission = Permission::find($id);
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou a página de cadastro da permissão de id = ' .$id;
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        return view('permission.Form_edita_permission', compact('permission'));
    }

    //realizar o cadastro dos usuário
    public function cad_permission(Request $request)
    {
       
        $this->authorize('Admin');
       
        DB:: beginTransaction();
        //recebendo os dados do formulário
        $dadosForm = $request->all();
      
        //validando os dados
        $validator = validator($dadosForm, [
            'st_nome' => 'required',
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
       $insert = Permission::create($dadosForm) ;
       
       
        
        if($insert){
            DB::commit();
            $acao = "Cadastro";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou a permissão de id = ' . $insert->id;
            //chamando a classe para registra a alteração na tabela logs
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            return redirect('/permissions');
        }else{
            DB::rollback();
         //   return 'Falha ao Cadastrar os Dados!';
         
         return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar a Permissão');  
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
        $permission= Permission::find($id);
        
        //Inserindo um usuário
       // $insert = User::create($dadosForm);
       $alterapermission = $permission->update($dadosForm) ;
    
        
      
        
        if($alterapermission){
            DB::commit();
            $acao = "Edição";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou a permissão de id = ' . $id;
            //chamando a classe para registra a alteração na tabela logs
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            return redirect('/permissions');
        }else{
            DB::rollback();
            //   return 'Falha ao Cadastrar os Dados!';
         
         return redirect()->back()->with('erroMsg', 'Falha ao Alterar o usuário');  
        }
             
    }
    
    
}
