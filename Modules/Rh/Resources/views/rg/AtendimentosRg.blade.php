@extends('adminlte::page')

@section('title', 'Atendimentos de RG')
@can('Administrador')
@section('content_header')

@stop
@endcan

@section('content')
    
<div class="panel panel-primary">
    <div class="panel-heading">Atendimentos de RG</div>
        <div class="panel-body">
        @can("IDENTIFICAR_PM")
        <div class="panel panel-primary">
            <div class="panel-heading">Buscar Atendimentos</div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{url('rh/rg/atendimentos')}}">
                    {{ csrf_field() }}
                        <div class='row'>
                            <div class="form-group col-md-2">
                                <label for="dt_inicial" class="control-label">
                                    Data Inicial
                                </label>
                                <input  min="{{$dataMinima}}" max="{{$dataInicio}}" id="dt_inicial" type="date" class="form-control" name="dt_inicio" @if(isset($dadosForm["dt_inicio"])) value="{{$dadosForm["dt_inicio"]}}" @endif required> 
                            </div>
                            <div class="form-group col-md-2">
                                <label for="dt_final" class="control-label">
                                    Data Final
                                </label>
                                <input min="{{$dataMinima}}" max="{{$dataInicio}}" id="dt_final" type="date" class="form-control" name="dt_fim" @if(isset($dadosForm["dt_fim"])) value="{{$dadosForm["dt_fim"]}}" @endif required> 
                            </div>
                            <div style='margin-top: 25px'>
                                <button type='submit' class='btn btn-primary'>Buscar</button>
                            </div>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
        <div style="padding:10px">
        @if(count($dados) > 0)
            <table class='table table-hover'>
                <thead style="background-color: #337ab7; color: white">
                    <tr>
                        <th>Nº</th>
                        <th>Cédula</th>
                        <th>RG</th>
                        <th>Matrícula</th>
                        <th>Grad</th>
                        <th>Nome</th>
                        <th>Emissão</th>
                        <th>Entrega</th>
                        <th>Triturada</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dados as $rg)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td><strong>{{$rg->st_cedula}}</strong></td>
                        <td><strong>{{$rg->policial->st_rgmilitar}}</strong></td>
                        <td>{{$rg->policial->st_matricula}}</td>
                        <td>{{$rg->policial->graduacao->st_postograduacao}}</td>
                        <td>{{$rg->st_nome}}</td>
                        <td>@if($rg->dt_emissao!=null){{date('d/m/Y', strtotime($rg->dt_emissao))}}@else <a title="Não foi emitida!" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>  @endif</td>
                        <td>@if($rg->dt_entrega1!=null){{date('d/m/Y', strtotime($rg->dt_entrega1))}}@else <a title="Não foi entregue!" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>  @endif</td>
                        <td>@if($rg->dt_devolucao1!=null){{date('d/m/Y', strtotime($rg->dt_devolucao1))}}@else <a title="Não foi devolvida!" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>  @endif</td>
                        <td>{{$rg->st_obs}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else 
        <p>Nenhum atendimento realizado nesta data.</p>
        @endif
        </div>
    </div>
</div>
@stop