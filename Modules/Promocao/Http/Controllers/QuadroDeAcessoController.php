<?php namespace Modules\Promocao\Http\Controllers;

use App\Utis\Msg;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use Illuminate\Routing\Controller;

use Modules\Api\Services\BoletimService;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\NotaService;
use Modules\Api\Services\QuadroAcessoService;
use Modules\Api\Services\QuadroDeVagaService;
use Modules\Api\Services\ArquivoBancoService;
use Modules\Api\Services\QpmpService;
use Modules\Promocao\Entities\Cronograma;//P de promocao estava em minúsculo
use App\utis\Status;
use App\utis\FtpUtil;
use App\Ldap\Authldap;
use App\utis\Funcoes;
use DateTime;
use Exception;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Api\Services\GraduacaoService;
use Modules\Api\Services\UnidadeService;
use PHPExcel; 
use PHPExcel_IOFactory;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;

class QuadroDeAcessoController extends Controller{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    protected $QuadroAcessoService;
    protected $BoletimService;
    protected $PolicialService;
    protected $NotaService;
    protected $QpmpService;
    protected $Authldap;
    protected $ArquivoBancoService;
    protected $UnidadeService;
    protected $GraduacaoService;
    public function __construct(BoletimService $BoletimService, PolicialService $PolicialService, NotaService $NotaService, QuadroAcessoService $QuadroAcessoService, QpmpService $QpmpService, 
                                Authldap $Authldap, ArquivoBancoService $ArquivoBancoService, UnidadeService $UnidadeService, GraduacaoService $GraduacaoService){
        $this->middleware('auth');
        $this->BoletimService = $BoletimService;
        $this->QuadroAcessoService = $QuadroAcessoService;
        $this->PolicialService = $PolicialService;
        $this->NotaService = $NotaService;
        $this->QpmpService = $QpmpService;
        $this->Authldap = $Authldap;
        $this->ArquivoBancoService = $ArquivoBancoService;
        $this->UnidadeService = $UnidadeService;
        $this->GraduacaoService = $GraduacaoService;
        $this->QpmpService = $QpmpService;
    }

