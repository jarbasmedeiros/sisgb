
@extends('adminlte::page')

@section('title', 'Lista de Servidor')
@can('Edita')
    @section('content_header')
    
    <div class="row">
        <div class="col-md-1">
            <a class="btn btn-primary  pull-left" href="{{url('rh/servidor/create')}}">Novo Servidor</a>
        </div>
        @if(isset($status))
            <div class="col-md-10">
                
                <form id="listaFuncionarioFilter" class="form-inline pull-left"  role="form" method="POST" action='{{ url("rh/servidores/" .$status. "/listagem/") }}'>
                    {{csrf_field()}}
                    <div class="form-group">
                        <input id="st_tipo" type="hidden"  name="st_tipo" value="{{$st_tipo or 'null'}}"> 
                        <div class="col-md-2">
                            <select id="filterlist" name="filterlist" required="true" class="form-control" onclick="selectFilterFuncionarios()">
                                <option value="">Selecione</option>
                                <option value="ce_setor">Setor</option>
                                <option value="ce_orgao">Órgão</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="divSetorFilter" class="form-group{{ $errors->has('st_sigla') ? ' has-error' : '' }}" style="display: none">
                            <div class="col-md-2">
                                <select id="st_sigla" name="st_valor" required="true" class="form-control" disabled="true" onclick="selectFilterFuncionarios()">
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
                    </div>
                    <div class="form-group">
                        <div id="divOrgaoFilter" class="form-group{{ $errors->has('st_orgao') ? ' has-error' : '' }}" style="display: none">
                            <div class="col-md-2">
                                <select id="st_orgao" name="st_valor" required="true" class="form-control" disabled="true" onclick="selectFilterFuncionarios()">
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
                        
                    </div>
                    <button type="submit" onclick="selecionatipoexportacao('listagem')" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
        @endif
    </div>
    @stop
@endcan

@section('content')
        <div class="row">
            <div class="col-md-14">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="6">{{$nome_tabela}} - TOTAL: {{$servidores->total()}}</th> 
                            <th>
                                @can('Edita')
                                    @if(isset($status))
                                        <div class="col-md-1">
                                            <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("rh/servidores/".$status."/execel/") }}'>
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>

                                                <input  type="hidden"  name="filterlist" value="{{$filterlist or 'null'}}"> 
                                                <input type="hidden"  name="st_valor" value="{{$st_valor or 'null'}}"> 
                                                                                            
                                            </form>
                                        </div>
                                    @endif
                                @endcan
                            </th>
                            <th>
                                @can('Edita')
                                    @if(isset($status) )
                                        <div class="col-md-1">
                                            <form id="listaFuncionarioFilter" class="form-horizontal" role="form" method="POST" action='{{ url("rh/servidores/".$status."/pdf/") }}'>
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Gerar PDF</button>
    
                                                <input  type="hidden"  name="filterlist" value="{{$filterlist or 'null'}}"> 
                                                <input type="hidden"  name="st_valor" value="{{$st_valor or 'null'}}"> 
                                                                                            
                                            </form>
                                        </div>                              
                                    @endif
                                @endcan
                            </th>
                        </tr>
                        <tr>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-1">MATRÍCULA</th>
                            <th class="col-md-1">CPF</th>
                            <th class="col-md-1">ORGÃO</th>
                            <th class="col-md-2">SETOR</th>
                            <th class="col-md-1">STATUS</th>
                            <th class="col-md-1">MOTIVO INATIVIDADE</th>
                            @can('Admin')
                                <th class="col-md-3">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($servidores))
                            @forelse($servidores as $s)
                            <tr>
                                <th>{{$s->st_nome}}</th>
                                <th>{{$s->st_matricula}}</th>
                                <th>{{$s->st_cpf}}</th>
                                <th>{{$s->st_siglaorgao}}</th>
                                <th>{{$s->st_siglasetor}}</th>
                                <th>{{($s->bo_ativo == 0) ? 'INATIVO' : 'ATIVO'}}</th>
                                <th>{{$s->st_tipoinatividade}}</th>
                                <th>
                                    @can('Edita')
                                        <a class="btn btn-primary" href="{{url('rh/servidor/edita/'.$s->id.'/dados_pessoais')}}">Editar</a>
                                    @endcan
                                    @can('Consulta_ficha')
                                    <a class="btn btn-primary" href="{{url('rh/servidor/imprimirficha/'.$s->id)}}"><i class="fa fa-fw fa-print"></i>Ficha</a>
                                    @endcan  
                                </th>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Nenhum servidor encontrado.</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
                @if(isset($busca))
                    {{$servidores->appends(['filterlist' => $filterlist, 'st_valor'=> $st_valor, 'busca'=>$busca])->links()}}
                @else
                    {{$servidores->appends(['filterlist' => $filterlist, 'st_valor'=> $st_valor])->links()}}
                @endif
            </div>
        </div>
    </div>

@stop