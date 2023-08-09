function getBaseUrl() {  
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    return baseUrl;
};





function eventModalRemoverPolicialParaQualquerNota() { 
    alert('chegou');
   /*  $.ajax({
        headers: {
            '_token': token
            },
        //Enviando via ajax
        url : baseUrl,
        dataType: "json",
        data: {// change data to this object
            _token : token,
            ce_opmdestino: idOpmDestino,
            ce_nota: idNota,
            ce_tipo: idTipoNota,
            dt_acontar: dtAcontar,
            ce_policial: idPolicial
        },
        method: 'post',
        success: function (data) {
          if(data.retorno=='erro'){
              alert(data.msg);
            }else{
                alert(data.msg);
            window.location.href = getBaseUrl()+"/boletim/nota/edit/"+idNota+"/"+idTipoNota;
            //$(location).href("boletim/nota/edit/"+nota.ce_nota+"/"+nota.ce_tipo);
          }            
        },
        error: function (request, status, error) {
            alert('Falha para adicionar o policial à nota');
        }
    }); */
}

$(document).ready(function(){
   
    /** realiza o controle de (de)habilitar  o btn de pesquisar pm */      
    //$('#btnLocalizarPolicial').attr("disabled","disabled");
    if( $('#st_policial').val() ) {                  
        $('#btnLocalizarPolicial').attr("disabled",false);
    }else{
        $('#btnLocalizarPolicial').attr("disabled",true);
    }
    $('#st_policial').blur(function(){
         if( $(this).val() ) {                  
             $('#btnLocalizarPolicial').attr("disabled",false);
         }else{
             $('#btnLocalizarPolicial').attr("disabled",true);
         }
     });
     
     /** evento para add pm a nota de movimentação */
     $("#addpmnotamovimentacao").click(function() {
         
        //recupera valores 
        var idOpmDestino = $( "#ce_unidadedestino option:selected" ).val();
        var idTipoNota = $( "#ce_tiponota").val();
        var idNota = $( "#idNota").val();
        var idPolicial = $( "#policialencontrado_tbody :first-child").attr('id');
        var dtAcontar = $( "#dt_acontar").val();
     
        var token = $('input[name="_token"]').attr('value');
        var baseUrl = getBaseUrl()+"/boletim/addpolicialparacadatiponota";
      //  alert(baseUrl); 
      // var text = ce_opmdestino+'/'+ce_tiponota+'/'+ce_policial+'/'+dt_acontar+'/'+token;
       //     alert(text);
        //valida preenchimento dos campos obrigatórios
        if(idOpmDestino==="" || idPolicial==="" || dtAcontar ===""){
            if(idOpmDestino===""){
                alert("Necessário selecionar a unidade de destino");
            }
            if(idPolicial===""){
                alert("Necessário selecionar um policial");
            }
            if(dtAcontar ===""){            
                alert("Necessário informar a data a contar");
            }
           
        }else{        
            $.ajax({
                headers: {
                    '_token': token
                    },
                //Enviando via ajax
                url : baseUrl,
                dataType: "json",
                data: {// change data to this object
                    _token : token,
                    ce_opmdestino: idOpmDestino,
                    ce_nota: idNota,
                    ce_tipo: idTipoNota,
                    dt_acontar: dtAcontar,
                    ce_policial: idPolicial
                },
              
                method: 'post',

                success: function (data) {
                  if(data.retorno=='erro'){
                      alert(data.msg);
                    }else{
                        alert(data.msg);
                    window.location.href = getBaseUrl()+"/boletim/nota/edit/"+idNota+"/"+idTipoNota;
                    //$(location).href("boletim/nota/edit/"+nota.ce_nota+"/"+nota.ce_tipo);
                  }            
                },
                error: function (request, status, error) {
                    alert('Falha para adicionar o policial à nota');
                }

            });
 
        }
     });


     /** evento para add pm a nota de movimentação */
    $("#btnShowModalConfirmaRemoverPolicialNotaMovimentacao").click(function() {
        alert('event show modal exclusão');    
     });
     /** evento para add pm a nota de movimentação */
    $(".testeModal").click(function() {
        if (confirm('Deseja excluir o policial desta nota?')) {
            var token = $('input[name="_token"]').attr('value');
            var baseUrl = getBaseUrl()+"/boletim/delpolicialparacadatiponota";

            var idTipoNota = $(this).attr('attrtidtiponota');
            var idNota = $(this).attr('attridnota');
            var idPolicial = $(this).attr('attridpolicial');
            $.ajax({
                headers: {
                    '_token': token
                    },
                //Enviando via ajax
                url : baseUrl,
                dataType: "json",
                data: {// change data to this object
                    _token : token,
                    ce_nota: idNota,
                    ce_tipo: idTipoNota,
                    ce_policial: idPolicial
                },
              
                method: 'post',

                success: function (data) {
                  //  alert(data);
                  alert(data.msg);
                  if(data.retorno=='sucesso'){                    
                    window.location.href = getBaseUrl()+"/boletim/nota/edit/"+idNota+"/"+idTipoNota;
                    //$(location).href("boletim/nota/edit/"+nota.ce_nota+"/"+nota.ce_tipo);
                  }            
                },
                error: function (request, status, error) {
                    //alert(request.responseText);
                    alert('Falha para excluir o policial: '+request.responseText);
                }

            });
          } else {
            // Do nothing!
            console.log('cancelou');
          }
       // $('#modalRemoverPmNotaMovimentacao1').removeClass("modal fade").addClass("modal fade in").css('display: block; padding-right: 17px');
       // $('#modalRemoverPmNotaMovimentacao1').show();
     });
  
});
