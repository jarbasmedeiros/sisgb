@extends('boletim::notas.tipos.arquitetura_tipos_nota_template')
@section('conteudo_especifico_das_notas')


{{csrf_field()}}
<!-- .dados do procedimentos  -->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">DADOS DO PROCEDIMENTO</legend>

        <div class="form-group{{ $errors->has('st_tipoprocedimento') ? ' has-error' : '' }} col-md-3" style="margin-right: 0.2px">
            <label for="st_tipoprocedimento" class="control-label">Tipo de Procedimento</label>
                <select id="st_tipoprocedimento" name="st_tipoprocedimento" class="form-control select2" required="required" >
                    <option value="" >--Selecione--</option>
                    <option value="CD" {{((isset($nota) && ($nota->st_tipoprocedimento == 'CD')) 
                        ) ? 'selected' : ''}}>CD (Conselho de Disciplina) </option>
                    <option value="CJ" {{((isset($nota) && ($nota->st_tipoprocedimento == 'CJ')) 
                        ) ? 'selected' : ''}}>CJ (Conselho de Justificação)</option>
                    <option value="IPM" {{((isset($nota) && ($nota->st_tipoprocedimento == 'IPM')) 
                        ) ? 'selected' : ''}}>IPM (Inquérito Policial Militar)</option>
                    <option value="PAD" {{((isset($nota) && ($nota->st_tipoprocedimento == 'PAD')) 
                        ) ? 'selected' : ''}}>PAD (Processo Administrativo Disciplinar)</option>
                    <option value="PADS" {{((isset($nota) && ($nota->st_tipoprocedimento == 'PADS')) 
                        ) ? 'selected' : ''}}>PADS (Processo Administrativo Disciplinar Sumário)</option>
                    <option value="SINDICANCIA" {{((isset($nota) && ($nota->st_tipoprocedimento == 'SINDICANCIA')) 
                        ) ? 'selected' : ''}}>SINDICÂNCIA</option>
                </select> 
                @if ($errors->has('st_tipoprocedimento'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tipoprocedimento') }}</strong>
                    </span>
                @endif
        </div>
       
        <div class="form-group{{ $errors->has('st_numsei') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px">
            <label for="st_numsei" class="control-label" >N° do SEI</label>
            <input type="text" class="form-control" placeholder="Nº do SEI"  id="st_numsei" name="st_numsei" 
            value="{{(isset($nota)) ? $nota->st_numsei : '' }}" required="required">
            @if ($errors->has('st_numsei'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_numsei') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="form-group{{ $errors->has('st_numprocedimento') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px">
            <label  for="st_numprocedimento" class="control-label">N° da Portaria</label>
            <input type="text" class="form-control" placeholder="Nº da portaria" id="st_numprocedimento" 
            name="st_numprocedimento"
            value="{{(isset($nota)) ? $nota->st_numprocedimento : '' }}" required="required">
            @if ($errors->has('st_numprocedimento'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_numprocedimento') }}</strong>
                </span>
            @endif
        </div>
      
        <div class="form-group{{ $errors->has('st_documentooriginal') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px">
            <label for="st_documentooriginal" class="control-label">Documento Original</label>
            <input type="text" class="form-control" placeholder="Documento original" 
            id="st_documentooriginal"  name="st_documentooriginal"
            value="{{(isset($nota)) ? $nota->st_documentooriginal : '' }}" required="required">
            @if ($errors->has('st_documentooriginal'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_documentooriginal') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_origem') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px">
            <label for="st_origem" class="control-label">Origem do Procedimento</label>
                <select id="st_origem" name="st_origem" class="form-control select2" style="width: 100%;">
                    <option value="" >-- Selecione --</option>
                    <option value="PM" {{((isset($nota) && ($nota->st_origem == 'PM')) 
                        ) ? 'selected' : ''}}>PM(De Ofício)</option>
                    <option value="MP" {{((isset($nota) && ($nota->st_origem == 'MP')) 
                        ) ? 'selected' : ''}}>MP (Requisição)</option>
                    <option value="ORGAO_EXTERNO" {{((isset($nota) && ($nota->st_origem == 'ORGAO_EXTERNO')) 
                        ) ? 'selected' : ''}}>ORGÃOS EXTERNOS (Noticia Fato)</option>
                </select> 
                @if ($errors->has('st_origem'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_origem') }}</strong>
                    </span>
                @endif
        </div>
        <div class="form-group{{ $errors->has('dt_nomeacao') ? ' has-error' : '' }} col-md-2">
            <label  for="dt_nomeacao" class="control-label" >Data Nomeação em BG</label>                
            <input type="date" class="form-control" id="dt_nomeacao" name="dt_nomeacao"
            value="{{(isset($nota)) ? $nota->dt_nomeacao : '' }}" required="required" >
        </div>
        @if ($errors->has('dt_nomeacao'))
            <span class="help-block">
                <strong>{{ $errors->first('dt_nomeacao') }}</strong>
            </span>
        @endif
    </fieldset>

    
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">DESCRIÇÃO DO FATO DO PROCEDIMENTO</legend>
        <div class="form-group{{ $errors->has('st_fato') ? ' has-error' : '' }} col-md-12">
            @if(isset($nota))
                @if($nota->st_status ==  'RASCUNHO')
                    <textarea class="ckeditor"  id="st_fato" name="st_fato" >{{(isset($nota)) ? $nota->st_fato : '' }}</textarea>
                @else
                    <textarea class="ckeditor" disabled id="st_fato" name="st_fato" >{{(isset($nota)) ? $nota->st_fato : '' }}</textarea>
                @endif
            @else
                <h4> Ao salvar a nota o sistema habilitará o campo para incluir a descrição do fato do procedimento</h4>
            @endif
        </div>
    </fieldset>
    <!-- .end dados  do procedimentos  -->
@endsection


@section('fragmento_head_tbl_policias_notas')
    <th>Ord.</th>
    <th>Post/Grad</th>
    <th>Matrícula</th>
    <th>Nome</th>
    <th>Unidade</th>
    <th>Vínculo</th>
    <th >Ações</th>
@endsection

@section('fragmento_body_tbl_policias_notas')    
    @if(isset($policiaisDaNota) )
        @forelse($policiaisDaNota  as $key => $policial)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{$policial->st_postgraduacao}}</td>
                <td><strong>{{$policial->st_matricula}}</strong></td>
                <td id="policial_{{$policial->id}}"><strong>{{$policial->st_nome}}</strong></td>
                <td>{{$policial->st_unidadepolicial}}</td>
                
                <td>@if($policial->st_vinculo=='ENCARREGADO') <strong>{{$policial->st_vinculo}}</strong>@else {{$policial->st_vinculo}} @endif</td>
                <td>                               
                  
                    @if($nota->st_status == 'RASCUNHO')
                        <a class="btn btn-danger btn-sm removerPolicial" data-toggle="modal" onclick="showModalRemoverPmQualquerNota({{$policial->ce_policial}})" title="Remover Policial">
                        <span class="fa fa-trash"></span></a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>  
                <td>Nenhum policial adicionado</td>
            </tr>
        @endforelse
    @endif
@endsection


@section('fragmento_modais_da_nota')   
     
<div class="modal fade" id="modalConsultaPm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    
<div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header bg-primary">
                   <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                   <h4 class="modal-title">Adicionar Policial a Instauração do Procedimento</h4>
               </div>
               <div class="modal-body">
                   <table class="table table-condensed"  id="tblConfirmaPolicial" style=" font-weight: bold; margin-left: auto; margin-right: auto;">
                      <tbody>
                          <tr>
                            <td>Post/Grad</td>
                            <td>Matrícula</td>
                            <td>Nome</td>
                            <td>Unidade</td>
                          </tr>              
                      </tbody>
                      <tbody>
                      <table class="table table-condensed" >
                      <hr class="hr3" style=" border: 0;height: 2px; background-image: linear-gradient(to right, #E7E5EB, #E7E5EB, #E7E5EB);">

                <div class=" col-md-6">
                        <label  for="st_vinculo" class="control-label">Vínculo com o Procedimento:</label>
                            <select class="form-control" id="st_vinculo" name="st_vinculo" >
                                <option value="" >--Selecione--</option>
                                <option value="ENVOLVIDO">ENVOLVIDO</option>
                                <option value="ENCARREGADO">ENCARREGADO</option>
                            </select>
                        </div>
                        </table>
                      </tbody>
                  </table>  
             
              
               <div class="modal-footer">
               <button type="button" id="btnAddPmANota" name="btnAddPmANota" onclick="addPmQualquerNota()" class="btn btn-primary">Adicionar</button>          
               <button type="button" id="canceladd" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>               
           </div>
       </div>
    </div>

@endsection
   <!-- Java script para as notas -->

            
 


<!---end modal add selecionar pm -->



@section('fragmento_scripts_das_notas')
<script>

   /*  $("#st_vinculo").on('change', function() {
        var opcao = this.value ;
        
        if(opcao=='ENCARREGADO'){
            $("#div_restricaoarma").hide();
        }else{
            $("#div_restricaoarma").show();
        }
       
    }); */

function consultarPmQualquerNota(){
   // valida se informado a matrícula ou cpf do policial
    if($('#txtCpfMatriculaPolicial').val()==''){
        alert('Informar o CPF ou Matrícula do Policial');
    }else{
        //exibe o modal de consulta de policial para a nota 17
        $('#modalConsultaPm').modal({
            show: 'true'
        }); 

        //recuperando o tipo de nota selecionada    
        var idNota = $("#ce_tipo option:selected").val();

        //montando a url            
        baseUrl = getBaseUrl()+"/";

        //recuperando a matrícula/cpf do policial
        var user = $('#txtCpfMatriculaPolicial').val();

        //iniciando a requisição para a api rest para consultar o policial
        $.ajax({
                //Enviando via ajax
                url : baseUrl+"boletim/consultarpolicial/"+user,
                method: 'get',
   
            }).done(function(data){
                //console.log(data.length);
                //
                if(data != 1){
                    //popula a tabela com os dados do policial localizado.
                    $('.addPolicial').attr('id', data.id);
                    $('#idPolicial').val(data.id);
                    $('#policialencontrado_tbody').remove();

                    $('#tblConfirmaPolicial').append( "<tbody name='idPolicial' id='policialencontrado_tbody'></tbody>");
                    $('#policialencontrado_tbody').append(
                    "<tr id="+data.id+">"+
                        "<td>"+data.st_postograduacaosigla+"</td>"+
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
            }).fail(function () {
                alert('falha para consultar o policial');
            });
            
    }
} 

function addPmQualquerNota() {
    var baseUrl = getBaseUrl()+"/";
    var st_numsei =  $('#st_numsei').val();
    var st_vinculo =  $('#st_vinculo').val();

    var bo_restricaoarma =  $('#bo_restricaoarma').val();
    //validando os campos obrigatórios

    if(st_numsei==''){
        alert('Informe o número do processo SEI');
    }else{
        if(st_vinculo==''){
            alert('Selecionar um VINCULO do policial com o procedimento');
        }else{
           
              //agrupando os dados para enviar
              dados = {
                        ce_nota: $('#idNota').val(),
                        ce_tipo: $('#ce_tipo').val(),
                        _token: $("input[name=_token]").val(),
                        ce_policial: $('#policialencontrado_tbody tr:first-child').attr("id"),
                        st_vinculo: $('#st_vinculo').val(),
                        st_numsei: st_numsei,
                      
                    };       

                executarAjax(dados);
               
        
        }
    }
}
  
function executarAjax(dados){
        //fazendo a requisição a api rest
        $.ajax({
                    //preparando os dados
                    url : baseUrl+"boletim/tiponota/addpolicialparacadatiponota",//web rota service não api
                    method: 'post',
                    dataType: "json",
                    data: dados,            
                    //Verificando se encontrou 0 policial
                    success: function (data) {
                      //  alert(data);
                        if(data.retorno =='sucesso'){
                        // alert('Policial adicionado a nota com sucesso!');
                            alert(data.msg);
                            $("[data-dismiss=modal]").trigger({ type: "click" });
                            document.location.reload(true);
                        }else{
                        // fecha o modal
                            $("[data-dismiss=modal]").trigger({ type: "click" });
                            alert(data.msg);
                        }                           
                    },
                    error: function (request, status, error) {
                    //  alert( 'erro requisição');
                        alert('Falha para adicionar o policial: '+request.responseText);
                    }
                }); 
}
function showModalRemoverPmQualquerNota(idPolicial){
        //salva valor do id do policial selecionado
        $('#ce_policialselecionadoexclusao').val(idPolicial);
        //show modal
         $('#modalRemoverPmQualquerNota').modal({
            show: 'true'
        });  
}

function removerPmQualquerNota(){

    var idPolicial =  $('#ce_policialselecionadoexclusao').val();
    if( idPolicial==''){
        alert('Selecionar um policial');
    }else{        
        var token = $("input[name=_token]").val();
        var baseUrl = getBaseUrl()+"/boletim/tiponota/delpolicialparacadatiponota";
        var idNota = $('#idNota').val();
        var idTipoNota = $('#ce_tipo').val();

        //realizando requisição ajax
        $.ajax({
           
          
            url : baseUrl,
            dataType: "json",
            data: {// change data to this object
                _token: token,
                ce_nota:  idNota,
                ce_tipo:  idTipoNota,
                ce_policial: idPolicial
            },            
            method: 'post',
            success: function (data) {
               // alert('sucesso ok');
              //  alert(data);
                if(data.retorno=='sucesso'){                    
                    window.location.href = getBaseUrl()+"/boletim/nota/edit/"+idNota+"/"+idTipoNota;
                    //$(location).href("boletim/nota/edit/"+nota.ce_nota+"/"+nota.ce_tipo);
                    alert(data.msg);
                    $("[data-dismiss=modal]").trigger({ type: "click" });
                    document.location.reload(true);
                }else{  
                    alert(data.msg);
                    $('#modalRemoverPmQualquerNota').modal('hide');                       
                }                               
            },
            error: function (request, status, error) {
                alert('Falha para excluir o policial: '+error+'->'+status+'->'+request.responseText);
            }
        });
    }
}

    CKEDITOR.replace('st_fato');

</script>
@endsection