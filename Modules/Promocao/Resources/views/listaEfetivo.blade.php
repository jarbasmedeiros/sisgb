@extends('promocao::abas')
@if(Request::segment(2) == 'escriturarfichadereconhecimento')
    @section('title', 'Escriturar Ficha')
@elseif(Request::segment(2) == 'realizartaf' || Request::segment(2) == 'realizartafinspecionado')
    @section('title', 'Realizar TAF')
@elseif(Request::segment(2) == 'policiaisinspecionados' || Request::segment(2) == 'inspecaoparapromocaojpms')
    @section('title', 'Inspeção de Saúde')
@endif
@php
    use app\utis\Funcoes;
@endphp
@section('tabcontent')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div class="col-md-10">
                    <h4>{{$titulopainel}} {{date('d/m/Y', strtotime($quadro->dt_promocao))}}</h4>
                </div>
                <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: '.$nota->st_status : ''}}</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    <div class="form-row form-inline">
                        @if(Request::segment(2) == 'policiaisinspecionados' || Request::segment(2) == 'inspecaoparapromocaojpms' || Request::segment(2) == 'buscapolicialparainspecaodesaude')
                            <form method="post" action="{{url('promocao/buscapolicialparainspecaodesaude/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}">
                        @elseif(Request::segment(2) == 'realizartaf' || Request::segment(2) == 'realizartafinspecionado'|| Request::segment(2) == 'buscapolicialparataf')
                            <form method="post" action="{{url('promocao/buscapolicialparataf/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}">
                        @endif
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
                                @if(Request::segment(2) != 'escriturarfichadereconhecimento')
                                    <th>Parecer JPMS</th>
                                @endif
                                @if(Request::segment(2) == 'policiaisinspecionados' || Request::segment(2) == 'inspecaoparapromocaojpms' || Request::segment(2) == 'buscapolicialparainspecaodesaude')
                                    <th>Observações</th>
                                @endif
                                @if(Request::segment(2) == 'realizartaf' || Request::segment(2) == 'realizartafinspecionado' || Request::segment(2) == 'buscapolicialparataf')
                                    <th>Parecer do TAF</th>
                                    <th>Observações</th>
                                @endif
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
                                    <tr>
                                        <th>{{$ordem}}</th>
                                        <th>{{$policial->st_postgrad}}</th>
                                        <th>{{$policial->st_numpraca}}</th>
                                        <th>{{$policial->st_matricula}}</th>
                                        <th>{{$policial->st_policial}}</th>
                                        @if(Request::segment(2) == 'policiaisinspecionados' || 'inspecaoparapromocaojpms')
                                            <th>{{$policial->st_inspecaojuntaparecer}}</th>
                                        @endif
                                        @if(Request::segment(2) == 'policiaisinspecionados' || Request::segment(2) == 'inspecaoparapromocaojpms' || Request::segment(2) == 'buscapolicialparainspecaodesaude')
                                            <th>{{$policial->st_inspecaojuntaobs}}</th>
                                        @endif
                                        @if(Request::segment(2) == 'realizartaf' || Request::segment(2) == 'realizartafinspecionado')
                                            <th>{{$policial->st_inspecaotafparecer}}</th>
                                            <th>{{$policial->st_inspecaotafobs}}</th>
                                        @endif
                                        <th>
                                        @if(isset($atividade) && empty($atividade->dt_atividade))
                                            @if(Request::segment(2) == 'escriturarfichadereconhecimento')
                                                <a href="{{url('promocao/escriturarfichadereconhecimento/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial.'/competencia/'.$competencia)}}" class='btn btn-primary' title="Escriturar ficha">
                                                    Escriturar
                                                </a>
                                                <a href="{{url('promocao/escriturarfichadereconhecimento/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial.'/competencia/'.$competencia.'/pdf')}}" class="btn btn-primary" title="Visualizar PDF">
                                                    <span class="fa fa-print"></span>
                                                </a>
                                            @elseif(Request::segment(2) == 'policiaisinspecionados' || Request::segment(2) == 'inspecaoparapromocaojpms' || Request::segment(2) == 'buscapolicialparainspecaodesaude')
                                                <button type="button" onclick="populaModalParecerJPMS({{$policial->ce_policial}}, {{$policial->ce_quadroacesso}}, {{$atividade->id}}, {{ "'" . (($policial->st_inspecaojuntaparecer == null) ? 'null' : $policial->st_inspecaojuntaparecer) . "'" }}, {{ "'" . (($policial->st_inspecaojuntaobs == null) ? 'null' : $policial->st_inspecaojuntaobs) . "'" }})" data-toggle="modal" data-target="#modalPerecerJPMS" title='Parecer da JPMS' class="btn btn-primary">
                                                    Parecer JPMS
                                                </button>
                                            @elseif(Request::segment(2) == 'realizartaf' || Request::segment(2) == 'realizartafinspecionado' || Request::segment(2) == 'buscapolicialparataf')
                                                <button type="button" onclick="popularModalRealizarTaf({{$policial->ce_policial}}, {{$policial->ce_quadroacesso}}, {{$atividade->id}}, {{ "'" . (($policial->st_inspecaotafparecer == null) ? 'null' : $policial->st_inspecaotafparecer) . "'" }}, {{ "'" . (($policial->dt_taf == null) ? 'null' : $policial->dt_taf) . "'" }}, {{ "'" . (($policial->st_inspecaotafobs == null) ? 'null' : $policial->st_inspecaotafobs) . "'" }})" data-toggle="modal" data-target="#modalRealizarTaf" class="btn btn-primary">
                                                    Realizar TAF
                                                </button>
                                            @endif
                                        @endif
                                        </th>
                                    </tr>
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
                </div>
            </div>
        </div>
        <div class="form-row">
            <a href="{{url('promocao/quadro/cronograma/'.$quadro->id.'/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>
            @if(isset($atividade) && empty($atividade->dt_atividade) && (Request::segment(2) == 'policiaisinspecionados' || Request::segment(2) == 'inspecaoparapromocaojpms'))
                <button onclick="populaModalConcluirInspecaoJPMS({{$quadro->id}}, {{$atividade->id}})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirInspecaoJPMS">
                    Concluir Inspeção da JPMS
                </button>
            @elseif(Request::segment(2) == 'realizartaf' || Request::segment(2) == 'realizartafinspecionado')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirTaf">
                    Concluir Realização de TAF
                </button>
            @endif
        </div>
    </div>
    <!--Modal para Realizar TAF-->
    <div class="modal fade" id="modalRealizarTaf" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Realizar TAF</h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="realizarTaf" method="POST">
                        {{csrf_field()}}
                        <h4>Parecer</h4>
                        <select class="form-control" required id="st_inspecaotafparecer" name="st_inspecaotafparecer">
                            <option value="" selected>Selecione</option>
                            <option value="Apto">Apto</option>
                            <option value="Inapto">Inapto</option>
                        </select>
                        <br>
                        <h4>Data de TAF</h4>
                        <input id="dt_taf" type="date" class="form-control" name="dt_taf" value="{{date('Y-m-d')}}">
                        <br>
                        <h4>Observação</h4>
                        <textarea class="form-control" id="st_inspecaotafobs" rows="3" name="st_inspecaotafobs"></textarea>
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
    <!--Modal para Concluir Realização de TAF-->
    <div class="modal fade" id="modalConcluirTaf" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmação de Policial</h4>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title">Atenção!</h4>
                    <div classe>
                        Atenção! Ao concluir a realização de TAF, não será mais possível realizar TAF para este quadro de acesso.
                        <br><br>
                        Deseja continuar?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Não</button>
                    <button onclick="modalConcluirTAFSenha({{$quadro->id}}, {{$atividade->id}})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirTafComSenha" data-dismiss="modal">
                        Sim
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal para Concluir Realização de TAF com senha-->
    <div class="modal fade" id="modalConcluirTafComSenha" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Concluir Realização de TAF</h4>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title">Atenção!</h4>
                    <div classe>
                        É necessario assinar eletrônicamente a conclusão de TAF.
                    </div>
                </div>
                <div class="modal-body">
                    <form role="form" id="concluirTaf" method="POST">
                        {{csrf_field()}}
                        <h4>Informe a Senha:</h4>
                        <input id="password" type="password" class="form-control" name="password" value="" placeholder="Digite sua senha..." required>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="concluirTaf" class="btn btn-primary">Concluir</button>
                        </div>
                    </form>
                </div>
            </div>
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
                    <a id="btn_concluirInspecao"  class="btn btn-primary" >Concluir Inspeção</a>
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
    function populaModalParecerJPMS(idPolicial, idQuadroAcesso, idAtividade, parecer, obs){
        $("#parecerJPMS").attr("action", "{{url('promocao/parcererjpms')}}/"+idPolicial+"/"+idQuadroAcesso+'/'+idAtividade);
        if(parecer != 'null'){
            $('#st_inspecaojuntaparecer').val(parecer);
        }
        if(obs != 'null'){
            $('#st_inspecaojuntaobs').val(obs);
        }
    }
    function populaModalConcluirInspecaoJPMS(idQuadroAcesso, idAtividade){
        $("#btn_concluirInspecao").attr("href", "{{url('promocao/concluirInspecaojpms')}}/"+idQuadroAcesso+'/'+idAtividade);
    }
    function popularModalRealizarTaf(idPolicial, idQuadroAcesso, idAtividade, parecer, data, obs){
        $("#realizarTaf").attr("action", "{{url('promocao/realizartafpolicial')}}/"+idQuadroAcesso+"/"+idAtividade+"/"+idPolicial);
        if(parecer != 'null'){
            $('#st_inspecaotafparecer').val(parecer);
        }
        if(data != 'null'){
            $('#dt_taf').val(data);
        }
        if(obs != 'null'){
            $('#st_inspecaotafobs').val(obs);
        }
    }
    function modalConcluirTAFSenha(idQuadroAcesso, idAtividade){
        $("#concluirTaf").attr("action", "{{url('promocao/concluirtaf')}}/"+idQuadroAcesso+'/'+idAtividade);
    }
</script>
@stop