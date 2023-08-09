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

$dadosXls .= " <th>Post. Graduação</th>";
$dadosXls .= " <th>Unidade</th>";
$dadosXls .= " <th>Nome</th>";
$dadosXls .= " <th>Matricula</th>";
$dadosXls .= " <th>Data de Nascimento</th>";
$dadosXls .= " <th>CID</th>";
$dadosXls .= " </tr>"; 


//varremos o array com o foreach para pegar os dados 
if(isset($dados) && count($dados) > 0){
foreach($dados as $a){ 

    $dt_nascimento = \Carbon\Carbon::parse($a->dt_nascimento)->format('d/m/Y');
    $dadosXls .= " <tr>";
    $dadosXls .= " <td>".$a->st_postograduacao."</td>";
    $dadosXls .= " <td>".$a->st_unidade."</td>";
    $dadosXls .= " <td>".$a->st_nome."</td>";
    $dadosXls .= " <td>".$a->st_matricula."</td>";
    $dadosXls .= " <td>".$dt_nascimento."</td>";
    $dadosXls .= " <td>".$a->st_cid."</td>";

    $dadosXls .= " </tr>"; 
    }
}

    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
$arquivo = "ListaAtendimentoConcluidosJPMS.xls";
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