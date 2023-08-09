@php use App\utis\Funcoes; @endphp
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
    $css = file_get_contents('assets/css/djd/pdfExtratoProcedimento.css');
    //$css = file_get_contents('assets/css/rh/djd/certidao_Nada_Consta_Pdf.css');
    $mpdf->SetTitle("Declaração Anual de Beneficiários da Prova de Vida");//titulo da pagina
    //insere a marca d'agua no PDF com o cpf do usuário logado
    $mpdf->SetWatermarkText(auth()->user()->matricula, 0.1);
    $mpdf->showWatermarkText = true;

    $mpdf->WriteHTML($css, 1);
    

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
                        Diretoria de Recursos Humanos<BR/>
                    </div>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='tituloextrato'>
                        DECLARAÇÃO ANUAL DE BENEFICIÁRIOS DA PROVA DE VIDA DE ".$dadosCertidao->st_ano."
                    </div>
                ";

 
    $dados_pdf .= "<table class='table'>";
 
        $dados_pdf .= "<tr>
                            <th class='legandatitulo' colspan='5'>DADOS DO POLICIAL</th>
                       </tr>";

        $dados_pdf .= "<tr>";
            $dados_pdf .= "<td ><span class='title'>GRADUAÇÃO</span><br />";
                if(!empty($policial->st_postograduacaosigla)){
                    $dados_pdf .= $policial->st_postograduacaosigla;
                }
            $dados_pdf .= "</td>";

            $dados_pdf .= "<td colspan='4'><span class='title'>NOME</span><br />"; 
                if(!empty($policial->st_nome)){
                    $dados_pdf .= $policial->st_nome;
                }
            $dados_pdf .= "</td>";
        $dados_pdf .= "</tr>";

        $dados_pdf .= "<tr >";
            $dados_pdf .= "<td ><span class='title'>MATRÍCULA</span><br />";
                if(!empty($policial->st_matricula)){
                    $dados_pdf .= $policial->st_matricula;
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td ><span class='title'>Nº DE PRAÇA</span><br />";
                if(!empty($policial->st_numpraca)){
                    $dados_pdf .= $policial->st_numpraca;
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td colspan='3'><span class='title'>RG MILITAR</span><br />";
                if(!empty($policial->st_rgmilitar)){
                    $dados_pdf .= $policial->st_rgmilitar;
                }
            $dados_pdf .= "</td>";
        $dados_pdf .= "</tr>";

        $dados_pdf .= "<tr >";
            $dados_pdf .= "<td><span class='title'>CPF</span><br />";
                if(!empty($policial->st_cpf)){
                    $dados_pdf .= $policial->st_cpf;
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td ><span class='title'>SEXO</span><br />";
                if(!empty($policial->st_sexo)){
                    $dados_pdf .= $policial->st_sexo;
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td colspan='3'><span class='title'>NASCIMENTO</span><br />";
            if(!empty($policial->dt_nascimento)){
                $dados_pdf .= Funcoes::converterDataFormatoBr($policial->dt_nascimento);
            }
        $dados_pdf .= "</td>";
        $dados_pdf .= "</tr>";

        $dados_pdf .= "<tr >";
            $dados_pdf .= "<td colspan='5'><span class='title'>UNIDADE</span><br />";
                if(!empty($policial->st_unidade)){
                    $dados_pdf .= $policial->st_unidade;
                }
            $dados_pdf .= "</td>";
        $dados_pdf .= "</tr>";

        $dados_pdf .= "</table>";
        $dados_pdf .= "<table class='table' style='margin-bottom:20px'>";

        $dados_pdf .= "<tr>
                            <th class='legandatitulo' colspan='5'>DADOS DOS BENEFICIÁRIOS</th>
                       </tr>";
        
        
        if(count($dadosCertidao->beneficiarios)>0){
            
            foreach($dadosCertidao->beneficiarios as $beneficiario){
                $dados_pdf .= "<tr style='background-color: lightgray'>
                       <td><span class='title'>NOME</span></td>
                       <td><span class='title' style='width:17%'>CPF</span></td>
                       <td><span class='title' style='width:13%'>SEXO</span></td>
                       <td><span class='title' style='width:18%'>TELEFONE</span></td>
                       <td><span class='title' style='width:15%'>ORDEM</span></td>
                  </tr>";
                $dados_pdf .= "<tr>
                            <td rowspan='3' class='fonte_beneficiarios'>".$beneficiario->pessoa->st_nome."</td>
                            <td style='width:17%'>".$beneficiario->pessoa->st_cpf."</td>
                            <td style='width:13%'>".$beneficiario->pessoa->st_sexo."</td>
                            <td style='width:18%'>".$beneficiario->pessoa->st_telefone."</td>
                            <td style='width:15%'>".$beneficiario->st_ordem."</td>
                             </tr>";
                $dados_pdf .= "<tr>
                             <td><span class='title'>NASCIMENTO</span></td>
                             <td colspan='3'><span class='title'>EMAIL</span></td>
                        </tr>";
                $dados_pdf .= "<tr>                             
                        <td>".Funcoes::converterDataFormatoBr($beneficiario->dt_nascimento)."</td>
                        <td colspan='3'>".$beneficiario->st_email."</td>
                   </tr>";
            }
        } else {
            $dados_pdf .= "<tr>
                            <td colspan='4'>Não há beneficiários cadastrados.</td>
                            </tr>";
        }

        $textoTitular = 'Atesto que são verdadeiras as informações que forneci para o preenchimento deste formulário de recadastramento.';

        $textoNaoTitular = 'Atestamos que o policial inativo supracitado forneceu as informações solicitadas para fins de recadastramento de proteção social.';

        $dados_pdf .= "<tr> <th class='legandatitulo' style='text-align: center;' colspan='5'>DADOS DO RECADASTRAMENTO</th> </tr>
        <tr>
        </tr>
        <br>
        <tr>
            <td style='text-align: center;' colspan='5'>
                <p>
                    ". $textoTitular ." <br><br> ____________________________________________________ <br> Policial <br>Natal, ".date('d')." de ".$meses[intval(date('m'))]." de ".date('Y')."
                </p>
                <br><br>
                <p>
                    ". $textoNaoTitular ." <br><br> ____________________________________________________ <br> Atendente <br>Natal, ".date('d')." de ".$meses[intval(date('m'))]." de ".date('Y')." <br><br>
                </p>
            </td>
        </tr>";
        


    $dados_pdf .= "</table>";
    
    //caso a assinatura volte tire esse if
    if(2==3){
        if($dadosCertidao->dt_assinaturapolicial && $dadosCertidao->dt_assinaturaresponsavel){
            $dados_pdf .= "
            <div class='conteudot5' >
                <h5>Eu, <strong>".$policial->st_nome." ".$policial->st_postograduacaosigla." ".$orgao."</strong>, matrícula <strong>".$policial->st_matricula."</strong> certifico e dou fé que os dados informados por mim nesta certidão são verídicos.</h5>
                <h5>Assinado eletronicamente no dia <strong>".date("d/m/Y",strtotime($dadosCertidao->dt_assinaturapolicial))."</strong> às <strong>".date("H:i:s",strtotime($dadosCertidao->dt_assinaturapolicial))." hrs</strong>.</h5>
            </div>";
    
    
            $dados_pdf .= "
            <div class='conteudot5'>
                <h5>Eu, <strong>".$dadosCertidao->sargenteante->st_nome." ".$dadosCertidao->sargenteante->st_postograduacaosigla." ".$orgao."</strong>, matrícula <strong>".$dadosCertidao->sargenteante->st_matricula."</strong> certifico e dou fé que este documento lavrado por mim foi baseado nas informações fornecidas pelo policial.</h5>
                <h5>Assinado eletronicamente no dia <strong>".date("d/m/Y",strtotime($dadosCertidao->dt_assinaturaresponsavel))."</strong> às <strong>".date("H:i:s",strtotime($dadosCertidao->dt_assinaturaresponsavel))." hrs</strong>.</h5>
            </div>";
        } else {
            $dados_pdf .= "<p style='color:red'>Esta certidão não é válida porque não foi assinada pelo policial e pelo responsável.</p>";
        }    
    }    

    $dados_pdf .= "</div>
                </div>";

    $footer = "<div>Declaração de Beneficiário / DP / SISGP. Pag. {PAGENO} de {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
    
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output('Declaracao de Beneficiario - '.$policial->st_nome.' - '.$policial->st_matricula.' - '.$dadosCertidao->st_ano.'.pdf', \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 
