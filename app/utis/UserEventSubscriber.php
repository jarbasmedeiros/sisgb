<?php
namespace App\utis;

/* use App\Util\MyLog;
use Exception; */
use Auth;

/**
 * Description of Log
 * Verifica os eventos relacionados aos acessos do usuário
 * para mais detalhes: https://blog.especializati.com.br/registrar-acessos-no-laravel/
 * @author Talysson
 */
class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event)
    {
        // Cadastra um novo log de login
        try{
			//'AQUI DEVE SALVAR O LOG DE ENTRADA NO LOGIN'
            
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
 
 
    /**
     * Handle user logout events.
     */
    public function onUserLogout($event)
    {
        // Cadastra um novo log de logout
        try{
			//'AQUI DEVE SALVAR O LOG DE SAIDA NO LOGIN'
            
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
 
 
    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\utis\UserEventSubscriber@onUserLogin'
        );
 
        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\utis\UserEventSubscriber@onUserLogout'
        );
    }
 
}
