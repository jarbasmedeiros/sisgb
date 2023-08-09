<?php

    namespace Modules\Api\Services;
    use App\utis\ApiRestGeneric;
    use App\Http\Controllers\Controller;
    use App\Utis\Msg;
    use Illuminate\Database\Query\Builder;
    use Exception;
    use App\utis\LengthAwarePaginatorConverter;
    use Request;
    use Auth;

    class ProntuarioJPMSService extends Controller{

        public function buscarProntuarios($dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("jpms/prontuarios", $dadosForm);
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

        public function showAtendimento($idAtendimento){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/prontuario/atendimento/".$idAtendimento);
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

        public function showProntuario($idProntuario){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/prontuario/".$idProntuario);
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
        
        public function getAtendimentosAbertos(){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/atendimentosabertos");
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
        
        public function getSessoesAbertas(){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/sessoesabertas");
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
        
        public function getRestricoes(){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/todasrestricoes");
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
        
        public function getCIDs(){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/cids");
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
        
        public function getPeritos(){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/peritos");
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

        public function getAnexos($idAtendimento){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/arquivos/atendimentos/".$idAtendimento);
                //dd($request);
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
        
        public function cadastrarAtendimento($idProntuario, $dados){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("jpms/prontuario/".$idProntuario."/atendimento/iniciar", $dados);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno) && $response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        
        public function salvarAtendimento($idProntuario, $idAtendimento, $dados){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("jpms/prontuario/".$idProntuario."/atendimento/".$idAtendimento."/salvar", $dados);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno) && $response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        public function concluirAtendimento($idProntuario, $idAtendimento){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("jpms/prontuario/".$idProntuario."/atendimento/".$idAtendimento."/concluir");
                $response = $api->converteStringJson($request);
                if(isset($response->retorno) && $response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        
        public function excluirAtendimento($idAtendimento){
            try{
                $api = new ApiRestGeneric();
                $request = $api->delete("jpms/atendimentos/".$idAtendimento."/excluir");
                $response = $api->converteStringJson($request);
                if(isset($response->retorno) && $response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        
        public function buscarPM($cpfPM){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("jpms/prontuario/policial/".$cpfPM);
                return $request;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        
        public function cadastrarProntuario($dados){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("jpms/prontuario/criar", $dados);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        public function sincronizarProntuario($idProntuario, $cpf){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("jpms/prontuario/".$idProntuario."/cpf/".$cpf."/sincronizar");
                $response = $api->converteStringJson($request);
                if(isset($response->retorno) && $response->retorno != "sucesso"){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
    }
?>