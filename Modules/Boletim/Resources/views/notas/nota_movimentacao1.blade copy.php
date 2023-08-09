
@component('boletim::notas.components.fieldsetbox')
    @slot('titulo')
        {{$titulo}} titulo fixo box
    @endslot
  
dasfsdafasdfds
@endcomponent   

                        

<fieldset class="scheduler-border">
    <legend class="scheduler-border">INFORMAÇÕES DOS POLICIAIS DA NOTA</legend>

    <div class="row">

    @if($nota->st_status == 'RASCUNHO')
            <div class="form-row form-inline">
                <div class="form-group col-xs-3 col-md-3 col-sm-3" style="margin-left:auto; padding-top:10px;">
                    <label style="padding: 2%;"><strong>Policial</strong></label>
                    <input type="text" class="form-control" id="st_policial" placeholder="Matrícula ou CPF" value="1666886">
                   
                    <button type="button" onclick="consultarbuscaPolicialParaNotaMovimentacao()" id="btnLocalizarPolicial"
                     class="btn btn-primary glyphicon glyphicon-search"
                    data-toggle="modal" data-target="#modalconfirmarPm"
                     title= "Localizar Policial"></button>                    
                </div>
                <div id="resultado"></div>
            </div>
          @endif     
            </div>
            <div class="table-responsive">
                <table class="table striped" id="policiais">
                <thead>
                    <tr>
                        <th>Ordem</th>
                        <th>Post/Grad</th>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>A contar</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($policiaisDaNota) && !empty($policiaisDaNota))
                   
                        @php $ordem = 0;@endphp
                        @foreach($policiaisDaNota as $policial)
                            @php $ordem++ @endphp
                            <tr>
                                <td>{{$ordem}}</td>
                                <td>{{$policial->st_postograduacaosigla}}</td>
                                <td>{{$policial->st_matricula}}</td>
                                <td>{{$policial->st_nome}}</td>
                                <td>{{$policial->st_siglaopmorigem}}</td>
                                <td>{{$policial->st_siglaopmdestino}}</td>
                                <td>{{$policial->dt_acontar}}</td>
                                <td>
                               <!--  <button type="button" data-toggle="modal" data-target="#modalRemoverPmNotaMovimentacao" 
                                title='Remover Policial' class="btn btn-danger fo fa fa-remove"></button> -->
                                @if($nota->st_status == 'RASCUNHO')
                                    <button type="button"  attridpolicial="{{$policial->ce_policial}}" attridnota="{{$nota->id}}" attrtidtiponota="{{$tipoNota->id}}"
                                    title='Remover Policial' class="btn btn-danger fo fa fa-remove testeModal"></button>
                                @endif

                                </td>
                                
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>


</fieldset>


  <!-- Modal para adicionar policial a nota de boletim -->
  <div class="modal fade" id="modalPolicial" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmação de Policial</h4>
        </div>
        <div class="modal-body">
            <div id="nome"></div>
            <div id="matricula"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <button type="button" onclick="addPolicialParaNota()" class="btn btn-primary" data-dismiss="modal">Adicionar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal para adicionar policial a nota de boletim -->
  


  <!-- Modal para remover policial da nota de boletim-->
  <div class="modal fade" id="modalRemoverPolicialParaQualquerNota" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmação de Remover Policial</h4>
        </div>
        <div class="modal-body">
            <div id="nome">Deseja Realmente Remover o Policial desta nota?</div>
            <div id="nome"></div>
            <div id="matricula"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <a id="urlRemoverPolicialNota"  class="btn btn-primary" >Remover</a>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal para remover policial da nota de boletim-->


   <!-- Modal para remover policial da nota de boletim-->
   <div class="modal fade" id="modalRemoverPmNotaMovimentacao" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmação de Remover Policial fixa 11111</h4>
        </div>
        <div class="modal-body">
            <div id="nome">Deseja Realmente Remover o Policial desta nota? 11111</div>
            <div id="nome"></div>
            <div id="matricula"></div>
            <input type="text" id="idpolicial">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-warning" id="btnShowModalConfirmaRemoverPolicialNotaMovimentacao" data-dismiss="modal">Remover1</button>
          <a id="btnConfirmaRemoverPolicialNotaMovimentacao1"  class="btn btn-primary" >Remover</a>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal para remover policial da nota de boletim-->
  @component('boletim::notas.components.modal_confirma_exclusao')
    @slot('idModal')
        #modalRemoverPmNotaMovimentacao1
    @endslot
    @slot('tituloModal')
        CONFIRMAÇÃO DE EXCLUSÃO
    @endslot
    @slot('msgModal')
        Confirma exclusão de Policial da Nota de Movimentação chamooooooouuuu ?
    @endslot

