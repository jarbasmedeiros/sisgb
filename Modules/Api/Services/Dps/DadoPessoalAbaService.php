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
use Session;

/**
 * # 462-criar-prontuario-de-pensionista
 * Service responsável pelo acesso da aba de dados do pensionista do prontuário do pensionista.
 * @author Jherod Brendon
 */
class DadoPessoalAbaService extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @return mixed dados da aba, ou erro 
     */
    public function getAba($pensionistaId) {
        try {
            //dd('aqui');
            $api = new ApiRestGeneric();
            $request = $api->get('dps/prontuario/pensionista/' . $pensionistaId . '/aba/dados_pessoais/acao/editar');
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
    public function salvarDados(int $pensionistaId, $dadosForm) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->post(
                'dps/prontuario/pensionista/' . $pensionistaId . '/aba/dados_pessoais/acao/salvar',
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

}