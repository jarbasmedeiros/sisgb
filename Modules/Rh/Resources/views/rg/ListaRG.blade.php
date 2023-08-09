@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Lista RG')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 193, implementar aba de promoções. -->
<div class="tab-pane active" id="dados_medalhas">
    <div class="row">
    <div class="col-md-10">
        <h4 class="tab-title">Identidades - {{ $policial->st_nome }} </h4>
    </div>
    <div class="col-md-2"> 
        @if(isset($policial->st_rgmilitar))
            @can('EMITIR_RG')
                <a class="btn btn-success" method="GET" href="{{url('rh/policiais/'.$policial->id.'/rg/new')}}" title="Cadastrar nova identidade">
                    <i class="fa fa-plus"></i>  Nova Identidade
                </a>
            @endcan
        @else 
            <font color="#FF0000"><b>  MILITAR SEM IDENTIFICAÇÃO</b></font>
        @endif
    </div>
    </div>
    
    <hr class="separador">
       
        <div class="row">
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Dados da Ficha Datiloscópica</legend>
                                                
         <form role="form" method="POST" action="{{ url('rh/policiais/'.$policial->id.'/rg/prontuario') }}">
         {{ csrf_field() }}
            
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="st_rgmilitar">Registro</label>
                  <b>
                         <input id="st_rgmilitar"  style="color: red;" type="text" class="form-control" placeholder="Digite o registro" name="st_rgmilitar" value="{{$policial->st_rgmilitar}}" required=""> 
                   </b>
                </div>
                <div class="form-group col-md-8">
                    <label for="st_registrocivil">Documento de origem</label>                 
                    <input id="st_registrocivil"   type="text" class="form-control" placeholder="Documento de inclusão" name="st_registrocivil" value="{{$policial->st_registrocivil}}" required>                   
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="st_fdd">FD-D</label>    
                  {{-- {{dd(auth()->user()->can('blablabal'))}} --}}
                    <input id="st_fdd" type="text" class="form-control" placeholder="Ex.: V-0000" name="st_fdd" data-mask="A-0000" value="{{$policial->st_fdd}}" required> 
                </div>
                <div class="form-group col-md-2">
                    <label for="st_fde">FD-E</label>
                    <input id="st_fde" type="text" class="form-control" placeholder="Ex.: V-0000" name="st_fde" data-mask="A-0000" value="{{$policial->st_fde}}"   required> 
                </div>
                <div class="form-group col-md-3">
                    <label for="st_ric">RIC</label>
                    <input id="st_ric" type="text" class="form-control" placeholder="Digite o RIC" name="st_ric" value="{{$policial->st_ric}}" > 
                </div>

                <div class="form-group col-md-1">
                    <label for="st_altura">Altura</label>
                    <input id="st_altura" type="text" class="form-control" placeholder="Altura" name="st_altura"  value="{{$policial->st_altura}}" > 
                </div>
                <!--
                <div class="form-group col-md-2">
                    <label for="st_cor">Cor</label>
                    <input id="st_cor" type="text" class="form-control" placeholder="Cor" name="st_cor"  value="{{$policial->st_cor}}" > 
                </div>
                -->
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="st_cutis">Cutis</label>                 
                    <input id="st_cutis"   type="text" class="form-control" placeholder="Cutis" name="st_cutis" value="{{$policial->st_cutis}}" >                   
                </div>
                <div class="form-group col-md-2">
                    <label for="st_cabelo">Cabelos</label>
                    <input id="st_cabelo" type="text" class="form-control" placeholder="Cabelos" name="st_cabelo" value="{{$policial->st_cabelo}}" > 
                </div>
                <div class="form-group col-md-2">
                    <label for="st_barba">Barba</label>
                    <input id="st_barba" type="text" class="form-control" placeholder="Barba" name="st_barba" value="{{$policial->st_barba}}" > 
                </div>
           
                <div class="form-group col-md-2">
                    <label for="st_bigode">Bigode</label>
                    <input id="st_bigode" type="text" class="form-control" placeholder="Bigode" name="st_bigode"  value="{{$policial->st_bigode}}" > 
                </div>
                <div class="form-group col-md-2">
                    <label for="st_olhos">Olhos</label>
                    <input id="st_olhos" type="text" class="form-control" placeholder="Olhos" name="st_olhos" value="{{$policial->st_olhos}}" > 
                </div>
                           
            </div>
            <div class="row">
                       
                <div class="form-group col-md-10">
                  <label>Observações para não assinantes</label>                 
                    <input id="st_naoassinarg" type="text" class="form-control" placeholder="Observações para não assintantes" name="st_naoassinarg" value="{{$policial->st_naoassinarg}}" > 
                </div> 
            </div> 
            <div class="row">
                       
                <div class="form-group col-md-10">
                  <label>Observações da Ficha Datiloscópica</label>
                 
                    <input id="st_obsrg" type="text" class="form-control" placeholder="Observações" name="st_obsrg" value="{{$policial->st_obsrg}}" > 
                </div> 
            </div> 
            <div class="row">
               
                <div class="form-group col-md-1">
                    <label for="btnSalvar"></label>
                    <button type="submit" id="btnSalvar"class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>   
                </div>
                
                @if(false)
                    @can('IDENTIFICAR_PM')
                        <div class="form-group col-md-1">
                        <label for="st_rgmilitar">Ficha</label>
                            <a class="btn btn-primary" method="GET" href="{{url('rh/policiais/'.$policial->id.'/rg/ficha')}}">
                                <i class="fa fa-print"></i>  Imprimir
                            </a>
                        </div>
                    @endcan
                @endif
            </div> 
               

      </form>
        </fieldset>
        @if(isset($policial->st_rgmilitar))
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Identidades Emitidas</legend>
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan = "9">LISTAGEM</th>
                        <th>
                           
                        </th>
                    </tr>
                    <tr>   
                        <th class = "col-md-1">CÉDULA</th>
                        <th class = "col-md-1">VIA</th>
                        <th class = "col-md-1">DATA EMISSÃO</th>
                        <th class = "col-md-1">MOTIVO</th>
                        <th class = "col-md-1">IMPRESSÃO</th>
                        <th class = "col-md-2">DATA ENTREGA</th>
                        <th class = "col-md-2">DATA DEVOLUÇÃO</th>                        
                        <th class = "col-md-1">RG</th>
                        <th class = "col-md-2">OBS</th>
                        <th class = "col-md-1">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($policial->rgs))
                        @forelse($policial->rgs as $rg)
                        <tr>
                            <td ><font color="#FF0000"><b>{{$rg->st_cedula}}</b></font></td>
                            <td>{{$rg->st_via}}</td>
                            <td>{{\Carbon\Carbon::parse($rg->dt_emissao)->format('d/m/Y')}}</td>                            
                            <td>{{$rg->st_motivo}}</td>
                            <td>{{$rg->st_impressao}}</td>
                            <td>{{$rg->dt_entrega1}}</td>                            
                            <td>
                                @if(!empty($rg->dt_emissao))                                
                                {{$rg->dt_devolucao1}}
                                @endif
                             </td>                                                                                                           
                            <td>
                               @if(isset($rg->st_fotorg) && $rg->st_fotorg !=null) 
                                    <a href="{{url('rh/policiais/'.$policial->id.'/rg/'.$rg->id.'/show')}}" title="RG" >                                    
                                        <img src="{{url('.$rg->st_fotorg.')}}" alt="RG" width="30" height="20"/>                                   
                                    </a>
                               @endif
                            </td>
                            <td>{{$rg->st_obs}}</td>
                            <td>
                                <a class="btn btn-primary fa fa-eye" href="{{url('rh/policiais/'.$policial->id.'/rg/'.$rg->id.'/edit')}}" title="Abrir"><i ></i> </a> 
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Nenhuma identidade encontrada</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        @endif
        </fieldset>
        <div class="col-md-offset-0">
            <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/dados_pessoais')}}">
                    <i class="fa fa-arrow-left"></i> Voltar
            </a>
        </div>
</div>

<!-- Modal Excluir-->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Promoção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">
                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR A PROMOÇÃO?</b>
                </h4>
            </div>
            <form class="form-inline" id="modalDesativa" method="get" > 
            {{csrf_field()}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Função JS que chama a rota para excluir medalha -->
<script>
    function modalDesativa(idPolicial, idPromocao){
        var url = idPolicial+'/promocao/'+idPromocao+'/deleta';                      
        $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
        $('#Modal').modal();        
    };
</script>

<!-- /.tab-pane -->
@endsection