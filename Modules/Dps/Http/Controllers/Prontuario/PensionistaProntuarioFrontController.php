<?php

namespace Modules\Dps\Http\Controllers\Prontuario;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Exception;

use Modules\Dps\Http\Controllers\Prontuario\PensionistaProntuarioAbaFactory;

/**
 * # 462-criar-prontuario-de-pensionista
 * controller que lida com as requsições do prontuário do pensionista.
 * @author Jherod Brendon
 */

class PensionistaProntuarioFrontController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @param int $pensionistaId id do pensionista
     * @param string $aba aba do prontuário que será instanciada
     * @param string $acao ação da aba que será executada
     * @param Request $request requisição com os dados dos formulários, se existirem
     * @return mixed abas dos prontuários, ou erros.
     */

    public function executar($pensionistaId, $aba, $acao, $registroId = 0, Request $request) {
        try {
            $factory = new PensionistaProntuarioAbaFactory();
            $controllerAbaCriada = $factory->createControllerAbaPensionista($aba);
            switch ($acao) {
                case 'editar':
                    return $controllerAbaCriada->editar($pensionistaId);
                    break;

                case 'listaupload':
                    return $controllerAbaCriada->listaUpload($pensionistaId,$registroId);
                    break;

                case 'uploadprovadevida':
                    return $controllerAbaCriada->uploadProvaDeVida($pensionistaId,$registroId,$request);
                    break;

                case 'listar':
                    return $controllerAbaCriada->listar($pensionistaId);
                    break;

                case 'criar':
                    return $controllerAbaCriada->criar($pensionistaId, $request);
                    break;

                case 'consultar':
                    return $controllerAbaCriada->consultar($pensionistaId);
                    break;

                case 'consultarRegistro':
                    return $controllerAbaCriada->consultarRegistro($pensionistaId, $registroId);
                    break;

                case 'consultarComprovante':
                    return $controllerAbaCriada->consultarComprovante($pensionistaId,$registroId);
                    break;

                    case 'consultarDocumento':
                        return $controllerAbaCriada->consultarDocumento($registroId);
                        break;
                
                case 'salvar':
                    return $controllerAbaCriada->salvar($pensionistaId, $request);
                    break;

                case 'imprimir':
                    return $controllerAbaCriada->imprimir($request);
                    break;

                case 'excluir':
                    return $controllerAbaCriada->excluir($request);
                    break;

                default:
                    throw new Exception('Ação ' . $acao . ' não implementada.');
                    break;
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        
    }

}