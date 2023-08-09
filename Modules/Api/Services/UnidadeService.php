<?php
namespace Modules\Api\Services;

use App\Http\Controllers\Controller; 
use Auth;
use App\Log;
use Exception;

use App\utis\ApiRestGeneric;
use App\utis\Msg;
use App\utis\LengthAwarePaginatorConverter;
use Illuminate\Support\Facades\Request;


use DB;


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
class UnidadeService  extends Controller {
   
    /* 
    Autor: @aggeu. 
    Issue 184, Editar dados funcionais. 
    Função que retorna uma lista não páginada de unidades 
    */     
    public function getUnidade() {
      try{        
        $api = new ApiRestGeneric();
        $request = $api->get("unidades/naopaginado");
        $response = $api->converteStringJson($request);
        
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

    public function getUnidadesPaginadas() {
      try{        
        $api = new ApiRestGeneric();
        $request = $api->get("unidades?".Request::getQueryString());
        $response = $api->converteStringJson($request);
       
       // dd($response);
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

     //  recupera uma unidade pelo id
    public function getUnidadeById($idUnidade) {
      try{        
        $api = new ApiRestGeneric();
        $request = $api->get("unidades/".$idUnidade);
        $response = $api->converteStringJson($request);
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
     * @author Jazon #296
     * Busca por nome ou sigla da unidade
     * */
    public function searchUnidade($dadosForm)
    {
      try{    
       
        $api = new ApiRestGeneric();
       // $request = $api->get("unidades/consulta",$dadosForm);
        $request = $api->get("unidades/consulta?".Request::getQueryString(),$dadosForm);
        $response = $api->converteStringJson($request);
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


    
  
     /***
      * @author Jazon #296
     * Editando uma Unidade.
     Para Editar uma unidade é necessário passar com parâmetro o objeto unidade, o qual deseja alterar e um array com dados para edição
     */
    public function updateUnidade($id,$dadosForm) {        
        try{   
            
            $api = new ApiRestGeneric();
            $request = $api->post("unidades/".$id,$dadosForm);
            

            $response = $api->converteStringJson($request);
            if(isset($response->retorno) && $response->retorno == 'erro'){                 
               throw new Exception($response->msg);
            }
            
            return $response->msg;         
        }catch(Exception $e){
          throw new Exception($e->getMessage());
        }

    }
      
    public function updateUnidadeAuxiliar($id,$dadosForm) {        
      try{   
          
          $api = new ApiRestGeneric();
          $request = $api->put("unidades/".$id."/extras",$dadosForm);
         //dd($request);

          $response = $api->converteStringJson($request);
          if(isset($response->retorno) && $response->retorno == 'erro'){                 
             throw new Exception($response->msg);
          }
          
          return $response->msg;         
      }catch(Exception $e){
        throw new Exception($e->getMessage());
      }

  }
            
    /**
     *  função para buscar a hierarquia de uma determinada Unidade
     *  Entrada: Objeto Unidade
     * Saída: Istring com a hirarquida das unidades superiores à unidade passada como parâmetro 
    */
    public function gethierarquia($unidade){
        $contador = 0;
            $pai = null;
        $hierarquia = null;
        if($unidade->ce_pai != 0){
                $pai = $unidade;
                $hierarquia = $hierarquia.'/'.$pai->st_sigla;
                
            while(!empty($pai)){
                $contador = $contador+1;
                
                $pai = Unidade::find($pai->ce_pai);
                if(!empty($pai)){

                    $hierarquia = $hierarquia.'/'.$pai->st_sigla;
                }
            }
        }else{
        $hierarquia = '/'.$unidade->st_sigla;
        
        } 
        
        return substr($hierarquia, 1);
    }
    /**
     * Busca todas as unidades subordinadas.
     * Entrada: id da unidade pai que desaja resgatar as filhas
     * Saída: array com os ids das unidades filhas e id da unidade pai
     */
    //
    public function getunidadesfilhas($idUnidadeLotacaoDoPolicial) {
    /*  var_dump($idUnidadeLotacaoDoPolicial);
     die(); */

      $api = new ApiRestGeneric();
      //$request = $api->get("unidades/".$idUnidadeLotacaoDoPolicial);
     $request = $api->get("unidades/arvoreunidades/".$idUnidadeLotacaoDoPolicial."/todasunidades");
     // dd( $request );
      $response = $api->converteStringJson($request);
      if(isset($response->retorno)){
        if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
          throw new Exception('Unidade Pai não encontrada');
        }else{
            throw new Exception($response->msg);
        }
      }
      

        return  $response;
    }
    /**
     * Busca todas as unidades subordinadas.
     * Entrada: id da unidade pai que desaja resgatar as filhas com o nome das unidades 
     * Saída: array com os ids das unidades filhas e id da unidade pai
     */
    //
    public function getunidadesfilhasNome($idUnidadeLotacaoDoPolicial) {
    /*  var_dump($idUnidadeLotacaoDoPolicial);
     die(); */

      $api = new ApiRestGeneric();
      //$request = $api->get("unidades/".$idUnidadeLotacaoDoPolicial);
     $request = $api->get("unidades/arvoreunidades/".$idUnidadeLotacaoDoPolicial."/todasunidades/filhas");
     // dd( $request );
      $response = $api->converteStringJson($request);
      if(isset($response->retorno)){
        if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
          throw new Exception('Unidade Pai não encontrada');
        }else{
            throw new Exception($response->msg);
        }
      }
      

        return  $response;
    }
    public function filhos() {
     
        $unidades = null;
        $unidade = Unidade::find(Auth::user()->ce_unidade);
       
        
        if(!empty($unidade)){             
          $unidades[] = $unidade->id;
          foreach($unidade->filhos as $comment){
            
            $unidades[] =$comment->id;
            if($comment->filhos->count()){
              foreach($comment->filhos as $reply){
                  
                $unidades[] = $reply->id;
              }
            }
          }

        }
        return $unidades;
    }

    /**
     * Para buscar os filhos recursivos se faz necessário passar um objeto unidade do usuario logado para o métod filhosrecursivo
     */
   public function filhosrecursivo($unidade){
    
    $unidadefilhas = null;
    $arrayfilhos = array();

    $filhos = $unidade->filhos;
    
      
       if($filhos->count() > 0){
        foreach($filhos as $filho){
            
           array_push($arrayfilhos, $this->filhosrecursivo($filho));
            
          }
          return $arrayfilhos;
       }else{
          return $filhos; 
       }
      
   }
   
   

   public function showOrganograma($tipo) {
    try{
      $api = new ApiRestGeneric();
      $request = $api->get("unidades/organograma/tipo/".$tipo);
      //dd($request);
      $response = $api->converteStringJson($request);
      if(isset($response->retorno)){
        if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
          //return redirect('/home')->with('erroMsg',"Nenhuma Unidade Cadastrada!");
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