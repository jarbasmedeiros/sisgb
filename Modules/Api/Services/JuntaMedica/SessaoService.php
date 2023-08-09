<?php

    namespace Modules\Api\Services\JuntaMedica;
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

    class SessaoService   extends Controller{

        
       

        /**
         * @author: alexia
         * issue #331: recupera a lista de  sessao paginadas
         */
        public function getSessao(){
            try{
                 
                $api = new ApiRestGeneric();
                $recuperasessao = $api->get('jpms/sessoespaginadas?'.Request::getQueryString());
              //dd( $recuperasessao);
                $response = $api->converteStringJson($recuperasessao);
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
         * @author: alexia
         * issue #331: retorna os tipos da sessao
         */
        public function tipoSessao(){
            try{
                $api = new ApiRestGeneric();
                $tiposessao = $api->get('jpms/tiposessoes');
                //dd($tiposessao);
                $response = $api->converteStringJson($tiposessao);
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
         * @author: alexia
         * issue #331: cadastra uma sessao
         */
        public function cadastraSessao($dadosForm){
            try{        
                    
                $api = new ApiRestGeneric();
                $request = $api->post('jpms/sessao', $dadosForm);
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
         * @author: alexia
         * issue #331: busca os dados que populam o form
         */
        public function findSessaoById($idSessao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/sessao/".$idSessao);
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
         * @author: alexia
         * issue #331: edita a sessao
         */
        public function editaSessao($idSessao, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("jpms/sessao/edita/".$idSessao, $dadosForm);
                $response = $api->converteStringJson($request);
                 if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                }
                 return $response;
            }catch(Exception $e){
                 throw new Exception($e->getMessage());
             }
        }

        /** 
        * @author juanMojica - Issue #334
        * @param int $idSessao
        * @return object $assinaturas
        */ 
        public function getAssinaturasSessao($idSessao){
            try{
                $api = new ApiRestGeneric();
                $assinaturas = $api->get("jpms/sessao/".$idSessao."/assinaturas");
                $response = $api->converteStringJson($assinaturas);
                if(isset($response->retorno)){
                    if($response->msg == "Nenhuma assinatura encontrada."){
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
        * @author medeiros - Issue #3335
       
        */ 
        public function exportaAtendimentosSessaoExcel($idSessao, $orgao){
            try{
                $api = new ApiRestGeneric();
                $sessao = $api->get("jpms/sessao/".$idSessao."/atendimentos/orgao/".$orgao);
                $response = $api->converteStringJson($sessao);
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        throw new Exception('Sessão Não encontrada');
                    }else{
                        throw new Exception($response->msg);
                    }
                }elseif(count($response->atendimentosMedicos) < 1){
                    throw new Exception('Não Há atendimentos de '.$orgao.' Na Sessão informada' );
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        
        /** 
        * @author juanMojica - Issue #334
        * @param int $idSessao
        * @param request $dados
        * @return sucesso ou erro 
        */ 
        public function assinaSessao($idSessao, $dados) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("jpms/sessao/".$idSessao."/assinatura", $dados);
                $response = $api->converteStringJson($request);
                if($response->retorno == "sucesso"){
                    return $response;
                }else{
                    throw new Exception($response->msg);
                }
            } catch(\Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /** 
        * @author juanMojica - Issue #334
        * @param int $idSessao
        * @param int $idAssinaturaSessao
        * @return sucesso ou erro 
        */ 
        public function excluiAssinaturaSessao($idSessao, $idAssinaturaSessao) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->delete("jpms/sessao/".$idSessao."/assinatura/".$idAssinaturaSessao."/deleta");
                $response = $api->converteStringJson($request);
                if($response->retorno == "sucesso"){
                    return $response;
                }else{
                    throw new Exception($response->msg);
                }
            } catch(\Exception $e){
                throw new Exception($e->getMessage());
            }
        }


         
            /**
         * @author: alexia
         * issue #331: exclui uma sessao
         */
        public function excluiSessao($idSessao){
           try{
                //dd($idSessao);
                $api = new ApiRestGeneric();
                $deleta = $api->delete("jpms/sessao/deleta/".$idSessao);
                
                $response = $api->converteStringJson($deleta);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        public function finalizaSessao($idSessao){
            try{
                 
                 $api = new ApiRestGeneric();
                 $sessao = $api->put("jpms/sessao/fecha/".$idSessao);
              
                $response = $api->converteStringJson($sessao);
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