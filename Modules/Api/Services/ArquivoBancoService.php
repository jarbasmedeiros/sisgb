<?php
    namespace Modules\Api\Services;

    use App\Utis\Msg;
    use Auth;
    use DB;
    use App\utis\MyLog;
    use App\utis\ApiRestGeneric;
    use App\utis\LengthAwarePaginatorConverter;
    use Exception;
    use Illuminate\Support\Facades\Request;

class ArquivoBancoService  
{
    /**
     * Chama o recurso de arquivos e cria um registro
     * retorna sucesso ou erro
     * @autor: Talysson
     */
    public function createArquivo($idPolicial, $dadosForm) 
    {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("arquivo/policial/".$idPolicial, $dadosForm);
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
     * @author: Marcos Paulo #336
     * Chama o recurso de arquivos genéricos e cria um registro
     * retorna sucesso ou erro
     */
    public function createArquivoGenerico($dadosForm){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("arquivos/create", $dadosForm);
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
     * @author: Marcos Paulo #336
     * Chama o recurso de arquivos genéricos e retorna um registro
     * retorna sucesso ou erro
     */
    public function getArquivoGenerico($id){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("arquivo/".$id);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    throw new Exception(Msg::NENHUM_RESULTADO_ENCONTRADO);
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
     * @author: Marcos Paulo #336
     * Deleta um arquivo genérico pelo id
     * retorna sucesso ou erro
     */
    public function deleteArquivoGenerico($id){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->delete("arquivos/delete/".$id);
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
     * Chama o recurso de arquivos e exibe um registro
     * retorna um objeto com as informações do arquivo
     * @autor: Talysson
     */
    public function getArquivoId($idArquivo, $idPolicial) 
    {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("arquivo/".$idArquivo."/policial/".$idPolicial);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    throw new Exception(Msg::NENHUM_RESULTADO_ENCONTRADO);
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
     * Chama o recurso de arquivos e atualiza um registro
     * retorna sucesso ou erro
     * @autor: Talysson
     */
    public function updateArquivo($idArquivo, $idPolicial, $dadosForm) 
    {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->put("arquivo/".$idArquivo."/policial/".$idPolicial, $dadosForm);
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
     * Chama o recurso de arquivos e apaga um registro
     * retorna sucesso ou erro
     * @autor: Talysson
     */
    public function deleteArquivo($idArquivo, $idPolicial) 
    {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->delete("arquivo/".$idArquivo."/policial/".$idPolicial);
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
     * Lista todos os arquivos de um policial
     * retorna uma lista de objeto com as informações dos arquivo
     * @autor: Talysson
     */
    public function findArquivoIdQuadroIdPolicial($idQuadro, $idPolicial) 
    {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("arquivo/".$idQuadro."/".$idPolicial);
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
    /* autor: @juanmojica
       Retorna uma lista de objeto com as informações do arquivos de um policial     
     */
    public function listaArquivos($idPolicial, $modulo){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("policial/".$idPolicial."/arquivo/modulo/".$modulo);
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
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

    public function getArquivoIdentificador($idIdentificador,$st_modulo){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("arquivos/identificador/$idIdentificador/modulo/$st_modulo");
            $objeto = $api->converteStringJson($request);
            //dd($objeto);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    throw new Exception(Msg::NENHUM_RESULTADO_ENCONTRADO);
                }else{
                    throw new Exception($objeto->msg);
                }
            }
            return $objeto;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function getlistaArquivoIdentificador($idIdentificador,$st_modulo){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("arquivos/identificador/$idIdentificador/modulo/$st_modulo");
            $objeto = $api->converteStringJson($request);
            //dd($objeto);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                   return [];
                }
            }
            return $objeto;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

}

?>
