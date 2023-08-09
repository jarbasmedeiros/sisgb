@extends('adminlte::page')

@section('title', 'Cadastro de Funções')

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
                    <div class="panel-heading">Cadastro Função</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/rh/funcoes') }}">
                            {{ csrf_field() }}
                                
                            <div class="form-group{{ $errors->has('st_funcao') ? ' has-error' : '' }}">
                                <label for="st_funcao" class="col-md-4 control-label">Função</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" required="true" placeholder="Função" name="st_funcao" value="{{ old('st_funcao') }}"> 
                                    @if ($errors->has('st_funcao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_funcao') }}</strong>
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
@stop