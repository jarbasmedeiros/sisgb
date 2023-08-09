<?php

namespace App\Ldap;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use App\Ldap\Authldap;
use Illuminate\Support\Str;
use App\User;
use Exception;
use App\utis\ApiRestGeneric;
use App\utis\Funcoes;
use App\utis\Msg;
use Auth;
use Session;

class LdapProvider extends EloquentUserProvider
{
   
    public function validateCredentials(UserContract $user, array $credentials)
    {
        //$plain = $credentials['password'];
        //return $this->hasher->check($plain, $user->getAuthPassword());
       
       $authldap =  new Authldap();
       return $authldap->autentica($credentials);
       
    }
    /**
      * Os métodos do EloquentUserProvider, que fazem uso de consultas no banco referentes ao login e logout do usuário
      * foram refatorados para consumir API. 
      */
    public function retrieveById($identifier){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("usuarios/".$identifier);
            //Verificação se houve erro na requisição
            $usuario = json_decode($request, true);
            if(isset($usuario->retorno)){
                if($usuario->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    throw new Exception(Msg::QA_NAO_ENCONTRADO);
                }else{
                    throw new Exception($usuario->msg);
                }
            }elseif(strpos($request, "exception") > 0){
                throw new Exception(json_decode($request)->message);

            }
            $user = new User($usuario);
            return $user;
        }catch(Exception $e){
            // throw new Exception($e->getMessage());
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function retrieveByCredentials(array $credentials){

        if (empty($credentials) ||
           (count($credentials) === 1 &&
            array_key_exists('password', $credentials))) {
            return;
        }
        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        try{
            if (!isset($credentials['g-recaptcha-response'])) {
                throw new Exception('Marque o reCAPTCHA para comprovar que não é um robô!');
            }
    
            //função que ajuda a proteger a aplicação contra ataque do tipo sql injection
            $credentials = Funcoes::addSlashesRecursivo($credentials);

            $api = new ApiRestGeneric();
            $dadosForm["st_cpf"] = $credentials["st_cpf"];
            // dd($dadosForm);
            // Requisição para API
            $request = $api->post("usuarios/cpf", $dadosForm);
           // $usuario = $api->converteStringJson($request);
            $usuario = json_decode($request, true);
            //Verificação se houve erro na requisição
            if(isset($usuario['retorno'])){
                if($usuario['msg'] == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    throw new Exception("Usuario não encontrado");
                }else{
                    throw new Exception($usuario['msg']);
                }
            }elseif(strpos($request, "exception") > 0){
                throw new Exception(json_decode($request)->message);

            }
            $user = new User($usuario);
            
            /**
             * Autoriza somente aos que têm essa permissão quando o sistema estiver em manutenção
             * Quando o sistema entrar em manutenção o ADMINISTRADOR deve alterar a variavel 
             * MANUTENCAO_SISTEMA do env para MANUTENCAO
             */
            $estado = env('MANUTENCAO_SISTEMA');            
                
            if(empty($estado)){
                throw new Exception("A variável MANUTENCAO_SISTEMA não existe no arquivo ENV!");
            }
            if($estado != 'PRODUCAO' && !in_array("MANUTENCAO_SISTEMA",$user->permissoes)){
                return redirect('login')->send()->with('erroMsg', "Sistema em manutenção!");
            } 

            Session::put('erroMsg', null);
            return $user;
        }catch(Exception $e){
            return redirect('login')->send()->with('erroMsg', $e->getMessage());
        }
    }

    public function updateRememberToken(UserContract $user, $token){
        try{
            $dados = [];
            $dados["token"] = $token;
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->put("usuarios/". $user->id, $dados);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->retorno == "erro"){
                    throw new Exception($objeto->msg);
                }
            }else{
                throw new Exception(json_decode($request)->message);
            }
            Session::put('erroMsg', null);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

}
