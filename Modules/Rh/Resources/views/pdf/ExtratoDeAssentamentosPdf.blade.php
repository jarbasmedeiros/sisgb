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
    $mpdf = new mPDF();
    $css = "";
    $css = file_get_contents('assets/css/rh/caderneta_de_registros.css');

    //insere a marca d'agua no PDF com o cpf do usuário logado
    $mpdf->SetWatermarkText(auth()->user()->matricula, 0.1);
    $mpdf->showWatermarkText = true;

    $mpdf->WriteHTML($css, 1);
    setlocale(LC_TIME, 'portuguese'); //Converte a data para o padrão BR
    date_default_timezone_set('America/Sao_Paulo'); //define o local da data
    $dataAtual = strftime('%d de %B de %Y', strtotime('today')); //recebe a data de hoje
    
    $header = "";
    $dados_pdf = "";
    $dados_pdf .= "
                <div class='border col-md-12'>
                <div class='mt-20'>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/Brasao_RN.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='cab-corpo'>
                        Governo do Estado do Rio Grande do Norte<br/>
                        Secretaria da Segurança Pública e da Defesa Social<br/>
                        Polícia Militar<br/>
                        Diretoria de Pessoal<br>
                        Arquivo Geral <br>
                    </div>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='titulocaderneta'>
                        EXTRATO DE ASSENTAMENTOS
                    </div>
                ";

    $dados_pdf .= " <div class='col-md-12 th border'>
                        <div class='legandatitulo'> DADOS PESSOAIS </div>
                    </div>";
    if(isset($cadernetaRegistro->qualificacao)) {
                $dados_pdf .= "
                <table class='table'>
                    <tr>";
                        $dados_pdf .= "<td colspan='12'><span class='title'> NOME </span><br>" . $cadernetaRegistro->qualificacao->st_nome . "</td>
                    </tr>
                    <tr>";
                         
                        if ($cadernetaRegistro->qualificacao->ce_graduacao < 7) {
                            $dados_pdf .= "<td class='col-md-6'><span class='title'> GRADUAÇÃO </span><br>" . $cadernetaRegistro->qualificacao->st_postograduacao . " PM</td>";
                            $dados_pdf .= "<td class='col-md-2'><span class='title'> Nº DE PRAÇA </span><br>" . $cadernetaRegistro->qualificacao->st_numpraca . "</td>";
                        } else {
                            $dados_pdf .= "<td class='col-md-8'><span class='title'> GRADUAÇÃO </span><br>" . $cadernetaRegistro->qualificacao->st_postograduacao . " PM</td>";
                        }
                        $dados_pdf .= "<td class='col-md-2'><span class='title'> MATRÍCULA </span><br>" . $cadernetaRegistro->qualificacao->st_matricula . "</td>"; 
                        $dados_pdf .= "<td class='col-md-2'><span class='title'> INCLUSÃO </span><br>"; 
                        if(!empty($cadernetaRegistro->qualificacao->dt_inclusao)){
                            $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_inclusao)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>
                    </tr>
                </table>
                    <div class='col-md-12 mt-20 th border'>
                        <div class='legandatitulo'> INFORMAÇÕES COLHIDAS DOS BOLETINS DA PM RN </div>
                    </div>
                ";
        }
                   
        if(isset($cadernetaRegistro->publicacoes) && count($cadernetaRegistro->publicacoes)>0){
            $countP = 0;
            foreach($cadernetaRegistro->publicacoes as $p){
                $dados_pdf .= "
                    <table class='table'>
                        <tr>
                ";   

                if($p->bo_reservado){    
                    $dados_pdf .= "<td class='col-md-8'><span class='title'>TIPO</span><br />Publicação reservada.</td>";
                } else {
                    $dados_pdf .= "<td class='col-md-8'><span class='title'>TIPO</span><br />" . $p->st_assunto . "</td>";
                }
                    $dados_pdf .= "<td class='col-md-2'><span class='title'>PUBLICAÇÃO</span><br />" . $p->st_boletim . "</td>";
                    $dados_pdf .= "<td class='col-md-2'><span class='title'>DATA DA PUBLICAÇÃO</span><br />"; 
                        if(!empty($p->dt_publicacao)){
                            $dados_pdf .= \Carbon\Carbon::parse($p->dt_publicacao)->format('d/m/Y');
                        }
                $dados_pdf .= "     </td>
                        </tr>
                    </table>
                ";

                if($p->bo_reservado){    
                    $observacao = 'Publicação reservada.';
                } else {
                    if (isset($p->st_campopersonalizado)) {
                        $observacao = strip_tags($p->st_campopersonalizado);
                    } else {
                        $observacao = strip_tags($p->st_materia);
                    }
                }
                
                $dados_pdf .= "
                <div class='col-md-12 border6'>
                        <span class='title'>OBSERVAÇÃO</span><br /> <div class='text-justify'>" . $observacao . 
                "</div></div>";  
                
                $countP++;
            }
            if ($countP == 0) {
                $dados_pdf .= "
                <div class='col-md-12 border fs-10pt'>
                    Nenhuma publicação cadastrada.
                </div>
            ";
            }
        }else{
            $dados_pdf .= "
                <div class='col-md-12 border fs-10pt'>
                    Nenhuma publicação cadastrada. 
                </div>
            ";
        }
    


    $dados_pdf .= "
                </div>
                </div>";

    $footer = "<div>Extrato de Assentamentos / DP / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
    
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output('Extrato de Assentamentos - '. $cadernetaRegistro->qualificacao->st_matricula . '.pdf', \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 