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
                    $dados_pdf .= "<th colspan='8' style='text-align: center;'>" . $nomeTabela . "</th>";
                $dados_pdf .= "</tr>
                <tr>
                    <th style='text-align: center;'>Nome</th>
                    <th style='text-align: center;'>Matrícula</th>
                    <th style='text-align: center;'>Qtd de Dias</th>
                    <th style='text-align: center;'>Início</th>
                    <th style='text-align: center;'>Fim</th>
                    <th style='text-align: center;'>Referente ao Ano</th>              
                </tr>
            </thead>
            <tbody>";
                if(isset($ferias)){
                    foreach($ferias as $f){
                        $dt_inicio = \Carbon\Carbon::parse($f->dt_inicio)->format('d/m/Y');
                        $dt_fim = \Carbon\Carbon::parse($f->dt_fim)->format('d/m/Y');
                        $dados_pdf .= "<tr>";
                            $dados_pdf .= "<th style='text-align: center;'>" . $f->st_nome . "</th>";
                            $dados_pdf .= "<th style='text-align: center;'>" . $f->st_matricula . "</th>";
                            $dados_pdf .= "<th style='text-align: center;'>" . $f->nu_dias . "</th>";
                            $dados_pdf .= "<th style='text-align: center;'>" . $dt_inicio . "</th>";
                            $dados_pdf .= "<th style='text-align: center;'>" . $dt_fim . "</th>";
                            $dados_pdf .= "<th style='text-align: center;'>" . $f->nu_ano . "</th>";
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