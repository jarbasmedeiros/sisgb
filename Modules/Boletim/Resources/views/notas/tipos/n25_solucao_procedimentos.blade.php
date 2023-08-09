@extends('boletim::notas.tipos.arquitetura_tipos_nota_template')
@section('conteudo_especifico_das_notas')


{{csrf_field()}}
<!-- .dados do procedimentos  -->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">DADOS DO PROCEDIMENTO</legend>
        @if(!isset($policiaisDaNota) || count($policiaisDaNota) < 1)
            <br> 
            <div class="form-inline">
                <div class="form-group{{ $errors->has('st_pesquisarprocedimento') ? ' has-error' : '' }} col-md-12" >
                    <div class="col-md-3 col-md-offset-1 text-right">
                        <label for="st_pesquisarprocedimento" class="col-form-label" style="margin-top: 7px">Pesquisar Procedimento pelo Nº do SEI</label>
                    </div>
                    <input type="text" name="st_pesquisarprocedimento" id="st_pesquisarprocedimento" class="form-control" style="width: 25%" placeholder="Digite o Nº do procedimento no SEI">
                    @if ($errors->has('st_pesquisarprocedimento'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_pesquisarprocedimento') }}</strong>
                        </span>
                    @endif
                    <a onclick="pesquisarProcedimento()" class="btn btn-primary" title="Pesquisar Procedimento">
                        <i class="fa fa-search"></i>
                    </a>
                    <span id="loader"></span>
                </div>
            </div>
            <br><br><br>
        @endif
        <div class="form-group{{ $errors->has('st_tipoprocedimento') ? ' has-error' : '' }} col-md-4" style="margin-right: 0.2px" >
            <label for="st_tipoprocedimento" class="control-label">Tipo de Procedimento</label>
                <select id="st_tipoprocedimento" name="st_tipoprocedimento" class="form-control select2" required="required" disabled>
                    <option value="" ></option>
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
        <div class="form-group{{ $errors->has('st_numsei') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px" >
            <label for="st_numsei" class="control-label" >N° do SEI</label>
            <input type="text" class="form-control" id="st_numsei" name="st_numsei" 
            value="{{$nota->st_numsei or '' }}" required="required" readonly>
            @if ($errors->has('st_numsei'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_numsei') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_numprocedimento') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px" >
            <label  for="st_numprocedimento" class="control-label">N° da Portaria</label>
            <input type="text" class="form-control" id="st_numprocedimento" 
            name="st_numprocedimento"
            value="{{$nota->st_numprocedimento or '' }}" required="required" readonly>
            @if ($errors->has('st_numprocedimento'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_numprocedimento') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_documentooriginal') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px" >
            <label for="st_documentooriginal" class="control-label">Documento Original</label>
            <input type="text" class="form-control"
            id="st_documentooriginal"  name="st_documentooriginal"
            value="{{$nota->st_documentooriginal or '' }}" required="required" readonly>
            @if ($errors->has('st_documentooriginal'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_documentooriginal') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_origem') ? ' has-error' : '' }} col-md-2" >
            <label for="st_origem" class="control-label">Origem do Procedimento</label>
                <select id="st_origem" name="st_origem" class="form-control select2" disabled>
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
        @if (isset($policiaisDaNota) && !empty($policiaisDaNota))
            <div class="row">
                <br><br><br><br>
                <h5><b class="text-danger">*</b> Caso deseje alterar os dados do procedimento é necessário excluir os policiais da nota.</h5>            
            </div>
        @endif
    </fieldset>
    <!-- .end dados  do procedimentos  -->
@endsection


@section('fragmento_head_tbl_policias_notas')
    <th>Ord.</th>
    <th>Post/Grad</th>
    <th>Matrícula</th>
    <th>Nome</th>
    <th>Solução Individual</th>
    <th>Unidade</th>
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
                <td>{{$policial->st_solucao}}</td>
                <td>{{$policial->st_unidadepolicial}}</td>
                <td>                               
                  
                    @if($nota->st_status == 'RASCUNHO')
                        <a class="btn btn-danger btn-sm removerPolicial" data-toggle="modal" onclick="showModalRemoverPmQualquerNota({{$policial->ce_policial}})" title="Remover Policial da Nota">
                            <span class="fa fa-trash"></span>
                        </a>
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
                   <h4 class="modal-title">Adicionar Policial a Solução do Procedimento</h4>
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
                        <label  for="st_solucao" class="control-label">Solução do Procedimento para o Policial:</label>
                            <select class="form-control" id="st_solucao" name="st_solucao" >
                                <option value="" >--Selecione--</option>
                                <option value="ARQUIVAMENTO">ARQUIVAMENTO</option>
                                <option value="INDICIAMENTO">INDICIAMENTO</option>
                                <option value="NAO_INDICIAMENTO">NÃO INDICIAMENTO</option>
                                <option value="PUNICAO">PUNIÇÃO</option>
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

@section('css')
<style>

    #st_tipoprocedimento {
        background: #eee; /* Simular campo inativo */ 
        pointer-events: none;
        touch-action: none;
    }

</style>
@endsection


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
                        st_solucao: $('#st_solucao').val(),
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
                        console.log(data);
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

function pesquisarProcedimento() {

    $('#st_tipoprocedimento').val('').change()
    $('#st_numsei').val('')
    $('#st_numprocedimento').val('')
    $('#st_documentooriginal').val('')
    $('#st_origem').val('').change()

    let baseUrl = getBaseUrl();
    let numSEI = $('#st_pesquisarprocedimento').val()

    if (numSEI == '') {
        alert('Informe o número do Procedimento!')
    } else {
        //iniciando a requisição ajax para buscar o procedimento
        $.ajax({
            //Enviando via ajax
            url: baseUrl + '/boletim/nota/consultarprocedimento/' + numSEI,
            method: 'get',
            beforeSend: function () {
                //adiciona o loader
                $("#loader").html("<span id='div-loader'> <img src='{{ asset('imgs/carregando.gif') }}' width=30>");
            },
            
        }).done(function(data){
            $('#div-loader').remove();
            if (data.length === 0) {
                alert('Nenhum Procedimento encontrado!')
            } else if (!data[0].id) {
                alert(data)
            } else {
                $('#st_tipoprocedimento').val(data[0].st_tipo).change()
                $('#st_numsei').val(data[0].st_numsei)
                $('#st_numprocedimento').val(data[0].st_numprocedimento)
                $('#st_documentooriginal').val(data[0].st_documentooriginal)
                $('#st_origem').val(data[0].st_origem).change()
            
            }
        
        }).fail(function () {
            $('#div-loader').remove();
            alert('Erro ao consultar Procedimento!');
        });
    } 
}

function solucionarProcedimento() {
    alert('falta implementar o método para solucionar procedimento!')
}


</script>
@endsection