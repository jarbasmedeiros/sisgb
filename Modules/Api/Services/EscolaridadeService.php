<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\Admin\Entities\Escolaridade;
    use Exception;
    use App\utis\ApiRestGeneric;
    use App\utis\LengthAwarePaginatorConverter;
    use App\Utis\Msg;
    use Illuminate\Http\Request;

    class EscolaridadeService  extends Controller {

        // Lista todos as escolaridades
        // Saída - lista todos os campos de escolaridades
        public function listaescolaridadesativos() {
            $escolaridades = Escolaridade::orderby('st_escolaridade')->get();
            return $escolaridades;
        }

        public function listaCursosAcademicos($idPolicial){
            try {
                $api = new ApiRestGeneric();
                //Busca os cursos acadêmicos do policial
                $request = $api->get("policiais/".$idPolicial."/cursos/academicos");
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                return $response;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

    }

?>