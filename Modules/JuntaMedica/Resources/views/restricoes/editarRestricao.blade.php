@extends('adminlte::page')
@section('title', 'Restrições')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                CONTROLE DE RESTRIÇÕES MÉDICAS
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <form class="form"  method="post" action='{{url("juntamedica/restricao/update/".$restricao->id)}}'> 
                            {{csrf_field()}}
                            <fieldset class="scheduler-border">    	
                                <legend class="scheduler-border">DADOS DA RESTRIÇÃO</legend>
                                <div class="row">
                                    <div class="form-group{{ $errors->has('st_restricao') ? ' has-error' : '' }} col-md-12">
                                        <label for="st_restricao" class="control-label">RESTRIÇÃO</label>
                                        <input class="form-control" id="st_restricao" name="st_restricao" type="text" value="{{$restricao->st_restricao}}"> 
                                        @if ($errors->has('st_restricao'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_restricao') }}</strong>
                                        </span>
                                        @endif
                                    </div>
            
                                    <div class="form-group{{ $errors->has('st_restricao') ? ' has-error' : '' }} col-md-12">
                                        <label for="bo_ativo" class="control-label">STATUS</label>
                                        <select id="bo_ativo" type="text" class="form-control" name="bo_ativo">
                                            @if($restricao->bo_ativo)
                                                <option value="1" selected>Ativo</option>
                                                <option value="0">Inativo</option>
                                            @else
                                                <option value="1">Ativo</option>
                                                <option value="0" selected>Inativo</option>
                                            @endif
                                        </select>
                                        @if ($errors->has('st_restricao'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_restricao') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{url('juntamedica/restricoes')}}" class="btn btn-danger">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
    <style>
        th, td{text-align: center;}
        #a-voltar {margin-left: 10px;}
    </style>
@stop