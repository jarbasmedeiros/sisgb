
$("input:checkbox").change(function() {
    
    var permissao = $('#todasPermissoes').val();
    var PermissionObj = {};
    PermissionObj.idsSelecionadas = [];
    PermissionObj.idsNaoSelecionadas = [];

    $("input:checkbox").each(function() {
        
        if ($(this).is(":checked")) {
            
            PermissionObj.idsSelecionadas.push($(this).attr("id"));
        } else {
            
            PermissionObj.idsNaoSelecionadas.push($(this).attr("id"));
        }
    });
    
    $('#novasPermissoes').val(PermissionObj.idsSelecionadas);

    //console.log(PermissionObj.idsSelecionadas+'-'+$('#todasPermissoes').val());
    
    param = $('#novasPermissoes').val(PermissionObj.idsSelecionadas);
    if(PermissionObj.idsSelecionadas == $('#todasPermissoes').val()){
        $('#atualizar').hide();
        $("#atualizar").attr("onclick","AdicionarPermissao()");
    }else{
        $("#atualizar").attr("onclick","AdicionarPermissao('"+$('#novasPermissoes').val()+"')");
        $('#atualizar').show();
    }
});




function AdicionarPermissao(ids)
{
    
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    baseUrl += "/";
    var todasIds = $("#todasPermissoes").val();
    var novasIds = ids;
    var auxiliar = novasIds.replace(/,/g, "-");
    var total = ids;
    
    if($("#novasPermissoes").val() == 0){
        alert('Selecione uma Permissão!'); return false;
    }
    var r = confirm("Deseja realmente adicionar esta(s) permissão(ões) ao perfil?");
    if(r == false){
    return false;
    }
    
    

    dados = {
      idPerfil: $('#idPerfil').val(),
      idsPermissoes: ids,
     _token: $("input[name=_token]").val()
     };
    
    
    $.ajax({
        //Enviando via ajax
        url : baseUrl+"admin/role/adicionarpermissao",
        data: dados,
        method: 'POST',
        //Verificando se encontrou 0 policial
    }).done(function(data){
        
        if(data == 1){
            
            alert('Permissão Adicionada ao perfil com sucesso!');
            $("[data-dismiss=modal]").trigger({ type: "click" });
            document.location.reload(true);
        }else{
            alert('Erro! '+data); 
            $("[data-dismiss=modal]").trigger({ type: "click" });
        }

    });
}