<?php

namespace Modules\Api\Services\Dps;

use App\Http\Controllers\Controller;
use App\utis\LengthAwarePaginatorConverter;
use Exception;
use Auth;
use DB;
use App\utis\Status;
use App\utis\ApiRestGeneric;
use App\utis\MyLog;
use App\utis\Msg;
use Illuminate\Support\Facades\Request;
use Session;

/**
 * # 462-criar-prontuario-de-pensionista
 * Service responsável pelo acesso da aba de recadastro da pensão do prontuário do pensionista.
 * @author Jherod Brendon
 */
class RecadastroAbaService {
    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @return mixed|array dados da aba, lista vazia, ou erro 
     */
    public function getAba(int $pensionistaId) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get('dps/prontuario/pensionista/' . $pensionistaId . '/aba/recadastramento/acao/listar');
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->msg == 'Nenhum resultado encontrado.')
                return [];
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @param mixed $dadosForm dados do formulário
     * @return mixed dados atualizados, ou erro 
     */
    public function salvarDados(int $pensionistaId, $dadosForm) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->post(
                'dps/prontuario/pensionista/' . $pensionistaId . '/aba/recadastramento/acao/salvar',
                $dadosForm
            );
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @param mixed $dadosForm dados do formulário
     * @return mixed registro criado, ou erro 
     */
    public function criarProvaDeVida(int $pensionistaId, $dadosForm) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->post(
                'dps/prontuario/pensionista/' . $pensionistaId . '/aba/recadastramento/acao/criar',
                $dadosForm
            );
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @param int $registroId id do registro da prova de vida
     * @return mixed comprovante da prova de vida, ou erro
     */
    public function gerarComprovante(int $pensionistaId, int $registroId) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get(
                'dps/prontuario/pensionista/' . $pensionistaId . '/aba/recadastramento/acao/editarRegistro/registro/' . $registroId
            );
            $response = $api->converteStringJson($request);
            //$dados = str_replace("\r\n","",$response->st_dados);
            //$dados = $api->converteStringJson($dados);
            if (isset($response->retorno) && $response->retorno == 'erro'){
                throw new Exception($response->msg);
            }
           return $response->st_dados;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @param mixed $dadosForm dados do formulário
     * @return mixed dados atualizados, ou erro 
     */
    public function salvarRegistro($pensionistaId, $idRegistro, $dadosForm) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->post(
                'dps/prontuario/pensionista/' . $pensionistaId . '/aba/recadastramento/acao/salvarregistro',
                $dadosForm
            );
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @param mixed $dadosForm dados do formulário
     * @return mixed dados atualizados, ou erro 
     */
    public function atualizarRegistro($pensionistaId, $idRegistro, $dadosForm) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->put(
                'dps/prontuario/pensionista/' . $pensionistaId . '/aba/recadastramento/acao/atualizarRegistro/registro/'.$idRegistro,
                $dadosForm
            );
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response->msg;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function editarRegistro($pensionistaId, $idRegistro) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get(
                'dps/prontuario/pensionista/' . $pensionistaId . '/aba/recadastramento/acao/editarRegistro/registro/'.$idRegistro
            );
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro'){
                throw new Exception($response->msg);
            }                
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}