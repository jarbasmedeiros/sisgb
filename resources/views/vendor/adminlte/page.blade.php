@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
          <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
          <!-- <link href="{{ asset('css/layout.css') }}" rel="stylesheet"> -->

<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('bootstrap-daterangepicker/daterangepicker.css') }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    @stack('css')
    @yield('css')
    <style>
        .mt-8 {margin-top: 8px;}
        .text-white {color: white}
        .fs-12-pt {font-size: 12pt}
    </style>
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))



@section('body')
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>
            
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
                
                <span class="col-md-3 text-white" style="margin-top: 1%;"> <b> Sistema Integrado de Gestão Policial </b> </span>
                
            @endif
            
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    
                    <ul class="nav navbar-nav">
                        
<!-- Bloco sobre o perfil-->
        <li class="dropdown user user-menu">
            
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">  
              <img src="{{ URL::asset('/imgs/default_profile.jpg') }}"  width='100' height='120' class="user-image" alt="User Image">
              <span class="hidden-xs">{{auth()->user()->name}}</span>
            </a>
            
            <ul class="dropdown-menu" style="background-color:#DCDCDC">
           
              <li class="user-header">
              <img src="{{ URL::asset('/imgs/default_profile.jpg') }}"  width='10' height='10' class="user-image" alt="User Image">
              <p>
                <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">
                Meu servidor: {{env('MEUSERVIDOR')}} 
                </font>
                </font>
              </p>
              </li>
            </ul>
        </li>
        @if (isset(auth()->user()->vinculos) && count(auth()->user()->vinculos) > 1)
            <li>
                <div class="mt-8" id="div_vinculo_seleciona">
                    <select name='vinculo_selecionado' id='vinculo_selecionado' onchange="alterarVinculo()" class="form-control select2">
                        @foreach(auth()->user()->vinculos as $vinculo)
                            <option {{$vinculo['id'] == auth()->user()->ce_vinculo ? 'selected' : ''}} value="{{$vinculo['id']}}">{{ $vinculo['st_unidade'] or 'OPM não informada' }} - {{$vinculo['st_role']}}</option>
                        @endforeach
                    </select>
                </div>
            </li>
        @endif

        @can('Leitura')
            <li>
                <a href="{{ route('sugestoes') }}">
                    <i class="fa fa-fw fa-commenting "></i>
                    <span>Sugestões</span>
                </a>
            </li>
        @endcan
<!-- -->
                        <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> Sair
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> Sair
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                @can('Leitura')
                    <!-- search form -->
                    <!-- @aggeu: Issue 179 consultar policial. -->
                    <form action="{{url('/rh/policiais/buscar')}}" method="post" class="sidebar-form">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" name="busca" id="busca" class="form-control" placeholder="Busca rápida de policial" required>
                            <span class="input-group-btn">
                                <button type="submit" id="search-btn" class="btn btn-flat">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                @endcan
                <!-- search form -->

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>
              

            <!-- Main content -->
            <section class="content">
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
                @if(session('alertaMsg'))
                    <div class="container">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Atenção!</strong> {{ session('alertaMsg')}}
                        </div>
                    </div>
                @endif
               

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{asset('js/functions.js') }}"></script>  
    <script src="{{asset('js/jquery.mask.min.js') }}"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script> -->

    
    <!-- date-range-picker -->
    <script src="{{ asset('moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    
    @stack('js')
    @yield('js')

    <script>

        //função para alterar o vínculo do usuário via ajax
        function alterarVinculo(){
            //recebe o valor do option selecionado no select "vinculo_selecionado"
            let vinculoSelecionado = $('#vinculo_selecionado option:selected').val();
            //monta a URL base "...sisgp/"
            var getUrl = window.location;
            let baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            baseUrl += "/";
            //prepara os dados a serem enviados na requisição
            dados = {
                vinculo: vinculoSelecionado,
                _token: $("input[name=_token]").val()
            };  

            $.ajax({
                //Enviando via ajax
                url : baseUrl+"usuario/alterar_vinculo",
                data: dados,
                method: 'POST',
                dataType: "json",
                beforeSend: function () {
                    //adiciona o loader
                    $("#div_vinculo_seleciona").html("<img src='{{ asset('imgs/carregando.gif') }}' width=30><span class= 'text-white fs-12-pt'><b> Aguarde, atualizando... </b></span>");
                }, 

                //Verificando o retorno
            }).done(function(data){
                if(data.retorno == 'sucesso'){
                    console.log(data.msg);
                    //redireciona para a "/home"
                    window.location.href = baseUrl;
                }else{
                    alert(data.msg);
                    //redireciona para a "/home"
                    window.location.href = baseUrl;
                }
            });

        }
    </script>

@stop
