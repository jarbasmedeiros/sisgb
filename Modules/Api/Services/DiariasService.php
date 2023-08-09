<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Exception;
    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;

    class DiariasService  extends Controller {

        
        /* Retorna uma lista de policiais de férias de acordo com as matrículas e periodo recebidos como parâmetros */
        // Entrada - uma ou várias matrículas, dt_inicio e dt_final
        // Saída - lista de policiais de férias férias desejada.
        public function listapoliciaisFerias($dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                
                $request = $api->get("diarias/listapoliciaisferias", $dadosForm);
                $objeto = $api->converteStringJson($request);
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        
                        return [];
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }   
        }
        
        /* Retorna uma lista de policiais de licenças de acordo com as matrículas e periodo recebidos como parâmetros */
        // Entrada - uma ou várias matrículas, dt_inicio e dt_final
        // Saída - lista de policiais de férias férias desejada.
        public function listapoliciaisLicenca($dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("diarias/listapoliciaislicenca", $dadosForm);
                $objeto = $api->converteStringJson($request);
               
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        
                        return [];
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }   
        }
        /* Retorna uma lista de policiais de licenças de acordo com as matrículas e periodo recebidos como parâmetros */
        // Entrada - uma ou várias matrículas, dt_inicio e dt_final
        // Saída - lista de policiais de férias férias desejada.
        public function listaPoliciaisMatricula($dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("diarias/listapoliciais", $dadosForm);
                $objeto = $api->converteStringJson($request);
               
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        
                        return [];
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }   
        }
        
        // Busca o histórico de férias de férias específica
        // Entrada - idFerias e idPolicial
        // Saída - lista todos os campos do historcioferias e os campos das férias desejada.
        public function listapoliciaisferiaswww($dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                
                $request = $api->get("diarias/listapoliciaisferias", $dadosForm);
                $objeto = $api->converteStringJson($request);
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        
                        return [];
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }   
        }
        
        // Busca o histórico de férias de férias específica
        // Entrada - idFerias e idPolicial
        // Saída - lista todos os campos do historcioferias e os campos das férias desejada.
        public function getHistoricoFerias($idHistorico)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("historicoferias/get/" . $idHistorico );
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }   
        }

        // Autor: @higormelo
        // Assegura determinado historico de férias
        // Entrada - id do histórico de férias, id das férias e dados do formulario
        // Saída - mensagem com o resultado
        public function assegurar($idHistorico, $idFerias, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("historicoferias/assegurar/" . $idHistorico . "/" . $idFerias, $dadosForm);
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if($objeto->retorno != 'sucesso'){
                    throw new Exception($objeto->msg);
                }
                return $objeto->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        // Autor: @higormelo
        // Cancela determinado historico de férias
        // Entrada - id do histórico de férias, id das férias e dados do formulario
        // Saída - mensagem com o resultado
        public function cancelar($idHistorico, $idFerias, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("historicoferias/cancelar/" . $idHistorico . "/" . $idFerias, $dadosForm);
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if($objeto->retorno != 'sucesso'){
                    throw new Exception($objeto->msg);
                }
                return $objeto->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        // Autor: @higormelo
        // Cria determinado historico de férias
        // Entrada -id das férias e dados do formulario
        // Saída - mensagem com o resultado
        public function create($idFerias, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("historicoferias/create/" . $idFerias, $dadosForm);
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if($objeto->retorno != 'sucesso'){
                    throw new Exception($objeto->msg);
                }
                return $objeto->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }
        
        // Autor: @higormelo
        // Atualiza determinado historico de férias
        // Entrada -idHistorico e dados do formulario
        // Saída - mensagem com o resultado
        public function update($idHistorico, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->put("historicoferias/update/" . $idHistorico, $dadosForm);
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if($objeto->retorno != 'sucesso'){
                    throw new Exception($objeto->msg);
                }
                return $objeto->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

    }

?>