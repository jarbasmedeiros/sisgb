$(document).ready(function(){
    $("#vl_gratificacao").inputmask('currency', {
                'alias': 'numeric',
                'decimalProtect': true,
                'groupSeparator': '.',
                'autoGroup': true,
                'digits': 2,
                'radixPoint': ",",
                'digitsOptional': false,
                'allowMinus': false,
                'prefix': 'R$ ',
                'placeholder': '0',
                'removeMaskOnSubmit': true
    });
});


/**
* Funções para formulaário cadastro de íten
*/

function selectTipoItem() {        
    var valor = $("#ce_tipoitem").val();
    if(valor == '4'){                     
        document.getElementById("divMestre").style.display = "block";
        document.getElementById("divDetalhe").style.display = "block";
        $("#bo_mestre").removeAttr("disabled");
        $("#bo_detalhe").removeAttr("disabled");
    }
    else{
        document.getElementById("divMestre").style.display = "none";
        $("#bo_mestre").attr("disabled", "true");
        document.getElementById("divDetalhe").style.display = "none";
        $("#bo_detalhe").attr("disabled", "true");
        document.getElementById("divTabelaOrigem").style.display = "none";
        document.getElementById("divColunaWhere").style.display = "none";
        document.getElementById("divColunaTabela").style.display = "none";
        $("#st_tabelaorigem").attr("disabled", "true");
        $("#st_colunawhere").attr("disabled", "true");
        $("#st_colunatabela").attr("disabled", "true");
    }
}

function selectMestre() {        
    var valor = $("#bo_mestre").val();
    if(valor == '1'){                            
        document.getElementById("divTabelaOrigem").style.display = "block";
        document.getElementById("divColunaWhere").style.display = "block";
        document.getElementById("divColunaTabela").style.display = "block";
        document.getElementById("divIdDetalhe").style.display = "block";
        $("#st_tabelaorigem").removeAttr("disabled");
        $("#st_colunawhere").removeAttr("disabled");
        $("#st_colunatabela").removeAttr("disabled");
        $("#st_iddetalhe").removeAttr("disabled");
    }
    else{          
        document.getElementById("divTabelaOrigem").style.display = "none";
        document.getElementById("divColunaWhere").style.display = "none";
        document.getElementById("divColunaTabela").style.display = "none";
        document.getElementById("divIdDetalhe").style.display = "none";
        $("#st_tabelaorigem").attr("disabled", "true");
        $("#st_colunawhere").attr("disabled", "true");
        $("#st_colunatabela").attr("disabled", "true");
        $("#st_iddetalhe").attr("disabled", "true");
    }     
}
/**
* 
* Funções para gerenciar filtros de listagem de férias
* 
*/

