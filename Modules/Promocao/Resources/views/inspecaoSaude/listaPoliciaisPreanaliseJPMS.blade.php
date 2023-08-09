@extends('promocao::abas')
@section('title', 'Inspeção de Saúde')
@php
    use app\utis\Funcoes;
@endphp
@section('tabcontent')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div class="col-md-10">
                <h4>{{(empty($policiaisQuadro)) ? '0' : $policiaisQuadro->total()}} {{$titulopainel}} {{date('d/m/Y', strtotime($quadro->dt_promocao))}}</h4>
                </div>
                <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: '.$nota->st_status : ''}}</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    <div class="form-row form-inline">
                        <form method="post" action="{{url('promocao/buscapolicialparapreanalisejpms/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}">
                            {{csrf_field()}}
                            <div class="form-group col-xs-12 col-md-12 col-sm-12" style="margin-left:auto; padding-top:10px;">
                                <label style="padding: 2%;">
                                    <strong>Localizar Policial</strong>
                                </label>
                                <select class="form-control" name="st_filtro">
                                    <option value="st_matricula" selected>Matrícula</option>
                                    <option value="st_cpf">CPF</option>
                                    <option value="st_policial">Nome</option>
                                </select>
                                <input type="text" class="form-control" id="st_policial" name="st_parametro" placeholder="Matrícula ou CPF" required>
                                @if(isset($nota))
                                    <input type="hidden" class="form-control" id="idNota" value="{{$nota->id}}">
                                @endif
                                <button type="submit" class="btn btn-primary glyphicon glyphicon-search" title="Localizar Polcial" style="margin-bottom:7px;"></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table striped" id="policiais">
                        <thead>
                            <tr>
                                <th class="col-xs-1 col-md-1 col-sm-1">Ordem</th>
                                <th>Post/Grad</th>
                                <th>Praça</th>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                @if($tipoAnalise == "busca")
                                    <th>Pré-análise</th>
                                @endif
                                <th>Parecer JPMS</th>
                                <th>Observações</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($policiaisQuadro) && count($policiaisQuadro) > 0)
                                @php
                                    $ordem = 0;
                                @endphp
                                
                                @if($tipoAnalise == "naoanalisado")
                                    @foreach($policiaisQuadro as $policial)
                                        @php
                                            $ordem++
                                        @endphp
                            
                                        @if($policial->bo_pendenciapreanalisejpms == null)
                                            <tr>
                                                <th>{{$ordem}}</th>
                                                <th>{{$policial->st_postgrad}}</th>
                                                <th>{{$policial->st_numpraca}}</th>
                                                <th>{{$policial->st_matricula}}</th>
                                                <th>{{$policial->st_policial}}</th>
                                                <th>{{$policial->st_inspecaojuntaparecer}}</th>
                                                <th>{{$policial->st_inspecaojuntaobs}}</th>
                                                <th>
                                                    @if(isset($atividade) && empty($atividade->dt_atividade))
                                                        <button type="button" onclick="populaModalParecerJPMS({{$policial->ce_quadroacesso}}, {{$policial->ce_policial}}, {{$policial->bo_pendenciapreanalisejpms}})" data-toggle="modal" data-target="#modalPerecerJPMS" title='Parecer da JPMS' class="btn btn-primary">
                                                            Pré-análise
                                                        </button>
                                                    @endif
                                                </th>
                                            </tr>
                                        @endif
                                    @endforeach
                                @elseif($tipoAnalise == "busca")
                                    @foreach($policiaisQuadro as $policial)
                                        @php
                                            $ordem++
                                        @endphp
                            
                                        @if($policial->bo_pendenciapreanalisejpms == "1" || $policial->bo_pendenciapreanalisejpms == "0" || $policial->bo_pendenciapreanalisejpms == null)
                                            <tr>
                                                <th>{{$ordem}}</th>
                                                <th>{{$policial->st_postgrad}}</th>
                                                <th>{{$policial->st_numpraca}}</th>
                                                <th>{{$policial->st_matricula}}</th>
                                                <th>{{$policial->st_policial}}</th>
                                                @if($policial->bo_pendenciapreanalisejpms == null)
                                                    <th>{{"Convocado"}}</th>
                                                @elseif($policial->bo_pendenciapreanalisejpms == "0")
                                                    <th>{{"Regular"}}</th>
                                                @elseif($policial->bo_pendenciapreanalisejpms == "1")
                                                    <th>{{"Com pendência"}}</th>
                                                @endif
                                                <th>{{$policial->st_inspecaojuntaparecer}}</th>
                                                <th>{{$policial->st_inspecaojuntaobs}}</th>
                                                <th>
                                                    @if(isset($atividade) && empty($atividade->dt_atividade))
                                                    <button type="button" onclick="populaModalParecerJPMS({{$policial->ce_quadroacesso}}, {{$policial->ce_policial}}, {{$policial->bo_pendenciapreanalisejpms}})" data-toggle="modal" data-target="#modalPerecerJPMS" title='Parecer da JPMS' class="btn btn-primary">
                                                            Pré-análise
                                                        </button>
                                                    @endif
                                                </th>
                                            </tr>
                                        @endif
                                    @endforeach
                                @elseif($tipoAnalise == "compendencia")
                                    @foreach($policiaisQuadro as $policial)
                                        @php
                                            $ordem++
                                        @endphp
                            
                                        @if($policial->bo_pendenciapreanalisejpms == "1")
                                            <tr>
                                                <th>{{$ordem}}</th>
                                                <th>{{$policial->st_postgrad}}</th>
                                                <th>{{$policial->st_numpraca}}</th>
                                                <th>{{$policial->st_matricula}}</th>
                                                <th>{{$policial->st_policial}}</th>
                                                <th>{{$policial->st_inspecaojuntaparecer}}</th>
                                                <th>{{$policial->st_inspecaojuntaobs}}</th>
                                                <th>
                                                    @if(isset($atividade) && empty($atividade->dt_atividade))
                                                    <button type="button" onclick="populaModalParecerJPMS({{$policial->ce_quadroacesso}}, {{$policial->ce_policial}}, {{$policial->bo_pendenciapreanalisejpms}})" data-toggle="modal" data-target="#modalPerecerJPMS" title='Parecer da JPMS' class="btn btn-primary">
                                                            Pré-análise
                                                        </button>
                                                    @endif
                                                </th>
                                            </tr>
                                        @endif
                                    @endforeach
                                @elseif($tipoAnalise == "sempendencia")
                                    @foreach($policiaisQuadro as $policial)
                                        @php
                                            $ordem++
                                        @endphp
                            
                                        @if($policial->bo_pendenciapreanalisejpms == "0")
                                            <tr>
                                                <th>{{$ordem}}</th>
                                                <th>{{$policial->st_postgrad}}</th>
                                                <th>{{$policial->st_numpraca}}</th>
                                                <th>{{$policial->st_matricula}}</th>
                                                <th>{{$policial->st_policial}}</th>
                                                <th>{{$policial->st_inspecaojuntaparecer}}</th>
                                                <th>{{$policial->st_inspecaojuntaobs}}</th>
                                                <th>
                                                    @if(isset($atividade) && empty($atividade->dt_atividade))
                                                        <button type="button" onclick="populaModalParecerJPMS({{$policial->ce_quadroacesso}}, {{$policial->ce_policial}}, {{$policial->bo_pendenciapreanalisejpms}})" data-toggle="modal" data-target="#modalPerecerJPMS" title='Parecer da JPMS' class="btn btn-primary">
                                                            Pré-análise
                                                        </button>
                                                    @endif
                                                </th>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                <tr>
                                    <th colspan="8">Nenhum policial encontrado</th>
                                </tr>    
                            @endif
                        </tbody>
                    </table>

                    @if(isset($policiaisQuadro) && (count($policiaisQuadro) > 0) )
                        {{$policiaisQuadro->links()}}
                    @endif
                    
                </div>
            </div>
        </div>
        <div class="form-row">
            <a href="{{url('promocao/quadro/cronograma/'.$quadro->id.'/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>
          <!--   @if($totalParaInspecionar == 0 && empty($atividade->dt_atividade))
                <button onclick="populaModalConcluirInspecaoJPMS({{$quadro->id}}, {{$atividade->id}})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirInspecaoJPMS">
                    Concluir Inspeção da JPMS
                </button>
            @endif -->
        </div>
    </div>
    
    <!--Modal para Concluir Inspeçao da JPMS-->
    <div class="modal fade" id="modalConcluirInspecaoJPMS" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmar Ação</h4>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title">Atenção!</h4>
                    <div classe> Ao concluir a inspeção da JPMS, não será mais possível inspecionar policiais para este quadro de acesso. 
                    Deseja continuar?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    <button onclick="modalConcluirJPMSSenha({{$quadro->id}}, {{$atividade->id}})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirJPMSComSenha" data-dismiss="modal">
                        Sim
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal para Concluir Realização de JPMS com senha-->
    <div class="modal fade" id="modalConcluirJPMSComSenha" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Concluir Realização de JPMS</h4>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title">Atenção!</h4>
                    <div classe>
                        É necessario assinar eletrônicamente a conclusão da JPMS.
                    </div>
                </div>
                <div class="modal-body">
                    <form role="form" id="concluirJPMS" method="POST">
                        {{csrf_field()}}
                        <h4>Informe a Senha:</h4>
                        <input id="password" type="password" class="form-control" name="password" value="" placeholder="Digite sua senha..." required>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btconcluirJPMS" class="btn btn-primary">Concluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pré-análise JPMS -->
    <div class="modal fade" id="modalPerecerJPMS" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Realizar Pré-análise (JPMS)</h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="parecerJPMS" method="POST">
                        {{csrf_field()}}
                        <h4>Pré-análise</h4>
                        <select class="form-control" required="required" name="bo_pendenciapreanalisejpms" id="bo_pendenciapreanalisejpms">
                            <option value="0">Sem pendência</option>
                            <option value="1">Com pendência</option>
                        </select>
                        <input type="hidden" id="competencia" name="competencia" value="{{$competencia}}">
                        <input type="hidden" id="url" name="url" value="{{Request::url()}}">
                        <input type="hidden" id="st_atividade" name="st_atividade" value="{{$atividade->id}}">
                        <input type="hidden" id="st_seguimento" name="st_seguimento" value="{{Request::segment(2)}}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit"class="btn btn-success salvar">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    //adiciona o href dinamico para o modal de comfirmação de remoção de policial do
    function populaModalParecerJPMS(idPolicial, idQuadroAcesso, boSituacao){
        $("#parecerJPMS").attr("action", "{{url('promocao/quadrosacessos')}}/"+idQuadroAcesso+"/policiais/"+idPolicial+'/preanalise/'+boSituacao);
        if(boSituacao != 'null'){
            $('#bo_pendenciapreanalisejpms').val(boSituacao);
        }
    
        /* if(obs != 'null'){
            $('#st_inspecaojuntaobs').val(obs);
        } */
    }
    function modalConcluirJPMSSenha(idQuadroAcesso, idAtividade){
        $("#concluirJPMS").attr("action", "{{url('promocao/concluirInspecaojpms')}}/"+idQuadroAcesso+'/'+idAtividade);
    }
</script>
@stop