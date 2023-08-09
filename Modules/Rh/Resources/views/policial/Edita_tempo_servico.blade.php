@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Tempo de Serviço')
@section('tabcontent')
@php use App\utis\Funcoes; @endphp
<!-- 
Autor: @aggeu.  
Issue 184, Editar dados funcionais. Refatorado na Issue 211.
View que mostra os dados funcionais recuperados para edição 
-->
<div class="tab-pane active" id="dados_funcionais">
    <h4 class="tab-title">Tempo de Serviço - {{ $policial->st_nome}}</h4>
    <hr class="separador">
    <div style="text-align:center; padding-bottom: 10px">
        @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) < 1)
            <a class="btn btn-success btn-lg fa fa fa-save" data-toggle="modal" data-target="#tempoServico"> Adicionar Dados</a>
        @endif
    </div>
    <hr class="separador">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Tempo de efetivo serviço (Polícia Militar)</legend>
            <div class="row">
            @if(count($dadostemposervico->tempooefetivoservico)>0)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Motivo</th>
                        <th style="width:10%">Data início</th>
                        <th style="width:10%">Data fim</th>
                        <th style="width:18%">Tempo</th>
                        <th style="width:10%">Dias</th>
                        <th style="width:20%">Boletim</th>
                        <th style="width:10%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dadostemposervico->tempooefetivoservico as $dados)
                    <tr>
                        <td>{{ $dados->st_motivo }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_inicio) }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_fim) }}</td>
                        <td>{{ $dados->nu_diasextenso }}</td>
                        <td>{{ $dados->nu_dias }}</td>
                        <td>{{ $dados->st_boletim}} - {{ Funcoes::converterDataFormatoBr($dados->dt_boletim) }}</td>
                        <td>
                            @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) < 1)
                                <a class="btn btn-danger fa fa-trash" id="{{ $dados->id }}" onclick="chamaModal(this.id)" title="Excluir"></a>
                                @if(isset($dados->ce_nota))
                                    <a class="btn btn-success fa fa fa-file-pdf-o" href='/sisgp/boletim/nota/visualizar/{{ $dados->ce_nota }}'  target="_blank" title="Publicação"></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
            <p>Não há tempo de serviço prestado à órgão público registrado.</p>
            @endif           
            </div>
        </fieldset>
        
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Tempo de serviço prestado à órgão público</legend>
            <div class="row">
            @if(count($dadostemposervico->tempoorgaopublico)>0)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Órgão</th>
                        <th style="width:10%">Data início</th>
                        <th style="width:10%">Data fim</th>
                        <th style="width:18%">Tempo</th>
                        <th style="width:10%">Dias</th>
                        <th style="width:20%">Boletim</th>
                        <th style="width:10%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dadostemposervico->tempoorgaopublico as $dados)
                    <tr>
                        <td>{{ $dados->st_motivo }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_inicio) }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_fim) }}</td>
                        <td>{{ $dados->nu_diasextenso }}</td>
                        <td>{{ $dados->nu_dias }}</td>
                        <td>{{ $dados->st_boletim}} - {{ Funcoes::converterDataFormatoBr($dados->dt_boletim) }}</td>
                        <td>
                            @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) < 1)
                                <a class="btn btn-danger fa fa-trash" id="{{ $dados->id }}" onclick="chamaModal(this.id)" title="Excluir"></a>
                                @if(isset($dados->ce_nota))
                                    <a class="btn btn-success fa fa fa-file-pdf-o" href='/sisgp/boletim/nota/visualizar/{{ $dados->ce_nota }}'  target="_blank" title="Publicação"></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
            <p>Não há tempo de serviço prestado à órgão público registrado.</p>
            @endif           
            </div>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Tempo de serviço prestado à iniciativa privada</legend>
            <div class="row">
            @if(count($dadostemposervico->tempoorgaoprivado)>0)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th style="width:10%">Data início</th>
                        <th style="width:10%">Data fim</th>
                        <th style="width:18%">Tempo</th>
                        <th style="width:10%">Dias</th>
                        <th style="width:20%">Boletim</th>
                        <th style="width:10%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dadostemposervico->tempoorgaoprivado as $dados)
                    <tr>
                        <td>{{ $dados->st_motivo }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_inicio) }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_fim) }}</td>
                        <td>{{ $dados->nu_diasextenso }}</td>
                        <td>{{ $dados->nu_dias }}</td>
                        <td>{{ $dados->st_boletim}} - {{ Funcoes::converterDataFormatoBr($dados->dt_boletim) }}</td>
                        <td>
                            @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) < 1)
                                <a class="btn btn-danger fa fa-trash" id="{{ $dados->id }}" onclick="chamaModal(this.id)" title="Excluir"></a>
                                @if(isset($dados->ce_nota))
                                    <a class="btn btn-success fa fa fa-file-pdf-o" href='/sisgp/boletim/nota/visualizar/{{ $dados->ce_nota }}'  target="_blank" title="Publicação"></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
            <p>Não há tempo de serviço prestado à iniciativa privada registrado.</p>
            @endif
            </div>           
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Licenças especiais não gozadas</legend>
            <div class="row">
            @if(count($dadostemposervico->tempolicencas)>0)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Decênio</th>
                        <th style="width:10%">Data início</th>
                        <th style="width:10%">Data fim</th>
                        <th style="width:18%">Tempo</th>
                        <th style="width:10%">Dias</th>
                        <th style="width:20%">Boletim</th>
                        <th style="width:10%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dadostemposervico->tempolicencas as $dados)
                    <tr>
                        <td>{{ $dados->st_decenio }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_inicio) }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_fim) }}</td>
                        <td>solicitar função de tempo</td>
                        <td>{{ $dados->nu_dias }}</td>
                        <td>{{ $dados->st_boletim}} - {{ Funcoes::converterDataFormatoBr($dados->dt_boletim) }}</td>
                        <td>
                            @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) < 1)
                                <a class="btn btn-danger fa fa-trash" id="{{ $dados->id }}" onclick="chamaModal(this.id)" title="Excluir"></a>
                                @if(isset($dados->ce_nota))
                                    <a class="btn btn-success fa fa fa-file-pdf-o" href='/sisgp/boletim/nota/visualizar/{{ $dados->ce_nota }}'  target="_blank" title="Publicação"></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
            <p>Não há licenças especiais não gozadas registradas.</p>
            @endif
            </div>           
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Férias não gozadas computadas em dobro</legend>
            <div class="row">
            @if(count($dadostemposervico->tempoferias)>0)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:11%">Ano</th>
                        <th style="width:11%">Observação</th>
                        <th style="width:10%">Data início</th>
                        <th style="width:10%">Data fim</th>
                        <th style="width:18%">Tempo</th>
                        <th style="width:10%">Dias</th>
                        <th style="width:20%">Boletim</th>
                        <th style="width:10%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dadostemposervico->tempoferias as $dados)
                    <tr>
                        <td>{{ $dados->st_ano }}</td>
                        <td>{{ $dados->st_obs }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_inicio) }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_fim) }}</td>
                        <td>{{ $dados->nu_diasextenso }}</td>
                        <td>{{ $dados->nu_dias }}</td>
                        <td>{{ $dados->st_boletim}} - {{ Funcoes::converterDataFormatoBr($dados->dt_boletim) }}</td>
                        <td>
                            @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) < 1)
                                <a class="btn btn-danger fa fa-trash" id="{{ $dados->id }}" onclick="chamaModal(this.id)" title="Excluir"></a>
                                @if(isset($dados->ce_nota))
                                    <a class="btn btn-success fa fa fa-file-pdf-o" href='/sisgp/boletim/nota/visualizar/{{ $dados->ce_nota }}'  target="_blank" title="Publicação"></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
            <p>Não há férias não gozadas registradas.</p>
            @endif
            </div>           
        </fieldset>

        @if(
            $policial->ce_qpmp == "7" || 
            $policial->ce_qpmp == "14" ||
            $policial->ce_qpmp == "16" ||
            $policial->ce_qpmp == "22" ||
            $policial->ce_qpmp == "24" ||
            $policial->ce_qpmp == "28"
        )
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Tempo fictício (Saúde)</legend>
            <div class="row">
            @if(count($dadostemposervico->tempoficticio)>0)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Motivo</th>
                        <th style="width:10%">Data início</th>
                        <th style="width:10%">Data fim</th>
                        <th style="width:18%">Tempo</th>
                        <th style="width:10%">Dias</th>
                        <th style="width:20%">Boletim</th>
                        <th style="width:10%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dadostemposervico->tempoficticio as $dados)
                    <tr>
                        <td>{{ $dados->st_motivo }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_inicio) }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_fim) }}</td>
                        <td>{{ $dados->nu_diasextenso }}</td>
                        <td>{{ $dados->nu_dias }}</td>
                        <td>{{ $dados->st_boletim}} - {{ Funcoes::converterDataFormatoBr($dados->dt_boletim) }}</td>
                        <td>
                            @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) < 1)
                                <a class="btn btn-danger fa fa-trash" id="{{ $dados->id }}" onclick="chamaModal(this.id)" title="Excluir"></a>
                                @if(isset($dados->ce_nota))
                                    <a class="btn btn-success fa fa fa-file-pdf-o" href='/sisgp/boletim/nota/visualizar/{{ $dados->ce_nota }}'  target="_blank" title="Publicação"></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
            <p>Não há tempo fictício registrado.</p>
            @endif
            </div>           
        </fieldset>
        @endif

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Tempo de serviço não computado/concomitante</legend>
            <div class="row">
            @if(count($dadostemposervico->temponaocomputado)>0)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Motivo</th>
                        <th style="width:10%">Data início</th>
                        <th style="width:10%">Data fim</th>
                        <th style="width:18%">Tempo</th>
                        <th style="width:10%">Dias</th>
                        <th style="width:20%">Boletim</th>
                        <th style="width:10%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dadostemposervico->temponaocomputado as $dados)
                    <tr>
                        <td>{{ $dados->st_motivo }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_inicio) }}</td>
                        <td>{{ Funcoes::converterDataFormatoBr($dados->dt_fim) }}</td>
                        <td>{{ $dados->nu_diasextenso }}</td>
                        <td>{{ $dados->nu_dias }}</td>
                        <td>{{ $dados->st_boletim}} - {{ Funcoes::converterDataFormatoBr($dados->dt_boletim) }}</td>
                        <td>
                            @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) < 1)
                                <a class="btn btn-danger fa fa-trash" id="{{ $dados->id }}" onclick="chamaModal(this.id)" title="Excluir"></a>
                                @if(isset($dados->ce_nota))
                                    <a class="btn btn-success fa fa fa-file-pdf-o" href='/sisgp/boletim/nota/visualizar/{{ $dados->ce_nota }}'  target="_blank" title="Publicação"></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
            <p>Não há tempo de serviço não computado/concomitante.</p>
            @endif
            </div>           
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Tempo Total Averbado</legend>
            <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>                    
                        <th style="width:50%">Tempo</th>
                        <th style="width:50%">Dias</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>@php echo $dadostemposervico->tempototal->nu_diasextenso; @endphp</td>
                        <td>@php echo $dadostemposervico->tempototal->nu_dias; @endphp</td>
                    </tr>
                
                </tbody>
            </table>
            </div>           
        </fieldset>
        
        @if ($dadostemposervico->tempototal->nu_dias > 0)
            @can('IMPRIMIR_CERTIDAO_TEMPO_SERVICO')
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Assinaturas</legend>
                    <div class="row mt-10">
                        <div class="col-md-6">
                            <div class="text-center">
                                @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) > 0)
                                    {{-- variável para que receberá o índice da assinatura do auxiliar, caso ele tenha assinado --}}
                                    @php $auxiliarAssinou = -1 @endphp
                                    @foreach ($dadostemposervico->assinaturas as $key => $a)
                                        {{-- verifica se a função na assinatura é auxiliar --}}
                                        @if ($a->st_funcaoassinante == 'AUXILIARDP2' || $a->st_funcaoassinante == 'AUXILIARDP4')
                                            {{-- variável recebe o índice da assinatura neste momento da iteração --}}
                                            @php $auxiliarAssinou = $key @endphp
                                        @endif
                                    @endforeach
                                    @if ($auxiliarAssinou > -1)
                                        Assinado eletronicamente por <br>
                                        {{$dadostemposervico->assinaturas[$auxiliarAssinou]->st_nomeassinante}} - {{$dadostemposervico->assinaturas[$auxiliarAssinou]->st_postogradassinante}} PM <br>
                                        Auxilar da {{( $dadostemposervico->qualificacao->ce_graduacao < 8 ? "DP/2" : "DP/4" )}} <br>
                                        em {{date('d/m/Y - H:i:s', strtotime($dadostemposervico->assinaturas[$auxiliarAssinou]->dt_cadastro))}} <br><br>
                                        <a class="btn btn-danger fa fa-trash" onclick="modalAssinarOuExcluirAssinaturaCertidao('AUXILIARDP', {{$dadostemposervico->qualificacao->ce_graduacao}}, 'CANCELAR', {{$dadostemposervico->assinaturas[$auxiliarAssinou]->id}})" title="Excluir Assinatura"></a>
                                    @else
                                        <button type="button" class="btn btn-primary center" onclick="modalAssinarOuExcluirAssinaturaCertidao('AUXILIARDP', {{$dadostemposervico->qualificacao->ce_graduacao}})" title="Assinar Certidão">
                                            <i class="fa fa-pencil"></i> Assinatura do Auxiliar da {{( $dadostemposervico->qualificacao->ce_graduacao < 8 ? "DP/2" : "DP/4" )}}
                                        </button>
                                    @endif
                                @else
                                    <button type="button" class="btn btn-primary center" onclick="modalAssinarOuExcluirAssinaturaCertidao('AUXILIARDP', {{$dadostemposervico->qualificacao->ce_graduacao}})" title="Assinar Certidão">
                                        <i class="fa fa-pencil"></i> Assinatura do Auxiliar da {{( $dadostemposervico->qualificacao->ce_graduacao < 8 ? "DP/2" : "DP/4" )}}
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                @if (isset($dadostemposervico->assinaturas) && count($dadostemposervico->assinaturas) > 0)
                                    {{-- variável para que receberá o índice da assinatura do auxiliar, caso ele tenha assinado --}}
                                    @php $chefeAssinou = -1 @endphp
                                    @foreach ($dadostemposervico->assinaturas as $key => $a)
                                        {{-- verifica se a função na assinatura é chefe --}}
                                        @if ($a->st_funcaoassinante == 'CHEFEDP2' || $a->st_funcaoassinante == 'CHEFEDP4')
                                            {{-- variável recebe o índice da assinatura neste momento da iteração --}}
                                            @php $chefeAssinou = $key @endphp 
                                        @endif
                                    @endforeach
                                    @if ($chefeAssinou > -1)
                                        Assinado eletronicamente por <br>
                                        {{$dadostemposervico->assinaturas[$chefeAssinou]->st_nomeassinante}} - {{$dadostemposervico->assinaturas[$chefeAssinou]->st_postogradassinante}} PM <br>
                                        Chefe da {{( $dadostemposervico->qualificacao->ce_graduacao < 8 ? "DP/2" : "DP/4" )}} <br>
                                        em {{date('d/m/Y - H:i:s', strtotime($dadostemposervico->assinaturas[$chefeAssinou]->dt_cadastro))}} <br><br>
                                        <a class="btn btn-danger fa fa-trash" onclick="modalAssinarOuExcluirAssinaturaCertidao('CHEFEDP', {{$dadostemposervico->qualificacao->ce_graduacao}}, 'CANCELAR', {{$dadostemposervico->assinaturas[$chefeAssinou]->id}})" title="Excluir Assinatura"></a>
                                    @else
                                        <button type="button" class="btn btn-primary center" onclick="modalAssinarOuExcluirAssinaturaCertidao('CHEFEDP', {{$dadostemposervico->qualificacao->ce_graduacao}})" title="Assinar Certidão">
                                            <i class="fa fa-pencil"></i> Assinatura do Chefe da {{( $dadostemposervico->qualificacao->ce_graduacao < 8 ? "DP/2" : "DP/4" )}}
                                        </button>
                                    @endif
                                @else
                                    <button type="button" class="btn btn-primary center" onclick="modalAssinarOuExcluirAssinaturaCertidao('CHEFEDP', {{$dadostemposervico->qualificacao->ce_graduacao}})" title="Assinar Certidão">
                                        <i class="fa fa-pencil"></i> Assinatura do Chefe da {{( $dadostemposervico->qualificacao->ce_graduacao < 8 ? "DP/2" : "DP/4" )}}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>  
                    <br>         
                </fieldset>
            @endcan
        @endif

    <!-- MODAIS -->
    <!-- Modal Cria Férias -->
    <div class="modal fade" id="tempoServico" tabindex="-1" role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <h4 class="modal-title">Tempo de Serviço</h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="form_ferias" method="POST" action="/sisgp/rh/policiais/edita/{{ $policial->id }}/tempo_servico/salvar"> 
                        {{ csrf_field() }}
                        <h4>Selecione o tipo</h4>
                        <select onchange="mostraDivs(this.value)" class="form-control" name="st_tipo" id="st_tipo">
                            <option value=""></option>
                            <option value="TEMPOSERVICOPM">Tempo de efetivo serviço (Polícia Militar)</option>
                            <option value="TEMPOSETORPUBLICO">Tempo de serviço prestado à órgão público</option>
                            <option value="TEMPOSETORPRIVADO">Tempo de serviço prestado à iniciativa privada</option>
                            <option value="TEMPOLICENCAS">Licenças especiais não gozadas</option>
                            <option value="TEMPOFERIAS">Férias não gozadas computadas em dobro</option>
                            <option value="TEMPOFICTICIO">Tempo fictício (Saúde)</option>
                            <option value="TEMPONAOCOMPUTADO">Tempo de serviço não computado/concomitante</option>
                        </select>
                        <hr class="separador">

                        <div id="TEMPOSERVICOPM" style="display: none;">
                            <h4>Motivo</h4>
                            <input type="text" name="st_motivo" class="form-control" maxlength="100" placeholder="Ex: Concurso de 2009...">
                            <h4>Data Inicial</h4>
                            <input type="date" name="dt_inicio" class='form-control'>
                            <h4>Data Fim</h4>
                            <input type="date" name="dt_fim" class='form-control'>
                            <h4>Boletim</h4>
                            <input type="text" name="st_boletim" class="form-control" maxlength="100">
                            <h4>Data Boletim</h4>
                            <input type="date" name="dt_boletim" class='form-control'>
                        </div>

                        <div id="TEMPOSETORPUBLICO" style="display: none;">
                            <h4>Órgão</h4>
                            <input type="text" name="st_motivo" class="form-control" maxlength="100" placeholder="Ex: Caern...">
                            <h4>Data Inicial</h4>
                            <input type="date" name="dt_inicio" class='form-control'>
                            <h4>Data Fim</h4>
                            <input type="date" name="dt_fim" class='form-control'>
                            <h4>Boletim</h4>
                            <input type="text" name="st_boletim" class="form-control" maxlength="100">
                            <h4>Data Boletim</h4>
                            <input type="date" name="dt_boletim" class='form-control'>
                        </div>

                        <div id="TEMPOSETORPRIVADO" style="display: none;">
                            <h4>Empresa</h4>
                            <input type="text" name="st_motivo" class="form-control" maxlength="100" placeholder="Ex: Casas Bahia...">
                            <h4>Data Inicial</h4>
                            <input type="date" name="dt_inicio" class='form-control'>
                            <h4>Data Fim</h4>
                            <input type="date" name="dt_fim" class='form-control'>
                            <h4>Boletim</h4>
                            <input type="text" name="st_boletim" class="form-control" maxlength="100">
                            <h4>Data Boletim</h4>
                            <input type="date" name="dt_boletim" class='form-control'>
                        </div>

                        <div id="TEMPOLICENCAS" style="display: none;">
                            <input type="hidden" name="st_motivo" value="Licença especial não gozada (6 meses)">
                            <h4>Decênio</h4>
                            <input type="text" name="st_decenio" class="form-control" maxlength="100">
                            <h4>Data Inicial do decênio</h4>
                            <input type="date" name="dt_inicio" class='form-control'>
                            <h4>Data Final do decênio</h4>
                            <input type="date" name="dt_fim" class='form-control'>
                            <h4>Boletim</h4>
                            <input type="text" name="st_boletim" class="form-control" maxlength="100">
                            <h4>Data Boletim</h4>
                            <input type="date" name="dt_boletim" class='form-control'>
                        </div>

                        <div id="TEMPOFERIAS" style="display: none;">
                            <input type="hidden" name="st_motivo" value="Férias não gozadas computadas em dobro.">
                            <h4>Ano</h4>
                            <input type="text" name="st_ano" class="form-control" maxlength="100">
                            <h4>Dias</h4>
                            <input onkeyup="somenteNumeros(this.value,this.id)" type="number" min="1" step="1" name="nu_dias" class="form-control" maxlength="100" placeholder="ex: 30">
                            <h4>Data Início do Gozo das Férias</h4>
                            <input type="date" name="dt_inicio" class='form-control'>
                            <h4>Data Fim do Gozo das Férias</h4>
                            <input type="date" name="dt_fim" class='form-control'>
                            <h4>Observação</h4>
                            <input type="text" name="st_obs" class='form-control' maxlength="500">
                            <h4>Boletim</h4>
                            <input type="text" name="st_boletim" class="form-control" maxlength="100">
                            <h4>Data Boletim</h4>
                            <input type="date" name="dt_boletim" class='form-control'>
                        </div>

                        <div id="TEMPOFICTICIO" style="display: none;">
                            <h4>Motivo</h4>
                            <input type="text" name="st_motivo" class='form-control' maxlength="100">
                            <h4>Data Inicio</h4>
                            <input type="date" name="dt_inicio" class='form-control'>
                            <h4>Data Fim</h4>
                            <input type="date" name="dt_fim" class='form-control'>
                            <h4>Boletim</h4>
                            <input type="text" name="st_boletim" class="form-control" maxlength="100">
                            <h4>Data Boletim</h4>
                            <input type="date" name="dt_boletim" class='form-control'>
                        </div>

                        <div id="TEMPONAOCOMPUTADO" style="display: none;">
                            <h4>Motivo</h4>
                            <input type="text" name="st_motivo" class='form-control' maxlength="100">
                            <h4>Data Inicio</h4>
                            <input type="date" name="dt_inicio" class='form-control'>
                            <h4>Data Fim</h4>
                            <input type="date" name="dt_fim" class='form-control'>
                            <h4>Boletim</h4>
                            <input type="text" name="st_boletim" class="form-control" maxlength="100">
                            <h4>Data Boletim</h4>
                            <input type="date" name="dt_boletim" class='form-control'>
                        </div>
                        
                        <div class="modal-footer" style="text-align:center;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success salvar">Salvar</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>

    <!-- Modal Exclui tempo de serviço -->       
    <div class="modal fade-lg" id="ModalExcluirTempoServico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Tempo de Serviço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-inline" id="form_tempo_serv" method="post"  action="">
                    {{csrf_field()}}
                    <div class="modal-body bg-danger">                
                        <h4 class="modal-title" id="exampleModalLabel">
                        <b>Motivo da Exclusão:</b>
                        <input id="st_motivoexclusao"  type="text"  required class="form-control" name="st_motivoexclusao" style="width:80%; "> 
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Moldal assina ou cancela assinatura certidão de tempo de serviço -->
    <div class="modal fade" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div id="div-modal-assina-cabecalho" class="modal-header bg-primary">
                <h5 class="modal-title" id="assinarModalLabel">Assinar Certidão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form id="form-modal-assina-exclui" action='' method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="row">
                        <label for="pass" class="col-md-3">Senha</label>
                        <input type="password" class="col-md-8" name="password" required>
                        <input type="text" class="col-md-8" id='funcaoAssina' name="funcao" required hidden>
                    </div>
                </div>
            </div>
            <div id="div-modal-assina-rodape" class="modal-footer bg-primary">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button id="bt-modal-assina-exclui" type="submit" class="btn btn-success">Assinar</button>
            </div>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection

