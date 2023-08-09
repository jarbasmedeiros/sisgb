<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use App\utis\LengthAwarePaginatorConverter;
    use Exception;
    use Auth;
    use App\utis\ApiRestGeneric;
    use App\utis\Msg;
    use Illuminate\Support\Facades\Request;
    use Session;

    class MuralService {
    
    /**
     * @author: Marcos Paulo #329
     * @revisor: Jazon
     * entrada: não tem
     * retorno: Lista todas as notícias do mural
     * OBS: Utilizado pela view Home
     */
    public function listarMural() {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("mural");
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

     /**
     * @author: Marcos Paulo #329
     * @revisor: Jazon
     * entrada: não tem
     * retorno: Lista todas as notícias do mural
     */
    public function listarNoticias() {
        try {
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("mural/noticiaspaginadas?".Request::getQueryString());
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($response->retorno)){
                if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                   return [];
                }else{
                    throw new Exception($response->msg);
                }
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
            return $paginator;

        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

     /**
     * @author: Marcos Paulo #329
     * @revisor: Jazon
     * entrada: não tem
     * retorno:Cria uma nova notícia no mural
     */
    public function criarNoticia($dados) {
        try{  
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("mural/noticia", $dados);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto)){
                if($objeto->retorno == 'erro'){
                throw new Exception($objeto->msg);
                }else{
                    return $objeto->msg;
                }
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

     /**
     * @author: Marcos Paulo #329
     * @revisor: Jazon
     * entrada: não tem
     * retorno: Requisita uma notícia do mural
     */
    public function editandoNoticia($id) {
        try{
            // Requisição para API
            $api = new ApiRestGeneric(); 
            $request = $api->get("mural/noticia/".$id);
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

     /**
     * @author: Marcos Paulo #329
     * @revisor: Jazon
     * entrada: não tem
     * retorno: Lista todas as notícias do mural
     */
    public function updateNoticia($id, $dadosForm) {
        try{
            // Requisição para API
            $api = new ApiRestGeneric(); 
            $request = $api->put("mural/noticia/".$id, $dadosForm);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto)){
                if($objeto->retorno == 'erro'){
                throw new Exception($objeto->msg);
                }else{
                    return $objeto->msg;
                }
            }

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}

?>