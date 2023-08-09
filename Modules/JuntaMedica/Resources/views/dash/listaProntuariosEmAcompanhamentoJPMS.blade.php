@extends('adminlte::page')
@section('title', 'JPMS')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">{{$tipoProntuario}}</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="11">Lista de pacientes</th>                     
                                </tr>
                                <tr>
                                    <th class="col-md-3">Nome</th>
                                    <th class="col-md-1">Post/Grad</th>
                                    <th class="col-md-1">Matrícula</th>
                                    <th class="col-md-2">Unidade</th>
                                    <th class="col-md-1">CID</th>
                                    <th class="col-md-3">OBS</th>
                                    <th class="col-md-1">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($prontuariosEmAcompanhamento))
                                    @forelse($prontuariosEmAcompanhamento as $p)
                                    <tr>
                                        <td>{{$p->st_nome}}</td>
                                        <td>{{$p->st_postograduacao}} {{$p->st_orgao}}</td>
                                        <td>{{$p->st_matricula}}</td>
                                        <td>{{$p->st_unidade}}</td>
                                        <td>{{$p->st_letracidprincipal}}</td>
                                        <td>{{$p->st_obs}}</td>
                                        <td>
                                            <a href="{{url('/juntamedica/prontuario/show/'.$p->id)}}" class="btn btn-primary" title="Abrir Prontuário">
                                                <i class="fa fa-folder-open" ></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">Nenhum prontuário encontrado.</td>
                                    </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
            <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
                <i class="glyphicon glyphicon-arrow-left"></i> Voltar 
            </a>  
        </div>
    </div>
</div>

@stop

@section('css')
    <style>
        th, td{text-align: center;}
        #a-voltar{margin-top: 10px;}
    </style>
@stop
