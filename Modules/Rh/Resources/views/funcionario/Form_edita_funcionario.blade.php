@extends('adminlte::page')

@section('title', 'Edição de Servidor')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Edição de Servidor</div>
                <div class="panel-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="{{ (Request::segment(4)=='dados_pessoais')?'active':'' }}">
                                <a href="{{url('rh/servidor/edita/'.$servidor->id.'/dados_pessoais')}}" >Dados Pessoais</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='dados_funcionais')?'active':'' }}">
                                <a href="{{url('rh/servidor/edita/'.$servidor->id.'/dados_funcionais')}}" >Dados Funcionais</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='documentos')?'active':'' }}">
                                <a href="{{url('rh/servidor/edita/'.$servidor->id.'/documentos')}}" >Documentos</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='dados_academicos')?'active':'' }}">
                                <a href="{{url('rh/servidor/edita/'.$servidor->id.'/dados_academicos')}}" >Dados Acadêmicos</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='ferias')?'active':'' }}">
                                <a href="{{url('rh/listacrportipo/'.$servidor->id.'/1/listagem')}}" >Férias</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='dados_medalhas')?'active':'' }}">
                                <a href="{{url('rh/servidor/edita/'.$servidor->id.'/dados_medalhas')}}" >Medalhas</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='licencas')?'active':'' }}">
                                <a href="{{url('rh/listacrportipo/'.$servidor->id.'/2/listagem')}}" >Licenças</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='eventos')?'active':'' }}">
                                <a href="{{url('rh/listacrportipo/'.$servidor->id.'/3/listagem')}}" >Eventos</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='movimentacoes')?'active':'' }}">
                                <a href="{{url('rh/listacrportipo/'.$servidor->id.'/4/listagem')}}" >Movimentações</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='lista_arquivos')?'active':'' }}">
                                <a href="{{url('rh/servidor/edita/'.$servidor->id.'/lista_arquivos')}}" >Arquivos</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            @yield('tabcontent')
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection