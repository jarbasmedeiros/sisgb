<?php
    namespace Modules\JuntaMedica\Http\Controllers;

    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Storage;
    use Modules\Api\Services\ProntuarioJPMSService;
    use Modules\Api\Services\ArquivoBancoService;
    use Modules\Api\Services\PolicialService;
    use Modules\Api\Services\JuntaMedica\SessaoService;
    use Maatwebsite\Excel\Facades\Excel;
    use App\utis\Funcoes;
    use App\utis\Msg;
    use Auth;

class ProntuarioJPMSController extends Controller {
        public function __construct(ProntuarioJPMSService $prontuarioJPMSService, ArquivoBancoService $ArquivoBancoService){
            $this->middleware('auth');
            $this->prontuarioJPMSService = $prontuarioJPMSService;
            $this->ArquivoBancoService = $ArquivoBancoService;
        }

        public function showFormProntuario() {
            return view('juntamedica::prontuario.busca_prontuario');      
        }

        /*@Author: Marcos Paulo #332
        /Retorna a lista de prontuarios de um policial na JPMS
        */
        public function showProntuario($idProntuario){    
            try {
                
                $prontuario = $this->prontuarioJPMSService->showProntuario($idProntuario);
                return view('juntamedica::prontuario.show_prontuario', compact('prontuario')); 
            } catch (Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }    
        }
        
