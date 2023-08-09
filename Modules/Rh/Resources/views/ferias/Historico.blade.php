@extends('adminlte::page')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Histórico de Férias</div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="col-md-12">
                                <label>Nome: {{ $policial->st_nome }}</label>
                            </div>
                            <div class="col-md-12">
                                <label>Ano de Referência: {{ $ferias->st_anoreferencia }}</label>
                            </div>
                            <div class="col-md-12">
                                <label>Plano anual: {{date('d/m/Y', strtotime($ferias->dt_inicio))}} - {{date('d/m/Y', strtotime($ferias->dt_termino))}}</label>
                            </div>
                            <div class="col-md-12">
                                <label>Faltam agendar {{$faltaAgendar}} dias de férias.</label>
                            </div>
                            <div class="col-md-12">
                                <label>Quantidade de dias usufruídos {{$ferias->nu_dias_gozadas}}.</label>
                            </div>
                            <div class="col-md-12">
                                <a href="{{url('rh/policiais/edita/' . $policial->id . '/ferias')}}" class=" btn btn-warning" title="Voltar">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>
                                @can('Edita')
                                    @if(($faltaAgendar) > 0)
                                        <a class="btn btn-primary" href="{{url('rh/historicoferias/create/' . $policial->id . '/' . $ferias->id)}}">Novo Período</a>
                                    @endif        
                                @endcan
                            </div>
                            <table class="table table-bordered col-md-12 col-lg-12 col-xs-12">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="12">Histórico</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1">Data de Cadastro</th>
                                        <th colspan="1">Tipo</th>
                                        <th colspan="1">Dias</th>
                                        <th colspan="1">Início</th>
                                        <th colspan="1">Fim</th>
                                        <th colspan="1">Status</th>
                                        <th colspan="5">Observação</th>
                                        <th colspan="1">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($ferias->historicos as $h)
                                            @php
                                                $status = "";
                                                if($h->st_status == "Assegurado" || $h->st_status == "Cancelado" ){
                                                    $status = $h->st_status;
                                                }elseif($h->st_tipo == 'Ferias' ||$h->st_tipo == 'FÉRIAS'){
                                                    if($h->dt_fim < date('Y-m-d')){
                                                        $status = "Usufruído";
                                                    }elseif($h->dt_inicio > date('Y-m-d')){
                                                        $status = "Agendada";
                                                    }else{
                                                        $status = "Em período de gozo";
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td colspan="1">
                                                    @if(isset($h->dt_cadastro) && $h->dt_cadastro != 'NULL')
                                                        {{date('d/m/Y', strtotime($h->dt_cadastro))}}
                                                    @endif
                                                </td>
                                                <td colspan="1">{{$h->st_tipo}}</td>
                                                <td colspan="1">{{$h->nu_dias}}</td>
                                                <td colspan="1">
                                                    @if(isset($h->dt_inicio) && $h->dt_inicio != 'NULL')
                                                        {{date('d/m/Y', strtotime($h->dt_inicio))}}
                                                    @endif
                                                </td>
                                                <td colspan="1">
                                                    @if(isset($h->dt_fim) && $h->dt_fim != 'NULL')
                                                        {{date('d/m/Y', strtotime($h->dt_fim))}}
                                                    @endif
                                                </td>
                                                <td colspan="1">{{$status}}</td>
                                                <td colspan="5">
                                                    @if(strlen($h->st_descricao) > 100)
                                                        <div class="collapseOne{{$h->id}} in">{{ substr($h->st_descricao,0,50) }}</div>
                                                            <a class="accordion-toggle" data-toggle="collapse" id="sanfona{{$h->id}}" aria-expanded="false" href=".collapseOne{{$h->id}}">Ver mais...</a>
                                                        <div class="accordion-body collapse collapseOne{{$h->id}}" id="textao{{$h->id}}">{{$h->st_descricao}}</div>
                                                    @else
                                                        {{$h->st_descricao}}
                                                    @endif
                                                </td>
                                                <th colspan="2">
                                                    @can('Edita_rh')
                                                        @if($status != "Assegurado" && $status != "Usufruído" && $status != "Cancelado" )
                                                            <a class="btn btn-sm btn-warning bt_edita" href="{{url('rh/historicoferias/edit/' . $policial->id . '/' . $ferias->id . '/' . $h->id)}}" data-toggle="tooltip" title="Editar" style="margin: 2px;"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if(($h->st_tipo == "Ferias" || $h->st_tipo == "FÉRIAS") && $h->st_status != "Assegurado" && $h->st_status != "Cancelado" )
                                                            <span data-toggle="modal" data-placement="top">
                                                                <a onclick='modalAssegurar({{$h->id}}, {{$ferias->id}})' data-toggle="tooltip" title="Assegurar Férias" class="btn btn-sm btn-success" style="margin: 2px;">
                                                                <i class="fa fa-share-square-o"></i></a>
                                                            </span>
                                                            <span data-toggle="modal" data-placement="top">
                                                                <a onclick='modalCancelar({{$h->id}}, {{$ferias->id}})' data-toggle="tooltip" title="Cancelar Férias" class="btn btn-sm btn-danger" style="margin: 2px;">
                                                                <i class="fa fa-close"></i></a>
                                                            </span>
                                                        @endif
                                                    @endcan
                                                </th>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Assegurar Férias -->
    <div class="modal fade-lg" id="ModalAssegurar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>ASSEGURAR AS FÉRIAS</b>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-inline" id="modalAssegurar" method="post"> {{csrf_field()}}
                        <div class="col-md-12">
                            <label>Justificativa:</label>
                        </div>
                        <textarea id="st_descricao" name="st_descricao" cols="120" rows="6" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Cancelar Férias -->
    <div class="modal fade-lg" id="ModalCancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>CANCELAR AS FÉRIAS</b>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-inline" id="modalCancelar" method="post"> {{csrf_field()}}
                        <div class="col-md-12">
                            <label>Justificativa:</label>
                        </div>
                        <textarea id="st_descricao" name="st_descricao" cols="120" rows="6" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        function modalAssegurar(idHistorico, idFerias) {
            $("#modalAssegurar").attr("action", "{{ url('rh/historicoferias/store/assegurar')}}/" + idHistorico + "/" + idFerias);
            $('#ModalAssegurar').modal();
            $('<input>').attr({
                type: 'hidden',
                id: 'id_historico',
                name: 'id_historico',
                value: id
            }).appendTo('#modalAssegurar');
        };
        function modalCancelar(idHistorico, idFerias) {
            $("#modalCancelar").attr("action", "{{ url('rh/historicoferias/store/cancelar')}}/" + idHistorico + "/" + idFerias);
            $('#ModalCancelar').modal();
            $('<input>').attr({
                type: 'hidden',
                id: 'id_historico',
                name: 'id_historico',
                value: id
            }).appendTo('#modalCancelar');
        };

        $('.accordion-toggle').click(function(){
            $(this).text(function(i,old){
                return old=='Ver mais...' ?  'Ver menos...' : 'Ver mais...';
            });
        });
    </script>
@endsection