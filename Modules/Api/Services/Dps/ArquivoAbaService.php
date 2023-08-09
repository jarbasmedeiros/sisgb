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
 * Service responsável pelo acesso da aba de arquivos do prontuário do pensionista.
 * @author Jherod Brendon
 */
class ArquivoAbaService extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @param string $aba aba do prontuário a ser recuperada
     * @return mixed dados da aba, ou erro 
     */
    public function getAba($pensionistaId, $aba, $acao) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get('dps/prontuario/pensionista/' . $pensionistaId . '/'. 'aba/' . $aba . '/' . 'acao/' . $acao);
            $response = $api->converteStringJson($request);
            if (isset($response->retorno) && $response->retorno == 'erro')
                throw new Exception($response->msg);
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
