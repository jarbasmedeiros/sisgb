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
                        Diretoria de Proteção Social<BR/>
                    </div>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='titulocaderneta'>
                        COMPROVANTE DE HABILITAÇÃO 
                    </div>
                ";

 
    $dados_pdf .= "<table class='table'>";
        $dados_pdf .= " <tr>
                            <th class='legandatitulo' colspan='8'> DADOS DO PROCEDIMENTO</th>
                        </tr>";
        
        $dados_pdf .= "<tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>TIPO</span><br />" . $comprovanteHabilitacao->st_tipo . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>DATA DE SOLICITAÇÃO</span><br />" ;
            if(!empty($comprovanteHabilitacao->dt_cadastro)){
                $dados_pdf .= \Carbon\Carbon::parse($comprovanteHabilitacao->dt_cadastro)->format('d/m/Y');
            }
            $dados_pdf .= "</td>";

            $dados_pdf .= "<td colspan='2'><span class='title'>STATUS</span><br />" . $comprovanteHabilitacao->st_status . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>PROTOCOLO</span><br />" . $comprovanteHabilitacao->st_protocolo . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>VÍNCULO</span><br />" . $comprovanteHabilitacao->st_vinculo . "</td>";
            $dados_pdf .= "</tr>";
       
        


        $dados_pdf .= " <tr>
                            <th class='legandatitulo' colspan='8'> DADOS DO SOLICITANTE</th>
                        </tr>";

        $dados_pdf .= "<tr>";

            $dados_pdf .= "<td colspan='5'><span class='title'>NOME</span><br />" . $comprovanteHabilitacao->solicitante->st_nome . " </td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>NASCIMENTO</span><br />"; 
            if(!empty($comprovanteHabilitacao->solicitante->dt_nascimento)){
                $dados_pdf .= \Carbon\Carbon::parse($comprovanteHabilitacao->solicitante->dt_nascimento)->format('d/m/Y');
            }
            $dados_pdf .= "</td>";
            $dados_pdf .= " <td colspan='2'><span class='title'>SEXO:</span><br />" . $comprovanteHabilitacao->solicitante->st_sexo  . "</td>";
            $dados_pdf .= "</tr>
            <tr>";
                        
            $dados_pdf .= "<td colspan='5'><span class='title'>NATURALIDADE</span><br />" . $comprovanteHabilitacao->solicitante->st_naturalidade . "</td>";
            $dados_pdf .= "<td colspan='3'><span class='title'>UF</span><br />" . $comprovanteHabilitacao->solicitante->st_ufnaturalidade . "</td>";
            $dados_pdf .= "</tr>
            <tr>";
            $dados_pdf .= "<td colspan='4'><span class='title'>NOME DO PAI</span><br />" . $comprovanteHabilitacao->solicitante->st_pai . "</td>";
            $dados_pdf .= "<td colspan='4'><span class='title'>NOME DA MÃE</span><br />" . $comprovanteHabilitacao->solicitante->st_mae . "</td>";
            $dados_pdf .= "</tr>";
            
        
        $dados_pdf .= "<tr>";
            $dados_pdf .= "<td colspan='5'><span class='title'>ENDEREÇO</span><br />" . $comprovanteHabilitacao->solicitante->st_logradouro . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>NÚMERO</span><br />" . $comprovanteHabilitacao->solicitante->st_numeroresidencia . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>COMPLEMENTO</span><br />" .$comprovanteHabilitacao->solicitante->st_complemento . "</td>";
            
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='3'><span class='title'>BAIRRO</span><br />" . $comprovanteHabilitacao->solicitante->st_bairro . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>CEP</span><br />" . $comprovanteHabilitacao->solicitante->st_cep . "</td>";
            $dados_pdf .= "<td colspan='3'><span class='title'>CIDADE</span><br />" . $comprovanteHabilitacao->solicitante->st_cidade . "</td>";
            $dados_pdf .= "<td colspan='1'><span class='title'>UF</span><br />" . $comprovanteHabilitacao->solicitante->st_ufendereco . "</td>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>TELEFONE RESIDENCIAL</span><br />" . $comprovanteHabilitacao->solicitante->st_telefone . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>TELEFONE CELULAR</span><br />" . $comprovanteHabilitacao->solicitante->st_telefonecelular . "</td>";
            $dados_pdf .= "<td colspan='4'><span class='title'>E-MAIL</span><br />" . $comprovanteHabilitacao->solicitante->st_email . "</td>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>CPF</span><br />" . $comprovanteHabilitacao->solicitante->st_cpf . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>REGISTRO CIVIL</span><br />" . $comprovanteHabilitacao->solicitante->st_rgcivil . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>ÓRGÃO EMISSOR</span><br />" . $comprovanteHabilitacao->solicitante->st_orgaorgcivil. "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>DATA DE EMISSÃO</span><br />"; 
                if(!empty($comprovanteHabilitacao->solicitante->dt_emissaorgcivil)){
                    $dados_pdf .= \Carbon\Carbon::parse($comprovanteHabilitacao->solicitante->dt_emissaorgcivil)->format('d/m/Y');
                }
            $dados_pdf .= "</td>
        </tr>
        <tr>";

            $dados_pdf .= "</tr>
        <tr>
            <th class='legandatitulo' colspan='8'>DADOS DO POLICIAL</th>
        </tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>MATRÍCULA</span><br />" . $comprovanteHabilitacao->policial->st_matricula . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>NOME</span><br />" . $comprovanteHabilitacao->policial->st_nome . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>NOME DE GUERRA</span><br />" . $comprovanteHabilitacao->policial->st_nomeguerra . "</td>";
            $dados_pdf .= "<td colspan='2'><span class='title'>POSTO/GRADUAÇÃO</span><br />" . $comprovanteHabilitacao->policial->st_postograduacaosigla . "</td>";
            
            $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<td colspan='2'><span class='title'>ESPECIALIZAÇÃO</span><br />" . $comprovanteHabilitacao->policial->st_qpmp . "</td>";            
            $dados_pdf .= "<td colspan='2'><span class='title'>DATA DE INCORPORAÇÃO (PM)</span><br />"; 
                if(!empty($comprovanteHabilitacao->policial->dt_incorporacao)){
                    $dados_pdf .= \Carbon\Carbon::parse($comprovanteHabilitacao->policial->dt_incorporacao)->format('d/m/Y');
                }
            
            $dados_pdf .= "</td>";

            $dados_pdf .= "<td colspan='3'><span class='title'>NÚMERO DE PRAÇA</span><br />" . $comprovanteHabilitacao->policial->st_numpraca . "</td>";
            


        $dados_pdf .= "
        <tr>
            <th class='legandatitulo' colspan='8'>DOCUMENTOS ANEXADOS</th>
        </tr>
        <tr>
            <th colspan='4'><span class='title'>DOCUMENTO</span></th>
            <th colspan='4'><span class='title'>DESCRIÇÃO</span></th>

        </tr>";
            if(isset($comprovanteHabilitacao->arquivosanexados) && count($comprovanteHabilitacao->arquivosanexados)>0){
                foreach($comprovanteHabilitacao->arquivosanexados as $c){
                    $dados_pdf .= "<tr>";
                        $dados_pdf .= "<td colspan='4'>" . $c->st_nomearquivo . "</td>";
                        $dados_pdf .= "<td colspan='4'>" . $c->st_descricao; 
                        $dados_pdf .= "</td>";

                    $dados_pdf .= "</tr>";
                }
            }else{
                $dados_pdf .= " <tr> 
                                    <td colspan='8'>Nenhum dado foi encontrado para este solicitante.</span></td>
                                </tr>";
            }
        


        $dados_pdf .= "</table>";

    

    $dados_pdf .= "
                </div>
                </div>";

    $footer = "<div>Comprovante de Habilitação / DPS / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
    
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output($comprovanteHabilitacao->solicitante->st_nome . ' - Comprovante de Habilitação.pdf', \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 
