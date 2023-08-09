@extends('adminlte::page')

@section('title', 'Licenças Ativas')

@section('content')
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-primary">
                    <th colspan="3">Lista de Licenças Ativas</th>
                    @can('Edita') 
                        <th>
                            <div class="col-md-1">
                                <form id="listaFeriasFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("rh/licencasativas/excel") }}'>
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>
                                </form>
                            </div>
                        </th> 
                        <th>                               
                            <div class="col-md-1">
                                <form id="listaFeriasFilter" class="form-horizontal" role="form" method="POST" action='{{ url("rh/licencasativas/pdf") }}'>
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Gerar PDF</button>                                                                                 
                                </form>
                            </div>
                        </th>
                    @endcan
                </tr>
                
                <tr>
                    <th class="col-md-3">Nome do Funcionário</th>
                    <th class="col-md-2">Setor</th>
                    <th class="col-md-2">Função</th>
                    <th class="col-md-2">Início</th>
                    <th class="col-md-2">Fim</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($licenca))
                    @foreach($licenca as $li)
                <tr>
                    @if($li->campos[1]->st_valor <= $dataatual && $li->campos[2]->st_valor >= $dataatual)
                    <th>{{$li->st_nomefuncionario}}</th>
                    <th>{{$li->st_siglasetor}}</th>
                    <th>{{$li->st_funcao}}</th>
                    @foreach($li->campos as $key => $valor)
                        @if($valor->st_nomeitem == 'Início')
                            <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                        @endif
                        @if($valor->st_nomeitem == 'Fim')
                            <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                        @endif
                        @endforeach
                    @endif
                </tr>
                @endforeach
                @endif
            </tbody>
    </div>
</div>

@stop
