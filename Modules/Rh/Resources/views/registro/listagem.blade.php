@extends('adminlte::page')

@section('title', 'Lista de Registros')

@section('content_header')
@stop


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>

                        <div >
                        <form id="listaFeriasBySetor" class="form-horizontal" role="form" method="POST" action='{{ url("/rh/registros/$tiporegistro/listagem") }}'>
                            {{csrf_field()}}
                            
                            <input id="st_tipo" type="hidden"  name="st_tipo" value="{{$st_tipo or 'null'}}"> 
                                    <div class="col-md-2">
                                        <select id="filterlist" name="filterlist" required="true" class="form-control" onclick="selectFilter()">
                                            <option value="">Selecione</option>
                                            <option value="ce_setor">Setor</option>
                                            <option value="ce_funcao">Função</option>
                                            <option value="ce_orgao">Órgão</option>
                                            <option value="dt_inicio">Data de Início</option>
                                            <option value="periodo">Período</option>
                                            <option value="dt_final">Final</option>
                                            @if($tiporegistro == 1)
                                                <option value="st_anoreferente">Ano Referente</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div id="divSetorFilter" class="form-group{{ $errors->has('st_sigla') ? ' has-error' : '' }}" style="display: none">

                                        <div class="col-md-2">
                                            <select id="st_sigla" name="st_valor" required="true" class="form-control" disabled="true" onclick="selectFilter()">
                                                <option value="">Selecione o Setor</option>
                                                @if(isset($listSetor)&& count($listSetor)>0)
                                                @foreach($listSetor as $s)
                                                <option value="{{$s->id}}">{{$s->st_sigla}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            
                                            @if ($errors->has('st_sigla'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_sigla') }}</strong>
                                            </span>
                                            @endif
                                            </div>

                                        </div>

                                        <div id="divFuncaoFilter" class="form-group{{ $errors->has('st_funcao') ? ' has-error' : '' }}" style="display: none">

                                            <div class="col-md-2">
                                                <select id="st_funcao" name="st_valor" required="true" class="form-control" disabled="true">
                                                    <option value="">Selecione a Função</option>
                                                    @if(isset($listFuncao)&& count($listFuncao)>0)
                                                    @foreach($listFuncao as $f)
                                                    <option value="{{$f->id}}">{{$f->st_funcao}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                
                                                @if ($errors->has('st_funcao'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('st_funcao') }}</strong>
                                                </span>
                                                @endif
                                                </div>
                                                                                            
                                        </div>

                                        <div id="divOrgaoFilter" class="form-group{{ $errors->has('st_orgao') ? ' has-error' : '' }}" style="display: none">

                                            <div class="col-md-2">
                                                <select id="st_orgao" name="st_valor" required="true" class="form-control" disabled="true">
                                                    <option value="">Selecione o Órgão</option>
                                                    @if(isset($listOrgao)&& count($listOrgao)>0)
                                                    @foreach($listOrgao as $o)
                                                    <option value="{{$o->id}}">{{$o->st_orgao}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                
                                                @if ($errors->has('st_orgao'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('st_orgao') }}</strong>
                                                </span>
                                                @endif
                                                </div>
                                                                                            
                                        </div>

                                        <div id="divDataInicioFilter" class="form-group{{ $errors->has('st_valor') ? ' has-error' : '' }}" style="display: none">                    
                                            <div class="col-md-2">
                                                <input id="dt_inicio" type="date" disabled="true" class="form-control" name="st_valor" value="{{ old('st_valor') }}"> 
                                                    @if($errors->has('st_valor'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_valor') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div>
                                       
                                        <div id="divPeriodoFilter" class="form-group" style="display: none">                      
                                            <div class="col-md-2">
                                                <input id="inicioPeriodo" type="date" disabled="true" class="form-control" name="st_valorinicio" value="{{ old('st_valorinicio') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <input id="finalPeriodo" type="date" disabled="true" class="form-control" name="st_valorfinal" value="{{ old('st_valorfinal') }}">
                                            </div>
                                            </div>
                                        </div>

                                        <div id="divDataFinalFilter" class="form-group{{ $errors->has('st_valor') ? ' has-error' : '' }}" style="display: none">                    
                                            <div class="col-md-2">
                                                <input id="dt_final" type="date" disabled="true" class="form-control" name="st_valor" value="{{ old('st_valor') }}"> 
                                                    @if($errors->has('st_valor'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_valor') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div>

                                        <div id="divAnoReferenteFilter" class="form-group{{ $errors->has('st_valor') ? ' has-error' : '' }}" style="display: none">
                                            <div class="col-md-2">
                                                <input id="st_anoreferente" type="text" disabled="true" class="form-control" name="st_valor" value="{{ old('st_valor') }}">
                                                @if($errors->has('st_valor'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('st_valor') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" onclick="selecionatipoexportacao('listagem')" class="btn btn-primary">Filtrar</button>
                                                                    
                            </form>
                        <div> 

                        <tr class="bg-primary">
                            
                            @if($tiporegistro == 1)
                                <th colspan="6">Lista de {{$registronome}}
                                </th>
                            @endif
                            @if($tiporegistro == 2)
                                <th colspan="5">Lista de {{$registronome}}
                                </th>
                            @endif
                            <th>
                                @can('Edita')                            
                                    <div class="col-md-1">
                                        <form id="listaFeriasFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("rh/registros/$tiporegistro/excel") }}'>
                                            {{csrf_field()}}
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>

                                            <input  type="hidden"  name="filterlist" value="{{$filterlist or 'null'}}"> 
                                            <input type="hidden"  name="st_valor" value="{{$st_valor or 'null'}}"> 
                                                                                        
                                        </form>
                                    </div>                               
                                @endcan
                            </th>
                            <th>
                                @can('Edita')                                  
                                    <div class="col-md-1">
                                        <form id="listaFeriasFilter" class="form-horizontal" role="form" method="POST" action='{{ url("rh/registros/$tiporegistro/pdf") }}'>
                                            {{csrf_field()}}
                                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Gerar PDF</button>
                                            
                                            <input  type="hidden"  name="filterlist" value="{{isset($filterlist) ? $filterlist : "NULL"}}">
                                            <input type="hidden"  name="st_valor" value="{{isset($st_valor) ? $st_valor : "NULL"}}">
                                            
                                            {{-- @foreach ($st_valor as $key => $val)
                                                    <input type="hidden"  name="'st_valor'" value="{{isset($val) ? $val : "NULL"}}">                                                 
                                                @endforeach --}}                                                                                        
                                        </form>
                                    </div>                              
                                @endcan
                            </th>
                            </th>
                        </tr>
                        
                        <tr>
                            <th class="col-md-3">Nome do Funcionário</th>
                            <th class="col-md-1">Matricula</th>
                            <th class="col-md-1">Setor</th>
                            <th class="col-md-2">Função</th>
                            <th class="col-md-2">Órgão</th>
                            <th class="col-md-1">Início</th>
                            <th class="col-md-1">Fim</th>
                            @if($tiporegistro == 1)
                                <th class="col-md-1">Referente ao Ano</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($registro) && count($registro) > 0)
                                                    
                        @foreach($registro as $r)
                    <tr>
                   
                        <th>{{$r->st_nomefuncionario}}</th>
                        <th>{{$r->st_matricula}}</th>
                        <th>{{$r->st_siglasetor}}</th>
                        <th>{{$r->st_funcao}}</th>
                        <th>{{$r->st_orgao}}</th>
                        @foreach($r->listRegistros as $key => $valor)
                            @if($valor->st_nomeitem == 'Início')
                                <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                            @endif
                            @if($valor->st_nomeitem == 'Fim')
                                <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                            @endif
                            @if($valor->st_nomeitem == 'Referente')
                                <th>{{$valor->st_valor}}</th>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                {{$registro->appends(['filterlist' => $filterlist, 'st_valor'=> $st_valor])->links()}}
              
            </div>
        </div>
    </div>
    
@stop
