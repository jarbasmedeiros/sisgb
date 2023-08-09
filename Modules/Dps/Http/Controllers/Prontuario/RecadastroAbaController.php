<?php 

namespace Modules\Dps\Http\Controllers\Prontuario;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Modules\Api\Services\DpsService;
use Modules\Api\Services\Dps\RecadastroAbaService;
use Modules\Api\Services\Dps\DadoPensaoAbaService;
use Modules\Api\Services\ArquivoBancoService;
use App\utis\Msg;
use App\utis\Funcoes;
use Auth;
use Exception;

/**
 * # 462-criar-prontuario-de-pensionista
 * Controller responsável pela aba de recadstramento da pensão do prontuário do pensionista.
 * @author Jherod Brendon
 */
class RecadastroAbaController extends Controller implements IPensionistaProntuarioAba {
    
    public function __construct() {
        $this->middleware('auth');
        $this->abaService = new RecadastroAbaService();
        $this->pensaoService = new DadoPensaoAbaService();
        $this->dpsService = new DpsService();
        $this->arquivoService = new ArquivoBancoService();
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @return mixed aba do prontuario, ou erro
     */
    public function editar(int $pensionistaId) {
        try {
            $idPensionista  = $pensionistaId;
            $dadosAba = $this->pensaoService->getAba($pensionistaId);
            return view(
                'dps::prontuario.recadastro_pensao_form',
                compact('dadosAba','idPensionista')
            );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function listaUpload(int $pensionistaId,int $idProvaDeVida) {
        try {
            $idPensionista  = $pensionistaId;
            $dadosAba = $this->pensaoService->getAba($pensionistaId);
            return view(
                'dps::prontuario.recadastro_pensao_upload',
                compact('dadosAba','idProvaDeVida','idPensionista')
            );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function uploadProvaDeVida(int $pensionistaId,int $idProvaDeVida, Request $request) {
        try {
            $dadosValidados = Funcoes::addSlashesRecursivo($request->all());
            // Validação do envio do arquivo
            if (isset($request->arquivo)) {
                $arquivo = $request->arquivo;
                //verifica se o arquivo é válido
                $nomeArquivo = $arquivo->getClientOriginalName();
                if ($arquivo->isValid()) {
                    $extensao = $arquivo->getClientOriginalExtension();
                    //busca o pensionista
                    $pensionista = $this->dpsService->getPensionistaById($pensionistaId);
                    //seleciona o id da pessoa do pensionista
                    $idPessoa = $pensionista->ce_pessoa;
                    //pega o cpf da pessoa do pensionista
                    $st_cpf = $pensionista->pessoa->st_cpf;
                    //monta o caminho do ftp
                    $caminho_armazenamento = $st_cpf."/".date('Y')."/"."DPS"."/"."recadastramento"."/".$pensionistaId."/";
                    //testa se existe o diretorio 
                    if (!Storage::disk('ftp')->exists($caminho_armazenamento)) { 
                        //cria o diretorio
                        Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                    }
                    //gera hash do nome do arquivo a partir do arquivo
                    $hashNome = hash_file('md5', $arquivo);
                    //todo estudar a funcao hash_file
                    //novo nome do arquivo com base no hash
                    $novoNome = $hashNome.'.'.$extensao;
                    //dd($novoNome);
                    //checa se o arquivo ja existe
                    if (!Storage::disk('ftp')->exists($caminho_armazenamento.$novoNome)) {                    
                        //salva arquivo no ftp
                        $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                        if ($salvouNoFtp) {
                            //salva o arquivo no banco
                            $dadosForm = [
                                'st_comprovante' => $caminho_armazenamento.$novoNome,
                                'st_cpf' => $st_cpf
                            ];
                            //altera caminho do arquivo em beneficiarios
                            //TODO corrigir o ce_policial na hora de salvar este arquivo
                            $resposta = $this->pensaoService->atualizarRegistro($pensionistaId,$idProvaDeVida,$dadosForm);
                            
                            return redirect()
                                ->route('prontuario_pensionista', ['pensionistaId' => $pensionistaId,'aba' => 'recadastro', 'acao' => 'listar'])
                                ->with('sucessoMsg', $resposta);
                        } else {
                            throw new Exception('Falha ao realizar o upload.');
                        }
                    } else {
                        //se já existe exclui e depois envia novamente
                        $resposta = Storage::disk('ftp')->delete($caminho_armazenamento.$novoNome);
                        if($resposta){
                            //salva arquivo no ftp
                            $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                            if ($salvouNoFtp) {
                                //salva o arquivo no banco
                                $dadosForm = [
                                    'st_comprovante' => $caminho_armazenamento.$novoNome,
                                    'st_cpf' => $st_cpf
                                ];
                                //altera caminho do arquivo em beneficiarios
                                $resposta = $this->pensaoService->atualizarRegistro($pensionistaId,$idProvaDeVida,$dadosForm);
                                
                                return redirect()
                                    ->route('prontuario_pensionista', ['pensionistaId' => $pensionistaId,'aba' => 'recadastro', 'acao' => 'listar'])
                                    ->with('sucessoMsg', $resposta);
                            } else {
                                throw new Exception('Falha ao realizar o upload.');
                            }
                        }
                    }
                } else {
                    throw new Exception('erroMsg', 'Falha ao realizar o upload do arquivo "'.$nomeArquivo.'", verifique se ele não está corrompido.');
                }
            } else {
                throw new Exception('Falha ao realizar o upload.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    public function listar(int $pensionistaId) {
        try {
            $idPensionista  = $pensionistaId;
            $dadosAba = $this->pensaoService->getAba($pensionistaId); 
            $provasDeVida = $this->abaService->getAba($pensionistaId);
            //dd($provasDeVida);
            return view(
                'dps::prontuario.recadastro_pensao_edit_aba',
                compact('dadosAba', 'provasDeVida','idPensionista')
            );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function criar(int $pensionistaId, Request $request) {
        try {
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_tiporesponsavellegal' => 'required'
            ]);

            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            } 
            unset($dadosForm['st_assinatura']);
            $dadosTratados = Funcoes::addSlashesRecursivo($dadosForm);
            $response = $this->abaService->criarProvaDeVida($pensionistaId, $dadosTratados);
            return redirect()->route('prontuario_pensionista', [
                'pensionistaId' => $pensionistaId,
                'aba' => 'recadastro',
                'acao' => 'listar'
            ])->with('sucessoMsg', 'Prova de vida cadastrada com sucesso!');
        } catch (Exception $e) {
            //return redirect()->back()->with('erroMsg', $e->getMessage());
            return redirect()
            ->route('prontuario_pensionista', ['pensionistaId' => $pensionistaId,'aba' => 'recadastro', 'acao' => 'listar'])
            ->with('erroMsg', $e->getMessage());
        }
    }

    public function salvar(int $pensionistaId, Request $dadosForm) {
        try {
            throw new Exception('Método não implementado.');
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

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @param int $registroId id do registro a ser recuperado
     * @return mixed página de pdf com os dados da prova de vida
     */
    public function consultarRegistro(int $pensionistaId, int $registroId) {
        try {
            $comprovanteProvaDeVida = $this->abaService->gerarComprovante($pensionistaId, $registroId);
            //dd($comprovanteProvaDeVida);
            if (empty($comprovanteProvaDeVida)) throw new Exception('Erro no acesso ao serviço.');
            return \PDF::loadView(
                'dps::prontuario.pdf.comprovantePDF',
                compact('comprovanteProvaDeVida')
            )->stream('comprovantePDF.pdf');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //cb araujo
    // branch - 498
    public function consultarComprovante(int $pensionistaId, int $registroId) {
        try {
            $provadevida = $this->abaService->editarRegistro($pensionistaId, $registroId);
            $caminhodocomprovante = $provadevida->st_comprovante;
            //pega a linha da tabela recadastramentos, pega a coluna st_comprovante e continua o codigo abaixo
            if(Storage::disk('ftp')->exists($caminhodocomprovante)){
                return Storage::disk('ftp')->download($caminhodocomprovante);
            }else{
                return redirect()->back()->with('erroMsg', Msg::ARQUIVO_NAO_ENCONTRADO);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //cb araujo
    // branch - 498
    public function consultarDocumento(int $registroId) {
        try {
            $arquivo = $this->arquivoService->getArquivoGenerico($registroId);
            $caminhodocomprovante = $arquivo->st_pasta.$arquivo->st_arquivo.".".$arquivo->st_extensao;
            if(Storage::disk('ftp')->exists($caminhodocomprovante)){
                return Storage::disk('ftp')->download($caminhodocomprovante);
            }else{
                return redirect()->back()->with('erroMsg', Msg::ARQUIVO_NAO_ENCONTRADO);
            }
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