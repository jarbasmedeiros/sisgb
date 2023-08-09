<?php

namespace Modules\Promocao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use Modules\Api\Services\BoletimService;
use Modules\Api\Services\NotaService;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\Policiaisdasnota;
use Modules\Api\Services\QuadroAcessoService;
use Modules\Api\Services\QpmpService;
use App\Ldap\Authldap;
use App\Utis\Msg;
use Illuminate\Support\Facades\Auth;
use Exception;
Use stdClass;
class PromocaoController extends Controller{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function __construct(BoletimService $BoletimService, PolicialService $PolicialService, NotaService $NotaService, QuadroAcessoService $QuadroAcessoService, QpmpService $QpmpService, Authldap $Authldap){
        $this->middleware('auth');
        $this->BoletimService = $BoletimService;
        $this->PolicialService = $PolicialService;
        $this->NotaService = $NotaService;
        $this->QuadroAcessoService = $QuadroAcessoService;
        $this->QpmpService = $QpmpService;
        $this->Authldap = $Authldap;
    }
    public function index()
    {
        return view('promocao::index');
    }

    /**
     * Método que chama a tela para inspeção de saúde para promoção
     */
    public function inspecaoParaPromocaoJpms($idQuadro, $idAtividade, $competencia){
        try{
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);           
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisParaInspecaoJPMS($idQuadro);
            $totalParaInspecionar = (empty($policiaisQuadro)) ? '0' : $policiaisQuadro->total();
            $titulopainel = 'Policiais para Inspeção referente à promoção de ';
            return view('promocao::inspecaoSaude/listaPoliciaisJPMS', compact('quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'idQuadro', 'totalParaInspecionar', 'competencia'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    

   
    /**
     * Método para concluir inspeção de saúde para promoção
     */
    public function concluirInspecaojpms(Request $request, $idQuadro, $idAtividade)
    {
        try{
            if(!isset($request['password'])){
                return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA); 
            }
            $ldap = $this->Authldap->autenticar($request['password']);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
            }

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            if(!empty($atividade->dt_atividade)){
                return redirect()->back()->with('erroMsg', Msg::ATIVIDADE_CONCLUIDA);
            }
            $concluirAtividade = $this->QuadroAcessoService->concluirAtividadeInspecaoJpms($idAtividade);
            return redirect('promocao/quadro/cronograma/'.$idQuadro)->with('sucessoMsg', $concluirAtividade);
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /**
     * Método para divulgar resultado de inspeção de saúde para promoção
     */
    public function resultadoDaInspecaoDeSaude($idQuadro, $idAtividade)
    {
        try{
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $titulopainel = 'Resultado da inspeção de Saúde para promoção de ';
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisInspecionadosJPMS($idQuadro);
            if($policiaisQuadro){
                return view('promocao::divulgarResultadoInspecaoSaude',compact('atividade', 'quadro', 'titulopainel', 'policiaisQuadro'));
            }else{
                return redirect()->back()->with('erroMsg', 'Erro Inesperado!!!.');
            }
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*
     * Método Lista dos os policiais de um quadro de acesso que ja foram inspecionados pela JPMS
     */
    public function policiaisInspecionadosJpms($idQuadro, $idAtividade, $competencia){
        try{
            $titulopainel = 'Policiais inspecionados para promoção de ';
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisInspecionadosJPMS($idQuadro);
            $policiaisParaInspecionar = $this->QuadroAcessoService->listaPoliciaisParaInspecaoJPMS($idQuadro);
            $totalParaInspecionar = (empty($policiaisParaInspecionar)) ? '0' : $policiaisParaInspecionar->total();
            return view('promocao::inspecaoSaude/listaPoliciaisJPMS', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'totalParaInspecionar', 'competencia'));
        } catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*
    * Método que chama a tela de lista de efetivo para TAF
    */
    public function realizarTaf($idQuadro, $idAtividade, $competencia){
        try{
            $titulopainel = 'Policiais inspecionados para promoção de ';
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisParaRealizarTaf($idQuadro);
            $tafInspecionados = "naoInspecionados";
            return view('promocao::quadroDeAcesso/inspecaoTaf', compact('quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'tafInspecionados', 'competencia'));
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*
    * Método que chama a tela de lista de efetivo para TAF de Policiais Inspecionados
    */
    public function realizarTafPoliciaisInspecionados($idQuadro, $idAtividade, $competencia){
        try{
            $titulopainel = 'Policiais inspecionados para promoção de ';
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadroParaInspecionar = $this->QuadroAcessoService->listaPoliciaisParaRealizarTaf($idQuadro);
            $policiaisQuadro = $this->QuadroAcessoService->listaPoliciaisInspecionadosTaf($idQuadro);
            $tafInspecionados = "inspecionados";
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
        return view('promocao::quadroDeAcesso/inspecaoTaf', compact('quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'policiaisQuadroParaInspecionar', 'tafInspecionados', 'competencia'));
    }
    /*
    * Método que realiza o TAF do policial salvando no banco os dados Data TAF, Inapto ou Apto e obs do TAF
    */
    public function realizarTafPolicial(Request $request, $idQuadro, $idAtividade, $idPolicial, $competencia){
        try{
            $dadosForm = $request->all();
            $dadosForm['bo_inspecionadotaf'] = 1;
            //Validando os dados
            $validator = validator($dadosForm, [
                'st_inspecaotafparecer' => 'required',
                'dt_taf' => 'date|required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $policialInspecionado = $this->QuadroAcessoService->inspecaoTafParecer($idQuadro, $idPolicial, $dadosForm);
            return redirect('promocao/realizartaf/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)->with('sucessoMsg', $policialInspecionado);
        }catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*
    * Método para busca de policiais para realizar TAF.
    */
    public function findPmTaf(Request $request, $tafInspecionados, $idQuadro, $idAtividade, $competencia){
        try{
            $dadosForm = $request->all();
            // Caso o token existe ele é removido
            if(isset($dadosForm['_token'])){
                unset($dadosForm['_token']);
            }
            //Validando os dados
            $validator = validator($dadosForm, [
                'criterio' => 'required',
                'filtro' => 'required',
            ]);
            if($validator->fails()){
                //Mensagem de erro com o formulário preenchido
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }
            
            $policiaisQuadro = $this->QuadroAcessoService->findPmTaf($idQuadro, $dadosForm, $tafInspecionados);

            $titulopainel = 'Policiais inspecionados para promoção de ';
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $policiaisQuadroParaInspecionar = $this->QuadroAcessoService->listaPoliciaisParaRealizarTaf($idQuadro);

            return view('promocao::quadroDeAcesso/inspecaoTaf', compact('quadro', 'policiaisQuadro', 'atividade', 'titulopainel', 'policiaisQuadroParaInspecionar', 'tafInspecionados', 'competencia'));
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*
    * Método para concluir realização de TAF.
    */
    public function concluirTaf(Request $request, $idQuadro, $idAtividade){
        try{
            $cpf = Auth::user()->st_cpf;

            $senhaUsuario = $request->all();
            if(!isset($senhaUsuario['password'])){
                return redirect()->back()->with('erroMsg', Msg::SENHA_OBRIGATORIA);
            }
            $credenciais = array('st_cpf' => $cpf, 'password' => $request['password']);
            //Validando credencais
            $ldap = $this->Authldap->autentica($credenciais);
            if($ldap == false){
                return redirect()->back()->with('erroMsg', Msg::SENHA_INVALIDA); 
            }

            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);

            if(empty($atividade)){
                return redirect()->back()->with('erroMsg', Msg::ATIVIDADE_NAO_ENCONTRADA);
            }
            if(!empty($atividade->dt_atividade)){
                return redirect()->back()->with('erroMsg', Msg::ATIVIDADE_CONCLUIDA);
            }

            $concluirAtividade = $this->QuadroAcessoService->concluirAtividadeTaf($idAtividade);

            return redirect('promocao/quadro/cronograma/'.$idQuadro)->with('sucessoMsg', $concluirAtividade);
            
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    /*
     * Método que chama a tela para inspeção de saúde para promoção
     */
    public function buscaPolicialParaInspecaoDeSaude(Request $request, $idQuadro, $idAtividade, $competencia){
        try{
            $parametroDeBusca = $request->input('st_parametro');
            $filtro = $request->input('st_filtro');
            $policiaisQuadro = $this->QuadroAcessoService->buscaPolicialDoQuadroPorNomeCpfMatricula($idQuadro, $parametroDeBusca, $filtro);
            $quadro = $this->QuadroAcessoService->getQuadroAcessoId($idQuadro);
            $atividade = $this->QuadroAcessoService->getAtividadeId($idAtividade);
            $totalParaInspecionar = (empty($policiaisQuadro)) ? '0' : $policiaisQuadro->total();
            $titulopainel = 'Policiais inspecionados para promoção de ';

            return view('promocao::inspecaoSaude/listaPoliciaisJPMS', compact('idQuadro', 'quadro', 'policiaisQuadro', 'atividade','titulopainel', 'totalParaInspecionar','competencia'));
            
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
    
    /**
     * Método Percistir o Parecer da JPMS referente à Promoção
     */
    public function parecerJPMS(Request $request, $idPolicialNoQuadro, $idQuadro, $idAtividade){
       try{
            $dadosForm = $request->all();
            $validator = validator($dadosForm, [
                'st_inspecaojuntaparecer' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->with('erroMsg', Msg::CAMPOS_OBRIGATORIOS);
            }
            $dadosForm['bo_inspecionadojunta'] = 1;
            $parecer = $this->QuadroAcessoService->inspecaoJuntaParecer($idPolicialNoQuadro, $idQuadro, $dadosForm);
            return redirect()->back()->with('sucessoMsg', $parecer);
        } catch(\Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('promocao::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('promocao::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    
    public function addPolicialNaListaDoQudro($idQuadro)
    {
       dd('Deve Adicionar o policial ao quadro');
      // falta criar o serviço para policiais do quardo
        return view('promocao::nota_template', compact('idQuadro'));
    }
}
