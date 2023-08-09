<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Exception;
    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;

    class HistoricoFeriasService  extends Controller {

        // Busca o histórico de férias de férias específica
        // Entrada - idFerias e idPolicial
        // Saída - lista todos os campos do historcioferias e os campos das férias desejada.
        public function getHistoricoFeriasPolicial($idPolicial, $idFerias)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("policiais/" . $idPolicial . "/historicoferias/" . $idFerias);
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