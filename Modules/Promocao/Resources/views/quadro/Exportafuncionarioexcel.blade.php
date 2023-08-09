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

$dadosXls .= " <th>Nome</th>";
$dadosXls .= " <th>CPF</th>";
$dadosXls .= " <th>Matrícula</th>";
$dadosXls .= " <th>Data de Nascimento</th>"; 
$dadosXls .= " <th>Sexo</th>"; 
$dadosXls .= " <th>Setor</th>"; 
$dadosXls .= " <th>Órgão</th>"; 
$dadosXls .= " <th>Graduação</th>"; 
$dadosXls .= " <th>Gratificação</th>"; 
$dadosXls .= " <th>Função</th>"; 

$dadosXls .= " </tr>"; 
//incluimos nossa conexão include_once('Conexao.class.php'); 
//instanciamos $pdo = new Conexao(); 
//mandamos nossa query para nosso método dentro de conexao dando um return $stmt->fetchAll(PDO::FETCH_ASSOC); 
//$result = $pdo->select("SELECT id,nome,email FROM cadastro"); 
//varremos o array com o foreach para pegar os dados 
foreach($servidores as $res){ 
    $dadosXls .= " <tr>";
   
    $dadosXls .= " <td>".$res->st_nome."</td>";
    $dadosXls .= " <td>".$res->st_cpf."</td>";
    $dadosXls .= " <td>".$res->st_matricula."</td>";
    $dadosXls .= " <td>".$res->dt_nascimento."</td>"; 
    $dadosXls .= " <td>".$res->st_sexo."</td>"; 
    $dadosXls .= " <td>".$res->st_siglasetor."</td>"; 
    $dadosXls .= " <td>".$res->st_siglaorgao."</td>"; 
    $dadosXls .= " <td>".$res->st_postograduacao."</td>"; 
    $dadosXls .= " <td>".$res->st_nomedagratificacao."</td>"; 
    $dadosXls .= " <td>".$res->st_nomedafuncao."</td>"; 
     
    $dadosXls .= " </tr>"; }
    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
$arquivo = "Funcionários.xls";
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