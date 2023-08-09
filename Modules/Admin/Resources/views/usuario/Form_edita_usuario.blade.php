@extends('adminlte::page')

@section('title', 'Edita Usuarios')

@section('content')
<div class="container">
        <div class="row">
        
     
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Altera Usuário</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/usuario/edit/'.$usuario->id) }}">
                            {{ csrf_field() }}
                            
    
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nome</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" required="true" placeholder="Nome do Usuário" name="name" value="{{ $usuario->name }}"> 
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('matricula') ? ' has-error' : '' }}">
                                <label for="matricula" class="col-md-4 control-label">Matrícula</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" required="true" placeholder="Matrícula" name="matricula" value="{{$usuario->matricula  }}"> 
                                    @if ($errors->has('matricula'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matricula') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }}">
                                <label for="st_cpf" class="col-md-4 control-label">CPF</label>
    
                                <div class="col-md-6">
                                    <input id="st_cpf" type="text" required="true" class="form-control" placeholder="Informe o cpf" name="st_cpf" value="{{ $usuario->st_cpf }}"> 
                                    @if ($errors->has('st_cpf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_cpf') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" required="true" class="form-control" placeholder="E-mail" name="email" value="{{$usuario->email }}"> 
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }}">
                                <label for="ce_unidade" class="col-md-4 control-label">Unidade</label>
                                <div class="col-md-6">
                                    <select class='form-control select2' required name='ce_unidade' id='ce_unidade'  >
                                        
                                        @foreach($unidades as $u)
                                        <option value="{{$u->id}}" {{($u->id) == ($usuario->ce_unidade) ? 'selected' : ''}}>{{$u->st_nomepais}}</option>
                                          {{--   <option value="{{$usuario->id}}">{{$u->st_nomepais}}</option> --}}
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ce_unidade'))
                                    <span class="help-block text-center">
                                        <strong>{{ $errors->first('ce_unidade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group ">
                                <div class="col-md-2  col-md-offset-4">
                                    <a href='{{ url("admin/usuarios") }}' class=" btn btn-danger"  title="Voltar">
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

      
</div>



@stop