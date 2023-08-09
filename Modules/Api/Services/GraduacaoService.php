<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\Admin\Entities\Graduacao;
    use App\utis\ApiRestGeneric;

    class GraduacaoService  extends Controller {

        // Busca graduação por id
        // Entrada - id da graduação desejada
        // Saída - lista todos os campos da graduacao caso ele seja encontrado
        public function getGraduacaoById($id) {
            /* ... */
        }

        /* 
        Autor: @aggeu. 
        Issue 184, Editar dados funcionais. 
        Função que retorna uma lista não páginada de graduações 
        */     
        public function getGraduacao() {
            try{            
                $api = new ApiRestGeneric();
                $request = $api->get("graduacoes");
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
        
}

?>