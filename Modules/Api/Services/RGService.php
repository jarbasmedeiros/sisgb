<?php
    namespace Modules\Api\Services;

    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;
    use App\Utis\Funcoes;
    use Exception;
    use Illuminate\Support\Facades\Auth;
    
                


class RgService   {
    
    //   Route::get('/v1/prontuario/{idPolicial}', 'RgController@getProntuario');
    // Lista todos os cargos ativos
    // Saída - lista os campos [id, st_cargo] de cargos
    public function getProntuario($idPolicial) {
        try{
            //  dd('fdsfdsfsdfsdaf');
            $api = new ApiRestGeneric();
            //dd('fdfdwwdfdfdfdfd');
            $request = $api->get("rg/prontuario/".$idPolicial);
            
            $response = $api->converteStringJson($request);
            //dd($response);
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            return $response;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    public function listarRGs1() {
        
        $rgs = collect ([
        (object) ["id"=>"1","ce_policial"=>"1769","st_rgmilitar"=>"1111","st_nome"=>"pedro","st_impresso"=>"NORMAL","st_fotorg"=>"imagem1", "st_validade"=>"indeterminada","st_cedula"=>"1234","nu_via"=>"1","dt_emissao"=>"12/12/2010","dt_entrega"=>"12/12/2010","dt_devolucao"=>"12/12/2010","st_motivo"=>"promovido a cabo"],
        (object) ["id"=>"2","ce_policial"=>"10064","st_rgmilitar"=>"2222","st_nome"=>"carlos","st_impresso"=>"NORMAL","st_fotorg"=>"","st_validade"=>"indeterminada","st_cedula"=>"1234","nu_via"=>"2","dt_emissao"=>"12/12/2010","dt_entrega"=>"12/12/2010","dt_devolucao"=>"","st_motivo"=>"promovido a cabo"]
        
        ]);
    //  dd($rgs);
        return $rgs;
    }
    
    public function getRgById($idRg) {
        try{
                $api = new ApiRestGeneric();
                $request = $api->get("rg/".$idRg);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }

    public function criarRg($idPolicial,$dadosForm) {
        try{
            
            $dadosForm['ce_emissor'] = Auth::user()->id;
            $dadosForm['st_via'] = 1;
            $dadosForm['ce_policial'] = $idPolicial;
            
                $api = new ApiRestGeneric();
                $request = $api->post("rg/novo",$dadosForm);
            //  dd($request);
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }
    public function salvarRg($idRg, $dadosForm) {
        try{
                dd('salvarRg');                   
                $api = new ApiRestGeneric();
                $request = $api->post("rg/".$idRg,$dadosForm);
                dd($request);
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }
    public function getIdentidadeParaImpressao($idPolicial, $idRg) {
        try{
            // dd('dfds');                   
            $api = new ApiRestGeneric();
            $request = $api->get("rg/".$idRg."/impressao/pm/".$idPolicial);
            $response = $api->converteStringJson($request);
            // dd($response);
            
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            return $response;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    
    public function confirmarImpressao($idPolicial,$idRg,$dadosForm){
        try{
                $api = new ApiRestGeneric();
                $request = $api->post("rg/".$idRg."/impressao/pm/".$idPolicial."/confirmacao",$dadosForm);
                // dd($request);
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno) && $response->retorno=="erro"){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }
    public function entregarRg($idRg){
        try{
                $api = new ApiRestGeneric();
                $request = $api->get("rg/".$idRg."/entrega");
            //  dd($request);
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno) && $response->retorno=="erro"){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }

    public function devolverRg($idRg){
        try{
                $api = new ApiRestGeneric();
                $request = $api->get("rg/".$idRg."/devolucao");
                // dd($request);
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno) && $response->retorno=="erro"){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }

    public function salvarImagemCedulaRg($idRg,$fotoRg){
        try{
            //   dd($idRg);
                $api = new ApiRestGeneric();
                // $api->showUrl(true);
                $request = $api->post("rg/".$idRg."/imagens",$fotoRg);
                // dd($request);
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno) && $response->retorno=="erro"){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }


    public function setProntuario($idPolicial,$dadosForm){
        try{
            
                $api = new ApiRestGeneric();
                // $api->showUrl(true);
            
                $request = $api->post("rg/prontuario/".$idPolicial,$dadosForm);
                // dd($request);
                $response = $api->converteStringJson($request);
                
                if(isset($response->retorno) && $response->retorno=="erro"){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }

    
    public function getDashboard(){
        try{
            
                $api = new ApiRestGeneric();
            
                $request = $api->get("rg/dashboard");
                // dd($request);
                $response = $api->converteStringJson($request);
            //    dd($response);
                if(isset($response->retorno) && $response->retorno=="erro"){
                    throw new Exception($response->msg);
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }

    public function atualizarCedula($idRg, $dadosForm){
        try{
            
                $api = new ApiRestGeneric();
                // /v1/rg/{idRg}/cedula
                $request = $api->post("rg/".$idRg."/cedula",$dadosForm);
                //dd($request);
                $response = $api->converteStringJson($request);
                //dd($response);
                if(isset($response->retorno) && $response->retorno=="erro"){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }

    public function pesquisarRg($dadosForm){
        
            try{
                $api = new ApiRestGeneric();
                // /v1/rg/{idRg}/cedula
                $request = $api->post("rg/pesquisa",$dadosForm);
            //s  dd($request);
                $response = $api->converteStringJson($request);
                //($response);
                if(isset($response->retorno) && $response->retorno=="erro"){
                    throw new Exception($response->msg);
                }                 
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }

    /**  
    * @author @juanmojica - #355
    * @param $chave
    * @return response (Retorna um objeto configuração com os dados da chave informada)
    */
    public function getConfiguracao(){
        try{  
            $api = new ApiRestGeneric();
            $request = $api->get("config/chave/RESPONSAVELRG");
            //dd($request);
            $response = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            //retorna o objeto
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    /**  
    * @author @jazon - #355
    * @return lista de configurações do módulo RG
    */
    public function getConfiguracoesModuloRg(){
        try{  
            $api = new ApiRestGeneric();
            $request = $api->get("config/modulo/RG");
            // dd($request);
            $response = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            //retorna a lista de objetos
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    /**  
    * @author @jazon - #355
    * @return lista de configurações do módulo RG
    */
    public function setConfiguracaoModuloRg($dadosForm){
        try{  
            //dd($dadosForm);
            $api = new ApiRestGeneric();
            $request = $api->post("config",$dadosForm);
            //dd($request);
            $response = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($response->retorno) && $response->retorno !="sucesso"){
                throw new Exception($response->msg);
            }
            //retorna a msg
            return $response->msg;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    //cb Araujo
    //527-resolver-bug-do-rg
    public function listaAgendamento($dadosForm) {            
        try{
            $api = new ApiRestGeneric();
            $request = $api->get('rg/listar_por_dt_emissao', $dadosForm);
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