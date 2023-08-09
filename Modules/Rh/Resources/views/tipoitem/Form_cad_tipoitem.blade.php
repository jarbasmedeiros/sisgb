@extends('adminlte::page')

@section('title', 'Cadastro de Tipo de Item')

@section('content')
<div class="row">
    <div class="col-md-12">        
        @if(session('sucessoMsg'))
        <div class="container">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Sucesso!</strong> {{ session('sucessoMsg')}}
            </div>
        </div>
        @endif
        @if(session('erroMsg'))
        <div class="container">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Atenção!</strong> {{ session('erroMsg')}}
            </div>
        </div>
        @endif
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Cadastro de Tipo de Item</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/rh/tipoitens') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('st_item') ? ' has-error' : '' }}">
                            <label for="st_item" class="col-md-4 control-label">Item</label>

                            <div class="col-md-6">
                                <input id="st_item" type="text" class="form-control" placeholder="Digite o tipo do item" name="st_item" value="{{ old('st_item') }}" required> 
                                @if ($errors->has('st_item'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_item') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                            <label for="st_descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="2" id="st_descricao" name="st_descricao" placeholder="Digite uma descrição" required>{{ old('st_descricao') }}</textarea>
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
                                <i class="fa fa-check"> </i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection