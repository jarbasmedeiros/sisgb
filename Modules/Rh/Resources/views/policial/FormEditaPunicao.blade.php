@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Punições')
@section('tabcontent')
<div class="tab-pane active" id="Punicao">
    <h4 class="tab-title">Punição - {{ $policial->st_nome}}</h4>
    <hr class="separador">
       

        <form class="form"  method="post" action='{{url("rh/policiais/".$policial->id."/punicao/edita/".$punicao->id)}}'> 
        {{csrf_field()}}
            <fieldset class="scheduler-border">    	
                <legend class="scheduler-border">Dados da Punição</legend>
                <div class="row">
                    <div class="form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }} col-md-4">
                        <label for="st_tipo">TIPO DA PUNIÇÃO</label>
                        <input id="st_tipo" type="text" class="form-control" placeholder="Informe o tipo da punição" name="st_tipo" value="{{$punicao->st_tipo}}"> 
                        @if ($errors->has('st_tipo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_tipo') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dt_punicao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_punicao" class="control-label">DATA DE PUNIÇÃO</label>
                        <input id="dt_punicao" type="date" class="form-control" name="dt_punicao" value="{{$punicao->dt_punicao}}"> 
                        @if ($errors->has('dt_punicao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_punicao') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('st_boletim') ? ' has-error' : '' }} col-md-3">
                        <label for="st_boletim">PUBLICAÇÃO</label>
                        <input id="st_boletim" type="text" class="form-control" placeholder="EX: BG 000/0000" name="st_boletim" value="{{$punicao->st_boletim}}"> 
                        @if ($errors->has('st_boletim'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_boletim') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dt_boletim') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_boletim" class="control-label">DATA DE PUBLICAÇÃO</label>
                       <input id="dt_boletim" type="date" class="form-control" name="dt_boletim" value="{{$punicao->dt_boletim}}"> 
                        @if ($errors->has('dt_boletim'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_boletim') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('nu_dias') ? ' has-error' : '' }} col-md-3">
                        <label for="nu_dias">QTD DIAS</label>
                        <input id="nu_dias" type="number" class="form-control" placeholder="NÚMERO" name="nu_dias"  value="{{$punicao->nu_dias}}"> 
                        @if ($errors->has('nu_dias'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nu_dias') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('st_gravidade') ? ' has-error' : '' }} col-md-3">
                        <label for="st_gravidade">GRAVIDADE</label>
                        <input id="st_gravidade" type="text" class="form-control" placeholder="Gravidade da Punição" name="st_gravidade" value="{{$punicao->st_gravidade}}"> 
                        @if ($errors->has('st_gravidade'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_gravidade') }}</strong>
                        </span>
                        @endif
                    </div>
                    

                    <div class="form-group{{ $errors->has('st_comportamento') ? ' has-error' : '' }} col-md-2">
                        <label for="st_comportamento" class="control-label">COMPORTAMENTO</label>
                        <select id="st_comportamento" name="st_comportamento" class="form-control" >
                            <option value="" >Selecione</option>                        
                        <option {{strtoupper($punicao->st_comportamento) == 'EXCEPCIONAL' ? 'selected' : ''}} value="EXCEPCIONAL">Excepcional</option>                     
                        <option {{strtoupper($punicao->st_comportamento) == 'ÓTIMO' ? 'selected' : ''}} value="ÓTIMO">Ótimo</option>
                        <option {{strtoupper($punicao->st_comportamento) == 'BOM' ? 'selected' : ''}} value="BOM">Bom</option>
                        <option {{strtoupper($punicao->st_comportamento) == 'MAU' ? 'selected' : ''}} value="MAU">Mau</option>
                        <option {{strtoupper($punicao->st_comportamento) == 'INSUFICIENTE' ? 'selected' : ''}} value="INSUFICIENTE">Insuficiente</option>
                        </select>
                        @if ($errors->has('st_comportamento'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_comportamento') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_status') ? ' has-error' : '' }} col-md-2">
                        <label for="st_status" class="control-label">STATUS</label>
                        <select id="st_status" name="st_status" class="form-control" >
                            <option value="" >Selecione</option>                        
                        <option {{strtoupper($punicao->st_status) == 'ATIVA' ? 'selected' : ''}} value="ATIVA">ATIVA</option>                     
                        <option {{strtoupper($punicao->st_status) == 'CANCELADA' ? 'selected' : ''}} value="CANCELADA">CANCELADA</option>                     
                        <option {{strtoupper($punicao->st_status) == 'ANULADA' ? 'selected' : ''}} value="ANULADA">ANULADA</option>                     
                        </select>
                        @if ($errors->has('st_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_status') }}</strong>
                        </span>
                        @endif
                    </div>
                      <div class="form-group{{ $errors->has('st_boletimcancelamentoanulacao') ? ' has-error' : '' }} col-md-3">
                        <label for="st_boletimcancelamentoanulacao">BOLETIM DE CANCELAMENTO</label>
                        <input id="st_boletimcancelamentoanulacao" type="text" class="form-control" placeholder="EX: BG 000/0000" name="st_boletimcancelamentoanulacao" value="{{$punicao->st_boletimcancelamentoanulacao}}"> 
                        @if ($errors->has('st_boletimcancelamentoanulacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_boletimcancelamentoanulacao') }}</strong>
                        </span>
                        @endif
                    </div>
                   
                    <div class="form-group{{ $errors->has('dt_boletimcancelamentoanulacao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_boletimcancelamentoanulacao" class="control-label">DATA DO BOLETIM DE CANCELAMENTO</label>
                        <input id="dt_boletimcancelamentoanulacao" type="date" class="form-control" name="dt_boletimcancelamentoanulacao" value="{{$punicao->dt_boletimcancelamentoanulacao}}"> 
                        @if ($errors->has('dt_boletimcancelamentoanulacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_boletimcancelamentoanulacao') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('dt_cancelamentoanulacao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_cancelamentoanulacao" class="control-label">DATA DO CANCELAMENTO</label>
                        <input id="dt_cancelamentoanulacao" type="date" class="form-control" name="dt_cancelamentoanulacao" value="{{$punicao->dt_cancelamentoanulacao}}"> 
                        @if ($errors->has('dt_cancelamentoanulacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_cancelamentoanulacao') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
              
                <div class="row">
                    <div class="form-group{{ $errors->has('st_materia') ? ' has-error' : '' }} col-md-12">
                        <label for="st_materia" class="control-label">DESCRIÇÃO</label>
                        <textarea id="st_materia" type="text" class="ckeditor form-control" name="st_materia" rows="5">{{$punicao->st_materia}}</textarea>
                        @if ($errors->has('st_materia'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_materia') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

            </fieldset>    

            <div class="modal-footer">
            <a href='{{url("rh/policiais/".$policial->id. "/punicoes")}}' class="btn btn-warning">
            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
             </a>                 
            </button>
                <button type="submit" class="btn btn-primary">SALVAR</button>
            </div>
        </form>
</div>

@endsection