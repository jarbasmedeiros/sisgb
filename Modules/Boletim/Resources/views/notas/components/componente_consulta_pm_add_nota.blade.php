<!-- .consulta pms da nota componente -->
<fieldset class="scheduler-border">
            <legend class="scheduler-border">Informações do Policial-componente</legend>
            <div class="form-group">
                @if((!empty($nota)) || (isset($nota) && $nota->st_status ==  'RASCUNHO' ))
                    <label for="st_assunto" class="col-md-2 control-label">Policial</label>
                    <div class="col-md-6">
                        <input id="txtCpfMatriculaPolicial" type="text"  value="1666886"class="form-control" name="txtCpfMatriculaPolicial" placeholder="Buscar policial por CPF ou Matrícula">
                    </div>
                    <div class="col-4">
                        <!-- Botão para acionar modal -->
                        <a id="btnConsultarPm" name="btnConsultarPm" class="btn btn-primary " onclick="consultarPm()" data-toggle="modal" data-target="#modalConsultaPm1">
                        Consultar1
                        </a>
                    </div>
                @else
                    <h4>Ao salvar o sistema habilita o formulário para incluir policias-componente </h4>
                @endif
            </div>
           
 </fieldset>



 <script>  
     function consultarPm() {
         if($('#txtCpfMatriculaPolicial').val()==''){
             alert('Informar o CPF ou Matrícula do Policial');
            }else{
             
             $('#modalConsultaPm').modal({
                show: 'true'
            }); 
            
            var idNota = $("#ce_tipo option:selected").val();
            
            baseUrl = getBaseUrl()+"/";
            //alert(baseUrl);
            var user = $('#txtCpfMatriculaPolicial').val();
            //alert(user); return false;
            $.ajax({
                //Enviando via ajax
                url : baseUrl+"boletim/consultarpolicial/"+user,
                method: 'get',
                //Verificando se cadastrou
            }).done(function(data){
                //console.log(data.length);
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
            });
        }
    } 

    
    
    
</script>
  <!--   <script>
 function consultar111() {
    var idNota = $("#ce_tipo option:selected").val();
    alert(idNota);
    //$('#policialencontrado_tbody').empty();
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    baseUrl += "/";
    
    if(!$('#consultaPolicial').val()){
        alert('Insira o CPF ou Matrícula do policial!');

        return false;
    }
    var user = $('#consultaPolicial').val();
    //alert(user); return false;
    $.ajax({
        //Enviando via ajax
        url : baseUrl+"boletim/consultarpolicial/"+user,
        method: 'get',
        //Verificando se cadastrou
    }).done(function(data){
        //console.log(data.length);
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

    });
 }
 </script> -->
<!--  end consulta pms da nota componente -->
