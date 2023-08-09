@extends('adminlte::page')

@section('title', 'Redifinir Senha')



@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(isset($sucesso))
            <div id="sucesso" class="alert-success">
                {{$sucesso}}
            </div>
             @endif
            @if(isset($erro))
            <div class="alert-danger">
                {{$erro}}
            </div>
             @endif
            <div class="panel panel-primary">
                <div class="panel-heading">Redefinir Senha</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('usuario/alterasenha/'.$id) }}">
                        {{ csrf_field() }}
                       
                        
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Nova Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" required="required" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Nova Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password"  class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>-->

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Senha</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password"  class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-inline">
                            <div class="col-md-2 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i> Redefinir Senha
                                </button>
                                 
                            </div>
							@if(Auth::user()->id == $id)
                            <div class="col-md-2 col-md-offset-1 btn btn-primary">
                                 <a  href='{{ url("/") }}' class="btn-primary">
                                   Voltar
                               </a>
                            </div>
							@else
							 <div class="col-md-2 col-md-offset-1 btn btn-primary">
                                 <a  href='{{ url("usuarios") }}' class="btn-primary">
                                    Voltar
                               </a>
                            </div>
							@endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
<script src="{{url('/assets/js/jquery-3.1.1.min.js')}}"></script>
<script>
$(document).ready(function(){
//       se existe valor na dive suscesso, deve redirecionar para a página home
    var valorDaDiv = $(".alert-success").text(); 
    if(valorDaDiv != ""){
        window.setTimeout(function(){
        window.location.href = '../';

        }, 3000);
    }

});
</script>