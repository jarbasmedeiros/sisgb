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

$dadosXls .= " <th>Sigla</th>";
$dadosXls .= " <th>Número Praça</th>";
$dadosXls .= " <th>Matrícula</th>";
$dadosXls .= " <th>CPF</th>";
$dadosXls .= " <th>Nome</th>"; 
$dadosXls .= " </tr>"; 

//varremos o array com o foreach para pegar os dados 
if(isset($policiaisEmAcompanhamento) && count($policiaisEmAcompanhamento) > 0){
foreach($policiaisEmAcompanhamento as $a){ 
    $dadosXls .= " <tr>";
    $dadosXls .= " <td>".$a->st_postograduacaosigla."</td>";
    $dadosXls .= " <td>".$a->st_numpraca."</td>";
    $dadosXls .= " <td>".$a->st_matricula."</td>";
    $dadosXls .= " <td>".$a->st_cpf."</td>";
    $dadosXls .= " <td>".$a->st_nome."</td>";
    $dadosXls .= " </tr>"; 
    }
}

    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
$arquivo = "ListaPoliciaisEmAcompanhamentoJPMS.xls";
// Configurações header para forçar o download 
 header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
 header('Content-Disposition: attachment;filename="'.$arquivo.'"');
 header('Cache-Control: max-age=0');
 // Se for o IE9, isso talvez seja necessário 
 header('Cache-Control: max-age=1'); 
  // Envia o conteúdo do arquivo 
  echo $dadosXls; exit; ?>

    </body>
</html>