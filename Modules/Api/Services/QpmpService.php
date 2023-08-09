<?php

    namespace Modules\Api\Services;
    use Modules\RH\Entities\Qpmp;
    use App\utis\Status;
    use Auth;
    use DB;
    use App\utis\MyLog;
    use App\utis\ApiRestGeneric;

    class QpmpService {
    
        /* 
        Autor: @aggeu. 
        Issue 184, Editar dados funcionais. 
        Função que retorna uma lista de quadros. 
        */     
        public function getQpmp() {
            try{        
                $api = new ApiRestGeneric();
                $request = $api->get("qpmps");
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