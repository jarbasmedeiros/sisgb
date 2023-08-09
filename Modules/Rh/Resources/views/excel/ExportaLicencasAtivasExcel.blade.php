<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    </head>   
    <body>
<?php //declaramos uma variavel para monstarmos a tabela 
$dadosXls = ""; 
$dadosXls .= " <table border='1' >"; 
$dadosXls .= " <tr>"; 

$dadosXls .= " <th>POST/GRAD</th>";
$dadosXls .= " <th>NOME</th>";
$dadosXls .= " <th>MATRÍCULA</th>";
$dadosXls .= " <th>TIPO</th>";
$dadosXls .= " <th>QTD DIAS</th>";
$dadosXls .= " <th>INÍCIO</th>";
$dadosXls .= " <th>FIM</th>";

$dadosXls .= " </tr>"; 

//varremos o array com o foreach para pegar os dados 
foreach($licencas as $l){ 
   
    $dt_inicio = \Carbon\Carbon::parse($l->dt_inicio)->format('d/m/Y');
    $dt_fim = \Carbon\Carbon::parse($l->dt_fim)->format('d/m/Y');
    
    $dadosXls .= " <tr>";
   
    $dadosXls .= " <td>".$l->st_postograduacaosigla."</td>";
    $dadosXls .= " <td>".$l->st_nome."</td>";
    $dadosXls .= " <td>".$l->st_matricula."</td>";
    $dadosXls .= " <td>".$l->st_tipoLicenca."</td>";
    $dadosXls .= " <td>".$l->nu_dias."</td>";
    $dadosXls .= " <td>".$dt_inicio."</td>"; 
    $dadosXls .= " <td>".$dt_fim."</td>"; 
     
    $dadosXls .= " </tr>"; }
    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
$arquivo = "Licenças.xls";
// Configurações header para forçar o download 
 header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
 header('Content-Disposition: attachment;filename="'.$arquivo.'"');
 header('Cache-Control: max-age=0');
 // Se for o IE9, isso talvez seja necessário 
 // header('Cache-Control: max-age=1'); 
  // Envia o conteúdo do arquivo 
  echo $dadosXls; exit; ?>

    </body>
</html>