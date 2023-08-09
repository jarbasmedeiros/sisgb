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

    class DpsService{
        /*
        public function __construct(NotaService $NotaService, PolicialService $policialService, UnidadeService $unidadeService){
            $this->middleware('auth');
            $this->NotaService = $NotaService;
            $this->policialService = $policialService;
            $this->unidadeService = $unidadeService;
            //$this->api = new ApiRestGeneric();
        }
        */

    
    /***
     * Lista todos os boletins gerais
     * retorno: Lista todos os boletins gerais em elaboração
     * @autor: Jazon #363
     */
    public function getDashboard() {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("dps/dashboard");
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

    public function getSituacao($situacao) {            
        try{
            //dd($situacao);
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("dps/policiais/situacao/".$situacao);
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

    public function getAgendamentos($situacao,$mes) {            
        try{
            //dd($situacao." ".$mes);
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("dps/policiais/agendamentos/".$situacao."/mes/".$mes);
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
            return $response;
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @return mixed lista de habilitações por unidade, ou objeto de erro
     */

    public function listarHabilitacoesPorUnidade() {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get("dps/habilitacoes/abertas");
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                if ($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO) return [];
                else throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPolicial
     *   @return mixed policial e lista de beneficiários, ou objeto de erro
     */

    public function listarBeneficiariosPorPolicial($idPolicial) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get("dps/habilitacao/beneficiarios/pm/".$idPolicial);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idSolicitante id do solicitante
     *   @param int $idPolicial id do policial
     *   @return mixed dados do solicitante e do policial, ou objeto de erro
     */

    public function getDadosSolicitantePolicial($idSolicitante, $idPolicial) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get("dps/habilitacao/solicitante/".$idSolicitante."/pm/".$idPolicial);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param string $cpf
     *   @return mixed dados do pensionista, ou objeto de erro
     */

    public function getPensionistaByCPF($cpf) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get('dps/pensionistas/cpf/'.$cpf);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPensionista id do pensionista
     *   @return mixed dados do pensionista, ou objeto de erro
     */

    public function getPensionistaById($idPensionsta) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get('dps/pensionistas/'.$idPensionsta);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idHabilitacao id da habilitação
     *   @return mixed dados da habilitação, solicitante e policial
     */

    public function getHabilitacaoById($idHabilitacao) {
        try {
            
            $api = new ApiRestGeneric();
            
            $request = $api->get('dps/habilitacao/'.$idHabilitacao);
            

            $response = $api->converteStringJson($request);
            
            if (isset($response->retorno) && $response->retorno == 'erro')
                
                throw new Exception($response->msg);
                
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPessoa id da pessoa
     *   @param int $idPolicial id do policial
     *   @param array $dadosForm dados do formulário
     *   @return mixed objeto com os dados da habilitação criada
     */

    public function createHabilitacao($idPessoa, $idPolicial, $dadosForm) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->post('dps/habilitacao/solicitante/'.$idPessoa.'/pm/'.$idPolicial, $dadosForm);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *  # 447-cadastrar-habilitacoes-dps
     *  @author Jherod Brendon
     *  @param int $idHabilitacao habilitação a ser registrada
     *  @return mixed habilitacao com status SOLICITADA, e msg de retorno
     */

    public function finalizaCadastroHabilitacao($idHabilitacao) {
        try { 
            $api = new ApiRestGeneric();
            // $request = $api->put('dps/habilitacao/'.$idHabilitacao.'/registro');
            $request = $api->post('dps/habilitacao'.'/'.$idHabilitacao.'/'.'registro');
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $id id do arquivo
     *   @return mixed Arquivo apagado no banco e no ftp
     */

    public function deleteArquivoGenerico($id){
        try{
            $api = new ApiRestGeneric();
            // Quando for fazer o merge, tem que trocar pra delete
            // $request = $api->delete("arquivos/delete/".$id);
            $request = $api->post("arquivos/delete/".$id);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param array $dados dados do formulário de cadastro
     *   @return mixed objeto com os dados cadastrados
     */

    public function createPessoa($dados) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->post('rh/pessoas', $dados);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPessoa id da pessoa que será alterada
     *   @param array $dados dados do formulário de atualização
     *   @return mixed objeto com os dados cadastrados
     */

    public function updatePessoa($idPessoa, $dados) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->put('rh/pessoas/'.$idPessoa, $dados);
            //$request = $api->post('rh/pessoas/'.$idPessoa, $dados);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param string $cpf Cpf a ser pesquisado
     *   @return mixed objeto com os dados da pessoa, ou com as mensagens de erro
     */

    public function getPessoaByCPF($cpf) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get('rh/pessoas/cpf/'.$cpf);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 496-criar-aba-declaracao-beneficiarios
     *   @author Araújo
     *   Busca pessoa sem levantar Exception caso não encontre a pessoa
     */

    public function getPessoaByCPFnoException($cpf) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get('rh/pessoas/cpf/'.$cpf);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro'){
                return [];
            } else {
                return $response;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPessoa id da pessoa a ser recuperada
     *   @return mixed objeto com os dados da pessoa, ou com as mensagens de erro
     */

    public function getPessoaById($idPessoa) {
        try {
            //dd(gettype($idPessoa));
            $idPessoa = intval($idPessoa);
            //dd(var_dump($idPessoa));
            $api = new ApiRestGeneric();
            $request = $api->get('rh/pessoa/'.$idPessoa);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param mixed $st_parametro pode ser um cpf, id ou matricula de um policial
     *   @return mixed objeto com os dados do policial
     */
    

    public function findPolicialNomeMatriculaCpf($st_parametro) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get("policiais/consultarpornomecpfmatricula/".$st_parametro);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }   
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idHabilitacao habilitacao a ser recuperada
     *   @return mixed objeto com o histórico de alterações na habilitação
     */

    public function getHistoricoByHabId($idHabilitacao) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get('dps/habilitacao/'.$idHabilitacao.'/'.'historicos');
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 462-criar-prontuario-de-pensionista
     *   @author Jherod Brendon
     *   @param mixed $dadosForm parâmetro para a pesquisa do pensionista
     *   @return mixed lista de pensionistas que atendem ao paramentro
     */

    public function pesquisarPensionista($dadosForm) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->post('dps/pensionistas/cpfnome', $dadosForm);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 462-criar-prontuario-de-pensionista
     *   @author cb Araújo
     *   Atualiza/salva local do scan da prova de vida assinada na tabela recadastramentos
     */

    public function atualizaStComprovante($dadosForm) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->post('dps/pensionistas/cpfnome', $dadosForm);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * # 462-criar-prontuario-de-pensionista
     *   @author cb Araújo
     *   Busca dados da pessoas pra ser usado em ajax
     */
    public function buscaPessoaCpfAjax($cpf){
        try
        {
            $api = new ApiRestGeneric();
            $request = $api->get("rh/pessoas/cpf/$cpf");
            //return $request;
            $response = $api->converteStringJson($request);            
            if(isset($response->retorno)){
                if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($response->msg);
                }
            }
            return json_encode($response);
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

  
}




?>