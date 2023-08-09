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
                        <form method="post" action="{{url('promocao/buscapolicialparainspecaodesaude/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}">
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
                                @foreach($policiaisQuadro as $policial)
                                    @php
                                        $ordem++
                                    @endphp
                                    @if($policial->bo_pendenciapreanalisejpms == 1)
                                        <tr bgcolor="#ffb3b3">
                                            <th>{{$ordem}}</th>
                                            <th>{{$policial->st_postgrad}}</th>
                                            <th>{{$policial->st_numpraca}}</th>
                                            <th>{{$policial->st_matricula}}</th>
                                            <th>{{$policial->st_policial}}</th>
                                            <th>{{$policial->st_inspecaojuntaparecer}}</th>
                                            <th>{{$policial->st_inspecaojuntaobs}}</th>
                                            <th>
                                                @if(isset($atividade) && empty($atividade->dt_atividade))
                                                    <button type="button" onclick="populaModalParecerJPMS({{$policial->ce_policial}}, {{$policial->ce_quadroacesso}}, {{$atividade->id}}, {{ "'" . (($policial->st_inspecaojuntaparecer == null) ? 'null' : $policial->st_inspecaojuntaparecer) . "'" }}, {{ "'" . (($policial->st_inspecaojuntaobs == null) ? 'null' : $policial->st_inspecaojuntaobs) . "'" }})" data-toggle="modal" data-target="#modalPerecerJPMS" title='Parecer da JPMS' class="btn btn-primary">
                                                        Parecer JPMS
                                                    </button>
                                                @endif
                                            </th>
                                        </tr>
                                    @else
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
                                                    <button type="button" onclick="populaModalParecerJPMS({{$policial->ce_policial}}, {{$policial->ce_quadroacesso}}, {{$atividade->id}}, {{ "'" . (($policial->st_inspecaojuntaparecer == null) ? 'null' : $policial->st_inspecaojuntaparecer) . "'" }}, {{ "'" . (($policial->st_inspecaojuntaobs == null) ? 'null' : $policial->st_inspecaojuntaobs) . "'" }})" data-toggle="modal" data-target="#modalPerecerJPMS" title='Parecer da JPMS' class="btn btn-primary">
                                                        Parecer JPMS
                                                    </button>
                                                @endif
                                            </th>
                                        </tr>
                                    @endif
                                @endforeach
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
                    
                    <p style="color:red"><b>* O policial que estiver destacado em vermelho se encontra em acompanhamento pela Junta Policial Militar de Saúde (JPMS).</b></p>
                    
                </div>
            </div>
        </div>
        <div class="form-row">
            <a href="{{url('promocao/quadro/cronograma/'.$quadro->id.'/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>
            @if($totalParaInspecionar == 0 && empty($atividade->dt_atividade))
                <button onclick="populaModalConcluirInspecaoJPMS({{$quadro->id}}, {{$atividade->id}})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirInspecaoJPMS">
                    Concluir Inspeção da JPMS
                </button>
            @endif
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
    <!-- Modal parecer JPMS -->
    <div class="modal fade" id="modalPerecerJPMS" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Realizar Inspecao de Saúde</h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="parecerJPMS" method="POST">
                        {{csrf_field()}}
                        <h4>Parecer</h4>
                        <select class="form-control" required="required" name="st_inspecaojuntaparecer" id="st_inspecaojuntaparecer">
                            <option value="">Selecione</option>
                            <option value="Apto">Apto</option>
                            <option value="Apto com restrição">Apto com restrição</option>
                            <option value="Inápto">Inápto</option>
                            <option value="faltou">Faltou</option>
                        </select>
                        <br><br>
                        <h4>Observação</h4>
                        <textarea class="form-control" rows="3" name="st_inspecaojuntaobs" id="st_inspecaojuntaobs" ></textarea>
                        <br><br>
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
    function populaModalParecerJPMS(idPolicial, idQuadroAcesso, idAtividade, competencia, parecer, obs){
        alert(competencia);
        $("#parecerJPMS").attr("action", "{{url('promocao/parcererjpms')}}/"+idPolicial+"/"+idQuadroAcesso+'/'+idAtividade+'/competencia/'+competencia);
        if(parecer != 'null'){
            $('#st_inspecaojuntaparecer').val(parecer);
        }
        if(obs != 'null'){
            $('#st_inspecaojuntaobs').val(obs);
        }
    }
    function modalConcluirJPMSSenha(idQuadroAcesso, idAtividade, competencia){
        $("#concluirJPMS").attr("action", "{{url('promocao/concluirInspecaojpms')}}/"+idQuadroAcesso+'/'+idAtividade+'/competencia/'+competencia);
    }
</script>
@stop