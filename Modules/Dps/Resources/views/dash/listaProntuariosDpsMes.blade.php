@extends('adminlte::page')
@section('title', 'DPS')
@section('content')
@php use App\utis\Funcoes; @endphp
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">DPS - Agendamentos {{ucfirst($situacao)}} de {{$mes}} de @php echo date("Y"); @endphp</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="11">Lista de Agendamentos {{ucfirst($situacao)}} de {{$mes}} de @php echo date("Y"); @endphp</th>                     
                                </tr>
                                <tr>
                                    <th class="col-md-2"  style='text-align:left;'>Matrícula</th>
                                    <th class="col-md-1"  style='text-align:left;'>Post/Grad</th>
                                    <th class="col-md-4"  style='text-align:left;'>Nome</th>
                                    <th class="col-md-3"  style='text-align:left;'>Nascimento</th>
                                    <!-- <th class="col-md-1">Ações</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($prontuariosEmAcompanhamento))
                                    @forelse($prontuariosEmAcompanhamento as $p)
                                    <tr>
                                        <td  style='text-align:left;'>{{$p->st_matricula}}</td>
                                        <td  style='text-align:left;'>{{$p->st_postograduacaosigla}}</td>
                                        <td  style='text-align:left;'>{{$p->st_nome}}</td>
                                        <td  style='text-align:left;'>{{ Funcoes::converterDataFormatoBr($p->dt_nascimento) }}</td>
                                        <!--
                                        <td>
                                            <a href="{{url('/juntamedica/prontuario/show/'.$p->id)}}" class="btn btn-primary" title="Abrir Prontuário">
                                                <i class="fa fa-folder-open" ></i>
                                            </a>
                                        </td>
                                        -->
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">Nenhum agendamento encontrado.</td>
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