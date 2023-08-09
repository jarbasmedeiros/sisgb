@extends('adminlte::page')

@section('title', 'Lista de Tipo de Registro')
@can('Admin')
@section('content_header')
    <a href="{{url('rh/tiporegistro/create')}}"><h1 class="btn btn-primary">Novo Tipo de Registro</h1></a>
@stop
@endcan

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="6">LISTA DE TIPOS DE REGISTRO</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">TIPO</th>
                            <th class="col-md-5">DESCRIÇÃO</th>
                            @can('Admin')
                            <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($tiposregistro))
                            @forelse($tiposregistro as $tr)
                            <tr>
                                <th>{{$tr->st_tipo}}</th>
                                <th>{{$tr->st_descricao}}</th>
                                @can('Admin')
                                <th>
                                    <a class="btn btn-primary" href="{{url('rh/tiporegistro/edita/'.$tr->id)}}">Editar</a> | 
                                    <a onclick="modalDesativa({{$tr->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger">
                                    <i class="fa fa-trash"></i></a> 
                                </th>
                                @endcan
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Nenhum tipo de registro cadastrado</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Modal Desativa usuário -->
    <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Exculir Tipo de Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-inline" id="modalDesativa" method="post" > {{csrf_field()}}
                    <div class="modal-body bg-danger">
                        <h4 class="modal-title" id="exampleModalLabel">
                            <b>DESEJA REALMENTE EXCLUIR O TIPO DE REGISTRO?</b>
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
    <script>
        function modalDesativa(id){
            $("#modalDesativa").attr("action", "{{ url('rh/tiporegistro/desativa')}}/"+id);
            $('#Modal').modal();        
        };
    </script>

@stop