@extends('adminlte::page')

@section('title', 'Lista de Férias')

@php 
$contador = 0;
if(isset($contador_incial)){
    $contador = $contador + $contador_incial;
}
@endphp

@section('content')

<div class="row">
    <div class="col-md-12">
        <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/ferias/unidade/paginado")}}' >
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }}" class="col-md-12">
                <div class="col-md-12">
                <select class="form-control select2" name="ce_unidade[]" data-placeholder="Selecione a unidade" style="width: 100%;" required>
                        <option value=""></option>
                        <option value="subordinadas">Todas as Unidade Subordinadas</option>    
                        @foreach($unidades as $u)
                            <option value="{{$u->id}}">{!!$u->st_nomepais!!}</option>
                        @endforeach
                    </select>
                </div>
            </div>                                                                            
            <div class="col-md-4">
                <label for="dt_inicio" class="col-md-2 ">Data Inicial:</label>
                <div class="col-md-2">
                    <input type="date" id="inicio" name="dt_inicio" class="form-inline" required="true">
                    @if ($errors->has('dt_inicio'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_inicio') }}</strong>
                        </span>
                    @endif
                </div>
            </div>                                                                            
            <div class="col-md-4">
                <label for="dt_final" class="col-md-2 ">Data Final:</label>
                <div class="col-md-2">
                    <input type="date" id="dt_final" name="dt_final" class="form-inline" required="true">
                    @if ($errors->has('dt_inicio'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_final') }}</strong>
                        </span>
                    @endif
                </div>
            </div>                                                                            
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Consultar</button>                                                                                        
        </form>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
               
                <tr class="bg-primary">
                    <th colspan = "7">LISTA DE FÉRIAS</th>
                        <th>
                            <div class="col-md-1">
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/ferias/unidade/excel")}}' >
                                    {{csrf_field()}}
                                    @if(isset($dados))
                                    @foreach($dados['ce_unidade'] as $d)
                                        <input type="hidden" name="ce_unidade[]" value="{{$d}}">    
                                    @endforeach
                                   
                                    <input type="hidden" id="inicio" name="dt_inicio" value="{{$dados['dt_inicio']}}">
                                    <input type="hidden" id="dt_final" name="dt_final" value="{{$dados['dt_final']}}" >
                                
                                    @endif
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>                                                                                        
                                </form>
                            </div>
                        </th>                     
                       
                </tr>
                <tr>
                    <th class="col-md-1">ORD</th>
                    <th class="col-md-1">POST/GRAD</th>
                    <th class="col-md-4">NOME</th>
                    <th class="col-md-2">MATRÍCULA</th>
                    <th class="col-md-1">QTD DE DIAS</th>
                    <th class="col-md-1">INÍCIO</th>
                    <th class="col-md-1">FIM</th>
                    <th class="col-md-1">REFERENTE AO ANO</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($ferias))
                    @forelse($ferias as $f)
                        @php $contador = $contador + 1; @endphp
                    <tr>
                        <td>{{$contador}}</td>
                        <td>{{$f->st_postograduacaosigla}}</td>
                        <td>{{$f->st_nome}}</td>
                        <td>{{$f->st_matricula}}</td>
                        <td>{{$f->nu_dias}}</td>
                        <td>{{\Carbon\Carbon::parse($f->dt_inicio)->format('d/m/Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($f->dt_fim)->format('d/m/Y')}}</td>
                        <td>{{$f->nu_ano}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center;">Nenhum policial com férias ativas encontrado.</td>
                    </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
        @if(isset($ferias) && count($ferias)>0 && (!is_array($ferias)))
             @if(isset($dados))
                {{$ferias->appends($dados)->links()}}
            @else
                {{$ferias->links()}}
            @endif
        @endif
        
    </div>
</div>
    

@stop






