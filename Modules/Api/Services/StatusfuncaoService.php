<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\Rh\Entities\StatusFuncao;
    use App\utis\ApiRestGeneric;
  
    use Modules\Api\Services\FuncaoService;

    class StatusfuncaoService  extends Controller {
        
        /* 
        Autor: @aggeu. 
        Issue 211, Editar dados funcionais. 
        Função que retorna uma lista de status. 
        */   
        public function getStatus() {
            try{        
                $api = new ApiRestGeneric();
                $request = $api->get("status");
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

        /* 
        Autor: @aggeu. 
        Issue 211, Editar dados funcionais. 
        Função que retorna uma lista de funcoes. 

        código transferido para a classe FunçãoService por Jazon #290
        */   
        public function getFuncoes() {
           $funcaoService = new FuncaoService();
           return $funcaoService->getFuncoes();
        }

        

        // Lista todos os status ativos
        // Saída - lista todos os campos de statusfuncao
        public function listastatusativos() {
            $status = StatusFuncao::where('bo_ativo', '1')->orderby('st_status')->get();
            return $status;
        }

        // Busca status por id
        // Entrada - id do status desejado
        // Saída - lista todos os campos do status caso ele seja encontrado
        public function buscastatus($id) {
            $status = StatusFuncao::find($id);
            return $status;
        }

        // Cria statusfuncao com dados que recebe
        // Entrada - dados do form
        // Saída - true ou false
        public function createstatusfuncao($dados){
            $statusfuncao = StatusFuncao::create($dados);
            return $statusfuncao;
        }

        // Atualiza statusfuncao com dados que recebe
        // Entrada - dados do form e o objeto statusfuncao
        // Saída - true ou false
        public function atualizastatusfuncao(StatusFuncao $statusfuncao, $dados){
            $update = $statusfuncao->update($dados);
            return $update;
        }

        // Desativa statusfuncao
        // Entrada - objeto statusfuncao
        // Saída - true ou false
        public function desativastatusfuncao(StatusFuncao $statusfuncao){
            $update = $statusfuncao->update(['bo_ativo' => 0]);
            return $update;
        }

    }

?>