@extends('adminlte::page')
@section('title', 'Aguardando Publicação em BG')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan = "9">Lista de Policiais Militares atendidos pela CMAPM (Aguardando Publicação em BG) </th>                            
                                    <th>
                                            <div class="col-md-1">
                                                <a href="{{url('/juntamedica/aguardandoPublicacao/pdf')}}" class="btn btn-primary"  target="_blank" title="Imprimir PDF">
                                                    <i class="glyphicon glyphicon-print"></i> Imprimir
                                                </a>
                                            </div>
                                    </th> 
                                </tr>
                                <tr>
                                    <th class="col-md-1">Nº</th>
                                    <th class="col-md-2">Nome</th>
                                    <th class="col-md-1">Matrícula</th>
                                    <th class="col-md-1">Parecer</th>
                                    <th class="col-md-1">Motivo</th>
                                    <th class="col-md-2">Restrição</th>
                                    <th class="col-md-1">Dias</th>
                                    <th class="col-md-1">Início</th>
                                    <th class="col-md-1">Término</th>
                                    <th class="col-md-1">Observação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($atendimentosAguardandoPublicacao))
                                    @forelse($atendimentosAguardandoPublicacao as $a)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$a->policial->st_nome}}</td>
                                        <td>{{$a->policial->st_matricula}}</td>
                                        <td>{{$a->st_parecer}}</td>
                                        <td>{{$a->st_motivo}}</td>
                                        <td>
                                            @if(count($a->restricoes) > 0)
                                                @foreach($a->restricoes as $r)
                                                    @if(!$loop->last)
                                                        {{$r->st_restricao}},
                                                    @else
                                                        {{$r->st_restricao}}.
                                                    @endif
                                                @endforeach                                               
                                            @endif
                                        </td>
                                        <td>{{$a->nu_dias}}</td>
                                        <td>{{\Carbon\Carbon::parse($a->dt_inicio)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($a->dt_termino)->format('d/m/Y')}}</td>
                                        <td>{{$a->st_obs}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10">Nenhum policial encontrado.</td>
                                    </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
            <i class="glyphicon glyphicon-arrow-left"></i> Voltar
        </a>
    </div>
</div>
@stop
@section('css')
    <style>
        th, td{text-align: center;}
        #a-voltar {margin-left: 10px;}
    </style>
@stop
