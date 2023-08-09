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

class MapaForcaService  extends Controller {

    //Autor: @carlos
    //consuta informações para p relatório de mapa forca
    //Requer o status
    public function getInformacoesParaFomularioRelatorioDinamico(){
        try{
                  
            $api = new ApiRestGeneric();
          
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


    public function filtro()
    {
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
           /*  if(isset($dados['excel']) &&  $dados['excel'] == 'true'){
                $dados = $dados[]
            }; */
            $request = $api->get("rh/relatorio/filtro");
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
    public function getInformacoesPorUnidade($idUnidade)
    {
        try{  
            $api = new ApiRestGeneric();
            $request = $api->get("rh/relatorio/mapaforca/unidade/$idUnidade");
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


}

?>