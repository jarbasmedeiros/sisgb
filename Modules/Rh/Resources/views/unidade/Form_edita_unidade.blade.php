@extends('adminlte::page')

@section('title', 'Edição de Unidade')

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
                    <div class="panel-heading">Editar unidade</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action='{{ url("rh/unidade/edita/$unidade->id") }}'>
                            {{ csrf_field() }}
                                
                            <div class="form-group{{ $errors->has('st_sigla') ? ' has-error' : '' }}">
                                <label for="st_sigla" class="col-md-4 control-label">Sigla</label>
    
                                <div class="col-md-6">
                                    <input type="text" class="form-control" required="true" placeholder="Sigla" name="st_sigla" value="{{$unidade->st_sigla}}"> 
                                    @if ($errors->has('st_sigla'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_sigla') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                                <label for="st_descricao" class="col-md-4 control-label">Descrição</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" required="true" placeholder="Descrição" name="st_descricao" value="{{$unidade->st_descricao}}"> 
                                    @if ($errors->has('st_descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_descricao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('ce_pai') ? ' has-error' : '' }}">
                                <label for="ce_pai" class="col-md-4 control-label">Filho de: </label>
                                <div class="col-md-6">
                                    <select class="form-control select2" name="ce_pai" data-placeholder="Selecione de unidade pai" style="width: 100%;">
                                        @foreach($unidades as $u)
                                        
                                            @if($u->ce_pai == $unidade->ce_pai)
                                                <option value="{{$u->ce_pai}}" selected = "true">{{$u->hierarquia}}</option>
                                        @else
                                                <option value="{{$u->ce_pai}}" >{{$u->hierarquia}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ce_pai'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ce_pai') }}</strong>
                                    </span>
                                    @endif
                                </div>
						    </div>
    
                            <div class="form-group ">
                                <div class="col-md-2  col-md-offset-4">
                                    <a href='{{ url("rh/unidades/listagem")}}' class=" btn btn-danger"  title="Voltar">
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