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
 * Service responsável pelo acesso da aba de dados da pensão do prontuário do pensionista.
 * @author Jherod Brendon
 */
class DadoPensaoAbaService extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @param string $aba aba do prontuário a ser recuperada
     * @return mixed dados da aba, ou erro 
     */
    public function getAba($pensionistaId) {
        try {
            $api = new ApiRestGeneric();
            $request = $api->get('dps/prontuario/pensionista/' . $pensionistaId . '/aba/dados_pensao/acao/editar');
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
                'dps/prontuario/pensionista/' . $pensionistaId . '/aba/dados_pensao/acao/salvar',
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
     * Chama o recurso de arquivos e atualiza um registro
     * retorna sucesso ou erro
     * @autor: Araujo
     */
    public function atualizarRegistro($idPensionista,$idRegistro,$dadosForm) 
    {
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->put("dps/prontuario/pensionista/$idPensionista/aba/recadastramento/acao/atualizarRegistro/registro/$idRegistro", $dadosForm);
            $response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

}