<?php

    namespace Modules\Api\Services;
    use Modules\rh\Entities\Medalha;
    use App\utis\ApiRestGeneric;
    use App\Http\Controllers\Controller;
    use App\Utis\Msg;
    use Exception;

    class MedalhaService extends Controller{

        /* 
        Autor: @aggeu. 
        Issue 194, implementar aba medalhas.
        Função recupera as medalhas de um policial a partir do seu ID e retorna as mesmas. 
        */
        public function listaMedalhas($idPolicial){
            try{
                $api = new ApiRestGeneric();
                $medalhas = $api->get("policiais/edita/".$idPolicial."/medalhas/listagem");
                $response = $api->converteStringJson($medalhas);
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

        /* 
        Autor: @aggeu. 
        Issue 197, crude de medalhas de um policial. 
        */
        public function cadastraMedalha($idPolicial, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $cadastra = $api->post("policiais/".$idPolicial."/medalha/cadastro", $dadosForm);
                $response = $api->converteStringJson($cadastra);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /* 
        Autor: @aggeu. 
        Issue 197, crude de medalhas de um policial. 
        */
        public function atualizaMedalha($idPolicial, $idMedalha, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $atualiza = $api->put("policiais/".$idPolicial."/medalha/".$idMedalha."/edita", $dadosForm);
                $response = $api->converteStringJson($atualiza);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /* 
        Autor: @aggeu. 
        Issue 197, crude de medalhas de um policial. 
        */
        public function excluiMedalha($idPolicial, $idMedalha){
            try{
                $api = new ApiRestGeneric();
                $exclui = $api->delete("policiais/".$idPolicial."/medalha/".$idMedalha."/exclui");
                $response = $api->converteStringJson($exclui);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

    }
?>
