@extends('adminlte::page')

@section('title', 'Edita Perfil')

@section('content')
<div class="container">
        <div class="row">
        
     
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Altera Perfil</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/role/edita/'.$role->id) }}">
                            {{ csrf_field() }}
                            
    
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nome</label>
    
                                <div class="col-md-6">
                                    <input id="st_nome" type="text" class="form-control" required="true" placeholder="Nome do Perfil" name="st_nome" value="{{ $role->st_nome }}"> 
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
                                    <input id="st_label" type="text" class="form-control" required="true" placeholder="st_label" name="st_label" value="{{$role->st_label  }}"> 
                                    @if ($errors->has('st_label'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_label') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <div class="col-md-2  col-md-offset-4">
                                    <a href="javascript:history.back()" class=" btn btn-warning"  title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>
                                </div>
                                <button type="submit" class="col-md-2 btn btn-primary">
                                    <i class="fa fa-save"></i> Salvar
                                </button>
                            </div>

                            <div style="border: solid #0a6 1px; margin-top: 30px;  margin-bottom: 30px;" class="col-md-12 form-inline">
                            <h4 style="background: #0a6; color: #fff;">Permissões do Perfil</h4>
                                   
                            @foreach ($permissoes as $key => $permissao)
                            
                            <div class="col-md-3 form-inline">
                                <input type="checkbox" name="permissao[]" value="{{$permissao->id}}"

                                @foreach ($permissoescadastradas as $chave => $cadastrada) 
                                    @if($cadastrada->permission_id == $permissao->id)
                                        checked
                                    @endif 
                                @endforeach
                                /><strong>{{$permissao->st_nome}}</strong>
                            </div>
                        
                            @endforeach
                       </div>  
    
    
                        </form>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    
@stop