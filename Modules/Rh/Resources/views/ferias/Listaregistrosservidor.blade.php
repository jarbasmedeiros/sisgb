@extends('rh::funcionario.Form_edita_funcionario')
@section('tabcontent')
@section('title', 'Férias')
@php
    $contador = 0;
    $id_crs = null;
    $caderneta = NULL;
    $id_crs = 1;
@endphp
@can('Edita')
    <a class="btn btn-primary" href="{{url('rh/registro/'.$funcionario.'/'.$tiporegsitro)}}">Novo Registro</a>
    <a class="btn btn-primary" href="{{url('/rh/listacrportipo/'.$funcionario.'/'.$tiporegsitro.'/impressao')}}">
        <i class="fa fa-fw fa-print"></i> Imprimir
    </a>
@endcan
<div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12">
        <table class="table table-bordered">
            @if(isset($registros) && count($registros) > 0)
                <thead>
                    <tr class="bg-primary">
                        <th colspan="8">
                            @if(isset($registros))
                                Lista de {{$registros[0]->st_tiporegistro}} - {{$servidor->st_nome}}
                            @endif
                        </th>
                    </tr>
                    <tr>
                        @if(isset($registros))
                            @php
                                $nomesdositens = $registros[0]->registros;
                            @endphp
                            @foreach($nomesdositens as $item)
                                @if($item->ce_item != 19)
                                    <th class="col-md-1 col-lg-1 col-xs-1">{{$item->st_nomedoitem}}</th>
                                @endif
                            @endforeach
                            @if($tiporegsitro == 1)
                                <th class="col-md-2 col-lg-2 col-xs-2">Situação</th>
                            @endif
                            <th class="col-md-2 col-lg-2 col-xs-2">BG</th>
                            @can('Edita')
                                <th class="col-md-2 col-lg-2 col-xs-2">AÇÕES</th>
                            @endcan
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(isset($registros))
                        @foreach($registros as $r)
                            <tr>
                                <form method='POST' action="{{url('/rh/editaferias/'.$funcionario.'/'.$tiporegsitro)}}">
                                    {{csrf_field()}}
                                    @php
                                        $caderneta = $r->registros;
                                        $id_crs = $r->id;
                                    @endphp
                                    @foreach($caderneta as $valor)
                                        @if($valor->tipoitem == 'Data')
                                            <th>
                                                @if(isset($valor->st_valor) && $valor->st_valor != 'NULL')
                                                    {{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}
                                                @endif
                                            </th>
                                        @elseif($valor->tipoitem == "Texto longo")
                                            <th>
                                                @if(strlen($valor->st_valor) > 100)
                                                    <div class="collapseOne{{$valor->id}} in">{{substr($valor->st_valor,0,50)}}</div>
                                                    <a class="accordion-toggle" data-toggle="collapse" id="sanfona{{$valor->id}}" aria-expanded="false" href=".collapseOne{{$valor->id}}">Ver mais...</a>
                                                    <div class="accordion-body collapse collapseOne{{$valor->id}}" id="textao{{$valor->id}}">{{$valor->st_valor}}</div>
                                                @else
                                                    {{$valor->st_valor}}
                                                @endif
                                            </th>
                                        @else
                                            @if($valor->ce_item != 19)
                                                @if($valor->st_nomedoitem != "Setor")
                                                    <th>{{$valor->st_valor}}</th>
                                                @else
                                                    <th>{{$listSetor->find($valor->st_valor)->st_sigla}}</th>
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                    @if($tiporegsitro == 1)
                                        <th>{{$r->situacao}}</th>
                                    @endif
                                    <th>Conteúdo</th>
                                    @can('Edita')
                                        <th>
                                            @if($tiporegsitro == 1)
                                                <a class="btn btn-sm btn-success" href="{{url('rh/historicoferias/lista/'.$id_crs)}}" data-toggle="tooltip" title="Histórico" style="margin: 2px;">
                                                    <i class="fa fa-list-ul"></i>
                                                </a>
                                            @endif
                                            <a class="btn btn-sm btn-primary bt_edita" href="{{url('rh/cr/edita/'.$funcionario.'/'.$tiporegsitro.'/'.$id_crs)}}" data-toggle="tooltip" title="Editar" style="margin: 2px;">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <input type="submit" value="Salvar" style="display: none;" id="{{$id_crs}}" class="btn-sm btn-primary $id_crs">
                                            <span data-toggle="modal" data-placement="top">
                                                <a onclick='modalDesativa({{$id_crs}})' data-toggle="tooltip" title="Deletar" class="btn btn-sm btn-danger" style="margin: 2px;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </span>
                                        </th>
                                    @endcan
                                </form>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            @else
                <tr>
                    <td class="col-md-12 bg-danger">Não existe registros para este funcinário.</td>
                </tr>
            @endif
        </table>
    </div>
</div>
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Publicação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-danger">
                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR A PUBLICAÇÃO?</b>
                </h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
    <script>
        $('.accordion-toggle').click(function(){
            $(this).text(function(i, old){
                return old == 'Ver mais...' ? 'Ver menos...' : 'Ver mais...';
            });
        });
        function modalDesativa(id){
            $("#modalDesativa").attr("action", "{{url('rh/cr/destroy')}}/"+id);
            $('#Modal').modal();
        };
    </script>
@endsection