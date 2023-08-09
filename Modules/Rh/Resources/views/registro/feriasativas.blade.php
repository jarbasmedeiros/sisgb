@extends('adminlte::page')

@section('title', 'Férias Ativas')
@php $total = 0;@endphp

@section('content')
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-primary">
                    <th colspan="5">Lista de Férias Ativas</th>
                    @can('Edita')
                    <th>
                        <div class="col-md-1">
                            <form id="listaFeriasFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("rh/feriasativas/excel") }}'>
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>
                            </form>
                        </div>
                    </th>
                    <th>
                        <div class="col-md-1">
                            <form id="listaFeriasFilter" class="form-horizontal" role="form" method="POST" action='{{ url("rh/feriasativas/pdf") }}'>
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Gerar PDF</button>

                            </form>
                        </div>
                    </th>
                    @endcan
                </tr>

                <tr>
                    <th class="col-md-1">Ord</th>
                    <th class="col-md-3">Nome do Funcionário</th>
                    <th class="col-md-2">Setor</th>
                    <th class="col-md-2">Função</th>
                    <th class="col-md-2">Início</th>
                    <th class="col-md-2">Fim</th>
                    <th class="col-md-2">Ano Referente</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($ferias))
                    @foreach($ferias as $fa)
                        <tr>
                            @php $total = $total + 1;@endphp
                            <th>{{$total}}</th>
                            <th>{{$fa->st_nomefuncionario}}</th>
                            <th>{{$fa->st_siglasetor}}</th>
                            <th>{{$fa->st_funcao}}</th>
                            <th>{{\Carbon\Carbon::parse($fa->dataferias_inicio)->format('d/m/Y')}}</th>
                            <th>{{\Carbon\Carbon::parse($fa->dataferias_fim)->format('d/m/Y')}}</th>
                            @foreach($fa->campos as $key => $valor)
                                @if($valor->st_nomeitem == 'Referente')
                                    <th>{{$valor->st_valor}}</th>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
{{$ferias->links()}}
@stop 