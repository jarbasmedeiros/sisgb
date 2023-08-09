@extends('adminlte::page')

@can('Administrador')
@section('content_header')
<!--
    <a href="{{url('rh/orgao/create1')}}"><h1 class="btn btn-primary">Novo Órgão</h1></a>
    <a href="{{url('rh/orgaos/pdf')}}"><h1 class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Imprimir listagem</h1></a>
    -->
@stop
@endcan

@section('content')
    <div class="content">
      <section class="content-header">
        <h1>
          Dashboard
          <small>{{$tituloDash}}</small>
        </h1>
      </section>
      
      @yield('conteudo')        
    </div>
@stop
