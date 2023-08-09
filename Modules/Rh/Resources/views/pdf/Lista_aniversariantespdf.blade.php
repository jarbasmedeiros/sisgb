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
        $mpdf->SetTitle($titulo);
        $css = "";
        $css = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($css, 1);
        
        $dados_pdf = "";
        $dados_pdf .= "<table class='table table-responsive'>          
            <thead>
                <tr>";
                    $dados_pdf .= "<th  colspan='5'>" . $titulo . "</th>";
                $dados_pdf .= "</tr>
                <tr>
                    <th >POSTO/GRAD.</th>
                    <th >NOME</th>
                    <th>SETOR</th>
                    <th >DIA</th>
                    <th >MÊS</th>
                </tr>
            </thead>
            <tbody>";
                if(isset($an)){
                    foreach($an as $a){
                        $dados_pdf .= "<tr>";
                            $dados_pdf .= "<th>" . $a->st_postograduacao . "</th>";
                            $dados_pdf .= "<th>" . $a->st_nome . "</th>";
                            $dados_pdf .= "<th>" . $a->st_sigla . "</th>";
                            $dados_pdf .= "<th>" . $a->dia . "</th>";
                            $dados_pdf .= "<th>" . $a->mes . "</th>";
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
