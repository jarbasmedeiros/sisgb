<?php
    namespace Modules\Api\Services;

    use App\utis\ApiRestGeneric;
    use App\Utis\Msg;
    use App\Utis\Funcoes;
    use Exception;
    use Illuminate\Support\Facades\Auth;
    
                


    class PunicaoService   {
     
        // Lista todos as punições de um policial
        public function GetPunicoesPolicial($idPolicial) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/punicoes/".$idPolicial);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($fichaDisciplinar->msg);
                    }
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
    
        // Recupera uma punição de um policial
        public function findPunicaoById($idPolicial, $idPunicao) {
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."punicao/".$idPunicao);
                $response = $api->converteStringJson($request);
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        public function cadastraPunicao($idPolicial,$dadosForm) {
            try{
                
                $dadosForm['ce_policial'] = $idPolicial;
                
                  $api = new ApiRestGeneric();
                  $request = $api->post("policiais/punicoes/".$idPolicial."/novaponicao", $dadosForm);
                  //$request = $api->post("rg/novo",$dadosForm);
                //  dd($request);
                  $response = $api->converteStringJson($request);
                  
                  if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }

                  return $response;
              } catch(Exception $e){
                  throw new Exception($e->getMessage());
              }
        }
        public function editaPunicao($idPolicial, $idPunicao,$dadosForm) {
            try{
                $dadosForm['ce_policial'] = $idPolicial;
                  $api = new ApiRestGeneric();
                  $request = $api->put("policiais/punicoes/".$idPolicial."/editapunicao/".$idPunicao, $dadosForm);

                  //$request = $api->post("rg/novo",$dadosForm);
                //  dd($request);
                  $response = $api->converteStringJson($request);
                    if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                    }
                  return $response;
              } catch(Exception $e){
                  throw new Exception($e->getMessage());
              }
        }


        /*issue:365-criar-aba-dependentes
         * exclui uma punicao
         * Alexia 
    */
        public function excluirPunicao($idPolicial, $idPunicao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->delete("policiais/punicoes/".$idPolicial. "/excluipunicao/" .$idPunicao);
                $response = $api->converteStringJson($request);
                //verifica se o response vem diferente de sucesso e retorna a msg
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
                return $response->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

    }

?>