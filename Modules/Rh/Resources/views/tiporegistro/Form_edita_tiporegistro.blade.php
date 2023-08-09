@extends('adminlte::page')

@section('title', 'Editar Tipo de Registro')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Editar Tipo de Registro</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/rh/tiporegistro/edita/'.$tiporegistro->id) }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}">
                            <label for="st_tipo" class="col-md-4 control-label">Tipo</label>

                            <div class="col-md-6">
                                <input id="st_tipo" type="text" class="form-control" placeholder="Digite o tipo do registro" name="st_tipo" value="{{ $tiporegistro->st_tipo }}" required> 
                                @if ($errors->has('st_tipo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_tipo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                            <label for="st_descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="2" id="st_descricao" name="st_descricao" placeholder="Digite uma descrição" required>{{ $tiporegistro->st_descricao }}</textarea>
                                @if ($errors->has('st_descricao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_descricao') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-2  col-md-offset-4">
                                <a href="javascript:history.back()" class=" btn btn-danger"  title="Voltar">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>
                            </div>
                            <button type="submit" class="col-md-2 btn btn-primary">
                                <i class="fa fa-fw fa-file"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop