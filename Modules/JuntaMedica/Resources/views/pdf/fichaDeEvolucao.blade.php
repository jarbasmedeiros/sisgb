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
    $mpdf = new mPDF('c', 'A4-P');
    $css = "";
    $css = file_get_contents('assets/css/rh/ficha_disciplinar.css');
    $mpdf->WriteHTML($css, 1);
    setlocale(LC_TIME, 'portuguese'); //Converte a data para o padrão BR
    date_default_timezone_set('America/Sao_Paulo'); //define o local da data
    
    $header = ""; 
    $dados_pdf = "";
    $dados_pdf .= "
        <div class='borda'>
            <div class='brasao'>
                <img class='img-responsive' src=" . URL::asset('/imgs/Brasao_RN.png') . " width='60' height='60' alt='logo'/>
            </div>
            <div class='cab-corpo'>
                RIO GRANDE DO NORTE<br/>
                SECRETARIA DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL<br/>
                POLÍCIA MILITAR<br/>
                DIRETORIA DE SAÚDE<br/>
                <b><u>JUNTA POLICIAL MILITAR DE SAÚDE</u></b><br/><br/>
            </div>
            <div class='brasao'>
                <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
            </div>                
            <div class='col-md-12'>
                <div class='head-ficha-evolucao'>
                    FICHA DE EVOLUÇÃO
                </div>
                <div class='titulo-sessao borda1'>
                    IDENTIFICAÇÃO
                </div>
                <div class='col-md-1 borda1'>
                    <div class='titulo-celula' >Posto/Grad </div>
                    $prontuario->st_postograduacao
                </div>
                <div class='col-md-1 borda1'>
                    <div class='titulo-celula' >Número/RE </div> 
                    $prontuario->id
                </div>
                <div class='borda1'>
                    <div class='titulo-celula ' >Nome </div> 
                    $prontuario->st_nome
                </div>
                <div class='borda1 col-md-2'>
                    <div class='titulo-celula ' >Data Nasc. </div>"; 
                    $dados_pdf .= \Carbon\Carbon::parse($prontuario->dt_nascimento)->format('d/m/Y');
$dados_pdf .= "</div>
                <div class='borda1 col-md-2'>
                    <div class='titulo-celula ' >Data Adm. PM </div>"; 
                    $dados_pdf .= \Carbon\Carbon::parse($prontuario->dt_inclusao)->format('d/m/Y');
$dados_pdf .="  </div>
                <div class='borda1'>
                    <div class='titulo-celula ' >BCG de Enc. </div> 
                    Falta saber
                </div>
                <div class='borda1 col-md-12'>
                    <div class='titulo-celula ' >OPM Atual </div> 
                    $prontuario->st_unidade
                </div>
                <div class='borda1 col-md-12'>
                    <div class='titulo-celula ' >End. Atual </div> 
                    $prontuario->st_endereco, $prontuario->st_numeroresidencia, $prontuario->st_bairro, $prontuario->st_cidade, $prontuario->st_ufendereco
                </div>


            <div class='titulo-sessao borda1'>
                ATENDIMENTOS
            </div>";
            if (isset($prontuario->atendimentos) && count($prontuario->atendimentos) > 0) {
                foreach ($prontuario->atendimentos as $atendimento) {
                    $dados_pdf .= "
                    <div class='borda1 col-md-2'>
                        <div class='titulo-celula ' >Sessão </div> 
                        {$atendimento->nu_sequencial} de {$atendimento->nu_ano}
                    </div>
                    <div class='borda1 col-md-2'>
                        <div class='titulo-celula ' >Data </div>"; 
                        $dados_pdf .= \Carbon\Carbon::parse($atendimento->dt_parecer)->format('d/m/Y');
                        $dados_pdf .= "  
                    </div>
                    <div class='borda1 col-md-6'>
                        <div class='titulo-celula ' >Diagnóstico </div> 
                        $atendimento->st_cid
                    </div>
                    <div class='borda1'>
                        <div class='titulo-celula ' >Dias LTS </div> 
                        $atendimento->nu_dias
                    </div>
                    <div class='borda1 col-md-12'>
                        <div class='titulo-celula ' >Parecer Médico </div> 
                        $atendimento->st_parecer
                    </div>
                    <div class='borda1 col-md-2'>
                        <div class='titulo-celula ' >Retorno </div> ";
                            $dados_pdf .= \Carbon\Carbon::parse($atendimento->dt_termino)->format('d/m/Y');
                            $dados_pdf .= " 
                        </div>
                    <div class='borda1'>
                        <div class='titulo-celula ' >Médico Perito </div> 
                        $atendimento->st_perito
                    </div><hr>";
                }
            } else {
                $dados_pdf .= "
                <div class='borda1 col-md-12'>
                    <div class='titulo-celula ' >Nenhum Atendimento Encontrado. </div> 
                </div>";
            }
            
$dados_pdf .= " 
            </div>
        </div>";
                            

        $footer = "<div>Junta Policial Militar de Saúde em Natal / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " em " . date('d/m/Y - H:m:s');
    // $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output("$prontuario->st_nome - Ficha de Evolução - JPMS.pdf", \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 