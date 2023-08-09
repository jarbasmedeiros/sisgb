@extends('adminlte::page')

@section('title', 'Lista de Órgãos')
@can('Administrador')
@section('content_header')
    <a href="{{url('rh/orgao/create1')}}"><h1 class="btn btn-primary">Novo Órgão</h1></a>
    <a href="{{url('rh/orgaos/pdf')}}"><h1 class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Imprimir lista de Órgãos</h1></a>
@stop
@endcan

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="6">LISTA DE ÓRGÃOS</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-2">SIGLA</th>
                            <th class="col-md-1">DESCRIÇÃO</th>
                            @can('Admin')
                            <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($orgaos))
                            @foreach($orgaos as $org)
                        <tr>
                            <th>{{$org->st_orgao}}</th>
                            <th>{{$org->st_sigla}}</th>
                            <th>{{$org->st_descricao}}</th>
                            @can('AdmAdministradorin')
                            <th><a class="btn btn-primary" href="{{url('rh/orgao/edita/'.$org->id)}}">Editar</a> | 
                                <a onclick="modalDesativa({{$org->id}})" data-toggle="modal" data-placement="top" title="Receber" class="btn btn-danger">
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

    <!--Modal Desativa órgão -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Exculir Órgão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR O ÓRGÃO?</b>
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
               
               $("#modalDesativa").attr("action", "{{ url('rh/orgao/destroy')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>

@stop