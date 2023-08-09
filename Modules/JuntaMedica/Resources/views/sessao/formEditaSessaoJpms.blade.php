@extends('adminlte::page')
@section('title', 'Sessoes')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-md-12">
                <div class="scheduler-border">
                    <form class="form" id="formEditaSessao" method="post" action='{{url("juntamedica/sessoes/edita/".$sessao->id)}}'> 
                        {{csrf_field()}}
                        <fieldset class="scheduler-border">    	
                            <legend class="scheduler-border">DADOS DA SESSÃO</legend>
                            <div class="row">
                                <div class="form-group{{ $errors->has('ce_tipo') ? ' has-error' : '' }} col-md-12">
                                    <label for="ce_tipo" class="control-label">TIPO DA SESSÃO</label>
                                    <select id="ce_tipo" name="ce_tipo" class="form-control" >
                                    @foreach($tipos as  $tp)
                                    @if($tp->id == $sessao->ce_tipo)
                                    <option value="{{$tp->id}}" selected>{{$tp->st_tipo}}</option>
                                    @else
                                    <option value="{{$tp->id}}">{{$tp->st_tipo}}</option>
                                    @endif
                                    @endforeach                      
                                    </select>
                                    @if ($errors->has('ce_tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ce_tipo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('bo_sessaovirtual') ? ' has-error' : '' }} col-md-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="bo_sessaovirtual" value="1" {{ ($sessao->bo_sessaovirtual == '1') ? 'checked':''}}>
                                        <strong> SESSÃO VIRTUAL </strong>
                                    </div>
                                    @if ($errors->has('bo_sessaovirtual'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bo_sessaovirtual') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('dt_sessao') ? ' has-error' : '' }} col-md-12">
                                    <label for="dt_sessao" class="control-label">DATA DA SESSÃO</label>
                                    <input id="dt_sessao" type="date" class="form-control" name="dt_sessao" value="{{$sessao->dt_sessao}}"> 
                                    @if ($errors->has('dt_sessao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dt_sessao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_numsei') ? ' has-error' : '' }} col-md-12">
                                    <label for="st_numsei" class="control-label">NÚMERO DO SEI</label>
                                    <input id="st_numsei" type="text" class="form-control" name="st_numsei" value="{{$sessao->st_numsei}}" > 
                                    @if ($errors->has('$sessao->st_numsei'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_numsei') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_obs') ? ' has-error' : '' }} col-md-12">
                                    <label for="st_obs" class="control-label col-md-12">OBSERVAÇÃO</label>
                                    <textarea id="st_obs" type="text" name="st_obs" rows="5" cols="145">{{$sessao->st_obs}}</textarea>
                                    @if ($errors->has('st_obs'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_obs') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Salvar
    </button>
    <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar"><i class="glyphicon glyphicon-arrow-left"></i> Voltar
    </a>
    </form>
</div>

@stop

@section('css')
<style>
    button{
        margin-left: 15px;
    }
</style>
@endsection

