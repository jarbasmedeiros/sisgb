<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Exception;
    use Auth;
    use DB;
    use App\utis\Msg;
    use App\utis\Status;
    use App\utis\ApiRestGeneric;
    use Illuminate\Support\Facades\Request;
    use Session;

    class DjdService extends Controller {

        public function __construct(){
            $this->middleware('auth');

        }

        public function getDadosDash(){
            try {                
                $api = new ApiRestGeneric();
                
                $request = $api->get("djd/dashboard");
                
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        

        public function consultarProcedimentos(){
            try {                
                $api = new ApiRestGeneric();
                
                $request = $api->get("djd/procedimentos");
                
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function buscarProcedimentos($dadosForm){
            try {                       
                $api = new ApiRestGeneric();                
                $request = $api->post("djd/procedimentos",$dadosForm);                
                $response = $api->converteStringJson($request);      
                          
                if(isset($response->retorno)){  
                                     
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }                
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }            

        }

        public function registrarProcedimentos($id){
            try {                       
                $api = new ApiRestGeneric();                
                $request = $api->post("djd/procedimentos/".$id."/registro"); 
                               
                $response = $api->converteStringJson($request);                
                if(isset($response->retorno)){                   
                    if($response->retorno == 'erro'){
                        throw new Exception($response->msg);
                    }else{
                        return $response->msg;
                    }
                }                
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            } 
        }

        public function getExtratoById($id){
            try {
                
                $api = new ApiRestGeneric();
                
                $request = $api->get('djd/procedimento/'.$id.'/extrato');
                
                
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){     
                                  
                    if($response->retorno == 'erro'){                        
                        throw new Exception($response->msg);
                    }else{
                        
                        return $response->msg;
                    }
                }                
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

    }
    

        


?>