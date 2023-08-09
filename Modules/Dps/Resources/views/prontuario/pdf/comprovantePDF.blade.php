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

    $meses = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];

    $st_cpf = $comprovanteProvaDeVida->st_cpf;

    $cpfMascara = ($st_cpf[0] . $st_cpf[1] . $st_cpf[2] . '.' . $st_cpf[3] . $st_cpf[4] . $st_cpf[5] . '.' . $st_cpf[6] . $st_cpf[7] . $st_cpf[8] . '-' . $st_cpf[9] . $st_cpf[10]);

    $st_cpf = $comprovanteProvaDeVida->st_cpfresponsavellegal;

    $cpfMascaraResponsavel = ($st_cpf[0] . $st_cpf[1] . $st_cpf[2] . '.' . $st_cpf[3] . $st_cpf[4] . $st_cpf[5] . '.' . $st_cpf[6] . $st_cpf[7] . $st_cpf[8] . '-' . $st_cpf[9] . $st_cpf[10]);

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
                        Diretoria de Proteção Social<BR/>
                    </div>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='titulocaderneta'>
                       COMPROVANTE DE RECADASTRAMENTO DO PENSIONISTA - 2022
                    </div>
                ";

 
    $dados_pdf .= "<table class='table'>";

        $dados_pdf .= " <tr>
                            <th class='legandatitulo' style='text-align: center;' colspan='8'> DADOS DO PENSIONISTA</th>
                        </tr>";

        $dados_pdf .= " <tr>
                            <th class='title' style='background-color: lightgray;' colspan='8'> Dados Pessoais</th>
                        </tr>";
            

        $dados_pdf .= "<tr>";

            $dados_pdf .= "<td colspan='5'><span class='title'>NOME</span><br />" . $comprovanteProvaDeVida->st_nome . " </td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>NASCIMENTO</span><br />"; 
            if(!empty($comprovanteProvaDeVida->dt_nascimento)){
                $dados_pdf .= \Carbon\Carbon::parse($comprovanteProvaDeVida->dt_nascimento)->format('d/m/Y');
            }
            $dados_pdf .= "</td>";
            $dados_pdf .= " <td colspan='2'><span class='title'>SEXO:</span><br />" . $comprovanteProvaDeVida->st_sexo  . "</td>";
            $dados_pdf .= "</tr>
            <tr>";
                        
            $dados_pdf .= "<td colspan='5'><span class='title'>NATURALIDADE</span><br />" . $comprovanteProvaDeVida->st_naturalidade . "</td>";
            $dados_pdf .= "<td colspan='3'><span class='title'>UF</span><br />" . $comprovanteProvaDeVida->st_ufnaturalidade . "</td>";
            $dados_pdf .= "</tr>
            <tr>";
            $dados_pdf .= "<td colspan='4'><span class='title'>NOME DO PAI</span><br />" . $comprovanteProvaDeVida->st_pai . "</td>";
            $dados_pdf .= "<td colspan='4'><span class='title'>NOME DA MÃE</span><br />" . $comprovanteProvaDeVida->st_mae . "</td>";
            $dados_pdf .= "</tr>
            <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>CPF</span><br />" . $cpfMascara . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>REGISTRO CIVIL</span><br />" . $comprovanteProvaDeVida->st_rgcivil . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>ÓRGÃO EMISSOR</span><br />" . $comprovanteProvaDeVida->st_orgaorgcivil. "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>DATA DE EMISSÃO</span><br />"; 
                if(!empty($comprovanteProvaDeVida->dt_emissaorgcivil)){
                    $dados_pdf .= \Carbon\Carbon::parse($comprovanteProvaDeVida->dt_emissaorgcivil)->format('d/m/Y');
                }
            $dados_pdf .= "</td>
        </tr>";

        $dados_pdf .= " <tr>
                            <th class='title' style='background-color: lightgray;' colspan='8'> Dados Para Contato</th>
                        </tr>";
            
        
        $dados_pdf .= "<tr>";
            $dados_pdf .= "<td colspan='5'><span class='title'>ENDEREÇO</span><br />" . $comprovanteProvaDeVida->st_logradouro . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>NÚMERO</span><br />" . $comprovanteProvaDeVida->st_numeroresidencia . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>COMPLEMENTO</span><br />" .$comprovanteProvaDeVida->st_complemento . "</td>";
            
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='3'><span class='title'>BAIRRO</span><br />" . $comprovanteProvaDeVida->st_bairro . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>CEP</span><br />" . $comprovanteProvaDeVida->st_cep . "</td>";
            $dados_pdf .= "<td colspan='3'><span class='title'>CIDADE</span><br />" . $comprovanteProvaDeVida->st_cidade . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>UF</span><br />" . $comprovanteProvaDeVida->st_ufendereco . "</td>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>TELEFONE RESIDENCIAL</span><br />" . $comprovanteProvaDeVida->st_telefone . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>TELEFONE CELULAR</span><br />" . $comprovanteProvaDeVida->st_telefonecelular . "</td>";
            $dados_pdf .= "<td colspan='4'><span class='title'>E-MAIL</span><br />" . $comprovanteProvaDeVida->st_email . "</td>";
        $dados_pdf .= "</tr>";
        

        $dados_pdf .= " <tr>
                            <th class='legandatitulo' style='text-align: center;' colspan='8'> DADOS DA PENSÃO</th>
                        </tr>";
        
        $dados_pdf .= "<tr>";

            $dados_pdf .= "<td colspan='2'><span class='title'>DATA DE INÍCIO</span><br />" ;
                $dados_pdf .= date('d/m/Y', strtotime($comprovanteProvaDeVida->dt_inicio)) ;
            $dados_pdf .= "</td>";

            $dados_pdf .= "<td colspan='2'><span class='title'>TIPO DE HABILITAÇÃO</span><br />" ;
                $dados_pdf .= 'PÓS-MORTE';
            $dados_pdf .= "</td>";

            $dados_pdf .= "<td colspan='2'><span class='title'>SITUAÇÃO DA PENSÃO</span><br />" ;
                $dados_pdf .= $comprovanteProvaDeVida->st_situacao;
            $dados_pdf .= "</td>";

            $dados_pdf .= "<td colspan='3'><span class='title'>TIPO DO VÍNCULO</span><br />" ;
                $dados_pdf .= $comprovanteProvaDeVida->st_vinculo;
            $dados_pdf .= "</td>";

            if($comprovanteProvaDeVida->st_tiporesponsavellegal != 'PENSIONISTA') {
                $dados_pdf .= "</tr>
                <tr>
                    <td colspan='4'>
                        <span class='title'>NOME DO RECADASTRANTE</span> <br>
                        ". $comprovanteProvaDeVida->st_nomeresponsavellegal ."
                    </td>
                    <td colspan='4'>
                        <span class='title'>CPF DO RECADASTRANTE</span> <br>
                        ". $comprovanteProvaDeVida->st_cpfresponsavellegal ."
                    </td>
                </tr>";
            }

            $dados_pdf .= "</tr>
        <tr>
            <th class='legandatitulo' style='text-align: center;' colspan='8'>DADOS DO POLICIAL</th>
        </tr>   
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>MATRÍCULA</span><br />" . $comprovanteProvaDeVida->st_matriculapolicialvinculado . "</td>";
            $dados_pdf .= "<td colspan='4'><span class='title'>NOME</span><br />" . $comprovanteProvaDeVida->st_nomepolicialvinculado . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>POSTO/GRADUAÇÃO</span><br />" . $comprovanteProvaDeVida->st_graduacaopolicialvinculado . "</td>";
            
            $dados_pdf .= "</tr>";

        $textoTitular = 'Atesto que são verdadeiras as informações que forneci para o preenchimento deste formulário de recadastramento.';

        $textoAtendentePen = 'Atestamos que o pensionista supracitado forneceu as informações solicitadas para fins de recadastramento de proteção social.';

        $textoAtendenteNaoPen = 'Atestamos que '.$comprovanteProvaDeVida->st_nomeresponsavellegal.', '.$cpfMascaraResponsavel.', '.$comprovanteProvaDeVida->st_tiporesponsavellegal.' do pensionista supracitado forneceu as informações solicitadas  para fins de recadastramento de proteção social.';

        $textoNaoTitular = ($comprovanteProvaDeVida->st_tiporesponsavellegal != 'PENSIONISTA') ? $textoAtendenteNaoPen : $textoAtendentePen;
        
        $dados_pdf .= "<tr> <th class='legandatitulo' style='text-align: center;' colspan='8'>DADOS DO RECADASTRAMENTO</th> </tr>
        <tr>
        </tr>
        <br>
        <tr style=''>
            <td style='text-align: center;' colspan='8'>
                <p>
                    ". $textoTitular ." <br><br> ____________________________________________________ <br> Recadastrante
                </p>
                <br><br>
                <p>
                    ". $textoNaoTitular ." <br> <br> Natal, ".date('d')." de ".$meses[intval(date('m'))]." de ".date('Y')." <br><br> ____________________________________________________ <br> Atendente
                </p>
            </td>
        </tr>";

        $dados_pdf .= "</table>";
    

    $dados_pdf .= "
                </div>
                
                </div>";

    $footer = "<div>Comprovante de Prova de Vida de Pensionista / DPS / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:i:s');
    
    $mpdf->SetTitle('Comprovante de Recadastramento de Prova de Vida');
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output($comprovanteProvaDeVida->st_nome . '_Recadastramento_'.date('Y').'.pdf', \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 
