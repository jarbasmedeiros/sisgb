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
                                    <th colspan = "5">Lista de Policiais Militares em Acompanhamento pela CMAPM </th>                            
                                    <th>
                                            <div class="col-md-1">
                                                <a href="{{url('/juntamedica/pendenciaMedica/pdf')}}" class="btn btn-primary"  target="_blank" title="Imprimir PDF">
                                                    <i class="glyphicon glyphicon-print"></i> Imprimir
                                                </a>
                                            </div>
                                    </th> 
                                    <th>
                                            <div class="col-md-1">
                                                <a href="{{url('/juntamedica/pendenciaMedica/excel')}}" class="btn btn-primary" title="Gerar Excel">
                                                    <i class="fa fa-file-excel-o"></i> Gerar Excel
                                                </a>
                                            </div>
                                    </th> 
                                </tr>
                                <tr>
                                    <th class="col-md-4">Nome</th>
                                    <th class="col-md-2">Nome de Guerra</th>
                                    <th class="col-md-1">Sexo</th>
                                    <th class="col-md-1">Posto/Graduação</th>
                                    <th class="col-md-1">Matrícula</th>
                                    <th class="col-md-1">OPM</th>
                                    <th class="col-md-1">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($policiaisEmAcompanhamento))
                                    @forelse($policiaisEmAcompanhamento as $p)
                                    <tr>
                                        <td>{{$p->st_nome}}</td>
                                        <td>{{$p->st_nomeguerra}}</td>
                                        <td>{{$p->st_sexo}}</td>
                                        <td>{{$p->st_postograduacaosigla}}</td>
                                        <td>{{$p->st_matricula}}</td>
                                        <td>{{$p->st_unidade}}</td>
                                        <td>
                                            <a href="{{url('/juntamedica/prontuario/show/'.$p->id)}}" class="btn btn-primary"  title="Abrir Prontuário">
                                                <i class="glyphicon  glyphicon-folder-open"></i> 
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="12">Nenhum policial encontrado.</td>
                                    </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                        @if(isset($policiaisEmAcompanhamento) && count($policiaisEmAcompanhamento) > 0)
                            {{$policiaisEmAcompanhamento->links()}}
                        @endif
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
