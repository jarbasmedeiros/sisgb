@extends('adminlte::page')

@section('title', 'Edita Permissão')

@section('content')
<div class="container">
        <div class="row">
        
     
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Altera Permissão</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/permission/edita/'.$permission->id) }}">
                            {{ csrf_field() }}
                            
    
                            <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nome</label>
    
                                <div class="col-md-6">
                                    <input id="st_nome" type="text" class="form-control" required="true" placeholder="Nome da Permissão" name="st_nome" value="{{ $permission->st_nome }}"> 
                                    @if ($errors->has('st_nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_nome') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('st_label') ? ' has-error' : '' }}">
                                <label for="st_label" class="col-md-4 control-label">Descrição</label>
    
                                <div class="col-md-6">
                                    <input id="st_label" type="text" class="form-control" required="true" placeholder="Descrição da Permissão" name="st_label" value="{{$permission->st_label  }}"> 
                                    @if ($errors->has('st_label'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_label') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('st_modulo') ? ' has-error' : '' }}">
                                <label for="st_modulo" class="col-md-4 control-label">Módulo</label>
    
                                <div class="col-md-6">
                                    <input id="st_modulo" type="text" class="form-control" required="true" placeholder="Descrição do Módulo" name="st_modulo" value="{{$permission->st_modulo}}"> 
                                    @if ($errors->has('st_modulo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_modulo') }}</strong>
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
                                    <i class="fa fa-btn fa-user"></i> Salvar
                                </button>
                            </div>


                            
    
    
                        </form>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    
@stop