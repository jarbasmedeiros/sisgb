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
                        <b> RESTRIÇÃO </b>
                    </div>
                    <div>
                        <b> NOME: </b>" .$atendimento->st_nome. " <br>
                        <b> MATRÍCULA: </b>" .$atendimento->st_matricula. " 
                        <p>";
                            if ($atendimento->st_parecer == "APTO COM RESTRIÇÃO") {
                                $dados_pdf .= "Apto para a atividade administrativa, "; 
                                if ($restricoes != "") {
                                    $dados_pdf .= "com restrição de " .$restricoes;
                                }
                                $dados_pdf .= " por " .$atendimento->nu_dias. "
                                dias a contar de " .\Carbon\Carbon::parse($atendimento->dt_inicio)->format('d/m/Y'). ". Retornar a JPMS em " 
                                .\Carbon\Carbon::parse($atendimento->dt_termino)->format('d/m/Y'). ".";
                            } elseif ($atendimento->st_parecer == "APTO COM RESTRIÇÃO (EM DEFINITIVO)") {
                                $dados_pdf .= "Apto para a atividade administrativa, "; 
                                if ($restricoes != "") {
                                    $dados_pdf .= "com restrição de " .$restricoes;
                                }
                                $dados_pdf .= " em definitivo. ";
                            }
    $dados_pdf .= "     </p> 
                        <b> OBS: </b>
                        <ol>
                            <li> Atestados médicos <b>A PARTIR DE 15 DIAS, </b> os militares devem apresentar-se de
                            <b>IMEDIATO </b> ao <b>Presidente da Comissão
                            Multidisciplinar </b> para o <b>visto e orientação.</b> </li>
                            <li> Apresentar-se de <b>IMEDIATO ao Comandante da OPM </b> para o visto e orientação
                            sobre o expediente. </li>
                            <li> A falta do visto implicará em <b>'NÃO atendimento' </b> no retorno. </li>
                            <li> Dias de Junta Médica - 2ª, 4ª e 5ª feira às 07:00h. </li>
                            <li> Por determinação do Diretor de Saúde, o <b>NÃO COMPARECIMENTO </b> ao expediente
                            diário do militar acima mencionado será de inteira responsabilidade do 
                            <b>SEU COMANDANTE.</b> </li>
                        </ol>
                    </div>
                    <div class='esquerda'>
                        <b>VISTO </b> <br>
                        Em _____/_____/_____ <br><br>
                        __________________ <br>
                        CMT DA OPM <br>
                        (carimbo e assinatura) <br>
                    </div>
                    <div class='direita'>
                        DS em Natal-RN, _____/_____/_____ <br><br><br>
                        ____________________________________ <br>
                        Carimbo e Assinatura do Médico
                    </div>
                    <div class='linha'>
                        - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    </div>
                    <div class='cx-texto-CMAPM'>
                        <div class='m-5'>
                            * Após o término dessa licença médica, o policial militar 
                            <span style='font-weight:bold;'>deverá comparecer</span> a esta JPMS para a avaliação 
                            pericial. O <span style='font-weight:bold;'> não comparecimento</span> dessa demanda, 
                            acarretará no <span style='font-weight:bold;'>término</span> da licença em vigor e nas 
                            <span style='font-weight:bold;'>providências administrativas cabíveis.</span> 
                        </div>
                    </div>
                    <div class='direita-visto'>
                        <b> VISTO </b> <br>
                        Em _____/_____/_____ <br><br>
                        _________________________ <br>
                        Presidente da CMAPM <br>
                        (carimbo e assinatura) 
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
    $mpdf->Output("$atendimento->st_nome - Parecer Apto com Restrição - JPMS.pdf", \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 