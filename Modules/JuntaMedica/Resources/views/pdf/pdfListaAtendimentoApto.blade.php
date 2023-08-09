<html lang="pt-BR">

<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
</head>


<body>
    <!-- RESPONSIVE TABLE -->
    <?php  //declaramos uma variavel para montarmos a tabela
    error_reporting(0);                 // Tira mensagem de erro no chrome
    ini_set('display_errors', 0);       // Tira mensagem de erro no chrome
    define('MPDF_PATH', 'class/mpdf/');
    include('mpdf/mpdf.php');
    $mpdf = new mPDF('c', 'A4-L');
    $css = "";
    $css = file_get_contents('assets/css/pdf_atendimento_JPMS.css');
    $mpdf->WriteHTML($css, 1);
    setlocale(LC_TIME, 'portuguese'); //Converte a data para o padrão BR
    date_default_timezone_set('America/Sao_Paulo'); //define o local da data
    
    $header = "";
    $dados_pdf = "";
    $dados_pdf .= "
                <div class='col-md-6'>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " alt='logo'/>
                    </div>
                    <div class='cab-corpo-apto'>
                        RIO GRANDE DO NORTE<br/>
                        SECRETARIA DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL<br/>
                        POLÍCIA MILITAR<br/>
                        DIRETORIA DE SAÚDE<br/>
                        <b><u> JUNTA POLICIAL MILITAR DE SAÚDE </u></b><br/><br/>
                    </div>
                    <div class='cx-texto'>
                        <div class='m-5'>
                            Natal-RN, ______/______/______<br/>
                            Do TC PM Méd Presidente da JPMS<br/>
                            Ao Cmt:<br/>
                            Assunto: Apresentação de PM APTO<br/>
                            ao trabalho.
                        </div>
                    </div>
                    <div class='targeta-parecer-apto'>
                        <b> APTO AO TRABALHO </b>
                    </div>
                        Memorando S/Nº/" .strftime('%Y'). " - JPMS <br/><br/>
                    <div style='text-align: justify; text-indent: 1.25cm;'>
                        Através deste dou ciência a V. Sº., que o Militar " .$atendimento->st_nome. ", Matrícula " .$atendimento->st_matricula. "
                        está <span style='font-weight:bold;'>APTO ao trabalho, </span> a partir de "
                        .\Carbon\Carbon::parse($atendimento->dt_parecer)->format('d/m/Y'). " sem restrições e devidamente orientado a 
                        apresentar-se à sua unidade de origem <span style='font-weight:bold;'>no prazo MÁXIMO de 24 horas.</span> 
                    </div>
                    <div class='cx-texto-inferior'>
                        <div style='margin: 15px'>
                            Recebi o original em: _____/_____/_____ <br/><br/>
                            Ass. do Militar ____________________
                        </div>
                    </div>
                    <div class='direita'>
                        <br/><br><br><br>
                        ______________________________ <br/>
                        Carimbo e Assinatura do Médico
                    </div>
                </div>
                ";

    $footer = "<div class='col-md-6'><div>___________________________________________________________________________________________<br>
                                        Junta Policial Militar de Saúde em Natal / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " em " . date('d/m/Y - H:m:s') . "</div>";
    // $mpdf->SetHeader($header);
    $mpdf->defaultfooterline=0;
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output("$atendimento->st_nome - Parecer Apto - JPMS.pdf", \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 