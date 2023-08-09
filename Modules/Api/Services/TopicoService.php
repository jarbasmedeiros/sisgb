<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\Boletim\Entities\Tiposboletim;
    use Modules\Boletim\Entities\Boletim;
    use Modules\Boletim\Entities\Capa;
    use App\utis\LengthAwarePaginatorConverter;
    use Exception;
    use Auth;
    use DB;
    use App\utis\Status;
    use App\utis\ApiRestGeneric;
    use Modules\Api\Services\NotaService;
    use Modules\Api\Services\PolicialService;
    use Modules\Api\Services\UnidadeService;
    use App\utis\MyLog;
    use App\utis\Msg;
    use Illuminate\Support\Facades\Request;
    use Session;

    class TopicoService extends Controller {

        public function __construct(NotaService $NotaService, PolicialService $policialService, UnidadeService $unidadeService){
            $this->middleware('auth');
            $this->NotaService = $NotaService;
            $this->policialService = $policialService;
            $this->unidadeService = $unidadeService;
            //$this->api = new ApiRestGeneric();
        }

    
    /***
     * Lista todos os tópicos de boletins 
     * entrada: não tem
     * retorno: Lista todos os tópicos dos boletins 
     * @autor: medeiros
     * #262
     */
    public function getTopicos() {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("boletim/topicos/lista/paginado?".Request::getQueryString());
            $topicos = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($objeto->msg);
                }
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($topicos, url()->current());
            return $paginator;
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    
    /***
     * @autor: Jazon #301
     * Pesquisa tópicos     
     * retorno: Lista dos tópicos dos boletins baseada nos critérios de seleção
     */
    public function pesquisarTopicos($dadosForm) {            
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("boletim/topicos/pesquisa?".Request::getQueryString(),$dadosForm);
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
         
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($objeto, url()->current());
        
            return $paginator;
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
   

    /***
     * Recupera um tópico de boletim pelo id
     * entrada: id do tópico
     * retorno: objeto do tipo tópico
     * @autor: medeiros
     */
    public function findTopicoId($idTopico) {            
        try{
            
            $api = new ApiRestGeneric();
            $request = $api->get("boletim/topico/".$idTopico);

            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    throw new Exception('TÓPICO DE BOLETIM NÃO ENCONTRADO.');
                }else{
                    throw new Exception($objeto->msg);
                }
            }
           return $objeto;
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
   


    public function store($dadosForm){
        try{
            $api = new ApiRestGeneric();
            $response = $api->post("boletim/topico", $dadosForm);
            $create = $api->converteStringJson($response);
            if($create->retorno != 'sucesso'){
                throw new Exception($create->msg);
            }
        } catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }
   
 

    //Entra com o formulario para atualização dos dados do tópico de boletim
    //Retorna mensagem de sucesso ou erro
    public function updateTopicoBoletim($dadosForm, $idTopico){
        try{

            $api = new ApiRestGeneric();
            $request = $api->put("boletim/topico/".$idTopico."/atualiza", $dadosForm);
            $response = $api->converteStringJson($request);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    //Entra com o formulario para atualização dos dados do tópico de boletim
    //Retorna mensagem de sucesso ou erro
    public function destroy($idTopico){
        try{

            $api = new ApiRestGeneric();
            $request = $api->delete("boletim/topico/".$idTopico."/deleta");
            $response = $api->converteStringJson($request);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * ALTERA O STATUS DO BOLETIM
     * entrada objeto boletim e novo status
     * retorno true ou false
     */
    public function alteraStatusBoletim($boletim, $dados) {
        //dd($dados);
        
        $api = new ApiRestGeneric();
        $response = $api->put("boletins/".$boletim->id."/assina", $dados);
        //dd($response);
        $alteraStatus = $api->converteStringJson($response);
        
        return $alteraStatus;
    }

    /**
     * FINALIZA BOLETIM
     * entrada objeto boletim
     * retorno true ou false
     */
    public function FinalizaBoletim($idBoletim) {
        try{
            // Altera status do boletim
            $api = new ApiRestGeneric();
            $response = $api->put("boletins/".$idBoletim."/finaliza");
            //dd($response);
            $finalizaBoletim = $api->converteStringJson($response);
            
            if($finalizaBoletim->retorno == "sucesso"){
                return $finalizaBoletim->msg;
            }else{
                throw new Exception($finalizaBoletim->msg);
            }
            

        } catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
       
    }
    /**
     * ASSINA BOLETIM
     * entrada ID do boletim
     * retorno true ou false
     */
    public function AssinaBoletim($idBoletim, $dados) {
        
        try{
            $api = new ApiRestGeneric();
            $response = $api->put("boletins/".$idBoletim."/assina", $dados);
            $assinaBoletim = $api->converteStringJson($response);
            if($assinaBoletim->retorno == "sucesso"){
                return $assinaBoletim;
            }else{
                throw new Exception($assinaBoletim->msg);
            }
        } catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    /**
     * RETORNA BOLETIM PARA ELABORAÇÃO
     * entrada ID do boletim
     * retorno true ou false
     */
    public function RetornaBoletimParaElaboracao($idBoletim) {
      
        try{
            // Altera status do boletim
            $api = new ApiRestGeneric();
            $response = $api->put("boletins/".$idBoletim."/devolucao");
            $retornaboletim = $api->converteStringJson($response);
            
            if($retornaboletim->retorno != "sucesso"){
                throw new Exception($finalizaBoletim->msg);
            }
            
      
        } catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }

    /**
     * PUBLICA BOLETIM E ALTERA STATUS DAS NOTAS
     * entrada ID do boletim
     * retorno true ou false
     */
    public function publicarBoletim($idBoletim, $dados) {
        try{
            // Altera status do boletim
            $api = new ApiRestGeneric();
            $response = $api->put("boletins/".$idBoletim."/publica", $dados);
            $obj = $api->converteStringJson($response);
            if($obj->retorno != "sucesso"){
                throw new Exception($obj->msg);
            }
            return $obj->msg;
        } catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * DELETA BOLETIM
     * entrada id do boletim
     * retorno true ou false
     */
    public function deletaBoletim($idBoletim) {
        //DB::beginTransaction();
        try{
            $api = new ApiRestGeneric();
            $response = $api->delete("boletins/".$idBoletim);
            $deletaboletim = $api->converteStringJson($response);
            //$deletaboletim = Boletim::find($id)->delete();
                if($deletaboletim->retorno != "sucesso"){
                    throw new Exception($deletaboletim->msg);
                   
                }
            } catch(\Exception $e){
                throw new Exception($e->getMessage());
            }
        
    }

    /**
     * PEGA NOTAS QUE SE RELACIONAM COM O BOLETIM
     * entrada id do boletim
     * retorno true ou false
     */
    
    public function getNotasDoBoletim($idBoletim) {
       
        try{
        $api = new ApiRestGeneric();
        $response = $api->get("boletins/".$idBoletim."/notas");
       
        $notasDoBoletim = $api->converteStringJson($response);
            if(count($notasDoBoletim) > 0){
                return $notasDoBoletim;
            }else{
                return $notasDoBoletim = [];
            }
        }catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
        
        return $notasDoBoletim;
    }

    public function getNotasAtribuidasBoletim($idBoletim) {
        try{
            $parte1 = array();
            $parte2 = array();
            $parte3 = array();
            $parte4 = array();
            $api = new ApiRestGeneric();
            $response = $api->get("boletins/".$idBoletim."/notas");
            $notas = $api->converteStringJson($response);
            if(isset($notas->retorno)){
                if($notas->msg == MSG::NENHUM_RESULTADO_ENCONTRADO){
                    $notasAtribuidasBoletim = array('parte1' => $parte1, 'parte2' => $parte2, 'parte3' => $parte3, 'parte4' => $parte4);
                    return $notasAtribuidasBoletim;
                }else{
                    throw new Exception($notas->msg);
                }
            }
        
            if(count($notas) > 0){
                foreach($notas as $key => $nota){
                    switch($nota){
                        case $nota->st_parte == 1: $parte1[] = $nota; break;
                        case $nota->st_parte == 2: $parte2[] = $nota; break;
                        case $nota->st_parte == 3: $parte3[] = $nota; break;
                        case $nota->st_parte == 4: $parte4[] = $nota; break;
                    }
                }
            }
            
            $notasAtribuidasBoletim = array('parte1' => $parte1, 'parte2' => $parte2, 'parte3' => $parte3, 'parte4' => $parte4);
            
            return $notasAtribuidasBoletim;

        }catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    public function getNotasAtribuidasBoletimComPolicial($idBoletim) {
        try{
            $api = new ApiRestGeneric();
            $response = $api->get("boletins/".$idBoletim."/notascompolicial");
            $notas = $api->converteStringJson($response);
            if(isset($notas->retorno)){
                throw new Exception($notas->msg);
            }
            return $notas;

        }catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
    }













    
    //Entra com o tipo do boletim e a unidade do policial
    //Retorna o tipo de capa
    public function getCapaBoletim($idTipoBoletim, $idUnidade){
        try{
            $api = new ApiRestGeneric();
            $request = $api->get("boletins/" . $idTipoBoletim . "/unidade/" . $idUnidade . "/capa/get");
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::BOLETIM_CAPA_NAO_ENCONTRADA){
                    return '';
                }
                throw new Exception($objeto->msg);
            }
            return $objeto;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    //Entra com o id da capa
    //Retorna a capa registrado no banco capas
    public function getCapaId($id){
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("boletins/capaboletim/".$id);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                throw new Exception($objeto->msg);
            }
            return $objeto;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    //Entra com o formulario para atualização da capa
    //Retorna mensagem de sucesso ou erro
    public function updateCapaBoletim($dadosForm, $idCapa){
        try{
            $api = new ApiRestGeneric();
            $request = $api->put("boletins/capaboletim/" . $idCapa . "/atualiza", $dadosForm);
            $response = $api->converteStringJson($request);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    //Entra com o formulario para criação da capa
    //Retorna mensagem de sucesso ou erro
    public function createCapaBoletim($idTipoBoletim, $idUnidade, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("boletins/" . $idTipoBoletim . "/unidade/" . $idUnidade . "/capa/cadastro", $dadosForm);
            $response = $api->converteStringJson($request);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    /* Busca dados nescessário para montar pdf do boletim
    * entrada id do boletim
    * retorno dados
    * @higormelo
    */
    public function visualizaBoletim($idBoletim)
    {
        try {
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("boletins/visualiza/".$idBoletim);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                throw new Exception($objeto->msg);
            }
            return $objeto;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }

}

?>