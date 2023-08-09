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

$dadosXls .= " <th>Nome do Funcionário</th>";
$dadosXls .= " <th>Matricula</th>";
$dadosXls .= " <th>Setor</th>";
$dadosXls .= " <th>Função</th>";
$dadosXls .= " <th>Órgão</th>"; 
$dadosXls .= " <th>Início</th>"; 
$dadosXls .= " <th>Fim</th>";
if($tiporegistro == 1){
    $dadosXls .= " <th>Ano Referente</th>"; 
}

$dadosXls .= " </tr>"; 
//incluimos nossa conexão include_once('Conexao.class.php'); 
//instanciamos $pdo = new Conexao(); 
//mandamos nossa query para nosso método dentro de conexao dando um return $stmt->fetchAll(PDO::FETCH_ASSOC); 
//$result = $pdo->select("SELECT id,nome,email FROM cadastro"); 
//varremos o array com o foreach para pegar os dados 
foreach($listRegistros as $r){ 
    $dadosXls .= " <tr>";
   
    $dadosXls .= " <td>".$r->st_nomefuncionario."</td>";
    $dadosXls .= " <td>".$r->st_matricula."</td>";
    $dadosXls .= " <td>".$r->st_siglasetor."</td>";
    $dadosXls .= " <td>".$r->st_funcao."</td>";
    $dadosXls .= " <td>".$r->st_orgao."</td>";
    foreach($r->listRegistros as $key => $valor) {
        if($valor->st_nomeitem == 'Início'){
            $dadosXls .= " <td>" . \Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y') . "</td>"; 
        }
        if($valor->st_nomeitem == 'Fim'){
            $dadosXls .= " <td>" . \Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y') . "</td>";
        }
        if($valor->st_nomeitem == 'Referente'){
            $dadosXls .= " <td>".$valor->st_valor."</td>";
        }
    }     
    $dadosXls .= " </tr>"; }
    $dadosXls .= " </table>"; 
// Definimos o nome do arquivo que será exportado 
if($tiporegistro == 1){
    $arquivo = "Férias.xls";
}
if($tiporegistro == 2){
    $arquivo = "Licenças.xls";
}

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