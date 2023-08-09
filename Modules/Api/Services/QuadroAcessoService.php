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

class QuadroAcessoService  
{
    // busca o Quadro de Acesso pelo id
    // Saída - Objeto Quadro de Acesso
    public function getQuadroAcessoId($id) {
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("qa/".$id);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    throw new Exception(Msg::QA_NAO_ENCONTRADO);
                }else{
                    throw new Exception($objeto->msg);
                }
            }
            return $objeto;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    
    // Lista os Quadros de Acesso pelo id
    // Saída - Obejto Quadro de Acesso
    public function listaQuadroAcesso($competencia) {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("qa/competencia/".$competencia."?".Request::getQueryString());
            $objeto = $api->converteStringJson($request);
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($objeto->msg);
                }
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($objeto, url()->current());
            return $paginator;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    // criar Quadro de Acesso
    // Saída - Obejto Quadro de Acesso
    public function createQuadroAcesso($dados) {
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("qa", $dados);
            $response = $api->converteStringJson($request);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    /**
     *  Editar  Quadro de Acesso
     *  id do quadro e os dados do quadro atualizados
     *  Saída - true ou false
     */
    public function updateQuadroAcesso($id, $dados) {
        try{
            $api = new ApiRestGeneric();
            $request = $api->put("quadrosacessos/".$id, $dados);
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
     * Método para exibir quantitativo de vagas por QPMP e Graduações.
     *
     */
    public function getQuantitativoDeVagas(){
        try{
            $qpmps = DB::table('rh.qpmps as q')
                ->join('promocao.vagas as v', 'v.ce_qpmp', 'q.id')
                ->join('rh.graduacoes as g', 'g.id', 'v.ce_postograduacao')
                ->select('v.id', 'q.id as idQuadro', 'q.st_qpmp', 'q.st_descricao', 'g.id as idGraduacao', 'g.st_postograduacao', 'v.nu_vagasprevistas')
                ->orderBy('q.id', 'ASC')
                ->orderBy('v.ce_postograduacao', 'DESC')
                ->get();
                $vagas = [];
                foreach($qpmps as $q){
                    $totalPorGraduacao = DB::table('rh.policiais')->where([['ce_qpmp', $q->idQuadro],['ce_graduacao', $q->idGraduacao]])->count();
                    $totalPorGraduacaoAagregado = DB::table('rh.policiais')->where([['ce_qpmp', $q->idQuadro],['ce_graduacao', $q->idGraduacao],['ce_situacao', 3]])->count();                  
                    $q->nu_vagasexistente = $totalPorGraduacao;
                    $q->nu_agragados = $totalPorGraduacaoAagregado;

                    if($q->nu_vagasprevistas >= $q->nu_vagasexistente){

                        $q->nu_claro = $q->nu_vagasprevistas - $q->nu_vagasexistente;
                        $q->nu_excedente = 0;
                    }else{
                        $q->nu_claro = 0;
                        $q->nu_excedente = $q->nu_vagasexistente -  $q->nu_vagasprevistas;
                    }
                    if(($q->nu_claro + $q->nu_agragados) > $q->nu_excedente){
                        $q->nu_vagas = ($q->nu_claro + $q->nu_agragados) - $q->nu_excedente;
                    }else{
                        $q->nu_vagas = 0;
                    }
                    $vagas[] = $q;
                }
            return $vagas;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
       /**
     * Método para atualizar quantitativo de vagas.
     * Entrada: array de dados onde chave equvile ao id da vaga e valor o novo valor a ser persistido no banco para a vaca
     * Saída: true ou false
     *
     */ 
    public function atualizaQuantitativoDeVagas($dados)
    {
        try{
            foreach($dados as $key =>$valor){
                if($key != '_token'){
                    $atualiza = Vaga::find($key)->update([
                        'nu_vagasprevistas' => $valor
                        ]);
                }
            }
            return $atualiza;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }



        /**
         * busca um Policial específico no Quadro de Acesso pelo id
         * Entrada: id do Policial e id do Quadro
         * Saída - Obejto Quadro de Acesso
         */
        // 
        public function GetPolicialQuadroId($idQuadro, $idPolicial) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/policiais/".$idPolicial);
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return null;
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
         * Busca o número de vagas para uma graduação Quadro de Acesso pelo id
         * Entrada: id do QPMP e id da Graduação
         * Saída - Obejto vagas para graduaçãõ
         */
        // 
        public function GetvagasPorGraduacao($idQpmp, $idGraduacao) {
            try{
            $vagas = DB::table('promocao.vagas')->where([['ce_qpmp', $idQpmp],['ce_postograduacao', $idGraduacao]])->first();
            return $vagas;
               
            } catch(Exception $e){
                
                return $e->getMessage();
            }
    
        }
        /**
         * busca o Cronograma de um Quadro de Acesso pelo id
         * Entrada: id do Quadro
         * Saída -lista de atividades;
         */
        // 
        public function GetCronogramaQuadroId($idQuadro, $competencia) {
            try{

                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/".$idQuadro."/cronogramas/competencia/".$competencia."?".Request::getQueryString());
                $objeto = $api->converteStringJson($request);
                
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        throw new Exception(Msg::CRONOGRAMA_NAO_ENCONTRADO);
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
         * Registra no cronograma do QA uma nova atividade
         * Entrada: id do QA e um Array de dados correspondete ao atributos do cronograma
         * Saída -true ou false;
         */
        // 
        public function adicionarAtividadenoCronograma($idQuadro, $dadosForm) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("quadrosacessos/".$idQuadro."/cronogramas", $dadosForm);
                $objeto = $api->converteStringJson($request);
                if($objeto->retorno != 'sucesso'){
                    throw new Exception($e->getMessage());
                }
                return $objeto;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }               
        }
        /**
         * Registra no cronograma do QA uma nova atividade
         * Entrada: id do QA e um Array de dados correspondete ao atributos do cronograma
         * Saída -true ou false;
         */
        // 
        public function removerAtividadenoCronograma($idAtividade) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->delete("quadrosacessos/cronogramas/".$idAtividade);
                $objeto = $api->converteStringJson($request);
                if($objeto->retorno != 'sucesso'){
                    throw new Exception($e->getMessage());
                }
                return $objeto;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }               
        }
        /**
         * Registra no cronograma do QA a finalização de determinada atividade
         * Entrada: id da Atividade
         * Saída -true ou false;
         */
        // 
        public function concluirAtividade($idAtividade) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->put("quadrosacessos/cronogramas/".$idAtividade."/conclusao");
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno) && $objeto->retorno == "sucesso"){
                    return $objeto->msg;                 
                }else{
                    throw new Exception($objeto->msg);
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * Registra no cronograma do QA a finalização de determinada atividade
         * Entrada: id da Atividade
         * Saída -true ou false;
         */
        // 
        public function concluirAtividadeEfetivo($idAtividade) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->put("quadrosacessos/cronogramas/".$idAtividade."/conclusao/efetivo");
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno) && $objeto->retorno == "sucesso"){
                    return $objeto->msg;                 
                }else{
                    throw new Exception($objeto->msg);
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * Registra no cronograma do QA a finalização de determinada atividade
         * Entrada: id da Atividade
         * Saída -true ou false;
         */
        // 
        public function concluirAtividadeInspecaoJpms($idAtividade) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->put("quadrosacessos/cronogramas/".$idAtividade."/conclusao/jpms");
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno) && $objeto->retorno == "sucesso"){
                    return $objeto->msg;                 
                }else{
                    throw new Exception($objeto->msg);
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * Registra no cronograma do QA a finalização de determinada atividade
         * Entrada: id da Atividade
         * Saída -true ou false;
         */
        // 
        public function concluirAtividadeTaf($idAtividade) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->put("quadrosacessos/cronogramas/".$idAtividade."/conclusao/taf");
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno) && $objeto->retorno == "sucesso"){
                    return $objeto->msg;                 
                }else{
                    throw new Exception($objeto->msg);
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * Busca uma atividade específica pelo id
         * Entrada: id da Atividade
         * Saída -objeto atividade;
         */
        public function getAtividadeId($idAtividade){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/cronogramas/".$idAtividade);
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
        /**
         * listas todos os Policiais vinculados ao um Quadro de Acesso com paginação
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function listaPoliciaisDoQuadro($idQuadro) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/policiais/paginado?".Request::getQueryString());
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
        /**
         * listas todos os sargentos vinculados ao um Quadro de Acesso com paginação
         * Entrada:  id do Quadro e id da unidade
         * Saída - lista de sargentos vinculados ao quadro
         */
        public function listaSgtEscriturarNaoEnviadaPaginado($idQuadro, $idUnidade) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/".$idQuadro."/sgt/naoenviada/unidade/".$idUnidade."/paginado?".Request::getQueryString());
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
        /**
         * listas todos os sargentos vinculados ao um Quadro de Acesso com paginação com a ficha enviada
         * Entrada:  id do Quadro e id da unidade
         * Saída - lista de sargentos vinculados ao quadro
         */
        public function listaSgtEscriturarEnviadaPaginado($idQuadro, $idUnidade) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/".$idQuadro."/sgt/enviada/unidade/".$idUnidade."/paginado?".Request::getQueryString());               
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
        /**
         * consulta um sargentos vinculado ao um Quadro de Acesso
         * Entrada:  id do Quadro e dados de um formulário
         * Saída - lista de sargentos vinculados ao quadro
         */
        public function getSgtCpfMatriculaNome($idQuadro, $dadosForm) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/".$idQuadro."/policiais/".$dadosForm['criterio']."/".$dadosForm['st_filtro']);
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
        /**
         * listas todos os Policiais vinculados ao um Quadro de Acesso Sem paginação
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        public function listaTodosPoliciaisDoQuadro($idQuadro) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/policiais");
                $policiais = $api->converteStringJson($request);
                if(isset($policiais->retorno)){
                    throw new Exception($policiais->msg);
                }
                return collect($policiais);
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * listas todos os Policiais vinculados ao um Quadro de Acesso que serão convocados para inspeção de saúde extraordinária
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        public function listaTodosPoliciaisDoQuadroParaConvocacaoExtra($idQuadro, $idAtividade) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/atividade/".$idAtividade."/convocacaoextrajpms");
                $policiais = $api->converteStringJson($request);
                if(isset($policiais->retorno)){
                    throw new Exception($policiais->msg);
                }
                return collect($policiais);
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * listas Policiais vinculados ao um Quadro de Acesso que não foram inspecionados pala JPMS (realizar inspeção de saúde)
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        //
        public function listaPoliciaisParaInspecaoJPMS($idQuadro) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/juntamedica/efetivo/naoinspecionados/paginado?".Request::getQueryString());
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * Lista os policiais vinculados ao um Quadro de Acesso que para preanalise pala JPMS (realizar preanalise). @aggeu, #254
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        //
        public function listaPoliciaisParaPreanaliseJPMS($idQuadro, $st_situacao) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/juntamedica/efetivo/preanalise/".$st_situacao."/paginado?".Request::getQueryString());
                
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * listas Policiais vinculados ao um Quadro de Acesso que não foram inspecionados pala JPMS (tela policiais inspecionados)
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function listaPoliciaisInspecionadosJPMS($idQuadro) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/juntamedica/efetivo/inspecionados/paginado?".Request::getQueryString());
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * lista todos Policiais vinculados ao um Quadro de Acesso que já foram inspecionados pala JPMS (pdf policiais inspecionados)
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function listarTodosPoliciaisInspecionadosJPMS($idQuadro) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/juntamedica/efetivo/inspecionados");
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                return $policiaisDoquadro;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * listas Soldados vinculados ao um Quadro de Acesso que não foram inspecionados pala JPMS
         * Entrada:  id do Quadro
         * Saída - lista de soldados vinculados ao quadro
         */
        // 
        /* public function listaSdParaConvocarJPMS($idQuadro){
            try{
                $sdDoquadro = Policialdoqa::where([['policiaisdosqas.ce_quadroacesso', $idQuadro], ['policiaisdosqas.st_inspecaojuntaparecer', null], ['st_postgrad', 'SD']])
                ->paginate(30);
                return $sdDoquadro;
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
        public function listaSdParaConvocarAptosJPMS($idQuadro){
            try{
                $sdAptoDoquadro = Policialdoqa::where([['policiaisdosqas.ce_quadroacesso', $idQuadro], ['policiaisdosqas.st_inspecaojuntaparecer', 'Apto'], ['st_postgrad', 'SD']])
                ->paginate(30);
                return $sdDoquadro;
            }catch(Exception $e){
                return $e->getMessage();
            }
        } */



        /**
         * listas Cabos vinculados ao um Quadro de Acesso que Precisam ser inspecionados pala JPMS (tela preparar convocação)
         * Entrada:  id do Quadro. Graduação (SD, CB e SGT)
         * Saída - lista de Cabos vinculados ao quadro
         */
        // 
        public function listaPoliciaisParaConvocarJPMS($idQuadro, $graduacao){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/" . $idQuadro . "/juntamedica/policiais/graduacao/".$graduacao."/paginado?".Request::getQueryString());
                $objeto = $api->converteStringJson($request);
                if(isset($objeto->retorno)){
                    throw new Exception($objeto->msg);
                }
                $paginator['convocar'] = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($objeto->convocar, url()->current());
                $paginator['naoconvocar'] = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($objeto->naoconvocar, url()->current());
                return $paginator;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
      /*   public function listaCbAptoJPMS($idQuadro){
            try{
                $cbAptoDoquadro = Policialdoqa::where([['policiaisdosqas.ce_quadroacesso', $idQuadro], ['policiaisdosqas.st_inspecaojuntaparecer', 'Apto'], ['st_postgrad', 'CB']])
                ->paginate(30);
                return $cbAptoDoquadro;
            }catch(Exception $e){
                return $e->getMessage();
            }
        } */


        /**
         * listas Sagentos vinculados ao um Quadro de Acesso que não foram inspecionados pala JPMS
         * Entrada:  id do Quadro
         * Saída - lista de Sagentos vinculados ao quadro
         */
        // 

        /* public function listaSgtParaConvocarJPMS($idQuadro){
            try{
                $sgtDoquadro = Policialdoqa::where([['policiaisdosqas.ce_quadroacesso', $idQuadro], ['policiaisdosqas.st_inspecaojuntaparecer', null], ['st_postgrad', 'like', '%SGT%']])
                ->paginate(30);
                return $sgtDoquadro;
            }catch(Exception $e){
                return $e->getMessage();
            }
        } */




        /**
         * lista posliciais vinculados ao um Quadro de Acesso considerados aptos pela JPMS Independente da data de inspeção de saúde e que estão precisando de fazer o taf
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function listaPoliciaisParaRealizarTaf($idQuadro){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/" . $idQuadro . "/taf/sgt/naoinspecionados/paginado?".Request::getQueryString());
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /**
         * lista policiais vinculados ao um Quadro de Acesso que realizaram o Taf
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function listaPoliciaisInspecionadosTaf($idQuadro){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/" . $idQuadro . "/taf/sgt/inspecionados/paginado?".Request::getQueryString());
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * lista todos posliciais vinculados ao um Quadro de Acesso que realizaram o Taf
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function listaTodosPoliciaisInspecionadosTaf($idQuadro){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/" . $idQuadro . "/taf/sgt/inspecionados");
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        throw new Exception(Msg:: POLICIAL_NAO_INSPECIONADO);
                    }
                }
                return $policiaisDoquadro;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }


        /**
         * Busca Policiais vinculados ao um Quadro de Acesso por CPF, Matrícula ou nome
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function buscaPolicialDoQuadroPorNomeCpfMatricula($idQuadro, $parametro, $filtro) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/" . $idQuadro . "/policiais/" . $filtro . "/" . $parametro);
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::POLICIAL_INEXISTENTE_NO_QA){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /**
         * Busca Policiais vinculados ao um Quadro de Acesso, que tem ficha de reconhecimento, por CPF, Matrícula ou nome
         * Entrada:  id do Quadro, parametro e filtro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function buscaPolicialDoQuadroParaHomologarPorNomeCpfMatricula($idQuadro, $dadosForm) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("quadrosacessos/" . $idQuadro . "/fichareconhecimento/policiais/paginado", $dadosForm);
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::POLICIAL_INEXISTENTE_NO_QA){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /**
         * Busca policial vinculados ao um Quadro de Acesso por CPF, Matrícula ou nome de acordo com a aba informada
         * Entrada:  id do Quadro, parametro e filtro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
        public function buscaPolicialFichaReconhecimentoAba($idQuadro, $dadosForm) {
            try{

                $api = new ApiRestGeneric();
              
                $request = $api->post("qa/$idQuadro/fichareconhecimento/localizar", $dadosForm);
                
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno)){
                    if($response->msg == Msg::POLICIAL_INEXISTENTE_NO_QA){
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

        /*
        * Busca Policiais vinculados ao um Quadro de Acesso e apto na JPMS  por CPF, Matrícula ou nome (busca para o taf)
        * Entrada:  id do Quadro
        * Saída - lista de policiais vinculados ao quadro
        */
        public function findPmTaf($idQuadro, $dadosForm, $tafInspecionados)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/taf/policiais/".$tafInspecionados."/paginado", $dadosForm);
                // dd($request);
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * Realiza inspeção de saude
         * Entrada:  id do policial no quadro e os dados do formulário da inspeção de saúde
         * Saída - true e false
         */
        // 
        public function inspecaoJuntaParecer($idPolicialNoQuadro, $idQuadro, $dadosForm) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("quadrosacessos/" . $idQuadro . "/juntamedica/policiais/" . $idPolicialNoQuadro, $dadosForm);
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
         * Registra o resultado da pré-análise da JPMS - @aggeu, #254.
         * Entrada:  id do policial no quadro e os dados do formulário da inspeção de saúde
         * Saída - true e false
         */
        // 
        public function realizarpreanalisejpms($idPolicialNoQuadro, $idQuadro, $dadosForm) {
            try{
                $api = new ApiRestGeneric();
                $bo_pendenciapreanalisejpms = $dadosForm["bo_pendenciapreanalisejpms"];
               /*  dd($bo_pendenciapreanalisejpms); */
                $request = $api->put("quadrosacessos/" . $idQuadro . "/policiais/" . $idPolicialNoQuadro. "/preanalise/". $bo_pendenciapreanalisejpms);
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
         * Realiza Taf 
         * Entrada:  id do policial no quadro e os dados do formulário da realização do TAF
         * Saída - true e false
         */
        // 
        public function inspecaoTafParecer($idQuadro, $idPolicialNoQuadro, $dadosForm) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("quadrosacessos/" . $idQuadro . "/taf/policiais/" . $idPolicialNoQuadro, $dadosForm);
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
         * vincula um Policial quadro ao Acesso 
         * Entrada: id do Policial e id do Quadro
         */
        
        // 
        public function vincularPolicialQuadro( $idQuadro, $idPolicial) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->post("quadrosacessos/".$idQuadro."/policiais/".$idPolicial, 'POST');
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno) && $objeto->retorno == "sucesso"){
                    return 1;                 
                }else{
                    if(strpos($objeto->msg, 'SQLSTATE') !== false){
                        throw new Exception(Msg::FALHA_BANCO);
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
         * Remove um Policial quedro ao Acesso 
         * Entrada: id da tabela policiasdosqas referente ao policial
         */
        // 
        public function removerPolicialQuadro($cePolicial, $idQuadroDeAcesso) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->delete("qa/".$idQuadroDeAcesso."/policiais/".$cePolicial);
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno) && $objeto->retorno == "sucesso"){
                    return $objeto->msg;                 
                }else{
                    throw new Exception($objeto->msg);
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }  
        }
       
        /**
         * Atualiza dados da portaria do cronograma - Sendo utilizado inicialmente apenas na convocação para junta médica
         * Entrada: id do cronograma (atividade) e dados do formulario (deve conter apenas qual coluna de portaria e as informações)
         */
        // 
        public function updatePortariaParaCronograma($idAtividade, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->put("quadrosacessos/cronogramas/".$idAtividade."/portaria", $dadosForm);
                $objeto = $api->converteStringJson($request);
                if($objeto->retorno != 'sucesso'){
                    throw new Exception($objeto->msg);
                }
                return $objeto->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /***
         * Cria Nota Para Promoção
         * entrada: array com dados do form
         * retorno: true ou false
         */
        public function criarNota($dadosForm, $idQuadro){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("quadrosacessos/".$idQuadro."/notas/promocao", $dadosForm);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /***
         * Cria Nota PARA CONOVAÇÃO EXTRA
         * entrada: array com dados do form
         * retorno: true ou false
         */
        public function criarNotaConvocacaoExtra($dadosform, $idQuadro, $idAtividade, $idPortaria){
            try
            {
                    $api = new ApiRestGeneric();
                    $request = $api->post("notas/cronograma/".$idAtividade.'/quadro/'.$idQuadro.'/portaria/'.$idPortaria, $dadosform);
                    $response = $api->converteStringJson($request);
                    //Verificação se houve erro na requisição
                    if(isset($response->retorno) && $response->retorno != 'sucesso'){
                            throw new Exception($response->msg);
                    }
                    return 'Nota criada com sucesso.';
                } catch(Exception $e){
                    throw new Exception($e->getMessage());
                }
            }

        /***
         * Cria Nota Para Convocação da jpms
         * entrada: array com dados do form
         * retorno: true ou false
         */
        public function criarNotaConvocacaoJpms($dadosForm, $idQuadro){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("quadrosacessos/".$idQuadro."/notas/promocaoConvocarJpms", $dadosForm);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /***
         * Cria Nota para divulgar quantitativo de vagas de um QA
         * entrada: idQuadro
         * retorno: true ou false
         */
        public function concluiAtividadeQuadroDeVagas($idAtividade, $idQuadro, $dados)
        {
            try{
                $api = new ApiRestGeneric();                                  
                $request = $api->post("quadrosacessos/".$idQuadro."/cronogramas/".$idAtividade."/conclusao/quadrovagas", $dados);
                $response = $api->converteStringJson($request);
                //dd($response);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /***
         * Retorna a ficha de reconhecimento de determinado policial
         * entrada: idQuadro, idPolicial
         * retorno: resultado da consulta
         */
        public function fichaReconhecimento($idQuadro, $idPolicial)
        {
            try{
                $api = new ApiRestGeneric();                                      
                $request = $api->get("qa/" . $idQuadro . "/fichareconhecimento/policial/" . $idPolicial);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                    }
                }
                if (isset($response->pontuacoes) && count($response->pontuacoes) < 1){
                    throw new Exception("Policial não possui pontuação!");
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /***
         * Atualiza as informações da ficha de reconhecimento de um PM em um QA
         * entrada: idQuadro, idPolicial, array
         * retorno: Sucesso ou erro
         */
        public function atualizaFichaReconhecimento($idQuadro, $idPolicial, $dadosFicha)
        {
            try{
                $api = new ApiRestGeneric();                    
                $request = $api->post("qa/" . $idQuadro . "/fichareconhecimento/policial/" . $idPolicial, $dadosFicha);
                //dd($request);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->msg == Msg::ATUALIZADO_SUCESSO){
                        return $response->msg;
                    }
                    throw new Exception($response->msg);                    
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /***
         * Atualiza o recurso da ficha de reconhecimento de um PM em um QA
         * entrada: idQuadro, idPolicial, array
         * retorno: Sucesso ou erro
         */
        public function salvaRecursoFichaReconhecimento($idQuadro, $idPolicial, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();                    
                $request = $api->put("quadrosacessos/" . $idQuadro . "/fichareconhecimento/recurso/policial/" . $idPolicial, $dadosForm);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->msg == Msg::ATUALIZADO_SUCESSO){
                        return $response->msg;
                    }
                    throw new Exception($response->msg);                    
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /***
         * Atualiza a avaliação do recurso da ficha de reconhecimento de um PM em um QA
         * entrada: idQuadro, idPolicial, array
         * retorno: Sucesso ou erro
         */
        public function salvarAnaliseRecurso($idQuadro, $idPolicial, $dadosForm)
        {
            try{
                $api = new ApiRestGeneric();                    
                $request = $api->put("quadrosacessos/" . $idQuadro . "/analiserecurso/policial/" . $idPolicial, $dadosForm);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->msg == Msg::ATUALIZADO_SUCESSO){
                        return $response->msg;
                    }
                    throw new Exception($response->msg);                    
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * finaliza a analise do recurso da ficha de reconhecimento de um PM em um QA
         * entrada: idQuadro, idPolicial, array
         * retorno: Sucesso ou erro
         */
        public function finalizarAnaliseRecurso($idQuadro, $idPolicial)
        {
            try{
                $api = new ApiRestGeneric();                    
                $request = $api->put("quadrosacessos/" . $idQuadro . "/finalizaanaliserecurso/policial/" . $idPolicial);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->msg == Msg::ATUALIZADO_SUCESSO){
                        return $response->msg;
                    }
                    throw new Exception($response->msg);                    
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /**
         * listas todos os sargentos vinculados ao um Quadro de Acesso com paginação
         * Entrada:  id do Quadro e id da unidade
         * Saída - lista de sargentos vinculados ao quadro
         */
        public function listaSgtAnalisarRecursosPaginado($idQuadro, $idUnidade) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/sgt/recursos/naoavaliados/unidade/".$idUnidade."/paginado?".Request::getQueryString());
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
        /**
         * listas todos os sargentos vinculados ao um Quadro de Acesso com paginação com a ficha enviada
         * Entrada:  id do Quadro e id da unidade
         * Saída - lista de sargentos vinculados ao quadro
         */
        public function listaSgtRecursosAvaliadosPaginado($idQuadro, $idUnidade) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/sgt/recursos/avaliados/unidade/".$idUnidade."/paginado?".Request::getQueryString());               
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
        /**
         * Envia a ficha de reconhecimento
         * Entrada:  id da atividade, id do policial do quadro
         * Saída: Sucesso ou erro
         */
        public function enviarFichaEscriturada($idAtividade, $idPolicialNoQuadro) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("qa/atividade/".$idAtividade."/policial/".$idPolicialNoQuadro."/enviarfichaescriturada");            
                $response = $api->converteStringJson($request);
                if (isset($response->retorno)) {
                    if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                    }
                    return $response->msg;
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /***
         * Homologa as informações da ficha de reconhecimento de um PM em um QA
         * entrada: idQuadro, idPolicial
         * retorno: Sucesso ou erro
         */
        public function homologarFichaReconhecimento($idAtividade, $idPolicial, $dadosFicha)
        {
            try{
                $api = new ApiRestGeneric();                                      
                $request = $api->post("qa/atividade/" . $idAtividade . "/homologarfichareconhecimento/policial/" . $idPolicial, $dadosFicha);
                $response = $api->converteStringJson($request);
                if (isset($response->retorno)) {
                    if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                    }
                    return $response->msg;
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /***
         * Homologa as informações da ficha de reconhecimento de um PM em um QA
         * entrada: idQuadro, idPolicial
         * retorno: Sucesso ou erro
         * @autor: Talysson
         */
        public function salvarHomologarFichaReconhecimento($idAtividade, $idPolicial, $dadosFicha)
        {
            try{
                $api = new ApiRestGeneric();                                      
                $request = $api->post("qa/atividade/" . $idAtividade . "/salvarhomologarfichareconhecimento/policial/" . $idPolicial, $dadosFicha);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->msg == Msg::SALVO_SUCESSO){
                        return $response->msg;
                    }
                    throw new Exception($response->msg);                    
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /***
         * @autor: Higor
         * Homologa as informações da ficha de reconhecimento de um PM em um QA
         * entrada: idQuadro, idPolicial
         * retorno: Sucesso ou erro
         */
        public function retornarFichaReconhecimento($idQuadro, $idAtividade, $idPolicial)
        {
            try{
                $api = new ApiRestGeneric();                                      
                $request = $api->put("qa/" . $idQuadro . "/atividade/" . $idAtividade . "/devolverfichareconhecimento/" . $idPolicial);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->msg == Msg::ATUALIZADO_SUCESSO){
                        return $response->msg;
                    }
                    throw new Exception($response->msg);                    
                }
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /***
         * Lista policiais para tem a ficha homologada ou que já foram homologados
         * entrada: idQuadro, st_parametro
         * retorno: Lista de policiais
         */
        public function listaPoliciaisDoQuadroHomologados($idQuadro, $st_parametro) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/".$idQuadro."/sgt/".$st_parametro."/paginado?".Request::getQueryString());
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
         * Lista policiais que não tem a ficha homologada ou que já foram homologados por graduação
         * entrada: idQuadro, (homologada ou naohomologada), graduacao
         * retorno: Lista de policiais
         */
        public function listaPoliciaisDoQuadroHomologadosPorGraduacao($idQuadro, $st_parametro, $graduacao) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/".$idQuadro."/graduacao/".$graduacao.'/parametro/'.$st_parametro."/paginado?".Request::getQueryString());
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
         * Retorna um policial que já foi homologado
         * entrada: idQuadro, idPolicial
         * retorno: Lista o policial
         */
        
        public function findPolicialDoQuadroAcessoById($idQuadro, $idPolicial) {            
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/".$idQuadro."/policiais/".$idPolicial);
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
         * Busca Policiais vinculados ao um Quadro de Acesso por CPF, Matrícula ou nome. Para inspeção do TAF
         * Entrada:  id do QA, parametro e filtro
         * Saída - lista de policiais vinculados ao quadro
         * autor: Talysson
         */
        public function findPmTafNomeCpfMatricula($idQuadro, $parametro, $filtro) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/" . $idQuadro . "/policiais/" . $filtro . "/" . $parametro);
                $policiaisDoquadro = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($policiaisDoquadro->retorno)){
                    if($policiaisDoquadro->msg == Msg::POLICIAL_INEXISTENTE_NO_QA){
                        return [];
                    }else{
                        throw new Exception($policiaisDoquadro->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiaisDoquadro, url()->current());
                return $paginator;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
       /**
         * Retorna o resultado da pesquisa de uma atividade do cronograma a partir do id, fase e sequência informados
         * @autor: Talysson
         * Entrada: id do quadro, nuFase, nuSequencia
         * Saída - um cronograma | Mensagem de erro 
         */
        public function findAtividadeIdFaseSequencia($idQuadro, $nuFase, $nuSequencia) 
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("qa/cronogramas/".$idQuadro."/".$nuFase."/".$nuSequencia);
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

        /**
         * Registra no cronograma do QA uma nova atividade
         * Entrada: id do QA e um Array de dados correspondete ao atributos do cronograma
         * Saída -true ou false;
         */
        // 
       
        /* Autor: @aggeu. Issue 215. */
        public function cadastraPolicialAssinaturaPortaria($idQuadro, $idAtividade, $idPolicial, $dadosForm) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("quadrosacessos/".$idQuadro."/atividade/".$idAtividade."/cadastra/policial/".$idPolicial."/assinatura/portaria", $dadosForm);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }               
        }

        //@autor: Juan Mojica
        // Lista os policiais cadastrados na comissão
        public function getPoliciaisNaComissao($idAtividade){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/atividade/".$idAtividade."/consulta/policiais/assinatura/portaria");
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        /* Autor: @aggeu. Issue 215. */
        public function finalizarPolicialAssinaturaPortaria($idQuadro, $idAtividade, $dadosForm) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("quadrosacessos/".$idQuadro."/atividade/".$idAtividade."/comissao/assinatura/portaria", $dadosForm);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
        
        /* Autor: @aggeu. Issue 215. */
        public function excluiPolicialAssinaturaPortaria($idQuadro, $idAtividade, $idPolicial) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->delete("quadrosacessos/".$idQuadro."/atividade/".$idAtividade."/deleta/policial/".$idPolicial."/assinatura/portaria");
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        //@autor: Juan Mojica
        //Busca uma policial de uma comissão pelo id
        public function getPolicialDaComissao($idQuadro, $idAtividade, $idPolicial){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("quadrosacessos/".$idQuadro."/atividade/".$idAtividade."/consulta/policial/".$idPolicial."/assinatura/portaria");
                $objeto = $api->converteStringJson($request);
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return Msg::NENHUM_RESULTADO_ENCONTRADO;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }


        /* Autor: @aggeu. Issue 215. */
        public function listaPolicialAssinaturaPortaria($idAtividade) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/atividade/".$idAtividade."/consulta/policiais/assinatura/portaria");
                $objeto = $api->converteStringJson($request);
                //dd($objeto);
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


        //@autor: Juan Mojica
        //Realiza a assinatura eletronica do policial na comissão
        public function assinarPortariaDoQuadro($idQuadro, $idAtividade, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("quadrosacessos/".$idQuadro."/atividade/".$idAtividade."/comissao/assinatura/portaria", $dadosForm);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            } 

        } 

        //@autor: Márcio, #255
        //Realiza a atualização das informações do policial em um determinado QA.
        public function updatePolicialPendenciasQa($idQuadro, $idPolicial, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("quadrosacessos/".$idQuadro."/policiais/".$idPolicial."/Pendencias", $dadosForm);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno) && ($response->retorno != 'sucesso')){
                    throw new Exception($response->msg);
                }
                return $response;            
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            } 

        } 
        

     /**
     * @autor: Márcio, #255
     * Busca Policial vinculado a um Quadro de Acesso por CPF ou Matrícula
     * Entrada:  id do Quadro
     * Saída - lista os dados de um determinado policial vinculado ao quadro
     */
    public function buscaPolicialDoQuadroPorCpfMatricula($idQuadro, $parametro) {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("quadrosacessos/" . $idQuadro . "/policiais/matricula-cpf/" . $parametro);
            $policialDoquadro = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($policialDoquadro->retorno) && ($policialDoquadro->retorno != 'sucesso')){
                throw new Exception($policialDoquadro->msg);
            }
            return $policialDoquadro;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @autor: Márcio, #257-realizar-inpecao-extra-pela-jpms
     * Lista todos os policiais do quadro de acesso para Promoção de praças que serão convocados para JPMS de forma extraordinária
     * Entrada:  id do Quadro
     * Saída - Retorna uma lista de policiais do quadro de para Promoção de praças que serão convocados para JPMS de forma extraordinária
     */
    public function listaPoliciaisDoQuadroParaPromocaoConvocacaoExtraJmps($idQuadro) {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("quadrosacessos/" . $idQuadro . "/policiais/convocacaojpms/extra");
            $policiaisDoquadro = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($policiaisDoquadro->retorno) && ($policiaisDoquadro->retorno != 'sucesso')){
                if($policiaisDoquadro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($policiaisDoquadro->msg);
                }
            }
            return $policiaisDoquadro;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @autor: Márcio, #257-realizar-inpecao-extra-pela-jpms
     * Lista todos os policiais do quadro de acesso para Promoção de praças que serão convocados para JPMS de forma extraordinária
     * Entrada:  id do Quadro, id da atividade
     * Saída - Retorna uma lista de policiais do quadro de para Promoção de praças que serão convocados para JPMS de forma extraordinária
     */
    public function listaAPortariaEPoliciaisDoQuadroParaPromocaoConvocacaoExtraJmps($idQuadro, $idAtividade) {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("quadrosacessos/" . $idQuadro . "/atividade/" . $idAtividade . "/convocacaoextrajpms");
            $policiaisDoquadro = $api->converteStringJson($request);
        
            //Verificação se houve erro na requisição
            if(isset($policiaisDoquadro->retorno) && $policiaisDoquadro->retorno =='erro'){
                throw new Exception($policiaisDoquadro->msg);
            }
            return $policiaisDoquadro;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @autor: Márcio, #257-realizar-inpecao-extra-pela-jpms
     * Lista todos os policiais do quadro de acesso para Promoção de praças que serão convocados para JPMS de forma extraordinária
     * Entrada:  id do Quadro
     * Saída - Retorna uma lista de policiais do quadro de para Promoção de praças que serão convocados para JPMS de forma extraordinária
     */
    public function salvarPortariaConvocacaoExtra($idQuadro, $idAtividade, $dadosForm) {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("quadrosacessos/" . $idQuadro . "/atividade/" . $idAtividade . "/convocacaoextrajpms/portaria", $dadosForm);

            $portaria = $api->converteStringJson($request);

            //Verificação se houve erro na requisição
            if(isset($portaria->retorno)) {
                 if($portaria->retorno =='erro'){
                     throw new Exception($portaria->msg);
                 }else{
                    return $portaria->msg;
                 }
                
            }
            return $portaria;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que importa para o QA o efetivo da unidade do perfil do policial logado
     * @param {id do QA, id da unidade do perfil logado}
     * @return Response (sucesso ou erro)
     */
    public function importaPoliciaisDaUnidadeParaQA($idQuadro, $idUnidade) {
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("qa/$idQuadro/unidade/$idUnidade/importarefetivo");
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($response->retorno)) {
                 if($response->retorno =='erro'){
                    throw new Exception($response->msg);
                 }else{
                    return $response->msg;
                 }
                
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que importa os dados do policial para a sua ficha de escrituração
     * @param {id do QA, id da unidade do perfil logado}
     * @return Response (sucesso ou erro)
     */
    public function importaDadosPolicialEscriturarFicha($idQuadro, $idUnidade, $idPolicial) {
        try{
            $api = new ApiRestGeneric();
           // $request = $api->get("qa/$idQuadro/unidade/$idUnidade/policial/$idPolicial/importarpontuacao");
            $request = $api->post("qa/$idQuadro/unidade/$idUnidade/policial/$idPolicial/importar_dados_qa_anterior");
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($response->retorno)) {
                 if($response->retorno =='erro'){
                    throw new Exception($response->msg);
                 }else{
                    return $response->msg;
                 }
                
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que assina a ficha de reconhecimento do policial
     * @param {id do QA, id do policial}
     * @return Response (sucesso ou erro)
     */
    public function assinaFichaReconhecimento($idQuadro, $idPolicial,$dadosForm) {
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("qa/$idQuadro/policial/$idPolicial/assinarficha",$dadosForm);
            //dd($request);
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($response->retorno)) {
                 if($response->retorno =='erro'){
                    throw new Exception($response->msg);
                 }else{
                    return $response->msg;
                 }
                
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que busca policial por cpf ou matrícula
     * @param {id do policial}, {unidade do perfil logado}
     * @return Response (retorna um policial)
     */
    public function buscarPolicialPorCpfOuMatricula($cpfOuMatricula, $idUnidade) {
        try{
            $api = new ApiRestGeneric();
           
            $request = $api->get("policiais/matricula-cpf/$cpfOuMatricula/unidade/$idUnidade");

            $response = $api->converteStringJson($request);

            //a validação de erro é feita na requisição ajax
            return $response;

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que busca policial por cpf ou matrícula
     * @param {id do policial}
     * @return Response (retorna um policial)
     */
    public function inserirPolicialNoQA($idQuadro, $idPolicial) {
        try{

            $api = new ApiRestGeneric();
            
            $request = $api->post("qa/$idQuadro/policiais/$idPolicial");
            $response = $api->converteStringJson($request);
            //a validação de erro é feita na requisição ajax
            return $response;

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que retorna para edição uma ficha escriturada assinada 
     * @param {id do QA, id da atividade e id do policial}
     * @return Response (sucesso ou erro)
     */
    public function retornarFichaEscrituradaParaEdicao($idQuadro, $idAtividade, $idPolicial) {
        try{
            $api = new ApiRestGeneric();
            $request = $api->put("qa/$idQuadro/atividade/$idAtividade/devolverfichareconhecimento/$idPolicial");
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($response->retorno)) {
                 if($response->retorno =='erro'){
                    throw new Exception($response->msg);
                 }else{
                    return $response->msg;
                 }
                
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Envia a ficha escriturada do policial para o QA 
     * @param {id do QA e id do policial}
     * @return Response (sucesso ou erro)
     */
    public function enviarFichaEscrituradaQA($idQuadro, $idPolicial,$dadosForm) {
        try{
            $api = new ApiRestGeneric();
            $request = $api->put("qa/$idQuadro/policial/$idPolicial/enviarfichaescriturada",$dadosForm);     
           // dd($request);     
            $response = $api->converteStringJson($request);
            if (isset($response->retorno)) {
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Salva a homologação da ficha de reconhecimento do policial
     * @param {id do QA, id do policial e os dados do formulário}
     * @return Response (sucesso ou erro)
     */
    public function salvarHomologarFichaReconhecimentoQA($idQuadro, $idPolicial, $dadosForm) {
        try{
            $api = new ApiRestGeneric();
            $request = $api->put("qa/$idQuadro/policial/$idPolicial/ficha/calcular", $dadosForm); 
            $response = $api->converteStringJson($request);  
            if (isset($response->retorno)) {
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Assina a homologação da ficha de reconhecimento do policial
     * @param {id do QA, id do policial}
     * @return Response (sucesso ou erro)
     */
    public function assinarHomologacaoFichaReconhecimentoQA($idQuadro, $idPolicial,$dadosForm) {
        try{
            //dd('assinarHomologacaoFichaReconhecimentoQA');
            $api = new ApiRestGeneric();
            $request = $api->put("qa/$idQuadro/policial/$idPolicial/ficha/homologar",$dadosForm); 
            //dd($request);
            $response = $api->converteStringJson($request);  
            if (isset($response->retorno)) {
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Reabre a homologação da ficha de reconhecimento do policial
     * @param {id do QA, id do policial}
     * @return Response (sucesso ou erro)
     */
    public function reabrirHomologacaoFichaReconhecimento($idQuadro, $idPolicial) {
        try{
            $api = new ApiRestGeneric();

            $request = $api->put("qa/$idQuadro/policial/$idPolicial/ficha/deshomologar"); 
            $response = $api->converteStringJson($request); 

            if (isset($response->retorno)) {
                
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }

                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Libera período para recurso no QA
     * @param {id do QA, status}
     * @return Response (sucesso ou erro)
     */
    public function alteraStatusRecursoQA($idQuadro, $status) {
        try{
            $api = new ApiRestGeneric();

            $request = $api->put("qa/{$idQuadro}/recurso/{$status}"); 
            $response = $api->converteStringJson($request); 

            if (isset($response->retorno)) {
                
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }

                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Altera status do escriturar ficha
     * @param {id do QA, status}
     * @return Response (sucesso ou erro)
     */
    public function alteraStatusEscriturarQA($idQuadro, $status) {
        try{
            $api = new ApiRestGeneric();
            
            $request = $api->put("qa/{$idQuadro}/param/{$status}/escriturar"); 
            $response = $api->converteStringJson($request); 

            if (isset($response->retorno)) {
                
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }

                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Cadastra dependências na ficha de reconhecimento do policial
     * @param {id do QA, status}
     * @return Response (sucesso ou erro)
     */
    public function cadastrarDependenciasFichaReconhecimento($idQuadro, $idPolicial, $dadosForm) {
        try{
            $api = new ApiRestGeneric();

            $request = $api->put("qa/{$idQuadro}/pm/{$idPolicial}/pendencias", $dadosForm); 
            $response = $api->converteStringJson($request); 
          
            if (isset($response->retorno)) {
                
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }

                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Altera o status do recorrer do policial 
     * @param {id do policial, id do QA}
     * @return Response (sucesso ou erro)
     */
    public function alterarStatusRecursoPolicial($idPolicial, $idQuadro) {
        try{
            $api = new ApiRestGeneric();
           
            $request = $api->put("qa/$idQuadro/policial/$idPolicial/recorrer"); 
            $response = $api->converteStringJson($request); 
          
            if (isset($response->retorno)) {
                
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }

                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Altera o status da análise do recurso da ficha do policial
     * @param {id do policial, id do QA}
     * @return Response (sucesso ou erro)
     */
    public function alterarStatusAnaliseRecursoPolicial($idPolicial, $idQuadro) {
        try{
            $api = new ApiRestGeneric();
           
            $request = $api->post("qa/$idQuadro/policial/$idPolicial/ficha/desanalisar"); 
            $response = $api->converteStringJson($request); 
          
            if (isset($response->retorno)) {
                
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }

                return $response->msg;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

     /**
     * @author juan_mojica - #485
     * Lista os policiais com ou sem pendências na ficha de reconhecimento
     * @param status ('sim' ou 'nao')
     * @param idQuadro
     * @param idAtividade
     * @return (Lista de Policiais)
     */
    public function listaPoliciaisPendenciasNaFichaReconhecimento($status, $idQuadro)
    {
        try{

            $api = new ApiRestGeneric();
            
            $request = $api->get("qa/$idQuadro/parametro/$status/relacao");
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

     /**
     * @author juan_mojica - #485
     * Lista os policiais que não enviaram a ficha de reconhecimento
     * @param idQuadro
     * @return (Lista de Policiais)
     */
    public function listaPoliciaisAusentesFichaReconhecimento($idQuadro)
    {
        try{

            $api = new ApiRestGeneric();
            
            $request = $api->get("qa/$idQuadro/naoenviados");
            $response = $api->converteStringJson($request);
           
            if(isset($response->retorno)){
                if($response->retorno == 'sucesso'){
                    return $response->msg;
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
     * @author juan_mojica - #485
     * Lista os policiais que recorreram na ficha de reconhecimento
     * @param $idQuadro
     * @param $graduacao
     * @return (Lista de Policiais)
     */
    public function listaPoliciaisRecorreramFicha($idQuadro, $graduacao)
    {
        try{

            throw new Exception("Migrado para o serviço listaPoliciaisRecursosFicha");
            

            $api = new ApiRestGeneric();
           
            $request = $api->get("qa/$idQuadro/stGraduacao/$graduacao/listarpoliciaisrecurso?".Request::getQueryString());
            $response = $api->converteStringJson($request);
           
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
     /**
     * @author juan_mojica - #485
     * Lista os policiais que tiveram o recursos analisados na ficha de reconhecimento
     * @param $idQuadro
     * @param $graduacao
     * @return (Lista de Policiais)
     */
    public function listaPoliciaisRecursosFicha($idQuadro, $graduacao, $dadosForm)
    {
        try{

            $api = new ApiRestGeneric();
           
            $request = $api->get("qa/$idQuadro/stGraduacao/$graduacao/listarpoliciaisrecurso?".Request::getQueryString(), $dadosForm);
            $response = $api->converteStringJson($request);
           
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

     /**
     * @author juan_mojica - #485
     * Lista todos os policiais que recorreram no QA
     * @param $idQuadro
     * @return (Lista de Policiais)
     */
    public function listaPoliciaisRecorreramQA($idQuadro)
    {
        try{

            $api = new ApiRestGeneric();
           
            $request = $api->get("qa/$idQuadro/exportarpoliciaisrecurso");
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

     /**
     * @author juan_mojica - #485
     * Lista histórico de alterações do policial no QA  
     * @param $idQuadro 
     * @param $idPolicial 
     * @return (lista de alterações do policial no QA)
     */
    public function listaHistoricoPolicialQA($idQuadro, $idPolicial)
    {
        try{

            $api = new ApiRestGeneric();
           
            $request = $api->get("qa/$idQuadro/policial/$idPolicial/historico");
            $response = $api->converteStringJson($request);

            //O tratamento de erro é feito no retorno do ajax
            return $response;

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

     /**
     * @author Jazon - #485
     * Adiciona policiais em lote ao QA  
     * @param $idQuadro 
     * @param $listamatriculas 
     * @return (lista de matrículas não inseridas no QA ou msg de sucesso)
     */
    public function addPoliciaisAoQaEmLoteExcel($idQuadro, $dadosForm)
    {
        try{

            $api = new ApiRestGeneric();
           
            $request = $api->post("qa/$idQuadro/importarmatriculas/qa",$dadosForm);
           // dd($request);
            $response = $api->converteStringJson($request);

            if (isset($response->retorno)) {

                if ($response->retorno != 'sucesso') {
                    throw new Exception($response->msg);
                }

                return $response->msg;

            }
            
            

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

     /**
     * @author juan_mojica - #485
     * Busca as informações para exibir no dashboard do QA  
     * @param $idQuadro 
     * @return (informações para exibir no dashboard do QA)
     */
    public function listadashboardQA($idQuadro)
    {
        try{

            $api = new ApiRestGeneric();
           
            $request = $api->get("qa/$idQuadro/dashboard");
            $response = $api->converteStringJson($request);

            if (isset($response->retorno)) {

                if ($response->retorno != 'sucesso') {
                    throw new Exception($response->msg);
                }
            }

            return $response;
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author Juan - #485
     * Importa efetivo inspecionado pela JPMS ou TAF ao QA  
     * @param $idQuadro 
     * @param $tipoInspecao 
     * @param $dadosForm
     * @return (sucesso ou erro)
     */
    public function importarPoliciaisInspecionadosJpmsTafExcel($idQuadro, $tipoInspecao, $dadosForm)
    {
        try{

            $api = new ApiRestGeneric();
          
            $request = $api->put("qa/$idQuadro/relacaojunta/$tipoInspecao", $dadosForm);
            $response = $api->converteStringJson($request);

            if (isset($response->retorno)) {

                if ($response->retorno != 'sucesso') {
                    throw new Exception($response->msg);
                }

                return $response->msg;

            }
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author Juan - #511
     * Edita dados do policial no QA  
     * @param $dadosForm
     * @param $idPolicial 
     * @param $idQuadro 
     * @return (sucesso ou erro)
     */
    public function editaPolicialNoQA($dadosForm, $idPolicial, $idQuadro)
    {
        try {
            
            $api = new ApiRestGeneric();

            $request = $api->put("qa/$idQuadro/policial/$idPolicial", $dadosForm);
            $response = $api->converteStringJson($request);

            if ($response->retorno != 'sucesso') {
                throw new Exception($response->msg);
            }

            return $response->msg;

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

}
?>