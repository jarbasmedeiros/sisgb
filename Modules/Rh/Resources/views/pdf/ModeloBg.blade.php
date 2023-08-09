<html lang="pt-BR">

<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
.borda {
border: 1px solid;
}
.head {
border: 1px solid;
background: #8B8989;
text-align: center;
}
.cabecalho{
	text-align: center;
	border: 1px solid;
}


</style>
</head>


<body>
    <!-- RESPONSIVE TABLE -->
    <?php  //declaramos uma variavel para montarmos a tabela
    error_reporting(0);                 // Tira mensagem de erro no chrome
    ini_set('display_errors', 0);       // Tira mensagem de erro no chrome
    define('MPDF_PATH', 'class/mpdf/');
    include('mpdf/mpdf.php');
    $mpdf = new mPDF();
    $css = "";
    $css = file_get_contents('assets/css/fichapdf.css');
    $mpdf->WriteHTML($css, 1);
    
   
    $header = "";
    $dados_pdf = "";
    $dados_pdf .= "<div class='box borda'>
	                <div class='row'>
                        <div class='col-md-12'>".$texto."</div>
                    </div>
                </div>";
                
   


    $dados_pdf .= "</table>";
    $footer = "";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s') . " - " . "Pag. {PAGENO} / {nb}";
    // $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output();
    exit();
    ?>

</body>

</html> 