@extends('adminlte::page')

@section('title', 'Idade')
@can('Edita')
@section('content_header')

@stop
@endcan

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="6">IDADE DOS FUNCIONÁRIOS</th>
                    </tr>
                    <tr>                     
                        <th class="col-md-3">NOME</th>
                        <th class="col-md-2">NASCIMENTO</th>
                        <th class="col-md-3">IDADE</th>
                        <th class="col-md-3">FALTA PARA 70 ANOS</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($servidores))
                        @foreach($servidores as $id)
                    <tr>
                        <th>{{$id->st_nome}}</th>
                        <th>{{$id->dt_nascimento}}</th>
                        <th>{{$id->idade}}</th>
                        @if($id->intervalo < 0)
                        <th style="color:red">{{$id->quanto}}</th>
                        @else
                        <th>{{$id->quanto}}</th>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                </tbody>
              
            </table>
            {{$servidores->links()}} 
        </div>
    </div>
@stop