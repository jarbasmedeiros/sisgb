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
use  Modules\Admin\Entities\Permission;
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
 * @author ataíde
 */
class PermissionService  extends Controller {


    /**
     * Author: Ataíde
     *  adiciona uma permissão especifica a um perfil específico
     *  passando apenas o id da permissão e do perfil.
     */
    public function adicionaPermissaoAoPerfil($id, $dados){
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $adiciona = $api->put("vincula/permissao/perfil/".$id, $dados);
            
            $objeto = $api->converteStringJson($adiciona);
                  
            //Verificação se houve erro na requisição
            if($objeto->retorno == 'sucesso'){
                
                return 1;
            }else{
                
                return $objeto->msg;
            }
            //return $objeto;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    /**
     * Author: Ataíde
     *  consulta uma permissão especifica
     *  passando apenas o id da permissão específica.
     */
    public function consultaPermissaoPorId($id){
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $consulta = $api->get("permissaodousuario/".$id);
            $objeto = $api->converteStringJson($consulta);
            
            //Verificação se houve erro na requisição
            if(isset($objeto->retorno)){
                throw new Exception($objeto->msg);
            }
            return $objeto;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }
    /**
     * Author: Ataíde
     *  lista todos as permissões de usuário
     */
    public  function listaTodasPermissoes() {
        try{
            
            $api = new ApiRestGeneric();
             // Requisição para API
            $permissoes = $api->get("permissaousuario");
            $objeto = $api->converteStringJson($permissoes); 

            if(count($objeto) < 1 ) {
                return [];
            }
            if(isset($objeto->retorno) && $objeto->retorno == 'erro'){
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
     *  Espera receber apenas o id da permissão como parâmetro
     */
    public function editaPermissao($id, $dados) {
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $edita = $api->put("permissaodousuario/".$id."/edita", $dados);
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
     *  cadastra uma permissao de usuário específica
     */
     
    public function cadastraPermissao($dados) {
        
        try{
            
            $api = new ApiRestGeneric();
            // Requisição para API
            $cadastra = $api->post("permissaodousuario/cadastra", $dados);
            
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
    
}




?>