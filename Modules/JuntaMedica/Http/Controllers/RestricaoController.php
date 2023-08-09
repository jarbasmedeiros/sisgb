<?php

    namespace Modules\JuntaMedica\Http\Controllers;

    use Modules\Api\Services\JuntaMedica\RestricaoService;
    use Illuminate\Routing\Controller;
    use Illuminate\Http\Response;
    use Illuminate\Http\Request;
    use App\utis\Msg;
    use Exception;

    class RestricaoController extends Controller
    {
        public function __construct(RestricaoService $restricaoService){
            $this->middleware('auth');
            $this->restricaoService = $restricaoService;
        }
        
        /** @author Marcos Paulo #332
        *   Obtem todas as restrições paginadas
        */
        public function getRestricoes(){
            try{
                $restricoes = $this->restricaoService->getRestricoes();
                return view('juntamedica::restricoes.listarRestricoes', compact('restricoes'));      
            }catch(Exception $e){
                dd($e->getmessage());
            }
        }

        /** @author Marcos Paulo #332
        *   Cria uma nova restrição
        */
        public function criarRestricao(Request $request){
            try {
                $dados = $request->all();
                $validator = validator($dados, ['st_restricao' => 'required']);
                $restricao = $this->restricaoService->criarRestricao($dados);
                return redirect('/juntamedica/restricoes')->with('sucessoMsg', $restricao);
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }

        /** @author Marcos Paulo #332
        *   Retorna o form de edição da restrição
        */
        public function editarRestricao($idRestricao){
            try {
                $restricao = $this->restricaoService->restricaoById($idRestricao);
                return View('juntamedica::restricoes.editarRestricao', compact('restricao'));
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }        
        }   

        /** @author Marcos Paulo #332
        *   Update restrição
        */
        public function updateRestricao(Request $request, $idRestricao){
            try{
                $dados = $request->all();
                $validator = validator($dados, [
                    'bo_ativo' => 'required',
                    'st_restricao' => 'required',
                ]);
                $restricao = $this->restricaoService->editarRestricao($idRestricao, $dados);  
                return redirect('/juntamedica/restricoes')->with('sucessoMsg', Msg::SALVO_SUCESSO);
            } catch (Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }        
        }

        /** @author Marcos Paulo #332
        *   Excluir restrição pelo id
        */
        /* public function deletarRestricao($idRestricao){
            try {
                $response = $this->restricaoService->deletarRestricao($idRestricao);
                return redirect()->back()->with('sucessoMsg', $response->msg);
            } catch(Exception $e) {
                return redirect()->back()->with('erroMsg', $e->getMessage());
            }
        }*/
    }
?>
