@extends('promocao::abas')
@section('title', 'Homologar Ficha')
@php
    use app\utis\Funcoes;
@endphp

@section('css')
<style>
    th, td { text-align: center; }
    .mt-30 { margin-top: 30px; }
    .ml-72 { margin-left: 72px; }
    .mr-15 { margin-right: 15px; }
</style>
@endsection

@php 

    if (isset($graduacao)) {

        if ($graduacao === 'todos') {
            $exibeGraduacao = 'Todas as graduações';

        } elseif ($graduacao === '1sgt') {
            $exibeGraduacao = '1º Sgts';

        } elseif ($graduacao === '2sgt') {
            $exibeGraduacao = '2º Sgts';

        } elseif ($graduacao === '3sgt') {
            $exibeGraduacao = '3º Sgts';

        } elseif ($graduacao === 'cb') {
            $exibeGraduacao = 'CBs';

        } elseif ($graduacao === 'sd') {
            $exibeGraduacao = 'SDs';

        } else {
            $exibeGraduacao = null;
        }
    }

    $contador = 0;
    if(isset($contador_inicial)){
        $contador = $contador + $contador_inicial;
    }

    setlocale(LC_TIME, 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');

@endphp

@section('tabcontent')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div class="col-md-10">  
                    <h4>{{(isset($policiaisQuadro) && count($policiaisQuadro) > 0) ? $policiaisQuadro->total() : '0'}} {{$titulopainel}} <b>{{date('d/m/Y', strtotime($quadro->dt_promocao))}}</b>. &nbsp; {{ $exibeGraduacao or ''}}</h4>
                </div>
                <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: '.$nota->st_status : ''}}</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    <div class="form-row form-inline col-md-5 col-md-offset-3">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Localizar Policial no QA</legend>
                            <form id="form" method="POST" action="{{url('promocao/buscapolicialparahomologar/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}">
                                {{csrf_field()}}
                                <div class="form-group col-xs-12 col-md-12 col-sm-12" style="margin-left:auto; margin:10px;">
                                    <select class="form-control" name="st_criterio" required>
                                        <option value="st_matricula" selected>Matrícula</option>
                                        <option value="st_cpf">CPF</option>
                                        <option value="st_policial">Nome</option>
                                    </select>
                                    <input type="text" class="form-control" id="st_policial" name="st_filtro" placeholder="Matrícula ou CPF" required>
                                    <button type="submit" class="btn btn-primary glyphicon glyphicon-search" title="Localizar Policial" style="margin-bottom:2px;"></button>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
                <div>
                    <table class="table table-responsive table-bordered table-striped" id="policiais">
                        <thead>
                            <tr class="bg-primary">
                                <th>Ordem</th>
                                <th>Post/Grad</th>
                                <th>Praça</th>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                <th class="col-md-3">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            //dd($policiaisQuadro);
                            @endphp
                            @if(isset($policiaisQuadro) && count($policiaisQuadro) > 0)
                                @foreach($policiaisQuadro as $policial)
                                    @php
                                        $contador++
                                    @endphp
                                    <tr>
                                        <td>{{$contador}}</td>
                                        <td>{{$policial->st_postgrad}}</td>
                                        <td>{{$policial->st_numpraca}}</td>
                                        <td>{{$policial->st_matricula}}</td>
                                        <td>{{$policial->st_policial}}</td>
                                        <td class="text-left">
                                       
                                            @can('HOMOLOGAR_FICHA_RECONHECIMENTO')
                                                @if($policial->bo_fichahomologada == 0)
                                                    <a href="{{url('promocao/homologarfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial.'/competencia/'.$competencia)}}" class='btn btn-sm btn-primary'>
                                                        Homologar
                                                    </a>
                                                @else
                                                <a href="{{url('promocao/fichas/visualizarhomologadas/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial.'/competencia/'.$competencia)}}" title="Visualizar Fichas de Reconhecimento" class="btn btn-sm btn-primary">
                                                    <span class="fa fa fa-eye"></span>
                                                 </a>
                                                 @endif
                                            @else 
                                                <a href="{{url('promocao/fichas/visualizarhomologadas/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial.'/competencia/'.$competencia)}}" title="Visualizar Fichas de Reconhecimento" class="btn btn-sm btn-primary">
                                                    <span class="fa fa fa-eye"></span>
                                                </a>
                                            @endcan
                                         
                                            <a onclick="buscaHistoricoNotas({{$quadro->id}}, {{$policial->ce_policial}})" title="Histórico" class="btn btn-sm btn-primary">
                                                <span class="fa fa-history"></span>
                                            </a>
                                            @if ( $policial->bo_fichahomologada == 1 )
                                                @can('GERENCIAR_QA')
                                                    <button type="button" class="btn btn-sm btn-success" title="Reabrir Homologação" onclick="reabrirHomologarFicha( '{{$quadro->id}}', '{{$atividade->id}}', '{{$policial->ce_policial}}', '{{$competencia}}' )" data-toggle="modal" data-target="#modalConfirmarReabrirFicha">
                                                        <i class="fa fa-gavel"></i>
                                                    </button>
                                                @endcan
                                                @can('LIBERAR_FICHA_RECONHECIMENTO_RECURSO')
                                                    @if ( $quadro->bo_recursoliberado && !$policial->bo_recorreu )
                                                        <a href="{{url('promocao/alterarstatusrecurso/policial/'.$policial->ce_policial.'/'.$quadro->id.'/'.$atividade->id)}}" class='btn btn-sm btn-success ' title="Liberar ficha para recurso">
                                                            <i class="fa fa-balance-scale"></i> 
                                                        </a>
                                                    @endif
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">Nenhum policial encontrado</td>
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
            {{-- essa rota volta para a tela do organograma do QA  --}}
            {{-- <a href="{{url('promocao/quadro/cronograma/'.$quadro->id.'/competencia/'.$competencia)}}" class="col-md-1 btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a> --}}
            {{-- essa rota leva para a tela dos QAs --}}
            <a href="{{url('promocao/listadequadrodeacesso/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>
            @if (isset($exibeBotaoExcel) && ($exibeBotaoExcel))
          
                <a href="{{url('promocao/fichasreconhecimento/excel/pendencias/consta/'.$quadro->id.'/'.$atividade->id)}}" class="btn btn-success" title="Exportar lista de policiais sem pendências para a promoção de {{date('d/m/Y', strtotime($quadro->dt_promocao))}}. Formato: Excel.">
                    <span class="fa fa-file-excel-o"></span> Sem pendências
                </a>
                <a href="{{url('promocao/fichasreconhecimento/excel/pendencias/naoconsta/'.$quadro->id.'/'.$atividade->id)}}" class="btn btn-danger" title="Exportar lista de policiais com pendências para a promoção de {{date('d/m/Y', strtotime($quadro->dt_promocao))}}. Formato: Excel.">
                    <span class="fa fa-file-excel-o"></span> Com pendências
                </a>
                <a href="{{url('promocao/fichasreconhecimento/policiais/recorreram/'.$quadro->id)}}" class="btn btn-primary" title="Exportar lista de policiais que recorreram para a promoção de {{date('d/m/Y', strtotime($quadro->dt_promocao))}}. Formato: Excel.">
                    <span class="fa fa-file-excel-o"></span> Recursos realizados
                </a>
            @endif
        </div>
    </div>
</div>

<!--Modal para confirmação da homologação do documento-->
<div class="modal fade" id="modalConfirmarReabrirFicha" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="reabreHomologacao" action="" method="post">
                {{ csrf_field() }}
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reabrir Homologação</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password" class="col-md-2 control-label" style="margin-top: 5px;">Senha</label>
                        <div class="col-md-10">
                            <input id="password" type="password" class="form-control" name="password" value="" placeholder="Digite sua senha..." required>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    <button type="submit" title="Concluir Ficha" class="btn btn-info">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal de histórico do QA-->
    
<div class="modal fade" id="modalHistorico" tabindex="-1" role="dialog" aria-labelledby="modalHistorico" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Histórico de alterações da Ficha</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable" role="grid">
                        <thead>
                            <tr class="bg-primary">
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>CPF</th>
                                <th>Status</th>
                                <th>Ação</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody id="historico_nota_tbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secundary center-block" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div id="spinner" class="spinner" style="left: 0;right: 0;top: 0;bottom: 0;font-size: 30px;position: fixed;background: rgba(0,0,0,0.6);width: 100%;height: 100% !important;z-index: 1050; display:none;" >
    <div style="top: 46%; left: 45%; position: absolute; color:white;">CARREGANDO...</div>
</div>


@stop

@section('js')
    <script>

        function reabrirHomologarFicha(idQuadro, idAtividade, idPolicial, competencia){
            $("#reabreHomologacao").attr("action", "{{url('promocao/deshomologar/fichadereconhecimento')}}/"+idQuadro+"/"+idAtividade+"/"+idPolicial+"/competencia/"+competencia);
        };

        function buscaHistoricoNotas(idQuadro, idPolicial){
            
            //Limpa o modal da consulta anterior
            $('#historico_nota_tbody').html("");
            
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            baseUrl += "/";
           
            $.ajax({
                url : baseUrl + "promocao/historico/quadrosacessos/" + idQuadro + "/" + idPolicial,
                type : 'get'
            }).done(function(historicos){
                
                if (historicos.retorno) {
                    alert(historicos.msg)

                } else if (historicos.lenght == 0) {
                    alert('Nenhum histórico encontrado!')

                } else {
                    $('#modalHistorico').modal('show');
                        for (var i = 0; i < historicos.length; i++){

                            if (historicos[i].st_obs == null){
                                var observacoes = "";
                            }else{
                                var observacoes = historicos[i].st_obs;
                            }
                                      
                            $('#historico_nota_tbody').append(
                                "<tr>"+ //Formata a data para dd/mm/yyyy hh:mm:ss
                                "<td>"+moment(historicos[i].dt_cadastro).format('DD/MM/YYYY HH:mm:ss')+"</td>"+
                                "<td>"+historicos[i].st_policialacao+"</td>"+
                                "<td>"+historicos[i].st_cpfpolicialacao+"</td>"+
                                "<td>"+historicos[i].st_status+"</td>"+
                                "<td>"+historicos[i].st_acao+"</td>"+
                                "<td>"+observacoes+"</td>"+
                                "</tr>");
                            
                        }
                }
                    
            }).fail(function(jgXHR, textStatus, historicos){
                alert('Falha na requisição do histórico!')
            })
            
        }

    </script>
@stop