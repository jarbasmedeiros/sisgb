@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Identidades')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 193, implementar aba de promoções. -->
<div class="tab-pane active" id="dados_promocao">
    <h4 class="tab-title">Emissão de Identidade - {{$policial->st_nome}}</h4>
    <hr class="separador">

  
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Dados pessoais</legend>
            <div class="row">
           
                 <div class="form-group{{ $errors->has('st_tiposanguineo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_tiposanguineo">Tipo Sanguíneo</label>
                    <input id="st_tiposanguineo" type="text" class="form-control" name="st_tiposanguineo"readonly  value="{{$policial->st_tiposanguineo}}"> 
                    @if ($errors->has('st_tiposanguineo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tiposanguineo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_fatorrh') ? ' has-error' : '' }} col-md-2">
                    <label for="st_fatorrh">Fator RH</label>
                    <input id="st_fatorrh" type="text" class="form-control" name="st_fatorrh" readonly value="{{$policial->st_fatorrh}}"> 
                    @if ($errors->has('st_fatorrh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fatorrh') }}</strong>
                    </span>
                    @endif
                </div>
           
               
                <div class="form-group{{ $errors->has('st_st_naturalidadecpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_naturalidade">Naturalidade</label>
                    <input id="st_naturalidade" type="text" class="form-control" name="st_fatorrh" readonly value="{{$policial->st_naturalidade}}"> 
                    @if ($errors->has('st_naturalidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_naturalidade') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_nascimento">Data Nascimento</label>
                    <input id="dt_nascimento" type="text" class="form-control" name="dt_nascimento" readonly value="{{$policial->dt_nascimento}}"> 
                    @if ($errors->has('dt_nascimento'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_nascimento') }}</strong>
                    </span>
                    @endif
                 </div>
                
            </div>
            
            <div class="row">
                <div class="form-group{{ $errors->has('st_mae') ? ' has-error' : '' }} col-md-5">
                    <label for="st_mae">Filiação (Mãe)</label>
                    <input id="st_mae" type="text" class="form-control" name="st_mae" readonly value="{{$policial->st_mae}}" > 
                    @if ($errors->has('st_mae'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_mae') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_pai') ? ' has-error' : '' }} col-md-5">
                    <label for="st_pai">Filiação</label>
                    <input id="st_pai" type="text" class="form-control" name="st_pai"readonly  value="{{$policial->st_pai}}"> 
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
                    <input id="st_matricula" type="text" class="form-control" name="st_matricula" readonly value="{{$policial->st_matricula}}"> 
                    @if ($errors->has('st_matricula'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_matricula') }}</strong>
                    </span>
                    @endif
                </div>
           
            <div class="form-group{{ $errors->has('dt_incorporacao') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_incorporacao">Data Incorporação</label>
                    <input id="dt_incorporacao" type="date" class="form-control" name="dt_incorporacao" readonly value="{{$policial->dt_incorporacao}}"> 
                    @if ($errors->has('dt_incorporacao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_incorporacao') }}</strong>
                    </span>
                    @endif
                </div>
             <div class="form-group{{ $errors->has('st_postograduacao') ? ' has-error' : '' }} col-md-2">
                    <label for="st_postograduacao">Posto/Graduação</label>
                    <input  type="text" class="form-control"  readonly value="{{$policial->st_postograduacao}}"> 
                    @if ($errors->has('st_postograduacao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_postograduacao') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_promocao') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_promocao">Data Promoção</label>
                    <input id="dt_promocao" type="text" class="form-control" name="dt_promocao" readonly value=""    > 
                    @if ($errors->has('dt_promocao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_promocao') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_numpraca') ? ' has-error' : '' }} col-md-2">
                    <label for="st_numpraca">Nº Praça</label>
                    <input id="st_numpraca" type="text" class="form-control" name="st_numpraca" readonly value="{{$policial->st_numpraca}}"> 
                    @if ($errors->has('st_numpraca'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_numpraca') }}</strong>
                    </span>
                    @endif
                </div>
          
        </fieldset>
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Documentos</legend>
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">CPF</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_cpf" readonly value="{{$policial->st_cpf}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_cnh') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cnh">CNH</label>
                    <input id="st_cnh" type="text" class="form-control" name="st_cnh" readonly value="{{$policial->st_cnh}}"> 
                    @if ($errors->has('st_cnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cnh') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_pispasep') ? ' has-error' : '' }} col-md-2">
                    <label for="st_pispasep">PIS/PASEP</label>
                    <input id="st_pispasep" type="text" class="form-control" name="st_pispasep"  readonly value="{{$policial->st_pispasep}}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_pispasep') }}</strong>
                    </span>
                    @endif
                </div>
           
            <div class="form-group{{ $errors->has('st_titulo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_titulo">Título de eleitor</label>
                    <input id="st_titulo" type="text" class="form-control" name="st_titulo" readonly value="{{$policial->st_titulo}}"> 
                    @if ($errors->has('st_titulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_titulo') }}</strong>
                    </span>
                    @endif
                </div>
            <div class="form-group{{ $errors->has('st_registrocivil') ? ' has-error' : '' }} col-md-3">
                    <label for="st_cpf">Documento de origem</label>
                    <input id="st_registrocivil" type="text" class="form-control" name="st_registrocivil" readonly value="{{$policial->st_registrocivil}}" />  
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_registrocivil') }}</strong>
                    </span>
                    @endif
                </div>
           
        </fieldset>
        @if(isset($rg->st_localizador1) && $rg->localizador !=="")
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Imagens</legend>
            <div class="form-group{{ $errors->has('st_fotorg') ? ' has-error' : '' }} col-md-1">
                    <label for="st_fotorg">Foto</label>
                    <img src="https://memegenerator.net/img/images/15161270.jpg" alt="RG" width="50" height="50"/>  
                    @if ($errors->has('st_fotorg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fotorg') }}</strong>
                    </span>
                    @endif
                    <form action="/action_page.php">                       
                        <input type="file" id="img" name="img" accept="image/*">
                        <input type="submit">
                    </form>
                </div>
                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-1">
                    <label for="st_cpf">Polegar</label>
                    <img src="https://media.istockphoto.com/photos/thumb-fingerprint-picture-id490612827" alt="RG" width="40" height="60"/>  
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                    <form action="/action_page.php">                       
                        <input type="file" id="img" name="img" accept="image/*">
                        <input type="submit">
                    </form>
                </div>
    
       
            <div class="col-md-offset-4" >
                    <label for="st_cpf">QR-Code</label>
                    
                    <img src="https://www.kaspersky.com/content/en-global/images/repository/isc/2020/9910/a-guide-to-qr-codes-and-how-to-scan-qr-codes-2.png" alt="RG" width="50" height="50"/>      
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif                   
            </div>           
            </div>
        </fieldset>
        @endif
     <form role="form" method="POST" action="{{ url('rh/policiais/'.$policial->id.'/rg/new') }}">
     {{ csrf_field() }}    
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Dados da Identidade</legend>
            <div class="form-group{{ $errors->has('st_rgmilitar') ? ' has-error' : '' }} col-md-2">
                    <label for="st_rgmilitar">Nº Registro</label>
                    <b>
                    <input id="st_rgmilitar" type="text" class="form-control" style="color: red;" name="st_rgmilitar" required readonly value="{{$policial->st_rgmilitar}}" > 
                    </b>
                    @if ($errors->has('st_rgmilitar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_rgmilitar') }}</strong>
                    </span> 
                    @endif
            </div>
            <div class="form-group{{ $errors->has('st_cedula') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cedula">Nº da cédula</label>
                    <input id="st_cedula" type="text"  class="form-control" name="st_cedula" required> 
                    @if ($errors->has('st_cedula'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cedula') }}</strong>
                    </span>
                    @endif
            </div>

            <div class="form-group{{ $errors->has('st_motivo') ? ' has-error' : '' }} col-md-3">
                    <label for="st_motivo" class="control-label">Motivo impressão</label>
                    <select id="st_motivo" name="st_motivo" class="form-control" required>
                        <option value="" >--Selecione--</option>
                        <option value="PROMOCAO" >Promoção</option>
                        <option value="EXTRAVIO">Extravio</option>  
                        <option value="ERRO">Erro impressão</option>  
                        <option value="RETIFICACAO">Retificação</option>  
                        <option value="REFORMAIDADE">Reformado por idade</option>  
                        <option value="REFORMAINVALIDEZ">Reformado por invalidez</option>  
                        <option value="R1">R1 - Reserva remunerada</option>  
                        <option value="R2">R2 - Reserva Não remunerada</option>  
                    </select>
                    @if ($errors->has('st_motivo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_motivo') }}</strong>
                    </span>
                    @endif
            </div>
            <div class="form-group{{ $errors->has('st_signatario') ? ' has-error' : '' }} col-md-3">
                    <label for="st_signatario" class="control-label">Chefe da Identificação</label>
                    <input id="st_signatario" type="text"  class="form-control" name="st_signatario" required value="{{$configuracao->st_valor}}"> 
                    @if ($errors->has('st_signatario'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_signatario') }}</strong>
                    </span>
                    @endif
            </div>
            <div class="form-group{{ $errors->has('st_motivo') ? ' has-error' : '' }} col-md-2">
            @if(isset($policial->st_rgmilitar))
                <label for="st_motivo" class="control-label"> </label>
                 <button style="margin-top: 25px" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Gerar RG</button>   
               
            @else 
               <div style="color: red;"> <b>ATENÇÃO, MILITAR SEM IDENTIFICAÇÃO</b></div>
            @endif
            </div> 
           
        </fieldset>
       
        <div class="form-group">
            <div class="col-md-offset-5">
                <a class="btn btn-warning" href="{{url('rh/policiais/'.$policial->id.'/rg/prontuario')}}"><i class="fa fa-arrow-left"></i> Voltar</a>
                
            </div>
        </div>
      
    </form>
</div>
<!-- /.tab-pane -->
@endsection