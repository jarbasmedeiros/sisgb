<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-type" content="text/html;charset=utf-8">
    <meta charset="utf-8">
    <link rel="icon" type="image/PNG" href="{{url('imgs/sesed.PNG')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{url('/imgs/logo2.png')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>{{$titulo or 'SESED'}}</title>

    <link rel='stylesheet' href="{{url('/assets/css/pdf.css')}}">
</head>


<body>
    <?php
    $contador = 0;
        error_reporting(0);                 // Tira mensagem de erro no chrome
        ini_set('display_errors', 0);       // Tira mensagem de erro no chrome
        define('MPDF_PATH', 'class/mpdf/');
        include('mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->SetTitle($nomeTabela);
        $css = "";
        $css = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($css, 1);
        
        $dados_pdf = "";
        $dados_pdf .= "<table class='table table-responsive'>
            <thead>
                <tr>";
                    $dados_pdf .= "<td colspan='8' style='text-align: center;'>" . $nomeTabela . "</td>";
                $dados_pdf .= "</tr>
                <tr>
                    <td style='text-align: center;'>Ordem</td>
                    <td style='text-align: center;'>Posto / Graduação</td>
                    <td style='text-align: center;'>Número de Praça</td>
                    <td style='text-align: center;'>Nome</td>
                    <td style='text-align: center;'>Matrícula</td>
                    <td style='text-align: center;'>CPF</td>
                    <td style='text-align: center;'>Unidade</td>
                    <td style='text-align: center;'>Status</td>               
                </tr>
            </thead>
            <tbody>";
                if(isset($policiais)){
                    foreach($policiais as $p){
                        $contador =  $contador+1;
                        $dados_pdf .= "<tr>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $contador . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $p->st_postograduacaosigla . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $p->st_numpraca . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $p->st_nome . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $p->st_matricula . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $p->st_cpf . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $p->st_unidade . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $status . "</td>";
                        $dados_pdf .= "</tr>";
                    }
                }
            $dados_pdf .= "</tbody>
        </table>";
        $mpdf->WriteHTML($dados_pdf, 2);
        ob_clean();      // Tira mensagem de erro no chrome
        $mpdf->Output();
        exit();
    ?>
</body>

</html> 