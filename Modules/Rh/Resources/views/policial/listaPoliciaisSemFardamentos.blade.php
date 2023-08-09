@extends('adminlte::page')

@section('title', 'Policias Sem Fardamento Cadastrado')

@section('css')
<style>
    fieldset.scheduler-border{
        margin: 0;
        padding: 0;
    }
    th, td{
        text-align: center;
    }
    #voltar{
        margin-left: 20px;
    }
</style>
@stop

@php 
$contador = 0;
if(isset($contador_inicial)){
    $contador += $contador_inicial;
}
@endphp

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <fieldset class="scheduler-border">
                <div class="col-md-12">
                    @if(isset($policiaisSemFardamento))                        
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="12">Policiais Sem Fardamento Cadastrado - TOTAL: {{count($policiaisSemFardamento)}}</th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-1">Ordem</th>
                                        <th class="col-md-1">Post/Grad</th>
                                        <th class="col-md-5">Nome</th>
                                        <th class="col-md-2">Matrícula</th>
                                        <th class="col-md-3">Unidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($policiaisSemFardamento as $p)
                                        @php $contador++; @endphp
                                            <tr>
                                                <td>{{$contador}}</td>
                                                <td>{{$p->st_postograduacaosigla}}</td>
                                                <td>{{$p->st_nome}}</td>
                                                <td>{{$p->st_matricula}}</td>
                                                <td>{{$p->st_unidade}}</td>
                                            </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td> Nenhum policial sem fardamento encontrado. </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @endif
                      
                </div>
            </fieldset>
        </div>
        <div class="row">
            <a href="{{ url('/') }}" id="voltar" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>                                                           
        </div>
    </div>
</div>

@stop