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
   
    use Auth;




    
class LicencaService  extends Controller {

    // Autor: @higormelo
    // Busca as licenças de determinado policial e seus historicos de licenças
    // Entrada - id do polcial
    // Saída - lista todos os campos de licenças e seus históricos
    public function getLicencaPolicial($idPolicial){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("policiais/" . $idPolicial . "/licencas");
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
    // Cria a licença de determinado policial e seu historico de licença
    // Entrada - id do polcial e dados do formulario
    // Saída - mensagem com o resultado
    public function criaLicencaPolicial($idPolicial, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("policiais/" . $idPolicial . "/licencas", $dadosForm);
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
    // Atualiza a licença de determinado policial e seu historico de licença
    // Entrada - idLicenca e dados do formulario
    // Saída - mensagem com o resultado
    public function updateLicencaPolicial($idPolicial, $idLicenca, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->put("policiais/" . $idPolicial . "/" . $idLicenca . "/licencas", $dadosForm);
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
    // Busca todos os tipos de licenças
    // Entrada - 
    // Saída - lista todos os campos de tipos de licenças
    public function getAllTipos(){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("tiposlicencas/get");
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
    //Autor: @Medeiros
    //Lista licenças dos policiais por unidade
    //A renderização dever ser "listagem", "excel" ou "paginado"
    public function listaLicencasPorUnidade(){
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
            $request = $api->get("licencas/corrente/unidade/".$policial->ce_unidade."/paginado?".Request::getQueryString());
            $licencas = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($licencas->retorno)){
                if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($licencas->msg);
                }
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($licencas, url()->current());
            return $paginator; 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
     //Autor: @Medeiros
    //Lista licenças dos policiais por unidade
    //A renderização dever ser "listagem", "excel" ou "paginado"
    public function listaLicencasPorUnidadeEperiodo($dados, $renderizacao){
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
               $request = $api->post("licencas/periodo/unidade/paginado?".Request::getQueryString(), $dados);
               $licencas = $api->converteStringJson($request);
               dd(  $licencas );
               //Verifica se houve erro na requisição
               if(isset($licencas->retorno)){
                   if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                       return [];
                   }else{
                       throw new Exception($licencas->msg);
                   }
               }
               $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($licencas, url()->current());
               return $paginator; 
                                            
           }else{
            $request = $api->post("licencas/periodo/unidade".Request::getQueryString(), $dados);
            $licencas = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($licencas->retorno)){
                if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($licencas->msg);
                }
            }
           return  $licencas;

           }
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }


     
     //Autor: @Alexia
    //exclui licença
    //issue: #379
    public function excluiLicenca($idPolicial, $idLicenca, $dadosForm){
        try{
          
            $api = new ApiRestGeneric();
            $request = $api->delete("policiais/".$idPolicial. "/" .$idLicenca."/licencas",  $dadosForm);
            //dd($request);
            $response = $api->converteStringJson($request);
            //verifica se o response vem diferente de sucesso e retorna a msg
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}

?>