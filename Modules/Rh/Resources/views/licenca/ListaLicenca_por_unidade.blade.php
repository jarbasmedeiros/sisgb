@extends('adminlte::page')

@section('title', 'Lista de licenças')


@section('content')

<div class="row">
                        
                            <div class="col-md-12">
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/licencas/unidade/paginado")}}' >
                                    {{csrf_field()}}
                                    <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }}" class="col-md-12">
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="ce_unidade[]" multiple="multiple" data-placeholder="Selecione a unidade" style="width: 100%;" required>
                                                @foreach($unidades as $u)
                                                    <option value="{{$u['id']}}">{{$u['st_sigla']}}</option>
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
                    <th colspan = "6">LISTA DE LICENÇA</th>
                        <th>
                            <div class="col-md-1">
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/licencas/unidade/excel")}}' >
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
                    <th class="col-md-1">POST/GRAD</th>
                    <th class="col-md-6">NOME</th>
                    <th class="col-md-2">MATRÍCULA</th>
                    <th class="col-md-2">TIPO</th>
                    <th class="col-md-2">QTD DE DIAS</th>
                    <th class="col-md-2">INÍCIO</th>
                    <th class="col-md-2">FIM</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($licencas))
                    @forelse($licencas as $l)
                    <tr>
                        <th>{{$l->st_postograduacaosigla}}</th>
                        <th>{{$l->st_nome}}</th>
                        <th>{{$l->st_matricula}}</th>
                        <th>{{$l->st_tipoLicenca}}</th>
                        <th>{{$l->nu_dias}}</th>
                        <th>{{\Carbon\Carbon::parse($l->dt_inicio)->format('d/m/Y')}}</th>
                        <th>{{\Carbon\Carbon::parse($l->dt_fim)->format('d/m/Y')}}</th>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Nenhum policial com licença ativa encontrado.</td>
                    </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
        @if(isset($licencas) && count($licencas)>0 && (!is_array($licencas)))
            {{$licencas->links()}}
        @endif
        
    </div>
</div>
    

@stop






