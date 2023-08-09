
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    </head>   
    <body>
        <?php //declaramos uma variavel para monstarmos a tabela 
        $dadosXls = ""; 
        $dadosXls .= " <table>"; 
        $dadosXls .= " <tr>";
        foreach($nome_colunas as $c){ 
            $dadosXls .= " <td>".$colunas->$c."</td>";
        }
        $dadosXls .= " </tr>";
        //incluimos nossa conexão include_once('Conexao.class.php'); 
        //instanciamos $pdo = new Conexao(); 
        //mandamos nossa query para nosso método dentro de conexao dando um return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        //$result = $pdo->select("SELECT id,nome,email FROM cadastro"); 
        //varremos o array com o foreach para pegar os dados 
        foreach($funcionarios as $f){
            $dadosXls .= " <tr>";
            foreach($f as $key => $c){
                if(substr($key, 0, 2) == 'dt' && $c != null) {
                    $dadosXls .= " <td>" . \Carbon\Carbon::parse($c)->format('d/m/Y') . "</td>";
                }else{
                    $dadosXls .= " <td> ".$c ."</td>";
                }
            }
            $dadosXls .= " </tr>";
        }
        $dadosXls .= " </table>"; 
        // Definimos o nome do arquivo que será exportado 
        $arquivo = "Relatorio.xls";
        // Configurações header para forçar o download 
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header('Content-Disposition: attachment;filename="'.$arquivo.'"');
        header('Cache-Control: max-age=0'); 
        // Se for o IE9, isso talvez seja necessário 
        // header('Cache-Control: max-age=1'); 
        // Envia o conteúdo do arquivo 
       print($dadosXls); exit; ?>

    </body>
</html>