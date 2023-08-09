<?php
    namespace Modules\Api\Services;
    use App\utis\Status;
    use Auth;
    use DB;
    use Illuminate\Support\Facades\Request;
    use App\utis\MyLog;
    use App\utis\ApiRestGeneric;
    use App\utis\LengthAwarePaginatorConverter;
    use App\utis\Msg;
    use Modules\Boletim\Entities\Role;
    use Exception;


    class RoleService 
    {
        public function consultaPerfisPorId($idPerfil){
            try {
                
                $api = new ApiRestGeneric();
                $perfil = $api->get("perfisdousuario/".$idPerfil);
                $response = $api->converteStringJson($perfil);
                
                if(isset($response)){
                
                    if(!isset($response->retorno)){
                        return $response;    
                    }

                    throw new Exception($response->msg);
                }
                    

            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }

        public function listaPerfisDeUsuario(){
            try {
               
                $api = new ApiRestGeneric();
                $perfis = $api->get("perfisusuario");
                $response = $api->converteStringJson($perfis);
                
                if(isset($response)){
                    if(isset($response->retorno)){
                        if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                            return [];
                        }else{

                            throw new Exception($response->msg);
                        }
                    }
                    return $response;    
                }
                    

            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }

        public function cadastraPerfisDeUsuario($dados){
            try {

                $api = new ApiRestGeneric();
                $novoPerfil = $api->post("perfisdousuario/cadastra", $dados);
                $cadastra = $api->converteStringJson($novoPerfil);
                
                if($cadastra->retorno != 'erro'){
                    return $cadastra;
                }else{
                    throw new Exception($cadastra->msg);
                }

            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }

        public function editaPerfisDeUsuario($dados, $id){
            try {
                //$id = 39;
                $api = new ApiRestGeneric();
                $Perfil = $api->put("perfisdousuario/".$id."/edita", $dados);
                $edita = $api->converteStringJson($Perfil);

                if($edita->retorno == 'sucesso'){
                    //return $edita;
                }else{
                    
                    throw new Exception($edita->msg);
                }

            }catch(Exception $e){
                
                throw new Exception($e->getMessage());
            }

        }
        
    }

?>