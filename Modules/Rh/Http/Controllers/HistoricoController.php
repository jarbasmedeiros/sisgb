<?php
namespace Modules\Rh\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Auth;
use Modules\Rh\Entities\Historico;
use App\utis\MyLog;
use Modules\Rh\Entities\Funcionario;

class HistoricoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lista_historico($id){
        $this->authorize('Edita');
        //Selecionando o funcionario
        $servidor = Funcionario::where('id', $id)->first();
        //Selecionando o histórico do servidor
        $historicos = DB::table('historicos')
                        ->where('historicos.ce_funcionario', $id)
                        ->get();
        dd($historicos);
        $acao = "Consulta";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' acessou o histórico do funcionário: ' . $id;
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        return view('rh::funcionario.Lista_historico', compact('historicos', 'servidor'));
    }
}
