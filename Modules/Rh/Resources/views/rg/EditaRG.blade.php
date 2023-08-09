@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Identidades')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 193, implementar aba de promoções. -->
<div class="tab-pane active" id="dados_promocao">
    <h4 class="tab-title">Emissão de Identidade - {{ $policial->st_nome }}</h4>
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
        <div class="row">
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
                    <input id="st_postograduacao" type="text" class="form-control" name="st_postograduacao" readonly value="{{$policial->st_postograduacao}}"> 
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
        </div>
          
        </fieldset>
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Documentos</legend>
        <div class="row">
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
            </div>
            <div class="row">
 
                <div class="form-group{{ $errors->has('st_registrocivil') ? ' has-error' : '' }} col-md-8">
                    <label for="st_cpf">Documento de origem</label>
                    <input id="st_registrocivil" type="text" class="form-control" name="st_registrocivil" readonly value="{{$policial->st_registrocivil}}" />  
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_registrocivil') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
        </fieldset>
        
     {{ csrf_field() }}    
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Dados da Identidade</legend>
        <div class="row">
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
            <form role="form" method="POST" action="{{ url('rh/policiais/'.$policial->id.'/rg/'.$rg->id.'/cedula') }}">
                        <input id="id_cedula" type="hidden"   name="id_cedula"  value="{{$rg->id}}"> 
            <div class="form-group{{ $errors->has('st_cedula') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cedula">Nº da cédula</label>
                    {{ csrf_field() }}   
                    @can('IDENTIFICAR_PM')
                        <input id="st_cedula" type="text"  class="form-control" name="st_cedula" required value="{{$rg->st_cedula}}"> 
                    @else 
                        <input id="st_cedula" type="text"  class="form-control" name="st_cedula" required value="{{$rg->st_cedula}}" readonly> 
                    @endcan

                    @if ($errors->has('st_cedula'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cedula') }}</strong>
                    </span>
                    @endif
            </div>

            <div class="form-group{{ $errors->has('st_motivo') ? ' has-error' : '' }} col-md-3">
                    <label for="st_motivo" class="control-label">Motivo impressão</label>
                    @can('IDENTIFICAR_PM')
                    <select id="st_motivo" name="st_motivo" class="form-control" required>
                        <option value="" >--Selecione--</option>
                        <option value="PROMOCAO" {{($rg->st_motivo =='PROMOCAO')?'selected':''}} >Promoção</option>
                        <option value="EXTRAVIO" {{($rg->st_motivo =='EXTRAVIO')?'selected':''}}>Extravio</option>  
                        <option value="ERRO" {{($rg->st_motivo =='ERRO')?'selected':''}}>Erro impressão</option>  
                        <option value="RETIFICACAO" {{($rg->st_motivo =='RETIFICACAO')?'selected':''}}>Retificação</option>  
                        <option value="REFORMAIDADE" {{($rg->st_motivo =='REFORMAIDADE')?'selected':''}}>Reformado por idade</option>  
                        <option value="REFORMAINVALIDEZ" {{($rg->st_motivo =='REFORMAINVALIDEZ')?'selected':''}}>Reformado por invalidez</option>  
                        <option value="R1" {{($rg->st_motivo =='R1')?'selected':''}}>R1 - Reserva remunerada</option>  
                        <option value="R2" {{($rg->st_motivo =='R2')?'selected':''}}>R2 - Reserva Não remunerada</option>  
                    </select>
                    @else 
                        <input id="st_motivo" type="text"  class="form-control" name="st_motivo" required value="{{$rg->st_motivo}}" readonly> 
                    @endcan
                    @if ($errors->has('st_motivo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_motivo') }}</strong>
                    </span>
                    @endif
            </div>
            <div class="form-group{{ $errors->has('st_signatario') ? ' has-error' : '' }} col-md-3">
                    <label for="st_signatario" class="control-label">Chefe da Identificação</label>
                    <input id="st_signatario" type="text"  class="form-control" name="st_signatario" readonly required value="{{$rg->st_signatario}}"> 
                    @if ($errors->has('st_signatario'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_signatario') }}</strong>
                    </span>
                    @endif
            </div>

            <div class="row">
                <div style="padding-left:30px" class="form-group{{ $errors->has('st_obs') ? ' has-error' : '' }} col-md-10">
                        <label for="st_obs">Observação</label>
                        {{ csrf_field() }}   
                        @can('IDENTIFICAR_PM')
                            <input id="st_obs" type="text"  class="form-control" name="st_obs" value="{{$rg->st_obs}}"> 
                        @else 
                            <input id="st_obs" type="text"  class="form-control" name="st_obs" value="{{$rg->st_obs}}" readonly> 
                        @endcan

                        @if ($errors->has('st_obs'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_obs') }}</strong>
                        </span>
                        @endif
                </div>
            </div>
            
            @if(isset($rg->st_impressao))
            <div class="form-group{{ $errors->has('st_impressao') ? ' has-error' : '' }} col-md-2">
                    <label for="st_impressao" class="control-label">Resultado impressão</label>
            
                    <input id="st_impressao" type="text"  class="form-control" name="st_impressao" required value="{{$rg->st_impressao}}" readonly> 
                    @if ($errors->has('st_impressao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_impressao') }}</strong>
                    </span>
                    @endif
            </div>
            @endif            

            @can('IDENTIFICAR_PM')
            <div @if(isset($rg->st_impressao)) style="padding-top:25px" @endif class="form-group{{ $errors->has('st_motivo') ? ' has-error' : '' }} col-md-2">
                <label for="st_motivo" class="control-label"> </label>
                 <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>   
            </div>
            @endcan 
        </form>
        </div>   
        </fieldset>
    @if(false))
        <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Imagens</legend>
        <form role="form" method="POST" id="formEnviaImagens"action="{{ url('rh/policiais/'.$policial->id.'/rg/'.$rg->id.'/imagens') }}" enctype="multipart/form-data">
        {{ csrf_field() }}   
           
            <div class="form-group{{ $errors->has('st_fotorg') ? ' has-error' : '' }} col-md-1">
                    <label for="st_fotorg">Foto RG</label>
                @if(isset($rg->st_fotorg) )
                    <img src="{{$rg->st_fotorg}}" alt="RG" width="50" height="50" requered/>  
                    <img id="img" class="img" src="data:image/png;data:image/jpeg;base64,{!! $rg->st_fotorg !!}"  width='100' height='120' style="border:1px solid #999;">
                    @if ($errors->has('st_fotorg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fotorg') }}</strong>
                    </span>
                    @endif
                @endif                
                                     
                        <input type="hidden" id="st_cedula" name="st_cedula" value="{{$rg->st_cedula}}">
                        <input type="file" id="st_fotorg" name="st_fotorg" accept="image/*">
                       
                  
                
            </div>
            @if(false)
            <div class="form-group{{ $errors->has('st_fotorg') ? ' has-error' : '' }} col-md-1">
                    <label for="st_fotorg">Foto</label>
                    <img src="https://memegenerator.net/img/images/15161270.jpg" alt="RG" width="50" height="50"/>  
                    @if ($errors->has('st_fotorg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fotorg') }}</strong>
                    </span>
                    @endif
                                      
                        <input type="file" id="img" name="img" accept="image/*">
                   
            </div>
            <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-1 col-md-offset-2">
                    <label for="st_cpf">Polegar</label>
                    <img src="https://media.istockphoto.com/photos/thumb-fingerprint-picture-id490612827" alt="RG" width="40" height="60"/>  
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                                       
                        <input type="file" id="img" name="img" accept="image/*">
                 
            </div>
    
            @if(isset($rg->st_cpf) && $rg->st_cpf !=="")
                <div class="col-md-offset-4" >
                        <label for="st_cpf">QR-Code</label>
                        
                        <img src="https://www.kaspersky.com/content/en-global/images/repository/isc/2020/9910/a-guide-to-qr-codes-and-how-to-scan-qr-codes-2.png" alt="RG" width="50" height="50"/>      
                        @if ($errors->has('st_cpf'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_cpf') }}</strong>
                        </span>
                        @endif
                    
                </div>
            @endif
           @endif
            
           @if(!isset($rg->dt_entrega1) )     
                <div class="form-group{{ $errors->has('st_motivo') ? ' has-error' : '' }} col-md-2 col-md-offset-6">
                    @if(isset($policial->st_rgmilitar))
                        <label for="st_motivo" class="control-label"> </label>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar Imagens</button>   
                    
                    @else 
                    <div style="color: red;"> <b>ATENÇÃO, MILITAR SEM IDENTIFICAÇÃO</b></div>
                    @endif
                </div> 
            @endif
        </fieldset>
    @endif

     <form role="form" method="POST" action="{{ url('rh/policiais/'.$policial->id.'/rg/'.$rg->id.'/edit') }}">
       
        <div class="form-group">
            <div class="col-md-offset-5">
                <a class="btn btn-warning" href="{{url('rh/policiais/'.$policial->id.'/rg/prontuario')}}"><i class="fa fa-arrow-left"></i> Voltar</a>
                        
                
                @if(!isset($rg->st_impressao) || !isset($rg->bo_impresso))               
                    <a class="btn btn-primary" href="{{url('rh/policiais/'.$policial->id.'/rg/'.$rg->id.'/preview')}}"  target="_blank" ><i class="fa fa-print"></i> Imprimir</a>                
                    <a class="btn btn-primary" onclick="modalConfirmaImpressao({{$policial->id}}, {{$rg->id}})" data-toggle="modal" data-placement="top"><i class="fa fa-check"></i> Confirmar Impressão</a>
                @endif
                 
                @if(!isset($rg->dt_entrega1) && isset($rg->st_impressao))          
                        <button type="button" class="btn btn-primary"onclick="modalEntregarRg({{$policial->id}}, {{$rg->id}})" 
                        data-toggle="modal" data-target="modalDevolverRg"><i class="fa fa-user"></i> Entregar</button>
                @endif
                
                @if(!isset($rg->dt_devolucao1) && isset($rg->dt_entrega1))                         
                    <button type="button" class="btn btn-danger"onclick="modalDevolverRg({{$policial->id}}, {{$rg->id}})" 
                    data-toggle="modal" data-target="modalDevolverRg"><i class="fa fa-trash"></i> Triturar RG</button>
                @endif
            </div>
        </div>
      
    </form>
</div>
<!-- /.tab-pane -->

<!-- Modal confirmar impressao-->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">CONFIRMAR IMPRESSÃO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          
               

            <form class="form-inline" id="modalConfirmaImpressao" method="post" > 
                {{csrf_field()}}

                <div class="form-group col-md-4">
                    <label for="st_impressao" class="control-label">Resultado da impressão</label>
                    <select id="st_impressao" name="st_impressao" class="form-control" required>
                        <option value="" >--Selecione--</option>                        
                        <option value="NORMAL" >Impressão normal</option>
                        <option value="ERRO" >Impressão com erro</option>                        
                    </select>
                </div>

            
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal confirmar impressao-->
<!-- Modal entregar rg-->
<div class="modal fade-lg" id="modalEntregarRg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Confirmar Entrega</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title" id="exampleModalLabel1">
                    <b>Deseja realmente confirmar a entrega desse RG ao Policial ?</b>
                </h4>
            </div>
          
            <form class="form-inline" id="formModalEntregarRg" method="get" > 
            {{csrf_field()}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal entregar rg-->
<!-- Modal devolver rg-->
<div class="modal fade-lg" id="modalDevolverRg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Confirmar Devolução</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title" id="exampleModalLabel1">
                    <b>Deseja realmente confirmar a devolução desse RG ?</b>
                </h4>
            </div>
          
            <form class="form-inline" id="formModalDevolverRg" method="get" > 
            {{csrf_field()}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end Modal devovler rg-->

<!-- Função JS que chama a rota para as ações -->
<script>
    function modalConfirmaImpressao(idPolicial,idRg){
      var url = idPolicial+"/rg/"+idRg+"/print";                      
      $("#modalConfirmaImpressao").attr("action", "{{ url('rh/policiais/')}}/"+url);
      $('#Modal').modal();        
    };

    function modalEntregarRg(idPolicial,idRg){

      var url = idPolicial+"/rg/"+idRg+"/entrega";                      
      //alert(url);
      $("#formModalEntregarRg").attr("action", "{{ url('rh/policiais/')}}/"+url);
      $('#modalEntregarRg').modal();        
    };
    function modalDevolverRg(idPolicial,idRg){

      var url = idPolicial+"/rg/"+idRg+"/devolucao";                      
      //alert(url);
      $("#formModalDevolverRg").attr("action", "{{ url('rh/policiais/')}}/"+url);
      $('#modalDevolverRg').modal();        
    };
</script>
@endsection