function selectFilter(){
    var valor = $("#filterlist").val();
    if(valor == 'ce_setor'){
        document.getElementById("divSetorFilter").style.display = "block";
        $("#st_sigla").removeAttr("disabled");
        $("#dt_final").attr("disabled", "true");
        $("#st_funcao").attr("disabled", "true");
        $("#dt_inicio").attr("disabled", "true");
        $("#periodo").attr("disabled", "true");
    }else{
        document.getElementById("divSetorFilter").style.display = "none";
        $("#st_sigla").attr("disabled", "true");
        $("#dt_final").attr("disabled", "true");
        $("#st_funcao").attr("disabled", "true");
        $("#dt_inicio").attr("disabled", "true");
        $("#periodo").attr("disabled", "true");
    }
    if(valor == 'ce_funcao'){
        document.getElementById("divFuncaoFilter").style.display = "block";
        $("#st_funcao").removeAttr("disabled");
        $("#dt_final").attr("disabled", "true");
        $("#st_sigla").attr("disabled", "true");
        $("#dt_inicio").attr("disabled", "true");
        $("#periodo").attr("disabled", "true");
    }
    else{
        document.getElementById("divFuncaoFilter").style.display = "none";
        $("#st_funcao").attr("disabled", "true");
    }
    if(valor == 'ce_orgao'){
        document.getElementById("divOrgaoFilter").style.display = "block";
        $("#st_orgao").removeAttr("disabled");
    }else{
        document.getElementById("divOrgaoFilter").style.display = "none";
        $("#st_orgao").attr("disabled", "true");
    }
    if(valor == 'dt_inicio'){
        console.log("Data Início");
        
        document.getElementById("divDataInicioFilter").style.display = "block";
        $("#dt_inicio").removeAttr("disabled");
        $("#st_funcao").attr("disabled", "true");
        $("#dt_final").attr("disabled", "true");
        $("#st_sigla").attr("disabled", "true");
        $("#periodo").attr("disabled", "true");
    }
    else{
        document.getElementById("divDataInicioFilter").style.display = "none";
        $("#dt_inicio").attr("disabled");
    }
    if(valor == 'periodo'){
        console.log("Período");

        document.getElementById("divPeriodoFilter").style.display = "block";
        $("#inicioPeriodo").removeAttr("disabled");
        $("#finalPeriodo").removeAttr("disabled");
        $("#dt_inicio").attr("disabled", "true");
        $("#st_funcao").attr("disabled", "true");
        $("#dt_final").attr("disabled", "true");
        $("#st_sigla").attr("disabled", "true");
    }
    else{
        document.getElementById("divPeriodoFilter").style.display = "none";
        $("#inicioPeriodo").attr("disabled");
        $("#finalPeriodo").attr("disabled");
    }
    if(valor == 'dt_final'){
        console.log("Data Final");

        document.getElementById("divDataFinalFilter").style.display = "block";
        $("#dt_final").removeAttr("disabled");
        $("#periodo").attr("disabled", "true");
        $("#dt_inicio").attr("disabled", "true");
        $("#st_funcao").attr("disabled", "true");
        $("#st_sigla").attr("disabled", "true");
    }
    else{
        document.getElementById("divDataFinalFilter").style.display = "none";
        $("#dt_final").attr("disabled");
    }
    if(valor == 'st_anoreferente'){
        document.getElementById("divAnoReferenteFilter").style.display = "block";
        $("#st_anoreferente").removeAttr("disabled");
        $("#periodo").attr("disabled", "true");
        $("#dt_inicio").attr("disabled", "true");
        $("#st_funcao").attr("disabled", "true");
        $("#dt_final").attr("disabled", "true");
        $("#st_sigla").attr("disabled", "true");
    }
    else{
        document.getElementById("divAnoReferenteFilter").style.display = "none";
        $("#st_anoreferente").attr("disabled", "true");
    }
}
jQuery(function($){
    $("#st_cep").mask("99999-999");
    $("#st_cpf").mask("999.999.999-99");
 });


 // ao alterar o campo altera status do servidor na hora do cadastro da Cr, exibe o campo
 // status para selecionar o proximo status
 function alterarstatusservidor(){
    var valor = $('#st_alterastatus').val();
    if(valor == 'Sim'){
        $('#status').show()
        $("#st_status").removeAttr("disabled");
        $("#st_status").attr("required", true);
      
    }else{
        $('#status').hide()
        //$("#st_status").attr("disabled");
        $('#st_status').prop('disabled', true);
        $("#st_status").attr("required", false);
        $("#st_status").val(null);
    }

     
};
function desativafuncionario(){
    var valor = $('#st_desativafuncionario').val();
    if(valor == 'Sim'){
        $('#motivo').show()
        $("#st_motivo").removeAttr("disabled");
        $("#st_motivo").attr("required", true);
      
    }else{
        $('#motivo').hide()
        //$("#st_status").attr("disabled");
        $('#st_motivo').prop('disabled', true);
        $("#st_motivo").attr("required", false);
        $("#st_motivo").val(null);
    }  
};
/* function escolheNotas(valor){
        var token = $("input[type=hidden][name=_token]").val();
        $.ajax({
            url : "../verificartiponota",
            type : 'post',
            data : {
            id :valor,
            _token : token,
        },
        beforeSend : function(){
            $("#resultado").html("ENVIANDO...");
        }
    }).done(function(msg){
        if(msg == 2){
            alert('Tipo de Nota Não encontrado!');
        }else{
            var redirect =msg;
            
            window.location.href = redirect;
        
        }
           
        }).fail(function(jqXHR, textStatus, msg){
            alert(msg);
        })


}; */

