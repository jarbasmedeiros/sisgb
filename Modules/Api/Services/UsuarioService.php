<?php
namespace Modules\Api\Services;
use App\Http\Controllers\Controller; 
use App\utis\ApiRestGeneric;
use App\utis\LengthAwarePaginatorConverter;
use App\utis\Msg;
use Auth;
use App\Log;
use App\Unidade;
use App\Historico;
use App\Regional;
use App\Instituto;
use App\Setor;
use  Modules\Admin\Entities\User;
use  Modules\Admin\Entities\Unidades_user;
use DB;
use Exception;

use Illuminate\Support\Facades\Redirect;



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author medeiros
 */
class UsuarioService  extends Controller {

    /**
     * Author: Ataíde
     *  consulta um usuário especifico
     *  passando apenas o id do usuário específico.
     */
    public function consultaUsuarioPorId($idUsuario){
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $consulta = $api->get("usuarios/".$idUsuario);
            $objeto = $api->converteStringJson($consulta);
            
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                if($objeto->msg == 'Nenhum resultado encontrado.'){
                    throw new Exception('Usuário não encontrado');
                }else{

                    throw new Exception($objeto->msg);
                }
            }
            
            return $objeto;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }
    /**
     * Author: Ataíde
     *  lista todos os usuários
     */
    public  function listaTodosUsuarios() {
        try{
            
            $api = new ApiRestGeneric();
             // Requisição para API
            $request = $api->get("usuarios/paginado?".\Request::getQueryString());
            $objeto = $api->converteStringJson($request); 
            if(isset($objeto->retorno)){
                if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($objeto->msg);
                }
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($objeto, url()->current());
            return $paginator;

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    /**
     * Author: Ataíde
     *  deleta um usuario específico
     *  Espera receber apenas o id do usuário como parâmetro
     */
    public function deletaUsuario($idUsuario) {
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $deleta = $api->delete("usuarios/".$idUsuario."/deleta");
            $objeto = $api->converteStringJson($deleta);
            
            //Verificação se houve erro na requisição
            if($objeto->retorno != 'sucesso'){
                throw new Exception($objeto->msg);
            }
            return $objeto;
            
        }catch(Exception $e){
            
        throw new Exception($e->getMessage());
        }
        
    }
     /**
     * Author: Ataíde
     *  Edita um usuario específico
     *  Espera receber apenas o id do usuário como parâmetro
     */
    public function editaUsuario($id, $dados) {
        try{
            //$id = 500;
            $api = new ApiRestGeneric();
            // Requisição para API
            $edita = $api->put("usuarios/".$id."/edita", $dados);
            $objeto = $api->converteStringJson($edita);
            
            //Verificação se houve erro na requisição
            if($objeto->retorno != 'sucesso'){
                    throw new Exception($objeto->msg);
            }

            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        
    }
    /**
     * author: Ataide
     *  cadastra um usuário específico
     */
     
    public function cadastraUsuario($dados) {
        
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $cadastra = $api->post("usuarios/cadastra", $dados);
            
            $objeto = $api->converteStringJson($cadastra);
            
            //Verificação se houve erro na requisição
            if(isset($objeto)){
                
                if($objeto->retorno == 'erro'){
                throw new Exception($objeto->msg);
                }else{
                    return $objeto->msg;
                }
            }
            
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }
    
    
   
    /**
     * Espera receber o id do usuarios, as unidades que eram vinculadas e que agora não samo mais
     *  e as unidades que serão vinculadas de fato
         
     */
    public function alteraunidadesvinculadas($id, $unidadesvinculadas )
    {
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $vincula = $api->put("usuarios/".$id."/vincula/unidade", $unidadesvinculadas);
            
            $objeto = $api->converteStringJson($vincula);
            
            //Verificação se houve erro na requisição
            if(isset($objeto)){
                
                if($objeto->retorno == 'erro'){
                throw new Exception($objeto->msg);
                }else{
                    return $objeto->msg;
                }
            }
            
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

    }

    /**
     * Espera receber o id do usuarios, as unidades que eram vinculadas e que agora não samo mais
     *  e as unidades que serão vinculadas de fato
         
     */
    public function vinculausuarioPerfil($idUsuario, $perfisVinculados )
    {
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $vincula = $api->put("vincula/perfil/usuario/".$idUsuario, $perfisVinculados);
            
            $objeto = $api->converteStringJson($vincula);
            
            //Verificação se houve erro na requisição
            if(isset($objeto)){
                
                if($objeto->retorno == 'erro'){
                throw new Exception($objeto->msg);
                }else{
                    return $objeto->msg;
                }
            }
            
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

    }

   
    /**
     * Espera receber o id do usuarios, as unidades que eram vinculadas e que agora não samo mais
     *  e as unidades que serão vinculadas de fato
         
     */
    public function recuperarUsuarioPorNomeCPF($nomeCPF)
    {
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $request = $api->GET("usuarios/nomecpf",$nomeCPF);
            
            $response = $api->converteStringJson($request);
           
            //Verificação se houve erro na requisição
            if(isset($response->retorno)){
                if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($response->msg);
                }               
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
            return $paginator;
            
            
            }catch(Exception $e){
                
                throw new Exception($e->getMessage());
            }

    }

    /**
     * @author juanmojica - #437
     * @param Int, Array['ce_vinculo']
     * @return  (mensagem de sucesso ou erro)
     */
    public function alterarVinculo($idUser, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("usuarios/" . $idUser . "/vinculo/mudar", $dadosForm);
            $response = $api->converteStringJson($request);
            return $response;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juanmojica - #437
     * @param Int (id do usuário)
     * @return Array (vínculos do usuário)
     */
    public function getVinculosUsuario($idUsuario){
        try{
            $api = new ApiRestGeneric();
            $request = $api->get("usuarios/" . $idUsuario . "/vinculo/lista");
            $response = $api->converteStringJson($request);
            if (isset($response->retorno)) {
                if ($response->msg == 'Nenhum resultado encontrado.') {
                    return [];
                }
                throw new Exception($response->msg);
            }
            return $response;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juanmojica - #437
     * @param Int, Array['ce_unidade', 'ce_perfil', 'ce_funcao']
     * @return  (mensagem de sucesso ou erro)
     */
    public function adicionaVinculo($idUsuario, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("usuarios/" . $idUsuario . "/vinculo/adicionar", $dadosForm);
            $response = $api->converteStringJson($request);
            if ($response->retorno != 'sucesso') {
                throw new Exception($response->msg);
            }
            return $response->msg;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @author juanmojica - #437
     * @param Int (id do usuário, id do vinculo)
     * @return  (mensagem de sucesso ou erro)
     */
    public function deletaVinculo($idUsuario, $idVinculo){
        try{
            $api = new ApiRestGeneric();
            $request = $api->post("usuarios/" . $idUsuario . "/vinculo/" . $idVinculo . "/excluir");
            $response = $api->converteStringJson($request);
            if ($response->retorno != 'sucesso') {
                throw new Exception($response->msg);
            }
            return $response->msg;
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    
    
}




?>