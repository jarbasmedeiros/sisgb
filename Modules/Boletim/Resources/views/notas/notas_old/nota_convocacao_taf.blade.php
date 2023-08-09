@extends('adminlte::page')
@section('title', 'SISGP - Convocar Para TAF')
@section('content')
<form method="POST" role="form" action="{{url('promocao/convocarparataf/convocacao/'.$idQuadro.'/'.$atividade->id)}}">
    {{csrf_field()}}
    <div class="panel panel-primary">
        <div class="panel-heading"><b>Convocar Para TAF</b></div>
        <div class="panel-body">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Convocação Para TAF</legend>
                <div class="row">
                    <div class="form-group">
                        <textarea type="textarea" class="form-control" rows="10" id="st_portaria" name="st_portaria" placeholder="Digite a convocação para TAF..." required>{{$atividade->st_portaria}}</textarea>
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <a href='{{ url("boletim/notas")}}' class="col-md-1 btn btn-warning" style="margin-right: 5px">
                    <span class="fa fa-reply"></span> Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Salvar
                </button>
                @if(isset($atividade->st_portaria))
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-file-pdf-o"></i> Gerar Nota
                    </button>
                @endif
            </div>
        </div>
    </div>
</form>
@stop