@endcomponent  

      <!-- Modal -->
      <div class="modal fade" id="modalconfirmarPm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="exampleModalLabel">Adicionar policial à Nota de Movimentação</h4>
                            </div>
                            <div class="modal-body">
                                
                                <table class="table table-bordered" id="tblConfirmaPolicial">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>Post/Grad</th>
                                            <th>Praça</th>
                                            <th>Matrícula</th>
                                            <th>Nome</th>
                                        </tr>
                                    </thead>
                                    <tbody name="idPolicial" id="policialencontrado_tbody">
                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- campos complementar para a nota de movimentação -->
                            <input type="hidden"  id="ce_tiponota" value="17" /> 
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="ce_tipo" class="col-md-3 control-label">Unidade de destino</label>
                                <div class="col-md-3">
                                
                                    <select id="ce_unidadedestino"  required name="ce_unidadedestino" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($unidades as $opm)
                                            <option value="{{ $opm->id}}">{{$opm->hierarquia}}</option>                                        
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ce_unidadedestino'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ce_unidadedestino') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dt_acontar" class="col-md-3 control-label">Data a contar</label>
                                <div class="col-md-3">                                   
                                    <input type="date" class="form-control" id="dt_acontar" name="dt_acontar" 
                                        required="" class="form-control" 
                                        name="dt_acontar" /> 
                                    @if ($errors->has('dt_acontar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dt_acontar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- -->
                            <br/>
                            <div class="modal-footer">
                                <button type="button" id="addpmnotamovimentacao" class="btn btn-primary">Adicionar</button>
                                <button type="button" id="canceladd" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                    </div>
        <!-- end Modal -->
<!-- javascript -->
@section('scripts')
    <script src="{{ asset('js/notas.js')}}"></script>
    <script>
    
              
function consultarbuscaPolicialParaNotaMovimentacao() {
 
 var idNota = $("#ce_tipo option:selected").val();
 
 //$('#policialencontrado_tbody').empty();
 var getUrl = window.location;
 var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
 baseUrl += "/";
 
 var user = $('#st_policial').val();
 // var arrayDados = {pm: user, ce_nota: idNota, st_tipo:idNota};
 $.ajax({
     //Enviando via ajax
     url : baseUrl+"boletim/consultarpolicial/"+user,
     method: 'get',
     //Verificando se cadastrou
 }).done(function(data){
    // alert(data);
     if(data != 1){
         $('.addPolicial').attr('id', data.id);
         $('#idPolicial').val(data.id);
         $('#policialencontrado_tbody').remove();

         $('#tblConfirmaPolicial').append( "<tbody name='idPolicial' id='policialencontrado_tbody'></tbody>");
         $('#policialencontrado_tbody').append(
           "<tr id="+data.id+">"+
             "<td>"+data.st_postograduacaosigla+"</td>"+
             "<td>"+data.st_numpraca+"</td>"+
             "<td>"+data.st_matricula+"</td>"+
             "<td>"+data.st_nome+"</td>"+
             "</tr>");

             $('#rascunho').append('<input type="hidden" id="rascunho_st_materia" name="rascunho_st_materia" value="">'+'<input type="hidden" id="rascunho_st_assunto" name="rascunho_st_assunto" value="">'+'<input type="hidden" name="ce_nota" value='+idNota+'>');    
             $('#rascunho_st_assunto').val($('#st_assunto').val());
             $('#rascunho_st_materia').val($('#st_materia').val());
             //$('#consultaPolicial').val('');
     }else{
         alert('Erro! Policial Não encontrado.');
         $("[data-dismiss=modal]").trigger({ type: "click" });
     }

 }).fail(function(data) {
    alert( "error"+data );
  });
 
}
    </script>
      <script>
        $(document).ready(function(){
         
            idNota = $('#idNota').val();
            tipoNota = $('#ce_tipo').val();
            idPolicial = 0;
            if(idNota == null || idNota == undefined || idNota == ""){
                idNota =0;
            }
            policial = null;
            @if(isset($nota))
                $("#form_create_nota").attr('action', "{{ url('boletim/nota/update/'.$nota->id) }}");
                /* Desabilitando os inputs caso seja o status seja RASCUNHO */
                var input = document.getElementsByTagName('input');
                /* Desabilitando o select e o textarea*/
                @if ($nota->st_status != 'RASCUNHO')
                    $("#ce_tipo").attr('disabled', true);                  

                    $("textarea").attr('disabled', true);
                    $("#st_obs").attr('disabled', false);
                @else
                    @if(isset($policiaisDaNota) && count($policiaisDaNota) > 0)
                    $("#ce_tipo").attr('disabled', true);                   
                    @else
                    $("#ce_tipo").attr('disabled', false);                   

                    @endif        
                    $("textarea").attr('disabled', false);
                @endif
                /* Percorre todos os inputs para desabilitalos */
                for( var i=0; i<=(input.length-1); i++ ){
                    @if ($nota->st_status != 'RASCUNHO')
                        input[i].disabled = true;
                    @else
                        input[i].disabled = false;
                    @endif
                }
                $("input[name=_token]").attr('disabled', false);
               
            @endif
        });
        </script>
@stop