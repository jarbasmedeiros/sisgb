<?php
namespace Modules\Api\Services;

use App\utis\ApiRestGeneric;
use App\utis\LengthAwarePaginatorConverter;
use App\utis\Msg;
use Auth;
use Exception;




/**

 *
 * @author Carolina Praxedes
 * branch: 478-corrigir-bugs
 */
class PerfilService  {


    /**
     * Author: Ataíde
     *  adiciona uma permissão especifica a um perfil específico
     *  passando apenas o id da permissão e do perfil.
     */
    public function getPerfis(){
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("usuarios/perfis");
            
            $response = $api->converteStringJson($request);
            //dd($response);    
            //Verificação se houve erro na requisição
            

            if(isset($response->retorno)){
                if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($response->msg);
                }
            }
            
            return $response;
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

}




?>