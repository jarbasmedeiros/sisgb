/* Tela boletim/notas - Histórico de Boletim */

function modalExcluiNota(id) {  
                
    $("#idNota").val(id);
    $('#exclui_nota').modal();
};

$('body').on('click','#btnExcluir', function() {

    if(!$('#st_obs').val())
    {
        alert('Preencha o campo de justificativa!');
        return false;
    }

});

$('.accordion-toggle').click(function(){
    $(this).text(function(i,old){
        return old=='Ver mais...' ?  'Ver menos...' : 'Ver mais...';
    });
});


function buscaHistoricoNotas(id){
 //   alert('boletim.js do public');
    $('.spinner').show();    
    $('.spinner').fadeOut(2150);
    
    //Limpa o modal da consulta anterior
    $('#historico_nota_tbody').html("");
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    baseUrl += "/";
    
    $.ajax({
        url : baseUrl + "boletim/nota/historico" + "/" + id,
        type : 'get'
    }).done(function(historicos){
        //console.log(historicos);
        $('#modalHistorico').modal('show');
            for (var i = 0; i < historicos.length; i++){
                if (historicos[i].st_obs == null){
                        var observacoes = "";
                    }else{
                        var observacoes = historicos[i].st_obs;
                    }
                    
                //Formata a data para dd/mm/yyyy hh:mm:ss                 
                $('#historico_nota_tbody').append(
                    "<tr>"+
                    "<td>"+moment(historicos[i].dt_cadastro).format('DD/MM/YYYY HH:mm:ss')+"</td>"+
                    "<td>"+historicos[i].st_usuario+"</td>"+
                    "<td>"+historicos[i].st_status+"</td>"+
                    "<td>"+historicos[i].st_msg+"</td>"+
                    "<td>"+observacoes+"</td>"+
                    "</tr>");
                    
            }
            
    }).fail(function(jgXHR, textStatus, historicos){
        //$('#modalHistorico').modal('toggle');

    })

}

function off() {
    document.getElementById("spinner").style.display = "none";
}


/* ------------------------------------------------------------ */
/*Tela boletim/consulta - Consulta Boletim */

function opcaoUnidade(value){
    if(value == "2"){
        $("#unidadeBoletim").show();
        $("#ce_unidade").prop('disabled', false);
        $("#ce_unidade").attr("required", true);
    }else{
        $("#unidadeBoletim").hide();
        $("#ce_unidade").prop('disabled', true);
        $("#ce_unidade").removeAttr("required");
    }
}
$(document).on("change", "select", function() {
    if($(this).prop("id") == "ce_tipo"){
        opcaoUnidade($("#ce_tipo").val());
    }else if($(this).prop("id") == "st_filtro"){
        alteracaoCriterios(this.value);
    }
});
$(document).ready(function() {
    alteracaoCriterios($("#st_filtro").val());
    opcaoUnidade($("#ce_tipo").val());
});
function alteracaoCriterios(valor){
    if (valor == "data_boletim"){
        $("#data").show();
        $("#inputData").prop('disabled', false);
        $("#inputData").attr("required", true);

        $("#numero").hide();
        $("#inputNumero").prop('disabled', true);
        $("#inputNumero").removeAttr("required");

        $("#ano").hide();
        $("#inputAno").prop('disabled', true);
        $("#inputAno").removeAttr("required");
        
        $("#mes").hide();
        $("#inputMes").prop('disabled', true);
        $("#inputMes").removeAttr("required");
        
        $("#assunto").hide();
        $("#inputAssunto").prop('disabled', true);
        $("#inputAssunto").removeAttr("required");
        
    } else if(valor == "mes_boletim"){
        $("#ano").show();
        $("#inputAno").prop('disabled', false);
        $("#inputAno").attr("required", true);
        
        $("#mes").show();
        $("#inputMes").prop('disabled', false);
        $("#inputMes").attr("required", true);
        
        $("#numero").hide();
        $("#inputNumero").prop('disabled', true);
        $("#inputNumero").removeAttr("required");
        
        $("#data").hide();
        $("#inputData").prop('disabled', true);
        $("#inputData").removeAttr("required");
        
        $("#assunto").hide();
        $("#inputAssunto").prop('disabled', true);
        $("#inputAssunto").removeAttr("required");
        
    } else if(valor == "assunto_boletim"){
        $("#ano").show();
        $("#inputAno").prop('disabled', false);
        $("#inputAno").attr("required", true);
        
        $("#assunto").show();
        $("#inputAssunto").prop('disabled', false);
        $("#inputAssunto").attr("required", true);
        
        $("#mes").hide();
        $("#inputMes").prop('disabled', true);
        $("#inputMes").removeAttr("required");
        
        $("#numero").hide();
        $("#inputNumero").prop('disabled', true);
        $("#inputNumero").removeAttr("required");
        
        $("#data").hide();
        $("#inputData").prop('disabled', true);
        $("#inputData").removeAttr("required");
    } else {
        $("#numero").show();
        $("#inputNumero").prop('disabled', false);
        $("#inputNumero").attr("required", true);
        
        $("#ano").show();
        $("#inputAno").prop('disabled', false);
        $("#inputAno").attr("required", true);
        
        $("#data").hide();
        $("#inputData").prop('disabled', true);
        $("#inputData").removeAttr("required");
        
        $("#mes").hide();
        $("#inputMes").prop('disabled', true);
        $("#inputMes").removeAttr("required");
        
        $("#assunto").hide();
        $("#inputAssunto").prop('disabled', true);
        $("#inputAssunto").removeAttr("required");

    }
}
$("#inputMes").datepicker({
    format: "mm",
    startView: "months", 
    minViewMode: "months",
    language: "pt-BR"
});
$("#inputData").datepicker({
    format: "dd/mm/yyyy",

});
$("#inputAno").datepicker({
    format: "yyyy",
    minViewMode: 2,
    language: "pt-BR"
});


   
/* ------------------------------------------------------------ */
/* Tela de boletim/edit/ {id} - Elaborar Boletim atribuição de notas */
function mudaParteboletimNota(valorParte, nota, idBoletim){
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    
    $.ajax({
        //Enviando via ajax
        url: baseUrl+"/boletim/alterapartenota/"+nota+'/'+valorParte+'/'+idBoletim,
        method: 'get',
        //Verificando se cadastrou
    }).done(function(data){
        if(data == 1){
            alert('Parte da nota no Boletim alterada com sucesso.')
            document.location.reload(true);
        }else{
            alert(data)
        }
        
    });
    
};
/*  Tela de boletim/edit/ {id} - Elaborar Boletim atribuição de notas */
/* function mudaParteboletimNota(valorParte, nota, idBoletim){
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    baseUrl += "/public/";
    
    $.ajax({
        //Enviando via ajax
        url: baseUrl+"boletim/alterapartenota/"+nota+'/'+valorParte+'/'+idBoletim,
        method: 'get',
        //Verificando se cadastrou
    }).done(function(data){
        if(data == 1){
            alert('Parte da nota no Boletim alterada com sucesso.')
            document.location.reload(true);
        }else{
            alert('Erro ao alterar a parte da nota no Boletim.')
        }
        
    });
    
};  */
/* ------------------------------------------------------------ */

