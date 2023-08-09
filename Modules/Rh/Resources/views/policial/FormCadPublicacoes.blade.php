@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Publicações')
@section('tabcontent')
<div class="tab-pane active" id="publicacoes">
    <h4 class="tab-title">Publicações - {{ strtoupper($policial->st_nome) }}</h4>
    <hr class="separador">
       

        <form class="form"  method="post" action='{{url("rh/policiais/".$policial->id."/publicacao/cadastra")}}'> 
        {{csrf_field()}}
            <fieldset class="scheduler-border">    	
                <legend class="scheduler-border">Dados da Publicação</legend>
                <div class="row">
                    <div class="form-group{{ $errors->has('st_assunto') ? ' has-error' : '' }} col-md-4">
                        <label for="st_assunto">ASSUNTO</label>
                        <input id="st_assunto" type="text" class="form-control" placeholder="Assunto da Publicação" name="st_assunto"required> 
                        @if ($errors->has('st_assunto'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_assunto') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_boletim') ? ' has-error' : '' }} col-md-3">
                        <label for="st_boletim">PUBLICAÇÃO</label>
                        <input id="st_boletim" type="text" class="form-control" placeholder="Boletim de Publicação" name="st_boletim"required> 
                        @if ($errors->has('st_boletim'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_boletim') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dt_publicacao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_publicacao" class="control-label">DATA DE PUBLICAÇÃO</label>
                        <input id="dt_publicacao" type="date" class="form-control" name="dt_publicacao" required> 
                        @if ($errors->has('dt_publicacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_publicacao') }}</strong>
                        </span>
                        @endif
                    </div>
                    

                    <div class="form-group{{ $errors->has('st_comportamento') ? ' has-error' : '' }} col-md-2">
                        <label for="st_comportamento" class="control-label">COMPORTAMENTO</label>
                        <select id="st_comportamento" name="st_comportamento" class="form-control" required>
                            <option value="" >Selecione</option>                        
                            <option value="EXCEPCIONAL" >EXCEPCIONAL</option>                        
                            <option value="ÓTIMO">ÓTIMO</option>
                            <option value="BOM">BOM</option>
                            <option value="INSUFICIENTE">INSUFICIENTE</option>
                            <option value="MAU">MAU</option>
                        </select>
                        @if ($errors->has('st_comportamento'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_comportamento') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group{{ $errors->has('st_materia') ? ' has-error' : '' }} col-md-12">
                        <label for="st_materia" class="control-label">MATÉRIA</label>
                        <textarea id="st_materia" type="text" class="ckeditor form-control" name="st_materia" rows="5" required></textarea>
                        @if ($errors->has('st_materia'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_materia') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

            </fieldset>    

            <div class="modal-footer">
            <button type="button" class="btn btn-warning">
                <a href="{{url('rh/policiais/'.$policial->id.'/publicacoes/listagem')}}"><font color=white>
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar
                </font></a>                
            </button>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>

        </form>
</div>

@endsection