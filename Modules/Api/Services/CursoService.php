<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Exception;
    use App\utis\ApiRestGeneric;
    use Request;
    use App\utis\LengthAwarePaginatorConverter;
    use App\Utis\Msg;
    use Auth;

    class CursoService  extends Controller {

    
        
        // Busca os cursos dos policiais da unidade de lotação
        // Entrada - idFUnidade 
        // Saída - lista de policiais de uma determinada unidade com seus respectivos cursos.
        public function listaCursosPorUnidade($idUnidade, $renderizacao)
        {
            try{
                $api = new ApiRestGeneric();
                if($renderizacao == 'paginado'){
                    $request = $api->get("cursos/unidade/" . $idUnidade."/paginado?".Request::getQueryString());
                }else{
                    $request = $api->get("cursos/unidade/" . $idUnidade );
                }
               
                $cursos = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($cursos->retorno)){
                    if($cursos->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($cursos->msg);
                    }
                }

                if($renderizacao == 'paginado'){
                    $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($cursos, url()->current());
                    return $paginator; 
                }else{
                    return $cursos; 
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }   
        }
        
        // Busca os cursos dos policiais da unidade e nome passados como parêmtros
        // Entrada - array de ce_unidades e st_curso
        // Saída - lista paraginada com os policiais e seus respectivos cursos, conforme unidades e nome do curso passsados como parâmetros
        public function listaCursosPorUnidadeENome($dados, $rederizacao)
        {
            try{
                $api = new ApiRestGeneric();
                if($rederizacao !=     'paginado'){
                    $request = $api->post("cursos/nome/unidade", $dados );
                }else{

                    $request = $api->post("cursos/nome/unidade/paginado", $dados );
                }
                $cursos = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($cursos->retorno)){
                    if($cursos->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($cursos->msg);
                    }
                }
                if($rederizacao == 'paginado'){
                    $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($cursos, url()->current());
                    return $paginator; 
                   
                 }else{
                    return  $cursos;
                 }
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }   
        }

      


    }

?>