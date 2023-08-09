@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                @if(Request::segment(2) == 'escriturarfichadereconhecimento')
                    <div class="panel-heading">Escriturar Ficha</div>
                @elseif(    Request::segment(2) == 'homologarfichareconhecimento' 
                            || Request::segment(2) == 'homologadosfichareconhecimento' 
                            || Request::segment(2) == 'buscapolicialparahomologar' 
                            || Request::segment(2) == 'recursosfichareconhecimento' 
                            || Request::segment(2) == 'recursosanalisadosfichareconhecimento' 
                            || Request::segment(2) == 'buscapolicialfichaaba'
                        )
                    <div class="panel-heading">Homologar Ficha</div>
                @elseif(Request::segment(2) == 'realizartaf' || Request::segment(2) == 'realizartafinspecionado')
                    <div class="panel-heading">Realizar TAF</div>
                @elseif(Request::segment(2) == 'policiaisinspecionados' || Request::segment(2) == 'inspecaoparapromocaojpms')
                    <div class="panel-heading">Inspeção de Saúde</div>
                <!-- @aggeu -->
                @elseif(Request::segment(2) == 'buscapolicialparapreanalisejpms' || Request::segment(2) == 'preanalisejpms' || Request::segment(2) == 'compendencianajpms' || Request::segment(2) == 'sempendencianajpms')
                    <div class="panel-heading">Listagem de Pré-análise</div>
                <!-- / -->
                @elseif(Request::segment(2) == 'fichasgtnaoenviada' || Request::segment(2) == 'fichasgtenviada')
                    <div class="panel-heading">{{$titulopainel}} {{date('d/m/Y', strtotime($quadro->dt_promocao))}}</div>
                @elseif(Request::segment(2) == 'listaanalisarrecurso' || Request::segment(2) == 'listarecursosavaliados')
                    <div class="panel-heading">{{$titulopainel}} {{date('d/m/Y', strtotime($quadro->dt_promocao))}}</div>
                @endif
                <div class="panel-body">
                    <div class="nav-tabs-custom">
                        @if(Request::segment(2) == 'policiaisinspecionados' || Request::segment(2) == 'inspecaoparapromocaojpms' || Request::segment(2) == 'buscapolicialparainspecaodesaude')
                            <ul class="nav nav-tabs">
                                <li class="{{(Request::segment(2) == 'inspecaoparapromocaojpms') ? 'active' : ''}}">
                                    <a href="{{url('promocao/inspecaoparapromocaojpms/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}">Policiais para ser inspecionados</a>
                                </li>
                                <li class="{{(Request::segment(2) == 'policiaisinspecionados') ? 'active' : ''}}">
                                    <a href="{{url('promocao/policiaisinspecionados/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}">Policiais inspecionados</a>
                                </li>
                            </ul>
                        @endif
                        <!-- @aggeu, #254. -->
                        @if(Request::segment(2) == 'preanalisejpms' || Request::segment(2) == 'compendencianajpms' || Request::segment(2) == 'sempendencianajpms' || Request::segment(2) == 'buscapolicialparapreanalisejpms')
                            <ul class="nav nav-tabs">
                                <li class="{{(Request::segment(2) == 'preanalisejpms') ? 'active' : ''}}">
                                    <a href="{{url('promocao/preanalisejpms/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}">Convocados</a>
                                </li>
                                <li class="{{(Request::segment(2) == 'sempendencianajpms') ? 'active' : ''}}">
                                    <a href="{{url('promocao/sempendencianajpms/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}">Regular</a>
                                </li>
                                <li class="{{(Request::segment(2) == 'compendencianajpms') ? 'active' : ''}}">
                                    <a href="{{url('promocao/compendencianajpms/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}">Com pendência médica</a>
                                </li>
                            </ul>
                        @endif
                        <!-- / -->
                        @if(Request::segment(2) == 'realizartaf' || Request::segment(2) == 'realizartafinspecionado'|| Request::segment(2) == 'buscapolicialparataf')
                            <ul class="nav nav-tabs">
                                <li class="{{(Request::segment(2) == 'realizartaf') ? 'active' : ''}}">
                                    <a href="{{url('promocao/realizartaf/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}">Policiais para ser inspecionados</a>
                                </li>
                                <li class="{{(Request::segment(2) == 'realizartafinspecionado') ? 'active' : ''}}">
                                    <a href="{{url('promocao/realizartafinspecionado/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}">Policiais inspecionados</a>
                                </li>
                            </ul>
                        @endif
                        @if(Request::segment(2) == 'homologarfichareconhecimento' || Request::segment(2) == 'homologadosfichareconhecimento' || Request::segment(2) == 'buscapolicialparahomologar' || Request::segment(2) == 'recursosfichareconhecimento' || Request::segment(2) == 'recursosanalisadosfichareconhecimento' || Request::segment(2) == 'buscapolicialfichaaba')
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="dropdown {{(Request::segment(2) == 'homologarfichareconhecimento') ? 'active' : ''}}">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-hourglass-half"></i> Não Homologados <span class="caret"></span> </a>
                                        <ul class="dropdown-menu">
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/homologarfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/todos')}}')" role="menuitem" tabindex="-1"> Todos </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/homologarfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/1sgt')}}')" role="menuitem" tabindex="-1"> 1º Sgt </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/homologarfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/2sgt')}}')" role="menuitem" tabindex="-1"> 2º Sgt </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/homologarfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/3sgt')}}')" role="menuitem" tabindex="-1"> 3º Sgt </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/homologarfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/cb')}}')" role="menuitem" tabindex="-1"> CB </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/homologarfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/sd')}}')" role="menuitem" tabindex="-1"> SD </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{(Request::segment(2) == 'homologadosfichareconhecimento') ? 'active' : ''}}">
                                        <a href="{{url('promocao/homologadosfichareconhecimento/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}"> <i class="fa fa-gavel"></i> Homologados</a>
                                    </li>
                                    @if ( Request::segment(2) == 'recursosfichareconhecimento' || ( Request::segment(2) == 'buscapolicialfichaaba' && Request::segment(7) == 'recursos' ) )
                                        <li class="dropdown active">
                                    @else
                                        <li class="dropdown">
                                    @endif
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-balance-scale"></i> Recursos <span class="caret"></span> </a>
                                        <ul class="dropdown-menu">
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/recursosfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/todos')}}')" role="menuitem" tabindex="-1"> Todos </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/recursosfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/1sgt')}}')" role="menuitem" tabindex="-1"> 1º Sgt </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/recursosfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/2sgt')}}')" role="menuitem" tabindex="-1"> 2º Sgt </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/recursosfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/3sgt')}}')" role="menuitem" tabindex="-1"> 3º Sgt </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/recursosfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/cb')}}')" role="menuitem" tabindex="-1"> CB </a>
                                            </li>
                                            <li role="presentation">
                                                <a onclick="alterarGraduacao('{{url('promocao/recursosfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia.'/graduacao/sd')}}')" role="menuitem" tabindex="-1"> SD </a>
                                            </li>
                                        </ul>
                                    </li>
                                    {{-- <li class="{{(Request::segment(2) == 'recursosanalisadosfichareconhecimento') ? 'active' : ''}}"> --}}
                                    @if ( Request::segment(2) == 'recursosanalisadosfichareconhecimento' || ( Request::segment(2) == 'buscapolicialfichaaba' && Request::segment(7) == 'analisados' ) )
                                        <li class="active">
                                    @else
                                        <li class="">
                                    @endif
                                        <a href="{{url('promocao/recursosanalisadosfichareconhecimento/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}"> <i class="fa fa-check-square-o"></i> Analisados</a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                        @if(Request::segment(2) == 'fichasgtnaoenviada' || Request::segment(2) == 'fichasgtenviada')
                            <ul class="nav nav-tabs">
                                <li class="{{(Request::segment(2) == 'fichasgtnaoenviada') ? 'active' : ''}}">
                                    <a href="{{url('promocao/fichasgtnaoenviada/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}"> <i class="fa fa-hourglass-half"></i> Não enviadas </a>
                                </li>
                                <li class="{{(Request::segment(2) == 'fichasgtenviada') ? 'active' : ''}}">
                                    <a href="{{url('promocao/fichasgtenviada/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}"> <i class="fa fa-send-o"></i> Enviadas </a>
                                </li>
                            </ul>
                        @endif
                        @if(Request::segment(2) == 'listaanalisarrecurso' || Request::segment(2) == 'listarecursosavaliados')
                            <ul class="nav nav-tabs">
                                <li class="{{(Request::segment(2) == 'listaanalisarrecurso') ? 'active' : ''}}">
                                    <a href="{{url('promocao/listaanalisarrecurso/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}">Não avaliadas</a>
                                </li>
                                <li class="{{(Request::segment(2) == 'listarecursosavaliados') ? 'active' : ''}}">
                                    <a href="{{url('promocao/listarecursosavaliados/'.$quadro->id.'/'.$atividade->id. '/competencia/'.$competencia)}}">Avaliadas</a>
                                </li>
                            </ul>
                        @endif
                        <div class="tab-content">
                            @yield('tabcontent')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    //função para alterar a graduação selecionada
    function alterarGraduacao(url){

        //recebe o valor do option selecionado no select "graduacao_selecionada_homologar"
        //let graduacaoSelecionada = $('#div_graduacao_seleciona_homologar option:selected').val();

        //monta a URL base "...sisgp/"
        var getUrl = window.location;
        let baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        baseUrl += "/";

        //redireciona para a rota com a graduação selecionada
        //window.location.href = url + '/' + graduacaoSelecionada
        window.location.href = url

    }
    
</script>

@endsection

