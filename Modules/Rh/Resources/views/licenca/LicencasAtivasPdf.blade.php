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
        $mpdf->SetTitle("LISTA DE FÉRIAS ATIVAS");
        $css = "";
        $css = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($css, 1);

        $dados_pdf = "";
        $dados_pdf .= "<table class='table table-responsive'>
            <thead>
                <tr>
                    <th colspan='6'> LISTA DE FÉRIAS ATIVAS </th>
                </tr>
                <tr>
                    <th>NOME DO FUNCIONÁRIO</th>
                    <th>SETOR</th>
                    <th>FUNÇÃO</th>
                    <th>INÍCIO</th>
                    <th>FIM</th>
                    <th>ANO REFERENTE</th>
                </tr>
            </thead>
            <tbody>";
                if(isset($ferias)){
                    foreach($ferias as $fa){
                        $dados_pdf .= "<tr>";
                            $dados_pdf .= "<th>" . $fa->st_nomefuncionario . "</th>";
                            $dados_pdf .= "<th>" . $fa->st_siglasetor . "</th>";
                            $dados_pdf .= "<th>" . $fa->st_funcao . "</th>";
                            foreach($fa->campos as $key => $valor){
                                if($valor->st_nomeitem == 'Início'){
                                    $dados_pdf .= "<th>" . \Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y') . "</th>";
                                }
                                if($valor->st_nomeitem == 'Fim'){
                                    $dados_pdf .= "<th>" . \Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y') . "</th>";
                                }
                                if($valor->st_nomeitem == 'Referente'){
                                    $dados_pdf .= "<th>" . $valor->st_valor . "</th>";
                                }
                            }
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