<?php
    namespace Modules\Api\Services;

    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;
    use App\Utis\Funcoes;
    use Exception;
 
    
                

/**
 * @autor Jazon - #267
 * Classe responsável pelas validações de documentos emitidos pelo sistema
 */
    class ValidacaoService   {
     
        
        public function validarRg($localizador) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("rg/".$localizador."/validacao");
                
                $response = $api->converteStringJson($request);
                //dd($response);
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }



      
    }

?>