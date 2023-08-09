<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\utis\Funcoes;
use Illuminate\Http\Request;
use DB;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Role;
use Illuminate\Support\Facades\Validator;
use App\utis\MyLog;
use Auth;
use App\utis\Msg;
use Exception;
use Illuminate\Auth\Middleware\Authorize;
//use App\Unidade;
use Modules\Api\Services\UsuarioService;
use Modules\Api\Services\UnidadeService;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\RoleService;
use Modules\Api\Services\FuncaoService;
use Modules\Api\Services\PerfilService;

class UsuarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsuarioService $UsuarioService, UnidadeService $UnidadeService, RoleService $roleService, PolicialService $PolicialService )
    {
        $this->middleware('auth');
        $this->UsuarioService = $UsuarioService;
        $this->UnidadeService = $UnidadeService;
        $this->PolicialService = $PolicialService;
        $this->RoleService = $roleService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //Lista todos os usuarios ativos do sistema
    public function index(){
    try{
        // $cpf=Funcoes::limpaCPF_CNPJ(Auth::User()->st_cpf);
        $cpf=62006797468;
        
        $policial = $this->PolicialService->buscaPolicialCpf($cpf);
              
        $usuarios = $this->UsuarioService->listaTodosUsuarios();
        
        return view('admin::usuario.Listausuario', compact('usuarios')); 

        }catch(Exception $e){
            if($e->getmessage()== 'Nenhum resultado encontrado.'){
                return redirect()->back()->with('erroMsg', 'Usuário não é um policial cadastrado');
            }
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }
    
    //Chama o formulário de edição de usuarios
    public function edit($idUsuario)
    {
        try{
            
            $usuario = $this->UsuarioService->consultaUsuarioPorId($idUsuario);
            $perfis = $this->RoleService->listaPerfisDeUsuario();
            $unidades = $this->UnidadeService->getUnidade($idUsuario);


            
            return view('admin::usuario.Form_edita_usuario', compact('usuario', 'perfis','unidades'));

        }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        
    }
    
   
    //realizar o cadastro dos usuário
    public function create()
    {
            try
            {   
            
                $unidades = $this->UnidadeService->getUnidade();
                // dd($unidades);
                $perfilService = new PerfilService();
                
                $perfis = $perfilService->getPerfis();
                //dd($perfis);
                return view('admin::usuario.Form_cad_usuario', compact('unidades','perfis'));

            }catch(Exception $e){
                dd($e->getMessage());
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
    }

    public function store(Request $request){
        try{

            $this->authorize('Administrador');
            
            $dadosForm = $request->all();
            
           
            
            //valida os dados enviados na requisição
            $validator = validator($dadosForm, 
                [
                    'name' => "required",
                    'matricula' => "required",
                    'st_cpf' => "required",
                    'email' => "required",
                    'perfil' => 'required',
                    'ce_unidade' => "required",
                    
                ],
                [
                    //costumiza a msg a ser exibida no tipo de validação
                    'required' => 'Campo obrigatório!'
                ]
            );  
            if ($validator->fails()) {
                //retornando os dados do formulário deixando preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $cadastra = $this->UsuarioService->cadastrausuario($dadosForm);  
            
            return redirect('admin/usuarios')->with('sucessoMsg', MSG::USUARIO_CADASTRADO);
        
        }catch(Exception $e){
            
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try{
            
            
            $dados = $request->all();
            $usuario = $this->UsuarioService->consultaUsuarioPorId($id);
            $update = $this->UsuarioService->editaUsuario($id, $dados);
            $unidades = $this->UnidadeService->getUnidade($id);
            
            
              
            return redirect('admin/usuarios')->with('sucessoMsg', MSG::ATUALIZADO_SUCESSO);

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
     
    }
    

    public function destroy($id){
        try{
            
            $usuario = $this->UsuarioService->consultaUsuarioPorId($id);
            
            $destroy = $this->UsuarioService->deletaUsuario($usuario->id);
            
            return redirect()->back()->with('sucessoMsg', MSG::USUARIO_REMOVIDO);
            
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
    }


     //Chama o formulário de vincular o usuário ao perfil
     public function FormvinculaUsuarioPerfil($idUsuario)
     {
         try{
             
             $usuario = $this->UsuarioService->consultaUsuarioPorId($idUsuario);
             $perfis = $this->RoleService->listaPerfisDeUsuario();
            
             return view('admin::usuario.Form_vincular_usuario_perfil', compact('usuario', 'perfis'));
 
         }catch(Exception $e){
                 return redirect()->back()->with('erroMsg', $e->getMessage());
             }
         
     }


     //método para alterar perfis do usuário
    public function vinculausuarioPerfil(Request $request, $id){
        try{
                $this->authorize('Administrador');
            $dadosform = $request->all();
            if(!isset($dadosform['perfisVinculados'])){
                return redirect()->back()->with('erroMsg', 'input perfisVinculados é requerido.');    
            }elseif(count($dadosform['perfisVinculados'])< 1){
                return redirect()->back()->with('erroMsg', 'É obrigatório o preenchimento de pelo menos um perfil.');    

            }
            
                //Resgatando o usuário
                $usuario = $this->UsuarioService->consultaUsuarioPorId($id);
            
                $this->UsuarioService->vinculausuarioPerfil($id, $dadosform['perfisVinculados'] );
                return redirect('admin/usuario/vinculos/'.$id. '/perfil')->with('sucessoMsg', 'Dados Alterados com sucesso.');

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }


    
    public function form_vinculausuariounidade($id){
        try{
            $this->authorize('Administrador');
            //resgatando o usuário
            $usuario = $this->UsuarioService->consultaUsuarioPorId($id);
            if(empty($usuario)){
                return redirect()->back()->with('erroMsg', 'Usuário Não encontrado.'); 
            }
        // $todasunidades = collect($this->Seviceunidade->index());
            $unidades = $this->UnidadeService->getUnidade();
        
            //resgatando as unidades vinculadas do usuario
            $unidadesvinculadas = $usuario->unidadesvinculadas;
            

            return view('admin::usuario.Form_vinculosusuario', compact('usuario', 'unidades', 'unidadesvinculadas'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    //método para alterar unidades vinculadas do usuário
    public function vinculausuariounidade(Request $request, $id){
        try{
            $this->authorize('Administrador');
            $dadosform = $request->all();
            if(!isset($dadosform['unidadesvinculadas'])){
                return redirect()->back()->with('erroMsg', 'input unidadesvinculadas é requerido.');    
            }elseif(count($dadosform['unidadesvinculadas'])< 1){
                return redirect()->back()->with('erroMsg', 'É obrigatório o preenchimento de pelo menos uma unidade.');    

            }
            
                //Resgatando o usuário
                $usuario = $this->UsuarioService->consultaUsuarioPorId($id);
            
                $this->UsuarioService->alteraunidadesvinculadas($id, $dadosform['unidadesvinculadas'] );
                return redirect('admin/usuario/vinculos/'.$id)->with('sucessoMsg', 'Dados Alterados com sucesso.');

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    // usuário: Carolina Praxedes #471 
    // Pegando o parametro de nome ou CPF do usuario que deseja localizar
    public function recuperarUsuarioPorNomeCPF(Request $request){
        try{
            
            $this->authorize('Administrador');
            $dadosform = $request->all();
            
            if(!isset($dadosform['st_parametro'])){
                return redirect()->back()->with('erroMsg', 'Informe o CPF ou nome do usuário que deseja consultar');    
            }
                
                //Resgatando o usuário
              
                $usuarios = $this->UsuarioService->recuperarUsuarioPorNomeCPF($dadosform);
                
                return view('admin::usuario.Listausuario', compact('usuarios')); 
                
            }catch(Exception $e){
                
            return redirect('admin/usuarios')->with('erroMsg', $e->getMessage());
        }
    }

    // usuário: Carolina Praxedes #471 
    // Get para buscar um usuário com parametro de nome ou CPF informado
    //public function buscarUsuarioPorNomeCPF($nomeCPF){
    public function buscarUsuarioPorNomeCPF(Request $request){
        try{
           
            $this->authorize('Administrador');
            $dadosForm = $request->all();
            
            //valida os dados enviados na requisição
            $validator = validator($dadosForm, 
                [
                    'st_parametro' => "required",
                ]
            );  
            if ($validator->fails()) {
                //retornando os dados do formulário deixando preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //Resgatando o usuário
            $usuarios = $this->UsuarioService->recuperarUsuarioPorNomeCPF($dadosForm);

            
            return view('admin::usuario.Listausuario', compact('usuarios')); 
                
        }catch(Exception $e){
            return redirect('admin/usuarios')->with('erroMsg', $e->getMessage());
        } 
    }

     /**
     * @author @juan_mojica - #437
     * @param Int (id do usuário)
     * @return (tela do formulário de edição e listagem dos vínculos do usuário)
     */
    public function formEditaVinculos($idUsuario){
        try {
            $this->authorize('Administrador');
            
            $funcaoService = new FuncaoService();
            $funcoes = $funcaoService->getFuncoes();
            
            $perfis = $this->RoleService->listaPerfisDeUsuario();
            
            $unidades = $this->UnidadeService->getUnidade();
           
            $usuario = $this->UsuarioService->consultaUsuarioPorId($idUsuario);
            
            if (isset($usuario->matricula)) {
                //adiciona máscara à matrícula
                $func = new Funcoes();
                $usuario->matricula = $func->mask($usuario->matricula, '###.###-#');
            }
            
            $vinculosUsuario = $this->UsuarioService->getVinculosUsuario($idUsuario);
            
            return view('admin::vinculos.Form_edita_vinculos', compact('funcoes', 'perfis', 'unidades', 'usuario', 'vinculosUsuario'));

        } catch (Exception $e) {
           return redirect('admin/usuarios')->with('erroMsg', $e->getMessage());
        }
    }

     /**
     * @author @juan_mojica - #437
     * @param Int, Request (id do usuário)
     * @return Response (sucesso ou erro)
     */
    public function adicionaVinculo($idUsuario, Request $request){
        try {
            $this->authorize('Administrador');

            $dadosForm = $request->all();
            //valida os dados enviados na requisição
            $validator = validator($dadosForm, 
                [
                'ce_unidade' => "required",
                'ce_perfil' => "required",
                'ce_funcao' => "required",
                ],
                [
                    //costumiza a msg a ser exibida no tipo de validação
                    'required' => 'Campo obrigatório!'
                ]
            );  
            if ($validator->fails()) {
                //retornando os dados do formulário deixando preenchido
                return redirect()->back()->withErrors($validator);
            }
            //invoca o serviço para adicionar o vínculo ao usuário
            $msg = $this->UsuarioService->adicionaVinculo($idUsuario, $dadosForm);
            
            return redirect()->back()->with('sucessoMsg', $msg);

        } catch (Exception $e) {
           return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     /**
     * @author @juan_mojica - #437
     * @param Int (id do usuário e id do vínculo)
     * @return Response (sucesso ou erro)
     */
    public function deletaVinculo($idUsuario, $idVinculo){
        try {
            $this->authorize('Administrador');
            
            //invoca o serviço para adicionar o vínculo ao usuário
            $msg = $this->UsuarioService->deletaVinculo($idUsuario, $idVinculo);
            
            return redirect()->back()->with('sucessoMsg', $msg);

        } catch (Exception $e) {
           return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }




    
}
