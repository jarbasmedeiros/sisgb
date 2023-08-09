<?php

namespace Modules\Rh\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\utis\Msg;
use Modules\rh\Entities\Funcionario;
use Modules\rh\Entities\Policial;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use Modules\Api\Services\RelatorioService;
use Exception;
use Auth;
use App\utis\MyLog;
use Modules\Rh\Entities\StatusFuncao;
use DB;



class RelatorioController extends Controller
{
    public function __construct(RelatorioService $relatorioService){
        $this->middleware('auth');
        $this->relatorioService = $relatorioService;
       
    }

    public function index()
    {
        try{
             $this->authorize('Relatorios_rh'); 
            $dados = $this->relatorioService->getInformacoesParaFomularioRelatorioDinamico("1") ;
            /* $nome_col = Policial::renameColumns($col); */
            $dados->colunas = get_object_vars($dados->colunas);
            if(isset($dados->colunas['ce_unidade'])){
                unset($dados->colunas['ce_unidade']);
                $dados->colunas['st_unidade'] = 'UNIDADE';

            }
            return view('rh::relatorio.index', compact('dados'));

        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
            
    }
    
    public function filtro(Request $request)
    {
        $this->authorize('Relatorios_rh'); 
        try{
           
            $dadosFom = $request->all();
            $dados = $this->relatorioService->filtro($dadosFom,"1");
            $funcionarios = $dados->policiais;
            $nome_colunas = $dados->nome_colunas;
            $response = $dados->response;
            $colunas = $dados->colunas;
            $nome_tabela = 'Relatório de policiais';
            // Se for clicando em excel, entao gera o arquivo
            if($request['excel']){
                return view('rh::relatorio.listagem_excel', compact('funcionarios', 'nome_colunas', 'colunas'));
            }
            // Se não, então mostra a view
            return view('rh::relatorio.listagem', compact('funcionarios', 'nome_colunas', 'nome_tabela', 'response', 'colunas'));



                        
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
      
        
    }

    
    

    
}
