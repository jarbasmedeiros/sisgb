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

class QuadroDeVagaService  {
        
        // busca o Quadro de Acesso pelo id
        // Saída - Objeto Quadro de Acesso
        public function getQuadroAcessoId($id) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$id);
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
        public function listaQuadroAcesso() {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos?".Request::getQueryString());
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
                $request = $api->post("quadrosacessos", $dados);
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
                $request = $api->put("quadrosacessos/" . $id, $dados);
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
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("vagas");
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno)){
                      throw new Exception($objeto->msg);
                }
                return $objeto;
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
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->post("vagas",$dados);
            $objeto = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno) && $objeto->retorno == 'sucesso'){
                return $objeto->msg;
            }else{
                throw new Exception($objeto->msg);
            }
            
    }catch(Exception $e){
        return $e->getMessage();
    }
       /*  try{
            foreach($dados as $key =>$valor){
                if($key != '_token'){
                    $atualiza = Vaga::find($key)->update([
                        'nu_vagasprevistas' => $valor
                        ]);
           

                }
            }

            return $atualiza;
                
         } catch(Exception $e){
             
             return $e->getMessage();
         } */
       
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
        public function GetCronogramaQuadroId($idQuadro) {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/".$idQuadro."/cronogramas?".Request::getQueryString());
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
                $request = $api->get("quadrosacessos/cronogramas/".$idAtividade);
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
         * listas todos os Policiais vinculados ao um Quadro de Acesso Sem paginação
         * Entrada:  id do Quadro
         * Saída - lista de policiais vinculados ao quadro
         */
        // 
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
                $policiais = Policialdoqa::where([['policiaisdosqas.ce_quadroacesso', $idQuadro], ['policiaisdosqas.st_inspecaotafparecer', '!=', null], ['policiaisdosqas.bo_inspecionadotaf', 1]])
                ->get();
                return $policiais;
            }catch(Exception $e){
                return $e->getMessage();
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
        /*
        * Busca Policiais vinculados ao um Quadro de Acesso e apto na JPMS  por CPF, Matrícula ou nome (busca para o taf)
        * Entrada:  id do Quadro
        * Saída - lista de policiais vinculados ao quadro
        */
        public function buscaPolicialParaTafNomeCpfMatricula($idQuadro, $criterio, $filtro)
        {
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("quadrosacessos/" . $idQuadro . "/taf/policiais/" . $criterio . "/" . urlencode($filtro) . "/paginado");
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
                $request = $api->post("quadrosacessos/".$idQuadro."/policiais/".$idPolicial);
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
                $request = $api->delete("quadrosacessos/".$idQuadroDeAcesso."/policiais/".$cePolicial);
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
        public function criarNota($dadosform, $idQuadro){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("quadrosacessos/".$idQuadro."/notas/promocao", $dadosform);
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
