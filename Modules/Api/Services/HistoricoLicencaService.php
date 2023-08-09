<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Exception;
    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;

    class HistoricoLicencaService  extends Controller {

        // Busca o histórico de licença de licença específica
        // Entrada - idLicenca e idPolicial
        // Saída - lista todos os campos do historciolicenca e os campos das licença desejada.
        public function getHistoricoLicencaPolicial($idPolicial, $idLicenca)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("policiais/" . $idPolicial . "/historicolicencas/" . $idLicenca);
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
        
        // Busca o histórico de licença de licença específica
        // Entrada - idLicenca e idPolicial
        // Saída - lista todos os campos do historciolicenca e os campos das licença desejada.
        public function getHistoricoLicenca($idHistorico)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("historicolicencas/get/" . $idHistorico );
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
        // Assegura determinado historico de licença
        // Entrada - id do histórico de licença, id da licença e dados do formulario
        // Saída - mensagem com o resultado
        public function assegurar($idHistorico, $idLicenca, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("historicolicencas/assegurar/" . $idHistorico . "/" . $idLicenca, $dadosForm);
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
        // Cancela determinado historico de licença
        // Entrada - id do histórico de licença, id da licença e dados do formulario
        // Saída - mensagem com o resultado
        public function cancelar($idHistorico, $idLicenca, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("historicolicencas/cancelar/" . $idHistorico . "/" . $idLicenca, $dadosForm);
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
        // Cria determinado historico de licença
        // Entrada -id da licença e dados do formulario
        // Saída - mensagem com o resultado
        public function create($idLicenca, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("historicolicencas/create/" . $idLicenca, $dadosForm);
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
        // Atualiza determinado historico de licença
        // Entrada -idHistorico e dados do formulario
        // Saída - mensagem com o resultado
        public function update($idHistorico, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->put("historicolicencas/update/" . $idHistorico, $dadosForm);
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