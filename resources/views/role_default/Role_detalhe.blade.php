@extends('adminlte::page')

@section('title', 'Perfil')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="4">PERFIL</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-2">Descrição</th>
                            <th class="col-md-2">Permissões</th>
                            
                            @can('Admin')
                            <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($role))
                           
                        <tr>
                            <th>{{$role->st_nome}}</th>
                            <th>{{$role->st_label}}</th>
                            <th>{{$permissions}} </th>
                           
                            @can('Admin')
                            <th><a class="btn btn-primary" href="{{url('role/edita/'.$role->id)}}">Editar</a> </th>
                            @endcan
                        </tr>
                      
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   

@stop