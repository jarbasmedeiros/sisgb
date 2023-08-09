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
                        Agência Central de Inteligência<BR/>
                    </div>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='titulocaderneta'>
                        CADERNETA DE REGISTROS RESERVADOS (CR - Reservada)
                    </div>
                ";

    
    $dados_pdf .= "<table class='table'>";
        $dados_pdf .= " <tr>
                            <th class='legandatitulo' colspan='8'> DADOS PESSOAIS</th>
                        </tr>";
    if(isset($cadernetaRegistro->qualificacao)) {
        $dados_pdf .= "<tr>";
            if(isset($imagem)){
                $dados_pdf .= " <td colspan='1' rowspan='3'><img id='img' class='img' src='data:image/png;data:image/jpeg;base64,{!! $imagem !!}'  width='100' height='120' style='border:1px solid #999;'></td>";
                $dados_pdf .= "<td colspan='4'><span class='title'>NOME</span><br />" . $cadernetaRegistro->qualificacao->st_nome . " </td>";
                $dados_pdf .= "<td colspan='1'><span class='title'>NASCIMENTO</span><br />"; 
                if(!empty($cadernetaRegistro->qualificacao->dt_nascimento)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_nascimento)->format('d/m/Y');
                }
                $dados_pdf .= "</td>";
                $dados_pdf .= " <td colspan='2'><span class='title'>SEXO:</span><br />" . $cadernetaRegistro->qualificacao->st_sexo  . "</td>";
                $dados_pdf .= "</tr>
                <tr>";
                $dados_pdf .= "<td colspan='1'><span class='title'>TIPO SANGUÍNEO</span><br />" . $cadernetaRegistro->qualificacao->st_tiposanguineo . "</td>";
                $dados_pdf .= "<td colspan='1'><span class='title'>FATOR RH</span><br />" . $cadernetaRegistro->qualificacao->st_fatorrh . "</td>";
                $dados_pdf .= "<td colspan='4'><span class='title'>NATURALIDADE</span><br />" . $cadernetaRegistro->qualificacao->st_naturalidade . "</td>";
                $dados_pdf .= "<td colspan='1'><span class='title'>UF</span><br />" . $cadernetaRegistro->qualificacao->st_ufnaturalidade . "</td>";
                $dados_pdf .= "</tr>
                <tr>";
                $dados_pdf .= "<td colspan='3'><span class='title'>NOME DO PAI</span><br />" . $cadernetaRegistro->qualificacao->st_pai . "</td>";
                $dados_pdf .= "<td colspan='4'><span class='title'>NOME DA MÃE</span><br />" . $cadernetaRegistro->qualificacao->st_mae . "</td>";
                $dados_pdf .= "</tr>";
            }else{
                $dados_pdf .= "<td colspan='5'><span class='title'>NOME</span><br />" . $cadernetaRegistro->qualificacao->st_nome . " </td>";
                $dados_pdf .= "<td colspan='1'><span class='title'>NASCIMENTO</span><br />"; 
                if(!empty($cadernetaRegistro->qualificacao->dt_nascimento)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_nascimento)->format('d/m/Y');
                }
                $dados_pdf .= "</td>";
                $dados_pdf .= " <td colspan='2'><span class='title'>SEXO:</span><br />" . $cadernetaRegistro->qualificacao->st_sexo  . "</td>";
                $dados_pdf .= "</tr>
                <tr>";
                $dados_pdf .= "<td colspan='1'><span class='title'>TIPO SANGUÍNEO</span><br />" . $cadernetaRegistro->qualificacao->st_tiposanguineo . "</td>";
                $dados_pdf .= "<td colspan='1'><span class='title'>FATOR RH</span><br />" . $cadernetaRegistro->qualificacao->st_fatorrh . "</td>";
                $dados_pdf .= "<td colspan='5'><span class='title'>NATURALIDADE</span><br />" . $cadernetaRegistro->qualificacao->st_naturalidade . "</td>";
                $dados_pdf .= "<td colspan='1'><span class='title'>UF</span><br />" . $cadernetaRegistro->qualificacao->st_ufnaturalidade . "</td>";
                $dados_pdf .= "</tr>
                <tr>";
                $dados_pdf .= "<td colspan='4'><span class='title'>NOME DO PAI</span><br />" . $cadernetaRegistro->qualificacao->st_pai . "</td>";
                $dados_pdf .= "<td colspan='4'><span class='title'>NOME DA MÃE</span><br />" . $cadernetaRegistro->qualificacao->st_mae . "</td>";
                $dados_pdf .= "</tr>";
            }
        
        $dados_pdf .= "<tr>";
            $dados_pdf .= "<td colspan='5'><span class='title'>ENDEREÇO</span><br />" . $cadernetaRegistro->qualificacao->st_endereco . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>NÚMERO</span><br />" . $cadernetaRegistro->qualificacao->st_numeroresidencia . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>COMPLEMENTO</span><br />" . $cadernetaRegistro->qualificacao->st_complemento . "</td>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='3'><span class='title'>BAIRRO</span><br />" . $cadernetaRegistro->qualificacao->st_bairro . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>CEP</span><br />" . $cadernetaRegistro->qualificacao->st_cep . "</td>";
            $dados_pdf .= "<td colspan='3'><span class='title'>CIDADE</span><br />" . $cadernetaRegistro->qualificacao->st_cidade . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>UF</span><br />" . $cadernetaRegistro->qualificacao->st_ufendereco . "</td>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>TELEFONE RESIDENCIAL</span><br />" . $cadernetaRegistro->qualificacao->st_telefonefixo . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>TELEFONE CELULAR</span><br />" . $cadernetaRegistro->qualificacao->st_telefonecelular . "</td>";
            $dados_pdf .= "<td colspan='4'><span class='title'>E-MAIL</span><br />" . $cadernetaRegistro->qualificacao->st_email . "</td>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>CPF</span><br />" . $cadernetaRegistro->qualificacao->st_cpf . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>REGISTRO CIVIL</span><br />" . $cadernetaRegistro->qualificacao->st_rgcivil . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>ÓRGÃO EMISSOR</span><br />" . $cadernetaRegistro->qualificacao->st_orgaorgcivil . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>DATA DE EMISSÃO</span><br />"; 
                if(!empty($cadernetaRegistro->qualificacao->dt_emissaorgcivil)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_emissaorgcivil)->format('d/m/Y');
                }
            $dados_pdf .= "</td>
        </tr>
        <tr>";
            $dados_pdf .= "<td colspan='4'><span class='title'>REGISTRO MILITAR</span><br />" . $cadernetaRegistro->qualificacao->st_rgmilitar . "</td>";
            $dados_pdf .= "<td colspan='4'><span class='title'>DATA DE EMISSÃO</span><br />"; 
                if(!empty($cadernetaRegistro->qualificacao->dt_emissaorgmilitar)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_emissaorgmilitar)->format('d/m/Y');
                }
            $dados_pdf .= "</td>
        </tr>
        <tr>";
            $dados_pdf .= "<td colspan='3'><span class='title'>ESTADO CIVIL</span><br />" . $cadernetaRegistro->qualificacao->st_estadocivil . "</td>";
            $dados_pdf .= "<td colspan='5'><span class='title'> CÔNJUGE</span><br />" . $cadernetaRegistro->qualificacao->st_conjuge . "</td>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>TÍTULO ELEITORAL</span><br />" . $cadernetaRegistro->qualificacao->st_titulo . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'> ZONA</span><br />" . $cadernetaRegistro->qualificacao->st_zonatitulo . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'> SESSÃO</span><br />" . $cadernetaRegistro->qualificacao->st_secaotitulo . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>CIDADE</span><br />" . $cadernetaRegistro->qualificacao->st_municipiotitulo . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'> UF</span><br />" . $cadernetaRegistro->qualificacao->st_uftitulo . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'> DATA DE EMISSÃO</span><br />";
                if(!empty($cadernetaRegistro->qualificacao->dt_emissaotitulo)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_emissaotitulo)->format('d/m/Y');
                }
            $dados_pdf .= "</td>
        </tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>CNH</span><br />" . $cadernetaRegistro->qualificacao->st_cnh . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>CATEGORIA</span><br />" . $cadernetaRegistro->qualificacao->st_categoriacnh . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'> DATA DE EMISSÃO</span><br />";
                if(!empty($cadernetaRegistro->qualificacao->dt_emissaocnh)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_emissaocnh)->format('d/m/Y');
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'> DATA DE VALIDADE</span><br />";
                if(!empty($cadernetaRegistro->qualificacao->dt_vencimentocnh)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_vencimentocnh)->format('d/m/Y');
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>UF</span><br />" . $cadernetaRegistro->qualificacao->st_ufcnh . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>NIS (PIS/PASEP)</span><br />" . $cadernetaRegistro->qualificacao->st_pispasep . "</td>";
            $dados_pdf .= "</tr>
        <tr>
            <th class='legandatitulo' colspan='8'>DADOS FUNCIONAIS</th>
        </tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>MATRÍCULA</span><br />" . $cadernetaRegistro->qualificacao->st_matricula . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>NOME DE GUERRA</span><br />" . $cadernetaRegistro->qualificacao->st_nomeguerra . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>POSTO/GRADUAÇÃO</span><br />" . $cadernetaRegistro->qualificacao->st_postograduacaosigla . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>ESPECIALIZAÇÃO</span><br />" . $cadernetaRegistro->qualificacao->st_qpmp . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>COMPORTAMENTO</span><br />" . $cadernetaRegistro->qualificacao->st_comportamento . "</td>";
            $dados_pdf .= "</tr>
        <tr>";            
            $dados_pdf .= "<td colspan='2'><span class='title'>DATA DE INCORPORAÇÃO (PM)</span><br />"; 
                if(!empty($cadernetaRegistro->qualificacao->dt_incorporacao)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_incorporacao)->format('d/m/Y');
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>DATA DE INCLUSÃO</span><br />"; 
                if(!empty($cadernetaRegistro->qualificacao->dt_inclusao)){
                    $dados_pdf .= \Carbon\Carbon::parse($cadernetaRegistro->qualificacao->dt_inclusao)->format('d/m/Y');
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>NÚMERO DE PRAÇA</span><br />" . $cadernetaRegistro->qualificacao->st_numpraca . "</td>";
            $dados_pdf .= "<td colspan='3'><span class='title'>OPM:</span><br />" . $cadernetaRegistro->qualificacao->st_unidade . "</td>";
        
        $dados_pdf .= "
        </tr>
        <tr>
            <th class='legandatitulo' colspan='8'>PUBLICAÇÕES RESERVADAS</th>
        </tr>
        </table>";
        if(isset($cadernetaRegistro->publicacoes) && count($cadernetaRegistro->publicacoes)>0){
            $countP = 0;
            foreach($cadernetaRegistro->publicacoes as $p){
                    if($p->bo_reservado){ 
                        $dados_pdf .= "
                            <table class='table'>
                                <tr>
                        ";   
                        $dados_pdf .= "<td class='col-md-8'><span class='title'>TIPO</span><br />" . $p->st_assunto . "</td>";
                        $dados_pdf .= "<td class='col-md-2'><span class='title'>PUBLICAÇÃO</span><br />" . $p->st_boletim . "</td>";
                        $dados_pdf .= "<td class='col-md-2'><span class='title'>DATA DA PUBLICAÇÃO</span><br />"; 
                            if(!empty($p->dt_publicacao)){
                                $dados_pdf .= \Carbon\Carbon::parse($p->dt_publicacao)->format('d/m/Y');
                            }
                        $dados_pdf .= "     </td>
                                </tr>
                            </table>
                        ";
                        
                        if (isset($p->st_campopersonalizado)) {
                            $observacao = strip_tags($p->st_campopersonalizado);
                        } else {
                            $observacao = strip_tags($p->st_materia);
                        }
                        
                        $dados_pdf .= "
                        <div class='col-md-12 border6'>
                             <span class='title'>OBSERVAÇÃO</span><br /> <div class='text-justify'>" . $p->observacao . 
                        "</div></div>";  
                        
                        $countP++;
                    } 
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
    }


    $dados_pdf .= "
                </div>
                </div>";

    $footer = "<div>Caderneta de Registros Reservados / ACI / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
    
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output('CR-Reservada_'. $cadernetaRegistro->qualificacao->st_matricula . '.pdf', \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 