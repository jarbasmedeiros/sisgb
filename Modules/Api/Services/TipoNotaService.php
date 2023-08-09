<?php
    namespace Modules\Api\Services;
    use App\utis\Status;
    use Auth;
    use DB;
    use Illuminate\Support\Facades\Request;
    use App\utis\MyLog;
    use App\utis\ApiRestGeneric;
    use App\utis\LengthAwarePaginatorConverter;
    use App\utis\Msg;
    use Modules\Boletim\Entities\Nota;
    use Modules\Boletim\Entities\Tiposnota;
    use Exception;


    class TipoNotaService 
    {
    
        /* 
        * @falecomjazon - #461
        * lista os policiais conforme o tipo de nota
        * entradas: tipoNota, matrículacpf
        * retorno lista de policiais compatível com o tipo de nota
        */
        public function listarPolicialParaCadaTiponota($dadosDaNota)
        {
            try {
               //return($dadosDaNota);
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("tiposnotas/listarpolicialparacadatiponota",$dadosDaNota);
             
               // $response = $api->converteStringJson($request);
                return($request);
               
               // throw new Exception($response->msg);                    
                //Verificação se houve erro na requisição
              /*   if(isset($response->retorno) && $response->retorno=="erro"){                  
                } */
            }catch(\Exception $e){
                throw new Exception('erro inesperado: '.$e->getMessage());
            }
            
        }
        /* 
        * @falecomjazon - #461
        * add policiais conforme o tipo de nota
        * entradas: tipoNota, matrículacpf
        * retorno lista de policiais compatível com o tipo de nota
        */
        public function addPolicialParaCadaTipoNota($dadosDaNota)
        {
            try {
               //return($dadosDaNota);
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("tiposnotas/addpolicialparacadatiponota",$dadosDaNota);
             
               // $response = $api->converteStringJson($request);
                return($request);
               
               // throw new Exception($response->msg);                    
                //Verificação se houve erro na requisição
              /*   if(isset($response->retorno) && $response->retorno=="erro"){                  
                } */
            }catch(\Exception $e){
                throw new Exception('erro inesperado: '.$e->getMessage());
            }
            
        }
        /* 
        * @falecomjazon - #461
        * exclui os policiais conforme o tipo de nota
        * entradas: tipoNota, matrículacpf
        * retorno lista de policiais compatível com o tipo de nota
        */
                        
        public function delPolicialParaCadaTipoNota($dadosDaNota)
        {
            try {
               //return($dadosDaNota);
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("tiposnotas/delpolicialparacadatiponota",$dadosDaNota);
             
               // $response = $api->converteStringJson($request);
                return($request);
               
               // throw new Exception($response->msg);                    
                //Verificação se houve erro na requisição
              /*   if(isset($response->retorno) && $response->retorno=="erro"){                  
                } */
            }catch(\Exception $e){
                throw new Exception('erro inesperado: '.$e->getMessage());
            }
            
        }
     
      
        /* 
        * @falecomjazon - #461
        * listar os policiais conforme o tipo de nota
        * entradas: tipoNota, matrículacpf
        * retorno lista de policiais compatível com o tipo de nota
        */
        public function atualizarNotaParaCadaTipoNota($dadosDaNota)
        {
            try {
               //return($dadosDaNota);
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("tiposnotas/atualizarparacadatiponota",$dadosDaNota);
             
                $response = $api->converteStringJson($request);
                dd($response);
                //Verificação se houve erro na requisição
                if(isset($response->retorno) && $response->retorno=="erro"){                  
                    throw new Exception($response->msg);                    
                } 
                return($response);
               
            }catch(\Exception $e){
                throw new Exception('erro inesperado: '.$e->getMessage());
            }
            
        }
      
      
      
      
      
      


















      
      
      
      
      
      
      
      
        public function addpolicialparacadatiponota11($idNota, $idPolicial){
            try {
                $api = new ApiRestGeneric();
                $insert = $api->post("notas/".$idNota."/policial/".$idPolicial."/atribuicao");
              
                $response = $api->converteStringJson($insert);
                if(isset($response->retorno)){
                    if($response->retorno == 'erro'){
                        throw new Exception($response->msg);
                    }else{
                        return 1;
                    }
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }
        public function atribuiNotasAoBoletim($boletim, $nota, $parteDoboletim) 
        {

            $dados = ['nu_parte' => $parteDoboletim, 'idUsuario' => Auth::User()->id];

            try{
                // Cria a tabela de relacionamento
                $api = new ApiRestGeneric();
                $create = $api->put("boletins/".$boletim->id."/notas/".$nota->id."/atribuicao", $dados);
                $response = $api->converteStringJson($create);

                if($response->retorno == "sucesso"){
                    // Altera o status da nota para atribuida
                    $atribuiNota =  $this->alteraStatusNota($nota, Status::NOTA_ATRIBUIDA);
                    return $atribuiNota;
                } else{
                    throw new Exception($response->msg);
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
            
        }

        public function removeNotasDoboletim($idBoletim, $idNota, $dados) {
            try{
                // Deleta a linha da tabela de relacionamento
                $api = new ApiRestGeneric();
                $remove = $api->delete("boletins/".$idBoletim."/notas/".$idNota."/remocao", $dados);
                $response = $api->converteStringJson($remove);
                
                if($response->retorno != "sucesso"){
                    throw new Exception($response->msg);
                } 
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
            
        }

        public function alteraParteNotasDoboletim($idBoletim, $idNota, $topico) {
            try{
                $api = new ApiRestGeneric();
                $altera = $api->put("boletins/".$idBoletim."/notas/".$idNota."/parte/".$topico);
                $response = $api->converteStringJson($altera);
                if($response->retorno != "sucesso"){
                    throw new Exception($e->getMessage());
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
            
        }
        public function getNotaId($idNota) {
            try{
                $api = new ApiRestGeneric();
                $response = $api->get("notas/".$idNota);
                $nota = $api->converteStringJson($response);
                if(isset($nota->retorno)){
                    throw new Exception($nota->msg);
                }
                return $nota;
            }catch(Exception $e){
               throw new Exception($e->getMessage());
            }
        }
    
        public function alteraStatusNota($objetoNota, $status){
            $api = new ApiRestGeneric();
            $request = $api->put("notas/".$objetoNota->id);
            $alteraStatus = $api->converteStringJson($request);
            return $alteraStatus;
        }
   
        // Lista todos tipos de notas
        // Saída - lista todos os campos [id, st_tipo, st_descricao, st_sigla] de tiposnotas
        public function getTiposNotas() {
            try{
                $api = new ApiRestGeneric();
                $response = $api->get('notas/tiposnotas');
                $tipos = $api->converteStringJson($response);
                
                //dd($tipos);
                if(isset($tipos->retorno)){
                    if($tipos->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $tipos;
                }catch(Exception $e){
                    throw new Exception($e->getMessage());
                }
        }
        // busca o tipo de nota pelo id
        // Saída - lista todos os campos [id, st_tipo, st_descricao, st_sigla, st_tela] de tiposnotas
        public function getTiposNotaId($idTipoNota) {
            try{
                $api = new ApiRestGeneric();
                $response = $api->get('notas/tiposnotas/'.$idTipoNota);
                $tipoNotas = $api->converteStringJson($response);
                
                if(isset($response->retorno)){
                        return $response->msg;
                    }
                return $tipoNotas;
                }catch(Exception $e){
                    throw new Exception($e->getMessage());
                }
        }

        // Retorna nu_sequencial para uma nova nota
        // Saída - inteiro seguinte ao ultimo sequencial cadastrado
        public function getNovoSequencial($ano) {
            $tipos = Nota::where('nu_ano', $ano)->select('nu_sequencial')->latest('id')->first();
            return $tipos['nu_sequencial'] + 1;
        }
        /**
         * Vincula nota a uma atividade do cronogra de processo de promoção
         * Entrada: id da atividade
         * Saída: True ou false
         */
        public function vinculaNotaAtividade($idAtividade, $idNota) {
            $atividade = Cronograma::find($idAtividade)->update([
                'ce_nota' => $idNota
            ]);
          
            return  $atividade;
        }

        /***
         * Cria Nota
         * entrada: array com dados do form
         * retorno: true ou false
         */
        public function criarNota($dadosForm){
        
        try
        {
                $api = new ApiRestGeneric();
                $request = $api->post("notas", $dadosForm);
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

        /***
         * Cria Nota com Policial
         * entrada: array com dados do form e o id do policial a ser adicionado
         * retorno: o json da nota ou false
         */
        public function criarNotaComPolicial($dadosform, $idPolicialParaNota){
            DB::beginTransaction();
            try{
                // adiciona o nu_sequencial mais atualizado
                $dadosform['nu_sequencial'] = $this->getNovoSequencial();
                // cria a nota
                $create = Nota::create($dadosform);
                if($create->exists){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($create->id, Auth::user()->id, $create->st_status, 'Criou a Nota.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Insert";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Criou uma Nota';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                        $adicionarPolicialAnota = $this->vincularPolicialNota($create->id, $idPolicialParaNota);
                        if($adicionarPolicialAnota->exists){
                            //retorna o objeto policial em formato json
                            $jsonPolicial = json_decode($create, true);
                        } else{
                            DB::rollback();
                            return false;
                        }
                    } else{
                        DB::rollback();
                        return false;
                    }
                } else{
                    DB::rollback();
                    return false;
                }
            } catch(Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return $jsonPolicial;
        }

        /***
         * Atualiza Nota
         * entrada: array com dados do form e o objeto nota a ser utilizada
         * ataíde
         * retorno: true ou false
         */
        public function atualizarNota($dadosForm, $nota){
         //  dd('aqui');
            $dadosForm['idUsuario'] = Auth::User()->id;
         //  dd('chegou');
            try{
                // atualiza a nota
                $api = new ApiRestGeneric(); 
                $update = $api->put("notas/".$nota->id, $dadosForm);
                //dd($update);
                $objeto = $api->converteStringJson($update);
                dd($objeto);
                if($objeto->retorno == 'sucesso'){
                    return $objeto->msg;
                    
                }else{
                    //retorno de sucesso
                    throw new Exception($objeto->msg);
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        // Lista todas as notas em elaboração na unidade
        // Saída - lista as notas com todos os seus campos
        public function listaNotasParaAtribuir($idUnidade, $idBoletim) {
            try
            {
            $api = new ApiRestGeneric(); 
            $response = $api->get("notas/unidade/".$idUnidade."/boletim/".$idBoletim);
            $objeto = $api->converteStringJson($response);
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
        public function listaNotas($idUnidade) {
            try
            {
            $api = new ApiRestGeneric(); 
            $notas = $api->get("notas/unidade/".$idUnidade."/paginado?".Request::getQueryString());
            //dd($notas);
            $objeto = $api->converteStringJson($notas);
            
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
        // Lista todas as notas em enviadas para a unidade
        // Saída - lista as notas com todos os seus campos
        public function notasEnvidasParaBg() {
            try
            {
            $api = new ApiRestGeneric(); 
            $notas = $api->get("notas/enviadaparabg/paginado?".Request::getQueryString());
            $objeto = $api->converteStringJson($notas);
            //dd($objeto);
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

        // Deleta a Nota ----- Alterar apenas o bo_ativo futuramente
        // Entrada - Objeto Nota a ser deletado
        // Saída - true ou false
        public function deletaNota($idNota, $dados){
            try{
                
                $api = new ApiRestGeneric(); 
                $deleta = $api->delete("notas/".$idNota, $dados);
                $objeto = $api->converteStringJson($deleta);

                if(isset($objeto->retorno)){
                    if($objeto->retorno == 'sucesso'){
                        
                        return $objeto->msg;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        // Deleta a Nota ----- Alterar apenas o bo_ativo futuramente
        // Entrada - Objeto Nota a ser deletado
        // Saída - true ou false
        public function excluirNotaProcesso($idNota, $dadosForm){
            try{
               // dd($idNota);
              // dd($dadosForm);
                $api = new ApiRestGeneric(); 
              //  $request = $api->post("notas", $dadosForm);
                $request = $api->post("notasprocesso/excluir/".$idNota, $dadosForm);
               // dd($request);
                $response = $api->converteStringJson($request);
                //dd($response);
                if(isset($response->retorno)){
                    if($response->retorno == 'sucesso'){
                        return $response->msg;
                    }else{
                        throw new Exception($response->msg);
                    }
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        
      
        // CORRIGE NOTA - Retorna a Nota para correção
        // entrada objeto nota
        // ataíde
        // retorno true ou false
        public function corrigeNota($nota) {
            
            try{
                // retorna a nota para correção
                $dados = ['idUsuario' => Auth::User()->id];
                $api = new ApiRestGeneric(); 
                $corrige = $api->put("notas/".$nota->id."/retornaedicao", $dados);
                $objeto = $api->converteStringJson($corrige);
               
                if(isset($objeto->retorno)){
                    if($objeto->retorno == 'sucesso'){
                        return $objeto->msg;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }   
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

         /**
          * Finalizar edição da nota
        * @author: Jazon #290
        */
        public function finalizarEdicaoNota($idNota,$idUsuario) {            
            try{
                $api = new ApiRestGeneric(); 
                $request = $api->put("notas/".$idNota."/finalizanota/usuario/".$idUsuario);
                //dd($request);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->retorno == 'sucesso'){
                        return $response->msg;
                    }else{
                        throw new Exception($response->msg);
                    }
                }   
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        // ASSINA NOTA
        // entrada objeto nota
        // retorno true ou false
        //@autor: Ataide
        public function assinarNota($idNota, $dados) {
            
            try{
                $dados['st_cpf'] = Auth::User()->st_cpf;
                $api = new ApiRestGeneric(); 
                $notas = $api->put("notas/".$idNota."/assinatura", $dados);
                $objeto = $api->converteStringJson($notas);
                if(isset($objeto->retorno)){
                    if($objeto->retorno == 'sucesso'){
                        return $objeto->msg;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }   
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        // ENVIA NOTA
        // entrada objeto nota
        // retorno true ou false
        public function enviarNota($nota) {
            
            try{
                $dados = ['idUsuario' => Auth::User()->id];
                // Assina a nota
                $api = new ApiRestGeneric(); 
                $enviar = $api->put("notas/".$nota->id."/envia/bg", $dados);
                $objeto = $api->converteStringJson($enviar);
                
                if(isset($objeto->retorno)){
                    if($objeto->retorno == 'sucesso'){
                        return $objeto->msg;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        // RECUSAR NOTA
        // entrada objeto nota
        // retorno true ou false
        public function recusarNota($dadosform, $nota) {
            try{
                // Assina a nota
                $api = new ApiRestGeneric(); 
                $devolve = $api->put("notas/".$nota->id."/devolve/unidade", $dadosform);
                $objeto = $api->converteStringJson($devolve);
                if(isset($objeto->retorno)){
                    if($objeto->retorno == 'sucesso'){
                        return $objeto->msg;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }                
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
            
        }

        // ACEITA NOTA
        // entrada objeto nota
        // retorno true ou false
        public function aceitarNota($nota) {
            
            try{
                // Assina a nota
                $dados = ['idUsuario' => Auth::User()->id];
                $api = new ApiRestGeneric(); 
                $aceitar = $api->put("notas/".$nota->id."/recebe/boletim", $dados);
                $objeto = $api->converteStringJson($aceitar);
                //dd($objeto);
                if(isset($objeto->retorno)){
                    if($objeto->retorno == 'sucesso'){
                        return $objeto->msg;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }                
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        
        }

        // PUBLICA NOTA
        // entrada objeto nota
        // retorno true ou false
        public function publicarNota(Nota $nota) {
            $retornaNota = $nota->update([
                'st_status'=> Status::NOTA_PUBLICADA
            ]);
            return $retornaNota;
        }

        //Entra com o id da nota
        //Saída - lista os históricos das notas com todos os seus campos array
        public function getHistoricoNota($idNota){
            try
            {
                    $api = new ApiRestGeneric();
                    $request = $api->get("notas/".$idNota."/historico");

                    //Verificação se houve erro na requisição
                    if(isset($request->retorno)){
                        if($request->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                            return [];
                        }else{
                            throw new Exception($v->msg);
                        }
                    }
                    $response = $api->converteStringJson($request);
                    return $response;
                } catch(Exception $e){
                    throw new Exception($e->getMessage());
                }
        }

        // CRIA HISTÓRICO DE NOTA
        // entrada id da nota, id do usuário, status da nota, mensagem
        // retorno true ou false
        public function createHistoricoNota($notaId, $userId, $status, $msg){
            $api = new ApiRestGeneric();
            $create = $api->
            $create = Historiconota::create([
                'ce_nota' => $notaId,
                'ce_usuario' => $userId,
                'st_status' => $status,
                'st_msg' => $msg,
            ]);
            return $create;
        }

        // CRIA HISTÓRICO DE NOTA
        // entrada id da nota, id do usuário, status da nota, mensagem
        // retorno true ou false
        public function createHistoricoNotaComObs($notaId, $userId, $status, $msg, $obs){
            $create = Historiconota::create([
                'ce_nota' => $notaId,
                'ce_usuario' => $userId,
                'st_status' => $status,
                'st_msg' => $msg,
                'st_obs' => $obs,
            ]);
            return $create;
        }

        // Busca Policial para atribuir a nota de boletim
        // entrada cpf ou motrícula
        // ataide
        // retorno objeto policial ou nulo
        public function listaPoliciaisDaNota($idNota){
            try{
                
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("notas/".$idNota."/policiais/listagem");
               
                $objeto = $api->converteStringJson($request); 
                
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

        public function getPoliciaisDaNota($idNota){
            try{
                
                $api = new ApiRestGeneric();
                // Requisição para API
                $dadoPolicial = Auth::User()->st_cpf;
                
                $request = $api->get("notas/".$idNota."/policiais/listagem/paginado?".\Request::getQueryString());
              
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
        // Vincula um policial a uma nota de boletim
        // entrada id da nota e id do policial
        // retorno true ou false
        public function vincularPolicialNota($idNota, $idPolicial) {
            $vinculaPolicialNota = Policiaisdasnota::create([
                    'ce_nota' => $idNota,
                    'ce_policial' => $idPolicial,
            ]);
           
            return $vinculaPolicialNota;
        }

        
        /* Para busca um policial específico vinculado a uma nota de boletim
        * entrada id da nota e id do policial
        * retorno objeto policial
        * ataíde
        */
        public function removerPolicialDaNota($idNota, $idPolicial){
            try {
                    $api = new ApiRestGeneric();
                    // Requisição para API
                    $removepolicial = $api->delete("notas/".$idNota."/policial/".$idPolicial."/remocao");
                    $response = $api->converteStringJson($removepolicial); 
                    
                    if(isset($response->retorno)){
                        if($response->retorno == 'sucesso'){
                            return 1;
                        }else{
                            return 0;
                        }
                    }
                } catch(Exception $e){
                    throw new Exception($e->getMessage());
                }
            
        }
        
        /* Busca dados nescessário para montar pdf da nota
        * entrada id da nota
        * retorno dados
        * @higormelo
        */
        public function visualizaNota($idNota)
        {
            try {
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("notas/visualiza/".$idNota);
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
        /* 
        * @falecomjazon - #286
        * listar os policiais conforme o tipo de nota
        * entradas: tipoNota, matrículacpf
        * retorno lista de policiais compatível com o tipo de nota
        */
        public function listarPolicialParaCadaTipoNotas($dadosDaNota)
        {
            try {
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("tiposnotas/listarpolicialparacadatiponota?".Request::getQueryString(),$dadosDaNota);
                //dd($request);
                $response = $api->converteStringJson($request);
                 //dd($response);
                //Verificação se houve erro na requisição
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                       return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                 if(isset($dadosDaNota['bo_paginado'])){
                    $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
                    return $paginator;
                }else{ 
                    return $response;
                }

            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
            
        }
      

        /* 
        * @falecomcbaraujo - #84-981346783
        * feito dia 20/10/2021
        * jason deve continuar este service que já recebe os dados do form
        */
        public function addPoliciaisEmLoteParaCadaTipoNota($dadosDaNota)
        {
            try {
                $api = new ApiRestGeneric();

                // Requisição para API
                $request = $api->post("tiposnotas/addpolicialparacadatiponota",$dadosDaNota);
                
                //dd($request);
                
                $response = $api->converteStringJson($request);
                //$response = json_decode($request);
                //dd('sedsdrdrdrdre');
                //dd($response);
                //Verificação se houve erro na requisição
                if(isset($response->retorno) && $response->retorno=="erro"){                  
                    throw new Exception($response->msg);
                } 
                //return "lalala";
                return $response->msg;
            }catch(\Exception $e){
                //dd($e);
                throw new Exception($e->getMessage());
            }            
        }        

        /* 
        * @falecomjazon - #286
        * listar os policiais conforme o tipo de nota
        * entradas: tipoNota, matrículacpf
        * retorno lista de policiais compatível com o tipo de nota
        */
        public function delPolicialParaCadaTipoNotas($dadosDaNota)
        {
            try {
             //   dd($dadosDaNota);
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("tiposnotas/delpolicialparacadatiponota",$dadosDaNota);            
                return($request);
                $response = $api->converteStringJson($request);
               // throw new Exception($response->msg);                    
                //Verificação se houve erro na requisição
              /*   if(isset($response->retorno) && $response->retorno=="erro"){                  
                } */
                return $response;
            }catch(\Exception $e){
                throw new Exception('erro inesperado: '.$e->getMessage());
            }
            
        }


        /* 
        *refatorado por cb Araujo : 84-981346783 #381
        * @falecomjazon - #286
        * listar os policiais conforme o tipo de nota
        * entradas: tipoNota, matrículacpf
        * retorno lista de policiais compatível com o tipo de nota
        */
        public function delPolicialEmLoteParaCadaTipoNotas($dadosDaNota)
        {
            try {
             //   dd($dadosDaNota);
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("tiposnotas/delpolicialparacadatiponota",$dadosDaNota);            
                return($request);
                $response = $api->converteStringJson($request);
               // throw new Exception($response->msg);                    
                //Verificação se houve erro na requisição
              /*   if(isset($response->retorno) && $response->retorno=="erro"){                  
                } */
                return $response;
            }catch(\Exception $e){
                throw new Exception('erro inesperado: '.$e->getMessage());
            }
            
        }

        /* 
        * @falecomjazon - #356
        * listar as notas tramitadas para a unidade do usuário logado
        * entradas: cpf do usuário logado
        * retorno lista de notas
        */
        public function getNotasTramitadas($cpf)
        {
            try {
                //dd($dadosDaNota);
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("notas/tramitadas/".$cpf);
                //dd($request) ;           
                $response = $api->converteStringJson($request);
               // dd($response);
               // throw new Exception($response->msg);                    
                //Verificação se houve erro na requisição
                /*  if(isset($response->retorno)){
                    throw new Exception($response->msg);
                } 
                return $response; */
                 if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                       return [];
                    }else{
                       throw new Exception($response->msg);
                    }
                } 
                return $response;
            }catch(\Exception $e){
                throw new Exception('erro inesperado: '.$e->getMessage());
            }
            
        }
        /* 
        * @falecomjazon - #356
        * devolver uma nota tramitadas para a unidade de origem dela
        * retorno sucesso ou erro
        */
        public function devolverNotaTramitada($dadosForm)
        {
            try {
               // dd($dadosForm);
                $api = new ApiRestGeneric();
                // Requisição para API  
                $request = $api->post("notas/devolvertramitadas",$dadosForm);            
               // dd($request);
                $response = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($response->retorno) && $response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg; 

                
            }catch(\Exception $e){
                throw new Exception($e->getMessage());
            }
            
        }
        /* 
        * @falecomjazon - #356
        * tramita uma nota de uma unidade para outra
        * retorno sucesso ou erro
        */
        public function tramitarNota($dadosForm)
        {
            try {
                
                $api = new ApiRestGeneric();
                // Requisição para API  
                $request = $api->post("notas/tramitar",$dadosForm);            
                $response = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($response->retorno) && $response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg; 
            }catch(\Exception $e){
                throw new Exception($e->getMessage());
            }
            
        }




    }

?>