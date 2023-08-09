<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use DB;
    use Modules\rh\Entities\Funcionario;
    use Modules\Api\Services\UnidadeSErvice;
    use Illuminate\Database\Query\Builder;
    use Exception;
    use App\utis\ApiRestGeneric;
    use App\utis\LengthAwarePaginatorConverter;
    use App\Utis\Msg;
    use Request;
    use Auth;

class PolicialService  extends Controller 
{

    
    public function getEfetivoGeral($renderizacao,$status){
        try{
            if($status != 'ativo' && $status != 'inativo'){
                throw new Exception(Msg::STATUS_INVALIDO);
            }                
            $api = new ApiRestGeneric();
            if($renderizacao == 'listagem'){
                $request = $api->get("policiais/efetivogeral/listagem/".$status."/paginado?".Request::getQueryString());
            }else{
                $request = $api->get("policiais/efetivogeral/listagem/".$status);

            }
            $policiais = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($policiais->retorno)){
                if($policiais->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($policiais->msg);
                }
            }
            if($renderizacao == 'listagem'){
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiais, url()->current());
            return $paginator;
            }
            return $policiais; 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }



    //Autor: @juanmojica
    //Busca policiais ativos ou inativos
    //Requer o status
    public function getPoliciaisPorUnidade($status){
        try{
            if($status != 'ativo' && $status != 'inativo'){
                throw new Exception(Msg::STATUS_INVALIDO);
            }                
            $api = new ApiRestGeneric();

            $policial = auth()->user();
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            
            $request = $api->get("policiais/".$status."/unidade/".$policial->ce_unidade."/paginado?".Request::getQueryString());
            $policiais = $api->converteStringJson($request);
            
            //Verifica se houve erro na requisição
            if(isset($policiais->retorno)){
                if($policiais->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($policiais->msg);
                }
            }
            
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiais, url()->current());
            return $paginator; 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    //Autor: @medeiros
    //Busca policiais ativos ou inativos de uma unidade e suas subordinadas
    //Requer o status
    public function getPoliciaisPorUnidadeEUnidadeSubordinadas($status){
        try{
            if($status != 'ativo' && $status != 'inativo'){
                throw new Exception(Msg::STATUS_INVALIDO);
            }
          
            $api = new ApiRestGeneric();

            /* //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request); */
            $policial = auth()->user();
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            /* $unidade = new UnidadeSErvice();
            $unidadesFilhas = $unidade->getunidadesfilhas($policial->ce_unidade); */
            $unidadesFilhas = $policial->unidadesvinculadas;
            if(count( $unidadesFilhas) < 1){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $request = $api->post("policiais/".$status."/unidade/paginado?".Request::getQueryString(), $unidadesFilhas );
          
            $policiais = $api->converteStringJson($request);
            
            //Verifica se houve erro na requisição
            if(isset($policiais->retorno)){
                if($policiais->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($policiais->msg);
                }
            }
            
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($policiais, url()->current());
            return $paginator; 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    //Autor: @medeiros
    //Busca policiais ativos ou inativos de uma unidade e suas subordinadas
    //Requer o status
    public function geraPdfExcelPoliciaisPorUnidadeSubordinadas($status){
        try{
            if($status != 'ativo' && $status != 'inativo'){
                throw new Exception(Msg::STATUS_INVALIDO);
            }
            $api = new ApiRestGeneric();

            //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $unidade = new UnidadeSErvice();
            $unidadesFilhas = $unidade->getunidadesfilhas($policial->ce_unidade);
            if(count( $unidadesFilhas) < 1){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $request = $api->post("policiais/".$status."/unidade".Request::getQueryString(), $unidadesFilhas );
          
            $policiais = $api->converteStringJson($request);
            
            //Verifica se houve erro na requisição
            if(isset($policiais->retorno)){
                if($policiais->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($policiais->msg);
                }
            }
            
          return $policiais;      
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    //Autor: @medeiros
    //Busca policiais  uma unidade e suas subordinadas com seus respectivos perfis (permissões)
    //Requer o status
    public function getPolicialUnidadeEUnidadeSubordinadasPerfis($idUnidadePai){
        try{
            $api = new ApiRestGeneric();

            //resgata um policial pelo CPF
          /*   $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            } */
            $unidade = new UnidadeSErvice();
            $unidadesFilhas = $unidade->getunidadesfilhas($idUnidadePai);
            if(count( $unidadesFilhas) < 1){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
         //   dd()
           // dd($unidadesFilhas);
            $request = $api->post("policiais/unidade/perfis", $unidadesFilhas );
           // dd( $request);
            $policiais = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($policiais->retorno)){
                if($policiais->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($policiais->msg);
                }
            }
            
          return $policiais;      
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }


    //Autor: @juanmojica
    //Busca policiais ativos ou inativos
    //Requer o status e o tipo de renderização
    //O status deve ser ativo ou inativo - A renderização dever ser "excel" ou "pdf"
    public function geraPdfExcelPoliciaisPorUnidade($status, $renderizacao){
        try{
            if($status != 'ativo' && $status != 'inativo'){
                throw new Exception(Msg::STATUS_INVALIDO);
            }                
            $api = new ApiRestGeneric();

            //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }

            //Verifica o tipo de renderização
            if($renderizacao == 'excel' || $renderizacao == 'pdf'){
                $request = $api->get("policiais/".$status."/unidade/".$policial->ce_unidade);
                $policiais = $api->converteStringJson($request);                    
            }else{
                throw new Exception(Msg::PARAMETRO_INVALIDOS);
            }

            //Verifica se houve erro na requisição
            if(isset($policiais->retorno)){
                if($policiais->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($policiais->msg);
                }
            }
            
            return $policiais;
                                    
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

/**
 * @author falecomjazon@gmail.com
 * @date 19/03/2020
 * utilizado pelo módulo junta médica para pesquisar um policial
 */
        public function findPolicialNomeMatriculaCpf($parametro){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("policiais/consultarpornomecpfmatricula/".str_replace(' ', '%20', $parametro));
                $objeto = json_decode($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return Msg::NENHUM_RESULTADO_ENCONTRADO;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }
        public function findPolicialByCpfMatricula($parametro){
            try{
                $api = new ApiRestGeneric();
                // Requisição para API
                $request = $api->get("policiais/matricula-cpf/".str_replace(' ', '%20', $parametro));
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return Msg::NENHUM_RESULTADO_ENCONTRADO;
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }
        

        /* 
        Autor: @aggeu. 
        Issue 179 Consultar policial. 
        Busca funcionários por nome, cpf ou matrícula.
        */
        public function buscaPolicialNomeCpfMatricula($parametro) {
            try{
                //solução para resolver o problema de envio de espaço na url das requisições get
              $valor = str_replace(" ", "@", $parametro);
              $valor = urlencode($valor);
     
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/consultarpornomecpfmatricula/".$valor);
                $response = $api->converteStringJson($request);
        
                if(isset($response->retorno)){
                    if($response->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($response->msg);
                    }
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        //Autor: @juanmojica
        //Atualiza o policial 
        //Requer o id, status e unidade do policial
        public function atualizaDadosPessoais($idPolicial, $dados){
            try{     
                                         
                $api = new ApiRestGeneric();
                //Atualiza os dados do policial
                $request = $api->put("policiais/".$idPolicial, $dados);
             
                $response = $api->converteStringJson($request);
                
                //Verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        //Autor: @medeiros
        //Cadastra um novo policial 
      
        public function cadastraPolicial( $dados){
            try{                               
                $api = new ApiRestGeneric();
                //Atualiza os dados do policial
                $request = $api->post("policiais/cadastra/novo", $dados);
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

       
        // Busca funcionários apenas por cpf
        // Entrada - input de cpf
        // Saída - o primeiro funcionário com o cpf passado
            public function buscaPolicialCpf($cpf) {
                //dd($cpf);
                try{
                    $api = new ApiRestGeneric();
                    //dd('ops');
                    $request = $api->get("policiais/matricula-cpf/".$cpf);
                   // dd($request);
                    $response = $api->converteStringJson($request);
                    if(isset($response->retorno)){
                        throw new Exception($response->msg);
                    }
                    return $response;
                } catch(Exception $e){
                    throw new Exception($e->getMessage());
                }
            }

            public function findPolicialById($idPolicial) {
                try{
                    $api = new ApiRestGeneric();
                    $request = $api->get("policiais/".$idPolicial);
                    $response = $api->converteStringJson($request);
                    if(isset($response->retorno)){
                        throw new Exception($response->msg);
                    }
                    return $response;
                } catch(Exception $e){
                    throw new Exception($e->getMessage());
                }
            }

    //Autor: @medeiros
    //Lista movimentaçoes dos policias
    //Requer o id do policial
    public function listaMovimentacoesDoPolicial($idPolicial){
        try{                
            $api = new ApiRestGeneric();
            $request = $api->get("policiais/".$idPolicial."/movimentacoes/listagem");
            $movimentacoes = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($movimentacoes->retorno)){
                if($movimentacoes->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($movimentacoes->msg);
                }
            }
            return $movimentacoes;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    /*Autor: @medeiros. 
    Cadastra uma nova movimentaçao do policial
    */
    public function cadastraMovimentacao($idPolicial, $dados){
        try{   
            $api = new ApiRestGeneric();
            $cadastra = $api->post("policiais/".$idPolicial."/movimentacao/cadastra", $dados);
            $response = $api->converteStringJson($cadastra);
            if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }
    /*Autor: @medeiros. 
    recuper uma nova movimentaçao policial pelo id
    */
    public function findMovimentacaoPolicialByid($idMovimentacao){
        try{   
            $api = new ApiRestGeneric();
            $movimentacao = $api->get("policiais/movimentacao/".$idMovimentacao."/consultar");
            $response = $api->converteStringJson($movimentacao);
            if(isset($response->retorno)){
                    throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

       //Edita uma publicação de um policial
    //Retorna um objeto Publicação
    public function editaMovimentacao($idPolicial, $idMovimentacao, $dados){
        
        try{
            $api = new ApiRestGeneric();
            $edita = $api->put("policiais/".$idPolicial."/movimentacao/".$idMovimentacao."/edita", $dados);
            $response = $api->converteStringJson($edita);
            if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }
    
    //exclui uma publicação de um policial
    //Retorna mensagem de sucesso ou de erro
    public function excluiMovimentacao($idPolicial, $idMovimentacao){
        
        try{
            $api = new ApiRestGeneric();
            $exclui = $api->delete("policiais/".$idPolicial."/movimentacao/".$idMovimentacao."/exclui");
            $response = $api->converteStringJson($exclui);
            if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }


    //Autor: @juanmojica
    //Lista publicações dos policias
    //Requer o id do policial
    public function listaPublicacoesDoPolicial($idPolicial){
        try{                
            $api = new ApiRestGeneric();
            $request = $api->get("policiais/".$idPolicial."/publicacoes/listagem");
            $publicacoes = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($publicacoes->retorno)){
                if($publicacoes->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($publicacoes->msg);
                }
            }
            return $publicacoes;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    //Autor: @juanmojica
    //Busca um objeto Publicação pelo Id e o retorna
    public function findPublicacaoById($idPolicial, $idPublicacao){
        try{
            $api = new ApiRestGeneric();
           
            $publicacao = $api->get("policiais/".$idPolicial."/publicacao/".$idPublicacao);
            $response = $api->converteStringJson($publicacao);
            if(isset($response->retorno)){
                throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }


    /*Autor: @juanmojica. 
    Cadastra uma nova publicação do policial
    */
    public function cadastraPublicacao($idPolicial, $dados){
        try{
            $api = new ApiRestGeneric();
            $cadastra = $api->post("policiais/".$idPolicial."/publicacao/cadastra", $dados);
            $response = $api->converteStringJson($cadastra);
            if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    //Edita uma publicação de um policial
    //Retorna um objeto Publicação
    public function editaPublicacao($idPolicial, $idPublicacao, $dados){
        
        try{
            $api = new ApiRestGeneric();
            $edita = $api->put("policiais/".$idPolicial."/publicacao/".$idPublicacao."/edita", $dados);
            $response = $api->converteStringJson($edita);
            if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    //Autor: @juanmojica
    //Deleta uma publicação de um policial
    public function deletaPublicacao($idPolicial, $idPublicacao){
        try{
            $api = new ApiRestGeneric();
            $deleta = $api->delete("policiais/".$idPolicial."/publicacao/".$idPublicacao.'/deleta');
            $response = $api->converteStringJson($deleta);
            if($response->retorno != 'sucesso'){
                throw new Exception($response->msg);
            }
            return $response;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    //Autor: @juanmojica
    //Lista os policias de férias ativas
    //A renderização dever ser "listagem", "excel" ou "pdf"
    public function listaFeriasAtivas(){
        try{              
            $api = new ApiRestGeneric();

            //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $request = $api->get("ferias/corrente/unidade/".$policial->ce_unidade."/paginado?".Request::getQueryString());
            $ferias = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($ferias->retorno)){
                if($ferias->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($ferias->msg);
                }
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($ferias, url()->current());
            return $paginator; 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    

    /* Autor: @aggeu. Issue 201, Listar Licenças Ativas por unidade. */
    public function listaLicencasAtivas(){
        try{              
            $api = new ApiRestGeneric();

            //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $request = $api->get("licencas/corrente/unidade/".$policial->ce_unidade."/paginado?".Request::getQueryString());
            $licencas = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($licencas->retorno)){
                if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($licencas->msg);
                }
            }
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($licencas, url()->current());
            return $paginator; 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    /* Autor: @medeiros. Issue 298, Listar Licenças Ativas por unidades subordinadas. */
    public function listaLicencaPorUnidadeEperiodo($dados, $renderizacao){
        try{              
            $api = new ApiRestGeneric();
            //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            if($renderizacao == 'paginado'){
                $request = $api->post("licencas/periodo/unidade/paginado?".Request::getQueryString(), $dados);
            }else{
                $request = $api->post("licencas/periodo/unidade", $dados);

            }
            $licencas = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($licencas->retorno)){
                if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($licencas->msg);
                }
            }
            if($renderizacao == 'paginado'){
              //return  $licencas;
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($licencas, url()->current());
            return $paginator;
            }else{
                return  $licencas;
            } 
                                         
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

    /* Autor: @aggeu. Issue 207, Implementar listagem de ferias e licença para os proximos quinze dias (Tela home). */
    public function listaFeriasLicencas15Dias($idUnidade){
        try{              
            $api = new ApiRestGeneric();
            $request = $api->get("rh/feriaselicencas/unidade/".$idUnidade);
            $response = $api->converteStringJson($request);
            if(isset($response->retorno)){
                if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
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

    //Autor: @juanmojica
    //Lista os policias de férias ativas não paginado
    public function geraPdfExcelFeriasAtivas($renderizacao){
        try{              
            $api = new ApiRestGeneric();

            //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);
            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }

            //Verifica o tipo de renderização
            if($renderizacao == 'excel' || $renderizacao == 'pdf'){
                $request = $api->get("ferias/corrente/unidade/".$policial->ce_unidade);
                $ferias = $api->converteStringJson($request);                    
            }else{
                throw new Exception(Msg::PARAMETRO_INVALIDOS);
            }           
            
            //Verifica se houve erro na requisição
            if(isset($ferias->retorno)){
                if($ferias->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($ferias->msg);
                }
            } 
            return $ferias;                            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    
    /* Autor: @aggeu. Issue 201, Listar Licenças Ativas por unidade. */
    public function geraPdfExcelLicencasAtivas($renderizacao){
        try{              
            $api = new ApiRestGeneric();
            //resgata um policial pelo CPF
            $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            // Requisição para API
            $request = $api->get("policiais/matricula-cpf/".$cpf);
            $policial = $api->converteStringJson($request);

            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            
            //Verifica o tipo de renderização
            if($renderizacao == 'excel' || $renderizacao == 'pdf'){
                $request = $api->get("licencas/corrente/unidade/".$policial->ce_unidade);
                $licencas = $api->converteStringJson($request);                    
            }else{
                throw new Exception(Msg::PARAMETRO_INVALIDOS);
            }           
            
            //Verifica se houve erro na requisição
            if(isset($licencas->retorno)){
                if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($licencas->msg);
                }
            } 
            return $licencas;                            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    
    //autor: @juanmojica
    //busca um array multidimensional com os dados da Caderneta de Registro do policial
    //Requer o id do policial
    public function geraCadernetaDeRegistroPdf($idPolicial){
        try {
            $api = new ApiRestGeneric(); 
            // Requisição para API
            $request = $api->get("policiais/".$idPolicial."/cadernetaregistro");
            $cadernetaRegistro = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($cadernetaRegistro->retorno)){
                if($cadernetaRegistro->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($cadernetaRegistro->msg);
                }
            } 

            return $cadernetaRegistro;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    //autor: @medeiros
    //busca um array multidimensional com os dados da ficha disciplinar do policial
    //Requer o id do policial
    public function geraFichaDisciplinar($idPolicial){
        try {
            $api = new ApiRestGeneric(); 
            // Requisição para API
            $request = $api->get("policiais/".$idPolicial."/fichadisciplinar");
            $fichaDisciplinar = $api->converteStringJson($request);
            //Verifica se houve erro na requisição
            if(isset($fichaDisciplinar->retorno)){
                if($fichaDisciplinar->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($fichaDisciplinar->msg);
                }
            } 

            return $fichaDisciplinar;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }



    /* Autor: @medeiros. Issue 277 */
    public function listaMedalhasPorUnidade(){
        try{ 
            $api = new ApiRestGeneric();
            
            $policial = auth()->user();

            if(empty($policial->ce_unidade)){
                throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
            }
            $dados['ce_unidade'] = [$policial->ce_unidade];
            $request = $api->post("medalhas/unidade/paginado?".Request::getQueryString(), $dados);
            $medalhas = $api->converteStringJson($request); 
           
            //Verifica se houve erro na requisição
            if(isset($medalhas->retorno)){
                if($medalhas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                    return [];
                }else{
                    throw new Exception($medalhas->msg);
                }
            } 
            $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($medalhas, url()->current());
            return $paginator;                            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }
    /* Autor: @medeiros. Issue 277 */
    public function listaMedalhasPorVariasUnidades($dados, $renderizacao){
        try{ 
            $api = new ApiRestGeneric();
            if($renderizacao != 'excel'){
               
                $request = $api->post("medalhas/unidade/paginado?".Request::getQueryString(), $dados);
                $medalhasPaginadas = $api->converteStringJson($request); 
                //Verifica se houve erro na requisição
                if(isset($medalhasPaginadas->retorno)){
                    if($medalhasPaginadas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        return [];
                    }else{
                        throw new Exception($medalhasPaginadas->msg);
                    }
                }
                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($medalhasPaginadas, url()->current());
                return $paginator; 
                                             
            }else{
                $request = $api->post("medalhas/unidade?".Request::getQueryString(), $dados);
                $medalhas = $api->converteStringJson($request); 
                //Verifica se houve erro na requisição
                if(isset($medalhas->retorno)){
                    
                        throw new Exception($medalhas->msg);
                }
                return $medalhas;
            }
                                       
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }         
    }

  
   
    

























        // FUNÇÕES PARA LISTAGEM DE FUNCIONÁRIOS ATIVOS

            // Busca todos os funcionários ativos e seus respectivos orgãos e setores
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores - com paginação
            public function listafuncionariosativos(){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)->paginate(30);
                return $funcionarios;
            }

            // Busca todos os funcionários ativos e seus respectivos orgãos e setores
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores
            public function listafuncionariosativospdf(){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)->get();
                return $funcionarios;
            }

            // Busca todos os funcionários ativos e seus respectivos orgãos, setores, gratificações, funções e graduações
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos, st_sigla de setores, st_nomedagratificacao de gratificações, st_nomedafuncao de funções e st_postograduacao de graduações
            public function listafuncionariosativosexcel(){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionariosexcel(), 1)->get();
                return $funcionarios;
            }

            // Busca todos os funcionários ativos, com filtro de orgao ou setor, e seus respectivos orgãos e setores
            // Entrada - $filtro é o nome da coluna e $valor é o valor a ser buscado
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores  - com paginação
            public function listafuncionariosativoscomfiltro($filtro, $valor){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)->where('funcionarios.'.$filtro, $valor)->paginate(30);
                return $funcionarios;
            }
            
            // Busca todos os funcionários ativos, com filtro de orgao ou setor, e seus respectivos orgãos e setores
            // Entrada - $filtro é o nome da coluna e $valor é o valor a ser buscado
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores
            public function listafuncionariosativoscomfiltropdf($filtro, $valor){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)->where('funcionarios.'.$filtro, $valor)->get();
                return $funcionarios;
            }

            // Busca todos os funcionários ativos, com filtro de orgao ou setor, e seus respectivos orgãos, setores, gratificações, funções e graduações
            // Entrada - $filtro é o nome da coluna e $valor é o valor a ser buscado
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos, st_sigla de setores, st_nomedagratificacao de gratificações, st_nomedafuncao de funções e st_postograduacao de graduações
            public function listafuncionariosativoscomfiltroexcel($filtro, $valor){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionariosexcel(), 1)->where('funcionarios.'.$filtro, $valor)->get();
                return $funcionarios;
            }

        // FUNÇÕES PARA LISTAGEM DE FUNCIONÁRIOS INATIVOS

            // Busca todos os funcionários inativos e seus respectivos orgãos e setores
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores - com paginação
            public function listafuncionariosinativos(){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 0)->paginate(30);
                return $funcionarios;
            }

            // Busca todos os funcionários inativos e seus respectivos orgãos e setores
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores
            public function listafuncionariosinativospdf(){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 0)->get();
                return $funcionarios;
            }

            // Busca todos os funcionários inativos e seus respectivos orgãos, setores, gratificações, funções e graduações
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos, st_sigla de setores, st_nomedagratificacao de gratificações, st_nomedafuncao de funções e st_postograduacao de graduações
            public function listafuncionariosinativosexcel(){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionariosexcel(), 0)->get();
                return $funcionarios;
            }

            // Busca todos os funcionários inativos, com filtro de orgao ou setor, e seus respectivos orgãos e setores
            // Entrada - $filtro é o nome da coluna e $valor é o valor a ser buscado
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores  - com paginação
            public function listafuncionariosinativoscomfiltro($filtro, $valor){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 0)->where('funcionarios.'.$filtro, $valor)->paginate(30);
                return $funcionarios;
            }
            
            // Busca todos os funcionários inativos, com filtro de orgao ou setor, e seus respectivos orgãos e setores
            // Entrada - $filtro é o nome da coluna e $valor é o valor a ser buscado
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores
            public function listafuncionariosinativoscomfiltropdf($filtro, $valor){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 0)->where('funcionarios.'.$filtro, $valor)->get();
                return $funcionarios;
            }

            // Busca todos os funcionários inativos, com filtro de orgao ou setor, e seus respectivos orgãos, setores, gratificações, funções e graduações
            // Entrada - $filtro é o nome da coluna e $valor é o valor a ser buscado
            // Saída - lista todos os campos de funcionário, st_sigla de orgaos, st_sigla de setores, st_nomedagratificacao de gratificações, st_nomedafuncao de funções e st_postograduacao de graduações
            public function listafuncionariosinativoscomfiltroexcel($filtro, $valor){
                $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionariosexcel(), 0)->where('funcionarios.'.$filtro, $valor)->get();
                return $funcionarios;
            }

        // Query para listar os funcionários e seus respectivos orgãos e setores
        // Saída - retorna Builder com tabela de funcionários, nome do orgão e nome do setor
        private function querylistafuncionarios(){
            $funcionarios = DB::table('funcionarios')->orderby('funcionarios.st_nome')
                            ->leftjoin('orgaos', 'orgaos.id', 'funcionarios.ce_orgao')
                            ->leftjoin('setores', 'setores.id', 'funcionarios.ce_setor')
                            ->select('funcionarios.*', 'orgaos.st_sigla as st_siglaorgao', 'setores.st_sigla as st_siglasetor');
            return $funcionarios;
        }
        
        // Query para listar os funcionários e seus respectivos orgãos, setores, funcoes, graduacoes e gratificacoes
        // Saída - retorna Builder com tabela de funcionários, nome do orgão, nome do setor, nome da gratificação, nome da função e nome das graduações
        private function querylistafuncionariosexcel(){
            $funcionarios = DB::table('funcionarios')->orderby('funcionarios.st_nome')
                            ->leftjoin('orgaos', 'orgaos.id', 'funcionarios.ce_orgao')
                            ->leftjoin('setores', 'setores.id', 'funcionarios.ce_setor')
                            ->leftjoin('gratificacoes', 'gratificacoes.id', 'funcionarios.ce_gratificacao')
                            ->leftjoin('funcoes', 'funcoes.id', 'funcionarios.ce_funcao')
                            ->leftjoin('graduacoes', 'graduacoes.id', 'funcionarios.ce_graduacao')
                            ->select('funcionarios.*', 'orgaos.st_sigla as st_siglaorgao', 'setores.st_sigla as st_siglasetor', 'gratificacoes.st_gratificacao as st_nomedagratificacao','funcoes.st_funcao as st_nomedafuncao', 'graduacoes.st_postograduacao');
            return $funcionarios;
        }

        // Query para listar os funcionários ativos ou inativos
        // Entrada - Builder com outros parametros de pesquisa e valor do bo_ativo que deve ser 0 ou 1
        // Saída - retorna Builder com tabela de funcionários, nome do orgão e nome do setor
        private function querylistafuncionariosbo(Builder $builder, $bo){
            $funcionarios = $builder->where('funcionarios.bo_ativo', $bo);
            return $funcionarios;
        }

        // Busca todos os funcionários que fazem aniversário no mês correspondente
        // Entrada - Valor entre 1 e 12, correspondente aos meses do ano
        // Saída - Lista o nome do funcionário, graduação, mês e dia de aniversário, e o setor
        public function aniversariantes($mes){
            $funcionarios = DB::select(
                DB::raw("SELECT st_nome, DATEPART(day, funcionarios.dt_nascimento) AS dia, DATEPART(month, funcionarios.dt_nascimento) AS mes, st_postograduacao, st_sigla
                        FROM funcionarios
                        JOIN graduacoes ON funcionarios.ce_graduacao = graduacoes.id
                        JOIN setores ON funcionarios.ce_setor = setores.id
                        WHERE MONTH(dt_nascimento) = $mes
                        ORDER BY dia ASC")
            );
            return $funcionarios;
        }

        // Busca funcionário pelo id
        // Entrada - valor do id
        // Saída - Funcionário com o id correspondente ou false caso não exista
        public function buscafuncionarioid($id){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$id);
                $objeto = $api->converteStringJson($request);
                //Verificação se houve erro na requisição
                if(isset($objeto->retorno)){
                    if($objeto->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
                        throw new Exception(Msg::ATIVIDADE_NAO_ENCONTRADA);
                    }else{
                        throw new Exception($objeto->msg);
                    }
                }
                return $objeto;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        // Cria funcionário com dados que recebe
        // Entrada - dados do form
        // Saída - true ou false
        public function criafuncionario($dados){
            $funcionarios = Funcionario::create($dados);
            return $funcionarios;
        }

        // Atualiza funcionário com dados que recebe
        // Entrada - dados do form e o objeto funcionário
        // Saída - true ou false
        public function atualizafuncionario(Funcionario $funcionario, $dados){
            $update = $funcionario->update($dados);
            return $update;
        }

        /* 
        Autor: @aggeu. 
        Issue 184, Editar dados funcionais.
        Função que atualiza dados funcionais do policial. 
        */
        public function atualizaPolicialDadosFuncionais($policial, $dadosForm){
            try{
                
                $api = new ApiRestGeneric();
                $update = $api->put("policiais/".$policial->id, $dadosForm);
                
                $response = $api->converteStringJson($update);
               
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /* 
        Autor: @aggeu. 
        Issue 188, Editar documentos do policial. 
        Função que atualiza documentos do policial. 
        */
        public function atualizaPolicialDocumentos($policial, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $update = $api->put("policiais/".$policial->id, $dadosForm);
                $response = $api->converteStringJson($update);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }


    // Atualiza caminho da foto do funcionário com dados que recebe
    // Entrada - caminho da foto e o objeto funcionário
    // Saída - true ou false
    public function atualizafuncionariofoto(Funcionario $funcionario, $foto){
        $update = $funcionario->update(['st_caminhofoto' => $foto]);
        return $update;
    }
        // Lista os cursos que não são academicos do policial
        // Saída - lista de cursos
        public function listaCursosPolicial($idPolicial){
           
            try{
                $api = new ApiRestGeneric();
                $update = $api->get("policiais/".$idPolicial."/cursos");
                $response = $api->converteStringJson($update);
                if(isset($response->retorno) ){
                    if($response->msg == MSG::NENHUM_RESULTADO_ENCONTRADO){
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

        // Lista os cursos que não são academicos do policial
        // Saída - lista de cursos
        public function cadastrarCurso($idPolicial, $dados){
           
            try{
              
                $api = new ApiRestGeneric();
                $cadastra = $api->post("policiais/".$idPolicial."/cadastra/curso", $dados);
                $response = $api->converteStringJson($cadastra);
                if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }

       // edita um curso de um policial
        
        public function EditaCurso($idPolicial, $idcurso, $dados){
           
            try{
                $api = new ApiRestGeneric();
                $edita = $api->put("policiais/".$idPolicial."/edita/curso/".$idcurso, $dados);
                $response = $api->converteStringJson($edita);
                if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }

        // Exclui um curso de um policial
        
        public function deletaCurso($idPolicial, $idcurso){
           
            try{
                
                $api = new ApiRestGeneric();
                $deleta = $api->delete("policiais/".$idPolicial."/curso/".$idcurso.'/deleta');
                $response = $api->converteStringJson($deleta);
                if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }


        // Recupera um curso especifico de um policial
        // Saída - Objeto do tipo curso
        public function findCursoPolicialByid($idPolicial, $idCurso){
           
            try{
                $api = new ApiRestGeneric();
                $curso = $api->get("policiais/".$idPolicial."/curso/".$idCurso);
                $response = $api->converteStringJson($curso);
                if(isset($response->retorno) ){
                    throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }

        

// author: alexia tuane
//issue: 317 - criar sumario

public function PoliciaisPorUnidade($idUnidade){
   
    try{  
       $api = new ApiRestGeneric();
        $policiaisagrupados = $api->get("policiais/quantitativo/graduacao/unidade/".$idUnidade);
        $response = $api->converteStringJson( $policiaisagrupados);
        if(isset($response->retorno)){
            if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
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
        
public function  ListaPoliciaisPorUnidade($idGraducao, $idUnidade){

  try{  
                $api = new ApiRestGeneric();
                $policiais = $api->get("policiais/quantitativo/graduacao/".$idGraducao."/unidade/".$idUnidade);
               //dd($policiais);
                $response = $api->converteStringJson( $policiais);
                if(isset($response->retorno)){
                    if($licencas->msg == Msg::NENHUM_RESULTADO_ENCONTRADO){
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



        // Seleciona a quantidade de funcionários por órgãos
        // Saída - id e st_sigla dos orgaos ativos e quantidade de funcionarios ativos, em cada orgao
        public function funcionariospororgao(){
            $orgaos = DB::table('funcionarios as f')
                        ->select('o.st_sigla', 'o.id', DB::raw('COUNT(f.id) as qtde'))
                        ->leftjoin('orgaos as o', 'o.id', 'f.ce_orgao')
                        ->where([['f.bo_ativo', '1'],['o.bo_ativo', '1']])
                        ->groupby('o.id', 'o.st_sigla')
                        ->orderby('qtde', 'desc')->get();
            return $orgaos;
        }

        // Seleciona a quantidade de funcionários por status
        // Saída - id e st_status dos status ativos e quantidade de funcionarios ativos, em cada status
        public function funcionariosporstatus(){
            $status = DB::table('funcionarios as f')
                        ->select('s.st_status', 's.id', DB::raw('COUNT(f.id) as qtde'))
                        ->leftjoin('statusfuncoes as s', 's.id', 'f.ce_status')
                        ->where([['f.bo_ativo', '1'],['s.bo_ativo', '1']])
                        ->groupby('s.id', 's.st_status')
                        ->orderby('qtde', 'desc')->get();
            return $status;
        }

        // Seleciona a quantidade de funcionários por graduação
        // Saída - id e st_postograduacao das graduações ativas e quantidade de funcionarios ativos, em cada graduação
        public function funcionariosporgraduacoes(){
            $graduacoes = DB::table('funcionarios as f')
                        ->select('g.st_postograduacao', 'g.id', DB::raw('COUNT(f.id) as qtde'))
                        ->leftjoin('graduacoes as g', 'g.id', 'f.ce_graduacao')
                        ->where('f.bo_ativo', '1')
                        ->groupby('g.id', 'g.st_postograduacao')
                        ->orderby('qtde', 'desc')->get();
            return $graduacoes;
        }

        // Seleciona a quantidade de funcionários por funções
        // Saída - id e st_funcao das funções ativas e quantidade de funcionarios ativos, em cada função
        public function funcionariosporfuncao(){
            $funcoes = DB::table('funcionarios as f')
                        ->select('a.st_funcao', 'a.id', DB::raw('COUNT(f.id) as qtde'))
                        ->leftjoin('funcoes as a', 'a.id', 'f.ce_funcao')
                        ->where([['f.bo_ativo', '1'],['a.bo_ativo', '1']])
                        ->groupby('a.id', 'a.st_funcao')
                        ->orderby('qtde', 'desc')->get();
            return $funcoes;
        }

        // Seleciona a quantidade de funcionários por cargos
        // Saída - id e st_cargo das funções ativas e quantidade de funcionarios ativos, em cada cargo
        public function funcionariosporcargo(){
            $cargos = DB::table('funcionarios as f')
                        ->select('c.st_cargo', 'c.id', DB::raw('COUNT(f.id) as qtde'))
                        ->leftjoin('cargos as c', 'c.id', 'f.ce_cargo')
                        ->where([['f.bo_ativo', '1'],['c.bo_ativo', '1']])
                        ->groupby('c.id', 'c.st_cargo')
                        ->orderby('qtde', 'desc')->get();
            return $cargos;
        }

        // Seleciona funcionários ativos ordenados por idade
        // Saída - todos os campos dos funcionários
        public function funcionariosporidade(){
            $funcionarios = Funcionario::where('bo_ativo',  '1')->orderby('dt_nascimento')->paginate('30');
            return $funcionarios;
        }

        // Busca todos os funcionários ativos do órgão desejado
        // Entrada - id do orgao desejado
        // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores - com paginação
        public function listafuncionariosdoorgao($id){
            $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)
                            ->where('funcionarios.ce_orgao', $id)
                            ->paginate(30);
            return $funcionarios;
        }

        // Busca todos os funcionários ativos que exercem a função desejada
        // Entrada - id da função desejada
        // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores - com paginação
        public function listafuncionariosdafuncao($id){
            $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)
                            ->where('funcionarios.ce_funcao', $id)
                            ->paginate(30);
            return $funcionarios;
        }

        // Busca todos os funcionários ativos que tem a graduação desejada
        // Entrada - id da graduação desejada
        // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores - com paginação
        public function listafuncionariosdagraduacao($id){
            $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)
                            ->where('funcionarios.ce_graduacao', $id)
                            ->paginate(30);
            return $funcionarios;
        }

        // Busca todos os funcionários ativos que tem o status desejado
        // Entrada - id do status desejado
        // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores - com paginação
        public function listafuncionariosdostatus($id){
            $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)
                            ->where('funcionarios.ce_status', $id)
                            ->paginate(30);
            return $funcionarios;
        }

        // Busca todos os funcionários ativos que tem o cargo desejado
        // Entrada - id do cargo desejado
        // Saída - lista todos os campos de funcionário, st_sigla de orgaos e st_sigla de setores - com paginação
        public function listafuncionariosdocargo($id){
            $funcionarios = $this->querylistafuncionariosbo($this->querylistafuncionarios(), 1)
                            ->where('funcionarios.ce_cargo', $id)
                            ->paginate(30);
            return $funcionarios;
        }

        // Busca o funcionário que irá exibir na ficha pessoal
        // Entrada - id do funcionário desejado
        // Saída - lista todos os campos de funcionário, st_sigla de orgaos, st_sigla de setores, st_funcao de funções, st_postograduacao de graduações e st_gratificacao de gratificações
        public function funcionarioficha($id){
            $funcionario = DB::table('funcionarios')->where('funcionarios.id', $id)
                            ->leftjoin('setores', 'setores.id', 'funcionarios.ce_setor')
                            ->leftjoin('funcoes', 'funcoes.id', 'funcionarios.ce_funcao')
                            ->leftjoin('graduacoes', 'graduacoes.id', 'funcionarios.ce_graduacao')
                            ->leftjoin('gratificacoes', 'gratificacoes.id', 'funcionarios.ce_gratificacao')
                            ->leftjoin('orgaos', 'orgaos.id', 'funcionarios.ce_orgao')
                            ->select('funcionarios.*', 'setores.st_sigla as st_setor', 'funcoes.st_funcao', 'graduacoes.st_postograduacao', 'gratificacoes.st_gratificacao','orgaos.st_sigla as st_siglaorgao')
                            ->first();
            return $funcionario;
        }

        /**
         *  @author jazon #370
         * lista os policiais ordenados por antiguidade dentro da graduação
         */
        public function getListagemPmsClassificados($idGraducao)
        {
            try{  
                $api = new ApiRestGeneric();
                //http://localhost/sisgpws/api/v1/rh/policiais/classificados/15
                $request = $api->get("rh/policiais/classificados/".$idGraducao);
                //dd($request);
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
         *  @author jazon #370
         * ordena o número de antiguidade de um policial
         */
        public function ordenarAntiguidade($sentido,$idPolicial)
        {
            try{ 
                $api = new ApiRestGeneric();
                //http://localhost/sisgpws/api/v1/rh/policiais/classificados/15
                $request = $api->put("rh/policiais/classificador/ordenar/".$sentido."/".$idPolicial);
               // dd($request);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso' ){
                    throw new Exception($response->msg);
                }
                return $response->msg; 
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            } 
        }

        /*issue:365-criar-aba-dependentes
         * lista dependentes cadastrados
         * Alexia
         */

        public function listaDependente($idPolicial){
            try{
                  
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/dependentes");
             
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
        /*issue:365-criar-aba-dependentes
         * cadastra dependentes
         * Alexia 
         */
        public function cadatrarDependente($idPolicial, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("policiais/".$idPolicial."/dependentes", $dadosForm);
               //dd($request);
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        
        /*issue:365-criar-aba-dependentes
         * edita dependentes
         * Alexia 
         */
        public function editaDependente($idPolicial, $idDependente, $dadosForm){
            try{
                //dd($dadosForm);
                $api = new ApiRestGeneric();
                $request = $api->put("policiais/".$idPolicial."/dependentes/".$idDependente, $dadosForm);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
            }
                return $response->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
    }

    /*issue:365-criar-aba-dependentes
         * retorna dependente por id
         * Alexia 
         */
        public function findDependenteById($idPolicial,$idDependente){
            try{
                  
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/dependente/".$idDependente);
                
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                
                return  $response; 
                                             
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }
        

        /*issue:365-criar-aba-dependentes
         * exclui um dependente
         * Alexia 
         */
        public function excluirDependente($idPolicial, $idDependente, $dadosForm){
            try{
            
                $api = new ApiRestGeneric();
                $request = $api->delete("policiais/".$idPolicial. "/dependentes/" .$idDependente, $dadosForm);
                //dd($request);
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


        /**
         * @author juanmojica - #397
         * @param Integer
         * @return (Lista de objetos para gerar a certidão de tempo de serviço) 
         */
        public function getCertidaoDeTempoDeServico($idPolicial){
            try {
                $api = new ApiRestGeneric(); 
                
                // Requisição para API
                $request = $api->get("policiais/".$idPolicial."/certidao/temposervico");
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

        /*issue:398-criar-aba-comportamento
         * lista comportamento
         * Alexia
        */

        public function listarComportamento($idPolicial){
            try{
                  
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/comportamentos/listagem");
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

        /*issue:398-criar-aba-comportamento
        * cadastra comportamento
        * Alexia 
        */
        public function cadastrarComportamento($idPolicial, $dadosForm){
            try{
              
                $api = new ApiRestGeneric();
                $request = $api->post("policiais/".$idPolicial."/comportamentos/cadastra", $dadosForm);
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        /*issue:398-criar-aba-comportamento
         * retornacomportamento por id
         * Alexia 
         */
        public function findComportamentoById($idPolicial,$idComportamento){
            try{
                  
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/comportamentos/".$idComportamento);
             
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                
                return  $response; 
                                             
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        /** issue:396-criar-crud-de-tempo-de-servico
         * @author Cb Araújo 23-11-2021 => 84-981346783 
         * antigo cadastraTempoServico
         */
        public function salvaTempoServico($idPolicial,$dadosForm) {
            try{
                $api = new ApiRestGeneric();
                //echo $api->showUrl(true);
                $request = $api->post("policiais/".$idPolicial."/temposervico/novo", $dadosForm);
                //dd($request);
                $response = $api->converteStringJson($request);
                //dd($response);
                if(isset($response->retorno)){
                    if($response->retorno == "sucesso"){
                        return $response->msg;
                    } else {
                        throw new Exception($response->msg);
                    }                    
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        public function excluirTempoServico($idPolicial,$idTempoServico,$dadosForm) {
            try{
                $api = new ApiRestGeneric();
                //echo $api->showUrl(true);
                $request = $api->delete("policiais/".$idPolicial."/temposervico/".$idTempoServico, $dadosForm);
                //$request = $api->delete("policiais/1/temposervico/".$idTempoServico, $dadosForm);
                //dd($request);
                $response = $api->converteStringJson($request);
                //dd($response);
                if(isset($response->retorno)){
                    if($response->retorno == "sucesso"){
                        return $response->msg;
                    } else {
                        throw new Exception($response->msg);
                    }                    
                }
                return $response;
            } catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        public function editarComportamento($idPolicial, $idComportamento, $dadosForm){
            try{
                //dd($dadosForm);
                $api = new ApiRestGeneric();
                $request = $api->put("policiais/".$idPolicial."/comportamentos/".$idComportamento."/edita" ,$dadosForm);
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

         /**issue:365-criar-aba-comportamento
         * exclui um comportamento
         * Alexia 
         */
        public function excluirComportamento($idPolicial, $idComportamento, $dadosForm){
            try{
               
                $api = new ApiRestGeneric();
                $request = $api->delete("policiais/".$idPolicial. "/comportamentos/" .$idComportamento, $dadosForm);
                //dd($request);
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

         /**
          * @author @juan_mojica
          * @param Integer
          * @param Array ( dados requisitados pelo serviço da API )
          * @return Array ( retorno e mensagem )
          */
        public function AssinaDocumento($idPolicial, $acao, $dados){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("policiais/$idPolicial/certidao/temposervico/assinatura/$acao", $dados);
                //dd($request);
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

        /**
          * @author @juan_mojica - #410
          * @param Integer
          * @return Object ( regras para a exibição das fichas )
          */
        public function getRegrasFichas($idPolicial){
            try{
                  
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/fichas");
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

        public function atualizarClassificador($dadosForm){
            try {
                $api = new ApiRestGeneric();

                // Requisição para API
                $request = $api->put("rh/policiais/classificador/antiguidade/atualizar",$dadosForm);
                
                //dd($request);
                
                $response = $api->converteStringJson($request);
                //$response = json_decode($request);
                //dd('sedsdrdrdrdre');
                //dd($response);
                //Verificação se houve erro na requisição
                if(isset($response->retorno) && $response->retorno=="erro"){                  
                    throw new Exception($response->msg);
                } 
                //return "lalala";
                return $response->msg;
            }catch(\Exception $e){
                //dd($e);
                throw new Exception($e->getMessage());
            }            
        }  
        
        /**
          * @author @juan_mojica - #428
          * @param Array ( array lotepoliciais[[st_matricula, ce_unidade],[st_matricula, ce_unidade]...] )
          * @return Array ( retorno e mensagem )
          */
          public function movimentaPoliciaisEmLote($dados){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("policiais/movimentacao/lote", $dados);
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

          /**
          * @author @Alexia_Tuane -
          *issue:  #457
          *criar aba procedimentos
          */
        public function listaProcedimentos($idPolicial){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/procedimentos");
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
          * @author @Alexia_Tuane -
          *issue:  #464
          *criar aba pensionistas corrigido*
        */
          public function listarPensionistas($idPolicial){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/pensionistas");
                $response = $api->converteStringJson($request);
                //d($response);
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


        
        /*issue:465 criar-nada-consta
         * lista certidoes
         * Alexia
        */

        public function listarCertidoes($idPolicial){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/certidoes");
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

        /*issue:465 criar-nada-consta
         * recupera notas 
         * Alexia
        */
        public function findCertidaoById($idPolicial,$idCertidao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("policiais/".$idPolicial."/certidoes/".$idCertidao);
                //dd($request);
                $response = $api->converteStringJson($request);
                //dd($response);
                //Verifica se houve erro na requisição
                if(isset($response->retorno)){
                    throw new Exception($response->msg);
                }
                return  $response;                          
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        /*issue:398-criar-aba-comportamento
        * cadastra comportamento
        * Alexia 
        */
        public function cadastrarCertidao($idPolicial, $dadosForm){
            try{
                
                $api = new ApiRestGeneric();
                $request = $api->post("policiais/".$idPolicial."/certidoes", $dadosForm);
                //dd($request);
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }
        public function assinarCertidaoNadaConsta($idPolicial, $idCertidao, $dados){
            try{
                //dd($idCertidao);
                $api = new ApiRestGeneric();
                $request = $api->put("policiais/".$idPolicial."/certidoes/".$idCertidao."/assinar", $dados);
               
                $response = $api->converteStringJson($request);
                //dd($response);
                //verifica se o response vem diferente de sucesso e retorna a msg
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        
        }

        /**
         * @author juanmojica - #488
         * @param string {'paginado' ou 'naopaginado'}
         * @param array {unidades filhas da unidade do perfil logado}
         * @return {Lista de policiais que fizeram o censo religioso}
         */
        public function getPoliciaisCensoReligioso($tipo) {
            try {
                
                $api = new ApiRestGeneric();
                
                $request = $api->get("rh/censoreligioso/censorealizado/policiais/$tipo?".Request::getQueryString());
                $response = $api->converteStringJson($request);
               
                if (isset($response->retorno)) {
                    throw new Exception($response->msg);
                }

                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
                return $paginator; 

            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        
        /**
         * @author juanmojica - #488
         * @param string {'paginado' ou 'naopaginado'}
         * @param array {unidades filhas da unidade do perfil logado}
         * @return {Lista de policiais que fizeram o censo religioso}
         */
        public function getPoliciaisCensoReligiosoUnidadesFilhas($tipo, $dadosForm) {
            try {
                
                $api = new ApiRestGeneric();
                
                $request = $api->get("rh/censoreligioso/censorealizado/unidadesubordinadas/policiais/$tipo?".Request::getQueryString(), $dadosForm);
                $response = $api->converteStringJson($request);
               
                if (isset($response->retorno)) {
                    throw new Exception($response->msg);
                }

                $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
                return $paginator; 

            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        /**
         * @author juanmojica - #488
         * @param string {'paginado' ou 'naopaginado'}
         * @return {Lista de policiais que não fizeram o censo religioso}
         */
        public function getPoliciaisSemCensoReligioso($tipo) {
            try {
                
                $api = new ApiRestGeneric();
               
                $request = $api->post("rh/censoreligioso/censonaorealizado/$tipo?".Request::getQueryString());
                $response = $api->converteStringJson($request);
               
                if (isset($response->retorno)) {
                    throw new Exception($response->msg);
                }

               // $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
                return $response; 

            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        /**
         * @author juanmojica - #488
         * @param string {'paginado' ou 'naopaginado'}
         * @param array {unidades filhas da unidade do perfil logado}
         * @return {Lista de policiais que não fizeram o censo religioso}
         */
        public function getPoliciaisSemCensoReligiosoUnidadesFilhas($tipo, $dadosForm) {
            try {
               
                $api = new ApiRestGeneric();
                
                $request = $api->post("rh/censoreligioso/censonaorealizado/unidadesubordinadas/$tipo?".Request::getQueryString(), $dadosForm);
                $response = $api->converteStringJson($request);
                
                if (isset($response->retorno)) {
                    throw new Exception($response->msg);
                }

               // $paginator = LengthAwarePaginatorConverter::converterJsonToLengthAwarePaginator($response, url()->current());
                return $response; 

            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }


        public function atualizaInatividade($idPolicial, $dadosForm){
            try{     
              //  dd("dfdrvf");                
                $api = new ApiRestGeneric();
                //Atualiza os dados do policial
               // echo $api->showUrl(true);
                $request = $api->put("policiais/".$idPolicial."/dps/aba/inatividade/salvar", $dadosForm);
               // dd($request);
                $response = $api->converteStringJson($request);
               // dd($response);
                
                //Verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }
        /*
        *issue:498 criar-aba-prova-de-vida
         * lista provas de vida
         * Alexia
        */

        public function abaProvadeVida($idPolicial,$tipoDeclaracao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("rh/declaracoes/$idPolicial/$tipoDeclaracao");
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

        /*
            *issue:498 criar-aba-prova-de-vida
            * criar prova de vida
            * Alexia
        */

        public function cadastrarProvadeVida($idPolicial, $tipoDeclaracao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("rh/declaracoes/$idPolicial/$tipoDeclaracao");
               
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }


        /*
            *issue:498 criar-aba-prova-de-vida
            * cadastro de 'pessoa' da prova de vida
            * Alexia
        */
        public function cadastrarPVida($idPolicial,$idDeclaracao,$dadosForm){
            try{
                
                $api = new ApiRestGeneric();
                $request = $api->post("rh/declaracoes/$idPolicial/beneficiarios/$idDeclaracao",$dadosForm);
                $response = $api->converteStringJson($request);
                //Verifica se houve erro na requisição
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                    
                }
                return $response->msg; 
                                     
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

       
        /*
            *issue:498 criar-aba-prova-de-vida
            * lista beneficiarios na blade de cadastro da prova de vida
            * Alexia
        */
        public function listabeneficiariosProvadeVida($idDeclaracao){
            try{
                $api = new ApiRestGeneric();
              $request = $api->get("rh/declaracoes/declaracao/$idDeclaracao/beneficiarios");            
                 $response = $api->converteStringJson($request);
               //fica se houve erro na requisição
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
    
        /*
            *issue:498 criar-aba-prova-de-vida
            * Assina declaração prova de vida
            * Alexia
        */
        public function assinarDeclaracaoProvadeVida($idDeclaracao,$idPolicial,$tipoAssinante){
            try{
                $api = new ApiRestGeneric();
                //dd($tipoAssinante);
                $request = $api->put("rh/declaracoes/$idPolicial/beneficiarios/$idDeclaracao/assinante/$tipoAssinante/assinar");
               //dd($request);
                $response = $api->converteStringJson($request);
                //dd($response);
                //verifica se o response vem diferente de sucesso e retorna a msg
                if($response->retorno != 'sucesso'){
                   
                    throw new Exception($response->msg);
                }
                return $response->msg;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        
        }

        /*
            *issue:498 criar-aba-prova-de-vida
            * recupera os dados de um beneficiario
            * Alexia
        */
        public function getBeneficiarioById($idDeclaracao,$idBeneficiario){
            try{
                $api = new ApiRestGeneric();
              $request = $api->get("rh/declaracoes/declaracao/$idDeclaracao/beneficiario/$idBeneficiario");
              $response = $api->converteStringJson($request);
                // dd($response);
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

        public function AtualizarBeneficiario($idDeclaracao, $idBeneficiario, $idPessoa, $dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("rh/declaracoes/declaracao/$idDeclaracao/beneficiario/$idBeneficiario/pessoa/$idPessoa", $dadosForm);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;   
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
 /*
        branch 496
        cb Araújo
        obs: recupera dados de um beneficiario e da pessoa com base em seu id
        */
        public function editarBeneficiario($idCertidao,$idbeneficiario,$dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("rh/declaracoes/declaracao/$idCertidao/beneficiario/$idbeneficiario", $dadosForm);
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;   
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        public function excluirBeneficiarioProvadeVida($idDeclaracao,$idBeneficiario){
            try{
                $api = new ApiRestGeneric();
                $request = $api->delete("rh/declaracoes/declaracao/$idDeclaracao/beneficiario/$idBeneficiario");
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /*
        branch 498
        Alexia Tuane 
        obs: realiza o upload da declaracao assinada fisicamente pelo responsavel/pm
        */
        public function uploadDeclaracaoAssinada($idDeclaracao,$dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("rh/declaracoes/declaracao/$idDeclaracao/enviarassinaturapm", $dadosForm);
                
                $response = $api->converteStringJson($request);
                //dd($response);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;   
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }
         /*
        branch 498
        Alexia Tuane 
        reabre uma declaração de prova de vida
        */
        public function reabreDeclaracaoProvadeVida($idPolicial,$idDeclaracao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("rh/declaracoes/$idPolicial/beneficiarios/$idDeclaracao/reabrir");
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;   
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        /*
        branch 496
        cb Araújo
        obs: cria declaracao 
        */
        public function criaDeclaracao($idPolicial,$tipoDeclaracao){
            try{     
                $api = new ApiRestGeneric();
                $request = $api->post("rh/declaracoes/$idPolicial/$tipoDeclaracao");
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;                      
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        /*
        branch 496
        cb Araújo
        obs: lista declarações
        */
        public function listaDeclaracoes($idPolicial,$tipoDeclaracao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("rh/declaracoes/$idPolicial/$tipoDeclaracao");
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

        /*
        branch 496
        cb Araújo
        obs: salva beneficiario
        */
        public function salvaBeneficiario($idPolicial,$idCertidao,$dadosForm){
            try{
                $api = new ApiRestGeneric();
                $request = $api->post("rh/declaracoes/$idPolicial/beneficiarios/$idCertidao", $dadosForm);
                $response = $api->converteStringJson($request);
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }         
        }

        /*
        branch 496
        cb Araújo
        obs: lista beneficiarios
        */
        public function listaBeneficiarios($idPolicial,$idDeclaracao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("rh/declaracoes/$idPolicial/beneficiarios/$idDeclaracao");
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

        /*
        branch 496
        cb Araújo
        obs: dados de uma certidao especifica de beneficiários
        */
        public function CertidaoBeneficiarioById($idDeclaracao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("rh/declaracoes/declaracao/$idDeclaracao/beneficiarios");
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

        /*
        branch 496
        cb Araújo
        obs: recupera dados de um beneficiario e da pessoa com base em seu id
        */
        public function BeneficiarioById($idCertidao,$idbeneficiario){
            try{
                $api = new ApiRestGeneric();
                $request = $api->get("rh/declaracoes/declaracao/$idCertidao/beneficiario/$idbeneficiario");
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

        /*
        branch 496
        cb Araújo
        obs: assina a certidao de beneficiario
        */
        public function assinaCertidao($idCertidao,$idPolicial,$tipoAssinante){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("rh/declaracoes/$idPolicial/beneficiarios/$idCertidao/assinante/$tipoAssinante/assinar");
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

        /*
        branch 496
        cb Araújo
        obs: reabre a certidao de beneficiario
        */
        public function reabreDeclaracao($idPolicial,$idCertidao){
            try{
                $api = new ApiRestGeneric();
                $request = $api->put("rh/declaracoes/$idPolicial/beneficiarios/$idCertidao/reabrir");
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                    throw new Exception($response->msg);
                }
                return $response->msg;   
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        

        /*
        branch 496
        cb Araújo
        obs: exclui beneficiario da certidao
        */
        public function excluirBeneficiario($idCertidao,$idBeneficiario){
            
            try{
                $api = new ApiRestGeneric();
                $request = $api->delete("rh/declaracoes/declaracao/$idCertidao/beneficiario/$idBeneficiario");
                $response = $api->converteStringJson($request);
                if($response->retorno != 'sucesso'){
                        throw new Exception($response->msg);
                }
                return $response;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }

        }

        


    }
?>



