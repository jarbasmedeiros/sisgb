<?php 

namespace Modules\Dps\Http\Controllers\Prontuario;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Modules\Api\Services\Dps\ArquivoAbaService;
use Modules\Api\Services\ArquivoBancoService;
use Modules\Api\Services\DpsService;
use Modules\Api\Services\Dps\DadoPensaoAbaService;
use App\utis\Msg;
use App\utis\Funcoes;
use Auth;
use Exception;

/**
 * # 462-criar-prontuario-de-pensionista
 * Controller responsável pela aba de arquivos do prontuário do pensionista.
 * @author Jherod Brendon
 */
class ArquivoAbaController extends Controller implements IPensionistaProntuarioAba {
    
    public function __construct() {
        $this->middleware('auth');
        $this->abaService = new ArquivoAbaService();
        $this->dpsService = new DpsService();
        $this->arquivoService = new ArquivoBancoService;
        $this->pensaoService = new DadoPensaoAbaService();
    }

    /**
     * @param int $pensionistaId id do pensionista a ser recuperado
     * @return mixed aba do prontuario com os dados da pensão, ou erro
     */
    public function editar(int $pensionistaId) {
        try {
            $idPensionista  = $pensionistaId;
            $dadosAba = $this->pensaoService->getAba($pensionistaId); 
            $arquivos = $this->arquivoService->getlistaArquivoIdentificador($pensionistaId,"DPS");
            return view(
                'dps::prontuario.arquivos_edit_aba',
                ['dadosAba' => $dadosAba,
                'arquivos' => $arquivos],
                compact('idPensionista')
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

    public function salvar(int $pensionistaId, Request $request) {
        try {
            $dadosValidados = Funcoes::addSlashesRecursivo($request->all());
            // Validação do envio do arquivo
            if (isset($request->arquivo)) {
                $arquivo = $request->arquivo;
                //verifica se o arquivo é válido
                $nomeArquivo = $arquivo->getClientOriginalName();
                //captura a descricao do arquivo
                $st_descricao = $request->st_descricao;
                if ($arquivo->isValid()) {
                    $extensao = $arquivo->getClientOriginalExtension();
                    //busca o pensionista
                    $pensionista = $this->dpsService->getPensionistaById($pensionistaId);
                    //seleciona o id da pessoa do pensionista
                    $idPessoa = $pensionista->ce_pessoa;
                    //pega o cpf da pessoa do pensionista
                    $st_cpf = $pensionista->pessoa->st_cpf;
                    //monta o caminho do ftp
                    $caminho_armazenamento = $st_cpf."/".date('Y')."/"."DPS"."/"."arquivos"."/"."pensionista"."/";
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
                            $policial = auth()->user();
                            //salva o arquivo no banco
                            $dadosForm = [
                                'ce_identificador' => $pensionistaId,
                                'st_identificador' => "PENSIONISTA_ID",
                                'dt_arquivo' => date('Y-m-d'),
                                'ce_policial' => $policial->id,
                                'st_tipodocumento' => $st_descricao,
                                'st_modulo' => 'DPS',
                                'st_motivo' => 'DOCUMENTO',
                                'st_arquivo' => $hashNome,
                                'st_nomearquivo' =>$nomeArquivo,
                                'st_descricao' => $st_descricao,
                                'st_pasta' => $caminho_armazenamento,
                                'st_extensao' => $extensao,
                            ];

                            //salva no banco
                            $salvouNoBanco = $this->arquivoService->createArquivoGenerico($dadosForm);
                            if($salvouNoBanco){
                                return redirect()
                                ->route('prontuario_pensionista', ['pensionistaId' => $pensionistaId,'aba' => 'arquivos', 'acao' => 'editar'])
                                ->with('sucessoMsg', "Salvo com sucesso!");
                            } else {
                                throw new Exception('Upload realizado mas houve falha ao salvar no banco de dados.');
                            }                            
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
                                $policial = auth()->user();
                                //salva o arquivo no banco
                                $dadosForm = [
                                    'ce_identificador' => $pensionistaId,
                                    'st_identificador' => "PENSIONISTA_ID",
                                    'dt_arquivo' => date('Y-m-d'),
                                    'ce_policial' => $policial->id,
                                    'st_tipodocumento' => $st_descricao,
                                    'st_modulo' => 'DPS',
                                    'st_motivo' => 'DOCUMENTO',
                                    'st_arquivo' => $hashNome,
                                    'st_nomearquivo' =>$nomeArquivo,
                                    'st_descricao' => $st_descricao,
                                    'st_pasta' => $caminho_armazenamento,
                                    'st_extensao' => $extensao,
                                ];
    
                                //salva no banco
                                $salvouNoBanco = $this->arquivoService->createArquivoGenerico($dadosForm);
                                if($salvouNoBanco){
                                    return redirect()
                                    ->back()
                                    ->with('sucessoMsg', "Salvo com sucesso!");
                                } else {
                                    throw new Exception('Upload realizado mas houve falha ao salvar no banco de dados.');
                                }                            
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