@extends('adminlte::page')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Prontuário do Pensionista</div>
                <div class="panel-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="{{ (Request::segment(4)=='dados_pessoais')?'active':'' }}">
                                <a href=" {{
                                    URL::route('prontuario_pensionista', [
                                        'pensionistaId' => $idPensionista,
                                        'aba' => 'dados_pessoais',
                                        'acao' => 'editar'
                                    ])
                                }}">
                                    <span class="fa fa-user fa-lg"></span>
                                    Dados Pessoais 
                                </a>
                            </li>
                            <li class="{{ (Request::segment(4)=='dados_pensao')?'active':'' }}">
                                <a href=" {{
                                    URL::route('prontuario_pensionista', [
                                        'pensionistaId' => $idPensionista,
                                        'aba' => 'dados_pensao',
                                        'acao' => 'editar'
                                    ])
                                }}">
                                    <span class="fa fa-money fa-lg"></span>
                                    Dados da Pensão
                                </a>
                            </li>
                            <li class="{{ (Request::segment(4)=='recadastro')?'active':'' }}">
                                <a href=" {{
                                    URL::route('prontuario_pensionista', [
                                        'pensionistaId' => $idPensionista,
                                        'aba' => 'recadastro',
                                        'acao' => 'listar'
                                    ])
                                }}">
                                    <span class="fa fa-refresh fa-lg"></span>
                                    Prova de Vida
                                </a>
                            </li>
                            <li class="{{ (Request::segment(4)=='arquivos')?'active':'' }}">
                                <a href=" {{
                                    URL::route('prontuario_pensionista', [
                                        'pensionistaId' => $idPensionista,
                                        'aba' => 'arquivos',
                                        'acao' => 'editar'
                                    ])
                                }}">
                                    <span class="fa fa-paperclip fa-lg"></span>
                                    Arquivos
                                </a>
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