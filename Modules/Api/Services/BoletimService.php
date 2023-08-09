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

    class BoletimService extends Controller {

        public function __construct(NotaService $NotaService, PolicialService $policialService, UnidadeService $unidadeService){
            $this->middleware('auth');
            $this->NotaService = $NotaService;
            $this->policialService = $policialService;
            $this->unidadeService = $unidadeService;
            //$this->api = new ApiRestGeneric();
        }

    
    /***
     * Lista todos os boletins gerais
     * retorno: Lista todos os boletins gerais em elaboração
     * @autor: Jazon #363
     */
    public function getBGElaboracao() {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("boletins/bg/elaboracao");
            
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
    /***
     * Lista todos os boletins publicados
     * entrada: não tem
     * retorno: Lista todos os boletins publicados
     * @autor: Talysson
     */
    public function listaBoletimPublicados() {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("boletins/bg/publicados/paginados?".Request::getQueryString());
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
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    /***
     * Lista todos as unidades operacionais
     * entrada: não tem
     * retorno: Lista de todas as unidades
     * @autor: Talysson
     */
    public function listaUnidadesOperacionais() {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("unidades/naopaginado");
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

    /***
     * Lista todos os boletins publicados de acordo com os critérios de busca
     * entrada: Critérios de busca
     * retorno: Lista todos os boletins publicados
     * @autor: Talysson
     */
    public function findBoletinsPublicadosPaginado($dadosForm) {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            if(isset($dadosForm['page'])){
                $dados = Session::get('dadosForm');
                $request = $api->get("boletins/busca/publicados/paginados?".Request::getQueryString()."&", $dados);
            }else{
                $request = $api->get("boletins/busca/publicados/paginados?".Request::getQueryString(), $dadosForm);
            }
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
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    public function consultarPolicial($userParam){
        try {
            //code...
            $api = new ApiRestGeneric();
            $request = $api->get("policiais/matricula-cpf/".$userParam);
            $response = $api->converteStringJson($request);
            //dd($response);
            if(!isset($response->retorno)){
                //dd($response);
                return $response;
            }else{
                //dd($response->msg);
                //return 1;
                return 1;   
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }


        //Lista os boletins pendentes abertos na unidade
    public function lista_boletim_pendente($idUnidade){
            //
        try{
            if(empty($idUnidade)){
                throw new Exception('Informar unidade dos boletins');                 
            }
            $api = new ApiRestGeneric();
            $request = $api->get("boletins/unidade/".$idUnidade."/elaboracao");
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

    // Lista todos os boletins em elaboração na unidade
    // Saída - lista de boletins com todos os seus campos

    public function atribuirNotaAoBoletim($idBoletim, $idNota, $topico){
        $data = ['ce_topico' => $topico, 'idUsuario' => Auth::User()->id];
        try{
            $api = new ApiRestGeneric();
            $request = $api->put("boletins/".$idBoletim."/notas/".$idNota."/atribuicao", $data);
            $response = $api->converteStringJson($request);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);   
                        
            }
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }


    /* Lista todos tipos de boletins
     * Saída - lista os campos [id, st_tipo, st_descricao, st_sigla] de tiposboletins
     * Refatorado: Talysson
     */
    public function gettiposboletins() {
        try{
            $api = new ApiRestGeneric();
            $request = $api->get("boletins/tiposboletim");
            $response = $api->converteStringJson($request);
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }
    /***
     * Cria Boletim
     * entrada: id do tipo do boletim, data do boletim e id da unidade do boletim
     * retorno: true ou false
     * Correção: Ataíde
     */
    public function criarBoletim($dadosForm, $unidadeboletim){
        
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("boletins/unidade/".$unidadeboletim, $dadosForm);
            //dd($create);
            $response = $api->converteStringJson($request);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
        } catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }
   
    /** 
     * BUSCA UM BOLETIM PELO ID
     * /Retorno: Se existe retorna o objeto do boletim; se não existe retorna null
     */
    public function getBoletimId($id) {
        try{
            $api = new ApiRestGeneric();
            $request = $api->get("boletins/".$id);
            $response = $api->converteStringJson($request);
           if(isset($response->retorno)){
                    throw new Exception($response->msg);
            }
            return $response;
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
        
        $api = new ApiRestGeneric();
        $request = $api->put("boletins/".$boletim->id."/assina", $dados);
        //dd($response);
        $response = $api->converteStringJson($request);
        
        return $response;
    }

    /*
    cb Araujo - 07/12/2021
    396-criar-crud-de-tempo-de-servico    
    */
    public function cancelarBoletim($idBoletim, $dados) {
        try{

            $api = new ApiRestGeneric();
            $request = $api->post("boletins/".$idBoletim."/cancelarpublicacao", $dados);
            //dd($request);
            $response = $api->converteStringJson($request);
            //dd($response);
            if(isset($response->retorno)){
                if($response->retorno == "sucesso"){
                    return $response->msg;
                }else{
                    throw new Exception($response->msg);
                }
            }

        } catch(\Exception $e){
            throw new Exception($e->getMessage());
        }        
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
            $request = $api->put("boletins/".$idBoletim."/finaliza");
           
            $response = $api->converteStringJson($request);
            
            if($response->retorno == "sucesso"){
                return $response->msg;
            }else{
                throw new Exception($response->msg);
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
            $request = $api->put("boletins/".$idBoletim."/assina", $dados);
            $response = $api->converteStringJson($request);
            if($response->retorno == "sucesso"){
                return $response;
            }else{
                throw new Exception($response->msg);
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
            $request = $api->put("boletins/".$idBoletim."/devolucao");
            $response = $api->converteStringJson($request);
            
            if($response->retorno != "sucesso"){
                throw new Exception($response->msg);
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
            $request = $api->put("boletins/".$idBoletim."/publica", $dados);
            $response = $api->converteStringJson($request);
            
            if($response->retorno != "sucesso"){
                throw new Exception($response->msg);
            }
            return $response->msg;
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
            $request = $api->delete("boletins/".$idBoletim);
            $response = $api->converteStringJson($request);
            
                if($response->retorno != "sucesso"){
                    throw new Exception($response->msg);
                   
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
        $request = $api->get("boletins/".$idBoletim."/notas");
       
        $response = $api->converteStringJson($request);
            if(count($response) > 0){
                return $response;
            }else{
                return $response = [];
            }
        }catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
        
        return $response;
    }

    public function getTopicosBoletim() {
        try{
            
            $api = new ApiRestGeneric();
            $request = $api->get("boletim/topicos/lista");
            $response = $api->converteStringJson($request);
            if(isset($response->retorno)){
                if($response->msg == MSG::NENHUM_RESULTADO_ENCONTRADO){
                    $response =[];
                    return $response;
                }else{
                    throw new Exception($response->msg);
                }
            }
        
           return $response;

        }catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    public function getNotasAtribuidasBoletim($idBoletim) {
        try{
            $parte1 = array();
            $parte2 = array();
            $parte3 = array();
            $parte4 = array();
            $api = new ApiRestGeneric();
            $request = $api->get("boletins/".$idBoletim."/notas");
            $response = $api->converteStringJson($request);
            if(isset($response->retorno)){
                if($response->msg == MSG::NENHUM_RESULTADO_ENCONTRADO){
                    $notasAtribuidasBoletim = array('parte1' => $parte1, 'parte2' => $parte2, 'parte3' => $parte3, 'parte4' => $parte4);
                    return $notasAtribuidasBoletim;
                }else{
                    throw new Exception($response->msg);
                }
            }
        
            if(count($response) > 0){
                foreach($response as $key => $nota){
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
            $request = $api->get("boletins/".$idBoletim."/notascompolicial");
            $response = $api->converteStringJson($request);
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            return $response;

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
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($response->retorno)){
                if($response->msg == Msg::BOLETIM_CAPA_NAO_ENCONTRADA){
                    $capa = new Capa;
                    $capa ='';
                    return  $capa;
                }
                throw new Exception($response->msg);
            }
            return $response;
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
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            return $response;
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
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            return $response;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }

    public function getListarNotasPorBoletim($idBoletim) {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request= $api->get("boletins/".$idBoletim."/notas");
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

    /**
     * @author juanmojica - #386
     * @param array['st_criterio','st_policial','dt_inicio','dt_fim'] (query) 
     * @return (Lista de publicações com as informações repassadas para pesquisa)
     */
    public function pesquisarBGPratico($dados){
        try {
            
            $api = new ApiRestGeneric();
            //Requisição para API
            $request = $api->post("boletins/bgpratico", $dados);
            $response = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if (isset($response->retorno)) {
                if ($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO) {
                    return [];
                } else {
                    throw new Exception($response->msg);
                } 
            }
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juanmojica - #436
     * @param array['ce_unidadeorigem', 'ce_unidadedestino'] (query) 
     * @return (mensagem de sucesso ou erro)
     */
    public function moverBoletim($dadosForm){
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("boletins/movimentacao/unidade", $dadosForm);
            $response = $api->converteStringJson($request);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }


}

?>