        /*@Author: Marcos Paulo #332
        /Retorna a lista de prontuarios da busca
        */
        public function buscarProntuario(Request $request) {
            try{
                $dadosForm = $request->all();
                $prontuarios = $this->prontuarioJPMSService->buscarProntuarios($dadosForm);
                return view('juntamedica::prontuario.busca_prontuario', compact('prontuarios'));      
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }
        
        /*@Author: Marcos Paulo #332
        /Retorna a lista de pré-atendimentos abertos para o perito finalizar
        */
        public function listarAtendimentos() {
            try{
                $atendimentos = $this->prontuarioJPMSService->getAtendimentosAbertos();
                return view('juntamedica::prontuario.lista_atendimento', compact('atendimentos'));   
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }
        
        /*@Author: Marcos Paulo #332
        /Retorna o form de criação de pré-atendimento para o prontuario de um policial na JPMS
        */
        public function showPreAtendimento($idProntuario) {
            try{
                $prontuario = $this->prontuarioJPMSService->showProntuario($idProntuario);
                $sessoesabertas = $this->prontuarioJPMSService->getSessoesAbertas();
                if (count($sessoesabertas) > 0) {
                    return view('juntamedica::prontuario.pre_atendimento', compact('prontuario', 'sessoesabertas'));
                } else {
                    throw new Exception('Não existe sessão aberta.');
                }   
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }
        
        /*@Author: Marcos Paulo #332
        /Retorna um atendimento de um policial na JPMS pelo id
        */
        public function showAtendimento($idAtendimento){    
            try {
                $anexos = $this->prontuarioJPMSService->getAnexos($idAtendimento);
                $atendimento = $this->prontuarioJPMSService->showAtendimento($idAtendimento);
                return view('juntamedica::prontuario.show_atendimento', compact('anexos', 'atendimento')); 
            } catch (Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }    
        }

        /*@Author: Marcos Paulo #332
        /Retorna o form de criação de atendimento para o prontuario de um policial na JPMS
        */
        public function showFormAtendimento($idAtendimento) {
            try{
                $atendimento = $this->prontuarioJPMSService->showAtendimento($idAtendimento);
                $sessoesabertas = $this->prontuarioJPMSService->getSessoesAbertas();
                $restricoes = $this->prontuarioJPMSService->getRestricoes();
                $restricoesSelecionadas = [];
                foreach($atendimento->restricoes as $restricao){
                    $restricoesSelecionadas[] = $restricao->id;
                }
                $cids = $this->prontuarioJPMSService->getCIDs();
                $peritos = $this->prontuarioJPMSService->getPeritos();
                $anexos = $this->prontuarioJPMSService->getAnexos($idAtendimento);
                $cpfUsuario = Auth::user()->st_cpf;
                $bo_correcao = false;
                return view('juntamedica::prontuario.atendimento', compact('bo_correcao', 'anexos', 'atendimento', 'sessoesabertas', 'restricoes', 'cids', 'peritos', 'cpfUsuario', 'restricoesSelecionadas'));   
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }

        /*@Author: Marcos Paulo #332
        /Retorna o arquivo de um anexo para visualizar
        */
        public function verAnexo($id) {
            try{
                $anexo = $this->ArquivoBancoService->getArquivoGenerico($id);
                if(Storage::disk('ftp')->exists($anexo->st_pasta.$anexo->st_arquivo.'.'.$anexo->st_extensao)){
                    return Storage::disk('ftp')->response($anexo->st_pasta.$anexo->st_arquivo.'.'.$anexo->st_extensao);
                }else{
                    dd('Error');
                }
            }catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }
        
        /*@Author: Marcos Paulo #332
        /Retorna o form de criação de atendimento para o prontuario de um policial na JPMS
        */
        public function corrigirAtendimento($idSessao, $idAtendimento) {
            try{
                $atendimento = $this->prontuarioJPMSService->showAtendimento($idAtendimento);
                $sessoesabertas = $this->prontuarioJPMSService->getSessoesAbertas();
                $restricoes = $this->prontuarioJPMSService->getRestricoes();
                $restricoesSelecionadas = [];
                foreach($atendimento->restricoes as $restricao){
                    $restricoesSelecionadas[] = $restricao->id;
                }
                $cids = $this->prontuarioJPMSService->getCIDs();
                $peritos = $this->prontuarioJPMSService->getPeritos();
                $anexos = $this->prontuarioJPMSService->getAnexos($idAtendimento);
                $cpfUsuario = Auth::user()->st_cpf;
                $bo_correcao = true;
                return view('juntamedica::prontuario.atendimento', compact('idSessao', 'bo_correcao', 'anexos', 'atendimento', 'sessoesabertas', 'restricoes', 'cids', 'peritos', 'cpfUsuario', 'restricoesSelecionadas'));
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }
        
        /*@Author: Marcos Paulo #332
        //Cria um pré-atendimento para o prontuario de um policial na JPMS
        */
        public function cadastrarAtendimento(Request $request, $idProntuario) {
            try{
                $dados = $request->all();
                $this->prontuarioJPMSService->cadastrarAtendimento($idProntuario, $dados);
                
                return redirect('juntamedica/atendimentosabertos')->with('sucessoMsg', Msg::SALVO_SUCESSO);
            }catch(\Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        /*@Author: Marcos Paulo #332
        //Salva um atendimento para o prontuario de um policial na JPMS
        */
        public function salvarAtendimento(Request $request, $idProntuario, $idAtendimento) {
            try{
                $dados = $request->all();
                //verifica os campos do atendimento
                $validator = validator($dados, [
                    'ce_sessao' => 'required',
                    'dt_parecer' => 'required',
                    'st_parecer' => 'required',
                    'ce_perito' => 'required'
                ]);
                if($validator->fails()){
                    // Mensagem de erro com o formulário preenchido
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                switch($dados['st_parecer']){
                case 'APTO':
                    $dados['st_causaefeito'] = null;
                    $dados['st_restricao'] = null;
                    $dados['ce_cid'] = null;
                    $dados['dt_inicio'] = null;
                    $dados['nu_dias'] = null;
                    $dados['dt_termino'] = null;
                    break;
                case 'APTO COM RESTRIÇÃO (EM DEFINITIVO)':
                    //verifica os campos do atendimento
                    $validator = validator($dados, [
                        'st_causaefeito' => 'required',
                        'st_restricao' => 'required',
                        'ce_cid' => 'required',
                        'dt_inicio' => 'required'
                    ]);
                    if($validator->fails()){
                        // Mensagem de erro com o formulário preenchido
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $dados['nu_dias'] = null;
                    $dados['dt_termino'] = null;
                    break;
                case 'LICENÇA A. FAMILIAR':
                    //verifica os campos do atendimento
                    $validator = validator($dados, [
                        'dt_inicio' => 'required',
                        'nu_dias' => 'required',
                        'dt_termino' => 'required'
                    ]);
                    if($validator->fails()){
                        // Mensagem de erro com o formulário preenchido
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $dados['st_causaefeito'] = null;
                    $dados['st_restricao'] = null;
                    $dados['ce_cid'] = null;
                    break;
                }

                $this->prontuarioJPMSService->salvarAtendimento($idProntuario, $idAtendimento, $dados);

                if($dados['bo_correcao']){
                    return redirect('juntamedica/atendimento/corrigir/'.$dados['idSessao'].'/'.$idAtendimento)->with('sucessoMsg', Msg::SALVO_SUCESSO);
                }else{
                    return redirect('juntamedica/atendimento/editar/'.$idAtendimento)->with('sucessoMsg', Msg::SALVO_SUCESSO);
                }

            }catch(\Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        /*@Author: Marcos Paulo #332
        //Conclui um atendimento para o prontuario de um policial na JPMS
        */
        public function concluirAtendimento(Request $request, $idProntuario, $idAtendimento) {
            try{
                $dados = $request->all();
                //verifica os campos do atendimento
                $this->prontuarioJPMSService->concluirAtendimento($idProntuario, $idAtendimento);
                if(isset($dados['idSessao'])) {
                    return redirect('juntamedica/sessoes/'.$dados['idSessao'].'/sessaoaberta')->with('sucessoMsg', Msg::SALVO_SUCESSO);
                }else{
                    return redirect('juntamedica/atendimentosabertos')->with('sucessoMsg', Msg::SALVO_SUCESSO);
                }
            }catch(\Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        /* @author: Marcos Paulo #336
        // Anexa um arquivo em um atendimento para o prontuario de um policial na JPMS
        */
        public function deletarArquivo($idAtendimento, $idArquivo) {
            try{
                $arquivo = $this->ArquivoBancoService->getArquivoGenerico($idArquivo);
                //dd($arquivo);
                $caminho_armazenamento = $arquivo->st_pasta.$arquivo->st_arquivo.'.'.$arquivo->st_extensao;
                if(Storage::disk('ftp')->exists($caminho_armazenamento)){
                    Storage::disk('ftp')->delete($caminho_armazenamento);
                }else{
                    throw new Exception('Arquivo não encontrado no servidor de arquivos.');
                }
                $this->ArquivoBancoService->deleteArquivoGenerico($idArquivo);
                return redirect('juntamedica/atendimento/editar/'.$idAtendimento)->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
            }catch(\Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }
                    
        /*@Author: Marcos Paulo #332
        //Apaga um atendimento
        */
        public function excluirAtendimento($idAtendimento) {
            try{
                $this->prontuarioJPMSService->excluirAtendimento($idAtendimento);
                return redirect('juntamedica/atendimentosabertos')->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
            }catch(\Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }
        
        /*@Author: Marcos Paulo #332
        //Exibe o formulário de criação de um prontuario
        */
        public function criarProntuario() {
            return view('juntamedica::prontuario.criar_prontuario');   
        }
        
        /*@Author: Marcos Paulo #332
        //Busca as informações de um PM para criar um prontuario
        */
        public function buscarPM($cpfPM) {
            try{
                $cpf = Funcoes::limpaCPF_CNPJ($cpfPM);
                $pm = $this->prontuarioJPMSService->buscarPM($cpf);
                return $pm;   
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }
        
        /*@Author: Marcos Paulo #332
        //Cadastra um prontuario no banco de dados
        */
        public function cadastrarProntuario(Request $request) {
            try{
                $dados = $request->all();
                $prontuario = $this->prontuarioJPMSService->cadastrarProntuario($dados);
                return redirect('juntamedica/prontuario/show/'.$prontuario[0]->id)->with('sucessoMsg', Msg::SALVO_SUCESSO);   
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        /**
         * @author juanMojica - issue 339
         * @param int $idAtendimento
         * Retorna o comprovante em PDF de acordo com o parecer da JPMS
         */
        public function imprimirPdfAtendimentos($idAtendimento){
            try {
                $atendimento = $this->prontuarioJPMSService->showAtendimento($idAtendimento);
                $matricula = $this->mask($atendimento->st_matricula, '###.###-#');
                $atendimento->st_matricula = $matricula;
                if ($atendimento->st_parecer == "APTO") {
                    return view('juntamedica::pdf.pdfListaAtendimentoApto', compact('atendimento'));
                } elseif ($atendimento->st_parecer == "APTO COM RESTRIÇÃO" || $atendimento->st_parecer == "APTO COM RESTRIÇÃO (EM DEFINITIVO)") {
                    $restricoes = "";
                    foreach ($atendimento->restricoes as $r) {
                        if (count($atendimento->restricoes) == 1) {
                            $restricoes = $r->st_restricao;
                        } elseif (end($atendimento->restricoes) == $r) {
                            $restricoes = rtrim($restricoes, ", ");
                            $restricoes .= " e " . $r->st_restricao;
                        } else {
                            $restricoes .= $r->st_restricao . ", ";
                        }
                    }
                    return view('juntamedica::pdf.pdfListaAtendimentoAptoRestricao', compact('atendimento', 'restricoes'));
                } elseif ($atendimento->st_parecer == "LTS") {
                    return view('juntamedica::pdf.pdfListaAtendimentoLTS', compact('atendimento'));
                } else {
                    return redirect()->back()->with('erroMsg', 'Parecer inválido.');
                }                
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }
       
                /*@Author: Marcos Paulo #336
        //Sincroniza o prontuário médico com os dados do RH
        */
        public function sincronizarProntuario($idProntuario, $cpf) {
            try{
                $retorno = $this->prontuarioJPMSService->sincronizarProntuario($idProntuario, $cpf);
                return redirect('juntamedica/prontuario/show/'.$idProntuario)->with('sucessoMsg', $retorno->msg);
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        /**
         * @author juanMojica - issue 339
         * @param valor
         * @param máscara
         * Retorna o valor com a máscara, ambos são repassados como parâmetro
         */
        public function mask($val, $mask){
            $maskared = '';
            $k = 0;
            for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
                if ($mask[$i] == '#') {
                    if (isset($val[$k])) {
                        $maskared .= $val[$k++];
                    }
                } else {
                    if (isset($mask[$i])) {
                        $maskared .= $mask[$i];
                    }
                }
            }
            return $maskared;
        }

        /*@Author: Marcos Paulo #332
        //Salva um anexo para um atendimento para o prontuario de um policial na JPMS
        */
        public function salvarAnexoAtendimento(Request $request, $idProntuario, $idAtendimento, $idPolicial){
            try{
                $dados = $request->all();
                $arquivo = $request->file('arquivo');
                if(isset($arquivo)){
                    //verifica os campos do documento
                    $validator = validator($dados, [
                        'dt_documento' => 'required',
                        'st_tipodocumento' => 'required',
                        'st_descricao' => 'required'
                    ]);
                    if($validator->fails()){
                        // Mensagem de erro com o formulário preenchido
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    //verifica se o arquivo é válido
                    if($arquivo->isValid()){
                        //busca o nome do arquivo sem a extensão
                        $nomeArquivo = pathinfo($arquivo->getClientOriginalName(), PATHINFO_FILENAME);
                        $extensao = $arquivo->getClientOriginalExtension();
                        $extensoesPermitidas = array('pdf', 'jpg', 'jpeg', 'raw', 'bmp', 'gif', 'png', 'tiff' , 'psd' , 'exif', 'webp', 'eps', 'svg');
                        if(!in_array(strtolower($extensao), $extensoesPermitidas)){
                            throw new Exception('Falha ao realizar o upload, formato de arquivo não aceito, só é permitido imagens e pdf.');
                        }
                        $caminho_armazenamento = "juntamedica/".$idProntuario."/".$idAtendimento."/";
                        //testa se existe o diretorio do funcionario
                        if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                            //creates directory
                            Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                        }
                        //gera hash a partir do arquivo
                        $hashNome = hash_file('md5', $arquivo); 
                        //novo nome do arquivo com base no hash
                        $novoNome = $hashNome.'.'.$extensao;
                        //checa se o arquivo ja existe
                        if(!Storage::disk('ftp')->exists($caminho_armazenamento.$novoNome)){
                            //salva o arquivo no banco
                            $dadosForm = [
                                'ce_identificador' => $idAtendimento,
                                'st_identificador' => 'ATENDIMENTO_MEDICO',
                                'dt_arquivo' => $request->dt_documento,
                                'ce_policial' => $idPolicial,
                                'st_tipodocumento' => $request->st_tipodocumento,
                                'st_modulo' => 'JUNTA_MEDICA',
                                'st_motivo' => 'ANEXO_CRMEDICO',
                                'dt_envio' => date('Y-d-m H:i:s'),
                                'st_arquivo' => $hashNome,
                                'st_nomearquivo' => $nomeArquivo,
                                'st_descricao' => $request->st_descricao,
                                'st_pasta' => $caminho_armazenamento,
                                'st_extensao' => $extensao,
                            ];
                            //salva arquivo no ftp
                            $salvouNoFtp = Storage::disk('ftp')->put($caminho_armazenamento.$novoNome, fopen( $arquivo, 'r+')); 
                            if($salvouNoFtp){
                                //salva dados do arquivo no banco
                                $this->ArquivoBancoService->createArquivoGenerico($dadosForm);
                                return redirect()->back()->with('sucessoMsg', Msg::SALVO_SUCESSO);
                            }else{
                                throw new Exception('Falha ao realizar o upload, erro na base de dados de arquivos.');
                            }
                        } else {
                            throw new Exception('Arquivo já existe nesse atendimento.');
                        }
                    } else {
                        throw new Exception('Arquivo inválido.');
                    }
                }
            }catch(\Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        /** 
         * @author @juanmojica - #364
         * Retorna a Ficha de Evolução de atendimentos do policial em PDF
         * */  
        public function imprimirPdfFichaDeEvolucao($idProntuario){
            try {
                $prontuario = $this->prontuarioJPMSService->showProntuario($idProntuario);
                return view('juntamedica::pdf.fichaDeEvolucao', compact('prontuario'));
            } catch (\Exception $e) {
                redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

    }
    ?>