    public function index($competencia){
        try{
            if(($competencia != 'CPP') && ($competencia != 'JPMS') && ($competencia != 'TAF') && ($competencia != 'UNIDADE')){
                return redirect()->back()->with('erroMsg', 'Competência inválida!');
            }elseif($competencia == 'CPP'){
                $this->authorize('Lista_Todos_QA');
            }else{
                $this->authorize('Lista_QA_aberto');

            }
            $quadros = $this->QuadroAcessoService->listaQuadroAcesso($competencia);
            return view('promocao::quadroDeAcesso/listaDeQuadroDeAcesso', compact('quadros', 'competencia'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juanmojica - #467
     * Atribui a competêcia de acordo com o perfil setado e invoca a rota para exibir os quadros de acessos da respectiva competência
     * @return Redirect 
     */
    public function listaQuadrosDeAcesso(){
        try {
            $perfil = "";

            foreach (auth()->user()->vinculos as $vinculo) {
                if ($vinculo['id'] == auth()->user()->ce_vinculo) {
                    $perfil = $vinculo['st_role'];
                } 
            }

            $competencia = '';
            if (
                auth()->user()->perfil == '40' || 
                auth()->user()->perfil == '44' || 
                auth()->user()->perfil == '1036' || 
                auth()->user()->perfil == '1040' 
                /* $perfil == 'CPP-Unidades' || 
                $perfil == 'CPP-Unidades-Oficial' */
                ) 
            {
                $competencia = 'UNIDADE';

            } elseif (
                auth()->user()->perfil == '17' || 
                auth()->user()->perfil == '42' || 
                auth()->user()->perfil == '43' || 
                auth()->user()->perfil == '45' || 
                auth()->user()->perfil == '1038' || 
                auth()->user()->perfil == '1039') 
            {
                $competencia = 'CPP';

            } elseif (auth()->user()->perfil == '22') {
                $competencia = 'JPMS';

            } elseif (auth()->user()->perfil == '41' || auth()->user()->perfil == '1037') {
                $competencia = 'TAF';

            }else {
                throw new Exception ('Este perfil não tem competênia definida para acessar os Quadros de Acessos!');
            }
            return redirect("promocao/listadequadrodeacesso/competencia/$competencia");
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Lista policias do Quadro de Acesso
     * @param int $id
     * @return Response
     */
    public function listaefetivoParaQuadroAcesso($idQuadro, $idAtividade, $competencia){
        try{
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisDoQuadro($idQuadro);
            return view('promocao::listaPoliciaisQuadro', compact('quadro', 'policiaisQuadro', 'atividade', 'idQuadro', 'competencia'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    //Adiciona um policial para um quadro de acesso
    public function adicionarPolicialParaQuadroAcesso($idaQuadro, $idPolicialParQuadro){
        try{
            //verifica se existe o policial para Add quadro de Acesso
            $policial = $this->PolicialService->buscafuncionarioid($idPolicialParQuadro);
            if(empty($policial)){
                return "Policial não Encontrado";
            }else{

                //verifica se o policial ja está vinculado ao quadro de acesso
                $policialExiteNoQuadro = $this->QuadroAcessoService->GetPolicialQuadroId($idaQuadro, $idPolicialParQuadro);
                if(!empty($policialExiteNoQuadro)){
                    //caso o policial já esteja vinculado à nota, aborta a operação.
                    return 'O policial '.$policial->st_nome.' Já está Vinculado a esse Quadro de Acesso.';
                }
                //vincula o policial à nota
                $adicionarPolicialAnota = $this->QuadroAcessoService->vincularPolicialQuadro($idaQuadro, $idPolicialParQuadro);
               
                return $adicionarPolicialAnota;
            }
        }catch(Exception $e){
            return  $e->getMessage();
        }
        
    }
    //Remover um policial de um quadro de acesso
    public function removerPolicialDoQuadroAcesso($cePoliciaisDoQaudro, $idQuadroDeAcesso, $idAtividade){
        try{
            $removerPolicialAnota = $this->QuadroAcessoService->removerPolicialQuadro($cePoliciaisDoQaudro, $idQuadroDeAcesso);
            return redirect('promocao/listaefetivoparaquadro/'.$idQuadroDeAcesso.'/'.$idAtividade)->with('sucessoMsg', $removerPolicialAnota);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* /**
    * Método para listar o quantitativo de vagas
    *
    public function listarVagas(){
        try{
            $vagas = $this->QuadroAcessoService->getQuantitativoDeVagas();
            return view('promocao::quadroDeAcesso.quantitativoDeVagas', compact('vagas'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    } */
    
    /**
    * Método para Atualizar o quantitativo de vagas
    */
   /*  public function atualizaVagas(Request $request){
        try{
            $dadosForm = $request->all();
            $atualizados = $this->QuadroAcessoService->atualizaQuantitativoDeVagas($dadosForm);
            if($atualizados){
                return redirect()->back()->with('sucessoMsg', 'Quadro atualizado com Sucesso.');
            }else{
                return redirect()->back()->with('erroMsg', 'Ocorreu um erro inesperado ao atualizar o quantitativo de vagas.');
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    } */
    /**
    * Método para exibir a tela de cronograma do Quadro de Acesso.
    * @return Response
    */
    public function listaCronograma($idQuadro, $competencia){
        try{
            if(($competencia != 'CPP') && ($competencia != 'JPMS') && ($competencia != 'TAF') && ($competencia != 'UNIDADE')){
                return redirect()->back()->with('erroMsg', 'Competência inválida!');
            }
            
            $cronograma = $this->QuadroAcessoService->GetCronogramaQuadroId($idQuadro, $competencia);
            if($cronograma){
                return view('promocao::quadroDeAcesso/listaCronograma', compact('cronograma', 'idQuadro', 'competencia'));
            }else{
                return redirect()->back()->with('erroMsg', 'Erro Inesperado!!!');
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
    * Método para cadastrar uma nova atividade no cronograma do Quadro de Acesso.
    * @return Response
    */
    public function adicionarAtvidadeNoCronogramaDoQA(Request $request, $idQuadro){
        try{
            $dadosForm = $request->all();
            //Validando os dados
            $validator = validator($dadosForm, [
                'nu_fase' => 'required',
                'st_atividade' => 'required',
                'st_boletim' => 'required',
                'dt_atividade' => 'date|required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();//Mensagem de erro com o formulário preenchido
            }
            $adicionarAtividade = $this->QuadroAcessoService->adicionarAtividadenoCronograma($idQuadro, $dadosForm);
            return redirect('promocao/quadro/cronograma/'.$idQuadro)->with('sucessoMsg', $adicionarAtividade->msg);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
    * Método para remover uma atividade do cronograma do Quadro de Acesso.
    * @return Response
    */
    public function removerAtvidadeNoCronogramaDoQA($idQuadro, $idAtividade){
        try{
            $removerAtividade = $this->QuadroAcessoService->removerAtividadenoCronograma($idAtividade);
            return redirect('promocao/quadro/cronograma/'.$idQuadro)->with('sucessoMsg', $removerAtividade->msg);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
    * Método para concluir Relação de Efetivo para Quadro de Acesso.
    * @return Response
    */
    public function concluirRelacaoEfetivoParaQA($idAtividade){
        try{
            $concluirAtividade = $this->QuadroAcessoService->concluirAtividadeEfetivo($idAtividade);
            return redirect()->back()->with('sucessoMsg', $concluirAtividade);;
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    /**
     * Método que chama view para convocar soldados para jpms do Quadro de Acesso.
     * @return Response
     */
    public function convocarSoldadoJpms($idQuadro, $idAtividade, $competencia){
        try{
            $soldados = $this->QuadroAcessoService->listaPoliciaisParaConvocarJPMS($idQuadro, "SD");
            $soldadosConvocados = $soldados['convocar'];
            $soldadosAptos = $soldados['naoconvocar'];
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            return view('promocao::quadroDeAcesso/soldadoJpms', compact('soldadosConvocados', 'soldadosAptos', 'idQuadro', 'idAtividade', 'atividade', 'competencia'));
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método que salva dados da portaria para convocar soldados para jpms do Quadro de Acesso.
     * @return Response
     */
    public function convocarSoldadoJpmsStore(Request $request, $idQuadro, $idAtividade, $competencia){
        try{
            $dadosForm = $request->all();
            //Validando os dados
            $validator = validator($dadosForm, [
                'st_portaria' => 'required',
                'st_fechamento' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);//Mensagem de erro com o formulário preenchido
            }
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if($atividade->dt_atividade != null){
                return redirect()->back()->with('erroMsg', Msg::NAO_PERMITIDO);
            }
            $dadosForm['st_tipo'] = 'convocacaoJpms';
            $atualizaCronograma = $this->QuadroAcessoService->updatePortariaParaCronograma($idAtividade, $dadosForm);
            return redirect('promocao/convocarparajpms/soldado/'. $idQuadro . '/' . $idAtividade . '/competencia/' . $competencia)->with('sucessoMsg', $atualizaCronograma);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método que chama view para convocar cabos para jpms do Quadro de Acesso.
     * @return Response
     */
    public function convocarCaboJpms($idQuadro, $idAtividade, $competencia){
        try{
            $cabos = $this->QuadroAcessoService->listaPoliciaisParaConvocarJPMS($idQuadro, 'CB');
            $cabosConvocados = $cabos['convocar'];
            $cabosAptos = $cabos['naoconvocar'];
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            return view('promocao::quadroDeAcesso/caboJpms', compact('cabosConvocados', 'cabosAptos', 'idQuadro', 'idAtividade', 'atividade', 'competencia'));
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método que salva dados da portaria para convocar cabos para jpms do Quadro de Acesso.
     * @return Response
     */
    public function convocarCaboJpmsStore(Request $request, $idQuadro, $idAtividade, $competencia){
        try{
            $dadosForm = $request->all();
            //Validando os dados
            $validator = validator($dadosForm, [
                'st_portaria2' => 'required',
                'st_fechamento2' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);//Mensagem de erro com o formulário preenchido
            }
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if($atividade->dt_atividade != null){
                return redirect()->back()->with('erroMsg', Msg::NAO_PERMITIDO);
            }
            $dadosForm['st_tipo'] = 'convocacaoJpms';
            $atualizaCronograma = $this->QuadroAcessoService->updatePortariaParaCronograma($idAtividade, $dadosForm);
            return redirect('promocao/convocarparajpms/cabo/'. $idQuadro . '/' . $idAtividade . '/competencia/' . $competencia)->with('sucessoMsg', $atualizaCronograma);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método que chama view para convocar sargento para jpms do Quadro de Acesso.
     * @return Response
     */
    public function convocarSargentoJpms($idQuadro, $idAtividade, $competencia){
        try{
            $sargentos = $this->QuadroAcessoService->listaPoliciaisParaConvocarJPMS($idQuadro, 'SGT');
            $sargentosConvocados = $sargentos['convocar'];
            $sargentosAptos = $sargentos['naoconvocar'];
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            return view('promocao::quadroDeAcesso/sargentoJpms', compact('sargentosConvocados', 'sargentosAptos', 'idQuadro', 'idAtividade', 'atividade', 'competencia'));
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método que salva dados da portaria para convocar sargentos para jpms do Quadro de Acesso.
     * @return Response
     */
    public function convocarSargentoJpmsStore(Request $request, $idQuadro, $idAtividade, $competencia){
        try{
            $dadosForm = $request->all();
            //Validando os dados
            $validator = validator($dadosForm, [
                'st_portaria3' => 'required',
                'st_fechamento3' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);//Mensagem de erro com o formulário preenchido
            }
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if($atividade->dt_atividade != null){
                return redirect()->back()->with('erroMsg', Msg::NAO_PERMITIDO);
            }
            $dadosForm['st_tipo'] = 'convocacaoJpms';
            $atualizaCronograma = $this->QuadroAcessoService->updatePortariaParaCronograma($idAtividade, $dadosForm);
            return redirect('promocao/convocarparajpms/sargento/'. $idQuadro . '/' . $idAtividade. '/competencia/' . $competencia)->with('sucessoMsg', $atualizaCronograma);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function gerarNotaConvocacaoJpms(Request $request, $idQuadro, $idAtividade){
        try{
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if($atividade->st_portaria == null || $atividade->st_portaria2 == null || $atividade->st_portaria3 == null){
                return redirect()->back()->with('erroMsg', 'Ação não permitida!');
            }
             //resgata a unidade operacional do  policial
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);

            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', 'Informe a Senha Usuário.'); 
            }
            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', 'Senha inválida.'); 
            }

            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
            
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', 'O policial logado não está cadastrado ou vinculado a unidade operacional.');
            }
            $dadosForm = [];
            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['idUsuario'] = Auth::user()->id;
            $dadosForm['st_status'] = Status::NOTA_RASCUNHO;
            $dadosForm['nu_ano'] = date('Y');
            $dadosForm['ce_tipo'] = '12';
            $dadosForm['idAtividade'] = $idAtividade;
            $dadosForm['dt_cadastro'] = date('Y-d-m H:i:s');

            $policiais = $this->QuadroAcessoService->listaTodosPoliciaisDoQuadro($idQuadro);
            $tabelaSoldados = $tabelaSoldadosAptos = $tabelaCabos = $tabelaCabosAptos = $tabelaSargentos = $tabelaSargentosAptos = '';
            $contadorSoldados = $contadorSoldadosAptos = $contadorCabos = $contadorCabosAptos = $contadorSargentos = $contadorSargentosAptos = 1;
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
            if($policiais->count() > 0){
                foreach($policiais as $pol){
                    switch($pol->st_postgrad){
                        case "SD":
                            if($pol->st_inspecaojuntaparecer == null ){
                                $tabelaSoldados .= "<tr>";
                                    $tabelaSoldados .= "<th>" . $contadorSoldados . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_postgrad . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_numpraca . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_policial . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_matricula . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_unidade . "</th>";
                                $tabelaSoldados .= "</tr>";
                                $contadorSoldados++;
                            } elseif(strpos($pol->st_inspecaojuntaparecer, 'Apto') !== false && ($pol->bo_inspecionadojunta != 1 || $pol->bo_inspecionadojunta == null)){
                                $tabelaSoldadosAptos .= "<tr>";
                                    $tabelaSoldadosAptos .= "<th>" . $contadorSoldadosAptos . "</th>";
                                    $tabelaSoldadosAptos .= "<th>" . $pol->st_postgrad . "</th>";
                                    $tabelaSoldadosAptos .= "<th>" . $pol->st_numpraca . "</th>";
                                    $tabelaSoldadosAptos .= "<th>" . $pol->st_policial . "</th>";
                                    $tabelaSoldadosAptos .= "<th>" . $pol->st_matricula . "</th>";
                                    $tabelaSoldadosAptos .= "<th>" . $pol->st_unidade . "</th>";
                                    $tabelaSoldadosAptos .= "<th>Apto até " . date('d/m/Y', strtotime($pol->dt_inspecaosaude)) . "</th>";
                                $tabelaSoldadosAptos .= "</tr>";
                                $contadorSoldadosAptos++;
                            }
                            break;
                        case "CB":
                            if($pol->st_inspecaojuntaparecer == null ){
                                $tabelaCabos .= "<tr>";
                                    $tabelaCabos .= "<th>" . $contadorCabos . "</th>";
                                    $tabelaCabos .= "<th>" . $pol->st_postgrad . "</th>";
                                    $tabelaCabos .= "<th>" . $pol->st_numpraca . "</th>";
                                    $tabelaCabos .= "<th>" . $pol->st_policial . "</th>";
                                    $tabelaCabos .= "<th>" . $pol->st_matricula . "</th>";
                                    $tabelaCabos .= "<th>" . $pol->st_unidade . "</th>";
                                $tabelaCabos .= "</tr>";
                                $contadorCabos++;
                            } elseif(strpos($pol->st_inspecaojuntaparecer, 'Apto') !== false && ($pol->bo_inspecionadojunta != 1 || $pol->bo_inspecionadojunta == null)){
                                $tabelaCabosAptos .= "<tr>";
                                    $tabelaCabosAptos .= "<th>" . $contadorCabosAptos . "</th>";
                                    $tabelaCabosAptos .= "<th>" . $pol->st_postgrad . "</th>";
                                    $tabelaCabosAptos .= "<th>" . $pol->st_numpraca . "</th>";
                                    $tabelaCabosAptos .= "<th>" . $pol->st_policial . "</th>";
                                    $tabelaCabosAptos .= "<th>" . $pol->st_matricula . "</th>";
                                    $tabelaCabosAptos .= "<th>" . $pol->st_unidade . "</th>";
                                    $tabelaCabosAptos .= "<th>Apto até " . date('d/m/Y', strtotime($pol->dt_inspecaosaude)) . "</th>";
                                $tabelaCabosAptos .= "</tr>";
                                $contadorCabosAptos++;
                            }
                            break;
                        case strpos($pol->st_postgrad, 'SGT') !== false:
                            if($pol->st_inspecaojuntaparecer == null ){
                                $tabelaSargentos .= "<tr>";
                                    $tabelaSargentos .= "<th>" . $contadorSargentos . "</th>";
                                    $tabelaSargentos .= "<th>" . $pol->st_postgrad . "</th>";
                                    $tabelaSargentos .= "<th>" . $pol->st_numpraca . "</th>";
                                    $tabelaSargentos .= "<th>" . $pol->st_policial . "</th>";
                                    $tabelaSargentos .= "<th>" . $pol->st_matricula . "</th>";
                                    $tabelaSargentos .= "<th>" . $pol->st_unidade . "</th>";
                                $tabelaSargentos .= "</tr>";
                                $contadorSargentos++;
                            } elseif(strpos($pol->st_inspecaojuntaparecer, 'Apto') !== false && ($pol->bo_inspecionadojunta != 1 || $pol->bo_inspecionadojunta == null)){
                                $tabelaSargentosAptos .= "<tr>";
                                    $tabelaSargentosAptos .= "<th>" . $contadorSargentosAptos . "</th>";
                                    $tabelaSargentosAptos .= "<th>" . $pol->st_postgrad . "</th>";
                                    $tabelaSargentosAptos .= "<th>" . $pol->st_numpraca . "</th>";
                                    $tabelaSargentosAptos .= "<th>" . $pol->st_policial . "</th>";
                                    $tabelaSargentosAptos .= "<th>" . $pol->st_matricula . "</th>";
                                    $tabelaSargentosAptos .= "<th>" . $pol->st_unidade . "</th>";
                                    $tabelaSargentosAptos .= "<th>Apto até " . date('d/m/Y', strtotime($pol->dt_inspecaosaude)) . "</th>";
                                $tabelaSargentosAptos .= "</tr>";
                                $contadorSargentosAptos++;
                            }
                            break;
                    }
                }
            }

            $dadosForm['st_assunto'] = 'INSPEÇÃO DE SAÚDE PARA FINS DE INCLUSÃO EM QUADRO DE ACESSO';
            $dadosForm['st_materia'] = $atividade->st_portaria . '</br>';
            $dadosForm['st_materia'] .= "<p>A) POLICIAIS QUE DEVERÃO SER INSPECIONADOS PELA JPMS:</p>";
            $dadosForm['st_materia'] .= '<table border="1" style="width: 100%;">
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>GRAD</th>
                        <th>Nº DE PRAÇA</th>
                        <th>NOME</th>
                        <th>MAT</th>
                        <th>OME</th>
                    </tr>
                </thead>
                <tbody>';
                    if($tabelaSoldados == ''){
                        $dadosForm['st_materia'] .= "<tr><th colspan='6'>Não há soldados</th></tr>";
                    }else{
                        $dadosForm['st_materia'] .= $tabelaSoldados;
                    }
                $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= "<p>B) POLICIAIS EM DIA COM A JPMS, COM A RESPECTIVA DATA DE VALIDADE, QUE NÃO HÁ NECESSIDADE DE COMPARECIMENTO:</p>";
            $dadosForm['st_materia'] .= "<table border='1' style='width: 100%;'>
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>GRAD</th>
                        <th>Nº DE PRAÇA</th>
                        <th>NOME</th>
                        <th>MAT</th>
                        <th>OME</th>
                        <th>JPMS</th>
                    </tr>
                </thead>
                <tbody>";
                    if($tabelaSoldadosAptos == ''){
                        $dadosForm['st_materia'] .= "<tr><th colspan='7'>Não há soldados</th></tr>";
                    }else{
                        $dadosForm['st_materia'] .= $tabelaSoldadosAptos;
                    }
                $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= $atividade->st_fechamento . "</br>";
            $dadosForm['st_materia'] .= $atividade->st_portaria2 . '</br>';
            $dadosForm['st_materia'] .= "<p>A) POLICIAIS QUE DEVERÃO SER INSPECIONADOS PELA JPMS:</p>";
            $dadosForm['st_materia'] .= "<table border='1' style='width: 100%;'>
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>GRAD</th>
                        <th>Nº DE PRAÇA</th>
                        <th>NOME</th>
                        <th>MAT</th>
                        <th>OME</th>
                    </tr>
                </thead>
                <tbody>";
                    if($tabelaCabos == ''){
                        $dadosForm['st_materia'] .= "<tr><th colspan='6'>Não há cabos</th></tr>";
                    }else{
                        $dadosForm['st_materia'] .= $tabelaCabos;
                    }
                $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= "<p>B) POLICIAIS EM DIA COM A JPMS, COM A RESPECTIVA DATA DE VALIDADE, QUE NÃO HÁ NECESSIDADE DE COMPARECIMENTO:</p>";
            $dadosForm['st_materia'] .= "<table border='1' style='width: 100%;'>
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>GRAD</th>
                        <th>Nº DE PRAÇA</th>
                        <th>NOME</th>
                        <th>MAT</th>
                        <th>OME</th>
                        <th>JPMS</th>
                    </tr>
                </thead>
                <tbody>";
                    if($tabelaCabosAptos == ''){
                        $dadosForm['st_materia'] .= "<tr><th colspan='7'>Não há cabos</th></tr>";
                    }else{
                        $dadosForm['st_materia'] .= $tabelaCabosAptos;
                    }
                $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= $atividade->st_fechamento2 . "</br>";
            $dadosForm['st_materia'] .= $atividade->st_portaria3 . '</br>';
            $dadosForm['st_materia'] .= "<p>A) POLICIAIS QUE DEVERÃO SER INSPECIONADOS PELA JPMS:</p>";
            $dadosForm['st_materia'] .= "<table border='1' style='width: 100%;'>
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>GRAD</th>
                        <th>Nº DE PRAÇA</th>
                        <th>NOME</th>
                        <th>MAT</th>
                        <th>OME</th>
                    </tr>
                </thead>
                <tbody>";
                    if($tabelaSargentos == ''){
                        $dadosForm['st_materia'] .= "<tr><th colspan='6'>Não há sargentos</th></tr>";
                    }else{
                        $dadosForm['st_materia'] .= $tabelaSargentos;
                    }
                $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= "<p>B) POLICIAIS EM DIA COM A JPMS, COM A RESPECTIVA DATA DE VALIDADE, QUE NÃO HÁ NECESSIDADE DE COMPARECIMENTO:</p>";
            $dadosForm['st_materia'] .= "<table border='1' style='width: 100%;'>
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>GRAD</th>
                        <th>Nº DE PRAÇA</th>
                        <th>NOME</th>
                        <th>MAT</th>
                        <th>OME</th>
                        <th>JPMS</th>
                    </tr>
                </thead>
                <tbody>";
                    if($tabelaSargentosAptos == ''){
                        $dadosForm['st_materia'] .= "<tr><th colspan='7'>Não há sargentos</th></tr>";
                    }else{
                        $dadosForm['st_materia'] .= $tabelaSargentosAptos;
                    }
                $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= $atividade->st_fechamento3 . "</br>";
            $criaNota = $this->QuadroAcessoService->criarNotaConvocacaoJpms($dadosForm, $idQuadro);
            return redirect()->back()->with('sucessoMsg', $criaNota);
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function concluirResultadoJpms(Request $request, $idQuadro, $idAtividade, $tiporenderizacao){
        try{
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if($atividade->st_portaria == null){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }
             //resgata a unidade operacional do  policial
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);

            if($tiporenderizacao != "visualizar"){
                if(!isset($request['password'])){
                    return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
                }                
                $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
                //Validando credencais
                $ldap = $this->Authldap->autentica($credenciais);
                if($ldap == false){
                    return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
                }
            }

            $listaComissao = "";
            $comissao = $this->QuadroAcessoService->listaPolicialAssinaturaPortaria($idAtividade);
            foreach($comissao as $c){
                if($c->st_assinatura != null){
                    $listaComissao .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. mb_strtoupper($c->st_nomeassinante, 'UTF-8') .', '. QuadroDeAcessoController::titleCase($c->st_postograd) .' - '. QuadroDeAcessoController::titleCase($c->st_funcao).'.<br>';
                }
            }

            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
            
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', 'O policial logado não está cadastrado ou vinculado a unidade operacional.');
            }
            $dadosForm = [];
            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['idUsuario'] = Auth::user()->id;
            $dadosForm['st_status'] = Status::NOTA_RASCUNHO;
            $dadosForm['nu_ano'] = date('Y');
            $dadosForm['ce_tipo'] = '13';
            $dadosForm['idAtividade'] = $idAtividade;
            $dadosForm['dt_cadastro'] = date('Y-d-m H:i:s');
            $dadosForm['st_assunto'] = 'RESULTADO DA INSPEÇÃO DE SAÚDE PARA FINS DE INCLUSÃO EM QUADRO DE ACESSO';
            $dadosForm['st_materia'] = $atividade->st_portaria;
            $policiais = $this->QuadroAcessoService->listarTodosPoliciaisInspecionadosJPMS($idQuadro);
            $tabelaSargentos = $tabelaCabos = $tabelaSoldados = '';
            $contadorSargentos = $contadorCabos = $contadorSoldados = 1;
            if(count($policiais) > 0){
                foreach($policiais as $pol){
                    switch($pol->st_postgrad){
                        case "SD":
                            $tabelaSoldados .= "<tr>";
                                $tabelaSoldados .= "<th>" . $contadorSoldados . "</th>";
                                $tabelaSoldados .= "<th>" . $pol->st_postgrad . "</th>";
                                $tabelaSoldados .= "<th>" . $pol->st_numpraca . "</th>";
                                $tabelaSoldados .= "<th>" . $pol->st_policial . "</th>";
                                $tabelaSoldados .= "<th>" . $pol->st_matricula . "</th>";
                                $tabelaSoldados .= "<th>" . $pol->st_unidade . "</th>";
                                if($pol->bo_pendenciapreanalisejpms == 1){
                                    $tabelaSoldados .= "<th>" . "Pendente" . "</th>";
                                }else{
                                    $tabelaSoldados .= "<th>" . $pol->st_inspecaojuntaparecer . "</th>";
                                }
                               
                            $tabelaSoldados .= "</tr>";
                            $contadorSoldados++;
                            break;
                        case "CB":
                            $tabelaCabos .= "<tr>";
                                $tabelaCabos .= "<th>" . $contadorCabos . "</th>";
                                $tabelaCabos .= "<th>" . $pol->st_postgrad . "</th>";
                                $tabelaCabos .= "<th>" . $pol->st_numpraca . "</th>";
                                $tabelaCabos .= "<th>" . $pol->st_policial . "</th>";
                                $tabelaCabos .= "<th>" . $pol->st_matricula . "</th>";
                                $tabelaCabos .= "<th>" . $pol->st_unidade . "</th>";
                                if($pol->bo_pendenciapreanalisejpms == 1){
                                    $tabelaCabos .= "<th>" . "Pendente" . "</th>";
                                }else{
                                    $tabelaCabos .= "<th>" . $pol->st_inspecaojuntaparecer . "</th>";
                                }
                                
                            $tabelaCabos .= "</tr>";
                            $contadorCabos++;
                            break;
                        case strpos($pol->st_postgrad, 'SGT') !== false:
                            $tabelaSargentos .= "<tr>";
                                $tabelaSargentos .= "<th>" . $contadorSargentos . "</th>";
                                $tabelaSargentos .= "<th>" . $pol->st_postgrad . "</th>";
                                $tabelaSargentos .= "<th>" . $pol->st_numpraca . "</th>";
                                $tabelaSargentos .= "<th>" . $pol->st_policial . "</th>";
                                $tabelaSargentos .= "<th>" . $pol->st_matricula . "</th>";
                                $tabelaSargentos .= "<th>" . $pol->st_unidade . "</th>";
                                if($pol->bo_pendenciapreanalisejpms == 1){
                                    $tabelaSargentos .= "<th>" . "Pendente" . "</th>";
                                }else{
                                    $tabelaSargentos .= "<th>" . $pol->st_inspecaojuntaparecer . "</th>";
                                }
                            $tabelaSargentos .= "</tr>";
                            $contadorSargentos++;
                            break;
                    }
                }
            }
            $dadosForm['st_materia'] .= "<p style='text-align:center;'><strong>SARGENTOS</strong></p>";
            $dadosForm['st_materia'] .= "<table border='1' style='width: 100%;'>
                <thead>
                    <tr>
                        <th>ORD.</th>
                        <th>GRAD.</th>
                        <th>Nº</th>
                        <th>NOME</th>
                        <th>MAT.</th>
                        <th>OPM</th>
                        <th>PARECER</th>
                    </tr>
                </thead>
                <tbody>";
                if($tabelaSargentos == ''){
                    $dadosForm['st_materia'] .= "<tr><th colspan='7'>Não há sargentos</th></tr>";
                }else{
                    $dadosForm['st_materia'] .= $tabelaSargentos;
                }
            $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= "<p style='text-align:center;'><strong>CABOS</strong></p>";
            $dadosForm['st_materia'] .= "<table border='1' style='width: 100%;'>
                <thead>
                    <tr>
                        <th>ORD.</th>
                        <th>GRAD.</th>
                        <th>Nº</th>
                        <th>NOME</th>
                        <th>MAT.</th>
                        <th>OPM</th>
                        <th>PARECER</th>
                    </tr>
                </thead>
                <tbody>";
                if($tabelaCabos == ''){
                    $dadosForm['st_materia'] .= "<tr><th colspan='7'>Não há cabos</th></tr>";
                }else{
                    $dadosForm['st_materia'] .= $tabelaCabos;
                }
            $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= "<p style='text-align:center;'><strong>SOLDADOS</strong></p>";
            $dadosForm['st_materia'] .= "<table border='1' style=' width: 100%;'>
                <thead>
                    <tr>
                        <th>ORD.</th>
                        <th>GRAD.</th>
                        <th>Nº</th>
                        <th>NOME</th>
                        <th>MAT.</th>
                        <th>OPM</th>
                        <th>PARECER</th>
                    </tr>
                </thead>
                <tbody>";
                if($tabelaSoldados == ''){
                    $dadosForm['st_materia'] .= "<tr><th colspan='7'>Não há soldados</th></tr>";
                }else{
                    $dadosForm['st_materia'] .= $tabelaSoldados;
                }
            $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= $listaComissao;

            if($tiporenderizacao == "visualizar"){
                $nota = (object)$dadosForm;
                return \PDF::loadView('boletim::notas/pdf_nota', compact('nota'))->stream('nota.pdf');
            }else{
                $criaNota = $this->QuadroAcessoService->criarNota($dadosForm, $idQuadro);
                return redirect()->back()->with('sucessoMsg', $criaNota);
            }

        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que retorna uma lista de Sargentos de um QA de acordo com o estado da ficha de reconhecimento naoenviada.
     * @autor: Talysson
     * @return Response
     */
    public function listaSgtEscriturarNaoEnviada($idQuadro, $idAtividade, $competencia){
        try{
           
            $titulopainel = 'Quadro de acesso para promoção de ';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            $policiaisQuadro = $this->QuadroAcessoService->listaSgtEscriturarNaoEnviadaPaginado($idQuadro, auth()->user()->ce_unidade);

            $unidades = $this->UnidadeService->getUnidade();
           
            $graduacoes = $this->GraduacaoService->getGraduacao();
            
            $qpmps = $this->QpmpService->getQpmp();

            $contador_inicial = 0;
            if(method_exists($policiaisQuadro,'currentPage')){
              $contador_inicial =($policiaisQuadro->currentPage()-1) * 30;
            }

            return view('promocao::quadroDeAcesso/listaEfetivoEscriturarFichaNaoEnviada', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'contador_inicial', 'unidades', 'graduacoes', 'qpmps'));
        
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que retorna uma lista de Sargentos de um QA, que enviaram recurso e não foram avaliadas.
     * @autor: Talysson
     * @return Response
     */
    public function listaAnalisarRecurso($idQuadro, $idAtividade, $competencia){
        try{
            $titulopainel = 'Quadro de acesso para promoção de ';
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaSgtAnalisarRecursosPaginado($idQuadro, 2);
            return view('promocao::quadroDeAcesso/listaPmsRecursosNaoAvaliados', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia'));
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que retorna uma lista de Sargentos de um QA, que enviaram recurso e foram avaliadas.
     * @autor: Talysson
     * @return Response
     */
    public function listaRecursosAvaliados($idQuadro, $idAtividade, $competencia){
        try{
            $titulopainel = 'Quadro de acesso para promoção de ';
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaSgtRecursosAvaliadosPaginado($idQuadro, 2);
            return view('promocao::quadroDeAcesso/listaPmsRecursosAvaliados', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia'));
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que a tela de recurso do policial no processo de escriturar ficha de reconhecimento
     * @autor: Talysson
     * @return Response
     */
    public function AnalisarRecurso($idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{
            $ficha = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            $pontuacoes = $ficha->pontuacoes;
            $fichaPolicial = $this->QuadroAcessoService->findPolicialDoQuadroAcessoById($idQuadro, $idPolicial);
            if($fichaPolicial->bo_recursoanalisado == 1){
                throw new Exception('Falha, o recurso já foi avaliado.');
            }elseif($fichaPolicial->bo_fichahomologada != 1){
                throw new Exception('Esta ficha não foi homologada!');
            }
            $arquivos = $this->ArquivoBancoService->findArquivoIdQuadroIdPolicial($idQuadro, $idPolicial);
            return view('promocao::quadroDeAcesso/analisarRecurso', compact('fichaPolicial', 'ficha', 'idQuadro', 'idPolicial', 'idAtividade', 'pontuacoes', 'arquivos', 'competencia'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que salva a avaliação do recurso do policial no processo de escriturar ficha de reconhecimento
     * @autor: Talysson
     * @return Response
     */
    public function salvarAnaliseRecurso(Request $request, $idQuadro, $idAtividade, $idPolicial, $finalizarAnalise = null)
    {
        try{
            $dadosForm = $request->all();
            if(isset($dadosForm['_token'])){
                unset($dadosForm['_token']);
            }
            if(isset($dadosForm['password'])){
                unset($dadosForm['password']);
            }
            // Validação dos dados
            if(!isset($dadosForm['st_parecerrecurso']) || empty($dadosForm['st_parecerrecurso']) ||
               !isset($dadosForm['st_respostarecurso']) || empty($dadosForm['st_respostarecurso'])){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }
            if(strlen($dadosForm['st_respostarecurso']) > 500){
                throw new Exception('Falha, a resposta ao recurso não pode exceder 500 caracteres.');
            }
            if(isset($dadosForm['st_recurso'])){
                unset($dadosForm['st_recurso']);
            }
            // Separando as informações da resposta ao recurso
            $dadosRecurso = [
                'st_parecerrecurso' => $dadosForm['st_parecerrecurso'],
                'st_respostarecurso' => $dadosForm['st_respostarecurso']
            ];
            unset($dadosForm['st_parecerrecurso']);
            unset($dadosForm['st_respostarecurso']);
            // Separando as informações dos pontos
            $dadosHomologar = [];
            foreach ($dadosForm as $key => $value) {
                if(isset($dadosForm[$key]['bo_pontoaceito'])){
                    // $dadosHomologar[$key] = $dadosForm[$key]['bo_pontoaceito'];
                    array_push($dadosHomologar, $dadosForm[$key]['bo_pontoaceito']);
                    unset($dadosForm[$key]['bo_pontoaceito']);
                }
            }
            $enviar = 1;
            // Salva a ficha
            $fichaUpdate = $this->atualizaFichaReconhecimento($request, $idQuadro, $idAtividade, $idPolicial, $enviar, $competencia, $dadosForm);
            // Caso seja salvo com sucesso, a vaiável retorna nula
            if(!empty($fichaUpdate)){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }
            // Envia a ficha salva
            $this->QuadroAcessoService->enviarFichaEscriturada($idAtividade, $idPolicial);
            // Homologa os pontos
            $this->homologarValidacaoFichaReconhecimento($request, $idQuadro, $idAtividade, $idPolicial, $dadosHomologar);
            // Salva os dados da resposta ao recurso levantado
            $mensagemRetorno = $this->QuadroAcessoService->salvarAnaliseRecurso($idQuadro, $idPolicial, $dadosRecurso);
            if($finalizarAnalise != 1){
                return redirect('promocao/analisarrecurso/'.$idQuadro.'/atividade/'.$idAtividade.'/policial/'.$idPolicial.'/competencia/'.$competencia)->with('sucessoMsg', $mensagemRetorno);
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    public function finalizarAnaliseRecurso(Request $request, $idQuadro, $idAtividade, $idPolicial)
    {
        try{
            $finalizarAnalise = 1;
            // Salva os dados do formulário
            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
            }
            $ldap = $this->Authldap->autenticar($request['password']);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
            }
            $this->salvarAnaliseRecurso($request, $idQuadro, $idAtividade, $idPolicial, $finalizarAnalise);
            $mensagemRetorno = $this->QuadroAcessoService->finalizarAnaliseRecurso($idQuadro, $idPolicial);
            return redirect('promocao/listarecursosavaliados/'.$idQuadro.'/'.$idAtividade)->with('sucessoMsg', $mensagemRetorno);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método que retorna uma lista de Sargentos de um QA de acordo com o estado com uma busca específica (nome, CPF ou matrícula).
     * @autor: Talysson
     * @return Response
     */
    public function buscaSgtCpfMatriculaNomeRecurso(Request $request, $idQuadro, $idAtividade, $enviada, $competencia)
    {
        try{
            $dadosForm = $request->all();
            $policiaisQuadro = $this->QuadroAcessoService->getSgtCpfMatriculaNome($idQuadro, $dadosForm);
            $titulopainel = 'Quadro de acesso para promoção de ';
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            
            //Verifica em qual tela está sendo feita a consulta
            if($enviada == 1){
                return view('promocao::quadroDeAcesso/listaPmsRecursosAvaliados', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia'));
            }elseif($enviada == 0){
                return view('promocao::quadroDeAcesso/listaPmsRecursosNaoAvaliados', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia'));
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método que retorna uma lista de Sargentos de um QA de acordo com o estado da ficha de reconhecimento enviada.
     * @autor: Talysson
     * @return Response
     */
    public function listaSgtEscriturarEnviada($idQuadro, $idAtividade, $competencia){
        try{
           
            $titulopainel = 'Quadro de acesso para promoção de ';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            $policiaisQuadro = $this->QuadroAcessoService->listaSgtEscriturarEnviadaPaginado($idQuadro, auth()->user()->ce_unidade);

            $unidades = $this->UnidadeService->getUnidade();
           
            $graduacoes = $this->GraduacaoService->getGraduacao();
            
            $qpmps = $this->QpmpService->getQpmp();

            return view('promocao::quadroDeAcesso/listaEfetivoEscriturarFichaEnviada', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'unidades', 'graduacoes', 'qpmps'));
        
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que retorna uma tela com os dados da ficha de reconhecimento para edição e envio.
     * @autor: Talysson (refatoração)
     * @return Response
     */
    public function escriturarFichaReconhecimento($idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            //$pontuacoes = $policialDoQuadro->fichas[0]->pontuacoes;

            //percorre as fichas
            foreach($policialDoQuadro->fichas as $key => $ficha){
                //dd($ficha);
                //seleciona a ficha definitiva por padrão
                if($ficha->st_ficha == 'DEFINITIVA')
                    $idFicha = $ficha->id;
                    $ficha = $ficha;

            }
            if($quadro->st_status == 'ABERTO' && $quadro->bo_recursoliberado != 1 && $policialDoQuadro->bo_fichaenviada == 1) {
                throw new Exception('Esta ficha já foi enviada! Para escriturá-la novamente é preciso que ela seja devolvida.');

            } elseif ($quadro->st_status == 'ABERTO' && $quadro->bo_recursoliberado != 1 && $policialDoQuadro->bo_fichaenviada != 1) {
                //segue o fluxo
            
            } elseif ($quadro->st_status == 'ABERTO' && $quadro->bo_recursoliberado == 1) {
                //segue o fluxo

            } else {
                throw new Exception('Não é possível abrir a ficha para escrituração!');

            }
            
            $arquivos = $this->ArquivoBancoService->findArquivoIdQuadroIdPolicial($idQuadro, $idPolicial);
            return view('promocao::quadroDeAcesso/fichaReconhecimento', compact( 'idQuadro', 'idAtividade','policialDoQuadro', 'idPolicial', 'arquivos', 'competencia', 'quadro','idFicha','ficha'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    public function escriturarFichaReconhecimentoselecionada($idQuadro, $idAtividade, $idPolicial, $competencia, $idFicha)
    {
        try{
          // dd('escriturarFichaReconhecimentoselecionada');
          //dd($idFicha);
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            //$pontuacoes = $policialDoQuadro->fichas[0]->pontuacoes;
            //dd($policiaisQuadro);
             //percorre as fichas
            foreach($policialDoQuadro->fichas as $key => $fichaSelecionada){
                //dd($ficha);
                //seleciona a ficha selecionada pelo usuário
                if($fichaSelecionada->id == $idFicha)
                    $ficha = $fichaSelecionada;
                

            }
         
            
            $arquivos = $this->ArquivoBancoService->findArquivoIdQuadroIdPolicial($idQuadro, $idPolicial);
           // dd($ficha);
           // quadroDeAcesso/fichaReconhecimento
            return view('promocao::quadroDeAcesso/fichaReconhecimento', compact( 'idQuadro', 'idAtividade','policialDoQuadro', 'idPolicial', 'arquivos', 'competencia', 'quadro','idFicha','ficha'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    public function visualizarFichasReconhecimento($idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{
          // dd('visualizarFichasReconhecimento');
          //dd($competencia);
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            //$pontuacoes = $policialDoQuadro->fichas[0]->pontuacoes;
            //dd($policiaisQuadro);
             //percorre as fichas
            foreach($policialDoQuadro->fichas as $key => $fichaSelecionada){
                //dd($ficha);
                //seleciona a ficha selecionada pelo usuário
                if($fichaSelecionada->st_ficha == 'DEFINITIVA')
                    $ficha = $fichaSelecionada;
                

            }
         
            
            $arquivos = $this->ArquivoBancoService->findArquivoIdQuadroIdPolicial($idQuadro, $idPolicial);
           // dd($ficha);
           // quadroDeAcesso/fichaReconhecimento
           if($competencia == 'CPP'){
            //dd('homologar');
               return view('promocao::quadroDeAcesso/validarFichaReconhecimento', compact( 'idQuadro', 'idAtividade','policialDoQuadro', 'idPolicial', 'arquivos', 'competencia', 'quadro','ficha'));
            }else{
               // dd('escriturar');
               return view('promocao::quadroDeAcesso/fichareconhecimento', compact( 'idQuadro', 'idAtividade','policialDoQuadro', 'idPolicial', 'arquivos', 'competencia', 'quadro','ficha'));
           }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * #529 refatorar ficha reconhecimento
     * @author Jazon 
     * exibe em modo somente leitura as fichas do policial
     */
    public function consultarFichasReconhecimento($idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
      
            return view('promocao::quadroDeAcesso/fichas/consultarFichasReconhecimento', compact( 'idQuadro', 'idAtividade','policialDoQuadro', 'idPolicial', 'competencia', 'quadro'));
           
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    public function consultarFichasReconhecimentoSelecionada($idQuadro, $idAtividade, $idPolicial, $competencia,$idFicha)
    {
        try{
             $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
             $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
              //percorre as fichas
             foreach($policialDoQuadro->fichas as $key => $fichaSelecionada){
                 //seleciona a ficha selecionada pelo usuário
                 if($fichaSelecionada->id == $idFicha)
                     $ficha = $fichaSelecionada;
             }
            
            //$arquivos = $this->ArquivoBancoService->findArquivoIdQuadroIdPolicial($idQuadro, $idPolicial);
            //getlistaArquivoIdentificador($idIdentificador,$st_modulo){
            $arquivos = $this->ArquivoBancoService->getlistaArquivoIdentificador($idFicha, "PROMOCAO");
           //dd($arquivos);
            return view('promocao::quadroDeAcesso/fichas/consultarFichasReconhecimentoSelecionada', compact( 'idQuadro', 'idAtividade','policialDoQuadro', 'idPolicial', 'arquivos', 'competencia', 'quadro','ficha'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que atualiza a ficha de reconhecimento enviada.
     * @autor: Talysson
     * @return Response
     */
    public function atualizaFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $idPolicial, $competencia, $enviar = null, $dadosForm = null)
    {
        try{
          //  dd($idFicha);
          //  dd('atualizaFichaReconhecimento');
          //  dd('add ao ponto [st_publicacaolinkarquivo]');
            if(empty($dadosForm)){
                $dadosForm = $request->all();
            }
            if(!isset($dadosForm['ce_ficha'])){
                throw new Exception("Informe o identificador da ficha selecionada");
            }
           // dd($request->files);
          // dd($dadosForm);
            
            $policialDoQuadro = $this->QuadroAcessoService->findPolicialDoQuadroAcessoById($idQuadro, $idPolicial);

            // Validação do envio de arquivos
            if(isset($request->files)){
                $arquivos = $request->files;
                if($arquivos->count() > 0){
                    foreach($arquivos as $key => $arquivo){
                        //verifica se o arquivo é válido
                        $nomeArquivo = $arquivo['st_path']->getClientOriginalName();
                        if($arquivo['st_path']->isValid()){ 
                            $extensao = $arquivo['st_path']->getClientOriginalExtension();
                            //verifica se é pdf
                            if($extensao != 'pdf'){ 
                                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo "'.$nomeArquivo.'" não tem o formato pdf.');
                            }/* elseif($arquivo['st_path']->getClientSize() > 512000){
                                return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload, o arquivo "'.$nomeArquivo.'" excede o tamanho de 512 KB.');
                            } */
                        }else{
                            return redirect()->back()->with('erroMsg', 'Falha ao realizar o upload do arquivo "'.$nomeArquivo.'", verifique se ele não está corrompido ou o seu tamanho excede 512 KB.');
                        }
                    }
                }
            }
            // Variávei de controle, quando há mais de uma ocorrência de valor
            $contPunicao = 1;
            $contRepreensao = 1;
            $contDetencao = 1;
            $contPrisao = 1;
            $contInstrucao = 1;
            $contMonitor = 1;
            $contInstrutor = 1;
            $contCurso30 = 1;
            $contCurso60 = 1;
            $contCurso100 = 1;
            $idFicha = $dadosForm['ce_ficha'];

            // Tratamento dos dados para envio
            foreach ($dadosForm as $key => $value) {
                // Verifica se há alguma punição nas informações
                if(strpos($key, "UNICAO")>0){
                    // Switch para verificar em qual das punições o sub-array se enquadra
                    switch ($dadosForm[$key]["st_criterio"]) {
                        case "REPREENSAO":
                            // $dadosForm["REPREENSAO".$contRepreensao]["st_criterio"] = "REPREENSAO".$contRepreensao;
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm["REPREENSAO".$contRepreensao] = $dadosForm[$key];
                            if ( isset($dadosForm['ARQUIVO11_'.$contPunicao]) ) {
                                $dadosForm['ARQUIVO11_'.$contPunicao]['st_descricao'] = "REPREENSAO".$contRepreensao;
                            }
                            // Adiciona 1 ao valor da variável
                            $contRepreensao++;
                            $contPunicao++;
                            break;
                        case "DETENCAO":
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm["DETENCAO".$contDetencao] = $dadosForm[$key];
                            if ( isset($dadosForm['ARQUIVO11_'.$contPunicao]) ) {
                                $dadosForm['ARQUIVO11_'.$contPunicao]['st_descricao'] = "DETENCAO".$contDetencao;
                            }
                            // Adiciona 1 ao valor da variável
                            $contDetencao++;
                            $contPunicao++;
                            break;
                        case "PRISAO":
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm["PRISAO".$contPrisao] = $dadosForm[$key];
                            if ( isset($dadosForm['ARQUIVO11_'.$contPunicao]) ) {
                                $dadosForm['ARQUIVO11_'.$contPunicao]['st_descricao'] = "PRISAO".$contPrisao;
                            }
                            // Adiciona 1 ao valor da variável
                            $contPrisao++;
                            $contPunicao++;
                            break;
                        case "SEMPUNICAO":
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm["SEMPUNICAO"] = $dadosForm[$key];
                            unset($dadosForm['SEMPUNICAO']['st_publicacao']);
                            break;
                        default:
                            //return redirect()->back()->with('erroMsg', "A Propriedada do campo informada é inválida.");
                            break;
                    }
                    // Remove o sub-array residual
                    unset($dadosForm[$key]);
                // Verifica se há cientifico
                }elseif(strpos($key, "IENTIFICO")>0){
                    if(!empty($dadosForm[$key]["st_criterio"])){
                        $nomeInterno = $dadosForm[$key]["st_criterio"];
                        // Atribui um valor de acordo com o seu critério
                        $dadosForm[$nomeInterno] = $dadosForm[$key];
                        if($nomeInterno == "SEMCIENTIFICO"){
                            unset($dadosForm['SEMCIENTIFICO']['st_publicacao']);
                        } elseif ($nomeInterno == "SEMCIENTIFICOARTIGO") {
                            unset($dadosForm['SEMCIENTIFICOARTIGO']['st_publicacao']);
                        } elseif ($nomeInterno == "SEMCIENTIFICOLIVRO") {
                            unset($dadosForm['SEMCIENTIFICOLIVRO']['st_publicacao']);
                        }
                    } else {
                        if($key == "CIENTIFICO1"){
                            $dadosForm['SEMCIENTIFICO']['st_criterio'] = 'SEMCIENTIFICO';
                        } elseif ($key == "CIENTIFICO2") {
                            $dadosForm['SEMCIENTIFICOARTIGO']['st_criterio'] = 'SEMCIENTIFICOARTIGO';;
                        } elseif ($key == "CIENTIFICO3") {
                            $dadosForm['SEMCIENTIFICOLIVRO']['st_criterio'] = 'SEMCIENTIFICOLIVRO';;
                        }
                    }
                    // Remove o sub-array residual
                    unset($dadosForm[$key]);
                // Verifica se há formação
                }elseif($key == "FORMACAO"){
                    if(!empty($dadosForm[$key]["st_criterio"])){
                        $nomeInterno = $dadosForm[$key]["st_criterio"];
                        // Atribui um valor de acordo com o seu critério
                        $dadosForm[$nomeInterno] = $dadosForm[$key];
                        if($nomeInterno == "SEMFORMACAO"){
                            unset($dadosForm['SEMFORMACAO']['st_publicacao']);
                        }
                    }
                    // Remove o sub-array residual
                    unset($dadosForm[$key]);
                // Verifica se há um comportamento
                }elseif($key == "COMPORTAMENTO"){
                    if (isset($dadosForm[$key]["st_criterio"])) {
                        $nomeInterno = $dadosForm[$key]["st_criterio"];
                    }else {
                        $nomeInterno = 'SEMCOMPORTAMENTO';
                    }
                    // Atribui um valor de acordo com o seu critério
                    $dadosForm[$nomeInterno] = $dadosForm[$key];
                    // Remove o sub-array residual
                    unset($dadosForm[$key]);
                // Verifica se há uma medalha
                }elseif(strpos($key, "EDALHA")>0){
                    $nomeInterno = $dadosForm[$key]["st_criterio"];
                    // Atribui um valor de acordo com o seu critério
                    if ($nomeInterno != null) {
                        $dadosForm[$nomeInterno] = $dadosForm[$key];
                    }
                    if($nomeInterno == "SEMMEDALHA"){
                        unset($dadosForm['SEMMEDALHA']['st_publicacao']);
                    }
                    // Remove o sub-array residual
                    unset($dadosForm[$key]);
                // Verifica se há uma instrução
                }elseif(strpos($key, "NSTRUCAO")>0){ 
                    switch ($dadosForm[$key]["st_label"]) {
                        case 'MONITOR':
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm["MONITOR".$contMonitor] = $dadosForm[$key];
                            // Adiciona 1 ao valor da variável
                            if ( isset($dadosForm['ARQUIVO6_'.$contInstrucao]) ) {
                                $dadosForm['ARQUIVO6_'.$contInstrucao]['st_descricao'] = "MONITOR".$contMonitor;
                            }
                            $contMonitor++;
                            $contInstrucao++;
                            break;
                        case 'INSTRUTOR':
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm["INSTRUTOR".$contInstrutor] = $dadosForm[$key];
                            // Adiciona 1 ao valor da variável
                            if ( isset($dadosForm['ARQUIVO6_'.$contInstrucao]) ) {
                                $dadosForm['ARQUIVO6_'.$contInstrucao]['st_descricao'] = "INSTRUTOR".$contInstrutor;
                            }
                            $contInstrutor++;
                            $contInstrucao++;
                            break;
                        case 'Sem atividade':
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm["SEMATIVIDADE"] = $dadosForm[$key];
                            unset($dadosForm['SEMATIVIDADE']['st_criterio']);
                            unset($dadosForm['SEMATIVIDADE']['st_publicacao']);
                            unset($dadosForm['SEMATIVIDADE']['st_campo1']);
                            unset($dadosForm['SEMATIVIDADE']['st_campo2']);
                            break;
                        default:
                            //return redirect()->back()->with('erroMsg', "A Propriedada do campo informada é inválida.");
                            break;
                    }
                    // Remove o sub-array residual
                    unset($dadosForm[$key]);
                // Verifica se há "NOTACURSO"
                }elseif(strpos($key, "URSO")>0 && $key != "NOTACURSO"){
                    switch ($dadosForm[$key]["st_label"]) {
                        case 'CURSO30':
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm[$contCurso30."CURSO30"] = $dadosForm[$key];
                            $contCurso30++;
                            break;
                        case 'CURSO60':
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm[$contCurso60."CURSO60"] = $dadosForm[$key];
                            $contCurso60++;
                            break;
                        case 'CURSO100':
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm[$contCurso100."CURSO100"]= $dadosForm[$key];
                            $contCurso100;
                            break;
                        case 'Sem curso':
                            // Atribui um valor de acordo com o seu critério
                            $dadosForm["SEMCURSO"] = $dadosForm[$key];
                            // remove o criterio e a publicação referente ao item, caso ele tenha preenchido
                            unset($dadosForm['SEMCURSO']['st_criterio']);
                            unset($dadosForm['SEMCURSO']['st_publicacao']);
                        break;
                        default:
                            //return redirect()->back()->with('erroMsg', "A Propriedada do campo informada é inválida.");
                            break;
                        }
                    // Remove o sub-array residual
                    unset($dadosForm[$key]);
                }elseif($key == "SANGUE" && $dadosForm[$key]["st_criterio"] == "NAO"){
                    // Remove a publicação caso tenha informado que não é doador de sangue
                    unset($dadosForm['SANGUE']['st_publicacao']);
                // Verifica se têm arquivos anexados
                }elseif(strpos($key, "RQUIVO") > 0){
                    $arquivo = $dadosForm[$key];
                   // dd($key);
                  //  dd($value);
                    //dd($dadosForm);
                   // dd($arquivo);
                    $caminho_armazenamento = $this->setFileFichaReconhecimento($arquivo, $idPolicial, $idQuadro,$idFicha);
                    if ($dadosForm[$key]['st_descricao'] == 'certidao_nada_consta_justica') {
                        $dadosForm['st_caminhocertidao'] = $caminho_armazenamento;
                    }
                    unset($dadosForm[$key]);
                }
            }
            // Caso os incrementais venham sem* é removido todos os valores correspondentes residuais
            if(isset($dadosForm['SEMMEDALHA'])){
                foreach ($dadosForm as $key => $value) {
                    if(strpos($key, "EDALHA")>0 && $key != 'SEMMEDALHA'){
                        unset($dadosForm[$key]);
                    }
                }
            }
            if(isset($dadosForm['SEMATIVIDADE'])){
                foreach ($dadosForm as $key => $value) {
                    if(strpos($key, "ONITOR")>0 || strpos($key, "NSTRUTOR")>0){
                        unset($dadosForm[$key]);
                    }
                }
            }
            if(isset($dadosForm['SEMCURSO'])){
                foreach ($dadosForm as $key => $value) {
                    if(strpos($key, "URSO")>0 && $key != 'SEMCURSO' && $key != 'NOTACURSO'){
                        unset($dadosForm[$key]);
                    }
                }
            }
            if(isset($dadosForm['SEMPUNICAO'])){
                foreach ($dadosForm as $key => $value) {
                    if(strpos($key, "EPREENSAO")>0 || strpos($key, "ETENCAO")>0 || strpos($key, "RISAO")>0){
                        unset($dadosForm[$key]);
                    }
                }
            }
           // dd($dadosForm);
            //Atualização de ficha
            $mensagemRetorno = $this->QuadroAcessoService->atualizaFichaReconhecimento($idQuadro, $idPolicial, $dadosForm);
            
            // Redireciona para a ficha caso tenha solicitado somente o salvamento da mesma
           // if($enviar != 1){
                return redirect('promocao/escriturarfichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/ficha/'.$dadosForm['ce_ficha'])->with('sucessoMsg', $mensagemRetorno);
            //}
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que Salva os arquivos enviados na edição da ficha de reconhecimento.
     * @autor: Talysson
     * @return Response
     */
    public function setFileFichaReconhecimento($arquivo, $idPolicial, $idQuadro, $idFicha)
    {
        try {
            // Verifica se está vindo com o id
            if(isset($arquivo['id'])){
                $dadosArquivo = $this->ArquivoBancoService->getArquivoId($arquivo['id'], $idPolicial);
                $dadosArquivo->st_descricao = $arquivo['st_descricao'];
                $dadosArquivo->st_nomearquivo = $arquivo['st_descricao'];
                
                $atualizaArquivo = $this->ArquivoBancoService->updateArquivo($arquivo['id'], $idPolicial, $arquivo);
            }else{
                // verifica se o arquivo é válido
                if($arquivo['st_path']->isValid()){ 
                    $extensao = $arquivo['st_path']->getClientOriginalExtension();
                    // verifica se é pdf
                    if($extensao == 'pdf'){ 
                        $policial = $this->PolicialService->findPolicialById($idPolicial);
                        //$caminho_armazenamento = 'PROMOCAO/'.date('Y')."/".$idQuadro."/".str_replace(" ", "", $policial->st_cpf)."/";
                        $caminho_armazenamento = 'PROMOCAO/'.date('Y')."/".$idQuadro."/".str_replace(" ", "", $policial->st_cpf)."/".$idFicha;
                        try{
                            //testa se existe o diretorio do funcionario
                            if(!Storage::disk('ftp')->exists($caminho_armazenamento)){ 
                                //creates directory
                                Storage::disk('ftp')->makeDirectory($caminho_armazenamento, 0775, true); 
                            }
                            //gera hash a partir do arquivo
                            $hashNome = hash_file('md5', $arquivo['st_path']); 
                            //novo nome do arquivo com base no hash
                            $novoNome = $arquivo['st_descricao'].$hashNome.'.'.$extensao; 
                            //checa se o arquivo ja existe
                            if(!Storage::disk('ftp')->exists($caminho_armazenamento.$novoNome)){ 
                                //salva o arquivo no banco
                                $dadosForm = [
                                    'ce_qa' => $idQuadro,
                                    'st_modulo' => 'PROMOCAO',
                                    'st_motivo' => 'FICHA_RECONHECIMENTO',
                                    'dt_envio' => date('Y-d-m H:i:s'),
                                    'st_arquivo' => $arquivo['st_descricao'].$hashNome,
                                    'st_extensao' => $extensao,
                                    'st_descricao' => $arquivo['st_descricao'],
                                    'st_nomeinterno' => 'FICHA',
                                    'st_identificador' => 'FICHA',
                                    'ce_identificador' => $idFicha,
                                    'st_pasta' => $caminho_armazenamento.'/',
                                ];
                                //dd($caminho_armazenamento.$novoNome);
                                $criaArquivo = $this->ArquivoBancoService->createArquivo($idPolicial, $dadosForm);
                                if($criaArquivo){ 
                                    //salva arquivo no ftp
                                    Storage::disk('ftp')->put($caminho_armazenamento.'/'.$novoNome.'/', fopen( $arquivo['st_path'], 'r+')); 
                                    return $caminho_armazenamento.'/'.$novoNome.'/';
                                }else{
                                    throw new Exception('Falha ao realizar o upload, erro na base de dados.');
                                }
                            }else{
                                throw new Exception('Falha ao realizar o upload, o arquivo já existe na base de dados.');
                            }
                        }catch(\RuntimeException $e){
                            throw new Exception($e->getMessage());
                        }
                    }else{
                        throw new Exception('Falha ao realizar o upload, algum dos arquivos não tem o formato pdf.');
                    }
                }else{
                    throw new Exception('Falha ao realizar o upload, o arquivo não é válido.');
                }
            }
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    /**
     * Método que realiza o download do arquivo.
     * @autor: Talysson
     * @return Response
     */
    public function downloadArquivoFichaReconhecimento($idArquivo, $idPolicial)
    {
        try {
            $arquivo = $this->ArquivoBancoService->getArquivoId($idArquivo, $idPolicial);
            if(!isset($arquivo)){
                throw new Exception('Arquivo não foi encontrado.');
            }
            //$caminho = $arquivo->st_pasta .'/'.$idFicha.'/'. $arquivo->st_arquivo . '.' . 'pdf';
            $caminho = $arquivo->st_pasta . $arquivo->st_arquivo . '.' . 'pdf';
           // dd($caminho);
            if(Storage::disk('ftp')->exists($caminho)){
                return Storage::disk('ftp')->download($caminho);
            }else{
                throw new Exception('Arquivo não foi encontrado.');
            }
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que remove um arquivo de um policial.
     * @autor: Talysson
     * @return Response
     */
    public function deleteArquivoId(Request $request, $idAtividade, $idArquivo, $idPolicial, $competencia)
    {
        try {
            $cpf = Auth::user()->st_cpf;
            $senhaUsuario = $request->all();
            // Verifica se a senha veio na requisição
            if(!isset($senhaUsuario['password'])){
                return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA);
            }
            $credenciais = array('st_cpf' => $cpf, 'password' => $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
            }
            // Recupera o arquivo pelo id
            $arquivo = $this->ArquivoBancoService->getArquivoId($idArquivo, $idPolicial);
            if(!isset($arquivo)){
                throw new Exception('Arquivo não foi encontrado.');
            }
            $caminho = $arquivo->st_pasta . $arquivo->st_arquivo . '.' . 'pdf';
            //dd($caminho);
            if(Storage::disk('ftp')->exists($caminho)){
                // Exclui do banco
                $arquivoDelete = $this->ArquivoBancoService->deleteArquivo($idArquivo, $idPolicial);
                // Exclui do FTP
                Storage::disk('ftp')->delete($caminho);
                // Chama a view esclriturar ficha
                return redirect()->back()->with('sucessoMsg', $arquivoDelete);
            }else{
                throw new Exception('Arquivo não foi encontrado.');
            }
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que retorna o PDF da ficha de reconhecimento.
     * @autor: Talysson
     * @return Response
     */
    public function escriturarFichaReconhecimentoPdf($idQuadro, $idAtividade, $idPolicial,$competencia,$idFicha)
    {
        try{
     
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
              //percorre as fichas
            foreach($policialDoQuadro->fichas as $key => $fichaSelecionada){
           
                //seleciona a ficha selecionada pelo usuário
                if($fichaSelecionada->id == $idFicha)
                    $ficha = $fichaSelecionada;
                

            }
  
            $pontuacoes = $ficha->pontuacoes;

            return \PDF::loadView('promocao::pdf/fichaReconhecimento', compact('ficha', 'pontuacoes', 'quadro', 'idAtividade', 'idPolicial', 'policialDoQuadro'))->stream('FICHA_DE_RECONHECIMENTO_'.$policialDoQuadro->st_matricula.'.pdf');
       
        }catch(Exception $e){
            //dd($e->getline().'---'.$e->getmessage());
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    public function visualizarPdfFichaReconhecimento($idQuadro, $idAtividade, $idPolicial,$competencia,$idFicha)
    {
        try{
      
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
              //percorre as fichas
            foreach($policialDoQuadro->fichas as $key => $fichaSelecionada){
                //seleciona a ficha selecionada pelo usuário
                if($fichaSelecionada->id == $idFicha)
                $ficha = $fichaSelecionada;
            }

            $pontuacoes = $ficha->pontuacoes;

            return \PDF::loadView('promocao::pdf/fichaReconhecimento', compact('ficha', 'pontuacoes', 'quadro', 'idAtividade', 'idPolicial', 'policialDoQuadro'))->stream('FICHA_DE_RECONHECIMENTO_'.$policialDoQuadro->st_matricula.'.pdf');
       
        }catch(Exception $e){
            //dd($e->getline().'---'.$e->getmessage());
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que a tela de recurso do policial no processo de escriturar ficha de reconhecimento
     * @autor: Talysson
     * @return Response
     */
    public function recursoFichaReconhecimento($idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{

            $ficha = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            $fichaPolicial = $this->QuadroAcessoService->findPolicialDoQuadroAcessoById($idQuadro, $idPolicial);
            if($fichaPolicial->bo_recorreu == 1){
                throw new Exception('Falha o recurso já foi enviado.');
            }
            return view('promocao::quadroDeAcesso/recursoFichaReconhecimento', compact('fichaPolicial', 'ficha', 'idQuadro', 'idPolicial', 'idAtividade', 'competencia'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que a tela de recurso do policial no processo de escriturar ficha de reconhecimento
     * @autor: Talysson
     * @return Response
     */
    public function recursoFichaReconhecimentoPdf($idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{
            $ficha = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $fichaPolicial = $this->QuadroAcessoService->findPolicialDoQuadroAcessoById($idQuadro, $idPolicial);
            return \PDF::loadView('promocao::pdf/recursoFichaReconhecimento', compact('fichaPolicial', 'ficha', 'idQuadro', 'idPolicial', 'idAtividade', 'quadro', 'competencia'))->stream('RECURSO_AO_QUADRO_DE_ACESSO'.$ficha->st_matricula.'.pdf');
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que salva o recurso do policial no processo de escriturar ficha de reconhecimento
     * @autor: Talysson
     * @return Response
     */
    public function salvaRecursoFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{
            $dadosForm = $request->all();
            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
            }
            $ldap = $this->Authldap->autenticar($request['password']);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
            }
            unset($dadosForm['password']);
            
            if(!isset($dadosForm['st_recurso']) || empty($dadosForm['st_recurso'])){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }
            if(strlen($dadosForm['st_recurso']) > 500){
                throw new Exception('Falha, o recurso não pode exceder 500 caracteres.');
            }
            $fichaPolicial = $this->QuadroAcessoService->findPolicialDoQuadroAcessoById($idQuadro, $idPolicial);
            if($fichaPolicial->bo_recorreu == 1){
                throw new Exception('Falha o recurso já foi enviado.');
            }
            $this->QuadroAcessoService->salvaRecursoFichaReconhecimento($idQuadro, $idPolicial, $dadosForm);
            return redirect('promocao/fichasgtenviada/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)->with('sucessoMsg', 'Recurso enviado com sucesso!');
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que retorna uma lista de Sargentos de um QA de acordo com o estado com uma busca específica (nome, CPF ou matrícula).
     * @autor: Talysson
     * @return Response
     */
    public function buscaSgtCpfMatriculaNome(Request $request, $idQuadro, $idAtividade, $enviada, $competencia)
    {
        try{
            $dadosForm = $request->all();

            $titulopainel = 'Quadro de acesso para promoção de ';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            $policiaisQuadro = $this->QuadroAcessoService->getSgtCpfMatriculaNome($idQuadro, $dadosForm);
            
            $unidades = $this->UnidadeService->getUnidade();
           
            $graduacoes = $this->GraduacaoService->getGraduacao();
            
            $qpmps = $this->QpmpService->getQpmp();

            //Verifica em qual tela está sendo feita a consulta
            if($enviada == 1){

                return view('promocao::quadroDeAcesso/listaEfetivoEscriturarFichaEnviada', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'unidades', 'graduacoes', 'qpmps'));
            
            }elseif($enviada == 0){

                return view('promocao::quadroDeAcesso/listaEfetivoEscriturarFichaNaoEnviada', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'unidades', 'graduacoes', 'qpmps'));
            }
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método que envia ficha de reconhecimento para CPP
     * @autor: Talysson
     * @return Response
     */
    public function enviarFichaEscriturada(Request $request, $idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{
            if(!isset($request['ce_ficha'])){
                return redirect()->back()->with('erroMsg', "Informar o Id da Ficha"); 
            }
            $idFicha = $request['ce_ficha'];
            $cpf = auth()->user()->st_cpf;

            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', MSG::SENHA_OBRIGATORIA); 
            }

            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', MSG::SENHA_INVALIDA); 
            }

           // $dados = ['st_cpf' => $cpf, 'st_password' => $request['password']];
            $dadosForm = ['ce_ficha' => $idFicha];
           
            // Envia a ficha salva
            $envioFicha = $this->QuadroAcessoService->enviarFichaEscrituradaQA($idQuadro, $idPolicial,$dadosForm);

            return redirect("promocao/fichasgtnaoenviada/$idQuadro/$idAtividade/competencia/$competencia")->with('sucessoMsg', $envioFicha);

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function convocarParaTaf($idQuadro, $idAtividade, $competencia){
        try{
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            return view('promocao::quadroDeAcesso.convocarParaTaf', compact('idQuadro', 'atividade', 'competencia'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function cadastrarPortariaNoCronogrma(Request $request, $idQuadro, $idAtividade, $competencia){
        try{
            $dadosForm = $request->all();

            $validator = validator($dadosForm, ['st_portaria' => 'required']); // Validando os dados do formulário

            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS); // Validação de campo obrigatório
            }

            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf); // Resgata a unidade operacional do policial

            $policial = $this->PolicialService->buscafuncionariocpf($cpf);

            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', Msg::POLICIAL_SEM_UNIDADE);
            }

            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['st_status'] = Status::NOTA_RASCUNHO;
            $dadosForm['nu_ano'] = date('Y');
            $dadosForm['dt_cadastro'] = date('Y-d-m H:i:s');
            $dadosForm['ce_tipo'] = 10;
            $dadosForm['st_assunto'] = "Convocação para TAF";
            $dadosForm['st_tipo'] = 'convocarTaf';
            $msgUpdatePortaria = $this->QuadroAcessoService->updatePortariaParaCronograma($idAtividade, $dadosForm); // Cadastra os dados de portaria

            return redirect('promocao/convocarparataf/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)->with('sucessoMsg', $msgUpdatePortaria);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function gerarNotaConvocarTaf(Request $request, $idQuadro, $idAtividade){
        try{
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if($atividade->st_portaria == null){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }elseif(!empty($atividade->ce_nota)){
                return redirect()->back()->with('erroMsg', Msg::NOTA_JA_EXISTE);
            }
             //resgata a unidade operacional do  policial
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);

            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
            }
            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
            }

            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
            
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', Msg::POLICIAL_SEM_UNIDADE);
            }

            $dadosForm = [];
            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['idUsuario'] = Auth::user()->id;
            $dadosForm['st_status'] = Status::NOTA_RASCUNHO;
            $dadosForm['nu_ano'] = date('Y');
            $dadosForm['ce_tipo'] = '10';
            $dadosForm['idAtividade'] = $idAtividade;
            $dadosForm['dt_cadastro'] = date('Y-d-m H:i:s');
            $dadosForm['st_assunto'] = "CONVOCAÇÃO PARA TAF";
            $dadosForm['st_materia'] = $atividade->st_portaria;

            $criaNota = $this->QuadroAcessoService->criarNota($dadosForm, $idQuadro);
            return redirect()->back()->with('sucessoMsg', $criaNota);
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function convocarParaInspecaoSaude($idQuadro, $idAtividade, $competencia){
        try{
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $titulopainel = 'Resultado da inspeção de Saúde para promoção de ';
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisInspecionadosJPMS($idQuadro);
            /* @aggeu. Issue 219. adicionado variáveis para tratar condições na view*/
            $comissao = $this->QuadroAcessoService->listaPolicialAssinaturaPortaria($idAtividade);
            $contador = 0;
            foreach($comissao as $c){
                if($c->st_assinatura){
                    $contador++;
                }
            }
            $assinaturas = $contador;
            $matricula = Auth::user()->matricula;
            $matriculaLogada = trim($matricula);
            return view('promocao::divulgarResultadoInspecaoSaude',compact('comissao', 'matriculaLogada', 'assinaturas', 'atividade', 'quadro', 'titulopainel', 'policiaisQuadro', 'idQuadro', 'competencia'));

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function resultadoTaf($idQuadro, $idAtividade, $competencia){
        try{

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $titulopainel = 'Resultado do TAF para promoção de ';
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisInspecionadosTaf($idQuadro);
            $comissao = $this->QuadroAcessoService->listaPolicialAssinaturaPortaria($idAtividade);
            
            $contador = 0;
            foreach($comissao as $c){
                if($c->st_assinatura){
                    $contador++;
                }
            }
            $assinaturas = $contador;

            $matricula = Auth::user()->matricula;
            $matriculaLogada = trim($matricula);
            $contador = 0;
            /* dd(Auth::user()); */
            return view('promocao::divulgarResultadoTaF',compact('assinaturas', 'atividade', 'quadro', 'titulopainel', 'policiaisQuadro', 'idQuadro', 'comissao', 'matriculaLogada', 'competencia'));

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function cadastrarPortariaNoCronogrmaInspecaoSaude(Request $request, $idQuadro, $idAtividade){
        try{
            $dadosForm = $request->all();
            // Validando os dados do formulário
            $validator = validator($dadosForm, ['st_portaria' => 'required']); 

            // Validação de campo obrigatório
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS); 
            }
            $dadosForm['st_tipo'] = 'resultadoJpms';
            // Cadastra os dados de portaria
            $msgUpdatePortaria = $this->QuadroAcessoService->updatePortariaParaCronograma($idAtividade, $dadosForm); 
            
            return redirect()->back()->with('sucessoMsg', $msgUpdatePortaria);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    public function cadastrarPortariaNoCronogrmaDivulgarTaf(Request $request, $idQuadro, $idAtividade){
        try{
            $dadosForm = $request->all();

            // Validando os dados do formulário
            $validator = validator($dadosForm, ['st_portaria' => 'required']); 

            // Validação de campo obrigatório
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS); 
            }
            // Verificar necessidade dessa verificação de usuário
            // // Resgata a unidade operacional do policial
            // $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf); 

            // $policial = $this->PolicialService->buscafuncionariocpf($cpf);

            // if(!isset($policial) || empty($policial->ce_unidade)){
            //     return redirect()->back()->with('erroMsg', Msg::POLICIAL_SEM_UNIDADE);
            // }
            $dadosForm['st_tipo'] = 'convocarTaf';
            // Cadastra os dados de portaria
            $msgUpdatePortaria = $this->QuadroAcessoService->updatePortariaParaCronograma($idAtividade, $dadosForm); 
            
            return redirect('promocao/resultadodotaf/'.$idQuadro.'/'.$idAtividade)->with('sucessoMsg', $msgUpdatePortaria);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /* @aggeu, issue 215. Função que converte para maiúsculas o primeiro caractere de cada palavra, fonte: https://www.php.net/manual/pt_BR/function.ucwords.php*/
    public function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "dos", "das", "do", "I", "II", "III", "IV", "V", "VI"))
    {
        /*
         * Exceptions in lower case are words you don't want converted
         * Exceptions all in upper case are any words you don't want converted to title case
         *   but should be converted to upper case, e.g.:
         *   king henry viii or king henry Viii should be King Henry VIII
         */
        $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word) {
                if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtoupper($word, "UTF-8");
                } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtolower($word, "UTF-8");
                } elseif (!in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
       }//foreach
       return $string;
    }

    /* @aggeu, issue 215. Trabalha em cima de uma função existente*/
    /*Gerar nota de divulgação de resultado do taf */
    public function gerarNotaDivulgarTaf(Request $request, $idQuadro, $idAtividade, $tiporenderizacao)
    {
        try{

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            if(empty($quadro)){
                return redirect()->back()->with('erroMsg', Msg::QA_NAO_ENCONTRADO);
            }

            if($tiporenderizacao != "visualizar"){
                $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
                if($atividade->st_portaria == null){
                    return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
                }elseif(!empty($atividade->ce_nota)){
                    return redirect()->back()->with('erroMsg', Msg::NOTA_JA_EXISTE);
                }
            }else{
                $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
                if($atividade->st_portaria == null){
                    return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
                }
            }            
            
            //resgata a unidade operacional do  policial
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            
            if($tiporenderizacao != "visualizar"){
                if(!isset($request['password'])){
                    return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
                }                
                $ldap = $this->Authldap->autenticar($request['password']);
                if($ldap == false){
                    return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
                }
            }

            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
                
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', Msg::POLICIAL_SEM_UNIDADE);
            }

            $listaComissao = "";
            $comissao = $this->QuadroAcessoService->listaPolicialAssinaturaPortaria($idAtividade);
            foreach($comissao as $c){
                if($c->st_assinatura != null){
                    $listaComissao .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. QuadroDeAcessoController::titleCase($c->st_nomeassinante) .', '. $c->st_postograd .' - '. mb_strtoupper($c->st_funcao, 'UTF-8') .'.<br>';
                }
            }

            $policiais = $this->QuadroAcessoService->listaTodosPoliciaisInspecionadosTaf($idQuadro);
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
            $tabelaSargentos = "";
            $contadorSargentos = 1;
            foreach($policiais as $pol){
                $dtJunta = (empty($pol->dt_validadeinspecaosaude)) ? "" : " até " . strftime("%B de %Y" ,strtotime($pol->dt_validadeinspecaosaude));
                $tabelaSargentos .= "<tr>";
                    $tabelaSargentos .= "<th><font size=1>" . $contadorSargentos . "</font></th>";
                    $tabelaSargentos .= "<th><font size=1>" . $pol->st_postgrad . "</font></th>";
                    $tabelaSargentos .= "<th><font size=1>" . $pol->st_numpraca . "</font></th>";
                    $tabelaSargentos .= "<th><font size=1>" . $pol->st_policial . "</font></th>";
                    $tabelaSargentos .= "<th><font size=1>" . $pol->st_matricula . "</font></th>";
                    $tabelaSargentos .= "<th><font size=1>" . $pol->st_unidade . "</font></th>";
                    $tabelaSargentos .= "<th><font size=1>" . $pol->st_inspecaojuntaparecer . $dtJunta . "</font></th>";
                    $tabelaSargentos .= "<th><font size=1>" . $pol->st_inspecaotafparecer . "</font></th>";
                $tabelaSargentos .= "</tr>";
                $contadorSargentos++;
            }

            $dadosForm = [];
            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['idUsuario'] = Auth::user()->id;
            $dadosForm['st_status'] = Status::NOTA_RASCUNHO;
            $dadosForm['nu_ano'] = date('Y');
            $dadosForm['ce_tipo'] = '11';
            $dadosForm['idAtividade'] = $idAtividade;
            $dadosForm['dt_cadastro'] = date('Y-d-m H:i:s');
            $dadosForm['st_assunto'] = "RESULTADO DE TAF";
            $dadosForm['st_materia'] = $atividade->st_portaria;

            $dadosForm['st_assunto'] = 'ATA DO EXAME DO CONDICIONAMENTO FÍSICO DOS PRIMEIROS,
            SEGUNDOS E TERCEIROS SARGENTOS DA PMRN PARA FINS DE
            PROMOÇÕES PREVISTAS PARA '. strtoupper(strftime("%d de %B de %Y" ,strtotime($quadro->dt_promocao)));
            $dadosForm['st_materia'] = $atividade->st_portaria . '</br>';
            $dadosForm['st_materia'] .= "<table border='1' width='100%' cellspacing=0 cellpadding=2 bordercolor='666633'>
                <thead>
                    <tr>
                        <th><font size=1>ORD</font></th>
                        <th><font size=1>GRAD</font></th>
                        <th><font size=1>Nº DE PRAÇA</font></th>
                        <th><font size=1>NOME</font></th>
                        <th><font size=1>MAT</font></th>
                        <th><font size=1>OME</font></th>
                        <th><font size=1>JPMS</font></th>
                        <th><font size=1>RESULTADO</font></th>
                    </tr>
                </thead>
                <tbody>";
                $dadosForm['st_materia'] .= $tabelaSargentos;     
                   
                   
                $dadosForm['st_materia'] .= "</tbody>
            </table>";
            $dadosForm['st_materia'] .= $listaComissao;

            if($tiporenderizacao == "visualizar"){
                $nota = (object)$dadosForm;
                return \PDF::loadView('boletim::notas/pdf_nota', compact('nota'))->stream('nota.pdf');
            }else{
                $criaNota = $this->QuadroAcessoService->criarNota($dadosForm, $idQuadro);
                return redirect()->back()->with('sucessoMsg', $criaNota);
            }
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
    * Show the form for creating a new resource.
    * @return Response
    */
    public function create(){
        return view('promocao::create');
    }

    public function store(Request $request){}

    public function show(){
        return view('promocao::show');
    }

    public function edit($id){
        return view('promocao::edit');
    }


    // Método criado no botão salvar Quadro da Modal
    public function adicionar(Request $request){
        try{
            $dadosForm = $request->all();/* Recebendo os dados do formulário */
           // dd($dadosForm);
            $validator = validator($dadosForm, [
                'dt_promocao' => 'required',
                'dt_referencia' => 'required',
                'ce_qaanterior' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', $validator);
               // return redirect()->back()
                    //Mensagem de Erro
                   // ->withErrors($validator)
                    //Preenchendo o Formulário
                  //  ->withInput();
            }
            $quadroDeAcesso = $this->QuadroAcessoService->createQuadroAcesso($dadosForm);
            return redirect('promocao/listadequadrodeacesso')->with('sucessoMsg', $quadroDeAcesso);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
    * Método exibe a tela o quantitativo de vagas na PM
    */
    public function calcularQuadroDeVagas($idQuadro,$idAtividade, $competencia)
    {
        try{
            //busca a matrícula do usuário logado
            $matricula = preg_replace("/\D+/", "", Auth::user()->matricula);
            
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            
            //busca os policiais cadastrados na comissão
            $membrosDaComissao = $this->QuadroAcessoService->getPoliciaisNaComissao($idAtividade);
            $todosAssinaram = false;
            $alguemAssinou = false;
            //Verifica se tem algum membro cadastrado na comissão
            if(count($membrosDaComissao) > 0){
                //Verifica se todos os membros assinaram - retorna um boolean
                $todosAssinaram = QuadroDeAcessoController::verificaAssinaturas($membrosDaComissao);
                //Verifica se pelo menos um membro da comissão assinou
                $alguemAssinou  = QuadroDeAcessoController::alguemAssinou($membrosDaComissao);
            }
            
            //busca a quantidade de vagas no quadro
            $quadroDeVagasService = new QuadroDeVagaService();
            $vagas = $quadroDeVagasService->getQuantitativoDeVagas(); 
            return view('promocao::quadroDeAcesso.quantitativoDeVagas', compact('vagas', 'idQuadro','atividade', 'membrosDaComissao', 'matricula', 'todosAssinaram', 'alguemAssinou', 'competencia'));
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
    * Método cria uma nota de BG para exibe a tela o quantitativo de vagas na PM
    */
    public function gerarNotaContendoQuadroDeVagas(Request $request, $idQuadro, $idAtividade, $tipoRenderizacao)
    {
        try{
            //Verifica o tipo de renderização
            if($tipoRenderizacao != 'visualizar' && $tipoRenderizacao != 'gerarNota'){
                return redirect()->back()->with('erroMsg', Msg::PARAMETRO_RENDERIZAÇÃO_INVALIDOS);
            }
            
            //resgata o quador de acesso pelo ID
            $qa = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            
             //resgata o CPF do usuário logado
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
           
            //Busca policial pelo CPF
            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
            if(empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', Msg::POLICIAL_SEM_UNIDADE);
            } 
            //Resgata a atividade pelo ID
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            //Resgata o quantitativo de vagas
            $quadroDeVagasService = new QuadroDeVagaService();
            $vagas = $quadroDeVagasService->getQuantitativoDeVagas();
            //busca os policiais cadastrados na comissão
            $membrosDaComissao = $this->QuadroAcessoService->getPoliciaisNaComissao($idAtividade);
            
            //Seta a data em um formto português
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
            
            //Montando os dados para a geração da nota
            $dadosNota['idUsuario'] = Auth::user()->id;
            $dadosNota['ce_tipo'] = '14';
            $dadosNota['ce_unidade'] = $policial->ce_unidade;
            $dadosNota['idAtividade'] = $idAtividade;
            $dadosNota['st_materia'] = $atividade->st_portaria;
            $dadosNota['st_assunto'] = 'QUADRO DEMONSTRATIVO DE VAGAS PARA AS PROMOÇÕES PREVISTAS PARA '. strtoupper(strftime("%d de %B de %Y" ,strtotime($qa->dt_promocao))) . ', ATUALIZADO EM '.
            strtoupper(strftime("%d de %B de %Y" ,strtotime(date('d-m-Y')))).'.';
            //Concatena os membros da comissão para ser exibido no pdf, se existir algum membro cadastrado
            if(isset($membrosDaComissao) && count($membrosDaComissao) > 0){
                $dadosNota['st_materia'] .= '<table cellpadding="1" cellspacing="1" class="estiloTabela">'; 
                $dadosNota['st_materia'] .= '<tbody>';
                foreach($membrosDaComissao as $m){
                    $dadosNota['st_materia'] .= 
                    '<tr>'.
                    '<td>'.$m->st_nomeassinante.' - '.$m->st_postograd.' PM'.'</td>'.
                    '</tr>
                    <tr>';
                        $dadosNota['st_materia'] .= '<td>'.$m->st_funcao.'</td>'.
                    '</tr>';
                   
                }
                $dadosNota['st_materia'] .= '</tbody></table>';
            }
            $dadosNota['st_materia'] .= '<h5 id="anexo">ANEXO</h5>';
            
            /**
             * Variáveis de totais para calcular o total de cada coluna da tabela
             */
            $totalVagasPrevistas = 0;
            $totalVagasExistentes = 0;
            $totalClaro = 0;
            $totalExcedentes = 0;
            $totalAgregados = 0;
            $totalVagas = 0;
            
            //$quadro Variável de controle de criação de tabelas 
            $quadro = null;

            /**
             * Montagem da tabela
             */
            foreach($vagas as $v){
                if(isset($quadro)){
                    if($quadro == $v->st_qpmp){
                        $totalVagasPrevistas += $v->nu_vagasprevistas;
                        $totalVagasExistentes += $v->nu_vagasexistente;
                        $totalClaro += $v->nu_claro;
                        $totalExcedentes += $v->nu_excedente;
                        $totalAgregados += $v->nu_agragados;
                        $totalVagas += $v->nu_vagas;
                        $dadosNota['st_materia'] .= '<tr>'.
                            '<th>'.$v->st_postograduacao.'</th>'.
                            '<th>'.$v->nu_vagasprevistas.'</th>'.
                            '<th>'.$v->nu_vagasexistente.'</th>'.
                            '<th>'.$v->nu_claro.'</th>'.
                            '<th>'.$v->nu_excedente.'</th>'.
                            '<th>'.$v->nu_agragados.'</th>'.
                            '<th>'.$v->nu_vagas.'</th>'.
                        '</tr>';
                    }else{
                        $dadosNota['st_materia'] .= '<tr>'.
                            '<th>TOTAL</th>'.
                            '<th>'.$totalVagasPrevistas.'</th>'.
                            '<th>'.$totalVagasExistentes.'</th>'.
                            '<th>'.$totalClaro.'</th>'.
                            '<th>'.$totalExcedentes.'</th>'.
                            '<th>'.$totalAgregados.'</th>'.
                            '<th>'.$totalVagas.'</th>'.
                        '</tr>'.
                        '</table>';
        
                        $totalVagasPrevistas = 0;
                        $totalVagasExistentes = 0;
                        $totalClaro = 0;
                        $totalExcedentes = 0;
                        $totalAgregados = 0;
                        $totalVagas = 0;

                        $totalVagasPrevistas += $v->nu_vagasprevistas;
                        $totalVagasExistentes += $v->nu_vagasexistente;
                        $totalClaro += $v->nu_claro;
                        $totalExcedentes += $v->nu_excedente;
                        $totalAgregados += $v->nu_agragados;
                        $totalVagas += $v->nu_vagas;

                        $dadosNota['st_materia'] .= '<table border="1" cellpadding="1" cellspacing="1" class="estiloTabela">'.
                            '<thead>'.
                                '<tr>'.
                                    '<th colspan="7">'.$v->st_qpmp .'-'. $v->st_descricao.'</th>'.
                                '</tr>'.
                                '<tr>'.
                                    '<th>Graduações</th>'.
                                    '<th>Previstos</th>'.
                                    '<th>Existentes</th>'.
                                    '<th>Claros</th>'.
                                    '<th>Excedentes</th>'.
                                    '<th>Agregados</th>'.
                                    '<th>Vagas</th>'.
                                '</tr>'.
                            '</thead>'.
                            '<tr>'.
                                '<th>'.$v->st_postograduacao.'</th>'.
                                '<th >'.$v->nu_vagasprevistas.'</th>'.
                                '<th>'.$v->nu_vagasexistente.'</th>'.
                                '<th>'.$v->nu_claro.'</th>'.
                                '<th>'.$v->nu_excedente.'</th>'.
                                '<th>'.$v->nu_agragados.'</th>'.
                                '<th>'.$v->nu_vagas.'</th>'.
                            '</tr>';
                            $quadro = $v->st_qpmp;
                    }
                }else{
                    //Formação da primeira tabela
                    $dadosNota['st_materia'] .= '<table border="1" cellpadding="1" cellspacing="1" class="estiloTabela">'.
                        '<thead>'.
                            '<tr>'.
                                '<th colspan="7">'.$v->st_qpmp .'-'. $v->st_descricao.'</th>'.
                            '</tr>'.
                            '<tr>'.
                                    '<th>Graduações</th>'.
                                    '<th>Previstos</th>'.
                                    '<th>Existentes</th>'.
                                    '<th>Claros</th>'.
                                    '<th>Excedentes</th>'.
                                    '<th>Agregados</th>'.
                                    '<th>Vagas</th>'.
                                '</tr>'.
                        '</thead>'.
                        '<tr>'.
                            '<th>'.$v->st_postograduacao.'</th>'.
                            '<th>'.$v->nu_vagasprevistas.'</th>'.
                            '<th>'.$v->nu_vagasexistente.'</th>'.
                            '<th>'.$v->nu_claro.'</th>'.
                            '<th>'.$v->nu_excedente.'</th>'.
                            '<th>'.$v->nu_agragados.'</th>'.
                            '<th>'.$v->nu_vagas.'</th>'.
                        '</tr>';
                        $quadro = $v->st_qpmp;
                        $totalPostograduacao = $v->st_postograduacao;
                        $totalVagasPrevistas = $v->nu_vagasprevistas;
                        $totalVagasExistentes = $v->nu_vagasexistente;
                        $totalClaro = $v->nu_claro;
                        $totalExcedentes = $v->nu_excedente;
                        $totalAgregados = $v->nu_agragados;
                        $totalVagas = $v->nu_vagas;
                }
            }
            $dadosNota['st_materia'] .= '<tr>'.
                '<th>TOTAL</th>'.
                '<th>'.$totalVagasPrevistas.'</th>'.
                '<th>'.$totalVagasExistentes.'</th>'.
                '<th>'.$totalClaro.'</th>'.
                '<th>'.$totalExcedentes.'</th>'.
                '<th>'.$totalAgregados.'</th>'.
                '<th>'.$totalVagas.'</th>'.
            '</tr></table><style>th{text-align: center;}</style>';
            //Adiciona aos dados da nota o id do usuário logado
            $dadosNota['idUsuario'] = Auth::user()->id;
            if($tipoRenderizacao == 'visualizar'){
                //converte o array em objeto para ser enviado a view do pdf
                $nota = (object) $dadosNota;
                //exibe um esboço da nota em pdf, sem salvar no banco
                return \PDF::loadView('boletim::notas/pdf_nota', compact('nota'))->stream('nota.pdf');
            }elseif($tipoRenderizacao == 'gerarNota'){
                //Conclui atividade calcular vagas do QA e gera uma nota de BG
                $this->QuadroAcessoService->concluiAtividadeQuadroDeVagas($idAtividade, $idQuadro, $dadosNota);
                return redirect('/promocao/quadro/divulgarquadrovagas/'.$idQuadro.'/'.$idAtividade)->with('sucessoMsg', 'Nota de boletim gerada com sucesso');
            }
             
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function update(Request $request, $id){
        try{
            //recuperar os campos enviados pelo formulário
            $dadosForm = $request->all();
            //validando os dados do formulário
            $validator = validator($dadosForm, [
                'dt_promocao' => "required",
                'dt_referencia' => "required"
            ]);
            if($validator->fails()){
                return redirect()->back()
                //mostrando o erro no form Create
                ->withErrors($validator)
                //retornando os dados do formulário deixando-o preenchido
                ->withInput();
            }
            //recuperar o registro da tabela
            $atualizaQA = $this->QuadroAcessoService->updateQuadroAcesso($id, $dadosForm);
            //validar as informações recuperadas
            return redirect()->back()->with('sucessoMsg', $atualizaQA);
            
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    public function listaPoliciaisNaoHomologadosGraduacaoFicha($idQuadro, $idAtividade, $competencia, $graduacao)
    {
        try{
            //TODO - bordas vermelhas na tela de homologar só quando o item não for homologada
            $this->authorize('HOMOLOGAR_FICHA_RECONHECIMENTO');
            $graduacoesValidas = [ 'todos', '1sgt', '2sgt', '3sgt', 'cb', 'sd' ];
           
            if ( !in_array($graduacao, $graduacoesValidas) ) {
                throw new Exception('Graduação inválida para pesquisa das fichas não homologadas!');
            }

            $titulopainel = 'Fichas de reconhecimento não validadas para promoção de ';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisDoQuadroHomologadosPorGraduacao($idQuadro, 'naohomologada', $graduacao);
            
            $contador_inicial = 0;
            if(method_exists($policiaisQuadro,'currentPage')){
              $contador_inicial = ($policiaisQuadro->currentPage()-1) * $policiaisQuadro->perPage();
            }
           
            return view('promocao::quadroDeAcesso/listaEfetivoHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'graduacao', 'contador_inicial'));

        }catch(\Exception $e){
            return redirect("promocao/homologarfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP/graduacao/todos")->with('erroMsg', $e->getMessage());
        }
    }

    public function listaPoliciaisRecorreramFicha($idQuadro, $idAtividade, $competencia, $graduacao)
    {
        try{
            $this->authorize('HOMOLOGAR_FICHA_RECONHECIMENTO');
            $recursoAnalisado = ['recursoAnalisado' => 0];
            
            $graduacoesValidas = [ 'todos', '1sgt', '2sgt', '3sgt', 'cb', 'sd' ];
           
            if ( !in_array($graduacao, $graduacoesValidas) ) {
                throw new Exception('Graduação inválida para pesquisa dos recursos!');
            }
            
            $titulopainel = 'Fichas de reconhecimento com recursos para promoção de ';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisRecursosFicha($idQuadro, $graduacao, $recursoAnalisado);
            
            $contador_inicial = 0;
            if(method_exists($policiaisQuadro,'currentPage')){
              $contador_inicial = ($policiaisQuadro->currentPage()-1) * $policiaisQuadro->perPage();
            }

            $recursoAnalisado = 0;
           
            return view('promocao::quadroDeAcesso/listaEfetivoRecorreuHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'graduacao', 'contador_inicial', 'recursoAnalisado'));
            
        }catch(\Exception $e){
            return redirect("promocao/homologarfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP/graduacao/todos")->with('erroMsg', $e->getMessage());
        }
    }

    public function listaPoliciaisRecursosAnalisadosFicha($idQuadro, $idAtividade, $competencia)
    {
        try{
            $this->authorize('HOMOLOGAR_FICHA_RECONHECIMENTO');
            $titulopainel = 'Fichas de reconhecimento com recursos analisados para promoção de ';

            $recursoAnalisado = ['recursoAnalisado' => 1];

            $graduacao = 'todos';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisRecursosFicha($idQuadro, 'todos', $recursoAnalisado);
           // dd($policiaisQuadro);
            
            $contador_inicial = 0;
            if(method_exists($policiaisQuadro,'currentPage')){
              $contador_inicial = ($policiaisQuadro->currentPage()-1) * $policiaisQuadro->perPage();
            }

            $recursoAnalisado = 1;
           
            return view('promocao::quadroDeAcesso/listaEfetivoRecorreuHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'graduacao', 'contador_inicial', 'recursoAnalisado'));
            
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function listaPoliciaisHomologadosFicha($idQuadro, $idAtividade, $competencia)
    {
        try{
            $this->authorize('HOMOLOGAR_FICHA_RECONHECIMENTO');
            $exibeBotaoExcel = true;

            $titulopainel = 'Fichas de reconhecimento validadas para promoção de ';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisDoQuadroHomologados($idQuadro, 'homologada');
           
            $contador_inicial = 0;
            if(method_exists($policiaisQuadro,'currentPage')){
              $contador_inicial = ($policiaisQuadro->currentPage()-1) * $policiaisQuadro->perPage();
            }
            
            return view('promocao::quadroDeAcesso/listaEfetivoHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'exibeBotaoExcel', 'contador_inicial'));
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function buscaPolicialValidarFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $competencia){
        try{
            
            $dadosForm['criterio'] = $request->input('st_criterio');
            $dadosForm['filtro'] = $request->input('st_filtro');
            $policiaisQuadro = $this->QuadroAcessoService->buscaPolicialDoQuadroParaHomologarPorNomeCpfMatricula($idQuadro, $dadosForm);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $titulopainel = 'Sargentos para promoção de ';
            //return view('promocao::quadroDeAcesso/listaEfetivoHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade','titulopainel'));
            return view('promocao::quadroDeAcesso/listaEfetivoHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia'));
            
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function buscaPolicialRecorreuFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $competencia){
        try{

            $dadosForm['criterio'] = $request->input('st_criterio');
            $dadosForm['filtro'] = $request->input('st_filtro');

            $policiaisQuadro = $this->QuadroAcessoService->buscaPolicialDoQuadroParaHomologarPorNomeCpfMatricula($idQuadro, $dadosForm);
            
            $titulopainel = 'Fichas de reconhecimento com recursos para promoção de ';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            
            $contador_inicial = 0;
            if(method_exists($policiaisQuadro,'currentPage')){
              $contador_inicial = ($policiaisQuadro->currentPage()-1) * $policiaisQuadro->perPage();
            }
            
            return view('promocao::quadroDeAcesso/listaEfetivoRecorreuHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'contador_inicial'));
            
        } catch(\Exception $e){
            return redirect(url("promocao/recursosfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP/graduacao/todos"))->with('erroMsg', $e->getMessage());
        }
    }

    public function buscaPolicialFichaReconhecimentoAba(Request $request, $idQuadro, $idAtividade, $competencia, $aba){
        try{

            $dadosForm['st_aba'] = $aba;
            $dadosForm['st_parametro'] = $request->input('st_filtro');
            $dadosForm['st_filtro'] = $request->input('st_criterio');
           
            $policiaisQuadro = $this->QuadroAcessoService->buscaPolicialFichaReconhecimentoAba($idQuadro, $dadosForm);
            
            /* {
                    st_aba: nao_enviadas ou enviadas ou  nao_homologadas ou  homologadas ou recursos  ou analisados
                    st_parametro: st_matricula ou st_nome ou st_cpf
                    st_filtro: matrícula ou nome ou cpf do pm
                } */
            $titulopainel = 'Fichas de reconhecimento com recursos para promoção de ';

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            
            $contador_inicial = 0;
            if(method_exists($policiaisQuadro,'currentPage')){
              $contador_inicial = ($policiaisQuadro->currentPage()-1) * $policiaisQuadro->perPage();
            }

            if ( $aba == 'recursos' ) {

                $recursoAnalisado = 0;

                return view('promocao::quadroDeAcesso/listaEfetivoRecorreuHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'contador_inicial', 'recursoAnalisado'));

            } elseif ($aba == 'analisados') {

                $recursoAnalisado = 1;

                return view('promocao::quadroDeAcesso/listaEfetivoRecorreuHomologarFicha', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'competencia', 'contador_inicial', 'recursoAnalisado'));
            }

        } catch(\Exception $e){

            if ( $aba == 'recursos' ) {

                return redirect(url("promocao/recursosfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP/graduacao/todos"))->with('erroMsg', $e->getMessage());

            } elseif ($aba == 'analisados') {

                return redirect(url("promocao/recursosanalisadosfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP"))->with('erroMsg', $e->getMessage());
            }
        }
    }

    public function validarFichaReconhecimento($idQuadro, $idAtividade, $idPolicial, $competencia)
    {
        try{
            $this->authorize('HOMOLOGAR_FICHA_RECONHECIMENTO');
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);

             //percorre as fichas
             foreach($policialDoQuadro->fichas as $key => $ficha){
                //seleciona a ficha definitiva por padrão
                if($ficha->st_ficha == 'DEFINITIVA')
                    $idFicha = $ficha->id;
                    $ficha = $ficha;

            }
            $pontuacoes = $ficha->pontuacoes;

            //$arquivos = $this->ArquivoBancoService->findArquivoIdQuadroIdPolicial($idQuadro, $idPolicial);
            $arquivos = $this->ArquivoBancoService->getlistaArquivoIdentificador($idFicha, "PROMOCAO");

            // Busca a atividade pelo id do quadro, número da fase e o número da sequência (2, 1: Escriturar ficha)
            $atividade = $this->QuadroAcessoService->findAtividadeIdFaseSequencia($idQuadro, 2, 1);

            //$policialDoQuadro = $this->QuadroAcessoService->findPolicialDoQuadroAcessoById($idQuadro, $idPolicial);
           
            if ( $quadro->st_status == "ABERTO"){


                return view('promocao::quadroDeAcesso/validarFichaReconhecimento', compact('ficha', 'pontuacoes', 'idQuadro', 'idAtividade', 'idPolicial', 'arquivos', 'atividade', 'competencia', 'policialDoQuadro'));
             }else{
                throw new Exception('Não pode editar Ficha de Reconhecimento com qa fechado');
            } 

          
        
        }catch(Exception $e){
            dd($e->getLine(). '-->'.$e->getmessage());
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    public function validarFichaReconhecimentoSelecionada($idQuadro, $idAtividade, $idPolicial, $competencia,$idFicha)
    {
        try{
            $this->authorize('HOMOLOGAR_FICHA_RECONHECIMENTO');

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);

             //percorre as fichas
             foreach($policialDoQuadro->fichas as $key => $fichaSelecionada){
                //dd($ficha);
                //seleciona a ficha definitiva por padrão
                if($fichaSelecionada->id == $idFicha)
                    $ficha = $fichaSelecionada;

            }
            $pontuacoes = $ficha->pontuacoes;

            $arquivos = $this->ArquivoBancoService->findArquivoIdQuadroIdPolicial($idQuadro, $idPolicial);

            // Busca a atividade pelo id do quadro, número da fase e o número da sequência (2, 1: Escriturar ficha)
            $atividade = $this->QuadroAcessoService->findAtividadeIdFaseSequencia($idQuadro, 2, 1);

          
            return view('promocao::quadroDeAcesso/validarFichaReconhecimento', compact('ficha', 'pontuacoes', 'idQuadro', 'idAtividade', 'idPolicial', 'arquivos', 'atividade', 'competencia', 'policialDoQuadro'));
  
        
        }catch(Exception $e){
            //dd('validarFichaReconhecimentoSelecionada'.$e->getLine(). '-->'.$e->getmessage());
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function homologarValidacaoFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $idPolicial,$idFicha, $dadosHomologar = null){
        try{

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
                
            if(empty($dadosHomologar)){
                $dadosForm = $request->all();
                unset($dadosForm['_token']);

                $cpf = auth()->user()->st_cpf;

                if(!isset($request['password'])){
                    return redirect()->back()->with('erroMsg', MSG::SENHA_OBRIGATORIA); 
                }

                $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);

                //Validando credencais
                $ldap = $this->Authldap->autentica($credenciais);
                if($ldap == false){
                    return redirect()->back()->with('erroMsg', MSG::SENHA_INVALIDA); 
                }

                unset($dadosForm['password']);

            }else{
                dd('elsedohomologar');
           /*      for ($i=0; $i < count($dadosHomologar); $i++) { 
                    $dadosForm[$pontuacoes[$i]->st_nomeinterno] = $dadosHomologar[$i];
                } */
            }

$dadosForm['ce_ficha'] = $idFicha;
//$dadosForm = array('ce_ficha'=> $idFicha);
            $salvar = $this->QuadroAcessoService->assinarHomologacaoFichaReconhecimentoQA($idQuadro, $idPolicial,$dadosForm);

            if ( $quadro->bo_escriturarliberado == 1 ) {

                return redirect('promocao/homologarfichareconhecimento/'.$idQuadro.'/'.$idAtividade.'/competencia/CPP/graduacao/todos')->with('sucessoMsg', $salvar);

            } else {
                
                return redirect('promocao/recursosfichareconhecimento/'.$idQuadro.'/'.$idAtividade.'/competencia/CPP/graduacao/todos')->with('sucessoMsg', $salvar);
            }
            
        }catch(Exception $e){
            return redirect()->back()->withInput()->with('erroMsg', $e->getMessage());
        }
    }
    public function salvarValidacaoFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $idPolicial){
        try{
            $dadosForm = $request->all();
           
            if(isset($dadosForm['_token'])){
                unset($dadosForm['_token']);
            }
            //dd($dadosForm);
            $salvar = $this->QuadroAcessoService->salvarHomologarFichaReconhecimentoQA($idQuadro, $idPolicial, $dadosForm);
            return redirect()->back()->with('sucessoMsg', $salvar);
        }catch(Exception $e){
            return redirect()->back()->withInput()->with('erroMsg', $e->getMessage());
        }
    }
    
    /**
     * @autor: Higor
     * Retorna a ficha de reconhecimento para a unidade de origem
     */
    public function retornarFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $idPolicial){
        try{

             //resgata o CPF do  policial
             $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);

             if(!isset($request['password'])){
                 return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
             }
             $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
             //Validando credencais
             $ldap = $this->Authldap->autentica($credenciais);
             if($ldap == false){
                 return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
             }

            $salvar = $this->QuadroAcessoService->retornarFichaReconhecimento($idQuadro, $idAtividade, $idPolicial);
            return redirect('promocao/homologarfichareconhecimento/'. $idQuadro . '/' . $idAtividade . '/CPP')->with('sucessoMsg', $salvar);
        }catch(Exception $e){
            return redirect()->back()->withInput()->with('erroMsg', $e->getMessage());
        }
    }

    
    /* @aggeu. Issue 222. Trabalhado em cima desta função. */
    public function listarPoliciaisQaPreliminar($idQuadro, $idAtividade, $competencia){
        try{
            
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            if(empty($quadro)){
                return redirect()->back()->with('erroMsg', Msg::QA_NAO_ENCONTRADO);
            }
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if(empty($atividade)){
                return redirect()->back()->with('erroMsg', Msg::ATIVIDADE_NAO_ENCONTRADA);
            }
            /* ---@aggeu. Issue 222. Código adicionado.---- */
            $comissao = $this->QuadroAcessoService->listaPolicialAssinaturaPortaria($idAtividade);
            
            $contador = 0;
            foreach($comissao as $c){
                if($c->st_assinatura){
                    $contador++;
                }
            }
            $assinaturas = $contador;

            $matricula = Auth::user()->matricula;
            $matriculaLogada = trim($matricula);
            /* ---/Issue 222--- */
            $policiaisQuadro  = $this->QuadroAcessoService->listaPoliciaisDoQuadro($idQuadro);
            return view('promocao::quadroDeAcesso.listaPoliciaisQuadroPreliminar', compact('comissao', 'assinaturas', 'matriculaLogada', 'policiaisQuadro', 'quadro','atividade','idQuadro', 'competencia'));

            //return redirect()->back()->with('sucessoMsg', $criaNota);
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

      /**
     * Método que salva dados da portaria para divulgar  Quadro de Acesso a prmoçao de praças preliminar.
     * @return Response
     */
    public function cadastrarPortariaDivulgarQaPreliminar(Request $request, $idQuadro, $idAtividade){
        try{
            $dadosForm = $request->all();
            //Validando os dados
            $validator = validator($dadosForm, [
                'st_portaria' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);//Mensagem de erro com o formulário preenchido
            }

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if($atividade->dt_atividade != null){
                return redirect()->back()->with('erroMsg', Msg::NAO_PERMITIDO);
            }
            $dadosForm['st_tipo'] = 'divulgarQaPreliminar';
            $atualizaCronograma = $this->QuadroAcessoService->updatePortariaParaCronograma($idAtividade, $dadosForm);
            return redirect('promocao/divulgarqapreliminar/'. $idQuadro . '/' . $idAtividade)->with('sucessoMsg', $atualizaCronograma);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* @aggeu. Issue 222. Trabalhado em cima desta função. */
    public function gerarNotaQaPreliminar(Request $request, $idQuadro, $idAtividade, $tiporenderizacao){
        try{
            
            $dadosForm = $request->all();
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
        
            if(empty($quadro)){
                return redirect()->back()->with('erroMsg', Msg::QA_NAO_ENCONTRADO);
            }


            if($tiporenderizacao != "visualizar"){
                $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
                if($atividade->st_portaria == null){
                    return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
                }elseif(!empty($atividade->ce_nota)){
                    return redirect()->back()->with('erroMsg', Msg::NOTA_JA_EXISTE);
                }
            }else{
                $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
                if($atividade->st_portaria == null){
                    return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
                }
            }    

             //resgata a unidade operacional do  policial
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);

            if($tiporenderizacao != "visualizar"){
                if(!isset($request['password'])){
                    return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
                }                
                $ldap = $this->Authldap->autenticar($request['password']);
                if($ldap == false){
                    return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
                }
            }

            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
            
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', Msg::POLICIAL_SEM_UNIDADE);
            }
            
            
            $policiais  = $this->QuadroAcessoService->listaTodosPoliciaisDoQuadro($idQuadro);
                  
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

            $qpmp = null;
            $graduacao = null;
            $tabela1 = null;
            $promoximaGrad = null;
            foreach($policiais as $pol){
                //caso o qpmp da vez for diferente do anterior gera uma nova tabela
                if( $pol->ce_qpmp !=  $qpmp || $pol->ce_graduacao != $graduacao){
                    /**
                     * Se a variável qmpm ou a graduação for difente de null é porque esse elemento não é mais o primeiro. Entao se qpmp ou graduação 
                     * for diferente do elemento da vez a porque deve ser inserido em outra tabela. Por isso, deve fechar a tabela criada anteriormente.
                     */
                    if($qpmp  != null || $graduacao  != null){
                            $tabela1 =  $tabela1. '</table>';
                    }
                    /**
                     * Condições para GERAR O TÍTULO DA TABELA  de acordo com a QPMP e a Graduação, dinamicamente
                     */
                    switch ($pol->ce_graduacao) {
                        case '2':
                            $promoximaGrad = 'CABO';
                            break;
                        case '3':
                            $promoximaGrad = '3º SGT';
                            break;
                        case '4':
                            $promoximaGrad = '2º SGT';
                            break;
                        case '5':
                            $promoximaGrad = '1º SGT';
                            break;
                        case '6':
                            $promoximaGrad = 'SUBTENENTE';
                            break;   
                    }

                    $tabela1 = $tabela1.'QUADRO DE ACESSO PARA PROMOÇÃO À GRADUAÇÃO DE '.$promoximaGrad.'  QPMP-'.$pol->ce_qpmp; 
                    $tabela1 = $tabela1.'<table border="1" width="100%" cellpadding="2" cellspacing="0">'.
                                '<thead>'. 
                                    '<tr>'.
                                        '<th style="width: 40px; text-align: center"><font size=0>GRAD.</font></th>'.
                                        '<th style="width: 50px; text-align: center"><font size=0>NUM</font></th>'.
                                        '<th style="text-align: center"><font size=0>NOME</font></th>'.
                                        '<th style="width: 50px; text-align: center"><font size=0>MAT.</font></th>'.
                                        '<th style="width: 75px; text-align: center"><font size=0>OME</font></th>'.
                                        '<th style="width: 50px; text-align: center"><font size=0>PONTOS</font></th>'.
                                    '</tr>'.
                                '</thead>'.
                                '<tbody>'.
                                    '<tr>'.
                                        '<td style="width: 40px; text-align: center"><font size=0>'.$pol->st_postgrad.'</font></td>'.
                                        '<td style="width: 50px; text-align: center"><font size=0>'.$pol->st_numpraca.'</font></td>'.
                                        '<td><font size=0>'.$pol->st_policial.'</font></th>'.
                                        '<td style="width: 50px; text-align: center"><font size=0>'.$pol->st_matricula.'</font></td>'.
                                        '<td style="width: 75px; text-align: center"><font size=0>'.$pol->st_unidade.'</font></td>'.
                                        '<td style="width: 50px; text-align: center"><font size=0>'.$pol->vl_pontos.'</font></td>'.
                                    '</tr>';
                                
                            $qpmp = $pol->ce_qpmp;
                            $graduacao = $pol->ce_graduacao;

                //Se o qpmp da vez for igual do anterior gera apenas uma linha na tabela existente
                }else{
                    $tabela1 = $tabela1.
                                    '<tr>'.
                                        '<td style="width: 40px; text-align: center"><font size=0>'.$pol->st_postgrad.'</font></td>'.
                                        '<td style="width: 50px; text-align: center"><font size=0>'.$pol->st_numpraca.'</font></td>'.
                                        '<td><font size=0>'.$pol->st_policial.'</font></th>'.
                                        '<td style="width: 50px; text-align: center"><font size=0>'.$pol->st_matricula.'</font></td>'.
                                        '<td style="width: 75px; text-align: center"><font size=0>'.$pol->st_unidade.'</font></td>'.
                                        '<td style="width: 50px; text-align: center"><font size=0>'.$pol->vl_pontos.'</font></td>'.
                                    '</tr>';
                }
            }

            $listaComissao = null;
            $comissao = $this->QuadroAcessoService->listaPolicialAssinaturaPortaria($idAtividade);
            foreach($comissao as $c){
                if($c->st_assinatura != null){
                    $listaComissao .='<div style="text-align: center">'. QuadroDeAcessoController::titleCase($c->st_nomeassinante) .' - '. $c->st_postograd .'<br>'. QuadroDeAcessoController::titleCase(mb_strtoupper($c->st_funcao, 'UTF-8')) .'</div>';
                }
            }
    

            /* ---criando dados do pdf--- */

            $dadosForm = [];
            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['idUsuario'] = Auth::user()->id;
            $dadosForm['st_status'] = Status::NOTA_RASCUNHO;
            $dadosForm['nu_ano'] = date('Y');
            $dadosForm['ce_tipo'] = '11';
            $dadosForm['idAtividade'] = $idAtividade;
            $dadosForm['dt_cadastro'] = date('Y-d-m H:i:s');
            $dadosForm['st_assunto'] = "QUADROS DE ACESSOS";
            $dadosForm['st_materia'] = $atividade->st_portaria;
            $dadosForm['st_materia'] .= $tabela1;

            $dadosForm['st_materia'] .= "</tbody>
            </table>";

            $dadosForm['st_materia'] .= $listaComissao;

            /* dd($dadosForm['st_materia']); */
            
            /* ---/--- */
            /* dd($dadosForm); */
            if($tiporenderizacao == "visualizar"){
                $nota = (object)$dadosForm;
                return \PDF::loadView('boletim::notas/pdf_nota', compact('nota'))->stream('nota.pdf');
            }else{
                $criaNota = $this->QuadroAcessoService->criarNota($dadosForm, $idQuadro);
                return redirect()->back()->with('sucessoMsg', $criaNota);
            }
        
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    
    public function finalizarEscrituracao(Request $request, $idQuadro, $idAtividade, $competencia)
    {
        if(!isset($request['password'])){
            return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
        }
        
        $ldap = $this->Authldap->autenticar($request['password']);
        if($ldap == false){
            return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
        }
        $atualiza = $this->QuadroAcessoService->concluirAtividade($idAtividade);
        return redirect('promocao/quadro/cronograma/' . $idQuadro . '/competencia/' . $competencia)->with('sucessoMsg', $atualiza);
    }

    /*  @autor: Juan Mojica
        cadastra o policial na comissão de uma portaria
     */
    public function cadastrarPolicialNaComissao(Request $request, $idQuadro, $idAtividade){
        try {
            $idPolicial = $request->idPolicial;
            $dadosForm['st_funcaoAssinate'] = $request->st_funcao;
            
            $this->QuadroAcessoService->cadastraPolicialAssinaturaPortaria($idQuadro, $idAtividade, $idPolicial, $dadosForm);

            return redirect()->back()->with('sucessoMsg', Msg::SALVO_SUCESSO);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    /* @author: Juan Mojica 
     * Exclui um arquivo de um Policial 
     */
    public function deletarMembroDaComissao($idQuadro, $idAtividade, $idPolicial){
        try {
            // Exclui do banco
            $this->QuadroAcessoService->excluiPolicialAssinaturaPortaria($idQuadro, $idAtividade, $idPolicial);
                              
            // recarrega a view com a mensagem de sucesso
            return redirect()->back()->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);

        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /* Autor: @aggeu. Issue 215. */
    public function cadastraPolicialAssinaturaPortaria(Request $request, $idQuadro, $idAtividade){
        try{
            $dadosForm = $request->all();
            $idPolicial = $request->idPolicial;            
            $policial = $this->QuadroAcessoService->cadastraPolicialAssinaturaPortaria($idQuadro, $idAtividade, $idPolicial, $dadosForm);
            return redirect()->back()->with('sucessoMsg', $policial);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* Autor: @aggeu. Issue 215. */
    public function excluiPolicialAssinaturaPortaria($idQuadro, $idAtividade, $idPolicial){
        try{    
            $this->QuadroAcessoService->excluiPolicialAssinaturaPortaria($idQuadro, $idAtividade, $idPolicial);
            return redirect()->back()->with('sucessoMsg', Msg::EXCLUIDO_SUCESSO);
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* Autor: @aggeu. Issue 215. */
    public function formCadastraPolicialAssinaturaPortaria($idQuadro, $idAtividade){
        try{

            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
                       
            return view('promocao::quadroDeAcesso.listaPoliciaisQuadroPreliminar', compact('policiaisQuadro', 'quadro','atividade','idQuadro'));

            return view('rh::policial.EditaDocumentos', compact('policial'));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*  @autor: Juan Mojica
        O policial assina a portaria ou ata com sua senha digital
     */
    public function assinarPortariaDoQuadro(Request $request, $idQuadro, $idAtividade){
        try {
            //Verifica se existe senha
            if(!isset($request['st_password'])){
                return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
            }
            //Busca cpf do usuário logado
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            //Busca policial pelo CPF
            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
            //Busca um policial cadastrado na comissão 
            $policialDaComissao = $this->QuadroAcessoService->getPolicialDaComissao($idQuadro, $idAtividade, $policial->id);
            if($policialDaComissao == Msg::NENHUM_RESULTADO_ENCONTRADO){
                return redirect()->back()->with('erroMsg', Msg::POLICIAL_NAO_ENCONTRADO_NA_COMISSAO);
            }
            //Verificação de segurança ao tentar assinar uma ata ou portaria
            $ldap = $this->Authldap->autenticar($request['st_password']);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
            }
            $dadosForm['st_cpf'] = $cpf;
            $dadosForm['st_password'] = $request->st_password;
            
            $this->QuadroAcessoService->assinarPortariaDoQuadro($idQuadro, $idAtividade, $dadosForm);

            return redirect()->back()->with('sucessoMsg', Msg::NOTA_ASSINADA);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /* Autor: @aggeu. Issue 215. */
    public function finalizarPolicialAssinaturaPortaria(Request $request, $idQuadro, $idAtividade)
    {
        try{

            $dadosForm = $request->all();            
            
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if($atividade->st_portaria == null){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }elseif(!empty($atividade->ce_nota)){
                return redirect()->back()->with('erroMsg', Msg::NOTA_JA_EXISTE);
            }
             //resgata a unidade operacional do  policial
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);

            //dd(Auth::user());

            if(!isset($request['st_password'])){
                return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
            }
            
            $ldap = $this->Authldap->autenticar($request['st_password']);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
            }
            
            $dadosForm['st_password'] = $request->st_password;           

            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);

            
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', Msg::POLICIAL_SEM_UNIDADE);
            }
            $dadosForm['st_cpf'] = $policial->st_cpf;

            $this->QuadroAcessoService->finalizarPolicialAssinaturaPortaria($idQuadro, $idAtividade, $dadosForm);
            return redirect()->back()->with('sucessoMsg', Msg::NOTA_ASSINADA);
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }

    }

    //@autor: Juan Mojica
    //Verifica se todos os membros da comissão assinaram
    public function verificaAssinaturas($membrosDaComissao){
        $count = 0;
        foreach($membrosDaComissao as $m){
            if($m->st_assinatura != null){
                $count++;
            }
        }
        if(count($membrosDaComissao) == $count){
            return true;
        }else{
            return false;
        }
    }

    //@autor: Juan Mojica
    public function cadastrarPortariaDivulgarQuadroDeVagas(Request $request, $idQuadro, $idAtividade){
        try{
            $dadosForm = $request->all();
            
            // Validando os dados do formulário
            $validator = validator($dadosForm, ['st_portaria' => 'required']); 
            
            // Validação de campo obrigatório
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS); 
            }

            $dadosForm['st_tipo'] = 'divulgarQuadroVagas';
            
            // Cadastra os dados da portaria
            $this->QuadroAcessoService->updatePortariaParaCronograma($idAtividade, $dadosForm); 
            
            return redirect()->back()->with('sucessoMsg', Msg::SALVO_SUCESSO);

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }      
    }

    /* Autor: @aggeu. Issue 215. */
    public function procuraPolicialAssinaturaPortaria(Request $request, $idQuadro, $idAtividade){
        try{
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_funcaoAssinate' => 'required',
                'st_cpf' => 'required'
            ]);
            if($validator->fails()){
                //Mensagem de erro com o formulário preenchido
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }            
            $policial = $this->PolicialService->buscaPolicialNomeCpfMatricula($dadosForm->st_cpf);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            return view('promocao::quadroDeAcesso/inspecaoTaf', compact('quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'policiaisQuadroParaInspecionar', 'tafInspecionados'));
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    //@autor: Juan Mojica
    //Verifica se algum membro da comissão assinou
    public function alguemAssinou($membrosDaComissao){
        foreach($membrosDaComissao as $m){
            if($m->st_assinatura != null){
                return true;
            }
        }
        return false;
    }
    

    /**
     * Método que chama a tela para Realizar pré-análise (JPMS) - Não analisado. @aggeu, #254.
     */
    public function preanalisejpms($idQuadro, $idAtividade, $competencia){
        try{
            $st_situacao = "convocado";
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);           
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisParaPreanaliseJPMS($idQuadro, $st_situacao);
            $tipoAnalise = "naoanalisado";
            $totalParaInspecionar = (empty($policiaisQuadro)) ? '0' : $policiaisQuadro->total();
            $titulopainel = 'Policiais para pré-análise (JPMS) referente à promoção de ';
            return view('promocao::inspecaoSaude/listaPoliciaisPreanaliseJPMS', compact('competencia', 'tipoAnalise', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'idQuadro', 'totalParaInspecionar'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método que chama a tela para realizar Realizar pré-análise (JPMS)  - Com pendência na JPMS. @aggeu, #254.
     */
    public function compendencianajpms($idQuadro, $idAtividade, $competencia){
        try{
            $st_situacao = "pendente";
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);           
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisParaPreanaliseJPMS($idQuadro, $st_situacao);
            $tipoAnalise = "compendencia";
            $totalParaInspecionar = (empty($policiaisQuadro)) ? '0' : $policiaisQuadro->total();
            $titulopainel = 'Policiais para pré-análise (JPMS) referente à promoção de ';
            return view('promocao::inspecaoSaude/listaPoliciaisPreanaliseJPMS', compact('competencia', 'tipoAnalise', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'idQuadro', 'totalParaInspecionar'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

     /**
     * Método que chama a tela para realizar Realizar pré-análise (JPMS) - Sem pendência na JPMS. @aggeu, #254.
     */
    public function sempendencianajpms($idQuadro, $idAtividade, $competencia){
        try{
            $st_situacao = "regular";
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);           
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisParaPreanaliseJPMS($idQuadro, $st_situacao);
            $tipoAnalise = "sempendencia";
            $totalParaInspecionar = (empty($policiaisQuadro)) ? '0' : $policiaisQuadro->total();
            $titulopainel = 'Policiais para pré-análise (JPMS) referente à promoção de ';
            return view('promocao::inspecaoSaude/listaPoliciaisPreanaliseJPMS', compact('competencia', 'tipoAnalise', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'idQuadro', 'totalParaInspecionar'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /*
     * Método que chama a tela para pré-análise JPMS - @aggeu, #254.
     */
    public function buscaPolicialParaPreanaliseJpms(Request $request, $idQuadro, $idAtividade, $competencia){
        try{
            $parametroDeBusca = $request->input('st_parametro');
            $filtro = $request->input('st_filtro');
            $policiaisQuadro = $this->QuadroAcessoService->buscaPolicialDoQuadroPorNomeCpfMatricula($idQuadro, $parametroDeBusca, $filtro);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $totalParaInspecionar = (empty($policiaisQuadro)) ? '0' : $policiaisQuadro->total();
            $titulopainel = 'Policiais para pré-análise (JPMS) referente à promoção de ';
            $tipoAnalise = "busca";

            return view('promocao::inspecaoSaude/listaPoliciaisPreanaliseJPMS', compact('competencia', 'tipoAnalise', 'idQuadro', 'quadro', 'policiaisQuadro', 'atividade','titulopainel', 'totalParaInspecionar'));
            
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * Método para realizar Pré-análise da JPMS referente à Promoção - @aggeu, #254.
     */
    public function realizarpreanalisejpms(Request $request, $idPolicialNoQuadro, $idQuadro){
        try{       
             $dadosForm = $request->all();
             $url = $dadosForm['url'];
             $validator = validator($dadosForm, [
                 'bo_pendenciapreanalisejpms' => 'required'
             ]);
             if($validator->fails()){
                 return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
                }
                $preanalise = $this->QuadroAcessoService->realizarpreanalisejpms($idPolicialNoQuadro, $idQuadro, $dadosForm);
                if($dadosForm['st_seguimento'] == 'buscapolicialparapreanalisejpms'){
                    return redirect("promocao/preanalisejpms/".$idQuadro."/".$dadosForm['st_atividade']."/competencia/".$dadosForm["competencia"])->with('sucessoMsg', $preanalise);
                    
                }
                
            return redirect("promocao/".$dadosForm['st_seguimento']."/".$idQuadro."/".$dadosForm['st_atividade']."/competencia/".$dadosForm["competencia"])->with('sucessoMsg', $preanalise);
         
         } catch(\Exception $e){
             return redirect()->back()->with('erroMsg', $e->getMessage());
         }
     }

    /**
    * @Márcio, #255
    * Método exibe a tela para consultar o policial e verificar se tem pendências
    */
    public function consultarPolicialParaResolverPendenciasCpp($idQuadro,$idAtividade,$competencia)
    {
        try{

            return view('promocao::quadroDeAcesso.resolverPendenciaCpp', compact('competencia', 'idQuadro', 'idAtividade')); 

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
    * @Márcio, #255
    * Método exibe o policial consultado
    */
    public function listarPolicialParaResolverPendenciasCpp(Request $request,$idQuadro,$idAtividade,$competencia)
    {
        try{
            $st_parametro = $request->input('st_parametro');
            $policialQuadro = $this->QuadroAcessoService->buscaPolicialDoQuadroPorCpfMatricula($idQuadro, $st_parametro);
            return view('promocao::quadroDeAcesso.resolverPendenciaCpp', compact('competencia', 'policialQuadro', 'idQuadro', 'idAtividade')); 

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
    * @Márcio, #255
    * Método atualização das informações do policial em um determinado QA. 
    */
    public function salvarAtualizacaoDoPolicialPendenciasCpp(Request $request,$idQuadro,$idAtividade,$idPolicial,$competencia)
    {
        try{
            $dadosForm = $request->all();

            if((strlen($dadosForm['st_motivosaidadoqa']) > '500' 
            || strlen($dadosForm['st_inspecaojuntaobs']) > '300' 
            || strlen($dadosForm['st_protocolorecurso']) > '50' 
            || strlen($dadosForm['st_recurso']) > '500' 
            || strlen($dadosForm['st_documentospendentes']) > '200' 
            || strlen($dadosForm['st_respostarecurso']) > '500' 
            || strlen($dadosForm['st_inspecaotafobs']) > '300')){
              return redirect()->back()->with('erroMsg', 'Limite de caracteres excedido');
            }
//Não encontrei uma forma melhor de tratar o limite de caracteres. Só vai chegar aqui se passar do bloqueio do html maxlength
          
            $fichaPolicial = $this->QuadroAcessoService->findPolicialDoQuadroAcessoById($idQuadro, $idPolicial);
            unset ($dadosForm['_token']);
            $this->QuadroAcessoService->updatePolicialPendenciasQa($idQuadro, $idPolicial, $dadosForm);
            return redirect("promocao/pendencias/". $idQuadro . "/" . $idAtividade . "/" . $idPolicial . "/competencia/" . $competencia)->with('sucessoMsg', Msg::ATUALIZADO_SUCESSO);

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
    * @Márcio, #255
    * Lista as informações do policial em um determinado QA atualizado. 
    */
    public function listarPolicialComPedenciaResolvidaCpp($idQuadro,$idAtividade,$idPolicial,$competencia)
    {
        try{
            $policialQuadro = $this->QuadroAcessoService->findPolicialDoQuadroAcessoById($idQuadro, $idPolicial);
            return view('promocao::quadroDeAcesso.resolverPendenciaCpp', compact('competencia', 'policialQuadro', 'idQuadro', 'idAtividade')); 

        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
    * @Márcio, #257-realizar-inpecao-extra-pela-jpms
    * Método que chama a tela para inspeção Extra pela JPMS
    */
    public function convocarInspExtraJpms($idQuadroAcesso, $idAtividade, $competencia){
        try{
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadroAcesso);
            if(empty($quadro)){
                return redirect()->back()->with('erroMsg', Msg::QA_NAO_ENCONTRADO);
            }
           
            if(isset($quadro) && $quadro->st_status != 'ABERTO'){
                return redirect()->back()->with('erroMsg', 'Quadro de acesso Fechado');
            }
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if(empty($atividade)){
                return redirect()->back()->with('erroMsg', Msg::ATIVIDADE_NAO_ENCONTRADA);
            }
          //  $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisDoQuadroParaPromocaoConvocacaoExtraJmps($idQuadroAcesso);
            
            $dadosDaPortaria = $this->QuadroAcessoService->listaAPortariaEPoliciaisDoQuadroParaPromocaoConvocacaoExtraJmps($idQuadroAcesso, $idAtividade);
            // dd($policiaisQuadroPortaria);
            $titulopainel = 'Tela de Convocação Extra para o Quadro de Acesso da Promoção de ';
                return view('promocao::inspecaoSaude/listaPoliciaisInspExtraJPMS', compact('dadosDaPortaria', 'idAtividade', 'quadro', 'atividade', 'titulopainel', 'idQuadroAcesso', 'competencia'));
         } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
    * @Márcio, #257-realizar-inpecao-extra-pela-jpms
    * Método que Remover um policial da Convocação Extra
    */
        public function removerPolicialDaConvocacoExtra($idPolicial, $idQuadroDeAcesso, $idAtividade){
            try{
                $remover = $this->QuadroAcessoService->removerPolicialQuadro($idPolicial, $idQuadroDeAcesso);
                return redirect('promocao/convocacaoextra/'.$idQuadroDeAcesso.'/'.$idAtividade.'/competencia/CPP')->with('sucessoMsg', $remover);
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

    /**
    * @Márcio, #257-realizar-inpecao-extra-pela-jpms
    * Método que Cria uma nova nota para boletim do tipo Convocação Extra
    */


    
    public function gerarNotaConvocacaoExtra(Request $request, $idQuadro, $idAtividade, $competencia ){
        try{
 
             //resgata a unidade operacional do  policial
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);

            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', 'Informe a Senha Usuário.'); 
            }
            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', 'Senha inválida.'); 
            }

            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
            
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', 'O policial logado não está cadastrado ou vinculado a unidade operacional.');
            }
            $dadosForm = [];
            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['idUsuario'] = Auth::user()->id;
            $dadosForm['st_status'] = Status::NOTA_RASCUNHO;
            $dadosForm['nu_ano'] = date('Y');
            $dadosForm['ce_tipo'] = '16';
            $dadosForm['idAtividade'] = $idAtividade;
            $dadosForm['dt_cadastro'] = date('Y-d-m H:i:s');
            $portaria = $this->QuadroAcessoService->listaTodosPoliciaisDoQuadroParaConvocacaoExtra($idQuadro, $idAtividade);
            $tabelaSoldados = null;
            $contadorPolicial = 0;
            $contadorSoldados = $contadorSoldadosAptos = $contadorCabos = $contadorCabosAptos = $contadorSargentos = $contadorSargentosAptos = 1;
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
            if(count($portaria['policiais'])> 0){
                foreach($portaria['policiais'] as $pol){
                    $contadorPolicial = $contadorPolicial++;
                    $tabelaSoldados .= "<tr>";
                                    $tabelaSoldados .= "<th>" . $contadorPolicial . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_postgrad . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_numpraca . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_policial . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_matricula . "</th>";
                                    $tabelaSoldados .= "<th>" . $pol->st_unidade . "</th>";
                                $tabelaSoldados .= "</tr>";
                    
                }
            }
           
            $dadosForm['st_materia'] = $portaria['st_portaria'];
            $dadosForm['st_assunto'] = 'INSPEÇÃO DE SAÚDE PARA FINS DE INCLUSÃO EM QUADRO DE ACESSO';
            $dadosForm['st_materia'] .= '<table border="1" style="width: 100%;">
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>GRAD</th>
                        <th>Nº DE PRAÇA</th>
                        <th>NOME</th>
                        <th>MAT</th>
                        <th>OME</th>
                    </tr>
                </thead>
                <tbody>';
                   
                $dadosForm['st_materia'] .= $tabelaSoldados;
                $dadosForm['st_materia'] .= "</tbody>
            </table>";
           
       
            
            $criaNota = $this->QuadroAcessoService->criarNotaConvocacaoExtra($dadosForm, $idQuadro, $idAtividade, $portaria['id']);
            return redirect()->back()->with('sucessoMsg', $criaNota);
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function gerarNotaConvocacaoExtra1(Request $request, $idQuadroAcesso, $idAtividade, $competencia){
        try{
            $dadosForm = $request->all();

             //resgata a unidade operacional do policial
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);

            $policial = $this->PolicialService->findPolicialByCpfMatricula($cpf);
            
            if(!isset($policial) || empty($policial->ce_unidade)){
                return redirect()->back()->with('erroMsg', Msg::POLICIAL_SEM_UNIDADE);
            }

            $dadosForm['ce_unidade'] = $policial->ce_unidade;
            $dadosForm['idUsuario'] = Auth::user()->id;
            $dadosForm['ce_tipo'] = '16';
            $dadosForm['idAtividade'] = $idAtividade;
            $dadosForm['st_assunto'] = "CONVOCAÇÃO EXTRA PARA JPMS PARA FINS DE INCLUSÃO DE QUADRO DE ACESSO";
            unset ($dadosForm['_token']);
            dd('ok');
           $criaNota = $this->QuadroAcessoService->criarNotaConvocacaoExtra($dadosForm);
            return redirect("promocao/convocacaoextra/" . $idQuadroAcesso . "/" . $idAtividade .  "/competencia/" . $competencia)->with('sucessoMsg', $criaNota);
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    
    /**
    * @Márcio, #257-realizar-inpecao-extra-pela-jpms
    * Método que Salva a portaria do tipo Convocação Extra
    */
    public function salvarMateriaConvocacaoExtra(Request $request, $idQuadroAcesso, $idAtividade, $competencia){
        try{
            $dadosForm = $request->all();
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadroAcesso);
            if(empty($quadro)){
                return redirect()->back()->with('erroMsg', Msg::QA_NAO_ENCONTRADO);
            }
            if(isset($quadro) && $quadro->st_status != 'ABERTO'){
                return redirect()->back()->with('erroMsg', 'Quadro de acesso Fechado');
            }
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if(empty($atividade)){
                return redirect()->back()->with('erroMsg', Msg::ATIVIDADE_NAO_ENCONTRADA);
            }
            unset ($dadosForm['_token']);
            $salvarportaria = $this->QuadroAcessoService->salvarPortariaConvocacaoExtra($idQuadroAcesso, $idAtividade, $dadosForm);
            
            return redirect("promocao/convocacaoextra/" . $idQuadroAcesso . "/" . $idAtividade .  "/competencia/" . $competencia)->with('sucessoMsg', $salvarportaria);
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que importa para o QA o efetivo da unidade do perfil do policial logado
     * @param {id do QA, id da atividade (ex de atividade: escrituração da ficha), compentência (ex: UNIDADE)}
     * @return (retorna para a rota de ficha de sgts não enviadas, com a msg de sucesso ou erro, dependendo da resposta da API)
     */
    public function importaPoliciaisDaUnidadeParaQA($idQuadro, $idAtividade, $competencia){
        try{
            
            $msg = $this->QuadroAcessoService->importaPoliciaisDaUnidadeParaQA($idQuadro, auth()->user()->ce_unidade);
            return redirect('promocao/fichasgtnaoenviada/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)->with('sucessoMsg', $msg);
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que importa os dados do policial para a sua ficha de escrituração
     * @param {id do QA, id da atividade (ex de atividade: escrituração da ficha), compentência (ex: UNIDADE)}
     * @return (retorna para a rota de ficha de sgts não enviadas, com a msg de sucesso ou erro, dependendo da resposta da API)
     */
    public function importaDadosPolicialEscriturarFicha($idQuadro, $idAtividade, $competencia, $idPolicial)
    {   
        try{
          
            //recupera o qa
            $quadroAcesso = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
           
            //recupera o pm do qa
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            
            //verifica se o pm está no qa
            if(empty($policialDoQuadro)){
                 throw new Exception("Policial não encontrado no QA");
            }

            //percorre as fichas do pm
            foreach ($policialDoQuadro->fichas as $key => $ficha) {
                if($ficha->st_ficha =='DEFINITIVA'){
                    $idFicha = $ficha->id;
                }
            }
            $anoDoQa =  date('Y', strtotime($quadroAcesso->dt_promocao));

            try {
                    //define o caminho de origem
                if($idQuadro==14 || $idQuadro == 3){
                    //regra exclusiva para o qa de abril de 2023 ser compatível com a nova regra 
                $caminho_armazenamento_origem = "PROMOCAO/2022/1/".str_replace(" ", "", $policialDoQuadro->st_cpf);//."/";
                }else{
                    $caminho_armazenamento_origem = "PROMOCAO/".$anoDoQa."/".$quadroAcesso->ce_qaanterior."/".str_replace(" ", "", $policialDoQuadro->st_cpf)."/".$idFicha."/";
                }
                //define o caminho de destino
                $caminho_armazenamento_destino = 'PROMOCAO/'.$anoDoQa."/".$idQuadro."/".str_replace(" ", "", $policialDoQuadro->st_cpf)."/".$idFicha."/";
                
                //dd($caminho_armazenamento_origem);
                //TODO - definir o que fazer caso o pm não tenha arquivos no ftp
                //testa se existe o diretorio de origem 
                if(!Storage::disk('ftp')->exists($caminho_armazenamento_origem)){ 
                    //creates directory
                    throw new Exception("Diretório de arquivos anexados a ficha de reconhecimento não encontrados");
                }

                //verifica se existem arquivos no diretório de origem
                $files = Storage::disk('ftp')->files($caminho_armazenamento_origem);

                /*   //verifica se existe arquivos
                if(count($files)<1){
                    throw new Exception("Arquivos anexados a ficha de reconhecimento não encontrados");
                } */					

                //testa se existe o diretorio de destino 
                if(!Storage::disk('ftp')->exists($caminho_armazenamento_destino)){ 
                    //creates directory
                    Storage::disk('ftp')->makeDirectory($caminho_armazenamento_destino, 0775, true); 
                }

                //percorre a lista de arquivos da ficha do qa anterior
                foreach ($files as $key => $fileAnterior) {
                    try {
                        //recupera apenas o nome do arquivo
                        $nomeArquivoAntigo = Str::after($fileAnterior, $policialDoQuadro->st_cpf.'/');

                        //pega o arquivo
                        $arquivoAnterior = Storage::disk('ftp')->get($fileAnterior); 

                        //salva o arquivo na nova pasta 
                        Storage::disk('ftp')->put($caminho_armazenamento_destino.$nomeArquivoAntigo, $arquivoAnterior);
                    } catch (\Throwable $th) {
                        //não faz nada
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                //não faz nada
            }
            //importo e clono os arquivos anexados na ficha do pm que estão no banco
            $msg = $this->QuadroAcessoService->importaDadosPolicialEscriturarFicha($idQuadro, auth()->user()->ce_unidade, $idPolicial);
            return redirect('promocao/fichasgtnaoenviada/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)->with('sucessoMsg', $msg);
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    private function clonarAnexosDaFichaReconhecimento($policialDoQuadro, string $caminho_armazenamento_origem, string $caminho_armazenamento_destino)
    {
        try {
            //testa se existe o diretorio de origem 
            if(!Storage::disk('ftp')->exists($caminho_armazenamento_origem)){ 
                //creates directory
                throw new Exception("Diretório de arquivos anexados a ficha de reconhecimento não encontrados");
            }

            //verifica se existem arquivos no diretório de origem
            $files = Storage::disk('ftp')->files($caminho_armazenamento_origem);
            
            //testa se existe o diretorio de destino 
            if(!Storage::disk('ftp')->exists($caminho_armazenamento_destino)){ 
                //creates directory
                Storage::disk('ftp')->makeDirectory($caminho_armazenamento_destino, 0775, true); 
            }

            //percorre a lista de arquivos da ficha do qa anterior
            foreach ($files as $key => $fileAnterior) {
                try {
                    //recupera apenas o nome do arquivo
                    $nomeArquivoAntigo = Str::after($fileAnterior, $policialDoQuadro->st_cpf.'/');

                    //pega o arquivo
                    $arquivoAnterior = Storage::disk('ftp')->get($fileAnterior); 
                    //monta o caminho completo (diretório + arquivo) de destino
                    $caminho_armazenamento_destino_completo = $caminho_armazenamento_destino.'/'.$nomeArquivoAntigo;
                    //salva o arquivo na nova pasta 
                    Storage::disk('ftp')->put($caminho_armazenamento_destino_completo, $arquivoAnterior);
                } catch (\Throwable $th) {
                    //não faz nada
                }
            }
            $files = Storage::disk('ftp')->files($caminho_armazenamento_origem);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    /**
     * @author juan_mojica - #451
     * Método que assina a ficha de reconhecimento dos SGTs
     * @param {id do QA, id do policial}
     * @return (retorna para a tela da ficha do policial, com a msg de sucesso ou erro, dependendo da resposta da API)
     */
    public function assinaFichaReconhecimento(Request $request, $idQuadro, $idPolicial){
        try{

            if(!isset($request['ce_ficha'])){
                return redirect()->back()->with('erroMsg', "Informar o Id da Ficha"); 
            }
            $idFicha = $request['ce_ficha'];

            $cpf = auth()->user()->st_cpf;

            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', MSG::SENHA_OBRIGATORIA); 
            }

            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', MSG::SENHA_INVALIDA); 
            }

            //$dados = ['st_cpf' => $cpf, 'st_password' => $request['password']];
            $dadosForm = ['ce_ficha' => $idFicha];
            
            $msg = $this->QuadroAcessoService->assinaFichaReconhecimento($idQuadro, $idPolicial,$dadosForm);
            
            return redirect()->back()->with('sucessoMsg', 'Ficha assinada com sucesso.');
            
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que gera o excel com a lista dos policiais com a ficha de reconhecimento validada
     * @return (retorna para a tela da ficha do policial, com a msg de sucesso ou erro, dependendo da resposta da API)
     */
    public function geraExcelFichaReconhecimento($idQuadro, $idAtividade){
        try{
            dd('cheogu no controller passando id do quadro e da atividade');
            
            
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Método que gera o excel com a lista dos policiais com ou sem pendências na ficha de reconhecimento
     * @param status ('sim' ou 'nao')
     * @param idQuadro
     * @param idAtividade
     * @return (retorna a view que exporta o excel com os dados retornados pela API)
     */
    public function geraExcelFichaReconhecimentoPendencias($status, $idQuadro, $idAtividade){
        try{

            if ($status === 'naoconsta' || $status === 'consta') {

                $policiais = $this->QuadroAcessoService->listaPoliciaisPendenciasNaFichaReconhecimento($status, $idQuadro);
                
                if ($status === 'consta') {
                    $pendencias = false;
                    $nomeArquivo = 'Policiais_sem_pendencias_no_QA.xls';
                } elseif ($status === 'naoconsta') {
                    $pendencias = true;
                    $nomeArquivo = 'Policiais_com_pendencias_no_QA.xls';
                }
                
            } else {
                throw new Exception('Parâmetro de pendêcia inválido!');
            }
            
            return view('promocao::excel/listaEfetivoPendencias', compact('policiais','pendencias', 'nomeArquivo'));
            
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Método que gera o excel com a lista dos policiais que não enviaram a ficha de reconhecimento
     * @param idQuadro
     * @return (retorna a view que exporta o excel com os dados retornados pela API)
     */
    public function geraExcelFichaReconhecimentoAusentes($idQuadro){
        try{

            $policiais = $this->QuadroAcessoService->listaPoliciaisAusentesFichaReconhecimento($idQuadro);

            if ( is_array($policiais) ) {
                return view('promocao::excel/listaEfetivoAusentes', compact('policiais'));
            } else {
                return redirect()->back()->with('sucessoMsg', $policiais);
            }
            
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que um policial por CPF ou Matrícula
     * @return (retorna um json com os dados do policial, dependendo da resposta da API)
     */
    public function buscarPolicialPorCpfOuMatricula($cpfOuMatricula){
        try{
            $this->authorize('Lista_QA_aberto');

            $policial = $this->PolicialService->buscaPolicialCpf($cpfOuMatricula);

            return response()->json($policial);            
            
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que inseri um policial no QA
     * @return (retorna sucesso ou erro)
     */
    public function inserirPolicialNoQA($idQuadro, $idPolicial){
        try{
            $this->authorize('Lista_QA_aberto');
            
            $response = $this->QuadroAcessoService->inserirPolicialNoQA($idQuadro, $idPolicial);
            
            return response()->json($response);            
            
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Método que retorna para edição uma ficha escriturada assinada 
     * @return (retorna sucesso ou erro)
     */
    public function retornarFichaEscrituradaParaEdicao($idQuadro, $idAtividade, $idPolicial, $competencia){
        try{
            $this->authorize('Lista_QA_aberto');
           
            $msg = $this->QuadroAcessoService->retornarFichaEscrituradaParaEdicao($idQuadro, $idAtividade, $idPolicial);

            return redirect()->back()->with('sucessoMsg', $msg);            
            
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #451
     * Remove um Policial do QA 
     * @return (retorna sucesso ou erro)
     */
    public function removerPolicialDoQA($idPolicial, $idQuadro, $idAtividade, $competencia){
        try{
            $this->authorize('Lista_QA_aberto');
           
            $msg = $this->QuadroAcessoService->removerPolicialQuadro($idPolicial, $idQuadro);

            return redirect("promocao/fichasgtnaoenviada/$idQuadro/$idAtividade/competencia/$competencia")->with('sucessoMsg', $msg);

        }catch(\Exception $e){
            return redirect("promocao/fichasgtnaoenviada/$idQuadro/$idAtividade/competencia/$competencia")->with('erroMsg', $e->getMessage());
        }
    }


    public function reabrirHomologacaoFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $idPolicial, $competencia ) {
        try {
            
            $cpf = auth()->user()->st_cpf;

            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', MSG::SENHA_OBRIGATORIA); 
            }

            $credenciais = array('st_cpf' => $cpf, 'password' =>  $request['password']);

            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', MSG::SENHA_INVALIDA); 
            }
           
            $msg = $this->QuadroAcessoService->reabrirHomologacaoFichaReconhecimento($idQuadro, $idPolicial);

            return redirect("promocao/homologadosfichareconhecimento/$idQuadro/$idAtividade/competencia/$competencia")->with('sucessoMsg', $msg);

        } catch (Exception $e) {
            return redirect('/home')->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Altera o status do Recurso  
     * @param idQuadro 
     * @param idAtividade
     * @param competencia
     * @param status ('liberar' ou 'bloquear')
     * @return (retorna sucesso ou erro)
     */
    public function alterarRecursoQA($idQuadro, $idAtividade, $competencia, $status) {
        try {
          
            $msg = $this->QuadroAcessoService->alteraStatusRecursoQA($idQuadro, $status);

            return redirect()->back()->with('sucessoMsg', $msg);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());        
        }
    }

    /**
     * @author juan_mojica - #485
     * Cadastra dependências na ficha de reconhecimento do policial
     * @param idQuadro 
     * @param idAtividade
     * @param competencia
     * @param status ('liberar' ou 'bloquear')
     * @return (retorna sucesso ou erro)
     */
    public function cadastrarDependenciasFichaReconhecimento(Request $request, $idQuadro, $idAtividade, $idPolicial) {
        try {
            
            $dadosForm = $request->except('_token');
            $idFicha = $request->input('ce_ficha');
            $msg = $this->QuadroAcessoService->cadastrarDependenciasFichaReconhecimento($idQuadro, $idPolicial, $dadosForm);

            return redirect("promocao/homologarfichareconhecimento/$idQuadro/$idAtividade/$idPolicial/competencia/CPP/ficha/".$idFicha)->with('sucessoMsg', $msg);

        } catch (Exception $e) {
            return redirect("promocao/homologarfichareconhecimento/$idQuadro/$idAtividade/$idPolicial/competencia/CPP/ficha/".$idFicha)->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Altera o status do Escriturar  
     * @param idQuadro 
     * @param idAtividade
     * @param competencia
     * @param status ('liberar' ou 'bloquear')
     * @return (retorna sucesso ou erro)
     */
    public function alterarEscriturarQA($idQuadro, $idAtividade, $competencia, $status) {
        try {
          
            $msg = $this->QuadroAcessoService->alteraStatusEscriturarQA($idQuadro, $status);

            return redirect()->back()->with('sucessoMsg', $msg);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());        
        }
    }

    /**
     * @author juan_mojica - #485
     * Altera o status do recorrer do policial  
     * @param idQuadro 
     * @param idAtividade
     * @param competencia
     * @return (retorna sucesso ou erro)
     */
    public function alterarStatusRecursoPolicial($idPolicial, $idQuadro, $idAtividade) {
        try {
           // dd('alterarStatusRecursoPolicial');
            //TODO - implementar o clone dos arquivos da ficha na próxima semana
            //recupera o qa
            $quadroAcesso = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            
            //recupera o pm do qa
            $policialDoQuadro = $this->QuadroAcessoService->fichaReconhecimento($idQuadro, $idPolicial);
            //dd($policialDoQuadro);
            //verifica se o pm está no qa
            if(empty($policialDoQuadro)){
                throw new Exception("Policial não encontrado no QA");
            }

            //percorre as fichas do pm
            foreach ($policialDoQuadro->fichas as $key => $ficha) {
                if($ficha->st_ficha =='DEFINITIVA'){
                    $idFicha = $ficha->id;
                }
            }
            $anoDoQa =  date('Y', strtotime($quadroAcesso->dt_promocao));

            //informa que o pm recorreu e clona os anexos no banco da ficha
            $fichaClonada = $this->QuadroAcessoService->alterarStatusRecursoPolicial($idPolicial, $idQuadro);
            //dd($fichaClonada);


            if($idQuadro == 3){
                //regra exclusiva para o qa de abril de 2023 ser compatível com a nova regra 
                $caminho_armazenamento_origem = "PROMOCAO/2022/1/".str_replace(" ", "", $policialDoQuadro->st_cpf);
            }else{
                $caminho_armazenamento_origem = "PROMOCAO/".$anoDoQa."/".$quadroAcesso->ce_qaanterior."/".str_replace(" ", "", $policialDoQuadro->st_cpf)."/".$idFicha."/";
            }
            //define o caminho de destino
            $caminho_armazenamento_destino = 'PROMOCAO/'.$anoDoQa."/".$idQuadro."/".str_replace(" ", "", $policialDoQuadro->st_cpf)."/".$fichaClonada->id;
            //dd($caminho_armazenamento_destino);

            //clona os arquivo no ftp
            $this->clonarAnexosDaFichaReconhecimento($policialDoQuadro, $caminho_armazenamento_origem,$caminho_armazenamento_destino);

            return redirect( url("promocao/homologadosfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP") )->with('sucessoMsg', "Recurso liberado");

        } catch (Exception $e) {
            return redirect( url("promocao/homologadosfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP") )->with('erroMsg',  $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #525
     * Altera o status da análise do recurso da ficha do policial  
     * @param idQuadro 
     * @param idAtividade
     * @param competencia
     * @return (retorna sucesso ou erro)
     */
    public function alterarStatusAnaliseRecursoPolicial($idPolicial, $idQuadro, $idAtividade) {
        try {
            
            $msg = $this->QuadroAcessoService->alterarStatusAnaliseRecursoPolicial($idPolicial, $idQuadro);
            
            return redirect( url("promocao/recursosanalisadosfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP") )->with('sucessoMsg', $msg);

        } catch (Exception $e) {
            return redirect( url("promocao/recursosanalisadosfichareconhecimento/$idQuadro/$idAtividade/competencia/CPP") )->with('erroMsg',  $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #485
     * Altera o status do recorrer do policial  
     * @param idQuadro 
     * @return (lista de policiais que recorreram no QA)
     */
    public function exportaPoliciaisRecorreram($idQuadro) {
        try {
            
            $policiais = $this->QuadroAcessoService->listaPoliciaisRecorreramQA($idQuadro);

            if (empty($policiais)) {
                throw new Exception('Nenhum recurso realizado!');
            }
           
            return view('promocao::excel/listaEfetivoRecorreu', compact('policiais'));

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());        
        }
    }

    /**
     * @author juan_mojica - #485
     * Lista histórico de alterações do policial no QA  
     * @param $idQuadro 
     * @param $idPolicial 
     * @return (lista de alterações do policial no QA)
     */
    public function listaHistoricoPolicialQA($idQuadro, $idPolicial) {
        try {
            
            $historicos = $this->QuadroAcessoService->listaHistoricoPolicialQA($idQuadro, $idPolicial);
           
            return response()->json($historicos); 

        } catch (Exception $e) {
            return response()->json($e->getMessage());        
        }
    }


    /**
     * @author Jazon - #485
     * Adiciona policiais em lote ao QA  
     * @param $idQuadro 
     * @param $lista de matrículas 
     * @return (sucess or list of errors)
     */
    public function addPoliciaisAoQaEmLoteExcel(Request $request) {
        try{
            //captura idQuadro
            $idQuadro = $request->idQuadro;
            $arquivoCsv = $request->file('arquivo');
            // $extensaoOriginal = $arquivoCsv->getClientOriginalExtension();

            // if (!in_array($extensaoOriginal, ['xls', 'xlsx']))
            //     throw new Exception('O arquivo que você está tentando enviar deve estar em formato xls ou xlsx!');

            $nomeOriginalDoArquivo = $arquivoCsv->getClientOriginalName();
            
            if (!in_array($nomeOriginalDoArquivo, [
                'relacao_efetivo_do_qa.xls',
                'relacao_efetivo_do_qa.xlsx'
                ])
            ) throw new Exception('O nome do arquivo que você deve fazer o upload deve ser igual a (relacao_efetivo_do_qa.xls) ou (relacao_efetivo_do_qa.xlsx).');

            $paginasDoDocumento = Excel::toArray(new ExcelImport, $arquivoCsv);
            
            $listaMatriculas = [];
            if ($paginasDoDocumento[0][0][0] != 'MATRICULA')
                throw new Exception('A 1ª linha e 1ª coluna do arquivo deve ser MATRICULA');

            // remove a 1ª linha da 1ª página do excel enviado
            unset($paginasDoDocumento[0][0]);

            foreach ($paginasDoDocumento as $pagina) {
                foreach ($pagina as $linha) {
                    // recupera a 1ª coluna
                    $matricula = str_replace(['.', '-', ','], '', $linha[0]);
                    $listaMatriculas[] = $matricula;
                }
            }

            $mensagemRetorno = $this
                ->QuadroAcessoService
                ->addPoliciaisAoQaEmLoteExcel($idQuadro,$listaMatriculas);

            return redirect()
                ->back()
                ->with('sucessoMsg', $mensagemRetorno);
        } catch (Exception $e) {
            //o retorno é um json
            return redirect()
                ->back()
                ->with('erroMsg',$e->getmessage());
        }
    }
    
    /**
     * @author juan_mojica - #485
     * Lista histórico de alterações do policial no QA  
     * @param $idQuadro 
     * @param $idPolicial 
     * @return (dashboard do QA)
     */
    public function exibeDashboardQA($idQuadro, $idAtividade) {
        try {
            $this->authorize('GERENCIAR_QA');
            
            $dadosDash = $this->QuadroAcessoService->listadashboardQA($idQuadro);
            $tituloDash = 'das fichas de reconhecimento no Quadro de Acesso';
           
            return view('promocao::dashboard\dashboardQA', compact('dadosDash', 'tituloDash')); 

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());        
        }
    }

    /**
     * @author juan mojica - #485
     * Importa efetivo inspecionado pela JPMS ou TAF em formato excel
     * @return (sucesso ou lista de erros)
     */
    public function importarPoliciaisInspecionadosJpmsTafExcel(Request $request) {
        try{ 
            $this->authorize('IMPORTAR_EFETIVO_INSPECAO_JPMS_TAF_QA');

            $idQuadro = $request->idQuadro;
            $tipoInspecao = $request->tipoInspecao;

            //prepara upload
            $uploaddir = 'planilhas/';//public/planilhas
            $uploadfile = $uploaddir . basename($_FILES['arquivo']['name']);
            $tipodearquivo = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));

            //verifica se o arquivo é excel
            if ($tipodearquivo == 'xls') {
                
                //verifica o nome do arquivo
                if (basename($_FILES['arquivo']['name']) == 'efetivo_inspecionado_do_qa.xls') {
                    
                    //verifica se fez o upload
                    if (move_uploaded_file($_FILES["arquivo"]["tmp_name"],$uploadfile )) {

                        //captura os dados do excel
                        $tmpfname = "planilhas/efetivo_inspecionado_do_qa.xls";//foi la na public/planilhas
                        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
                        $excelObj = $excelReader->load($tmpfname);
                        $worksheet = $excelObj->getActiveSheet();
                        $lastRow = $worksheet->getHighestRow();
                        $lastCol = $worksheet->getHighestColumn();
                        
                        //começa da segunda linha pq pula o título
                        for ($row = 2; $row <= $lastRow; $row++) {

                            //captura linhas da coluna A
                            $matricula = trim($worksheet->getCell('A'.$row)->getValue());
                            $dataInspecao = trim($worksheet->getCell('B'.$row)->getValue());
                            $parecerInspecao = trim($worksheet->getCell('C'.$row)->getValue());
                            $dataValidadeInspecao = trim($worksheet->getCell('D'.$row)->getValue());


                            //remove a mascara da matrícula
                            $matricula = str_replace(".","",$matricula);
                            $matricula = str_replace("-","",$matricula);
                            $matricula = str_replace(",","",$matricula);

                            $dtInspecao = new DateTime($dataInspecao);
                            $dtInspecaoFormatada = $dtInspecao->format('Y-d-m');

                            $dtValidadeInspecao = new DateTime($dataValidadeInspecao);
                            $dtValidadeInspecaoFormatada = $dtValidadeInspecao->format('Y-d-m');

                            //se não for vazio adiciona a matrícula na listagem
                            if(!empty(trim($matricula))){
                                $listaEfetivo[$matricula] = [
                                    'dt_inspecao' => $dtInspecaoFormatada,
                                    'st_parecerinspecao' => $parecerInspecao,
                                    'dt_validadeinspecao' => $dtValidadeInspecaoFormatada,
                                ];
                            } else {
                                break;
                            }
                        }
                        //dd($listaEfetivo);
                        //cria um array com idQuadro e o listaMatriculas e manda para o service
                        $dadosForm =  $listaEfetivo;
                       
                        $msg = $this->QuadroAcessoService->importarPoliciaisInspecionadosJpmsTafExcel($idQuadro, $tipoInspecao, $dadosForm);
                        
                        //apaga a planilha do servidor
                        if (file_exists("planilhas/".basename($_FILES['arquivo']['name']))) {
                            unlink("planilhas/".basename($_FILES['arquivo']['name']));
                        }   
                        return redirect()->back()->with('sucessoMsg',$msg);                         
                    } else {
                        return redirect()->back()->with('erroMsg','Upload não foi concluído. Tente novamente!');
                    }                        
                } else {
                    return redirect()->back()->with('erroMsg','O nome do arquivo que você deve fazer o upload deve ser igual a: (efetivo_inspecionado_do_qa.xls).');
                }
            } else {
                return redirect()->back()->with('erroMsg','O arquivo que você está tentando enviar não é um Excel xls!');
            }
        } catch (Exception $e) {
            //o retorno é um json
            return redirect()->back()->with('erroMsg',$e->getmessage());
        }
    }

    /**
     * @author Juan - #511
     * Edita dados do policial no QA  
     * @param $dadosForm
     * @param $idPolicial 
     * @param $idQuadro 
     * @return (sucesso ou erro)
     */
    public function editaPolicialNoQA(Request $request, $idPolicial, $idQuadro, $statusFicha) {
        try {
            
            $this->authorize('HOMOLOGAR_FICHA_RECONHECIMENTO'); 

            $dadosForm = $request->except('_token');

            $dadosForm['st_matricula'] = Funcoes::limpaCPF_CNPJ($dadosForm['st_matricula']);

            $dadosForm['st_numpraca'] = Funcoes::limpaCPF_CNPJ($dadosForm['st_numpraca']);

            $validator = validator(
                $dadosForm, 
                [
                    'st_policial' => 'required',
                    'st_matricula' => 'required',
                    'ce_graduacao' => 'required',
                    'ce_qpmp' => 'required',
                    'st_numpraca' => 'required',
                    'dt_nascimento' => 'required',
                    'ce_unidade' => 'required',
                ]
            ); 
            
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', 'Preencha todos os campos da tela "Atualizar dados do Policial do QA", para atualizar os dados do Policial.'); 
            }

            $msg = $this->QuadroAcessoService->editaPolicialNoQA($dadosForm, $idPolicial, $idQuadro);

            if ( $statusFicha == 'enviada' ) {

                return redirect( url("promocao/fichasgtenviada/$idQuadro/4/competencia/CPP") )->with('sucessoMsg', $msg);
               
            } elseif ( $statusFicha == 'nao_enviada' ) {
               
                return redirect( url("promocao/fichasgtnaoenviada/$idQuadro/4/competencia/CPP") )->with('sucessoMsg', $msg);

            } else {

                throw new Exception('Status da ficha inválido. Status válidos para a ficha: "enviada" ou "nao_enviada"');
            }

        } catch (Exception $e) {

            return redirect()->back()->with('erroMsg',$e->getmessage());
        }
    }
    

}