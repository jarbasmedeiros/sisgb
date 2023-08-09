<?php

    namespace Modules\Api\Services;
    use Modules\rh\Entities\Promocao;
    use App\utis\ApiRestGeneric;
    use App\Http\Controllers\Controller;
    use App\Utis\Msg;
    use Modules\rh\Entities\Funcionario;
    use Illuminate\Database\Query\Builder;
    use Exception;
    use App\utis\LengthAwarePaginatorConverter;
    use Request;
    use Auth;

    class DashboardJpmsService  extends Controller{

        
        /**
         * @author Jazon #333
         */
        public function getDados(){
            try{
              //  return array('nu_cedulasdisponiveis'=>9);
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/dash");
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