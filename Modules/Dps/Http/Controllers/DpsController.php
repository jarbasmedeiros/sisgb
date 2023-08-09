<?php

namespace Modules\Dps\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Modules\Api\Services\DpsService;
use Modules\Api\Services\RelatorioService;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\ArquivoBancoService;
use App\utis\Msg;
use App\utis\Funcoes;
use Auth;
use Exception;

class DpsController extends Controller
{
    public function __construct(ArquivoBancoService $arquivoService,DpsService $DpsService, RelatorioService $relatorioService, PolicialService $policialService ){
        $this->middleware('auth');
        $this->dpsService = $DpsService;
        $this->relatorioService = $relatorioService;
        $this->policialService = $policialService;
        $this->arquivoService = $arquivoService;
    }

    /**
     * cb Araújo
     * 10-01-2022
     * dashboard do menu lateral do sisgp
     */
    public function getDados(){
        $this->authorize('DASHBOARD_DPS');
        try{
            $dashboard = $this->dpsService->getDashboard();
            //dd($dashboard);
            return view('dps::dash.dashboardDps', compact('dashboard'));      
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function getMaisInformacoes($situacao)
    {
        $this->authorize('DASHBOARD_DPS');
        try{
            if ($situacao == 'inativos' || $situacao == 'reserva' || $situacao == 'reformados' || $situacao == 'mortos') {
                $prontuariosEmAcompanhamento = $this->dpsService->getSituacao($situacao);
                switch ($situacao) {
                    case "inativos":
                    $tipoProntuario = "Policiais Inativos";
                    break;
                    case "reserva":
                    $tipoProntuario = "Policiais da Reserva";
                    break;
                    case "reformados":
                    $tipoProntuario = "Policiais Reformados";
                    break;
                    case "mortos":
                    $tipoProntuario = "Policiais Falecidos";
                    break;
                }
                return view('dps::dash.listaProntuariosDps', compact('prontuariosEmAcompanhamento', 'tipoProntuario'));
            } else {
                return redirect()->back()->with('erroMsg', MSG::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function getAgendamentos($situacao,$mes){
        $this->authorize('DASHBOARD_DPS');
        try{
            $prontuariosEmAcompanhamento = $this->dpsService->getAgendamentos($situacao,$mes);
            if (isset($prontuariosEmAcompanhamento)) {
                switch ($mes) {
                    case '1':
                        $mes = 'Janeiro';
                        break;
                    case '2':
                        $mes = 'Fevereiro';
                        break;
                    case '3':
                        $mes = 'Março';
                        break;
                    case '4':
                        $mes = 'Abril';
                        break;
                    case '5':
                        $mes = 'Maio';
                        break;
                    case '6':
                        $mes = 'Junho';
                        break;
                    case '7':
                        $mes = 'Julho';
                        break;
                    case '8':
                        $mes = 'Agosto';
                        break;
                    case '9':
                        $mes = 'Setembro';
                        break;
                    case '10':
                        $mes = 'Outubro';
                        break;
                    case '11':
                        $mes = 'Novembro';
                        break;
                    case '12':
                        $mes = 'Dezembro';
                        break;                
                    default:
                        # code...
                        break;
                }
                return view(
                    'dps::dash.listaProntuariosDpsMes',
                    compact('prontuariosEmAcompanhamento','situacao','mes')
                );
            }
            return view(
                'dps::dash.listaProntuariosDpsMes',
                [
                    'prontuariosEmAcompanhamento' => [],
                    'situacao' => $situacao,
                    'mes' => $mes
                ]
            );
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * cb Araújo
     * 11-02-2022
     * Relatorio da DPS
     */
    public function getRelatorios(){
        try{
            $this->authorize('DASHBOARD_DPS'); // <<<<<<< MUDAR ISSO AQUI
            $dados = $this->relatorioService->getInformacoesParaFomularioRelatorioDinamico("0") ;
            $dados->colunas = get_object_vars($dados->colunas);
            if(isset($dados->colunas['ce_unidade'])){
                unset($dados->colunas['ce_unidade']);
                $dados->colunas['st_unidade'] = 'UNIDADE';
            }
            return view('dps::relatorio.index', compact('dados'));

       } catch (Exception $e) {
           return redirect()->back()->with('erroMsg', $e->getMessage());  
       }
    }

    public function filtro(Request $request)
    {
        $this->authorize('DASHBOARD_DPS'); // <<<<<<< MUDAR ISSO AQUI
        try{
            //dd("chegou no DPS controller filtro");           
            $dadosFom = $request->all();
            $dados = $this->relatorioService->filtro($dadosFom,"0");
            $funcionarios = $dados->policiais;
            $nome_colunas = $dados->nome_colunas;
            $response = $dados->response;
            $colunas = $dados->colunas;
            $nome_tabela = 'Relatório de policiais inativos';
            //dd($dados);
            // Se for clicando em excel, entao gera o arquivo
            if($request['excel']){
                return view('dps::relatorio.listagem_excel', compact('funcionarios', 'nome_colunas', 'colunas'));
            }
            // Se não, então mostra a view
            return view('dps::relatorio.listagem', compact('funcionarios', 'nome_colunas', 'nome_tabela', 'response', 'colunas'));
              
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @return mixed tela com os dados das habilitações, ou msg de erro
     */

    public function listarHabilitacoesPorUnidade() {
        try {
            $habilitacoes = $this->dpsService->listarHabilitacoesPorUnidade();
            return view('dps::habilitacoes.lista_habilitacoes_unidade', compact('habilitacoes'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage()); 
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @return mixed tela com uma barra de pesquisa para pesquisar policiais
     */

    public function findPMParaNovaHabilitacao() {
        try {
            return view('dps::habilitacoes.pesquisar_policial');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage()); 
        }  
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPolicial id do policial a ser recuperado
     *   @return mixed tela com o formulário para cadastrar um novo solicitante
     */

    public function telaNovoSolicitante($idPolicial) {
        try {
            return view('dps::habilitacoes.cadastrar_novo_solicitante', compact('idPolicial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage()); 
        }  
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param string $cpf cpf da pessoa a ser recuperada
     *   @param int $idHabilitacao id da habilitação ligada a essa pessoa
     *   @return mixed tela com o formulário para editar os dados de um solicitante
     */

    public function telaEditarSolicitante($cpf, $idHabilitacao) {
        try {
            $ufs = ["AC", "AL", "AP", "AM", "BA", "CE", "DF", 
                "ES", "GO", "MA", "MT", "MS", 
                "MG", "PA", "PB", "PR", "PE", 
                "PI", "RJ", "RN", "RS", "RO",
                "RR", "SC", "SP", "SE", "TO"];
            $solicitante = $this->dpsService->getPessoaByCPF($cpf);
            //dd($solicitante);
            if (isset($solicitante))
                return view(
                    'dps::habilitacoes.atualizar_solicitante',
                    compact('solicitante', 'idHabilitacao', 'ufs')
                );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage()); 
        }  
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $id id do policial a ser recuperado
     *   @return mixed tela com os dados dos beneficiarios e do policial, ou msg de erro
     */

    public function listarBeneficiariosPorPolicial($id) {
        try {
            $policial = $this->policialService->findPolicialById($id);
                if (empty($policial)) throw new Exception('Policial não localizado');
            $beneficiarios = $this->dpsService->listarBeneficiariosPorPolicial($id);
                if (empty($beneficiarios->beneficiarios)) $beneficiarios->beneficiarios = [];
                //dd($beneficiarios);
            return view(
                'dps::habilitacoes.lista_beneficiarios_policial',
                compact('policial', 'beneficiarios')
            );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage()); 
        }  
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPolicial id do policial a ser recuperado
     *   @param int $idPessoa id da pessoa a ser recuperada
     *   @return mixed tela com os dados da pessoa do policial, ou msg de erro
     */

    public function telaDadosPolicial($idPolicial, $idPessoa) {
        try {
            $dados = $this
                ->dpsService
                ->getDadosSolicitantePolicial($idPessoa, $idPolicial);
            if (isset($dados))
                return view(
                    'dps::habilitacoes.preencher_dados', 
                    compact('dados', 'idPolicial')
                );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage()); 
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param Request $request requisição com os dados do form
     *   @return mixed retorna os dados de um policial, ou msg de erro
     */

    public function getPolicialByCpfMatriculaParaHabilitacao(Request $request) {
        try {
            $st_parametro = Funcoes::addSlashesRecursivo($request->st_parametro);
            $st_parametro = str_replace(' ', '@', $st_parametro);
            $policiais = $this->dpsService->findPolicialNomeMatriculaCpf($st_parametro);
            if (isset($policiais))
                return view('dps::habilitacoes.pesquisar_policial', compact('policiais'));
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idHabilitacao id da habilitação a ser recuperada
     *   @return mixed tela com os dados da habilitação, ou msg de erro
     */

    public function getHabilitacaoById($idHabilitacao) {
        try {
            $dados = $this
                ->dpsService
                ->getHabilitacaoById($idHabilitacao);
            if (isset($dados))
                return view('dps::habilitacoes.preencher_arquivos', compact('dados'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPolicial policial ligado a habilitação
     *   @param int $idPessoa pessoa ligada a habilitação
     *   @param Request $request requisição com os dados do form
     *   @return mixed habilitação criada, ou msg de erro
     */

    public function createHabilitacao($idPolicial, $idPessoa, Request $request) {
        try {
            $dadosValidados = Funcoes::addSlashesRecursivo($request->all());
            $resposta = $this
                ->dpsService
                ->createHabilitacao($idPessoa, $idPolicial, $dadosValidados);
            if (isset($resposta))
                return redirect()->route('get_habilitacao_id', ['id' => $resposta->id]);
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idHabilitacao habilitacao ligada ao arquivo
     *   @param Request $request requisição que possui o arquivo
     *   @return mixed arquivo guardado no banco e no ftp, ou msg de erro
     */

    public function createArquivoHabilitacao($idHabilitacao, Request $request){
        try {
            $dadosValidados = Funcoes::addSlashesRecursivo($request->all());
            // Validação do envio do arquivo
            if (isset($request->arquivo)) {
                $arquivo = $request->arquivo;
                //verifica se o arquivo é válido
                $nomeArquivo = $arquivo->getClientOriginalName();
                if ($arquivo->isValid()) { 
                    $extensao = $arquivo->getClientOriginalExtension();
                    $hab = $this->dpsService->getHabilitacaoById($idHabilitacao);
                    $caminho_armazenamento = date('Y')."/"."DPS"."/"."habilitacao"."/".$hab->id."/";
                    //testa se existe o diretorio do funcionario
                    if (!Storage::disk('ftp')->exists($caminho_armazenamento)) { 
                        //creates directory
                        Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                    }
                    //gera hash a partir do arquivo
                    $hashNome = hash_file('md5', $arquivo); 
                    //novo nome do arquivo com base no hash
                    $novoNome = $hashNome.'.'.$extensao; 
                    //checa se o arquivo ja existe
                    if (!Storage::disk('ftp')->exists($caminho_armazenamento.$novoNome)) { 
                        //salva o arquivo no banco
                        $dadosForm = [
                            'ce_identificador' => $idHabilitacao,
                            'st_identificador' => "HABILITACAO_ID",
                            'dt_arquivo' => date('Y-m-d'),
                            'ce_policial' => $dadosValidados['ce_policial'],
                            'st_tipodocumento' => $dadosValidados['st_descricao'],
                            'st_modulo' => 'DPS',
                            'st_motivo' => 'ANEXO_HABILITACAO',
                            'st_arquivo' => $hashNome,
                            'st_nomearquivo' =>$nomeArquivo,
                            'st_descricao' => $dadosValidados['st_descricao'],
                            'st_pasta' => $caminho_armazenamento,
                            'st_extensao' => $extensao,
                        ];
                        //salva arquivo no ftp
                        $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                        if ($salvouNoFtp) {
                            //salva dados do arquivo no banco
                            $salvouNoBanco = $this->arquivoService->createArquivoGenerico($dadosForm);
                            if(isset($salvouNoBanco))
                                return redirect()
                                    ->route('get_habilitacao_id', ['idHabilitacao' => $idHabilitacao])
                                    ->with('sucessoMsg', 'Arquivo salvo com sucesso.');
                        } else {
                            throw new Exception('Falha ao realizar o upload.');
                        }
                    } else {
                        throw new Exception("Esse arquivo já está cadastrado para esta habilitação com o nome: ". $nomeArquivo);
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

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idHabilitacao habilitacao a ser recuperada
     *   @return mixed objeto com o histórico de alterações na habilitação
     */

    public function deleteArquivoHabilitacao($idHabilitacao, $ano, $nomeArquivo, $idArquivo) {
        try {
            $caminho = $ano.'/DPS/habilitacao/'.$idHabilitacao.'/'.$nomeArquivo;
            if (Storage::disk('ftp')->exists($caminho)) {
                // Exclui do banco
                $objeto = $this->dpsService->deleteArquivoGenerico($idArquivo);
                // Exclui do ftp
                Storage::disk('ftp')->delete($caminho);               
                return redirect()
                    ->route('get_habilitacao_id', ['id' => $idHabilitacao])
                    ->with('sucessoMsg', $objeto->msg);
            } else {
                throw new Exception('Arquivo não encontrado.');
            }
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idHabilitacao habilitacao do arquivo a ser recuperado
     *   @param string $ano ano do arquivo a ser recuperado
     *   @param string $nomeArquivo nome do arquivo a ser recuperado
     *   @return mixed visão do arquivo recuperado, ou msg de erro
     */

    public function getArquivoHabilitacao($idHabilitacao, $ano, $nomeArquivo) {
        try {
            $url = $ano.'/DPS/habilitacao/'.$idHabilitacao.'/'.$nomeArquivo;
            if (Storage::disk('ftp')->exists($url)) {
                $arquivoRetorno = Storage::disk('ftp')->get($url);
                $tipoArquivo = Storage::disk('ftp')->mimeType($url);
                $response = response($arquivoRetorno, 200); 
	            $response->header('Content-Type', $tipoArquivo);
                return $response;
            } else {
                throw new Exception('Arquivo não encontrado!');
            }
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idHabilitacao habilitacao ligada ao arquivo
     *   @param string $ano ano de registro do arquivo
     *   @param string $nomeArquivo nome do arquivo em questão
     *   @return mixed requisição de download do arquivo, ou msg de erro
     */

    public function downloadArquivoHabilitacao($idHabilitacao, $ano, $nomeArquivo) {
        try {
            $url = $ano.'/DPS/habilitacao/'.$idHabilitacao.'/'.$nomeArquivo;
            if (Storage::disk('ftp')->exists($url)) {
                return Storage::disk('ftp')->download($url);
            } else {
                throw new Exception('Arquivo não encontrado!');
            }
        } catch(Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     *  # 447-cadastrar-habilitacoes-dps
     *  @author Jherod Brendon
     *  @param int $idHabilitacao habilitação a ser registrada
     *  @return mixed habilitacao com status SOLICITADA, tela de dados da habilitação
     */

    public function finalizaCadastroHabilitacao($idHabilitacao) {
        try {
            $response = $this->dpsService->finalizaCadastroHabilitacao($idHabilitacao);
            if (isset($response))
                return redirect()
                    ->route('get_habilitacao_id', ['idHabilitacao' => $idHabilitacao])
                    ->with('sucessoMsg', $response->msg);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage()); 
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPolicial
     *   @param Request $request requisição com os dados do form
     *   @return mixed form de cadastro de habilitação, ou msg de erro
     */

    public function createPessoa($idPolicial, Request $request) {
        try {
            $dadosForm = Funcoes::addSlashesRecursivo($request->all());
            $response = $this->dpsService->createPessoa($dadosForm);
            if (isset($response))
                return redirect()->route('dps_tela_dados_solicitacao', [
                    'idPolicial' => $idPolicial,
                    'idPessoa' => $response->id
                ])->with('sucessoMsg', 'Solicitante cadastrado com susceso!');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param Request $request requisição com os dados do form
     *   @return mixed dados da pessoa, ou mensagem de erro
     */
    
    public function getPessoaByCPF(Request $request) {
        try {
            $idPolicial = $request->idPolicial;
            $cpf = Funcoes::addSlashesRecursivo($request->st_cpf);
            $solicitante = $this->dpsService->getPessoaByCPF($cpf);
            if (isset($solicitante))
                return view('dps::habilitacoes.cadastrar_novo_solicitante',
                    compact('idPolicial', 'solicitante')
                );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /** 
     * # 447-cadastrar-habilitacoes-dps
     *   @author Jherod Brendon
     *   @param int $idPessoa id da pessoa que será alterada
     *   @param int $idHabilitacao id da habilitacao ligada a pessoa
     *   @param Request $request requisição com os dados do formulário
     *   @return mixed tela com a habilitação e os dados da pessoa
     */

    public function updatePessoa($idPessoa, $idHabilitacao, Request $request) {
        try {
            $dadosForm = Funcoes::addSlashesRecursivo($request->all());
            $dadosValidados = validator(
                $dadosForm, 
                [
                    'st_nome' => 'required',
                    'st_cpf' => 'required|max:14'
                ]
            );
            $resposta = $this->dpsService->updatePessoa($idPessoa, $dadosForm);
            if (isset($resposta))
                return redirect()
                    ->route('get_habilitacao_id', ['idHabilitacao' => $idHabilitacao])
                    ->with('sucessoMsg', $resposta->msg);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
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
            $historico = $this->dpsService->getHistoricoByHabId($idHabilitacao);
            return $historico;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /** 
     * # 454-criar-comprovante-de-hablitacao
     *   @author Ana Carolina
     *   @param int $idHabilitacao habilitacao a ser recuperada
     *   @return mixed view com o pdf do comprovante
     */

    public function gerarComprovanteHabilitacao($idHabilitacao) {
        try {
            $comprovanteHabilitacao = $this->dpsService->getHabilitacaoById($idHabilitacao);
            if (isset($comprovanteHabilitacao))
                return \PDF::loadView('dps::habilitacoes.pdf.comprovanteHabilitacaoPDF',
                    compact('comprovanteHabilitacao'))
                    ->stream('comprovanteHabilitacaoPDF.pdf');
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

}