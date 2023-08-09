@extends('adminlte::page')
@section('title', 'Quantitativo de Vagas')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">Quantitativo de Vagas</div>
            <div class="panel-body">
                <form class="form-contact" role="form" method="POST" action="{{url('/promocao/atualizaquantitativovagas')}}">
                    {{csrf_field()}}
                    @php $total = 0; @endphp
                        @foreach($vagas as $v)
                            @if(isset($quadro))
                                @if($quadro == $v->st_qpmp)
                                    @php
                                        $total = ($total + $v->nu_vagas);
                                    @endphp
                                    <tr>
                                        <th>{{$v->st_postograduacao}}</th>
                                        <th>
                                            <input name='{{$v->id}}' type='number' value="{{$v->nu_vagasprevistas}}">
                                        </th>
                                        <th>{{$v->nu_vagasexistente}}</th>
                                        <th>{{$v->nu_claro}}</th>
                                        <th>{{$v->nu_excedente}}</th>
                                        <th>{{$v->nu_agragados}}</th>
                                        <th>{{$v->nu_vagas}}</th>
                                    </tr>
                                @else
                                    <tr class="bg-info">
                                        <th colspan="6" class="foot">TOTAL</th>
                                        <th>{{$total}}</th>
                                    </tr>
                                    </table>
                                        @php
                                            $total = 0;
                                            $total = ($total + $v->nu_vagas);
                                        @endphp
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th colspan="2">{{$v->st_qpmp}} - {{$v->st_descricao}}</th>
                                            </tr>
                                            <tr class="bg-primary">
                                                <th class="col-md-2">Graduações</th>
                                                <th class="col-md-2">Previstos</th>
                                                <th class="col-md-1">Existentes</th>
                                                <th class="col-md-1">Claros</th>
                                                <th class="col-md-1">Excedentes</th>
                                                <th class="col-md-1">Agregados</th>
                                                <th class="col-md-1">Vagas</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th>{{$v->st_postograduacao}}</th>
                                            <th>
                                                <input name='{{$v->id}}' type='number' value="{{$v->nu_vagasprevistas}}">
                                            </th>
                                            <th>{{$v->nu_vagasexistente}}</th>
                                            <th>{{$v->nu_claro}}</th>
                                            <th>{{$v->nu_excedente}}</th>
                                            <th>{{$v->nu_agragados}}</th>
                                            <th>{{$v->nu_vagas}}</th>
                                        </tr>
                                    @php
                                        $quadro = $v->st_qpmp
                                    @endphp
                                @endif
                            @else
                            <table class="table table-bordered"><!--Primeira volta do for-->
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2">{{$v->st_qpmp}} - {{$v->st_descricao}}</th>
                                    </tr>
                                    <tr class="bg-primary">
                                            <th class="col-md-2">Graduações</th>
                                            <th class="col-md-2">Previstos</th>
                                            <th class="col-md-1">Existentes</th>
                                            <th class="col-md-1">Claros</th>
                                            <th class="col-md-1">Excedentes</th>
                                            <th class="col-md-1">Agregados</th>
                                            <th class="col-md-1">Vagas</th>
                                        </tr>
                                </thead>
                                <tr>
                                    <th>{{$v->st_postograduacao}}</th>
                                    <th>
                                        <input name='{{$v->id}}' type='number' value="{{$v->nu_vagasprevistas}}">
                                    </th>
                                    <th>{{$v->nu_vagasexistente}}</th>
                                    <th>{{$v->nu_claro}}</th>
                                    <th>{{$v->nu_excedente}}</th>
                                    <th>{{$v->nu_agragados}}</th>
                                    <th>{{$v->nu_vagas}}</th>
                                </tr>
                                @php
                                    $quadro = $v->st_qpmp;
                                    $total = $v->nu_vagas;
                                @endphp
                            @endif
                        @endforeach
                        <tr class="bg-info">
                            <th colspan="6" class="foot">TOTAL</th>
                            <th>{{$total}}</th>
                        </tr>
                    </table>
                    <a href="javascript:history.back()" class="col-md-1 btn btn-warning">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>
                    <button type="submit" class="col-md-1 btn btn-primary">
                        <i class="fa fa-save"></i> Salvar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
    <style>
        th, input{text-align:center;}
        .foot{text-align: right;}
        a, button{margin:5px;}
    </style>
@stop