@extends('adminlte::page')

@section('title', 'Listagem de Habilitações')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Lista de Habilitações para Análise
                </div>
                <div class="panel-body">
                    <a href="{{ URL::route('dps_tela_pesquisar_policial') }}" class="btn btn-primary btn-md">
                        <span class="glyphicon glyphicon-plus"></span>
                        Nova Habilitação
                    </a>
                    <hr>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                        @empty($habilitacoes)
                            {{ count($habilitacoes) }} habilitação(oes) para análise
                        @else
                            Habilitações cadastradas
                        @endempty
                        </legend>
                        <table class="table table-hover">
                            <thead class="bg-primary">
                                <th>
                                    Tipo
                                </th>
                                <th>
                                    Data
                                </th>
                                <th>
                                    Protocolo
                                </th>
                                <th>
                                    Solicitante
                                </th>
                                <th>
                                    Vínculo
                                </th>
                                <th>
                                    Policial
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Ações
                                </th>
                            </thead>
                            <tbody>
                                @isset($habilitacoes)
                                    @foreach($habilitacoes as $h)
                                        <tr>
                                            <td>
                                                @if($h->st_tipo == 'POS_MORTE')
                                                    <span
                                                        data-toggle="tooltip" data-placement="top" title="Pós-Morte" 
                                                        class="icon fa fa-user-times fa-2x">
                                                    </span>
                                                @elseif($h->st_tipo == 'JUDICIAL')
                                                    <span
                                                        data-toggle="tooltip" data-placement="top" title="Judicial" 
                                                        class="icon fa fa-legal fa-2x">
                                                    </span>
                                                @else
                                                    <span class="icon fa fa-question fa-2x">

                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{date('d/m/Y', strtotime($h->dt_cadastro))}}
                                            </td>
                                            <td>
                                                {{$h->st_protocolo}}
                                            </td>
                                            <td>
                                                {{$h->solicitante->st_nome}}
                                            </td>
                                            <td>
                                                {{$h->st_vinculo}}
                                            </td>
                                            <td>
                                                {{$h->policial->st_nome}}
                                            </td>
                                            <td>
                                                {{$h->st_status}}
                                            </td>
                                            <td>
                                                <a data-toggle="tooltip" data-placement="top" title="Abrir" href="{{
                                                    URL::route('get_habilitacao_id', ['idHabilitacao' => $h->id])
                                                }}" class="btn btn-primary">
                                                    <span class="icon fa fa-folder-open fa-lg"></span>
                                                </a>

                                                <button data-toggle="tooltip" onclick="buscaHistoricoHabilitacoes(<?php echo($h->id) ?>)" data-placement="top" title="Histórico" href="#" class="btn btn-success">
                                                    <span class="icon fa fa-list fa-lg"></span>
                                                </button>
                                                
                                                @if($h->st_status != 'ABERTO')
                                                    <a data-toggle="tooltip" data-placement="top" title="Analisar" class="btn btn-warning" href="#">
                                                        <span class="icon fa fa-pencil-square-o fa-lg"></span>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                            <tfoot>
                                @empty($habilitacoes)
                                    <tr>
                                        <td colspan="8">
                                            <strong>
                                                <p style="text-align: center;">
                                                    Nenhuma habilitação cadastrada.
                                                </p>
                                            </strong>
                                        </td>
                                    </tr>
                                @endempty
                            </tfoot>
                        </table>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHistorico" tabindex="-1" role="dialog" aria-labelledby="modalHistorico" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick="off()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Histórico de alterações de Habilitação</h4>
                </div>
                <div class="modal-body" id="corpoModal">
                    <div class="table-responsive">
                        <table class="table table-hover dataTable" role="grid">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Data</th>
                                    <th>Usuário</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                    <th>Observação</th>
                                </tr>
                            </thead>
                            <tbody id="historico_habilitacao_tbody">
                                
                            </tbody>
                            <tfoot id="historico_habilitacao_tfoot">

                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secundary center-block" data-dismiss="modal" onclick="off()">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="spinner" class="spinner" style="left: 0;right: 0;top: 0;bottom: 0;font-size: 30px;position: fixed;background: rgba(0,0,0,0.6);width: 100%;height: 100% !important;z-index: 1050; display:none;" >
        <div style="top: 46%; left: 45%; position: absolute; color:white;">CARREGANDO...</div>
    </div>

    <script>
        function buscaHistoricoHabilitacoes(id) {
            $('.spinner').show();    
            $('.spinner').fadeOut(2150);
            
            //Limpa o modal da consulta anterior
            $('#historico_habilitacao_tbody').html("");
            $('#historico_habilitacao_tfoot').html("");

            const url = 'habilitacoes/historico/' + id;
            
            $.ajax({
                url : url,
                type : 'GET'
            }).done(function(historico) {
                if (historico == 'Nenhum resultado encontrado.') {
                    $('#historico_habilitacao_tfoot')
                    .append("<tr>" + "<td colspan=5>" + "<strong>"+
                                "<p style='text-align: center'>"+
                                    "Não há histórico para essa habilitação."+
                                "</p>"+
                            "</strong>" + "</td>" + "</tr>");
                    $('#modalHistorico').modal('toggle');
                } else {
                    $('#modalHistorico').modal('show');
                    for (var i = 0; i < historico.length; i++) {            
                        $('#historico_habilitacao_tbody').append(
                        "<tr>"+
                        "<td>"+moment(historico[i].dt_cadastro).format('DD/MM/YYYY HH:mm')+"</td>"+
                        "<td>"+historico[i].usuario.name+"</td>"+
                        "<td>"+historico[i].st_status+"</td>"+
                        "<td>"+historico[i].st_acao+"</td>"+
                        "<td>"+ (historico[i].st_obs == null ? '' : historico[i].st_obs) +"</td>"+
                        "</tr>");
                    }
                }
            }).fail(function(Request, textStatus, errorThrown) {
                console.log(Request.responseJSON.message);
            })            
        }

        function off() {
            document.getElementById("spinner").style.display = "none";
        }
    </script>
@endsection