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

$dadosXls .= " <th>Ordem</th>";
$dadosXls .= " <th>Posto / Graduação</th>";
$dadosXls .= " <th>Número de Praça</th>";
$dadosXls .= " <th>Nome</th>";
$dadosXls .= " <th>Matrícula</th>";
$dadosXls .= " <th>CPF</th>";
$dadosXls .= " <th>Unidade</th>"; 
$dadosXls .= " <th>Status</th>"; 

$dadosXls .= " </tr>"; 
$contador = 0;
//varremos o array com o foreach para pegar os dados 
foreach($policiais as $res){ 
    $contador = $contador+1;
    $dadosXls .= " <tr>";
   
 
    $dadosXls .= " <td>".$contador ."</td>";
    $dadosXls .= " <td>".$res->st_postograduacaosigla."</td>";
    $dadosXls .= " <td>".$res->st_numpraca."</td>";
    $dadosXls .= " <td>".$res->st_nome."</td>";
    $dadosXls .= " <td>".$res->st_matricula."</td>"; 
    $dadosXls .= " <td>".$res->st_cpf."</td>"; 
    $dadosXls .= " <td>".$res->st_unidade."</td>"; 
    $dadosXls .= " <td>".$status."</td>"; 
         
    $dadosXls .= " </tr>"; }
    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
$arquivo = "Policiais.xls";
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