<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PDF -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/quadroAcesso.css') }}"> -->
    <style>
        .justificativa{
            text-align: justify;
        }

        .espacamento {
            padding: 1%;
        }
        .rodape {
            position: fixed;
            bottom: -60px; 
            left: 0px; 
            right: 0px;
            height: 50px; 
            font-size: 8px;
            /** Extra personal styles **/
            /* text-align: center; */
            line-height: 5px;
        }
        div {
            font-size: 16px;
            font-weight: normal;
        }
    </style>
    <title>RECURSO AO QUADRO DE ACESSO - {{$ficha->st_matricula}}</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary container-fluid">
                <div class="panel-heading row" style="text-align:center;">
                    <span><b>ESTADO DO RIO GRANDE DO NORTE</b></span><br/>
                    <span><b>SECRETARIA DE ESTADO DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL</b></span><br/>
                    <span><b>POLÍCIA MILITAR</b></span>
                </div>
                <br/>
                <div style="border:1px solid black; text-align: center;">
                    <b>RECURSO AO QUADRO DE ACESSO REFERENTE AS PROMOÇÕES DE PARA: {{date('d/m/Y', strtotime($quadro->dt_promocao))}}</b>
                </div>
                <br/>
                <div style="border:1px solid black; border-left:1px solid black; background:#a0a0a0;">
                    <b class="espacamento">IDENTIFICAÇÃO DO REQUERENTE</b>
                </div>
                <div class="panel-body">
                    <div class="scheduler-border"  style="border-right:1px solid black; border-left:1px solid black;">
                        <div class="form-row" style="width: 100%;">
                        <div class="form-group col-xs-6" >
                                <strong><label class="espacamento">NOME:</label></strong>
                                <span class="form-control">{{$ficha->st_nome}}</span>
                            </div>
                            <div class="form-group col-xs-2" style="border-top:1px solid black;">
                                <strong><label class="espacamento">OPM:</label></strong>
                                <span class="form-control">{{$ficha->st_opm}}</span>
                            </div>
                            <div style="">
                                <div class="form-group col-xs-2" style="border-top:1px solid black; border-right:1px solid black; float: left; width: 33%;">
                                    <strong><label style="padding: 3%;">GRADUAÇÃO:</label></strong>
                                    <span class="form-control">{{$ficha->st_graduacao}}</span>
                                </div>
                                <div class="form-group col-xs-2" style="border-top:1px solid black; border-right:1px solid black; float: left; width: 33%;">
                                    <strong><label style="padding: 3%;">QPMP:</label></strong>
                                    <span class="form-control">{{$ficha->st_qpmp}}</span>
                                </div>
                                <div class="form-group col-xs-2" style="border-top:1px solid black; float: left; width: 33.8%;">
                                    <strong><label style="padding: 3%;">Nº PRAÇA:</label></strong>
                                    <span class="form-control">{{$ficha->st_numpraca}}</span>
                                </div>
                                <div style='clear: left;'></div>
                            </div>
                            <div>
                                <div class="form-group col-xs-2" style="border-top:1px solid black; border-right:1px solid black; float: left; width: 50%;">
                                    <strong><label style="padding: 2%;">MATRÍCULA:</label></strong>
                                    <span class="form-control">{{$ficha->st_matricula}}</span>
                                </div>
                                <div class="form-group col-xs-2" style="border-top:1px solid black; float: left; width: 50%;">
                                    <strong><label style="padding: 2%;">DATA DE NASCIMENTO:</label></strong>
                                    <span class="form-control">{{date('d/m/Y', strtotime($ficha->dt_nascimento))}}</span>
                                </div>
                                <div style="clear: left;" ></div>
                            </div>
                        </div>
                    </div>
                    <div style="border:1px solid black; border-left:1px solid black; background:#a0a0a0;">
                        <b class="espacamento">REQUERIMENTO</b>
                    </div>
                    <div style="border-right:1px solid black; border-left:1px solid black;">
                        <span><strong class="espacamento">Nº DO PROTOCOLO:</strong>{{empty($fichaPolicial->st_protocolorecurso)?'':$fichaPolicial->st_protocolorecurso}}</span>
                    </div>
                    <div class="justificativa espacamento" style="border:1px solid black; border-left:1px solid black;">
                        <span>
                            <strong>
                                JUSTIFICATIVA:
                            </strong>
                        </span>
                        <br>
                        <span>
                            {{empty($fichaPolicial->st_recurso)?'':strip_tags($fichaPolicial->st_recurso)}}
                        </span>
                    </div>
                    <div style="border-right:1px solid black; border-left:1px solid black; background:#a0a0a0;">
                        <b class="espacamento">RESULTADO DO REQUERIMENTO</b>
                    </div>
                    @if($fichaPolicial->bo_recursoanalisado == 1)
                        <div style="border-top:1px solid black; border-right:1px solid black; border-left:1px solid black;">
                            <span><strong class="espacamento">PARECER:</strong> {{empty($fichaPolicial->st_parecerrecurso)?'':$fichaPolicial->st_parecerrecurso}}</span>
                        </div>
                        <div class="justificativa espacamento" style="border:1px solid black; border-left:1px solid black;">
                            <span>
                                <strong>
                                    DESPACHO:
                                </strong>
                            </span>
                            <br>
                            <span>
                                {{strip_tags($fichaPolicial->st_respostarecurso)}}
                            </span>
                        </div>
                    @else
                        <div style="border-top:1px solid black; border-right:1px solid black; border-left:1px solid black;">
                            <span><strong class="espacamento">PARECER:</strong> AGUARDANDO</span>
                        </div>
                        <div class="justificativa espacamento" style="border:1px solid black; border-left:1px solid black;">
                            <span>
                                <strong>
                                    DESPACHO:
                                </strong>
                            </span>
                            <br>
                            <span>
                                
                            </span>
                        </div>
                    @endif
                    <br><br><br><br>
                    <div style="text-align: center;">
                        <span style="border-top:1px solid black; padding: 10%;">Assinantura e data</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rodape">
        <p>SISGP - Recurso {{empty($fichaPolicial->st_protocolorecurso)?'':$fichaPolicial->st_protocolorecurso}} - Impresso por {{Auth::user()->name . " - " . date('d/m/Y - H:m:s')}} </p>
    </div>
</body>
</html>