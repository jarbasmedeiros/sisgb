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
                    <div class='cab-corpo-restricao'>
                        RIO GRANDE DO NORTE<br/>
                        SECRETARIA DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL<br/>
                        POLÍCIA MILITAR<br/>
                        DIRETORIA DE SAÚDE<br/>
                        <b><u>JUNTA POLICIAL MILITAR DE SAÚDE</u></b><br/><br/>
                    </div>
                    <div class='targeta-parecer'>
                        <b> LICENÇA TOTAL </b>
                    </div>
                    <div>
                        <p>
                            <b> NOME: </b>" .$atendimento->st_nome. ", 
                            <b> MATRÍCULA: </b>" .$atendimento->st_matricula. ", 
                            necessita de " .$atendimento->nu_dias. " dias de licença para tratamento de saúde 
                            a contar de " .\Carbon\Carbon::parse($atendimento->dt_inicio)->format('d/m/Y'). ". Retornar a JPMS em " 
                            .\Carbon\Carbon::parse($atendimento->dt_termino)->format('d/m/Y'). ". <br/><br/>
                        </p>
                        <div class='text-center'>
                            <b> ORIENTAÇÕES APÓS RECEBIMENTO DA GUIA DA LICENÇA MÉDICA </b>
                        </div>
                        <ol>
                            <li> Atestados médicos <b>A PARTIR DE 15 DIAS, </b> os militares devem apresentar-se de
                            <b>IMEDIATO </b> ao <b>Presidente da Comissão
                            Multidisciplinar </b> para o <b>visto e orientação.</b> </li>
                            <li> Apresentar-se de <b>IMEDIATO ao Comandante da OPM </b> para o visto e orientação
                            sobre o repouso. </li>
                            <li> A falta do visto implicará em <b>'NÃO atendimento' </b> no retorno. </li>
                            <li> Dias de Junta Médica - 2ª, 4ª e 5ª feira às 07:00h. </li>
                        </ol><br>
                    </div>
                    <div class='esquerda'>
                        <b>VISTO </b> <br/>
                        Em _____/_____/_____ <br/><br/><br>
                        ____________________ <br/>
                        CMT DA OPM <br/>
                        (carimbo e assinatura) <br/>
                    </div>
                    <div class='direita'>
                        DS em Natal-RN, _____/_____/_____ <br/><br/><br/><br>
                        ____________________________________ <br/>
                        Carimbo e Assinatura do Médico
                    </div>
                    <div class='linha'>
                        - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    </div>
                    <div class='cx-texto-CMAPM'>
                        <div class='m-5'>
                            * Após o término dessa licença médica, o policial militar 
                            <b>deverá comparecer</b> a esta JPMS para a avaliação 
                            pericial. O <b> não comparecimento</b> dessa demanda, 
                            acarretará no <b>término</b> da licença em vigor e nas 
                            <b>providências administrativas cabíveis.</b> 
                        </div>
                    </div>
                    <div class='direita-visto'>
                        <b>VISTO </b> <br/>
                        Em _____/_____/_____ <br/><br/><br>
                        _________________________ <br/>
                        Presidente da CMAPM <br/>
                        (carimbo e assinatura) <br/>
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
    $mpdf->Output("$atendimento->st_nome - Parecer Licença Total - JPMS.pdf", \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 