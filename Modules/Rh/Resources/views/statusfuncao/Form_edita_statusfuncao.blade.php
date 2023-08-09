@extends('adminlte::page')

@section('title', 'Edição de Status de Função')

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
                    <div class="panel-heading">Editar Status de Função</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action='{{ url("rh/statusfuncao/edita/$statusfuncao->id") }}'>
                            {{ csrf_field() }}
                                
                            <div class="form-group{{ $errors->has('st_status') ? ' has-error' : '' }}">
                                <label for="st_status" class="col-md-4 control-label">Status de Função</label>
    
                                <div class="col-md-6">
                                    <input id="st_status" type="text" class="form-control" required="true" placeholder="Status de Função" name="st_status" value="{{$statusfuncao->st_status}}"> 
                                    @if ($errors->has('st_status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group ">
                                <div class="col-md-2  col-md-offset-4">
                                    <a href='{{ url("rh/statusfuncoes")}}' class=" btn btn-danger"  title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Cancelar
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