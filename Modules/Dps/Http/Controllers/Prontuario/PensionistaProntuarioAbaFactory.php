<?php

namespace Modules\Dps\Http\Controllers\Prontuario;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Exception;

use Modules\Dps\Http\Controllers\Prontuario\DadosPessoalAbaController;
use Modules\Dps\Http\Controllers\Prontuario\DadosPensaoAbaController;
use Modules\Dps\Http\Controllers\Prontuario\RecadastroAbaController;
use Modules\Dps\Http\Controllers\Prontuario\ArquivoAbaController;

/**
 * # 462-criar-prontuario-de-pensionista
 * factory responsável por instanciar as abas do prontuário do pensionista.
 * @author Jherod Brendon
 */
class PensionistaProntuarioAbaFactory extends Controller {

    /**
     * @param string $aba aba do prontuário que será instanciada.
     * @return mixed uma aba do prontuário, ou um erro.
     */
    public function createControllerAbaPensionista($aba) {
        try {
            switch ($aba) {
                case 'dados_pessoais':
                    return new DadosPessoalAbaController();
                    break;

                case 'dados_pensao':
                    return new DadosPensaoAbaController();
                    break;

                case 'recadastro':
                    return new RecadastroAbaController();
                    break;

                case 'arquivos':
                    return new ArquivoAbaController();
                    break;

                default:
                    throw new Exception('Aba ' . $aba . ' não implementada.');
                    break;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
    }
}

?>