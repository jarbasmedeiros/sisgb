@extends('adminlte::page')

@section('title', 'home')
@can('Administrador')
    @section('content_header')
        <a href="{{url("usuario/create")}}"><h1 class="btn btn-primary">Novo Usuário</h1></a>
    @stop
@endcan

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="6">LISTA DE USUÁRIOS</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-2">CPF</th>
                            <th class="col-md-1">MATRÍCULA</th>
                            <th class="col-md-2">EMAIL</th>
                            <th class="col-md-2">PERFIL</th>
                            @can('Admin')
                            <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($usuarios))
                            @foreach($usuarios as $u)
                        <tr>
                            <th>{{$u->name}}</th>
                            <th>{{$u->st_cpf}}</th>
                            <th>{{$u->matricula}}</th>
                            <th>{{$u->email}}</th>
                            <th>{{$u->nome_perfil}}</th>
                            @can('Administrador')
                            <th>
							<a class="btn btn-primary" href="{{url('usuario/edita/'.$u->id)}}">Editar</a> | 
                                <a onclick="modalDesativa({{$u->id}})" data-toggle="modal" data-placement="top" title="Receber" class="btn btn-danger">
                                <span class="glyphicon glyphicon-ban-circle" title='Cancelar Usuario'></span></a> 
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
                    <h5 class="modal-title" id="exampleModalLabel">Exculir Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR O USUÁRIO?</b>
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
               
               $("#modalDesativa").attr("action", "{{ url('usuario/desativa')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>

@stop