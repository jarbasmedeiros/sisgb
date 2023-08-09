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
    $css = file_get_contents('assets/css/rh/ficha_tempo_de_servico.css');

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
        <div class='borda'>
            <div class='mt-20'>
            <div class='brasao'>
                <img class='img-responsive' src=" . URL::asset('/imgs/Brasao_RN.png') . " width='60' height='60' alt='logo'/>
            </div>
            <div class='cab-corpo'>
                RIO GRANDE DO NORTE<br/>
                SECRETARIA DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL<br/>
                POLÍCIA MILITAR<br/>
                DIRETORIA DE PESSOAL<br/>
            </div>
            <div class='brasao'>
                <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
            </div>  
            </div>  
            <div class='col-md-12'>

                <div class='head'>
                    CERTIDÃO DE TEMPO DE SERVIÇO
                </div>



                <div class='col-md-12 borda1 titulo-sessao'>
                    IDENTIFICAÇÃO DO MILITAR
                </div>



                <div class='col-md-12 borda1'>
                    <div class='col-md-8 '>
                        <div class='titulo-celula' >Instituição </div>
                        POLÍCIA MILITAR DO RIO GRANDE DO NORTE
                    </div>
                    <div class=' '>
                        <div class='titulo-celula' >CNPJ </div> 
                        04.058.766/0001-88
                    </div>
                </div>";


    if (isset($certidao)) {
           
            $dados_pdf .= "
                <div class='col-md-12 borda1'>
                    <div class='titulo-celula' >Nome do Servidor </div>
                    {$certidao->qualificacao->st_nome} 
                </div>


                <div class='col-md-12 borda1'>
                    <div class='col-md-8 '>
                        <div class='titulo-celula' > Cargo Efetivo </div> 
                        {$certidao->qualificacao->st_cargoefetivo}
                    </div>
                    <div class=''>
                        <div class='titulo-celula ' >Matrícula </div> 
                        {$certidao->qualificacao->st_matricula}
                    </div>
                </div>


                <div class='col-md-12 borda1'>
                    <div class='col-md-4 '>
                        <div class='titulo-celula' >Identidade </div>
                        {$certidao->qualificacao->st_rgmilitar}
                    </div>
                    <div class='col-md-4 '>
                        <div class='titulo-celula' >Órgão Expedidor </div> 
                        PM/RN
                    </div>
                    <div class=''>
                        <div class='titulo-celula ' >CPF </div> 
                        {$certidao->qualificacao->st_cpf}
                    </div>
                </div>
                
                
                <div class='col-md-12 borda1'>
                    <div class='titulo-celula' >Filiação </div> 
                    {$certidao->qualificacao->st_pai} e {$certidao->qualificacao->st_mae}
                </div>


                <div class='col-md-12 borda1'>
                    <div class='col-md-2 '>
                        <div class='titulo-celula ' >Data de Nascimento </div> 
                        {$certidao->qualificacao->dt_nascimento}
                    </div>
                    <div class='col-md-2 '>
                        <div class='titulo-celula ' >Sexo </div> 
                        {$certidao->qualificacao->st_sexo}
                    </div>
                    <div class=' '>
                        <div class='titulo-celula ' >Naturalidade </div> 
                        {$certidao->qualificacao->st_naturalidade} / {$certidao->qualificacao->st_ufnaturalidade}
                    </div>
                </div>


                <div class='col-md-12 borda1'>
                    <div class='titulo-celula' >Fonte de Informação </div> 
                    BOLETINS GERAIS DA PM RN, ASSENTAMENTOS FUNCIONAIS E SISGP
                </div>


                <div class='col-md-12 borda1 titulo-sessao mt-10'>
                    TEMPO DE SERVIÇO / CONTRIBUIÇÃO
                </div>"; 


                $dados_pdf .= "   
                    <div class='col-md-12 mt-10'>
                    <table class='table'>
                        <thead>
                            <tr class='col-md-12'>
                                <th class='col-md-9'> (+) TEMPO DE EFETIVO SERVIÇO (POLÍCIA MILITAR) </th>
                                <th class=''> QUANTIDADE DE DIAS </th>
                            </tr>
                        </thead>
                        <tbody>";

                            foreach ($certidao->tempooefetivoservico as $key => $tfs) {

                                $tfs->dt_inicio = date('d/m/Y', strtotime($tfs->dt_inicio));
                                $tfs->dt_fim = date('d/m/Y', strtotime($tfs->dt_fim));
                                if ((date('Y/m/d', strtotime($tfs->dt_boletim)) == $tfs->dt_boletim) || (date('Y-m-d', strtotime($tfs->dt_boletim)) == $tfs->dt_boletim)) {
                                    $tfs->dt_boletim = strftime('%d de %B de %Y', strtotime($tfs->dt_boletim));
                                }

                                $dados_pdf .= "
                                    <tr class='corpo-sub-sessao text-left'>
                                        <td class='text-left'>
                                            Motivo: {$tfs->st_motivo} <br>
                                            De {$tfs->dt_inicio}    até {$tfs->dt_fim} 
                                            - {$tfs->nu_diasextenso}. <br>
                                            {$tfs->st_boletim} de {$tfs->dt_boletim}.
                                        </td>
                                        <td class='text-center'> {$tfs->nu_dias} </td>
                                    </tr>
                                ";
                            }
                    $dados_pdf .= "
                        </tbody>
                    </table>
                    </div>";

            
            if (empty($certidao->tempoorgaopublico)) {
                $dados_pdf .= 
                "<div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (+) TEMPO DE SERVIÇO PRESTADO À ÓRGÃO PÚBLICO </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='corpo-sub-sessao text-left'>
                            <td class='text-left'>
                                NADA CONSTA
                            </td>
                            <td class='text-center'> 0 </td>
                        </tr>   
                    </tbody>
                </table>
                </div>";
            } else {
                $dados_pdf .= "   
                <div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (+) TEMPO DE SERVIÇO PRESTADO À ÓRGÃO PÚBLICO </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>";

                        foreach ($certidao->tempoorgaopublico as $key => $t) {

                            $t->dt_inicio = date('d/m/Y', strtotime($t->dt_inicio));
                            $t->dt_fim = date('d/m/Y', strtotime($t->dt_fim));
                            if ((date('Y/m/d', strtotime($t->dt_boletim)) == $t->dt_boletim) || (date('Y-m-d', strtotime($t->dt_boletim)) == $t->dt_boletim)) {
                                $t->dt_boletim = strftime('%d de %B de %Y', strtotime($t->dt_boletim));
                            }

                            $dados_pdf .= "
                                <tr class='corpo-sub-sessao text-left'>
                                    <td class='text-left'>
                                        Empregador: {$t->st_motivo} <br>
                                        De {$t->dt_inicio}    até {$t->dt_fim} 
                                        - {$t->nu_diasextenso}. <br>
                                        {$t->st_boletim} de {$t->dt_boletim}.
                                    </td>
                                    <td class='text-center'> {$t->nu_dias} </td>
                                </tr>
                            ";
                        }

                $dados_pdf .= "
                    </tbody>
                </table>
                </div>";
            }
            

            if (empty($certidao->tempoorgaoprivado)) {
                $dados_pdf .= 
                "<div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (+) TEMPO DE SERVIÇO PRESTADO A INICIATIVA PRIVADA </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='corpo-sub-sessao text-left'>
                            <td class='text-left'>
                                NADA CONSTA
                            </td>
                            <td class='text-center'> 0 </td>
                        </tr>   
                    </tbody>
                </table>
                </div>";
            } else {
                $dados_pdf .= "   
                <div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (+) TEMPO DE SERVIÇO PRESTADO A INICIATIVA PRIVADA </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>";

                        foreach ($certidao->tempoorgaoprivado as $key => $t) {

                            $t->dt_inicio = date('d/m/Y', strtotime($t->dt_inicio));
                            $t->dt_fim = date('d/m/Y', strtotime($t->dt_fim));
                            if ((date('Y/m/d', strtotime($t->dt_boletim)) == $t->dt_boletim) || (date('Y-m-d', strtotime($t->dt_boletim)) == $t->dt_boletim)) {
                                $t->dt_boletim = strftime('%d de %B de %Y', strtotime($t->dt_boletim));
                            }

                            $dados_pdf .= "
                                <tr class='corpo-sub-sessao text-left'>
                                    <td class='text-left'>
                                        Empregador: {$t->st_motivo} <br>
                                        De {$t->dt_inicio}    até {$t->dt_fim} 
                                        - {$t->nu_diasextenso}. <br>
                                        {$t->st_boletim} de {$t->dt_boletim}.
                                    </td>
                                    <td class='text-center'> {$t->nu_dias} </td>
                                </tr>
                            ";
                        }

                $dados_pdf .= "
                    </tbody>
                </table>
                </div>";
            }


            if (empty($certidao->tempolicencas)) {
                $dados_pdf .= 
                "<div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (+) LICENÇAS ESPECIAIS NÃO GOZADAS COMPUTADAS EM DOBRO </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='corpo-sub-sessao text-left'>
                            <td class='text-left'>
                                NADA CONSTA
                            </td>
                            <td class='text-center'> 0 </td>
                        </tr>   
                    </tbody>
                </table>
                </div>";
            } else {
                $dados_pdf .= "   
                <div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (+) LICENÇAS ESPECIAIS NÃO GOZADAS COMPUTADAS EM DOBRO </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>";
                        foreach ($certidao->tempolicencas as $key => $l) {

                        $l->dt_inicio = date('d/m/Y', strtotime($l->dt_inicio));
                        $l->dt_fim = date('d/m/Y', strtotime($l->dt_fim));
                        if ((date('Y/m/d', strtotime($l->dt_boletim)) == $l->dt_boletim) || (date('Y-m-d', strtotime($l->dt_boletim)) == $l->dt_boletim)) {
                            $l->dt_boletim = strftime('%d de %B de %Y', strtotime($l->dt_boletim));
                        }

                        $dados_pdf .= "
                            <tr class='corpo-sub-sessao text-left'>
                                <td class='text-left'>
                                    {$l->st_decenio}º decênio   
                                    - de {$l->dt_inicio}    até {$l->dt_fim} 
                                    - {$l->nu_diasextenso}. <br>
                                    {$l->st_boletim} de {$l->dt_boletim}.
                                </td>
                                <td class='text-center'> {$l->nu_dias} </td>
                            </tr>
                        ";
                    }
                $dados_pdf .= "
                    </tbody>
                </table>
                </div>";
            }


            if (empty($certidao->tempoferias)) {
                $dados_pdf .= 
                "<div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (+) FÉRIAS NÃO GOZADAS COMPUTADAS EM DOBRO </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='corpo-sub-sessao text-left'>
                            <td class='text-left'>
                                NADA CONSTA
                            </td>
                            <td class='text-center'> 0 </td>
                        </tr>   
                    </tbody>
                </table>
                </div>";
            } else {        
                $dados_pdf .= "   
                <div class='col-md-12'>
                <div class='titulo-sub-sessao borda1' > (+) FÉRIAS NÃO GOZADAS COMPUTADAS EM DOBRO </div>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-3'> ANO </th>
                            <th class='col-md-6'> BG DE AVERBAÇÃO </th>
                            <th >QUANTIDADE DE DIAS</th>
                        </tr>
                    </thead>
                    <tbody>";

                        foreach ($certidao->tempoferias as $key => $f) {

                            $f->dt_inicio = date('d/m/Y', strtotime($f->dt_inicio));
                            $f->dt_fim = date('d/m/Y', strtotime($f->dt_fim));
                            if ((date('Y/m/d', strtotime($f->dt_boletim)) == $f->dt_boletim) || (date('Y-m-d', strtotime($f->dt_boletim)) == $f->dt_boletim)) {
                                $f->dt_boletim = strftime('%d de %B de %Y', strtotime($f->dt_boletim));
                            }

                            $dados_pdf .= "
                                <tr class='corpo-sub-sessao'>
                                    <td class='text-left'> {$f->st_ano} </td>
                                    <td class='text-left'> {$f->st_boletim} de {$f->dt_boletim} </td>
                                    <td class='text-center'> {$f->nu_dias} </td>
                                </tr>
                            ";
                        }
                $dados_pdf .= "
                    </tbody>
                </table> 
                </div>";
            }

            //array com as ce_qpmpm do quadro de saúde
            $qpmpSaude = ['7', '14', '16', '22', '24', '28'];

            if (in_array($certidao->qualificacao->ce_qpmp, $qpmpSaude)) {
                if (empty($certidao->tempoficticio)) {
                    $dados_pdf .= 
                    "<div class='col-md-12 mt-10'>
                    <table class='table'>
                        <thead>
                            <tr class='col-md-12'>
                                <th class='col-md-9'> (+) TEMPO FICTÍCIO </th>
                                <th class=''> QUANTIDADE DE DIAS </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class='corpo-sub-sessao text-left'>
                                <td class='text-left'>
                                    NADA CONSTA
                                </td>
                                <td class='text-center'> 0 </td>
                            </tr>   
                        </tbody>
                    </table>
                    </div>";
                } else {        
                    $dados_pdf .= "   
                    <div class='col-md-12 mt-10'>
                    <table class='table'>
                        <thead>
                            <tr class='col-md-12'>
                                <th class='col-md-9'> (+) TEMPO FICTÍCIO </th>
                                <th class=''> QUANTIDADE DE DIAS </th>
                            </tr>
                        </thead>
                        <tbody>";

                            foreach ($certidao->tempoficticio as $key => $tf) {

                                $tf->dt_inicio = date('d/m/Y', strtotime($tf->dt_inicio));
                                $tf->dt_fim = date('d/m/Y', strtotime($tf->dt_fim));
                                if ((date('Y/m/d', strtotime($tf->dt_boletim)) == $tf->dt_boletim) || (date('Y-m-d', strtotime($tf->dt_boletim)) == $tf->dt_boletim)) {
                                    $tf->dt_boletim = strftime('%d de %B de %Y', strtotime($tf->dt_boletim));
                                }

                                $dados_pdf .= "
                                    <tr class='corpo-sub-sessao text-left'>
                                        <td class='text-left'>
                                            Motivo: {$tf->st_motivo} <br>
                                            De {$tf->dt_inicio}    até {$tf->dt_fim} 
                                            - {$tf->nu_diasextenso}. <br>
                                            {$tf->st_boletim} de {$tf->dt_boletim}.
                                        </td>
                                        <td class='text-center'> {$tf->nu_dias} </td>
                                    </tr>
                                ";
                            }
                    $dados_pdf .= "
                        </tbody>
                    </table>
                    </div>";
                }
            }

            
                    
            if (empty($certidao->temponaocomputado)) {
                $dados_pdf .= 
                "<div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (-) TEMPO DE SERVIÇO NÃO COMPUTADO / CONCOMITANTE </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='corpo-sub-sessao text-left'>
                            <td class='text-left'>
                                NADA CONSTA
                            </td>
                            <td class='text-center'> 0 </td>
                        </tr>   
                    </tbody>
                </table>
                </div>";
            } else {        
                $dados_pdf .= "   
                <div class='col-md-12 mt-10'>
                <table class='table'>
                    <thead>
                        <tr class='col-md-12'>
                            <th class='col-md-9'> (-) TEMPO DE SERVIÇO NÃO COMPUTADO / CONCOMITANTE </th>
                            <th class=''> QUANTIDADE DE DIAS </th>
                        </tr>
                    </thead>
                    <tbody>";

                        foreach ($certidao->temponaocomputado as $key => $tnc) {
                            
                            $tnc->dt_inicio = date('d/m/Y', strtotime($tnc->dt_inicio));
                            $tnc->dt_fim = date('d/m/Y', strtotime($tnc->dt_fim));
                            if ((date('Y/m/d', strtotime($tnc->dt_boletim)) == $tnc->dt_boletim) || (date('Y-m-d', strtotime($tnc->dt_boletim)) == $tnc->dt_boletim)) {
                                $tnc->dt_boletim = strftime('%d de %B de %Y', strtotime($tnc->dt_boletim));
                            }

                            $dados_pdf .= "
                            <tr class='corpo-sub-sessao text-left'>
                                <td class='text-left'>
                                    Motivo: {$tnc->st_motivo} <br>
                                    De {$tnc->dt_inicio}    até {$tnc->dt_fim} 
                                    - {$tnc->nu_diasextenso}. <br>
                                    {$tnc->st_boletim} de {$tnc->dt_boletim}.
                                </td>
                                <td class='text-center'> {$tnc->nu_dias} </td>
                            </tr>
                            ";
                        }
                $dados_pdf .= "
                    </tbody>
                </table>
                </div>";
            }


                    $dados_pdf .= "
                    <div class='col-md-12'>
                        <div class='titulo-sub-sessao borda1' >
                            TEMPO TOTAL (EFETIVO SERVIÇO*¹ / CONTRIBUIÇÃO*² / FICTÍCIO*³) 
                        </div>
                    </div>
                    <div class='borda1 col-md-12'>
                        <b> {$certidao->tempototal->nu_dias} (dias) que correspondem a {$certidao->tempototal->nu_diasextenso}. <b>
                    </div>



                    <div class='col-md-10'>
                        <div class='titulo-sub-sessao borda1' >
                            COMPLETOU / COMPLETARÁ 30 (trinta) ANOS DE EFETIVO SERVIÇO EM
                        </div>
                    </div>
                    <div class='borda1 text-center mt-10'>
                        <b> {$certidao->dt_completoutempo} <b>
                    </div>



                    <div class='col-md-10 borda1 titulo-sub-sessao'>
                        NÍVEL P/ PERCEPÇÃO DO SUBSÍDIO, CONFORME LEI COMPLEMENTAR <br> Nº 463/2012
                    </div>
                    <div class='borda1 text-center mt-10'>
                        <b> <br> {$certidao->qualificacao->st_nivel} <b>
                    </div>";

                    if (isset($certidao->assinaturas) && count($certidao->assinaturas) > 0) {
                        $auxiliarAssinou = -1; 
                        $auxiliarDP = ''; 
                        $chefeAssinou = -1; 
                        $chefeDP = ''; 
                        foreach ($certidao->assinaturas as $key => $a) {
                            if ($a->st_funcaoassinante == 'CHEFEDP2' || $a->st_funcaoassinante == 'CHEFEDP4') {
                                 $chefeAssinou = $key;
                                 $chefeDP = ($a->st_funcaoassinante == 'CHEFEDP2' ? 'DP/2' : 'DP/4');  
                            } elseif ($a->st_funcaoassinante == 'AUXILIARDP2' || $a->st_funcaoassinante == 'AUXILIARDP4') {
                                 $auxiliarAssinou = $key;
                                 $auxiliarDP = ($a->st_funcaoassinante == 'AUXILIARDP2' ? 'DP/2' : 'DP/4'); 
                            }
                        }
                        $dataChefeAssinou = date('d/m/Y', strtotime($certidao->assinaturas[$chefeAssinou]->dt_cadastro));
                        $dataChefeAssinou .= ' às ' . date('H:i:s', strtotime($certidao->assinaturas[$chefeAssinou]->dt_cadastro));
                            
                        $dataAuxiliarAssinou = date('d/m/Y', strtotime($certidao->assinaturas[$auxiliarAssinou]->dt_cadastro));
                        $dataAuxiliarAssinou .= ' às ' . date('H:i:s', strtotime($certidao->assinaturas[$auxiliarAssinou]->dt_cadastro));
                    }

                    $dados_pdf .= "
                    <div class='col-md-6 border corpo-sub-sessao text-left mt-10'> 
                        Lavrei a Certidão que não contém emendas nem rasuras. <br><br>
                        Natal/RN, {$dataAtual}. <br><br>
                        <div class='text-center'>
                            Assinado eletronicamente por <br>
                            {$certidao->assinaturas[$auxiliarAssinou]->st_nomeassinante} - {$certidao->assinaturas[$auxiliarAssinou]->st_postogradassinante} PM <br>
                            Auxiliar $auxiliarDP <br>
                            em $dataAuxiliarAssinou <br>
                        </div>
                    </div>
                    <div class=' border corpo-sub-sessao text-left'> 
                        Visto do Chefe da {$certidao->dp}. <br><br>
                        Natal/RN, {$dataAtual}. <br><br>
                        <div class='text-center'>
                            Assinado eletronicamente por <br>
                            {$certidao->assinaturas[$chefeAssinou]->st_nomeassinante} - {$certidao->assinaturas[$chefeAssinou]->st_postogradassinante} PM <br>
                            Chefe da $chefeDP <br>
                            em $dataChefeAssinou <br>
                        </div>
                    </div>



                    <div class='obs'>
                        (1) Tempo de serviço na pmrn; <br>
                        (2) Tempo de serviço prestado a iniciativa privada e outros órgão públicos; <br>
                        (3) Tempo averbado para contagem em dobro, conforme lei estadual nº 4.630, de 16 de dezembro de 1976.
                    </div>";

    } 
               


            
            
$dados_pdf .= " 
            </div>
        </div>";
                            

        $footer = "<div>Certidão de Tempo de Serviço / DP / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " em " . date('d/m/Y - H:m:s');
    // $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output("Certidão de Tempo de Serviço - {$certidao->qualificacao->st_nome}.pdf", \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 