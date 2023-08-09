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

                                    
$dadosXls .= " <th>NOME</th>";
$dadosXls .= " <th>POST/GRAD</th>";
$dadosXls .= " <th>MATRÍCULA</th>";
$dadosXls .= " <th>CIA</th>";
$dadosXls .= " <th>PARECER</th>";
$dadosXls .= " <th>RESTRIÇÕES</th>";
$dadosXls .= " <th>OBS</th>";

$dadosXls .= " </tr>"; 
//varremos o array com o foreach para pegar os dados 
foreach($sessao->atendimentosMedicos as $a){ 

    
    $dadosXls .= " <tr>";
    $dadosXls .= " <td>".$a->st_nome."</td>";
    $dadosXls .= " <td>".$a->st_postograduacao."</td>";
    $dadosXls .= " <td>".$a->st_matricula."</td>";
    $dadosXls .= " <td>".$a->st_unidade."</td>";
    $dadosXls .= " <td>".$a->st_parecer."</td>";
    $restricoesAtendimento = null;
    if(isset($a->restricoes) && count($a->restricoes) > 0){
        foreach($a->restricoes as $r){
            $restricoesAtendimento .= $r->st_restricao.' ,';
        }
        
    }
    
    $dadosXls .= " <td>".$restricoesAtendimento."</td>"; 
    $dadosXls .= " <td>".$a->st_obs."</td>"; 
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