@extends('adminlte::page')
@section('title', 'SISGP - Convocar Para TAF')
@section('content')
<form method="POST" id="convocarParaTaf" role="form" action="{{url('promocao/convocarparataf/convocacao/'.$idQuadro.'/'.$atividade->id.'/competencia/'.$competencia)}}">
    {{csrf_field()}}
    <div class="panel panel-primary">
        <div class="panel-heading"><b>Convocar Para TAF</b></div>
        <div class="panel-body">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Dados da Portaria de Convocação para TAF</legend>
                <div class="row">
                    <div class="form-group">
                        @if($atividade->ce_nota == null)
                            <textarea type="textarea" class="ckeditor form-control" rows="10" id="st_portaria" name="st_portaria" placeholder="Digite a convocação para TAF..." required>{{$atividade->st_portaria}}</textarea>
                        @else
                            {!! $atividade->st_portaria !!}
                        @endif
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

<div class="form-group">
    <a href="{{ url('promocao/quadro/cronograma/'.$idQuadro.'/competencia/'.$competencia)}}" class="btn btn-warning">
        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
    </a>
    @if(empty($atividade->ce_nota))
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-fw fa-save"></i> Salvar
        </button>
    @endif
    @if(!empty($atividade->st_portaria) && empty($atividade->ce_nota))
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gerarNotaModal">Gerar Nota para BG</button>
    @endif
    @if($atividade->ce_nota != null)
        <a href='{{ url("boletim/nota/visualizar/" . $atividade->ce_nota)}}' class="btn btn-primary">
            <span class="fa fa-file-pdf-o"></span> Visualizar Nota
        </a>
    @endif
</div>
</form>
@stop

<!-- Moldal para botão finalizar -->
<div class="modal fade" id="gerarNotaModal" tabindex="-1" role="dialog" aria-labelledby="gerarNotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="gerarNotaModalLabel">Gerar Nota</h5>
                </div>
                <div class="modal-body bg-danger">
                    <div>
                        <strong> DESEJA REALMENTE GERAR A NOTA? </strong>
                        <p> Após gerar a nota, a convocação não poderá mais ser editada. </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#assinarModal">Sim</button>
                        <!-- <a href='{{url("boletim/nota/finalizar/")}}' class="btn btn-primary">Sim</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Moldal Assinar Nota -->
    <div class="modal fade" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-sm">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="assinarModalLabel">Assinar Nota</h5>
            </div>

            <div class="modal-body">
            <form action="{{url('promocao/gerarnota/convocacaotaf/' . $idQuadro . '/' . $atividade->id)}}" method="POST">
                {{csrf_field()}}
                <p><strong> Digite sua senha para assinar eletronicamente </strong></p><br/>
                <div class="form-group">
                    <label for="pass" class="control-label">Senha:</label>
                    <div class="">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Assinar</button>
                </div>
            </div>
                </form>
            </div>
        </div>
    </div>

@section('scripts')
<script>
   
    function geraNotaConvocacaoTaf(idQuadroAcesso, idAtividade ){
        $("#convocarParaTaf").remove("action");
        $("#convocarParaTaf").attr("action", "{{url('promocao/gerarnota/convocacaotaf')}}/"+idQuadroAcesso+'/'+idAtividade);
      
    }
    function salvaPortaria(idQuadroAcesso, idAtividade ){
        $("#convocarParaTaf").remove("action");
        $("#convocarParaTaf").attr("action", "{{url('promocao/convocarparataf/convocacao')}}/"+idQuadroAcesso+'/'+idAtividade);
      
    }
   
</script>
@stop