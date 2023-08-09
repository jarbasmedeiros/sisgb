<!DOCTYPE html>
<html lang="en">

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
    <?php  //declaramos uma variavel para monstarmos a tabela
    error_reporting(0);                 // Tira mensagem de erro no chrome
    ini_set('display_errors', 0);       // Tira mensagem de erro no chrome
    define('MPDF_PATH', 'class/mpdf/');
    include('mpdf/mpdf.php');
    $mpdf = new mPDF();
    $css = file_get_contents('assets/css/pdf.css');
    $mpdf->WriteHTML($css, 1);

    $dados_pdf = "";
    $dados_pdf .= " <table class='table table-responsive' >";
        $dados_pdf .= "<thead>";
            $dados_pdf .= " <tr>";
                if($tiporegistro == 1){
                    $dados_pdf .= "<th colspan='8'>LISTAGEM DE FÉRIAS</th>";
                } else {
                    $dados_pdf .= "<th colspan='7'>LISTAGEM DE LICENÇAS</th>";
                }
            $dados_pdf .= " </tr>";
            $dados_pdf .= " <tr>";
                $dados_pdf .= " <th>Nome do Funcionário</th>";
                $dados_pdf .= " <th>Matricula</th>";
                $dados_pdf .= " <th>Setor</th>";
                $dados_pdf .= " <th>Função</th>";
                $dados_pdf .= " <th>Órgão</th>";
                $dados_pdf .= " <th>Início</th>";
                $dados_pdf .= " <th>Fim</th>";
                if ($tiporegistro == 1) {
                    $dados_pdf .= " <th>Ano Referente</th>";
                }
            $dados_pdf .= " </tr>";
        $dados_pdf .= "</thead>";
        $dados_pdf .= "<tbody>";
            foreach ($listRegistros as $r) {
                $dados_pdf .= " <tr>";
                $dados_pdf .= " <td>" . $r->st_nomefuncionario . "</td>";
                $dados_pdf .= " <td>" . $r->st_matricula . "</td>";
                $dados_pdf .= " <td>" . $r->st_siglasetor . "</td>";
                $dados_pdf .= " <td>" . $r->st_funcao . "</td>";
                $dados_pdf .= " <td>" . $r->st_orgao . "</td>";
                foreach ($r->listRegistros as $key => $valor) {
                    if ($valor->st_nomeitem == 'Início') {
                        $dados_pdf .= " <td>" . \Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y') . "</td>";
                    }
                    if ($valor->st_nomeitem == 'Fim') {
                        $dados_pdf .= " <td>" . \Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y') . "</td>";
                    }
                    if ($valor->st_nomeitem == 'Referente') {
                        $dados_pdf .= " <td>" . $valor->st_valor . "</td>";
                    }
                }
                $dados_pdf .= " </tr>";
            }
        $dados_pdf .= "</tbody>";
    $dados_pdf .= " </table>";

    echo $dados_pdf;
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output();
    exit();
    ?>

</body>

</html> 