@section('css')
<style>
    .fileUpload {
    position: relative;
    overflow: hidden;
    margin: 24px 0px 10px 70px;
}

.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}

.mt-10 {
    margin-top: 10px;
}

</style>
@stop 

@section('js')

<script>
    var idTempoServico;

    $(document).ready(function () {  
        //função para fazer a preview da foto do policial
        //$(function(){
        $('#imagem').change(function(){
                const file = $(this)[0].files[0]
                const fileReader = new FileReader()
                fileReader.onloadend = function(){
                    $('#img').attr('src', fileReader.result)
                }
                fileReader.readAsDataURL(file)
        }) 
        $('#bo_ativo').on('change', function() {
            if(this.value ==1){
                $('#comboMotivoInatividade').hide();
                $('#dataInatividade').hide();
                $('#publicacaoInatividade').hide();
            }else{
                $('#comboMotivoInatividade').show();
                $('#dataInatividade').show();
                $('#publicacaoInatividade').show();
                }
            });

            if($('#bo_ativo').val()==1 ) {
                $('#comboMotivoInatividade').hide();
                $('#dataInatividade').hide();
                $('#publicacaoInatividade').hide();
            }else{
                $('#comboMotivoInatividade').show();
                $('#dataInatividade').show();
                $('#publicacaoInatividade').show();
            }
    });

    function mostraDivs(divid){

        switch(divid){
            case "TEMPOSERVICOPM":
                document.getElementById("TEMPOSERVICOPM").style.display = "block";
                document.getElementById("TEMPOSETORPUBLICO").style.display = "none";
                document.getElementById("TEMPOSETORPRIVADO").style.display = "none";
                document.getElementById("TEMPOLICENCAS").style.display = "none";
                document.getElementById("TEMPOFERIAS").style.display = "none";
                document.getElementById("TEMPOFICTICIO").style.display = "none";
                document.getElementById("TEMPONAOCOMPUTADO").style.display = "none";
            break;

            case "TEMPOSETORPUBLICO":
                document.getElementById("TEMPOSETORPUBLICO").style.display = "block";
                document.getElementById("TEMPOSERVICOPM").style.display = "none";
                document.getElementById("TEMPOSETORPRIVADO").style.display = "none";
                document.getElementById("TEMPOLICENCAS").style.display = "none";
                document.getElementById("TEMPOFERIAS").style.display = "none";
                document.getElementById("TEMPOFICTICIO").style.display = "none";
                document.getElementById("TEMPONAOCOMPUTADO").style.display = "none";
            break;

            case "TEMPOSETORPRIVADO":
                document.getElementById("TEMPOSETORPRIVADO").style.display = "block";
                document.getElementById("TEMPOSETORPUBLICO").style.display = "none";
                document.getElementById("TEMPOSERVICOPM").style.display = "none";
                document.getElementById("TEMPOLICENCAS").style.display = "none";
                document.getElementById("TEMPOFERIAS").style.display = "none";
                document.getElementById("TEMPOFICTICIO").style.display = "none";
                document.getElementById("TEMPONAOCOMPUTADO").style.display = "none";
            break;

            case "TEMPOLICENCAS":
                document.getElementById("TEMPOLICENCAS").style.display = "block";
                document.getElementById("TEMPOSETORPRIVADO").style.display = "none";
                document.getElementById("TEMPOSETORPUBLICO").style.display = "none";
                document.getElementById("TEMPOSERVICOPM").style.display = "none";
                document.getElementById("TEMPOFERIAS").style.display = "none";
                document.getElementById("TEMPOFICTICIO").style.display = "none";
                document.getElementById("TEMPONAOCOMPUTADO").style.display = "none";
            break;

            case "TEMPOLICENCAS":
                document.getElementById("TEMPOLICENCAS").style.display = "block";
                document.getElementById("TEMPOSETORPRIVADO").style.display = "none";
                document.getElementById("TEMPOSETORPUBLICO").style.display = "none";
                document.getElementById("TEMPOSERVICOPM").style.display = "none";
                document.getElementById("TEMPOFERIAS").style.display = "none";
                document.getElementById("TEMPOFICTICIO").style.display = "none";
                document.getElementById("TEMPONAOCOMPUTADO").style.display = "none";
            break;

            case "TEMPOFERIAS":
                document.getElementById("TEMPOFERIAS").style.display = "block";
                document.getElementById("TEMPOLICENCAS").style.display = "none";
                document.getElementById("TEMPOSETORPRIVADO").style.display = "none";
                document.getElementById("TEMPOSETORPUBLICO").style.display = "none";
                document.getElementById("TEMPOSERVICOPM").style.display = "none";
                document.getElementById("TEMPOFICTICIO").style.display = "none";
                document.getElementById("TEMPONAOCOMPUTADO").style.display = "none";
            break;

            case "TEMPOFICTICIO":
                document.getElementById("TEMPOFICTICIO").style.display = "block";
                document.getElementById("TEMPOFERIAS").style.display = "none";
                document.getElementById("TEMPOLICENCAS").style.display = "none";
                document.getElementById("TEMPOSETORPRIVADO").style.display = "none";
                document.getElementById("TEMPOSETORPUBLICO").style.display = "none";
                document.getElementById("TEMPOSERVICOPM").style.display = "none";
                document.getElementById("TEMPONAOCOMPUTADO").style.display = "none";
            break;

            case "TEMPONAOCOMPUTADO":
                document.getElementById("TEMPONAOCOMPUTADO").style.display = "block";
                document.getElementById("TEMPOFICTICIO").style.display = "none";
                document.getElementById("TEMPOFERIAS").style.display = "none";
                document.getElementById("TEMPOLICENCAS").style.display = "none";
                document.getElementById("TEMPOSETORPRIVADO").style.display = "none";
                document.getElementById("TEMPOSETORPUBLICO").style.display = "none";
                document.getElementById("TEMPOSERVICOPM").style.display = "none";
            break;

            default:
            document.getElementById("TEMPOSERVICOPM").style.display = "none";
            document.getElementById("TEMPOSETORPUBLICO").style.display = "none";
            document.getElementById("TEMPOSETORPRIVADO").style.display = "none";
            document.getElementById("TEMPOLICENCAS").style.display = "none";
            document.getElementById("TEMPOFERIAS").style.display = "none";
            document.getElementById("TEMPOFICTICIO").style.display = "none";
            document.getElementById("TEMPONAOCOMPUTADO").style.display = "none";
        }
        
    }

    //desabilita qualquer input que esteja dentro de uma div com display: none
    $(document).ready(function() {
        $('form').submit(function() {
            $(this).find('div:hidden input').prop('disabled', true);
        });
    });

    function somenteNumeros(str,id){
        document.getElementById(id).value = str.replace(/[^\d]+/g,'');
        //alert( str.replace(/[^\d]+/g,'') )
    }

    function chamaModal(id){
        //captura id do tempo de serviço
        idTempoServico = id;
        $('#ModalExcluirTempoServico').modal();
        //muda action do form
        acao = "/sisgp/rh/policiais/tempo_servico_apagar/{{ $policial->id }}/apagar/"+idTempoServico;
        $('#form_tempo_serv').attr('action', acao);
    };

    function modalAssinarOuExcluirAssinaturaCertidao(funcao, ce_graduacao, tipo = 'ASSINAR', idAssinatura = '', idPolicial = {{$policial->id}}){ 
        //verifica se o policial é praça ou oficial. Se < 7 é praça (DP2), senão é oficial (DP4)
        if (ce_graduacao < 8) {
            funcao += '2';
        } else {
            funcao += '4';
        }
        //verifica se o tipo da ação desejada é cancelar (por padrão é setado o valor 'ASSINAR')
        if (tipo == 'ASSINAR') {
            //altera os valores do atributo class do cabeçalho, rodapé e do botão do modal
            $('#div-modal-assina-cabecalho').prop('class', 'modal-header bg-primary');
            $('#div-modal-assina-rodape').prop('class', 'modal-footer bg-primary');
            $('#bt-modal-assina-exclui').prop('class', 'btn btn-success');
            //altera o texto a ser exibido no botão do modal
            $('#bt-modal-assina-exclui').html('Assinar');
            //altera o valor do atributo action no form do modal
            acao = '/sisgp/rh/policiais/assina_certidao/tempo_servico/' + idPolicial;
            $('#form-modal-assina-exclui').attr('action', acao);
        } else if (tipo == 'CANCELAR') {
            //altera os valores do atributo class do cabeçalho, rodapé e do botão do modal
            $('#div-modal-assina-cabecalho').prop('class', 'modal-header bg-danger');
            $('#div-modal-assina-rodape').prop('class', 'modal-footer bg-danger');
            $('#bt-modal-assina-exclui').prop('class', 'btn btn-danger');
            //altera o texto a ser exibido no botão do modal
            $('#bt-modal-assina-exclui').html('Excluir Assinatura');
            //altera o valor do atributo action no form do modal
            acao = '/sisgp/rh/policiais/cancela_assinatura_certidao/tempo_servico/' + idPolicial + '/' + idAssinatura;
            $('#form-modal-assina-exclui').attr('action', acao);
        }
        //atribui a função ao campo hidden funcao do form do modal
        $('#funcaoAssina').val(funcao);
        //invoca o modal
        $('#assinarModal').modal();
    };
    

</script>
@endsection