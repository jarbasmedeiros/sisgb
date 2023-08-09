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
                        Diretoria de Justiça e Disciplina<BR/>
                    </div>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='tituloextrato'>
                        EXTRATO DE PROCEDIMENTO
                    </div>
                ";

 
    $dados_pdf .= "<table class='table' >";
 
        $dados_pdf .= " <tr>
                            <th class='legandatitulo' colspan='5'> DADOS DO PROCEDIMENTO</th>
                        </tr>";
        $dados_pdf .= "<tr >";

        $dados_pdf .= "<td><span class='title'>DATA DO BOLETIM</span><br />"; 
                if(!empty($extratoProcedimento->dt_publicacaoboletim)){
                    $dados_pdf .= \Carbon\Carbon::parse($extratoProcedimento->dt_publicacaoboletim)->format('d/m/Y');
                }
            
            $dados_pdf .= "</td>";
            $dados_pdf .="<td><span class='title'>DATA DE INÍCIO</span><br/>";
                 if(!empty($extratoProcedimento->dt_prazoinicial)){
                    $dados_pdf .= \Carbon\Carbon::parse($extratoProcedimento->dt_prazoinicial)->format('d/m/Y');
                }
            $dados_pdf .= "</td>";
            $dados_pdf .= "<td width='17%'><span class='title'>TIPO</span><br /><strong>" . $extratoProcedimento->st_tipo . "</strong></td>";
            $dados_pdf .= "<td width='12%'><span class='title'>ORIGEM</span><br />" . $extratoProcedimento->st_origem . "</td>";
            $dados_pdf .= "<td width='12%'><span class='title'>STATUS</span><br/><strong>".$extratoProcedimento->st_status."</strong></td>";
            
            
            
            $dados_pdf .= "</tr>
        <tr>";
            
            $dados_pdf .= "<td colspan='2' ><span class='title'>N°SEI</span><br />" . $extratoProcedimento->st_numsei . "</td>";            
            $dados_pdf .= "<td envolvidos><span class='title'>PORTÁRIA</span><br />".$extratoProcedimento->st_numprocedimento."</td>"; 
            $dados_pdf .= "<td colspan='2'  ><span class='title'>UNIDADE</span><br />" .$extratoProcedimento->unidade->st_sigla. "</td>";
            $dados_pdf .="</tr>
        <tr>";
            $dados_pdf .="<td colspan='5'  ><span class='title'>FATO</span><br />" . $extratoProcedimento->st_fato ."</td>";
            $dados_pdf .="</tr>
        <tr>";
            $dados_pdf .="<td colspan='2'  ><span class='title'>DATA DE CONCLUSÃO</span><br/>";
                if(!empty($extratoProcedimento->dt_encerramento)){
                    $dados_pdf .= \Carbon\Carbon::parse($extratoProcedimento->dt_encerramento)->format('d/m/Y');
                }
            $dados_pdf .="</td>";
            $dados_pdf .="<td colspan='3'  ><span class='title'>SOLUÇÃO</span><br/>".$extratoProcedimento->st_solucao."</td>";


            $dados_pdf .="</tr>
        <tr>";
            $dados_pdf .="<td colspan='5'  ><span class='title'>OBSERVAÇÃO</span><br />".$extratoProcedimento->st_obs."</td>";
  
            $dados_pdf .= "</tr>
        <tr>
            <th class='legandatitulo' colspan='5'>DADOS DO ENCARREGADO</th>
        </tr>
        <tr>";

            $dados_pdf .= "<td ><span class='title'>GRADUAÇÃO</span><br />".$extratoProcedimento->st_postgradencarregado."</td>";
            $dados_pdf .= "<td  colspan='4' ><span class='title'>NOME</span><br />" . $extratoProcedimento->st_nomeencarregado ." </td>" ; 
            
 
           


        $dados_pdf .= "
        <tr>
            <th class='legandatitulo' colspan='5'>DADOS DO(S) ENVOLVIDO(S)</th>
        </tr>
        <tr>
            <th class='title-envolvidos'><span class='title'>MATRÍCULA</span></th>
            <th class='title-envolvidos'><span class='title'>NOME</span></th>
            <th class='title-envolvidos'><span class='title'>SOLUÇÃO</span></th>
            <th class='title-envolvidos'><span class='title'>RESTRIÇÃO DE ARMA</span></th>
            <th class='title-envolvidos'><span class='title'>REBECIMENTO</span></th>

        </tr>";
            if(isset($extratoProcedimento->envolvidos) && count($extratoProcedimento->envolvidos)>0){
                foreach($extratoProcedimento->envolvidos as $c){
                    $dados_pdf .= "<tr>";
                        $dados_pdf .= "<td >" . $c->st_matricula . "</td>";
                        $dados_pdf .= "<td class='size-envolvidos'>" . $c->st_policial . "</td>";
                        $dados_pdf .= "<td class='text-center'>" . $c->st_solucaoindividual . "</td>";
                        $dados_pdf .= "<td class='text-center'>";
                        if($c->bo_restricaoarma == "1"){
                            $dados_pdf .= "SIM";
                        }else{
                            $dados_pdf .= "NÃO";
                        }
                        $dados_pdf .= "</td>";
                        $dados_pdf .= "<td>";
                            if(!empty($c->dt_recebimento)){
                                $dados_pdf .= \Carbon\Carbon::parse($c->dt_recebimento)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>";
                       
                    $dados_pdf .= "</tr>";
                }
            }else{
                $dados_pdf .= " <tr> 
                                    <td   colspan='5'>Nenhum dado foi encontrado para este solicitante.</span></td>
                                </tr>";
            }
        


        $dados_pdf .= "</table>";

    

    $dados_pdf .= "
                </div>
                </div>";

    $footer = "<div>Extrato de procedimento / DJD / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
    
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output('Extrato do Procedimento - N° SEI '.$extratoProcedimento->st_numsei . '.pdf', \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 
