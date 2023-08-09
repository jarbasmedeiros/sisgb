<?php

    namespace Modules\Api\Services\JuntaMedica;

    use App\utis\LengthAwarePaginatorConverter;
    use App\Http\Controllers\Controller;
    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;
    use Exception;
    use Request;
    use Auth;

    class RestricaoService extends Controller{

        /**
         * @author: Marcos Paulo #332
         * Recupera a lista de restrições paginadas
         */
        public function getRestricoes(){
            try{
                 
                $api = new ApiRestGeneric();
                $restricoes = $api->get('jpms/restricoes');
                //dd($restricoes);
                $response = $api->converteStringJson($restricoes);
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /**
         * @author: Marcos Paulo #332
         * Criar uma restrição no banco
         */
        public function criarRestricao($dados){
            try{         
                $api = new ApiRestGeneric();
                $request = $api->post('jpms/restricao', $dados);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        /**
         * @author: Marcos Paulo #332
         * Retorna uma restrição no banco pelo ID
         */
        public function restricaoById($idRestricao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/restricao/".$idRestricao);
                $response = $api->converteStringJson($request);
                if(isset( $response->retorno )){
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
        
        /**
         * @author: Marcos Paulo #332
         * Editar uma restrição no banco
         */
        public function editarRestricao($idRestricao, $dados){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put('jpms/restricao/edita/'.$idRestricao, $dados);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        /**
         * @author: Marcos Paulo #332
         * Criar restrição no banco
         */
        /* public function deletarRestricao($idRestricao){
            try{         
                $api = new ApiRestGeneric();
                $request = $api->delete('jpms/restricao/'.$idRestricao.'/deleta');
                $response = $api->converteStringJson($request);
                if($response->retorno == "sucesso"){
                    return $response;
                }else{
                    throw new Exception($response->msg);
                }                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }    
        }*/
    }
?>