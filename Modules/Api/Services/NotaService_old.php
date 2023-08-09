<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\Boletim\Entities\Tiposnota;
    use Modules\RH\Entities\Funcionario;
    use Modules\Boletim\Entities\Notasdosboletim;
    use Modules\Boletim\Entities\Nota;
    use Modules\Boletim\Entities\Boletim;
    use Modules\Boletim\Entities\Historiconota;
    use Modules\Boletim\Entities\Policiaisdasnota;
    use Modules\Rh\Entities\Policial;
    use App\utis\Status;
    use Auth;
    use DB;
    use App\utis\MyLog;

    class NotaService  extends Controller {
    
        public function atribuiNotasAoBoletim(Boletim $boletim, Nota $nota, $parteDoboletim) {
            DB::beginTransaction();
            try{
                // Cria a tabela de relacionamento
                $create = Notasdosboletim::create([
                    'ce_boletim' => $boletim->id,
                    'ce_nota' => $nota->id,
                    'st_parte' => $parteDoboletim,
                ]);
                if($create->exists){
                    // Altera o status da nota para atribuida
                    $alteraStatusNota =  $this->alteraStatusNota($nota, Status::NOTA_ATRIBUIDA);
                    if($alteraStatusNota){
                        // Cria historico da nota
                        $historico = $this->createHistoricoNota($nota->id, Auth::user()->id, $nota->st_status, 'Atribuiu a Nota a um Boletim.');
                        if($historico->exists){
                            /***** CRIANDO LOGS NO SISTEMA  *****/
                            $acao = "Insert";      
                            $msg = 'O Usuário: '. Auth::user()->st_cpf . 'Atribuiu a nota de id: '.$nota->id.' ao Boletim de id: '.$boletim->id;
                            // Chamando a classe para registra a alteração na tabela logs
                            MyLog::info(compact('msg', 'acao'));
                        } else{
                            DB::rollback();
                            return false;
                        }
                    } else{
                        DB::rollback();
                        return false;
                    }
                } else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        public function removeNotasDoboletim(Boletim $boletim, Nota $nota) {
            DB::beginTransaction();
            try{
                // Deleta a linha da tabela de relacionamento
                $removenota = Notasdosboletim::where([['ce_boletim' ,$boletim->id], ['ce_nota', $nota->id]])->delete();
                if($removenota){
                    $status = Historiconota::where('ce_nota', $nota->id)->orderBy('dt_cadastro', 'desc')->select('st_status')->take(2)->get();
                    $status = $status->last()->st_status;
                    // Altera o status da nota para atribuida
                    $alteraStatusNota =  $this->alteraStatusNota($nota, $status);
                    if($alteraStatusNota){
                        // Cria historico da nota
                        $historico = $this->createHistoricoNota($nota->id, Auth::user()->id, $nota->st_status, 'Removeu a nota do Boletim.');
                        if($historico->exists){
                            /***** CRIANDO LOGS NO SISTEMA  *****/
                            $acao = "Delete";      
                            $msg = 'O Usuário: '. Auth::user()->st_cpf . 'Removeu a nota de id: '.$nota->id.' do Boletim de id: '.$boletim->id;
                            // Chamando a classe para registra a alteração na tabela logs
                            MyLog::info(compact('msg', 'acao'));
                        } else{
                            DB::rollback();
                            return false;
                        }
                    } else{
                        DB::rollback();
                        return false;
                    }
                } else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        public function alteraParteNotasDoboletim($idBoletim, $idNota, $parte) {
            DB:: beginTransaction();
            try{
                $alteraParte = Notasdosboletim::where([['ce_boletim' ,$idBoletim], ['ce_nota', $idNota]])->update([
                    'st_parte' => $parte
                ]);
                if($alteraParte){
                    /***** CRIANDO LOGS NO SISTEMA  *****/
                    $acao = "Update";      
                    $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Aletrou a parte da nota de id: '.$idNota.' no Boletim de id: '.$idBoletim;
                    // Chamando a classe para registra a alteração na tabela logs
                    MyLog::info(compact('msg', 'acao'));
                } else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }
        public function getNotaId($idNota) {
            $nota = Nota::find($idNota);
            return $nota;

        }
    
        public function alteraStatusNota($objetoNota, $status) {
            $alteraStatus = $objetoNota->update([
                'st_status' => $status,
            ]);
            return $alteraStatus;
        }
   
        // Lista todos tipos de notas
        // Saída - lista todos os campos [id, st_tipo, st_descricao, st_sigla] de tiposnotas
        public function getTiposNotas() {
            $tipos = Tiposnota::all();
            return $tipos;
        }
        // busca o tipo de nota pelo id
        // Saída - lista todos os campos [id, st_tipo, st_descricao, st_sigla, st_tela] de tiposnotas
        public function getTiposNotaId($id) {
            $tipo = Tiposnota::find($id);
            return $tipo;
        }

        // Retorna nu_sequencial para uma nova nota
        // Saída - inteiro seguinte ao ultimo sequencial cadastrado
        public function getNovoSequencial() {
            $tipos = Nota::select('nu_sequencial')->latest('id')->first();
            return $tipos['nu_sequencial'] + 1;
        }

        /***
         * Cria Nota
         * entrada: array com dados do form
         * retorno: true ou false
         */
        public function criarNota($dadosform){
            DB::beginTransaction();
            try{
                // adiciona o nu_sequencial mais atualizado
                $dadosform['nu_sequencial'] = $this->getNovoSequencial();
                // cria a nota
                $create = Nota::create($dadosform);
                if($create->exists){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($create->id, Auth::user()->id, $create->st_status, 'Criou a Nota.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Insert";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Criou uma Nota';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                    }else{
                        DB::rollback();
                        return $e->getMessage();
                    }
                }else{
                    DB::rollback();
                    return $e->getMessage();
                }
            } catch(\Exception $e){
                DB::rollback();
                return $e->getMessage();
            }
            DB::commit();
            return true;
        }

        /***
         * Cria Nota com Policial
         * entrada: array com dados do form e o id do policial a ser adicionado
         * retorno: o json da nota ou false
         */
        public function criarNotaComPolicial($dadosform, $idPolicialParaNota){
            DB::beginTransaction();
            try{
                // adiciona o nu_sequencial mais atualizado
                $dadosform['nu_sequencial'] = $this->getNovoSequencial();
                // cria a nota
                $create = Nota::create($dadosform);
                if($create->exists){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($create->id, Auth::user()->id, $create->st_status, 'Criou a Nota.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Insert";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Criou uma Nota';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                        $adicionarPolicialAnota = $this->vincularPolicialNota($create->id, $idPolicialParaNota);
                        if($adicionarPolicialAnota->exists){
                            //retorna o objeto policial em formato json
                            $jsonPolicial = json_decode($create, true);
                        } else{
                            DB::rollback();
                            return false;
                        }
                    } else{
                        DB::rollback();
                        return false;
                    }
                } else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return $jsonPolicial;
        }

        /***
         * Atualiza Nota
         * entrada: array com dados do form e o objeto nota a ser utilizada
         * retorno: true ou false
         */
        public function atualizarNota($dadosform, Nota $nota){
            DB::beginTransaction();
            try{
                // atualiza a nota
                $update = $nota->update($dadosform);
                if($update){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($nota->id, Auth::user()->id, $nota->st_status, 'Atualizou a nota.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Update";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Atualizou uma Nota';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                    }else{
                        DB::rollback();
                        return false;
                    }
                }else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        // Lista todas as notas em elaboração na unidade
        // Saída - lista as notas com todos os seus campos
        public function listaNotas($unidade) {
            $notas = Nota::where([['notas.st_status', '!=', Status::NOTA_PUBLICADA], ['notas.st_status', '!=', Status::NOTA_CANCELADA],['notas.ce_unidade', $unidade]])
            ->leftjoin('dbo.unidades as unidade', 'unidade.id', '=','notas.ce_unidade')
            ->select('notas.*', 'unidade.st_sigla as unidade')
            ->get();
            return $notas;
        }

        // Lista todas as notas em enviadas para a unidade
        // Saída - lista as notas com todos os seus campos
        public function listaNotasRecebidas($unidade) {
            $notas = Nota::where([['notas.st_status', Status::NOTA_ENVIADA],['notas.ce_unidade', $unidade]])
            ->leftjoin('dbo.unidades as unidade', 'unidade.id', '=','notas.ce_unidade')
            ->select('notas.*', 'unidade.st_sigla as unidade')
            ->get();
            return $notas;
        }

        // Deleta a Nota ----- Alterar apenas o bo_ativo futuramente
        // Entrada - Objeto Nota a ser deletado
        // Saída - true ou false
        public function deletaNota(Nota $nota){
            $delete = $nota->delete();
            return $delete;
        }

        
        // FINALIZA NOTA
        // entrada objeto nota
        // retorno true ou false
        public function finalizaNota(Nota $nota) {
            DB::beginTransaction();
            try{
                // finaliza a nota
                $update =  $this->alteraStatusNota($nota, Status::NOTA_FINALIZADA);
                if($update){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($nota->id, Auth::user()->id, $nota->st_status, 'Finalizou a nota.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Update";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Finalizou uma Nota';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                    }else{
                        DB::rollback();
                        return false;
                    }
                }else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        // CORRIGE NOTA - Retorna a Nota para correção
        // entrada objeto nota
        // retorno true ou false
        public function corrigeNota(Nota $nota) {
            DB::beginTransaction();
            try{
                // retorna a nota para correção
                $update =  $this->alteraStatusNota($nota, Status::NOTA_RASCUNHO);
                if($update){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($nota->id, Auth::user()->id, $nota->st_status, 'Retornou nota para correção.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Update";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Retornou uma nota para correção.';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                    }else{
                        DB::rollback();
                        return false;
                    }
                }else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        // ASSINA NOTA
        // entrada objeto nota
        // retorno true ou false
        public function assinarNota(Nota $nota) {
            DB::beginTransaction();
            try{
                // Assina a nota
                $update = $nota->update([
                    'st_status'=> Status::NOTA_ASSINADA, 
                    'bo_assinada'=> 1,
                ]);
                if($update){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($nota->id, Auth::user()->id, $nota->st_status, 'Assinou a nota.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Update";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Assinou uma nota.';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                    }else{
                        DB::rollback();
                        return false;
                    }
                }else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        // ENVIA NOTA
        // entrada objeto nota
        // retorno true ou false
        public function enviarNota(Nota $nota) {
            DB::beginTransaction();
            try{
                // Assina a nota
                $update = $nota->update([
                    'st_status'=> Status::NOTA_ENVIADA, 
                    'bo_enviado'=> 1, 
                ]);
                if($update){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($nota->id, Auth::user()->id, $nota->st_status, 'Enviou a nota.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Update";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Enviou uma nota.';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                    }else{
                        DB::rollback();
                        return false;
                    }
                }else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        // RECUSAR NOTA
        // entrada objeto nota
        // retorno true ou false
        public function recusarNota($dadosform, Nota $nota) {
            DB::beginTransaction();
            try{
                // Assina a nota
                $update = $nota->update($dadosform);
                if($update){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNotaComObs($nota->id, Auth::user()->id, $nota->st_status, 'Recusou a nota.', $nota->st_obs);
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Update";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Recusou uma nota.';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                    }else{
                        DB::rollback();
                        return false;
                    }
                }else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        // ACEITA NOTA
        // entrada objeto nota
        // retorno true ou false
        public function aceitarNota(Nota $nota) {
            DB::beginTransaction();
            try{
                // Assina a nota
                $update = $nota->update([
                    'st_status'=> Status::NOTA_RECEBIDA, 
                    'bo_enviado'=> 0,
                ]);
                if($update){
                    // Cria historico da nota
                    $historico = $this->createHistoricoNota($nota->id, Auth::user()->id, $nota->st_status, 'Aceitou a nota.');
                    if($historico->exists){
                        /***** CRIANDO LOGS NO SISTEMA  *****/
                        $acao = "Update";      
                        $msg = 'O Usuário: ' . Auth::user()->st_cpf . 'Aceitou uma nota.';
                        // Chamando a classe para registra a alteração na tabela logs
                        MyLog::info(compact('msg', 'acao'));
                    }else{
                        DB::rollback();
                        return false;
                    }
                }else{
                    DB::rollback();
                    return false;
                }
            } catch(\Exception $e){
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        }

        // PUBLICA NOTA
        // entrada objeto nota
        // retorno true ou false
        public function publicarNota(Nota $nota) {
            $retornaNota = $nota->update([
                'st_status'=> Status::NOTA_PUBLICADA
            ]);
            return $retornaNota;
        }

        //Entra com o id da nota
        //Saída - lista os históricos das notas com todos os seus campos array
        public function getHistoricoNota($idNota){
            $HistoricoNota = Historiconota::where('historiconotas.ce_nota', $idNota)
            ->leftjoin('dbo.users as usuario', 'usuario.id', '=','historiconotas.ce_usuario')
            ->select('historiconotas.ce_usuario', 'historiconotas.dt_cadastro', 'historiconotas.st_status', 'historiconotas.st_msg', 'historiconotas.st_obs', 'usuario.name as st_nome_usuario')
            ->get(); 
         
            return $HistoricoNota;
        }

        // CRIA HISTÓRICO DE NOTA
        // entrada id da nota, id do usuário, status da nota, mensagem
        // retorno true ou false
        public function createHistoricoNota($notaId, $userId, $status, $msg){
            $create = Historiconota::create([
                'ce_nota' => $notaId,
                'ce_usuario' => $userId,
                'st_status' => $status,
                'st_msg' => $msg,
            ]);
            return $create;
        }

        // CRIA HISTÓRICO DE NOTA
        // entrada id da nota, id do usuário, status da nota, mensagem
        // retorno true ou false
        public function createHistoricoNotaComObs($notaId, $userId, $status, $msg, $obs){
            $create = Historiconota::create([
                'ce_nota' => $notaId,
                'ce_usuario' => $userId,
                'st_status' => $status,
                'st_msg' => $msg,
                'st_obs' => $obs,
            ]);
            return $create;
        }

        // Busca Policial para atribuir a nota de boletim
        // entrada cpf ou motrícula
        // retorno objeto policial ou nulo
        public function getPolicialParaNota($dadoPolicial) {
            $policial = Funcionario::where('funcionarios.st_matricula',$dadoPolicial)
                        ->orWhere('funcionarios.st_cpf',$dadoPolicial)
                        ->leftjoin('graduacoes', 'graduacoes.id', 'funcionarios.ce_graduacao')
                        ->select('graduacoes.st_postograduacao', 'funcionarios.id','funcionarios.st_numeropraca', 'funcionarios.st_matricula', 'funcionarios.st_nome')
                        ->first();
           
                return $policial;
          
            
        }

        /* Para busca todos o policiais vinculados a uma nota de boletim
        * entrada id da nota
        * retorno array de policiais
        */
        public function getPoliciaisDaNota($idNota){
            $policiaisDaNota = Policiaisdasnota::where('policiaisdasnotas.ce_nota', $idNota)
                                ->leftjoin('funcionarios', 'funcionarios.id', 'policiaisdasnotas.ce_policial')
                                ->leftjoin('graduacoes', 'graduacoes.id', 'funcionarios.ce_graduacao')
                                ->select('policiaisdasnotas.ce_nota', 'funcionarios.id as id_policial', 'funcionarios.st_nome', 'funcionarios.st_numeropraca', 'funcionarios.st_matricula', 'funcionarios.ce_graduacao', 'graduacoes.st_postograduacao')
                                ->get();
            return $policiaisDaNota;
            
        }
        // Vincula um policial a uma nota de boletim
        // entrada id da nota e id do policial
        // retorno true ou false
        public function vincularPolicialNota($idNota, $idPolicial) {
            $vinculaPolicialNota = Policiaisdasnota::create([
                    'ce_nota' => $idNota,
                    'ce_policial' => $idPolicial,
            ]);
           
            return $vinculaPolicialNota;
        }


        /* Busca um policial específico vinculado a uma nota de boletim
        * entrada id da nota e id do policial
        * retorno objeto policial
        */
        public function getPolicialNaNota($idNota, $idPolicial){
            $policiailNaNota = Policiaisdasnota::where([['ce_nota', $idNota],['ce_policial', $idPolicial]])->first();
            return $policiailNaNota;
        }
        
        /* Para busca um policial específico vinculado a uma nota de boletim
        * entrada id da nota e id do policial
        * retorno objeto policial
        */
        public function removerPolicialDaNota($idNota, $idPolicial){
            $policiailNaNota = Policiaisdasnota::where([['ce_nota', $idNota],['ce_policial', $idPolicial]])->delete();
            return $policiailNaNota;
                
        
        }
    }

?>