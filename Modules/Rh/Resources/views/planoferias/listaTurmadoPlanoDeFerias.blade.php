@extends('adminlte::page')
@section('title', 'Editar Plano de Férias')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="row">
            <!-- <button class="btn btn-primary" id="btnNovoQuadro" name="btnNovoQuadro" onclick="()" data-toggle="modal" data-target="">Novo plano de férias</button> -->
    </div>
        <div class="panel panel-primary">
            <div class="panel-heading">{N° da turma}Turma do Plano de Férias de {Ano do plano de férias}</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th class='col-md-1'>Post/Grad</th>
                                <th class='col-md-2'>Matrícula</th>                                
                                <th class='col-md-2'>Cpf</th>
                                <th class='col-md-2'>Nome</th>
                                <th class='col-md-2'>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($listas) && count($listas) > 0)
                                @foreach($listas as $lista)
                                    <tr>
                                        <th>{{$lista->ano}}</th>
                                        <th>{{$lista->status}}</th>

                                        <th>                                            
                                            <a href="{{url('/rh/planoferias/EditarPlanoDeFerias')}}" class='btn btn-primary fa fa fa-eye' title='Abrir'></a>
                                            <a href="{{url('/rh/planoferias/ListaTurmaPlanoDeFerias')}}" class="btn btn-warning fa fa fa-pencil-square" title='Editar'></a>
                                        </th>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">
                                        Nenhum resultado encontrado.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <a href="{{url('/rh/planoferias')}}" class="col-md-1 btn btn-warning">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>
                
        </div>
    </div>
</div>


</div>
@stop
@section('css')
    <style>
        #btnNovoQuadro{
            float:right;
            margin-bottom:1%;
            margin-right:1%;
        }
    </style>
@stop