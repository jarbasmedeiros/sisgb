@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Punições')
@section('tabcontent')
<div class="tab-pane active" id="Punicao">
    <h4 class="tab-title">Punição - {{ strtoupper($policial->st_nome) }}</h4>
    <hr class="separador">
       

        <form class="form"  method="post" action='{{url("rh/policiais/".$policial->id."/punicao/cadastra")}}'> 
        {{csrf_field()}}
            <fieldset class="scheduler-border">    	
                <legend class="scheduler-border">Dados da Punição</legend>
                <div class="row">
                    <div class="form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }} col-md-4">
                        <label for="st_tipo">TIPO DA PUNIÇÃO</label>
                        <input id="st_tipo" type="text" class="form-control" placeholder="Ex: Prisão, detenção..." name="st_tipo" required> 
                        @if ($errors->has('st_tipo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_tipo') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dt_punicao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_punicao" class="control-label">DATA DE PUNIÇÃO</label>
                        <input id="dt_punicao" type="date" class="form-control" name="dt_punicao" required> 
                        @if ($errors->has('dt_punicao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_punicao') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('st_boletim') ? ' has-error' : '' }} col-md-3">
                        <label for="st_boletim">PUBLICAÇÃO</label>
                        <input id="st_boletim" type="text" class="form-control" placeholder="EX: BG 000/0000" name="st_boletim" required> 
                        @if ($errors->has('st_boletim'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_boletim') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dt_boletim') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_boletim" class="control-label">DATA DE PUBLICAÇÃO</label>
                        <input id="dt_boletim" type="date" class="form-control" name="dt_boletim" required> 
                        @if ($errors->has('dt_boletim'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_boletim') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('nu_dias') ? ' has-error' : '' }} col-md-3">
                        <label for="nu_dias">QTD DIAS</label>
                        <input id="nu_dias" type="number" class="form-control" placeholder="NÚMERO" name="nu_dias" required> 
                        @if ($errors->has('nu_dias'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nu_dias') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('st_gravidade') ? ' has-error' : '' }} col-md-3">
                        <label for="st_gravidade">GRAVIDADE</label>
                        <input id="st_gravidade" type="text" class="form-control" placeholder="EX: Grave, leve..." name="st_gravidade" required> 
                        @if ($errors->has('st_gravidade'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_gravidade') }}</strong>
                        </span>
                        @endif
                    </div>
                    

                    <div class="form-group{{ $errors->has('st_comportamento') ? ' has-error' : '' }} col-md-2">
                        <label for="st_comportamento" class="control-label">COMPORTAMENTO</label>
                        <select id="st_comportamento" name="st_comportamento" class="form-control"  required>
                            <option value="" >Selecione</option>                        
                            <option value="EXCEPCIONAL" >EXCEPCIONAL</option>                        
                            <option value="ÓTIMO">ÓTIMO</option>
                            <option value="BOM">BOM</option>
                            <option value="MAU">MAU</option>
                            <option value="INSUFICIENTE">INSUFICIENTE</option>
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
                        <label for="st_materia" class="control-label">DESCRIÇÃO</label>
                        <textarea id="st_materia" type="text" class="ckeditor form-control"   name="st_materia" rows="5" required></textarea>
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