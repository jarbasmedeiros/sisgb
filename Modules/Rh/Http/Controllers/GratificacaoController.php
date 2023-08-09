<?php

namespace Modules\Rh\Http\Controllers;

use App\Http\Controllers\Controller;

use Modules\Rh\Entities\Gratificacao;
use Illuminate\Http\Request;
use DB;
use App\utis\MyLog;
use Auth;
use Carbon\Carbon;

/**
 * Controller da Gratificação (dbo.gratificacoes)
 */
class GratificacaoController extends Controller
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

    /**
     * Lista todas as gratificacoes ativas do sistema.
     * 
     * @param $tiporenderizacao (listagem, pdf ou excel)
     */
    public function index($tiporenderizacao)
    {
        $this->authorize('Gratificacao');
        /** Consultando a lista de gratificações ativas na tabela. */
        $gratificacoes = DB::table('gratificacoes')->where('gratificacoes.bo_ativo',  '1')->orderby('gratificacoes.st_gratificacao')->get();
       
        /** Consultando as gratificações cadastradas por funcionário, selecionando da tabela funcionários e relacionando com a tabela gratificacoes. */
        $qtdeGrat = DB::table('funcionarios as f')
            ->where('f.bo_ativo', 1)
            ->join('gratificacoes as g', 'g.id', 'f.ce_gratificacao')
            ->select('g.st_gratificacao', 'g.id', 'g.nu_vagas', 'g.vl_gratificacao', DB::raw('COUNT(f.id) AS qtde'))
            ->groupBy('g.id', 'g.st_gratificacao', 'g.nu_vagas', 'g.vl_gratificacao')
            ->orderBy('qtde', 'DESC')
            ->get();
        /** Adicionando a quantidade de gratificações cadastradas. */
        if(isset($gratificacoes) && count($gratificacoes) > 0){
            foreach($gratificacoes as $g){
                foreach($qtdeGrat as $qtd){
                    if($g->st_gratificacao == $qtd->st_gratificacao){
                        $g->listGrat = $qtdeGrat;
                        $listGrat[] = $g;
                    }
                }
            }
        }
        
        /** Escolhendo PDF como tipo de renderização, o retorno é diferente. */
        if($tiporenderizacao == 'pdf'){
            
            $acao = "Consulta";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' Gerou o pdf da lista de gratificações';
            /** Chamando a classe para registrar a alteração na tabela logs  */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        
            return \PDF::loadView('rh::pdf.Lista_gratificacoespdf', compact('listGrat', 'gratificacoes', 'qtdeGrat'))
                // Para deixar no formato a4 retrato: ->setPaper('a4', 'landscape')
                 ->stream('Lista_policial.pdf');

        }
        /** Renderização do tipo "listagem" */
        else{
            $acao = "Consulta";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' listou as gratificações';
            /** Chamando a classe para registrar a alteração na tabela logs  */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            
            return view('rh::gratificacao.Listagratificacao', compact('listGrat', 'gratificacoes', 'qtdeGrat')); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Gratificacao');
        
        return view('rh::gratificacao.Form_cad_gratificacao', compact('listGrat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Gratificacao');
        /** Iniciando a transação no banco de dados. */
        DB:: beginTransaction();
        /** Recebendo os dados do formulário */
        $dadosForm = $request->all();
        /** Instancionando uma nova gratificação. */
        $gratificacao = new Gratificacao;
        /** Tratando o Input do valor */ 
        $find = array('.', ',');
        $replace   = array(',', '.');
        /** Injetando o valor da gratificação no formulário. */
        $dadosForm['vl_gratificacao'] = str_replace($find, $replace, $dadosForm['vl_gratificacao']);
        /** Injetando o valor do bo_ativo no formulário. */
        $dadosForm['bo_ativo'] = 1;
        /** Injetando a data de cadastro no formulário. */ 
        $dadosForm['dt_cadastro'] = Carbon::now()->format('Y-d-m H:m:s');
        /** Validando os dados */ 
        $validator = validator($dadosForm, $gratificacao->rules);
        
        /** Se a validação falhar, mensagens de erro serão exibidas. */
        if($validator->fails()){
            return redirect()->back()
            /** Mensagem de Erro */          
                ->withErrors($validator)
            /** Preenchendo o Formulário */          
                ->withInput();
        }
        /**  Inserindo a gratificação */
        $insert = Gratificacao::create($dadosForm) ;
       
        /** Tentando inserir a gratificação no banco */
        if($insert){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Cadastro";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' cadastrou nova gratificação';
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
            /** Redirecionando para o index de gratificações. */
            return redirect('/rh/gratificacoes/listagem');
        }
        /**
         * Caso o insert falhe, faz rollback e redireciona para mensagem de erro.
         */
        else{
            DB::rollback();
            return redirect()->back()->with('erroMsg', 'Falha ao Cadastrar a gratificação');  
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gratificacao  $gratificacao
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Gratificacao');
        /** Consultado na tabela o elemento requerido pelo usuário. */
        $gratificacao = Gratificacao::find($id);
        return view('rh::gratificacao.Form_edita_gratificacao', compact('gratificacao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gratificacao  $gratificacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('Gratificacao');
        /** Iniciando a transação no banco de dados. */
        DB::beginTransaction();
        $dadosForm = $request->all();
        /** Tratando o Input do valor */
        $find = array('.', ',');
        $replace   = array(',', '.');
        /** Injetando o valor da gratificação no formulário. */
        $dadosForm['vl_gratificacao'] = str_replace($find, $replace, $dadosForm['vl_gratificacao']);
        /** Instanciando a gratificação com o id da gratificação requerida pelo usuário. */
        $gratificacao = Gratificacao::find($id);
        /** Validando os dados */
        $validator = validator($dadosForm, [
            'st_gratificacao' => 'max:50|required|unique:gratificacoes,st_gratificacao,'.$id,
            'vl_gratificacao' => 'required',
            'nu_vagas' => 'required|integer'
        ]);
        /**
         * Se a validação falhar, mensagens de erro serão exibidas.
         */
        if($validator->fails()){
            return redirect()->back()
            /** Mensagem de Erro */          
                ->withErrors($validator)
            /** Preenchendo o Formulário */
                ->withInput();
        }
        /** Editando a gratificação de acordo com os dados do formulário */
        $gratificacaoeditado = $gratificacao->update($dadosForm);

        /** Editando a gratificação */
        if($gratificacaoeditado){
            DB::commit();
            /** Cadastra a ação na tabela log no banco. */
            $acao = "Edição";
            $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' editou a gratificação de id = ' . $gratificacao->id;
            /* Chamando a classe para registra a alteração na tabela logs. */
            MyLog::info(compact('antes', 'depois', 'msg', 'acao'));

             /** Redirecionando para a listagem de gratificações. */
            return redirect('/rh/gratificacoes/listagem');
        }
        /** Caso a edição falhe, faz rollback e redireciona para mensagem de erro. */
        else{
            DB::rollback();
            return redirect()->back()->with('erroMsg', 'Falha ao Alterar a gratificação');  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gratificacao  $gratificacao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** Busca na tabela a gratificação a ser excluído */
        $gratificacao = Gratificacao::find($id);
        /** Desativa ("deleta") o a gratificação setando o bo_ativo para 0 */
        $gratificacaoalterado = $gratificacao->update([
            'bo_ativo' => 0
        ]);
        /** Cadastra a ação na tabela log no banco. */
        $acao = "Delete";
        $msg = 'O Usuário: ' . Auth::user()->st_cpf . ' deletou a gratificação de id = ' . $gratificacao->id;
        /* Chamando a classe para registra a alteração na tabela logs. */
        MyLog::info(compact('antes', 'depois', 'msg', 'acao'));
        
        /** Redireciona para a listagem de cargos. */
        return redirect('/rh/gratificacoes/listagem');
    }
}
