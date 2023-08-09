@extends('adminlte::page')

@section('title', 'Função')
@can('Administrador')
@section('content_header')
    <a href="{{url("rh/funcao/create")}}"><h1 class="btn btn-primary">Nova Função</h1></a>
@stop
@endcan

@section('content')
    <div class="content">
            <div class="row">
                <div class="col-md-12">

                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan="6">LISTA DE FUNÇÕES</th>
                            </tr>
                            <tr>
                                <th class="col-md-3">FUNÇÃO</th>
                                <th class="col-md-2">DATA DE CADASTRO</th>
                                @can('Admin')
                                <th class="col-md-2">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($funcoes))
                            @foreach($funcoes as $f)
                        <tr>
                            <th>{{$f->st_funcao}}</th>
                            <th>{{\Carbon\Carbon::parse($f->dt_cadastro)->format('d/m/Y')}}</th>
                            @can('Administrador')
                            <th><a class="btn btn-primary" href="{{url('rh/funcao/edita/'.$f->id)}}">Editar</a> | 
                                <a onclick="modalDesativa({{$f->id}})" data-toggle="modal" data-placement="top" title="Deletar" class="btn btn-danger">
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
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Função</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR A FUNÇÃO?</b>
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
               
               $("#modalDesativa").attr("action", "{{ url('rh/funcao/destroy')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>
@stop