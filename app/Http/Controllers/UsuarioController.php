<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Role;
use App\utis\MyLog;
use Auth;
use Exception;
use Modules\Api\Services\UsuarioService;

class UsuarioController extends Controller
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
    $this->authorize('Administrador');
         $usuarios = DB::table('users')
         ->where('users.bo_ativo',  '1')
         ->leftJoin('roles', 'users.perfil', '=', 'roles.id')
         ->select('users.*', 'roles.st_nome as nome_perfil')
         ->orderby('users.name')
         ->get();

        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' listou os usuários';
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        
        return view('usuario.Listausuario', compact('usuarios')); 
    }
    //Chama o formulário de cadastro de usuarios
    public function form_usuario()
    {
        $this->authorize('Administrador');
        //pegando todos os perfis de usuário para popular o campo perfil
        $perfis = Role::get();

        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou página de cadastro de usuário';
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        return view('usuario.Form_cad_usuario', compact('perfis')); 
    }
    //Chama o formulário de cadastro de usuarios
    public function fom_edita($id = null)
    {
        $this->authorize('Administrador');
        $usuario = DB::table('users')
        ->where('users.id',  $id)
        ->leftJoin('roles', 'users.perfil', '=', 'roles.id')
        ->select('users.*', 'roles.st_nome as nome_perfil')
        ->orderby('users.name')
        ->first();
        dd($usuario);

        //pegando todos os perfis de usuário para popular o campo perfil
        $perfis = Role::get();
   
        $acao = "Consulta";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou página de edição de usuário de id = ' . $id;
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        return view('usuario.Form_edita_usuario', compact('usuario', 'perfis'));
    }
    //realizar o cadastro dos usuário
    public function cad_usuario(Request $request)
    {
        $this->authorize('Administrador');
        DB:: beginTransaction();
        //recebendo os dados do formulário
        $dadosForm = $request->all();
        //validando os dados
        $validator = validator($dadosForm, [
            'name' => 'required|max:255',
            'matricula' => 'required',
            'st_cpf' => 'required|min:14|max:14|unique:users',
            'email' => 'required|email|max:255|unique:users',
    
        ]);
      
        if($validator->fails()){
           
            return redirect()->back()
            //          Mensagem de Erro
                    ->withErrors($validator)
           //          Preenchendo o Formulário
                    ->withInput();
        }
        //Inserindo um usuário
       $insert = User::create($dadosForm) ;
       /* $insert = User::create([
            'name' => $dadosForm['name'],
            'matricula' => $dadosForm['matricula'],
            'st_cpf' => $dadosForm['st_cpf'],
            'email' => $dadosForm['email'],
            'st_conselho' => $dadosForm['st_conselho'],
            'perfil' => $dadosForm['perfil'],
            'st_orgao' => $dadosForm['st_orgao'],
            'st_funcao' => $dadosForm['st_funcao'],
            'bo_ativo' => 1,
            'ce_sistema' => 1,
            'password' => bcrypt($dadosForm['password']),
        ]); */
        
        //inserindo as permissões de acesso do usuário
        $role_user = DB::table('role_user')->insert([
            'Role_id'=>$insert->perfil,
            'user_id'=>$insert->id]);

        
        if($insert && $role_user){
            DB::commit();

            $acao = "Cadastro";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' criou o usuário de id = ' . $insert->id;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            return redirect('/usuarios');
//            //Redirecionando para mostrar o resumo do documento cadastrado
             //return view('comele.Resumo_documento', compact('documento','examesCadastrados'));
            //return "1";
        }else{
            DB::rollback();
            //   return 'Falha ao Cadastrar os Dados!';
            $acao = "Cadastro";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' tentou criar um usuário e não conseguiu.';
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar o usuário');
        }
             
    }
    public function update(Request $request, $id)
    {
        $this->authorize('Administrador');
        DB:: beginTransaction();
        //recebendo os dados do formulário
        $dadosForm = $request->all();
        //validando os dados
        $validator = validator($dadosForm, [
            'name' => 'required|max:255',
            'matricula' => 'required',
            'st_cpf' => "required|min:14|max:14|unique:users,st_cpf,$id",
            'email' => "required|email|max:255|unique:users,email,$id",
            
        ]);
    
            
        
      
        if($validator->fails()){
           
            return redirect()->back()
            //          Mensagem de Erro
                    ->withErrors($validator)
           //          Preenchendo o Formulário
                    ->withInput();
        }
        $usuario = User::find($id);
        
        //Inserindo um usuário
       $alerauaurario = $usuario->update($dadosForm) ;
       /* $insert = User::create([
            'name' => $dadosForm['name'],
            'matricula' => $dadosForm['matricula'],
            'st_cpf' => $dadosForm['st_cpf'],
            'email' => $dadosForm['email'],
            'st_conselho' => $dadosForm['st_conselho'],
            'perfil' => $dadosForm['perfil'],
            'st_orgao' => $dadosForm['st_orgao'],
            'st_funcao' => $dadosForm['st_funcao'],
            'bo_ativo' => 1,
            'ce_sistema' => 1,
            'password' => bcrypt($dadosForm['password']),
        ]); */
        
      //recupera o usuário editado
      $usuario = User::find($id);
      //inserindo as permissões de acesso do usuário
      $role_user = DB::table('role_user')->where('user_id', $usuario->id)
                    ->update([
                        'Role_id'=>$usuario->perfil,
                        'user_id'=>$usuario->id]);

        
        if($alerauaurario){
            DB::commit();

            $acao = "Edição";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou o usuário de id = ' . $id;
            //chamando a classe para registra a alteração na tabela logs
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

            return redirect('/usuarios');
//            //Redirecionando para mostrar o resumo do documento cadastrado
             //return view('comele.Resumo_documento', compact('documento','examesCadastrados'));
            //return "1";
        }else{
            DB::rollback();
            //   return 'Falha ao Cadastrar os Dados!';
            $acao = "Edição";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' tentou editar o usuário de id = ' . $id;
            //chamando a classe para registra a alteração na tabela logs
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            return redirect()->back()->with('erroMsg', 'Falha ao Alterar o usuário');  
        }
             
    }

    public function desativa($id){
        $this->authorize('Administrador');
        //pegando todos os perfis de usuário para popular o campo perfil
        $usuario = User::find($id);
        $peritodesignado = $usuario->update([
            "bo_ativo" => 0
            
        ]);

        $acao = "Remoção";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' removeu o usuário de id = ' . $id;
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        return redirect('/usuarios');
    }

    public function formularioalterasenha($id){
        //pegando todos os perfis de usuário para popular o campo perfil
        $usuario = User::find($id);
        if(empty($usuario)){
            return redirect()->back()->with('erroMsg', 'O usuário que você está tentando alterar a senha não existe em nossa base de dados.'); 
        }
        if(Auth::user()->id ==  $usuario->id){
            //Se o usuário estiver querendo alterar a sua própria senha, exibe o formulário normalmente
            return view('usuario.alterarsenha', compact('id'));
          
           
        }else{
            //Se o usuário estiver querendo alterar a  senha de outro usuário, este tem que ter a permissão de administrador
            $this->authorize('Administrador');
            return view('usuario.alterarsenha', compact('id'));
        }

    }
    public function alterasenha(Request $request, $id)
    {
        $dadosform = $request->all();
       
         //pegando todos os perfis de usuário para popular o campo perfil
         $usuario = User::find($id);
         if(empty($usuario)){
             return redirect()->back()->with('erroMsg', 'O usuário que você está tentando alterar a senha não existe em nossa base de dados.'); 
         }
         if($dadosform['password'] != $dadosform['password_confirmation'] ){
            return redirect()->back()->with('erroMsg', 'As senhas informadas não coincidem.'); 
         }

         $validator = validator($dadosform, [
            'password' => 'required|min:6',
        ]);

      
        if($validator->fails())
        {
            // Mensagem de erro com o formulário preenchido
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $senha = bcrypt($dadosform['password']);

         if(Auth::user()->id ==  $usuario->id){
             //Se o usuário estiver querendo alterar a sua própria senha, exibe o formulário normalmente
             $usuario->update([
                 'password' => $senha

             ]);
               
             $acao = "Update";      
             $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Redefiniu sua senha.';
             //chamando a classe para registra a alteração na tabela logs
             MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
                
             return redirect()->back()->with('sucessoMsg', 'Senha Alterada com sucesso.'); 
             
              
         
             return view('usuario.alterarsenha', compact('id'));
           
            
         }else{
             //Se o usuário estiver querendo alterar a  senha de outro usuário, este tem que ter a permissão de administrador
             $this->authorize('Administrador');
             $usuario->update([
                'password' => $senha

            ]);
              
            $acao = "Update";      
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Redefiniu sua senha do usuário de id:.'. $id;
            //chamando a classe para registra a alteração na tabela logs
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
    
            return redirect()->back()->with('sucessoMsg', 'Senha Alterada com sucesso.'); 
         }
     
        //pegando todos os perfis de usuário para popular o campo perfil
        $usuario = User::find($id);
        
        $peritodesignado = $usuario->update([
            "bo_ativo" => 0
            
        ]);

        $acao = "Remoção";      
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' removeu o usuário.';
        //chamando a classe para registra a alteração na tabela logs
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

        return redirect('/usuarios');
    }

    /**
     * @author @juan_mojica - #437
     * @param Request (vinculo_selecionado)
     * @return Json (sucesso ou erro)
     */
    public function alterarVinculo(Request $request){
        try {
            //prepara os dados para o serviço
            $dadosForm['ce_vinculo'] = $request->vinculo;
            $idUserLogado = auth()->user()->id;
            $usuariosService = new UsuarioService();
            $response = $usuariosService->alterarVinculo($idUserLogado, $dadosForm);
            return json_encode($response);

        } catch (Exception $e) {
            $response['msg'] = $e->getMessage();
            return json_encode($response);
        }
    }

   
  
    
}
