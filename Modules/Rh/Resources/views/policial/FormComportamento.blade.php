@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Comportamento')
@section('tabcontent')
<div class="tab-pane active" id="cursos">
    <h4 class="tab-title">Cadastro de comportamento</h4>
    <hr class="separador">
</div>
<div class="modal-content">
  
            <div class="modal-body">

                <form class="form"  method="post" action='{{url("rh/policiais/" . $policial->id ."/comportamentos/cadastrar")}}'>
                {{csrf_field()}}
                <fieldset class="scheduler-border">    	
                    <legend class="scheduler-border">Dados do comportamento</legend>
           
                    <div class="form-group  {{ $errors->has('st_comportamento') ? ' has-error' : '' }} col-md-2 ">
                            <label>Comportamento</label>
                            <select name="st_comportamento" id="st_comportamento" class="form-control"  required>
                            <option value="">Selecione</option>
                            <option >INSUFICIENTE</option>
                            <option >MAU</option>
                            <option >BOM </option>
                            <option >ÓTIMO</option>
                            <option >EXCEPCIONAL</option>
                            
                            </select>
                        
                            @if ($errors->has('st_comportamento'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_comportamento') }}</strong>
                                </span>
                             @endif
                    </div>

                      <div class="form-group  {{ $errors->has('st_boletim') ? ' has-error' : '' }} col-md-2">
                            <label>Data de boletim</label>
                            <input id="dt_boletim" type="date"  class="form-control" name="dt_boletim" required >
                            @if ($errors->has('dt_boletim'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_boletim') }}</strong>
                                </span>
                             @endif
                        </div>
                   
                        <div class="form-group {{ $errors->has('st_boletim') ? ' has-error' : '' }} col-md-2">
                        <label>Boletim</label>
                        <input id="st_boletim"  type="text" class="form-control" name="st_boletim"  required> 
                             @if ($errors->has('st_boletim'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_boletim') }}</strong>
                                </span>
                             @endif
                        </div>
                        
                        <div class="form-group {{ $errors->has('st_motivo') ? ' has-error' : '' }} col-md-6">
                        <label>Motivo</label>
                        <input id="st_motivo"  type="text" class="form-control" name="st_motivo" required> 
                        @if ($errors->has('st_motivo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_motivo') }}</strong>
                                </span>
                             @endif
                        </div>


                        <div class="form-group col-md-12">
                        <label>Observação</label>
                        <input id="st_obs"  type="text" class="form-control" name="st_obs" > 
                      
                        </div>
                </fieldset>
            </div>
            <div class="modal-footer">
            <div class="form-group">                
                <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/comportamento')}}" style='margin-right: 10px;'>
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
                            <button type="submit" class="btn btn-primary salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>

@endsection