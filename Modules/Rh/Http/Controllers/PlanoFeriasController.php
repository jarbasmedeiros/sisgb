<?php

namespace Modules\Rh\Http\Controllers;

use App\Http\Controllers\Controller;
use App\utis\Msg;
use App\utis\Funcoes;
use Illuminate\Http\Request;
use Exception;
use Auth;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\FeriasService;
use Modules\Api\Services\PlanoFeriasService;
use Modules\Api\Services\UnidadeService;
use Response;
use Illuminate\Support\Facades\Validator;
use PHPExcel_IOFactory;


class PlanoFeriasController extends Controller {

    public function __construct(PlanoFeriasService $PlanoFeriasService){
        $this->middleware('auth');
        $this->PlanoFeriasService = $PlanoFeriasService;
    }
    /* 
    Autor: @carlosalberto. 
    Função ira retornar plano de férias com ano e turma do policial.
    */
    public function index()
    {
        try {
            $listas = $this->PlanoFeriasService->listaPlanosFerias();
          //  dd($listas);
            return view('rh::planoferias.ListaDePlanoDeFerias',compact("listas"));
        } catch (\Throwable $th) {
            return redirect('rh/planoferias')->with('erroMsg', $th->getMessage());
        }
    }

    
    public function criarPlano()
    {
        try{
            $this->authorize('PLANO_FERIAS');
            $numeroDeTurmasMinimo = 11;
           // $numeroDeTurmasMinimo =  $this->PlanoFeriasService->getNumTurmaPlanoFerias();
            return view('rh::planoferias.CriarPlandoDeFerias',compact("numeroDeTurmasMinimo"));
        } catch (\Throwable $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    public function enviarPlano(Request $request)
    {
        try {
            $this->authorize('PLANO_FERIAS');
            $dadosForm = $request->all();
          //  dd($dadosForm);
            $msg = $this->PlanoFeriasService->criaPlanosFerias($dadosForm);
            return redirect('rh/planoferias')->with('sucessoMsg', $msg);
        } catch (\Throwable $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }



    public function salvarPortaria($ano,$st_turma,Request $request){
        try {
            $this->authorize('PLANO_FERIAS');
            $dadosForm =   $this->removerTokenDoRequest($request->all());
           //  dd($dadosForm)       ;
            $validator = validator($dadosForm, [
                'st_portaria' => 'required'
            ]);
    
            if($validator->fails()){
                // Mensagem de erro com o formulário preenchido
                return redirect()->back()->withErrors($validator)->withInput();
            } 
            $msg = $this->PlanoFeriasService->salvarPortaria($ano,$dadosForm);

            return redirect('rh/planoferias/'.$ano.'/turma/'.$st_turma)->with('sucessoMsg', $msg);
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    /**
     * exibe o plano selecionado
     */
    public function listarPlano($ano,$st_turma)
    {
        try {
           
           $planoFerias = $this->PlanoFeriasService->findPlanoFeriasByAno($ano);
            $efetivo = [];
          //  if($turmas)
          $contagemEfetivo = $this->PlanoFeriasService->getContagemEfetivoFerias($ano);
            $efetivo = $this->PlanoFeriasService->getEfetivoTurmaSelecionada($ano, $st_turma);
            //echo $turmas[$st_turma]->id;
            //dd($efetivo);
           return view('rh::planoferias.ListaPorAnoPlanoDeFerias',compact("ano","efetivo","st_turma","contagemEfetivo",'planoFerias'));
        } catch (\Throwable $th) {
            return redirect('rh/planoferias')->with('erroMsg', $th->getMessage());
        }

        //dd($efetivo);

    }


    public function distribuirEfetivo($ano)
    {
       try {
           $this->authorize('PLANO_FERIAS');
           $turmas = $this->PlanoFeriasService->listaTurmasPlanosFerias($ano);
           return view('rh::planoferias.DistribuirEfetivoPlanoDeFerias', compact("ano","turmas"));
       } catch (\Throwable $th) {
            return redirect()->back()->with('erroMsg', $th->getMessage());  
       }
    }

    /**
     * 503-importar-efetivo-para-plano-de-ferias
     * modificado por cb Araújo
     * 13/10/2022
     */
    public function enviarEfetivo(Request $request,$ano)
    {
        try {
           $this->authorize('PLANO_FERIAS');
            $dadosForm = $request->all();
            if(!empty($dadosForm['arquivo'])){

                //prepara upload
                $uploaddir = 'planilhas/';//public/planilhas
                $uploadfile = $uploaddir . basename($_FILES['arquivo']['name']);
                $tipodearquivo = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));
                
                //verifica se é excel
                if ($tipodearquivo == 'xlsx') {
                    if (basename($_FILES['arquivo']['name']) == 'planilha_generica_com_pm.xlsx') {
                        //verifica se fez o upload
                        if (move_uploaded_file($_FILES["arquivo"]["tmp_name"],$uploadfile )) {
                            //captura os dados do excel
                            $tmpfname = "planilhas/planilha_generica_com_pm.xlsx";//foi la na public/planilhas
                            $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
                            $excelObj = $excelReader->load($tmpfname);
                            $worksheet = $excelObj->getActiveSheet();
                            $lastRow = $worksheet->getHighestRow();
                            $lastCol = $worksheet->getHighestColumn();
                            //captura as matriculas
                            $st_policiais = "";
                            //começa da segunda linha pq pula o título
                            for ($row = 2; $row <= $lastRow; $row++) {
                                //captura linhas da coluna A
                                $matricula = trim($worksheet->getCell('A'.$row)->getValue());
                                $matricula = str_replace(".","",$matricula);
                                $matricula = str_replace("-","",$matricula);
                                $matricula = str_replace(",","",$matricula);
                                //$campo_personalizado = trim($worksheet->getCell('B'.$row)->getValue());
                                if(!empty(trim($matricula))){
                                    $st_policiais .= $matricula.',';
                                } else {
                                    break;
                                }
                            }
                            //retira virgula no final
                            $length = intval(strlen($st_policiais)-1);
                            $st_policiais = substr($st_policiais,0,$length);
                            //muda dadosform
                            $dadosForm["st_efetivo"] = $st_policiais;
                            //apaga planilha se ela existir
                            if (file_exists("planilhas/".basename($_FILES['arquivo']['name']))) {
                                unlink("planilhas/".basename($_FILES['arquivo']['name']));
                            }
                        } else {
                            return redirect()->back()->with('erroMsg','Upload não foi concluído. Tente novamente!');
                        }                        
                    } else {
                        return redirect()->back()->with('erroMsg','O nome do arquivo que você deve fazer o upload deve ser o mesmo que do arquivo você baixou (planilhapadrao.xlsx).');
                    }
                } else {
                    return redirect()->back()->with('erroMsg','O arquivo tem que ser em formato xlsx');
                }
            }
            //salva as matriculas no banco
            $msg = $this->PlanoFeriasService->distribuirEfetivoPlanosFerias($dadosForm,$ano);
            return redirect('rh/planoferias/'.$ano.'/turma/'.$dadosForm["st_turma"])->with('sucessoMsg', $msg);
        } catch (\Throwable $th) {
            return redirect()->back()->with('erroMsg', $th->getMessage());  
        }
    }

    public function trocarTurma($ano,$ce_policial)
    {
       try{
        $this->authorize('PLANO_FERIAS');
            $turmas = $this->PlanoFeriasService->listaTurmasPlanosFerias($ano);
            //dd($turmas);
            return view('rh::planoferias.TrocaTurmaPlanoDeFerias', compact("ano","ce_policial","turmas"));
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
    
    public function enviarTrocaTurma(Request $request,$ano)
    {
        try {
            $this->authorize('PLANO_FERIAS');
            $dadosForm = $request->all();
            //dd($dadosForm);
            $msg = $this->PlanoFeriasService->mudarTurmaEfetivo($dadosForm,$ano);
            //Aqui busca as turma para  descobrir o st_turma pelo id
            $turmas = $this->PlanoFeriasService->listaTurmasPlanosFerias($ano);
            //cria o st_turma para receber o valor final
            $st_turma = 0;
            //percorre todas as turmas do ano
            foreach ($turmas as $key => $turma) {
                //caso o id da turma que está sendo percorrido for igual ao que foi escolhido, pego o valor do st_turma
                if($turma->id == $dadosForm["ce_turmaferias"])$st_turma = $turma->st_turma;
            }
            //redireciona para a turma escolhida
            return redirect('rh/planoferias/'.$ano.'/turma/'.$st_turma)->with('sucessoMsg', $msg);
        } catch (\Throwable $th) {
            return redirect('rh/planoferias')->with('erroMsg', $th->getMessage());
        }
    }
    
        public function pesquisarTurmaFerias($ano,$st_turma,Request $request)
        {
           try{
                $this->authorize('Relatorios_rh');
               $dadosForm =   $this->removerTokenDoRequest($request->all());
               $validator = validator($dadosForm, [
                   'st_matricula' => 'required'
                ]);
                if($validator->fails()){
                    // Mensagem de erro com o formulário preenchido
                    return redirect()->back()->withErrors($validator)->withInput();
                } 
                $turmas = $this->PlanoFeriasService->listaTurmasPlanosFerias($ano);
                $efetivo = $this->PlanoFeriasService->pesquisarTurmaFerias($ano, $dadosForm);
                // dd($turmas);
                
                //consulta para recuperar os dados da portaria
                $planoFerias = $this->PlanoFeriasService->findPlanoFeriasByAno($ano);
                //                $efetivo = [];
                $contagemEfetivo = $this->PlanoFeriasService->getContagemEfetivoFerias($ano);
                // $efetivo = $this->PlanoFeriasService->getEfetivoTurmaSelecionada($ano, $st_turma);
                //echo $turmas[$st_turma]->id;
                //dd($efetivo);
                return view('rh::planoferias.ListaPorAnoPlanoDeFerias',compact('turmas',"ano","efetivo","st_turma","contagemEfetivo",'planoFerias'));
                
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }
        
        public function gerarNotaBgFerias($ano, $idPlanoFerias)
        {
            try{
                $this->authorize('PLANO_FERIAS');
                //monta o array com os dados necessário para gerar a nota
                $dadosForm = array( 'idUsuario'=>Auth::User()->id);
                //faz requisição a api
                $respostaApi = $this->PlanoFeriasService->gerarNotaBgFerias($ano, $dadosForm);
                 //redireciona para a listagem
                return redirect('rh/planoferias/')->with('sucessoMsg', $respostaApi);
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }

        public function exportarPlanoFeriasErgon($ano)
        {
            try{
                $this->authorize('PLANO_FERIAS');
              //  dd('chogou');
                //faz requisição a api
                $relacao = $this->PlanoFeriasService->exportarPlanoFeriasErgon($ano);
               // dd($respostaApi);
                 //redireciona para a listagem
                // return view('rh::planoferias.ExportarErgonListaDePlanoDeFerias',compact('relacao'));
             
                 if(isset($relacao) && count($relacao) > 0){

                    //fonte de pesquisa: https://www.laravelcode.com/post/how-to-export-csv-file-in-laravel-example
                    $fileName = 'planoferiasAnual.csv';
            
                    $headers = array(
                        "Content-type"        => "text/csv",
                        "Content-Disposition" => "attachment; filename=$fileName",
                        "Pragma"              => "no-cache",
                        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                        "Expires"             => "0"
                    );
                    $columns = array('Matricula', 'Vinculo', 'CPF', 'Inicio periodo aquisitorio', 'Fim periodo aquisitorio','Inicio Pagamento', 'Fim pagamento','Nome');

                    $callback = function() use($relacao, $columns) {
                        $file = fopen('php://output', 'w');
                        fputcsv($file, $columns);

                        foreach ($relacao as $task) {
                            $row['Matricula']  = $task->st_matricula;
                            $row['Vinculo']    = $task->st_vinculo;
                            $row['CPF']    = $task->st_cpf;
                            $row['Inicio periodo aquisitorio']  = $task->dt_inicioperiodoaquisitorio;
                            $row['Fim periodo aquisitorio']  = $task->dt_fimperiodoaquisitorio;
                            $row['Inicio Pagamento']  = $task->dt_inicio;
                            $row['Fim Pagamento']  = $task->dt_fim;
                            $row['Nome']  = $task->st_nome;

                            fputcsv($file, array($row['Matricula'], $row['Vinculo'], $row['CPF'], $row['Inicio periodo aquisitorio'], $row['Fim periodo aquisitorio'], $row['Inicio Pagamento'], $row['Fim Pagamento'], $row['Nome'] ));
                        }
                        fclose($file);
                    };
                    return response()->stream($callback, 200, $headers);
                }else {
                    throw new Exception("nenhum registro localizado");
                }
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }

        public function finalizarPlanoFerias($ano)
        {
            try{
                $this->authorize('PLANO_FERIAS');
                //faz requisição a api
                $msg = $this->PlanoFeriasService->finalizarPlanoFerias($ano);
               // dd($respostaApi);
                 //redireciona para a listagem
                 //return redirect('rh/planoferias')->with('sucessoMsg', $msg);
                 return redirect('rh/planoferias/'.$ano.'/turma/1')->with('sucessoMsg', $msg);
            }catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }

        /**
         * @author @juanmojica - #367
         * @param $ano
         * @return (Retorna uma lista do efetivo sem plano de férias)
          */
        public function listarEfetivoSemPlanoFerias($ano){
            try {
                //array com campo ('nu_ano') obrigatório exigido pelo serviço da API invocado abaixo
                $dados['nu_ano'] = $ano;
                $efetivo = $this->PlanoFeriasService->listarEfetivoSemPlanoFerias($dados);
                return view('rh::planoferias.ListaEfetivoSemPlanoFerias', compact('efetivo', 'ano'));
            } catch(Exception $e){
                return redirect()->back()->with('erroMsg', $e->getMessage());  
            }
        }

    }

?>