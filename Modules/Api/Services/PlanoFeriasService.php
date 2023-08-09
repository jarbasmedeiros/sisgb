<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Exception;
    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;
    use App\utis\LengthAwarePaginatorConverter;

class PlanoFeriasService  extends Controller {

    /**
     * @author carlosalberto
     * @isuse #321
     * */
    public function listaPlanosFerias(){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("rh/planosferias");
           // dd($request);
            $objeto = $api->converteStringJson($request);
            // dd($objeto);
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

    /**
     * @author carlosalberto
     * @isuse #321
     * */
    public function listaTurmasPlanosFerias($ano){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("rh/planosferias/".$ano."/turmas/show");
            //dd($request);
            $objeto = $api->converteStringJson($request);
            //dd($request);
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

    public function criaPlanosFerias($dadosForm ){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API, com os dados no formato de array que vem do blade
            $request = $api->post("rh/planosferias/criar", $dadosForm);
            //mostrando o retorno da API sem tratando de conversao para string
            $response = $api->converteStringJson($request);
             //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                if($response->retorno=="sucesso"){
                    return $response->msg;    
                }else{
                    throw new Exception($response->msg);
                }
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    // Autor: @carlosalberto
    public function listarTurmaPlano($idTurma){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("rh/planosferias/turma/".$idTurma."/efetivopaginado");
           // dd($request);
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

    public function distribuirEfetivoPlanosFerias($dadosForm ,$ano){
        try{
            //dd($dadosForm);
            $api = new ApiRestGeneric();
            // Requisição para API, com os dados no formato de array que vem do blade
            $request = $api->post("rh/planosferias/$ano/distribuirefetivo", $dadosForm);
          //  dd($request);
            //mostrando o retorno da API sem tratando de conversao para string
            $response = $api->converteStringJson($request);
            //dd($response);
            //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                if($response->retorno=="sucesso"){
                    return $response->msg;    
                }else{
                    throw new Exception($response->msg);
                }
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    public function getContagemEfetivoFerias($ano){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API, com os dados no formato de array que vem do blade
            $request = $api->get("rh/planosferias/".$ano."/totalefetivoferias");
           // dd($request);
            //mostrando o retorno da API sem tratando de conversao para string
            $response = $api->converteStringJson($request);
            //dd($response);
            //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                  throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    public function salvarPortaria($ano,$dadosForm){
        try{
           // dd('chegou service');
            $api = new ApiRestGeneric();
            // Requisição para API, com os dados no formato de array que vem do blade
            $request = $api->post("rh/planosferias/".$ano."/portaria", $dadosForm);
          //  dd($request);
            //mostrando o retorno da API sem tratando de conversao para string
            $response = $api->converteStringJson($request);
            //dd($response);
            //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                if($response->retorno=="sucesso"){
                    return $response->msg;    
                }else{
                    throw new Exception($response->msg);
                }
            }else{
                throw new Exception("Erro inesperado na requisição da api");
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    public function findPlanoFeriasByAno($ano){
        try{
           // dd('chegou service');
            $api = new ApiRestGeneric();
            // Requisição para API, com os dados no formato de array que vem do blade
            $request = $api->get("rh/planosferias/".$ano);
            //dd($request);
            //mostrando o retorno da API sem tratando de conversao para string
            $response = $api->converteStringJson($request);
            //dd($response);
            //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                return $response->msg;    
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    public function getEfetivoTurmaSelecionada($ano, $numTurma){
        try{
            $api = new ApiRestGeneric();
            $request = $api->get("rh/planosferias/".$ano."/turma/".$numTurma."/efetivopaginado?".\Request::getQueryString());
         // dd($request);
            $response = $api->converteStringJson($request);
            //dd($response);
            //Verifica se houve erro na requisição
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
    
    public function mudarTurmaEfetivo($dadosForm ,$ano){
        try{
            //dd($dadosForm);
            $api = new ApiRestGeneric();
            // Requisição para API, com os dados no formato de array que vem do blade
            $request = $api->post("rh/planosferias/$ano/mudarturmaefetivo", $dadosForm);
            // dd($request);
            //mostrando o retorno da API sem tratando de conversao para string
            $response = $api->converteStringJson($request);
            //dd($response);
            //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                if($response->retorno=="sucesso"){
                    return $response->msg;    
                }else{
                    throw new Exception($response->msg);
                }
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    
    public function pesquisarTurmaFerias($ano, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("rh/planosferias/".$ano."/buscaturma",$dadosForm);
          //dd($request);
            $response = $api->converteStringJson($request);
           // dd($response);
            //Verifica se houve erro na requisição
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
    
    public function gerarNotaBgFerias($ano, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("rh/planosferias/".$ano."/gerarnotabg",$dadosForm);
        //  dd($request);
            $response = $api->converteStringJson($request);
           // dd($response);
            //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                if($response->retorno=="sucesso"){
                    return $response->msg;    
                }else{
                    throw new Exception($response->msg);
                }
            } else{
                throw new Exception("Problemas inesperado para consultar a api");
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    public function exportarPlanoFeriasErgon($ano){
        try{
            $api = new ApiRestGeneric();
            $request = $api->get("rh/planosferias/".$ano."/exportarergon");
        // dd($request);
            $response = $api->converteStringJson($request);
           // dd($response);
            
           //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            } 
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    public function finalizarPlanoFerias($ano){
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("rh/planosferias/".$ano."/finalizar");
         //dd($request);
            $response = $api->converteStringJson($request);
           // dd($response);
            
           //Verifica se houve erro na requisição
           if(isset($response->retorno)){
                if($response->retorno=="sucesso"){
                    return $response->msg;    
                }else{
                    throw new Exception($response->msg);
                }
            } else{
                throw new Exception("Problemas inesperado para consultar a api");
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    public function getNumTurmaPlanoFerias(){
        try{
            $api = new ApiRestGeneric();
            $dadosForm = array('st_chave'=>'QTDTURMASFERIAS');
            $request = $api->get("dal/configuracoesporchave/totalturmas",$dadosForm);
         dd($request);
            $response = $api->converteStringJson($request);
           // dd($response);
            
           //Verifica se houve erro na requisição
           if(isset($response->retorno)){
                    throw new Exception($response->msg);
           }
           return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    /**
     * @author juanmoojica - #367
     * @param integer ('nu_ano' via query)
     * @return object (Lista de policiais sem plano de férias)
     * */
    public function listarEfetivoSemPlanoFerias($dados){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("rh/policiaissemplanoferias", $dados);
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

}

?>