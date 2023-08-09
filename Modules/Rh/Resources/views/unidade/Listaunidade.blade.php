@extends('adminlte::page')

@section('title', 'unidades')
@section('content_header')
    @can('Administrador')
    <a href="{{url('rh/unidade/create')}}"><h1 class="btn btn-primary">Nova Unidade</h1></a>
    @endcan
    <a href="{{url('rh/unidades/pdf')}}"><h1 class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Imprimir lista de unidades</h1></a>
    @stop

@section('content')
    <div class="content">
            <div class="row">
                <div class="col-md-12">

                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan="6">LISTA DE unidades</th>
                            </tr>
                            <tr>
                                <th class="col-md-3">SIGLA</th>
                                <th class="col-md-2">DESCRIÇÃO</th>
                                <th class="col-md-2">HIERARQUIA</th>
                                @can('Admin')
                                <th class="col-md-2">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($unidades))
                            @foreach($unidades as $s)
                        <tr>
                            <th>{{$s->st_sigla}}</th>
                            <th>{{$s->st_descricao}}</th>
                            <th>{{$s->hierarquia}}</th>
                            @can('Administrador')
                            <th><a class="btn btn-primary" href="{{url('rh/unidade/edita/'.$s->id)}}">Editar</a> | 
                                <a onclick="modalDesativa({{$s->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger">
                                <i class="fa fa-trash"></i></a> 
                            </th>
                            @endcan
                        </tr>
                        @endforeach
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
                    <h5 class="modal-title" id="exampleModalLabel">Excluir unidade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR A UNIDADE?</b>
                    </h4>
                    <form class="form-inline" id="modalDesativa" method="post" > {{csrf_field()}}
    
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
               
               $("#modalDesativa").attr("action", "{{ url('rh/unidade/destroy')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>
@stop