@extends('adminlte::page')

@section('title', 'home')
@can('Administrador')
@section('content_header')
    <div class="col-md-1">
        <a href="{{url('admin/role/create')}}"><h1 class="btn btn-primary">Novo Perfil</h1></a>
        <br><br>
    </div>
@stop
@endcan

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="3">LISTA DE PERFIS (Roles)</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-2">Descrição</th>
                            
                            @can('Administrador')
                            <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($roles))
                            @foreach($roles as $r)
                        <tr>
                            <th>{{$r->st_nome}}</th>
                            <th>{{$r->st_label}}</th>
                           
                            @can('Administrador')
                            <th><a class="btn btn-primary" href="{{url('admin/role/edita/'.$r->id)}}">Editar</a> 
                            <!--|<a class="btn btn-primary" href="{{url('admin/role/'.$r->id)}}">detalhes</a>-->
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