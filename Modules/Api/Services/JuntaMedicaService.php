<?php

    namespace Modules\Api\Services;
    use Modules\rh\Entities\Promocao;
    use App\utis\ApiRestGeneric;
    use App\Http\Controllers\Controller;
    use App\Utis\Msg;
    use Modules\rh\Entities\Funcionario;
    use Illuminate\Database\Query\Builder;
    use Exception;
    use App\utis\LengthAwarePaginatorConverter;
    use Request;
    use Auth;

    class JuntaMedicaService  extends Controller{

        
        public function listaAtendimentos($idPolicial){
            try{
                $api = new ApiRestGeneric();
                $atendimentos = $api->get("prontuarios/policial/".$idPolicial);
                $response = $api->converteStringJson($atendimentos);
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
        //@author Alexia Tuane
        //Issue #306: lista o quantitativo de policiais acompanhados pelo JPMS agrupados por graduação 

        public function getRelatorioAcompanhamentoJPMS(){
            try{
                $api = new ApiRestGeneric();
                $policiaisEmAcompanhamento = $api->get('rh/relatorio/mapaforca/juntamedica');
                $response = $api->converteStringJson($policiaisEmAcompanhamento);
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
        //@author Alexia Tuane
        //Issue #306:  excel de policiais acompanhados pelo JPMS  
        public function getExcelPoliciaisEmAcompanhamentoJPMS( $idGraduacao){
            try{
                $api = new ApiRestGeneric();
                $policiaisEmAcompanhamento = $api->get("rh/relatorio/mapaforca/juntamedica/graduacao/".$idGraduacao);
                $response = $api->converteStringJson($policiaisEmAcompanhamento);
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
        //@author Alexia Tuane
        //Issue #337:  Retona a lista de cids
        public function getrelatorioAtendimento(){
            try{
                $api = new ApiRestGeneric();
                $policiaisEmAtendimento = $api->get('jpms/cids');
                $response = $api->converteStringJson($policiaisEmAtendimento);
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

        public function getProntuariosEmAcompanhamentoJPMS($tipoProntuario){
            try{
                $api = new ApiRestGeneric();
                if ($tipoProntuario == 'clinicaMedica') {
                    $prontuariosEmAcompanhamento = $api->get('jpms/prontuariosemacompanhamento/clinicamedica');
                } elseif ($tipoProntuario == 'ortopedia') {
                    $prontuariosEmAcompanhamento = $api->get('jpms/prontuariosemacompanhamento/ortopedia');
                } elseif ($tipoProntuario == 'psiquiatria') {
                    $prontuariosEmAcompanhamento = $api->get('jpms/prontuariosemacompanhamento/psiquiatrico');
                } else {
                    $prontuariosEmAcompanhamento = $api->get('jpms/prontuariosemacompanhamento');
                }
                $response = $api->converteStringJson($prontuariosEmAcompanhamento);
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
                
        //@author Alexia Tuane
        //Issue #337: retorna a lista de atendimento medicos da JPMS por periodo e cids 
        public function atendimentoPeriodo($dadosForm){
            try{
               $api = new ApiRestGeneric();
               $atendimento = $api->post("jpms/atendimento/periodo/cid", $dadosForm);
               //dd($atendimento);
               $response = $api->converteStringJson($atendimento);
               if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            return $response;                      
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
        
        
    } 
     ?>