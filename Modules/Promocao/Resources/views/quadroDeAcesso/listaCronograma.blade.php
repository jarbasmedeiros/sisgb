@extends('adminlte::page')
@section('title', 'SISGP - Cronograma de Quadro de Acesso')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
<div class="container-fluid">
    <div class="row">
        <button class="btn btn-primary" style="float:right; margin-bottom:1%; margin-right:1%;" data-toggle="modal" data-target="#addNovaAtividade">
            Adicionar Atividade
        </button>
    </div>
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                CRONOGRAMA DA PROMOÇÃO DE
                @if(isset($cronograma) && count($cronograma) > 0)
                    {{date('d/m/Y', strtotime($cronograma[0]->dt_promocao))}}
                @endif
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-1">Realizado</th>
                                <th class="col-md-3">Atividade</th>
                                <th class="col-md-4">Publicação</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($cronograma) && count($cronograma) > 0)
                            @foreach($cronograma as $c)
                                <tr>
                                    @if($c->st_status == 'CONCLUIDO')
                                        <th style="text-align:center;">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </th>
                                    @elseif($c->st_status == 'PUBLICAR')
                                        <th style="text-align:center;">
                                            <span class="fa fa-hourglass-end"></span>
                                        </th>
                                    @else
                                        <th></th>
                                    @endif
                                    <th>{{$c->st_atividade}}</th>
                                    <th>{{$c->st_boletim}}</th>
                                    <th>
                                        @if(!empty($c->st_link))
                                            @if($c->bo_liberado)
                                                <a href="{{url($c->st_link.$c->ce_quadroacesso.'/'.$c->id.'/competencia/'.$competencia)}}" class='btn btn-primary fa fa fa-eye' title="Abrir"></a>
                                            @else
                                                <button class='btn btn-primary fa fa fa-eye' title="Abrir" disabled></button>
                                            @endif
                                        @else
                                            <a href="{{url('promocao/quadro/cronograma/removeratividade/'.$idQuadro.'/'.$c->id)}}" class='btn btn-danger fo fa fa-close' title="Excluir Atividade"></a>
                                        @endif
                                    </th>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{ url('promocao/listadequadrodeacesso/competencia/'.$competencia)}}" class="col-md-1 btn btn-warning">
            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
        </a>
        
    </div>

     <!-- Modal para adicionar Atividade Manual ao Cronorama -->
  <div class="modal fade" id="addNovaAtividade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Nova Atividade</h4>
        </div>
        <div class="modal-body">
            
            <form role="form" method="POST" action="{{url('promocao/quadro/cronograma/adicionaratividade/'.$idQuadro) }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('nu_fase') ? ' has-error' : '' }}">
                <label for="nu_fase" class="control-label">Fase</label>
                <select id="nu_fase" name="nu_fase" class="form-control" required="true"> 
                    <option value="">Selecione</option>
                    <option value="1">Preparação</option>
                    <option value="2">Inspeção</option>
                    <option value="3">Análise</option>
                    <option value="4">Promoção</option>
                    
                </select>
                @if ($errors->has('nu_fase'))
                <span class="help-block">
                    <strong>{{ $errors->first('nu_fase') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('st_atividade') ? ' has-error' : '' }} ">
                    <label for="st_atividade" class="control-label">Atividade</label>
                    <input id="st_atividade" type="text" class="form-control" name="st_atividade"  required> 
                    @if ($errors->has('st_atividade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_atividade') }}</strong>
                    </span>
                    @endif
            </div>
            <div class="form-group{{ $errors->has('dt_atividade') ? ' has-error' : '' }} ">
                    <label for="dt_atividade" class="control-label">Data da Publicação</label>
                    <input id="dt_atividade" type="date" class="form-control" name="dt_atividade"  required> 
                    @if ($errors->has('dt_atividade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_atividade') }}</strong>
                    </span>
                    @endif
            </div>
            <div class="form-group{{ $errors->has('st_boletim') ? ' has-error' : '' }} ">
                    <label for="st_boletim" class="control-label">Boletim</label>
                    <input id="st_boletim" type="text" class="form-control" name="st_boletim"  required>
                    @if ($errors->has('st_boletim'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_boletim') }}</strong>
                    </span>
                    @endif
            </div>
        </div>
            
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <button type="submit"  class="btn btn-primary">Adicionar ao Atividade</button>
         
        </form>
        </div>
      </div>
    </div>
  </div>


@stop