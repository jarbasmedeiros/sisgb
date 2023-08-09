@extends('adminlte::page')

@section('title', 'Edita Órgãos')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Altera Órgão</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/rh/orgao/edita/'.$orgao->id) }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('st_orgao') ? ' has-error' : '' }}">
                                <label for="st_orgao" class="col-md-4 control-label">Nome</label>
    
                                <div class="col-md-6">
                                    <input id="st_orgao" type="text" class="form-control" required="true" placeholder="Nome do Órgão" name="st_orgao" value="{{ $orgao->st_orgao }}"> 
                                    @if ($errors->has('st_orgao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_orgao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('st_sigla') ? ' has-error' : '' }}">
                                <label for="st_sigla" class="col-md-4 control-label">Sigla</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" required="true" placeholder="Sigla" name="st_sigla" value="{{$orgao->st_sigla  }}"> 
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
                                    <input id="st_descricao" type="text" required="true" class="form-control" placeholder="Informe a descrição" name="st_descricao" value="{{ $orgao->st_descricao }}"> 
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
    
@stop