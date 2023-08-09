<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Utis\Msg;
use Exception;
use Illuminate\Http\Request;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\SugestoesService;
use Symfony\Component\VarDumper\Caster\RedisCaster;


/** @author: juan_mojica - #392
 */
class SugestoesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SugestoesService $sugestoesService, PolicialService $policialService){
       $this->sugestoesService = $sugestoesService;
       $this->policialService = $policialService;
    }

    /**
     * @author juan_mojica - #392
     */
    public function index(){
        try {
            //Invoca o serviço para retornar as sugestões
            $sugestoes = $this->sugestoesService->getSugestoes();

            return view('admin::sugestoes.sugestoes', compact('sugestoes'));

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #392
     */
    public function store(Request $request){
        try {
            $dadosForm = $request->all();
            //validação dos dados do form
            $validator = validator($dadosForm, [
                'st_sugestao' => 'required',
            ]);
            //verifica se a validação foi violada
            if($validator->fails()){
                return redirect()->route('sugestoes')->with('erroMsg', 'O campo Sugestão é Obrigatório no cadastro!');
            }
            //adiciona ao array o "id" do usuário
            $dadosForm['ce_pessoa'] = auth()->user()->id;

            //invoca o serviço para cadastrar uma sugestão
            $msg = $this->sugestoesService->cadastraSugestao($dadosForm);

            return redirect()->route('sugestoes')->with('sucessoMsg', $msg);

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    /**
     * @author juan_mojica - #392
     */
    public function storeVoto($idSugestao, $voto){
        try {
            //popula o array a ser enviado ao serviço
            //O voto é "l" para like e "d" para dislike
            $dados['st_voto'] = $voto;
            $dados['ce_pessoa'] = auth()->user()->id;
            
            //invoca o serviço para cadastrar uma sugestão
            $msg = $this->sugestoesService->cadastraVotoSugestao($idSugestao, $dados);

            return redirect()->route('sugestoes')->with('sucessoMsg', $msg);
            
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

}