$('body').on('keypress','#st_assunto', function() {
        
    $('#st_assunto').css('border','1px solid #d2d6de');
    //$('#rascunho_st_assunto').val($('#st_assunto').val());
    //$('#salvarNota').prop('disabled', false);
    //$('#rascunho_st_materia').val($('#cke_st_materia').val());
    //$('#rascunho_'+value).val($('#'+value).val());
});

$('body').on('click','#salvarNota', function() {
    
    var idPolicial = $('.removerPolicial').attr('id');
    
    $('#idPolicial').val(idPolicial);
    var r = confirm("Deseja realmente salvar a Nota?");
    if(r == false){
    return false;
    }
    
});
/*---consultar policial----------------------------------------*/

$('body').on('change','#consultaPolicial', function() {
        
            $('#consultar').removeAttr("disabled");

});


function consultar() {
    alert('consultar pm');
    var idNota = $("#ce_tipo option:selected").val();
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
    
    
};

$('body').on('click','.addPolicial', function(){
    
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    baseUrl += "/";
    
    dados = {
      idNota: $('#idNota').val(),
      idPolicial: $('#idPolicial').val(),
     _token: $("input[name=_token]").val()
     };

    
    $.ajax({
        //Enviando via ajax
        url : baseUrl+"boletim/adicionapolicial",
        data: dados,
        method: 'POST',
        //Verificando se encontrou 0 policial
    }).done(function(data){
        //console.log(data.length);
        if(data == 1){
            alert('Policial adicionado a nota com sucesso!');
            $("[data-dismiss=modal]").trigger({ type: "click" });
            document.location.reload(true);
        }else{
            alert(data);
            //$("[data-dismiss=modal]").trigger({ type: "click" });
        }

    });
    

});

//var test = consultar();



function removerPolicial()
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    baseUrl += "/";
    
    //return false;

    dados = {
      idNota: $('#idNota').val(),
      idPolicial: $('.removerPolicial').attr('id'),
     _token: $("input[name=_token]").val()
     };
    
    //alert($('#consultaPolicial').val()); return false;
    $.ajax({
        //Enviando via ajax
        url : baseUrl+"boletim/removerpolicialdanota",
        data: dados,
        method: 'POST',
        //Verificando se encontrou 0 policial
    }).done(function(data){
        //console.log(data.length);
        if(data == 1){
            alert('Policial removido da nota com sucesso!');
            $("[data-dismiss=modal]").trigger({ type: "click" });
            document.location.reload(true);
        }else{
            alert('Erro ao remover o policial da nota!');
            $("[data-dismiss=modal]").trigger({ type: "click" });
            document.location.reload(true);

        }

    });
}
/*------------------------------------------------------------*/
/* Tela boletim/topicos - Modal para excluir tópico de boletim */
function modalExcluiTopico(id) {
    //alert(id);
    $('#deleta_topico').attr("href", 'deleta/' + id);
    $("#form_exclui_topico").attr("href", "{{ url('boletim/deleta/deleta')}}/" + id);
    $('#exclui_topico').modal();
};
/*------------------------------------------------------------*/
/* Tela boletim/lista_boletim_pendente - Modal para excluir nota */
function modalExcluiBoletim(id) {
    //alert(id);
    $('.excluirboletim').attr("href", "exclui/" + id);
    $("#form_exclui_boletim").attr("href", "{{ url('boletim/exclui')}}/" + id);
    $('#exclui_boletim').modal();
};
/* ------------------------------------------------------------ */
/* Tela de boletim/edit/{id} - Publicar boletim */
function publicarBoletim(idBoletim){
    $('.overlay').hide();
    alert("oi");
    console.log('oi');
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    baseUrl += "/";
    
    dados = {
        password: $('#publicarModal #password').val(),
       _token: $("#publicarModal input[name=_token]").val()
    };
    
    $.ajax({
        //Enviando via ajax
        url: baseUrl+"boletim/publicar1/"+idBoletim,
        data: dados,
        method: 'post',
        //Verificando se cadastrou
    }).done(function(response){
        console.log(response);
        window.location.replace(response.url);
    });
};
/* ------------------------------------------------------------ */   