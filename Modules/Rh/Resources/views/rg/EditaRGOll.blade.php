@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Identidades')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 193, implementar aba de promoções. -->
<div class="tab-pane active" id="dados_promocao">
    <h4 class="tab-title">Emissão de Identidade - {{ strtoupper($policial->st_nome) }}</h4>
    <hr class="separador">

  
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Dados pessoais</legend>
            <div class="row">
           
                 <div class="form-group{{ $errors->has('st_tiposanguineo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_tiposanguineo">Tipo Sanguíneo</label>
                    <input id="st_tiposanguineo" type="text" class="form-control" name="st_tiposanguineo" value="{{$policial->st_tiposanguineo}}"> 
                    @if ($errors->has('st_tiposanguineo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tiposanguineo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_fatorrh') ? ' has-error' : '' }} col-md-2">
                    <label for="st_fatorrh">Fator RH</label>
                    <input id="st_fatorrh" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_fatorrh}}"> 
                    @if ($errors->has('st_fatorrh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fatorrh') }}</strong>
                    </span>
                    @endif
                </div>
           
               
                <div class="form-group{{ $errors->has('st_st_naturalidadecpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_naturalidade">Naturalidade</label>
                    <input id="st_naturalidade" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_naturalidade}}"> 
                    @if ($errors->has('st_naturalidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_naturalidade') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_nascimento">Data Nascimento</label>
                    <input id="dt_nascimento" type="text" class="form-control" name="st_fatorrh" value="{{$policial->dt_nascimento}}"> 
                    @if ($errors->has('dt_nascimento'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_nascimento') }}</strong>
                    </span>
                    @endif
                 </div>
                 <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Foto</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="form-group{{ $errors->has('st_mae') ? ' has-error' : '' }} col-md-5">
                    <label for="st_mae">Filiação</label>
                    <input id="st_mae" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_mae}}"> 
                    @if ($errors->has('st_mae'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_mae') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_pai') ? ' has-error' : '' }} col-md-5">
                    <label for="st_pai">Filiação</label>
                    <input id="st_pai" type="text" class="form-control" name="st_pai" value="{{$policial->st_pai}}"> 
                    @if ($errors->has('st_pai'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_pai') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
         
        </fieldset>
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Dados Institucional</legend>
            <div class="form-group{{ $errors->has('st_matricula') ? ' has-error' : '' }} col-md-2">
                    <label for="st_matricula">Matrícula</label>
                    <input id="st_matricula" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_matricula}}"> 
                    @if ($errors->has('st_matricula'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_matricula') }}</strong>
                    </span>
                    @endif
                </div>
           
            <div class="form-group{{ $errors->has('dt_inclusao') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_inclusao">Data Incorporação</label>
                    <input id="dt_inclusao" type="date" class="form-control" name="dt_inclusao" value="{{$policial->dt_inclusao}}"> 
                    @if ($errors->has('st_rgmilitar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_rgmilitar') }}</strong>
                    </span>
                    @endif
                </div>
             <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Posto/Graduação</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Data Promoção</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Nº Praça</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
          
        </fieldset>
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Documentos</legend>
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">CPF</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">PIS/PASEP</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
           
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Título de eleitor</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Documento de origem</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
           
        </fieldset>
     <form role="form" method="post" action="{{ url('rh/policiais/'.$policial->id.'/rg/new') }}">
     {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Dados da Identidade</legend>
            <div class="form-group{{ $errors->has('st_rgmilitar') ? ' has-error' : '' }} col-md-2">
                    <label for="st_rgmilitar">Nº Registro</label>
                    <input id="st_rgmilitar" type="text" class="form-control" name="st_rgmilitar" value="{{$policial->st_rgmilitar}}"> 
                    @if ($errors->has('st_rgmilitar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_rgmilitar') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Nº da cédula</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Polegar</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">QR-Code</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
            </div>
           
               
               
            </div>
        </fieldset>
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Imagens</legend>
            <div class="form-group{{ $errors->has('st_fotorg') ? ' has-error' : '' }} col-md-2">
                    <label for="st_fotorg">Foto</label>
                    <input id="st_fotorg" type="text" class="form-control" name="st_rgmilitar" value="{{$rg->st_fotorg}}"> 
                    @if ($errors->has('st_fotorg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fotorg') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Polegar</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
  
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">QR-Code</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_fatorrh" value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
            </div>
           
               
               
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-offset-5">
                <a class="btn btn-warning" href="{{url('rh/policiais/'.$policial->id.'/rg/prontuario')}}"><i class="fa fa-arrow-left"></i> Voltar</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Gerar RG</button>               
                <a class="btn btn-primary" href="{{url('rh/policiais/'.$policial->id.'/rg/'.$policial->id.'/print')}}"><i class="fa fa-print"></i> Imprimir</a>
                <a class="btn btn-primary" href="{{url('rh/policiais/'.$policial->id.'/rg/'.$policial->id.'/print')}}"><i class="fa fa-check"></i> Confirmar Impressão</a>
                <a class="btn btn-primary" href="{{url('rh/policiais/'.$policial->id.'/rg/'.$policial->id.'/print')}}"><i class="fa fa-print"></i> Entregar</a>
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Devolver</button>
            </div>
        </div>
        <!-- Definindo o metodo de envio -->
        {{ method_field('PUT') }}
    </form>
</div>
<!-- /.tab-pane -->
@endsection