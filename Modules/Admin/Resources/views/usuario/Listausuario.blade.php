@extends('adminlte::page')

@section('title', 'Usuarios')

@section('css')
<style>
    .ml-25 {
        margin-left: 25px;
    }
    th {
        text-align: center
    }
</style>
@endsection

@can('Administrador')
    @section('content_header')
       <div class='col-md-2'> 
            <a href="{{url("admin/usuario/create")}}" class="btn btn-primary">
                <i class="fa fa-user-plus"></i> Novo Usuário
            </a>
        </div>
        <div class="col-md-9 form-group">
            <form class="form-inline" role="form" method="get" action='{{ url("admin/usuarios/consulta/buscarUsuario") }}' >
                
                <div class="form-group{{ $errors->has('st_parametro') ? ' has-error' : '' }} col-md-2 col-md-offset-2">
                    <input id="st_parametro " type="text" class="form-control" placeholder="CPF/Nome do usuário" name="st_parametro"  required> 
                    @if ($errors->has('st_parametro '))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_parametro ') }}</strong>
                    </span>
                    @endif
                </div>
            <div class='col-md-2 form-group ml-25'>
                <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Consultar Usuário</button>                                                                                        
            </div>
            </form>
        </div>
    @stop
@endcan

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
            <fieldset class="scheduler-border">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="5">LISTA DE USUÁRIOS</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-2">CPF</th>
                            <th class="col-md-1">MATRÍCULA</th>
                            <th class="col-md-2">EMAIL</th>
                            @can('Administrador')
                                <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($usuarios) && count($usuarios)>0)
                            @foreach($usuarios as $u)
                        <tr>
                            <td>{{$u->name}}</td>
                            <td class="text-center">{{$u->st_cpf}}</td>
                            <td class="text-center">{{$u->matricula}}</td>
                            <td>{{$u->email}}</td>
                            @can('Administrador')
                                <td class="text-center">
                                    <a class="btn btn-primary fa fa-pencil-square" href="{{url('admin/usuario/edit/'.$u->id)}}" title="Editar"></a> | 
                                    {{-- <a class="btn btn-warning fa fa-link" href="{{url('admin/usuario/vinculos/'.$u->id)}}" title="Vincular unidades"></a> | --}}
                                    {{-- <a class="btn btn-warning fa fa-unlock-alt" href="{{url('admin/usuario/vinculos/'.$u->id.'/perfil')}}" title="Alterar permissões"></a> | --}}
                                    <a class="btn btn-info fa fa-key" href="{{ route('formEditaVinculos', ['idUsuario' => $u->id]) }}" title="Alterar vínculos"></a> |
                                    <a onclick="modalDeleta({{$u->id}})" data-toggle="modal" data-placement="top" title="Cancelar Usuário" class="btn btn-danger fa fa-ban"></a>
                                </td>
                            @endcan
                        </tr>
                        @endforeach
                        @else
                            <tr onmouseOver="this.style.background='#F8F8FF'" onmouseOut="this.style.background='white'">
                                <td colspan="6" cl style="text-align: center;"><strong>Nenhum resultado encontrado.</strong></td>
                            </tr>

                        @endif
                       
                    </tbody>
                </table>
            </fieldset>
            </div>
        </div>
        @if(isset($usuarios) && count($usuarios)>0)
            <div class="pagination pagination-centered">
                <tr>
                <th>
                    {{$usuarios->appends($_GET)->links()}}
                </th>
                </tr>
            </div>
        @endif
    </div>

    <!--Modal Desativa usuário -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR O USUÁRIO?</b>
                    </h4>
                    <form class="form-inline" id="modalDeleta" method="post" > {{csrf_field()}}
    
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
  
        function modalDeleta(id){
            $("#modalDeleta").attr("action", "{{ url('admin/usuario/destroy')}}/"+id);
            $('#Modal').modal();        
        };

    </script>

@stop