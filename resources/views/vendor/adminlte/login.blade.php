@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page') 

@section('body')

@php 
    $estado = env('MANUTENCAO_SISTEMA');            
                
    if(!empty($estado)){
        if($estado != 'PRODUCAO'){
            $alerta = "<div class='alert alert-danger'><h4>ATENÇÃO! SISTEMA EM MANUTENÇÃO!</h4></div>";
        } else {
            $alerta = '';
        }  
    }    
@endphp

    <div class="container"style=" padding-top:130px !important; height: 10px;  Width:380px;" >
    <div class="login-logo" >
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
            <h4>Sistema Integrado de Gestão Policial</h4>
            @if(!empty($alerta))
            @php 
                echo $alerta;
            @endphp
            @endif
        </div>
        
        <!-- /.login-logo -->
        <div class="login-box-body" >
            <p class="login-box-msg">Informe as credenciais e pressione o botão ENTRAR para acessar o sistema {{env('MEUSERVIDOR')}}.</p>
            <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                {!! csrf_field() !!}
                @if(session('erroMsg'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Atenção!</strong> {{ session('erroMsg')}}
                    </div>
                @endif
                    <div class="form-group has-feedback {{ $errors->has('st_cpf') ? 'has-error' : '' }}">
                        <input type="text" name="st_cpf"  id="st_cpf" class="form-control" value="{{ old('st_cpf') }}"
                            placeholder="CPF: 000.000.000-00">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('st_cpf'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_cpf') }}</strong>
                            </span>
                        @endif
                    </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <br>
                {!! Recaptcha::render() !!}
                <br>
                <div class="row">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>                     
                    </div>
                    <div class="col-xs-4"></div>
                </div>
            </form>
        </div>
      <!--  <div class="login-box-msg" style="Width:100%"> Meu servidor: {{env('MEUSERVIDOR')}} </div>-->
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
