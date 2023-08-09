<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    </head>   
    <body>
<?php //declaramos uma variavel para monstarmos a tabela 
if(isset($dados)) {
   
}
$dadosXls = ""; 
$dadosXls .= " <table border='1' >"; 
$dadosXls .= " <tr>"; 

$dadosXls .= " <th>Post/Grad</th>";
$dadosXls .= " <th>Num/Praça</th>";
$dadosXls .= " <th>Nome</th>";
$dadosXls .= " <th>Matrícula</th>";
if($dados['st_tipo'] == 'ferias'){
    $dadosXls .= " <th>Qtd de Dias</th>";
    $dadosXls .= " <th>Início</th>";
    $dadosXls .= " <th>Fim</th>";
    $dadosXls .= " <th>Referente ao Ano</th>";
}elseif($dados['st_tipo'] == 'licenca'){
    $dadosXls .= " <th>Qtd de Dias</th>";
    $dadosXls .= " <th>Início</th>";
    $dadosXls .= " <th>Fim</th>";
    $dadosXls .= " <th>Tipo</th>";
}else{
    $dadosXls .= " <th>Unidade</th>";
}

$dadosXls .= " </tr>"; 

//varremos o array com o foreach para pegar os dados 
foreach($consulta as $res){ 
    if($dados['st_tipo'] == 'ferias' || $dados['st_tipo'] == 'licenca'){
        $dt_inicio = \Carbon\Carbon::parse($res->dt_inicio)->format('d/m/Y');
        $dt_fim = \Carbon\Carbon::parse($res->dt_fim)->format('d/m/Y');
    }
    $dadosXls .= " <tr>";
   
    $dadosXls .= " <td>".$res->st_postograduacaosigla."</td>";
    $dadosXls .= " <td>".$res->st_numpraca."</td>";
    $dadosXls .= " <td>".$res->st_nome."</td>";
    $dadosXls .= " <td>".$res->st_matricula."</td>";
    if($dados['st_tipo'] == 'ferias'){
    $dadosXls .= " <td>".$res->nu_dias."</td>";
    $dadosXls .= " <td>".$dt_inicio."</td>";
    $dadosXls .= " <td>".$dt_fim."</td>"; 
    $dadosXls .= " <td>".$res->nu_ano."</td>"; 
    }elseif($dados['st_tipo'] == 'licenca'){
        $dadosXls .= " <td>".$res->nu_dias."</td>";
    $dadosXls .= " <td>".$dt_inicio."</td>";
    $dadosXls .= " <td>".$dt_fim."</td>"; 
    $dadosXls .= " <td>".$res->st_tipoLicenca."</td>";  
    }else{
        $dadosXls .= " <td>".$res->st_unidade."</td>";  
    }
     
    $dadosXls .= " </tr>"; }
    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
$arquivo = "Ferias.xls";
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