<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use DB;
    use Illuminate\Database\Query\Builder;
    use Exception;
    use Request;
    use App\utis\ApiRestGeneric;
    use App\utis\LengthAwarePaginatorConverter;
    use App\Utis\Msg;
    //use Illuminate\Http\Request;
    use Auth;

class FeriasService  extends Controller {

    // Autor: @higormelo
    // Busca as ferias de determinado policial e seus historicos de férias
    // Entrada - id do polcial
    // Saída - lista todos os campos de férias e seus históricos
    public function getFeriasPolicial($idPolicial){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("policiais/" . $idPolicial . "/ferias");
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
    // Cria as ferias de determinado policial e seus historicos de férias
    // Entrada - id do polcial e dados do formulario
    // Saída - mensagem com o resultado
    public function criaFeriasPolicial($idPolicial, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("policiais/" . $idPolicial . "/ferias", $dadosForm);
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
    // Atualiza as ferias de determinado policial e seus historicos de férias
    // Entrada - id das férias e dados do formulario
    // Saída - mensagem com o resultado
    public function updateFeriasPolicial($idPolicial, $idFerias, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->put("policiais/" . $idPolicial . "/" . $idFerias . "/ferias", $dadosForm);
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

    //Autor: @Medeiros
    //Lista ferias dos policiais por unidade
    //A renderização dever ser "listagem", "excel" ou "pdf"
    public function listaFeriasPorUnidade($idUnidade){
        try{    
            $api = new ApiRestGeneric();

            
            $request = $api->get("ferias/corrente/unidade/".$idUnidade."/paginado?".Request::getQueryString());
      
            $ferias = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($ferias->retorno)){
                if($ferias->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($ferias->msg);
                }
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($ferias, url()->current());
            return $paginator; 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    //Autor: @Medeiros
    //Lista ferias dos policiais por unidade
    //A renderização dever ser "listagem", "excel" ou "pdf"
    public function listaFeriasPorUnidadeEperiodo($dados, $renderizacao){
        try{ 
            $api = new ApiRestGeneric();
            //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
           /*  Route::get('/v1/ferias/perido/unidade/'{idUnidade} */
           if($renderizacao != 'excel'){
              
               $request = $api->post("ferias/periodo/unidade/paginado?".Request::getQueryString(), $dados);
               $ferias = $api->converteStringJson($request);
               //Verifica se houve erro na requisição
               if(isset($ferias->retorno)){
                   if($ferias->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                       return [];
                   }else{
                       throw new Exception($ferias->msg);
                   }
               }
               $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($ferias, url()->current());
               return $paginator; 
                                            
           }else{
            $request = $api->post("ferias/periodo/unidade".Request::getQueryString(), $dados);
            $ferias = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($ferias->retorno)){
                if($ferias->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($ferias->msg);
                }
            }
           return  $ferias;

           }
            
           
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
}

?>