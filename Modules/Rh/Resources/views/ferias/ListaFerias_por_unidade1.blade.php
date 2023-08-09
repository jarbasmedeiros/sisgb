@extends('adminlte::page')

@section('title', 'Lista de Férias')


@section('content')

<div class="row">
                        
                            <div class="col-md-12">
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/ferias/unidade/paginado")}}' >
                                    {{csrf_field()}}
                                    <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }}" class="col-md-12">
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="ce_unidade[]" data-placeholder="Selecione a unidade" style="width: 100%;" required>
                                                @foreach($unidades as $u)

                                                    <option value="subordinadas">Todas as Unidade Subordinadas</option>
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
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Consultar</button>                                                                                        
                                </form>
                            </div>
                       









    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
               
                <tr class="bg-primary">
                    <th colspan = "5">LISTA DE FÉRIAS</th>
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
             @if(isset($dados))
                {{$ferias->appends($dados)->links()}}
            @else
                {{$ferias->links()}}
            @if
        @endif
        
    </div>
</div>
    

@stop






