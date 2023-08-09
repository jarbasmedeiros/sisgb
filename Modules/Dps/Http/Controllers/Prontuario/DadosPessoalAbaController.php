<?php 

namespace Modules\Dps\Http\Controllers\Prontuario;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Modules\Api\Services\Dps\DadoPessoalAbaService;
use App\utis\Msg;
use App\utis\Funcoes;
use Auth;
use Exception;

/**
 * # 462-criar-prontuario-de-pensionista
 * Controller responsável pela aba de dados pessoais do prontuário do pensionista.
 * @author Jherod Brendon
 */
class DadosPessoalAbaController extends Controller implements IPensionistaProntuarioAba {
    
    public function __construct() {
        $this->middleware('auth');
        $this->abaService = new DadoPessoalAbaService();
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @return mixed aba do prontuario com os dados pessoais, ou erro
     */
    public function editar(int $pensionistaId) {
        try {
            $idPensionista = $pensionistaId;
            $dadosAba = $this->abaService->getAba($pensionistaId);
            if (empty($dadosAba)) throw new Exception('Erro no acesso a aba de dados pessoais.');
            return view(
                'dps::prontuario.dados_pessoais_edit_aba',
                compact('dadosAba','idPensionista')
            );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function listar(int $pensionistaId) {
        try {
            throw new Exception('Método não implementado.');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function criar(int $pensionistaId, Request $dadosForm) {
        try {
            throw new Exception('Método não implementado.');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function salvar(int $pensionistaId, Request $dadosForm) {
        try {
            $dados = $dadosForm->all();
            $dados['st_cpf'] = Funcoes::limpaCPF_CNPJ($dados['st_cpf']);
            $dadosTratados = Funcoes::addSlashesRecursivo($dados);
            $response = $this->abaService->salvarDados($pensionistaId, $dadosTratados);
            if (empty($response)) throw new Exception('Erro no serviço de atualização de dados.');
            return redirect()->route('prontuario_pensionista', [
                'pensionistaId' => $pensionistaId,
                'aba' => 'dados_pessoais',
                'acao' => 'editar'
            ])->with('sucessoMsg', 'Dados atualizados com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function consultar(int $pensionistaId) {
        try {
            throw new Exception('Método não implementado.');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function consultarRegistro(int $pensionistaId, int $registroId) {
        try {
            throw new Exception('Método não implementado.');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function excluir(int $pensionistaId, Request $dadosForm) {
        try {
            throw new Exception('Método não implementado.');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function imprimir(int $pensionistaId, Request $dadosForm) {
        try {
            throw new Exception('Método não implementado.');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

}