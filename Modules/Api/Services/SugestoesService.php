<?php
    namespace Modules\Api\Services;

    use App\Http\Controllers\Controller;
    use App\utis\ApiRestGeneric;
    use App\utis\Msg;
    use Exception;


    class SugestoesService extends Controller
    {
        
        /**
         * @author juan_mojica - #392
        */
        public function getSugestoes(){
            try {
                $api = new ApiRestGeneric();
                //busca a lista de sugestões
                $request = $api->get("sugestoes");
                $response = $api->converteStringJson($request);
                //verifica se houve erro na requisição
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

        /**
         * @author juan_mojica - #392
         */
        public function cadastraSugestao($dados){
            try {
                $api = new ApiRestGeneric();
                //cadastra uma sugestão
                $request = $api->post("sugestoes", $dados);
                $response = $api->converteStringJson($request);
                //verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;    
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }

        /**
         * @author juan_mojica - #392
         */
        public function cadastraVotoSugestao($idSugestao, $dados){
            try {
                $api = new ApiRestGeneric();
                //cadastra o voto referente a uma sugestão
                $request = $api->put('sugestoes/' . $idSugestao . '/votar', $dados);
                $response = $api->converteStringJson($request);
                //verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;    
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }
        
    }

?>