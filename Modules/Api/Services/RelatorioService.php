<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use DB;
    use Illuminate\Database\Query\Builder;
    use Exception;
    use App\utis\ApiRestGeneric;
    use App\utis\LengthAwarePaginatorConverter;
    use App\Utis\Msg;
    use Request;
    use Auth;

class RelatorioService  extends Controller {

    //Autor: @medeiros
    //consuta informações para o formulario do relatorio dinâmico
    //Requer o status
    public function getInformacoesParaFomularioRelatorioDinamico($st_status){
        try{
            /* if($status != 'ativo' && $status != 'inativo'){
                throw new Exception(Msg::STATUS_INVALIDO);
            }  */               
            $api = new ApiRestGeneric();

           /*  //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            } */
          
         
            $request = $api->get("rh/relatorio");
            $dados = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($dados->retorno)){
                throw new Exception($dados->msg);
            }
            
            return $dados; 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }


    public function filtro($dados,$st_status)
    {
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("rh/relatorio/filtro/".$st_status, $dados);
            $dados = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($dados->retorno)){
                if($dados->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($dados->msg);
                }
            }
            return $dados;

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }       
    }


}

?>