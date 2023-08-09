@extends('adminlte::page')
@section('title', 'Lista de Férias')
@section('content')
@php 
$contador = 0;
if(isset($contador_incial)){
    $contador = $contador + $contador_incial;
}
@endphp
<div class="row">
<div class="col-md-12">
                                <form  class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/licencas/unidade/paginado")}}' >
                                    {{csrf_field()}}
                                    <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }}" class="col-md-12">
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="ce_unidade[]" data-placeholder="Selecione a unidade" style="width: 100%;" required>
                                                    <option value="">Selecione a unide para qual deseja consultar as férias</option>
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
                                            <th colspan = "6">LISTA DE LICENÇAS</th>
                                            <th>
                                                <div class="col-md-1">
                                                    @if(isset($dados))
                                                    <form id="ListaLicencasAtivasFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/licencas/unidade/excel")}}' >
                                  
                                                     @foreach($dados['ce_unidade'] as $d)
                                              
                                                            <input type="hidden" name="ce_unidade[]" value="{{$d}}">
                                                  
                                                        @endforeach
                                                            <input type="hidden" id="inicio" name="dt_inicio" value="{{$dados['dt_inicio']}}">
                                                            <input type="hidden" id="dt_final" name="dt_final" value="{{$dados['dt_final']}}" >
                              
                                                    @else    
                                                    <form id="ListaLicencasAtivasFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/licencasativas/excel")}}' >
                                                    @endif
                                                    {{csrf_field()}}
                                                    <button type="submit" class="btn btn-primary btn-xs"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>                                                                                        
                                                </form>
                                            </div>
                                        </th>                     
                                        <th>
                                            
                            <div class="col-md-1">
                                @if(isset($dados))
                                    <form id="ListaLicencasAtivasFilterExcel" class="form-horizontal" role="form" method="POST" target="_blank" action='{{url("rh/relatorios/licencas/unidade/pdf")}}' >
                
                                        @foreach($dados['ce_unidade'] as $d)
                                            <input type="hidden" name="ce_unidade[]" value="{{$d}}">
                                        @endforeach
                                        <input type="hidden" id="inicio" name="dt_inicio" value="{{$dados['dt_inicio']}}">
                                        <input type="hidden" id="dt_final" name="dt_final" value="{{$dados['dt_final']}}" >
        
                                @else 
                                    <form id="ListaLicencasAtivasFilterPdf" class="form-horizontal" role="form" method="POST"  target="_blank" action='{{url("rh/licencasativas/pdf")}}'>
                                    @endif
                                {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-print"></span> Gerar PDF</button>                                    
                                </form>
                            </div>
                        </th>
                </tr>
                <tr>
                    <th class="col-md-1">ORD</th>
                    <th class="col-md-1">POST/GRAD</th>
                    <th class="col-md-4">NOME</th>
                    <th class="col-md-1">MATRÍCULA</th>
                    <th class="col-md-2">TIPO</th>
                    <th class="col-md-1">QTD DIAS</th>
                    <th class="col-md-1">INÍCIO</th>
                    <th class="col-md-1">FIM</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($licencas))
                    @forelse($licencas as $l)
                    @php $contador = $contador + 1; @endphp
                    <tr>
                        <td>{{ $contador}}</td>
                        <td>{{$l->st_postograduacaosigla}}</td>
                        <td>{{$l->st_nome}}</td>
                        <td>{{$l->st_matricula}}</td>
                        <td>{{$l->st_tipoLicenca}}</td>
                        <td>{{$l->nu_dias}}</td>
                        <td>{{\Carbon\Carbon::parse($l->dt_inicio)->format('d/m/Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($l->dt_fim)->format('d/m/Y')}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Nenhum policial com férias ativas encontrado.</td>
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
        @if(isset($licencas) && count($licencas)>0 && (!is_array($licencas)))
            @if(isset($dados))
                {{$licencas->appends($dados)->links()}}
            @else
                {{$licencas->links()}}
            @endif
        @endif
        
    </div>
</div>
    

@stop






