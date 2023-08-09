<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use Exception;
use App\Permission;
use App\Ldap\LdapProvider;
use Illuminate\Support\Facades\Auth;
//use Modules\Admin\Entities\Unidade;
use App\Unidade;
use App\utis\ApiRestGeneric;
use App\utis\Msg;
use Session;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        try{
        $this->registerPolicies();
        //provider para conexao via AD
        Auth::provider('ldap', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...

            return new LdapProvider($app['hash'], $config['model']);
        });
        // Recupera todas as permissões de usuário no sistema
       
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("usuarios/permissoes");
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::PERMISSOES_DE_USUARIO_NAO_ENCONTRADAS){
                    throw new Exception(Msg::PERMISSOES_DE_USUARIO_NAO_ENCONTRADAS);
                }else{
                    throw new Exception($objeto->msg);
                }
            }
            $permissoions = $objeto;
       
        /* Retornando todas a permissões do banco de dados, jantamente com todas a funções das permissões
         * através do método roles() na Model Permission.
         * ex: cadastra => atendente, adm
         * Libera_DO => Medico Legista
         * Reconhece => atendente, adm, papiloscopista
         * Identifica => adm, papiloscopista
         * Entrega_Corpo => atendente
         **/
        foreach ($permissoions as $permission)
        {
            gate::define($permission->st_nome,  function(User $user)use($permission){
                return in_array($permission->st_nome, $user->permissoes);
            });
                    /***
                     *  verificando se o usuaário logado está vinculado a unidade do objeto que está sendo criado/alterado/deletado.
                     *  Caso o usuário logado não esteja vinculado à unidade passada como parâmetro, será abortada operação, retornoando um erro 403
                     * 
                     */
            // gate::define('updatenaunidade',  function(User $user, Unidade $unidade){
            //     dd('aaa');
             
            //     $existe = true;
              
            //     if(count($user->unidadesvinculadas)>0 ){
                  
              
            //         foreach($user->unidadesvinculadas as $s){
            //             if($unidade->id == $s->id){
            //                 $existe = true;
            //             }
            //         }
            //     }
            //      if(isset($existe) && ($existe == true)){
            //          return true;
            //      }
                
                 
            //  });
        }
         //definindo usuario administrador - tem poder de realizar qualquer ação no sistema
         gate::before(function (User $user, $ability){
            if (isset($user->perfil)) {
                if( $user->perfil == '1' ){
                    return true;
                }
            } else {
                return false;
            }
            
         });
        }catch(Exception $e){
            Auth::logout();
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
}
