@extends('adminlte::page')

@section('title', 'Lista de Férias')


@section('content')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-primary">
                    <th colspan = "4">LISTA DE FÉRIAS</th>
                        <th>
                            <div class="col-md-1">
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/feriasAtivas/excel")}}' >
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>                                                                                        
                                </form>
                            </div>
                        </th>                     
                        <th>
                            <div class="col-md-1">
                                <form id="listaFuncionarioFilter" class="form-horizontal" role="form" method="POST" action='{{url("rh/feriasAtivas/pdf")}}'>
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Gerar PDF</button>                                    
                                </form>
                            </div>
                        </th>
                </tr>
                <tr>
                    <th class="col-md-6">NOME</th>
                    <th class="col-md-2">MATRÍCULA</th>
                    <th class="col-md-2">QTD DE DIAS</th>
                    <th class="col-md-2">INÍCIO</th>
                    <th class="col-md-2">FIM</th>
                    <th class="col-md-2">REFERENTE AO ANO</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($ferias))
                    @forelse($ferias as $f)
                    <tr>
                        <th>{{$f->st_nome}}</th>
                        <th>{{$f->st_matricula}}</th>
                        <th>{{$f->nu_dias}}</th>
                        <th>{{\Carbon\Carbon::parse($f->dt_inicio)->format('d/m/Y')}}</th>
                        <th>{{\Carbon\Carbon::parse($f->dt_fim)->format('d/m/Y')}}</th>
                        <th>{{$f->nu_ano}}</th>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Nenhum policial com férias ativas encontrado.</td>
                    </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
        @if(isset($ferias) && count($ferias)>0 && (!is_array($ferias)))
            {{$ferias->links()}}
        @endif
        
    </div>
</div>
    

@stop






