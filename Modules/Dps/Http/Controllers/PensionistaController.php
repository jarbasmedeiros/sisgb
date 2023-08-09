<?php

namespace Modules\Dps\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Modules\Api\Services\DpsService;
use App\utis\Msg;
use App\utis\Funcoes;
use Auth;
use Exception;

class PensionistaController extends Controller {
    public function __construct(DpsService $DpsService){
        $this->middleware('auth');
        $this->dpsService = $DpsService;
    }

    /** 
     * # 462-criar-prontuario-de-pensionista
     *   @author Jherod Brendon
     *   @return mixed tela para a pesquisa de pensionistas
     */

    public function telaPesquisarPensionista() {
        return view('dps::prontuario.pesquisar_pensionista');
    }

    /** 
     * # 462-criar-prontuario-de-pensionista
     *   @author Jherod Brendon
     *   @param Request $request requisição com o parâmetro
     *   @return mixed tela para a pesquisa de pensionistas com os dados de um pensionista
     */

    public function pesquisarPensionista(Request $request) {
        try {
            $dadosForm = Funcoes::addSlashesRecursivo($request->all());
            $response = $this->dpsService->pesquisarPensionista($dadosForm);
            //dd($response);
            if (empty($response))
                throw new Exception('Erro no serviço de pesquisa do pensionista!');
            return view('
                dps::prontuario.pesquisar_pensionista',
                ['pensionistas' => $response]
            );
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }
}