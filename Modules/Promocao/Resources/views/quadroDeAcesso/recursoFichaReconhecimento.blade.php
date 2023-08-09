@extends('adminlte::page')
@section('title', 'Ficha de Reconhecimento')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div>
                    <label>Ficha de Reconhecimento dos sargentos da PM / RN</label>
                </div>
            </div>
            <div class="panel-body">
                <form id="form" class="form-contact" role="form" method="POST" action="{{url('promocao/escrituradaFicha/recurso/'.$idQuadro.'/atividade/'.$idAtividade.'/policial/'.$idPolicial.'/competencia/'.$competencia)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Dados do policial</legend>
                        <br />
                        <div class="form-row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-2">Graduação</th>
                                        <th class="col-xs-2">QPMP</th>
                                        <th class="col-xs-2">Matrícula</th>
                                        <th class="col-xs-2">Nº Praça </th>
                                        <th class="col-xs-2">Data de Nascimento </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th><span class="form-control">{{$ficha->st_graduacao}}</span></th>
                                    <th><span class="form-control">{{$ficha->st_qpmp}}</span></th>
                                    <th><span class="form-control">{{$ficha->st_matricula}}</span></th>
                                    <th><span class="form-control">{{$ficha->st_numpraca}}</span></th>
                                    <th><span class="form-control">{{date('d/m/Y', strtotime($ficha->dt_nascimento))}}</span></th>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-6">Nome</th>
                                        <th class="col-xs-4">OPM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><span class="form-control">{{$ficha->st_nome}}</span></th>
                                        <th><span class="form-control">{{$ficha->st_opm}}</span></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Recurso</legend>
                        <div id="recurso" class="form-group">
                            <textarea class="form-control ckeditor" rows="3" id="st_recurso" name="st_recurso" maxChar="5" maxWord="5" placeholder="Digite os recursos..." required>{{$fichaPolicial->st_recurso}}</textarea>
                        </div>
                    </fieldset>
                    <a href="{{url('promocao/fichasgtenviada/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)}}" title="Voltar" class="btn btn-warning">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>
                    <button type="button" title="Enviar" class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmarRecurso">
                        <span class="fa fa-send"></span> Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal para concluir envio do recurso-->
<div class="modal fade" id="modalConfirmarRecurso" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmar o envio do recurso</h4>
            </div>
            <div class="modal-body bg-danger">
                <h4 class="modal-title">Atenção!</h4>
                <div classe>
                    Ao confirmar esta ação, não será possível alterá-lo.
                    <br><br>
                    Deseja continuar?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" title="Não" class="btn btn-warning" data-dismiss="modal">Não</button>
                <button type="button" title="Sim" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirRecurso" data-dismiss="modal">
                    Sim
                </button>
            </div>
        </div>
    </div>
</div>
<!--Modal para confirmação do envio do recurso-->
<div class="modal fade" id="modalConcluirRecurso" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assinar o envio do recurso</h4>
            </div>
            <div class="modal-body bg-danger">
                <h4 class="modal-title">Atenção!</h4>
                <div classe>
                    É necessario assinar eletronicamente o envio do recurso.
                </div>
            </div>
            <div class="modal-body">
                <form role="form" id="concluirRecurso" method="POST">
                    {{csrf_field()}}
                    <h4>Informe a Senha:</h4>
                    <input id="password" type="password" class="form-control" name="password" value="" placeholder="Digite sua senha..." required>
                    <br>
                    <div class="modal-footer">
                        <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                        <button type="button" title="Enviar Recurso" class="btn btn-primary" onclick="enviarRecurso()">Assinar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
    <script>
        // Função para concluir homologação da ficha
        function enviarRecurso(){
            var pass = $("#password").val();
            var text = '<input id="password" type="hidden" class="form-control" name="password" value="'+pass+'" placeholder="Digite sua senha..." required>'
            // alerta o valor do campo
            $(text).insertBefore("#recurso");
            $("#form").submit();
        };
        // Exibir a quantidade de caracteres na tela
        var editor = CKEDITOR.replace( 'st_recurso' );
        // The "change" event is fired whenever a change is made in the editor.
        editor.on( 'change', function( evt ) {
            // getData() returns CKEditor's HTML content.
            var conteudo = jQuery(evt.editor.getData()).text();
            $('#caracteres').remove();
            $('#recurso').css('border', '');
            if(conteudo.length == 1){
                $('#recurso').append(
                    '<div id="caracteres"><strong>'+conteudo.length+' Caractere.</strong></div>');
            }else if(conteudo.length <= 500){
                $('#recurso').append(
                    '<div id="caracteres"><strong>'+conteudo.length+' caracteres.</strong></div>');
            }else{
                $('#recurso').append(
                    '<div id="caracteres"><strong>'+conteudo.length+' caracteres. Atenção! O recurso não pode exceder o tamanho de 500 caracteres.</strong></div>');
                $('#recurso').css('border', 'solid 1px red');
            }
        });
    </script>
@stop