
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
            $dadosXls .= " <td>INICIO</td>";
            $dadosXls .= " <td>FIM</td>";
            $dadosXls .= " <td>QTD/DIAS</td>";
        $dadosXls .= " </tr>";
        //incluimos nossa conexão include_once('Conexao.class.php'); 
        //instanciamos $pdo = new Conexao(); 
        //mandamos nossa query para nosso método dentro de conexao dando um return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        //$result = $pdo->select("SELECT id,nome,email FROM cadastro"); 
        //varremos o array com o foreach para pegar os dados 
        foreach($licencas as $l){
            $dadosXls .= " <tr>";
               
                     $dadosXls .= " <td> ".$l->st_postograduacaosigla ."</td>";
                    $dadosXls .= " <td> ".$l->st_nome ."</td>";
                    $dadosXls .= " <td> ".$l->st_matricula ."</td>";
                    $dadosXls .= " <td> ".$l->st_unidade ."</td>";
                    $dadosXls .= " <td> ".$l->st_tipoLicenca ."</td>";
                    if(!empty($l->dt_inicio)){
                        $dadosXls .= " <td>" . \Carbon\Carbon::parse($l->dt_inicio)->format('d/m/Y') . "</td>";
                    }else{
                        $dadosXls .= " <td> ".$l->dt_inicio ."</td>";
                    }
                    if(!empty($l->dt_fim)){
                        $dadosXls .= " <td>" . \Carbon\Carbon::parse($l->dt_fim)->format('d/m/Y') . "</td>";
                    }else{
                        $dadosXls .= " <td> ".$l->dt_fim ."</td>";
                    }
                    $dadosXls .= " <td> ".$l->nu_dias ."</td>";
            $dadosXls .= " </tr>";
        }
        $dadosXls .= " </table>"; 
        // Definimos o nome do arquivo que será exportado 
        $arquivo = "Licencas.xls";
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