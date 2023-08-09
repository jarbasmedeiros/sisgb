
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
        $dadosXls .= " <td>POST/GRAD</td>";
            $dadosXls .= " <td>NOME</td>";
            $dadosXls .= " <td>MATRÍCULA</td>";
            $dadosXls .= " <td>UNIDADE</td>";
            $dadosXls .= " <td>TIPO</td>";
            $dadosXls .= " <td>MEDELHAS</td>";
            $dadosXls .= " <td>DATA DA MEDALHA</td>";
            $dadosXls .= " <td>PUBLICAÇÃO</td>";
            $dadosXls .= " <td>DATA DA PUBLICAÇÃO</td>";
        $dadosXls .= " </tr>";
        //incluimos nossa conexão include_once('Conexao.class.php'); 
        //instanciamos $pdo = new Conexao(); 
        //mandamos nossa query para nosso método dentro de conexao dando um return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        //$result = $pdo->select("SELECT id,nome,email FROM cadastro"); 
        //varremos o array com o foreach para pegar os dados 
        foreach($medalhas as $m){
            $dadosXls .= " <tr>";
               
                     $dadosXls .= " <td> ".$m->st_postograduacaosigla ."</td>";
                    $dadosXls .= " <td> ".$m->st_nome ."</td>";
                    $dadosXls .= " <td> ".$m->st_matricula ."</td>";
                    $dadosXls .= " <td> ".$m->st_unidade ."</td>";
                    $dadosXls .= " <td> ".$m->st_tipo ."</td>";
                    $dadosXls .= " <td> ".$m->st_nomeMedalha ."</td>";
                    if(!empty($m->dt_medalha)){
                        $dadosXls .= " <td>" . \Carbon\Carbon::parse($m->dt_medalha)->format('d/m/Y') . "</td>";
                    }else{
                        $dadosXls .= " <td> ".$m->dt_medalha ."</td>";
                    }
                    $dadosXls .= " <td> ".$m->st_publicacao ."</td>";
                    if(!empty($m->dt_publicacao)){
                        $dadosXls .= " <td>" . \Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y') . "</td>";
                    }else{
                        $dadosXls .= " <td> ".$m->dt_publicacao ."</td>";
                    }
            $dadosXls .= " </tr>";
        }
        $dadosXls .= " </table>"; 
        // Definimos o nome do arquivo que será exportado 
        $arquivo = "Medalhas.xls";
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