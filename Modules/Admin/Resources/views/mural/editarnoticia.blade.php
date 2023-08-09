@extends('adminlte::page')

@section('title', 'Atualizar Cadastro de Unidades')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Edição de Notícia do Mural</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url('/admin/noticia/editar/'.$noticia->id)}}">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('st_titulo') ? ' has-error' : '' }}">
                        <label for="st_titulo" class="col-md-2 control-label">Título:</label>
                        <div class="col-md-8">
                                <input id="st_titulo" type="text" class="form-control" required="true" placeholder="Sigla" name="st_titulo" value="{{$noticia->st_titulo}}"> 
                                @if ($errors->has('st_titulo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_titulo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('st_msg') ? 'has-error' : '' }}">
                            <label for="st_msg" class="col-md-2 control-label">Mensagem:</label>
                            <div class="col-md-8">
                                <textarea class="ckeditor" id="st_msg" name="st_msg" required="true" name="st_msg">{{$noticia->st_msg}}</textarea> 
                                @if ($errors->has('st_msg'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_msg') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dt_inicio" class="col-md-1 col-md-offset-1 control-label">Data de Início:</label>
                            <div class="col-md-2">
                                <input id="dt_inicio" name="dt_inicio" class="form-control" type="text" data-provide="datepicker" class="form-control date" value="{{\Carbon\Carbon::parse($noticia->dt_inicio)->format('d/m/Y')}}" required/>
                            </div>
                            <label for="dt_termino" class="col-md-1 control-label">Data de Término:</label>
                            <div class="col-md-2">
                                <input id="dt_termino" name="dt_termino" class="form-control" type="text" data-provide="datepicker" class="form-control date" value="{{\Carbon\Carbon::parse($noticia->dt_termino)->format('d/m/Y')}}" required/>
                            </div>
                            <label for="bo_ativo" class="col-md-1 control-label">Ativo:</label>
                            <div class="col-md-2">
                                <select class='form-control' name='bo_ativo' id='bo_ativo' required>
                                <option value="">--  Selecionar  --</option>
                                    <option {{$noticia->bo_ativo == '1' ? 'selected' : ''}} value="1">Sim</option>
                                    <option {{$noticia->bo_ativo == '0' ? 'selected' : ''}} value="0">Não</option>
                                </select>
                                @if ($errors->has('bo_ativo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bo_ativo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-1 col-md-offset-2">
                                <a href="{{url('admin/noticias')}}" class="btn btn-warning"  title="Voltar">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>
                            </div>
                            <button type="submit" class="col-md-1 col-md-offset-6 btn btn-primary">
                                <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $(document).ready(function() {
        $('#dt_inicio').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR"
        });
        $('#dt_termino').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR"
        });
    });
</script>
@endsection