function ativafuncionario(){
    var valor = $('#st_ativafuncionario').val();
    if(valor == 'Sim'){
        $('#ativa').show()
        $("#dt_posse").removeAttr("disabled");
        $("#dt_exercicio").removeAttr("disabled");
        $("#ce_cargo").removeAttr("disabled");
        $("#ce_orgao").removeAttr("disabled");
      
    }else{
        $('#ativa').hide()
        $('#dt_posse').prop('disabled', true);
        $('#dt_exercicio').prop('disabled', true);
        $('#ce_cargo').prop('disabled', true);
        $('#ce_orgao').prop('disabled', true);
    }  
};
         

/*
 * Função de autopreenchimento de enredeço através do cep digitado
 */

$(document).ready(function() {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#st_logradouro").val("");
        $("#st_bairro").val("");
        $("#st_cidade").val("");
        $("#st_uf").val("");
        $("#st_numeroresidencia").val("");
    }
    
    //Quando o campo cep perde o foco.
    $("#st_cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                //$("#st_logradouro").val("...");
               // $("#st_bairro").val("...");
                //$("#st_cidade").val("...");
                //$("#st_uf").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#st_logradouro").val(dados.logradouro);
                        $("#st_bairro").val(dados.bairro);
                        $("#st_cidade").val(dados.localidade);
                        $("#st_uf").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        //alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                //alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

$(document).ready(function() {
    $('.select2').select2();
    $('[data-toggle="tooltip"]').tooltip(); //aciona tooltip do bootstrap, mas tem que colocar data-toggle="tooltip" na tag desejada
    $('#rgts6').blur(function(){ //função para calcular datas no new e edit de quando muda a qtd de dias
        if($('#rgts6').val()){
            if($('#rgts7').val()){
                $('#rgts8').val(calcData($("#rgts6").val(), $("#rgts7").val()));
            }
        }
    });
    $('#rgts1').blur(function(){ //função para calcular datas no new e edit de quando muda a qtd de dias
        if($('#rgts1').val()){
            if($('#rgts2').val()){
                $('#rgts3').val(calcData($("#rgts1").val(), $("#rgts2").val()));
            }
        }
    });
});

function calcData(dias, data){ //função para calcular datas no new e edit de quando muda a qtd de dias
    var from = data.split("-");
    var date = new Date(from[0], from[1] - 1, from[2]);
    date.setDate(date.getDate() + (parseInt(dias) - 1));
    var yyyy = date.getFullYear().toString();
    var mm = (date.getMonth()+1).toString();
    var dd  = date.getDate().toString();
    return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]);
}

function selectFilterFuncionarios(){
    var valor = $("#filterlist").val();
    if(valor == 'ce_setor'){
        document.getElementById("divSetorFilter").style.display = "block";
        $("#st_sigla").removeAttr("disabled");
    }
    else{
        document.getElementById("divSetorFilter").style.display = "none";
        $("#st_sigla").attr("disabled", "true");
    }
    if(valor == 'ce_orgao'){
        document.getElementById("divOrgaoFilter").style.display = "block";
        $("#st_orgao").removeAttr("disabled");
    }
    else{
        document.getElementById("divOrgaoFilter").style.display = "none";
        $("#st_orgao").attr("disabled", "true");
    }
};



function checkConjuge(){
    if($("#st_estadocivil").val() == "Casado" || $("#st_estadocivil").val() == "União Estável"){
        document.getElementById("divConjuge").style.display = "block";
    } else {
        document.getElementById("divConjuge").style.display = "none";
        document.getElementById("st_conjuge").value = "";
    }
};




