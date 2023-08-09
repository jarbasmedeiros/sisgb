<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    </head>   
    <body>
<?php //declaramos uma variavel para monstarmos a tabela 

use App\utis\Funcoes;

$dadosXls = ""; 
$dadosXls .= " <table border='1' >"; 
$dadosXls .= " <tr>"; 

$dadosXls .= " <th>Posto/Graduação</th>";
$dadosXls .= " <th>Nome</th>";
$dadosXls .= " <th>Matrícula</th>";
$dadosXls .= " <th>Nº Praça</th>";
$dadosXls .= " <th>Nascimento</th>";
$dadosXls .= " <th>Última Promoção</th>";
$dadosXls .= " <th>Parecer</th>"; 
$dadosXls .= " <th>Pontuação</th>"; 

$dadosXls .= " </tr>"; 

$func = new Funcoes();

//varremos o array com o foreach para pegar os dados 
foreach($policiais as $policial){
    
    $dadosXls .= " <tr>";
   
    $dadosXls .= " <td>".$policial->st_postgrad."</td>";
    $dadosXls .= " <td>".$policial->st_policial."</td>";
    $dadosXls .= " <td>".$func->mask($policial->st_matricula, '###.###-#')."</td>"; 
    $dadosXls .= " <td>".$func->mask($policial->st_numpraca, '####-####')."</td>";  
    $dadosXls .= " <td>".$func->converterDataFormatoBr($policial->dt_nascimento)."</td>"; 
    $dadosXls .= " <td>".$func->converterDataFormatoBr($policial->dt_ultimapromocao)."</td>"; 
    $dadosXls .= " <td>".$policial->st_parecerrecurso."</td>"; 
    $dadosXls .= " <td>".$policial->vl_pontosvalidosdopm."</td>"; 
         
    $dadosXls .= " </tr>"; }
    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
$arquivo = 'Policiais_recorreram_QA.xls';
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