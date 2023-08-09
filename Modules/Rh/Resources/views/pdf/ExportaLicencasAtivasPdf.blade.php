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
                    <td style='text-align: center;'>ORD</td>
                    <td style='text-align: center;'>PPOS/GRAD</td>
                    <td style='text-align: center;'>NOME</td>
                    <td style='text-align: center;'>MATRÍCULA</td>
                    <td style='text-align: center;'>TIPO</td>
                    <td style='text-align: center;'>QTD DIAS</td>
                    <td style='text-align: center;'>INÍCIO</td>
                    <td style='text-align: center;'>FIM</td>              
                </tr>
            </thead>
            <tbody>";
                if(isset($licencas)){
                    foreach($licencas as $l){
                        $contador = $contador+1;
                        $dt_inicio = \Carbon\Carbon::parse($l->dt_inicio)->format('d/m/Y');
                        $dt_fim = \Carbon\Carbon::parse($l->dt_fim)->format('d/m/Y');
                        $dados_pdf .= "<tr>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $contador . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $l->st_postograduacaosigla . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $l->st_nome . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $l->st_matricula . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $l->st_tipoLicenca . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $l->nu_dias . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $dt_inicio . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $dt_fim . "</td>";
                        $dados_pdf .= "</tr>";
                    }
                }
            $dados_pdf .= "</tbody>
        </table>";
        $footer = "Pag. {PAGENO} de {nb}";

                  
        $mpdf->SetFooter($footer);
        $mpdf->WriteHTML($dados_pdf, 2);
        ob_clean();      // Tira mensagem de erro no chrome
        $mpdf->Output();
        exit();
    ?>
</body>

</html>