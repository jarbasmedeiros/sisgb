<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Exception;
    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;
    use Illuminate\Support\Facades\Request;
    use App\utis\LengthAwarePaginatorConverter;

    class IntegradorService  extends Controller {

        // Autor: @higormelo
        // Lista de integrações agendadas paginado
        // Entrada -
        // Saída - lista de integrações agendadas paginado
        public function listaAgendamentos()
        {
            try{
                $api = new ApiRestGeneric(); 
                $response = $api->get("integracoes/agendadas?".Request::getQueryString());
                $objeto = $api->converteStringJson($response);
                
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($objeto, url()->current());
                return $paginator;
            
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }       
        }

        // Autor: @higormelo
        // Realiza integração
        // Entrada - idIntegrador
        // Saída - mensagem de sucesso ou erro
        public function integrarBoletim($idIntegrador)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("integracoes/integrarboletim/" . $idIntegrador);
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
        /**
         * @author Jazon #327
         * 
         */
        public function checarIntegracao($idIntegrador)
        {
            try{     
               // $obj = (object) array('1' => 'foo');
               /*  $integracoes = (object) array(
                    'id'=>30,
                    'ce_boletim'=>'22',
                   'notas'=>['ce_nota'=>30,'ce_tipo'=>'2','bo_integrado'=>1,'ce_boletim'=>'22','nu_policiais'=>2,'nu_publicacoes'=>2]
                );


                return json_encode($integracoes); */
                //return $integracoes;
                 $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("integracoes/checarintegracao/" . $idIntegrador);
               // dd($request);
                $objeto = $api->converteStringJson($request);
               // dd($objeto);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno) &&  $objeto->retorno != 'sucesso'){
                    throw new Exception($objeto->msg);
                }
                return $objeto; 
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }  
        }

    }

?>