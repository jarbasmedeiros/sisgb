@extends('adminlte::page')
@section('title', 'Relatorio de Acompanhamento JPMS')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
             <div class="panel-heading">
             RELATÓRIO DO QUANTITATIVO DE POLICIAIS EM ACOMPANHAMENTO PELA JPMS
             </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="bg-primary">
                                       </tr>
                                    <th class="col-md-2">Graduação</th>
                                    <th class="col-md-2">Total</th>
                                    @can('CMAPM')
                                     <th class='col-md-1'>Ações</th>
                                    @endcan
                                </tr>
                            </thead>
                           
                            <tbody>
                                @if(isset($policiaisEmAcompanhamento))
                                    @forelse($policiaisEmAcompanhamento as $a)
                                    <tr>
                                       
                                        <td>{{$a->st_postograduacao}}</td>
                                        <td>{{$a->total}}</td>
                                        @can('CMAPM')
                                        <th>
                                        <a href="{{url('/juntamedica/listacompanhamentojpms/'.$a->ce_graduacao.'/listagem' )}}"  class='btn btn-primary' title='Exibir'>Exibir</a>
                                           
                                        </th>
                                        @endcan
                                    </tr>
                                    @empty
                                   <tr>
                                        <td colspan="10">Nenhum policial encontrado.</td>
                                    </tr>
                                    @endforelse
                                @endif
                            </tbody>                     
                            @stop               
@section('css')
    <style>
        th, td{text-align: center;}
        #a-voltar {margin-left: 10px;}
    </style>
@stop
