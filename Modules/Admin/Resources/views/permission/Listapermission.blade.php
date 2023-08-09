@extends('adminlte::page')

@section('title', 'home')
@can('Administrador')
@section('content_header')
    <a href="{{url('admin/permission/create')}}"><h1 class="btn btn-primary">Nova Permissão</h1></a>
@stop
@endcan

@section('content')

    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    @if(isset($permissions) && count($permissions) > 0)
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="3">LISTA DE PERMISSÕES</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-2">Descrição</th>
                            
                            @can('Administrador')
                            <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    @else
                    <tr class="bg-primary">
                            <th colspan="3">NÃO EXISTEM PERMISSÕES CADASTRADAS NO SISTEMA.</th>
                        </tr>
                    @endif
                    <tbody>
                        @if(isset($permissions) && count($permissions) > 0)
                            @foreach($permissions as $p)
                        <tr>
                            
                            <th>{{$p->st_nome}}</th>
                            <th>{{$p->st_label}}</th>
                           
                            @can('Administrador')
                            <th><a class="btn btn-primary" href="{{url('admin/permission/edita/'.$p->id)}}">Editar</a> 
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

   

@stop