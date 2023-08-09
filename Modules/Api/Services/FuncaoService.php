<?php

    namespace Modules\Api\Services;

    use Exception;
    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;
   
    class FuncaoService   {
        
        
        /**
         * @author jazon #290
         * recupera as funções 
         * 
         */
        public function getFuncoes() {
            try{        
                $api = new ApiRestGeneric();
                $request = $api->get("funcoes");
                $response = $api->converteStringJson($request);
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