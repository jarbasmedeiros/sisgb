/* Tela boletim/notas - Histórico de Boletim */

/* ------------------------------------------------------------ */
/*Tela boletim/consulta - Consulta Boletim */
$(document).ready(function () {

   var categoria = $("#st_categoria").val()

   if(categoria == 'ACADEMICO'){
     
        /*  var campos_novos = "<div class='dep_fc'><div class='col-md-10' style='margin-top: 5px;'><input type='text' class='form-control' placeholder='Nome do Dependente' id='dependente[]' name='dependente[]'></div><div class='col-md-2' id='dep_fc' style='margin-top: 5px;'><button class='btn btn-primary remove' type='button' >Remove</button></div></div>";
         $("#campodinamico").append(campos_novos); */
      $("#st_tipo").empty();
      $("#st_tipo").append('<option value="">Selecione</option>') 
      $("#st_tipo").append('<option value="TECNICO">TECNICO</option>') 
      $("#st_tipo").append('<option value="TECNOLOGO">TECNOLOGO</option>') 
      $("#st_tipo").append('<option value="SUPERIOR">SUPERIOR</option>') 
      $("#st_tipo").append('<option value="PÓS-GRADUACAO">PÓS-GRADUACAO</option>') 
      $("#st_tipo").append('<option value="MESTRADO">MESTRADO</option>') 
      $("#st_tipo").append('<option value="DOUTORADO">DOUTORADO</option>') 
      $("#st_tipo").append('<option value="PHD">PHD</option>') 
      $("#st_tipo").append('<option value="OUTRO">OUTRO</option>')
      $("#st_tipo").show()
      $('.tipo').show();
      $('.cursoInput').show();
      $('.cursoSelect').hide();
      $("#cursoInput").attr('required', 'true');
      $("#cursoInput").attr('name', 'st_curso');
      $("#cursoSelect").removeAttr('required', 'true');
      $("#cursoSelect").removeAttr('name', 'true');
      $("#st_tipo").attr('required', 'true');
      
   }else if(categoria == 'APERFEICOAMENTO'){
      $("#cursoInput").removeAttr('name', 'true');
      $("#st_tipo").empty();
      $('.tipo').hide();
      $("#cursoSelect").empty();
      $("#cursoSelect").append('<option value="">Selecione</option>') 
      $("#cursoSelect").append('<option value="CAS">CAS</option>') 
      $("#cursoSelect").append('<option value="CAO">CAO</option>') 
      $("#cursoSelect").append('<option value="CSP">CSP</option>') 
      $("#cursoInput").empty();
      $('.cursoInput').hide();
      $('.cursoSelect').show();
      $("#cursoSelect").attr('required', 'true');
      $("#cursoSelect").attr('name', 'st_curso');
      $("#cursoInput").removeAttr('required', 'true');
     
      $("#st_tipo").removeAttr('required', 'true');

   }else if(categoria == 'FORMACAO'){
      $("#cursoInput").removeAttr('name', 'true');
      $("#cursoInput").removeAttr('required', 'true');
      $("#st_tipo").empty();
      $('.tipo').hide();
      $('.cursoInput').hide();
      $("#cursoSelect").append('<option value="">Selecione</option>') 
      $("#cursoSelect").append('<option value="CFP">CFP</option>') 
      $("#cursoSelect").append('<option value="CFC">CFC</option>') 
      $("#cursoSelect").append('<option value="CFS">CFS</option>') 
      $("#cursoSelect").append('<option value="CFO">CFO</option>') 
      $("#cursoSelect").append('<option value="CFSD">CFSD</option>')
      $("#cursoSelect").append('<option value="CHO">CHO</option>') 
      $("#cursoSelect").append('<option value="CNP">CNP</option>') 
      $("#cursoSelect").append('<option value="EHS">EHS</option>') 
      $('.cursoSelect').show();
      $("#cursoSelect").attr('required', 'true');
      $("#cursoSelect").attr('name', 'st_curso');
      $("#st_tipo").removeAttr('required', 'true');
   }else{
      $("#st_tipo").empty();
      $('.tipo').hide();;
      $('.cursoInput').show();
      $('.cursoSelect').hide();
      $("#cursoInput").attr('required', 'true');
      $("#cursoInput").attr('name', 'st_curso');
      $("#cursoSelect").removeAttr('required', 'true');
      $("#cursoSelect").removeAttr('name', 'true');
      $("#st_tipo").removeAttr('required', 'true');
   }
   


});
$("#st_categoria").change(function() {
   var valor = $(this).val();

   if(valor == 'ACADEMICO'){
     
        /*  var campos_novos = "<div class='dep_fc'><div class='col-md-10' style='margin-top: 5px;'><input type='text' class='form-control' placeholder='Nome do Dependente' id='dependente[]' name='dependente[]'></div><div class='col-md-2' id='dep_fc' style='margin-top: 5px;'><button class='btn btn-primary remove' type='button' >Remove</button></div></div>";
         $("#campodinamico").append(campos_novos); */
      $("#st_tipo").empty();
      $("#st_tipo").empty();
      $("#st_tipo").append('<option value="">Selecione</option>') 
      $("#st_tipo").append('<option value="TECNICO">TECNICO</option>') 
      $("#st_tipo").append('<option value="TECNOLOGO">TECNOLOGO</option>') 
      $("#st_tipo").append('<option value="SUPERIOR">SUPERIOR</option>') 
      $("#st_tipo").append('<option value="PÓS-GRADUACAO">PÓS-GRADUACAO</option>') 
      $("#st_tipo").append('<option value="MESTRADO">MESTRADO</option>') 
      $("#st_tipo").append('<option value="DOUTORADO">DOUTORADO</option>') 
      $("#st_tipo").append('<option value="PHD">PHD</option>') 
      $("#st_tipo").append('<option value="OUTRO">OUTRO</option>')
      $("#st_tipo").show()
      $('.tipo').show();
      $('.cursoInput').show();
      $('#cursoInput').empty();
      $('.cursoSelect').hide();
      $('#cursoSelect').empty();
      $("#cursoInput").attr('required', 'true');
      $("#cursoInput").attr('name', 'st_curso');
      $("#cursoSelect").removeAttr('required', 'true');
      $("#cursoSelect").removeAttr('name', 'true');
      $("#st_tipo").attr('required', 'true');
      
   }else if(valor == 'APERFEICOAMENTO'){
      $("#st_tipo").empty();
      $('.tipo').hide();
      $("#cursoSelect").empty();
      $("#cursoSelect").append('<option value="">Selecione</option>') 
      $("#cursoSelect").append('<option value="CAS">CAS</option>') 
      $("#cursoSelect").append('<option value="CAO">CAO</option>') 
      $("#cursoSelect").append('<option value="CSP">CSP</option>') 
      $("#cursoInput").empty();
      $('.cursoInput').hide();
      $('.cursoSelect').show();
      $("#cursoSelect").attr('required', 'true');
      $("#cursoSelect").attr('name', 'st_curso');
      $("#cursoInput").removeAttr('required', 'true');
      $("#cursoInput").removeAttr('name', 'true');
      $("#st_tipo").removeAttr('required', 'true');

   }else if(valor == 'FORMACAO'){
      $("#st_tipo").empty();
      $("#cursoSelect").empty();
      $("#cursoInput").empty();
      $('.tipo').hide();
      $('.cursoInput').hide();
      $("#cursoSelect").append('<option value="">Selecione</option>') 
      $("#cursoSelect").append('<option value="CFP">CFP</option>') 
      $("#cursoSelect").append('<option value="CFC">CFC</option>') 
      $("#cursoSelect").append('<option value="CFS">CFS</option>') 
      $("#cursoSelect").append('<option value="CFO">CFO</option>') 
      $("#cursoSelect").append('<option value="CFSD">CFSD</option>')
      $("#cursoSelect").append('<option value="CHO">CHO</option>') 
      $("#cursoSelect").append('<option value="CNP">CNP</option>') 
      $("#cursoSelect").append('<option value="EHS">EHS</option>') 
      $('.cursoSelect').show();
      $("#cursoSelect").attr('required', 'true');
      $("#cursoSelect").attr('name', 'st_curso');
      $("#cursoInput").removeAttr('required', 'true');
      $("#cursoInput").removeAttr('name', 'true');
      $("#st_tipo").removeAttr('required', 'true');
   }else{
      $("#st_tipo").empty();
      $('.tipo').hide();
      $("#cursoSelect").empty();
      $("#cursoInput").empty();
      $('.cursoInput').show();
      $('.cursoSelect').hide();
      $("#cursoInput").attr('required', 'true');
      $("#cursoInput").attr('name', 'st_curso');
      $("#cursoSelect").removeAttr('required', 'true');
      $("#cursoSelect").removeAttr('name', 'true');
      $("#st_tipo").removeAttr('required', 'true');
   }
   


});

/* ------------------------------------------------------------ */