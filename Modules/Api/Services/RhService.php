<?php
    namespace Modules\Api\Services;

    use App\utis\ApiRestGeneric;

    use App\Http\Controllers\Controller;
    use DB;
    use Modules\rh\Entities\Funcionario;
    use Modules\Api\Services\UnidadeSErvice;
    use Illuminate\Database\Query\Builder;
    use Exception;
    use App\utis\LengthAwarePaginatorConverter;
    use App\Utis\Msg;
    use Request;
    use Auth;

class RhService extends Controller 
{

    public function getDashboard() {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("rh/dashboard/ativos");//<<MUDAR ISSO AQUI
			$response = $api->converteStringJson($request);
            //dd($response);
            //Verificação se houve erro na requisição
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

    public function getCategoriasReligiosas() {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("rh/categoriasreligiosas");
			$response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
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

    public function getDenominacoesReligiosas($idcategoria) {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->get("rh/categoriareligiosa/".$idcategoria."/denominacoesreligiosas");
			$response = $api->converteStringJson($request);
            //Verificação se houve erro na requisição
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

    public function getDenominacaoByidCategoriaNome($dadosForm) {            
        try{
            $api = new ApiRestGeneric();
            // Requisição para API
           // $request = $api->get("rh/categoriareligiosa/".$idCategoria."/denominacaoreligiosa/".$denominacao);
            $request = $api->post("rh/categoriareligiosa", $dadosForm);
            $response = $api->converteStringJson($request);
            return  $response;
            //Verificação se houve erro na requisição
          /*   if(isset($response->retorno)){
                    throw new Exception($response->msg);
            } */
            return $response;            
        }catch(Exception $e){

            throw new Exception($e->getMessage());
        }
    }

    public function cadastraCensoReligioso($idPolicial, $dadosForm){
        try{            
            $api = new ApiRestGeneric();
            //salva o censo religioso do policial
            $request = $api->put("rh/cadastracensoreligioso/policial/".$idPolicial, $dadosForm);
            $response = $api->converteStringJson($request);
            //dd($response);
            //Verifica se houve erro na requisição
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;                      
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    public function cadastraCensoReligiosoAdm($idPolicial, $dadosForm){
        try{            
            $api = new ApiRestGeneric();
            
          
            //salva o censo religioso do policial
            $request = $api->put("rh/cadastracensoreligioso/policial/".$idPolicial, $dadosForm);
            $response = $api->converteStringJson($request);
            //dd($response);
            //Verifica se houve erro na requisição
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response->msg;                      
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    public function verificaCensoReligioso($idPolicial){
        try{            
            $api = new ApiRestGeneric();
            //retorna o censo religioso do policial
            $request = $api->get("rh/censoreligioso/policial/".$idPolicial);
            //$request = $api->get("rh/censoreligioso/policial/1564656");
            $response = $api->converteStringJson($request);
            //dd($response);
            if(isset($response->retorno)){
                if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return null;
                }else{
                    return $response;
                }
            }
            
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    
    /**
     * Alexia Tuane
     * issue: 487 - criar-tela-de-dashboard-censo-religioso
     * Dashboard do menu lateral do Recursos Humanos
     */
    public function getDashboardCensoReligioso() {            
    try{
        
        $api = new ApiRestGeneric();
        $request = $api->get("rh/censoreligioso/dashboard"); //depois remover a "}" da rota no swagger e aqui no service
        //dd($request);
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
    /**
     * Alexia Tuane
     * issue: 487 - criar-tela-de-dashboard-censo-religioso
     * Dashboard do menu lateral do Recursos Humanos
     */
    public function categoriaReligiosaDetalhada($idCategoria) {            
    try{
       
        $api = new ApiRestGeneric();
        $request = $api->get("rh/censoreligioso/dashboard/categoria/".$idCategoria); //depois remover a "}" da rota no swagger e aqui no service
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