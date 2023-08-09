<?php
    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Exception;
    use App\utis\ApiRestGeneric;
    use Request;
    use App\utis\LengthAwarePaginatorConverter;
    use App\Utis\Msg;
    use Auth;

    class DalService   extends Controller{
        

        //@author Alexia Tuane
        //lista recursos por unidade
        // issue: #343
        public function getRecurso($dadosForm){
            try{
                //dd($dadosForm);
                $api = new ApiRestGeneric();
                $request = $api->get('dal/unidade/recursos', $dadosForm);
                //dd($request);
                $response = $api->converteStringJson($request);
                return $response;
               }catch(Exception $e){
                    throw new Exception($e->getMessage());
            }
        }

           //@author Alexia Tuane
        //lista recursos por unidade e categoria
        // issue: #343
        public function categoriaUni($dadosForm){
            try{
                //dd($dadosForm);
                $api = new ApiRestGeneric();
                $request = $api->get('dal/unidade/categoria/recursos', $dadosForm);
                //dd($request);
                $response = $api->converteStringJson($request);
                return $response;
               }catch(Exception $e){
                    throw new Exception($e->getMessage());
            }
        }
         //@author Alexia Tuane
        //retor lista recursos por unidade
        // issue: #343
        public function recursoUni( $idUnidade){
            try{
                //dd($idUnidade);
                $api = new ApiRestGeneric();
                $request = $api->get('dal/unidade/recursos',  $idUnidade);
                //dd($request);
                $response = $api->converteStringJson($request);
                return $response;
               }catch(Exception $e){
                    throw new Exception($e->getMessage());
            }
        }

        public function getCategoria(){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("dal/categorias");
                $response = $api->converteStringJson($request);
                return $response;
                }catch(Exception $e){
                    throw new Exception($e->getMessage());
            }
        }

        //@author Alexia Tuane
        //edita um recurso
        // issue: #343
        public function cadastraRecurso($dadosForm){
            try{        
               $api = new ApiRestGeneric();
               $request = $api->post('dal/unidade/recurso/create', $dadosForm);
               $response = $api->converteStringJson($request);
               if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
            }
                 return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }



        //@author Alexia Tuane
        //retorna o form de edicao do recurso por id
        // issue: #343
    public function retornaRecursoPorId($idRecurso){
        try{
            $api = new ApiRestGeneric();
            $request = $api->get("dal/recurso/".$idRecurso);
            $response = $api->converteStringJson($request);
           
            if(isset( $response->retorno )){
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
         * @author juanmojica - issue 342 - implementar tela de cadastrar dados do fardamento
         * @param int $diPolicial  
         * @return object $response (Cautelas do Fardamento) */ 
        
        public function getCautelasFardamento($diPolicial){
            try {
                $api = new ApiRestGeneric();
                $request = $api->get('dal/cautelas/fardamento/policial/'.$diPolicial);
                $response = $api->converteStringJson($request);
                if (isset($response->retorno)) {
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
                
            }
        }

        /**
         * @author juanmojica - issue 342
         * @param void  
         * @return object $response (Quantitativo de Fardamentos) */ 
        
        public function getQuantitativoFardamentos(){
            try {
                $api = new ApiRestGeneric();
                $request = $api->get('dal/uniformeportamanho');
                $response = $api->converteStringJson($request);
                if (isset($response->retorno)) {
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
                
            }
        }

        /**
         * @author juanmojica - issue 342
         * @param array Ids de unidades  
         * @return object $response (Quantitativo de Fardamentos por Unidades) */ 
        
        public function getQuantitativoFardamentosPorUnidades($dados){
            try {
                $api = new ApiRestGeneric();
                $request = $api->get('dal/uniformeporunidades', $dados);
                $response = $api->converteStringJson($request);
                if (isset($response->retorno)) {
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
                
            }
        }
          //@author Alexia Tuane
        //retorna o form de edicao do recurso por id
        // issue: #343
    public function editaRecurso($idRecurso, $dadosForm){
        try{
            $api = new ApiRestGeneric();
            $request = $api->put("dal/recurso/edita/".$idRecurso, $dadosForm);
           //dd($request);
            $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        //@author Alexia Tuane
        //exclui recurso
        // issue: #343
    public function excluiRecurso($idRecurso){
        try{
             $api = new ApiRestGeneric();
             $exclui = $api->delete("dal/recurso/delete/".$idRecurso);
             $response = $api->converteStringJson($exclui);
             if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
             }
             return $response;
       }catch(Exception $e){
             throw new Exception($e->getMessage());
             }
        }

         /**
         * @author juanmojica - issue #345  
         * @return object $response (Retorna uma lista de policiais sem fardamentos cadastrados) */ 
        
        public function getPoliciaisSemFardamentos(){
            try {
                $api = new ApiRestGeneric();
                $request = $api->get('dal/policiaissemfardamentocasastrado?'.Request::getQueryString());
                $response = $api->converteStringJson($request); 
                if (isset($response->retorno)) {
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
               // $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
                return $response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
                
            }
        }



    }
   