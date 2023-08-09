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
    use Illuminate\Http\Request;
    use Auth;

    class PromocaoService extends Controller{

        /* 
        Autor: @aggeu. Issue 193, implementar aba de promoções
        */
        public function listaPromocoes($idPolicial){
            try{
                $api = new ApiRestGeneric();
                $promocao = $api->get("policiais/".$idPolicial."/promocoes/listagem");
              
                $response = $api->converteStringJson($promocao);
              
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                return $response;
            }catch(Exception $e){
            if($e->getMessage() =='Objeto Não encontrado.') {
                return [];
            }
                throw new Exception($e->getMessage());
            }
        }

        /* 
        Autor: @aggeu. Issue 193, implementar aba de promoções
        */
        public function cadastraPromocao($idPolicial, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $cadastra = $api->post("policiais/".$idPolicial."/promocoes/cadastra", $dadosForm);
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
        Autor: @aggeu. Issue 193, implementar aba de promoções
        */
        public function atualizaPromocao($idPolicial, $idPromocao, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $atualiza = $api->put("policiais/".$idPolicial."/promocoes/".$idPromocao, $dadosForm);
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
        Autor: @aggeu. Issue 193, implementar aba de promoções
        */
        public function excluiPromocao($idPolicial, $idPromocao){
            try{
                $api = new ApiRestGeneric();
                $exclui = $api->delete("policiais/".$idPolicial."/promocao/".$idPromocao."/deleta");
                $response = $api->converteStringJson($exclui);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /* 
        Autor: @aggeu. Issue 193, implementar aba de promoções
        */
        public function recuperaPromocao($idPolicial, $idPromocao) {
            try{
                $api = new ApiRestGeneric();
                $promocao = $api->get("policiais/".$idPolicial."/promocoes/".$idPromocao);
                $response = $api->converteStringJson($promocao);
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