<html lang="pt-BR">

<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
</head>


<body>
    <!-- RESPONSIVE TABLE -->
    <?php  //declaramos uma variavel para monstarmos a tabela
    error_reporting(0);                 // Tira mensagem de erro no chrome
    ini_set('display_errors', 0);       // Tira mensagem de erro no chrome
    define('MPDF_PATH', 'class/mpdf/');
    include('mpdf/mpdf.php');
    $mpdf = new mPDF();
    $css = "";
    $css = file_get_contents('assets/css/fichapdf.css');
    $mpdf->WriteHTML($css, 1);
    

    $header = "";
    $dados_pdf = "";
    $dados_pdf .= "
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/Brasao_RN.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='cab-corpo'>
                        Governo do Estado do Rio Grande do Norte<br/>
                        Secretaria da Segurança Pública e da Defesa Social<br/>
                        Setor de Recursos Humanos/SESED<BR/>
                    </div>
                    <div class='brasao'>";
                        if(isset($servidor->st_caminhofoto)){
                            $dados_pdf .= "<img class='img-responsive' src='data:image/jpeg;base64, ". $img ."' width='90' height='120' alt='logo'/>";
                        }
                    $dados_pdf .= "</div>
                    <div class='titulocaderneta'>
                        CADERNETA DE ANOTAÇÕES
                    </div>
                ";

    
    $dados_pdf .= "<table class='table'>
        <tr>
            <th class='legandatitulo' colspan='8'> DADOS PESSOAIS</th>
        </tr>";
    if(isset($servidor)) {
        $dados_pdf .= "<tr>";
            $dados_pdf .= "<th colspan='3'><span class='title'>Nome:</span><br />" . $servidor->st_nome . " </th>";
            $dados_pdf .= "<th colspan='1'><span class='title'>Data Nascimento:</span><br />"; 
                if(!empty($servidor->dt_nascimento)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_nascimento)->format('d/m/Y');
                }
            $dados_pdf .= "</th>";
            $dados_pdf .= " <th colspan='2'><span class='title'>Sexo:</span><br />" . (($servidor->st_sexo == 'F') ? "Feminino" : "Masculino") . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Tipo Saguineo/Fator RH:</span><br />" . $servidor->st_tiposanguineo . " " . $servidor->st_fatorh . "</th>";
        $dados_pdf .= "</tr>";
        $dados_pdf .= "<tr>";
            $dados_pdf .= "<th colspan='4'><span class='title'>Nacionalidade:</span><br />" . $servidor->st_nacionalidade . "</th>";
            $dados_pdf .= "<th colspan='4'><span class='title'>UF Naturalidade:</span><br />" . $servidor->st_naturalidade . "/" . $servidor->st_ufnaturalidade . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='4'><span class='title'>Filiação - Nome do pai:</span><br />" . $servidor->st_pai . "</th>";
            $dados_pdf .= "<th colspan='4'><span class='title'>Filiação - Nome da mãe:</span><br />" . $servidor->st_mae . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='3'><span class='title'>Endereço:</span><br />" . $servidor->st_logradouro . "</th>";
            $dados_pdf .= "<th colspan='1'><span class='title'>Número:</span><br />" . $servidor->st_numeroresidencia . "</th>";
            $dados_pdf .= "<th colspan='4'><span class='title'>Complemento:</span><br />" . $servidor->st_complemento . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='3'><span class='title'>Bairro:</span><br />" . $servidor->st_bairro . "</th>";
            $dados_pdf .= "<th colspan='1'><span class='title'>CEP:</span><br />" . $servidor->st_cep . "</th>";
            $dados_pdf .= "<th colspan='3'><span class='title'>Cidade:</span><br />" . $servidor->st_cidade . "</th>";
            $dados_pdf .= "<th colspan='1'><span class='title'>UF:</span><br />" . $servidor->st_uf . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Telefone Residencial:</span><br />" . $servidor->st_telefoneresidencial . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Telefone Celular:</span><br />" . $servidor->st_telefonecelular . "</th>";
            $dados_pdf .= "<th colspan='4'><span class='title'>E-mail:</span><br />" . $servidor->st_email . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='2'><span class='title'>cpf:</span><br />" . $servidor->st_cpf . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Registro Geral:</span><br />" . $servidor->st_rg . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Órgão Emissor:</span><br />" . $servidor->st_orgaorg . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Data de Emissão:</span><br />"; 
                if(!empty($servidor->dt_emissaorg)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_emissaorg)->format('d/m/Y');
                }
            $dados_pdf .= "</th>
        </tr>
        <tr>";
            $dados_pdf .= "<th colspan='3'><span class='title'>Estado Civil:</span><br />" . $servidor->st_estadocivil . "</th>";
            $dados_pdf .= "<th colspan='5'><span class='title'> Cônjuge:</span><br />" . $servidor->st_conjuge . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Altura:</span><br />" . $servidor->st_altura . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Cor:</span><br />" . $servidor->st_cor . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Olhos:</span><br />" . $servidor->st_olhos . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Cabelos:</span><br />" . $servidor->st_cabelos . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Título Eleitoral:</span><br />" . $servidor->nu_titulo . "</th>";
            $dados_pdf .= "<th colspan='1'><span class='title'> Zona:</span><br />" . $servidor->nu_zonatitulo . "</th>";
            $dados_pdf .= "<th colspan='1'><span class='title'> Sessão:</span><br />" . $servidor->nu_secaotitulo . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Cidade:</span><br />" . $servidor->st_municipiotitulo . "</th>";
            $dados_pdf .= "<th colspan='1'><span class='title'> UF:</span><br />" . $servidor->st_uftitulo . "</th>";
            $dados_pdf .= "<th colspan='1'><span class='title'> Data de Emissão:</span><br />";
                if(!empty($servidor->dt_emissaotitulo)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_emissaotitulo)->format('d/m/Y');
                }
            $dados_pdf .= "</th>
        </tr>
        <tr>";
            $dados_pdf .= "<th colspan='4'><span class='title'>CNH:</span><br />" . $servidor->st_municipiotitulo . "</th>";
            $dados_pdf .= "<th colspan='1'><span class='title'>Categoria:</span><br />" . $servidor->st_categoriacnh . "</th>";
            $dados_pdf .= "<th colspan='3'><span class='title'> Data de Emissão:</span><br />";
                if(!empty($servidor->dt_emissaocnh)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_emissaocnh)->format('d/m/Y');
                }
            $dados_pdf .= "</th>
        </tr>
        <tr>";
            $dados_pdf .= "<th colspan='2'><span class='title'> Data de Validade:</span><br />";
                if(!empty($servidor->dt_vencimentocnh)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_vencimentocnh)->format('d/m/Y');
                }
            $dados_pdf .= "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>UF:</span><br />" . $servidor->st_ufcnh . "</th>";
            $dados_pdf .= "<th colspan='4'><span class='title'>PIS/PASEP:</span><br />" . $servidor->nu_pis_pasep . "</th>";
        $dados_pdf .= "</tr>
        <tr>
            <th class='legandatitulo' colspan='8'>DADOS FUNCIONAIS</th>
        </tr>
        <tr>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Matricula:</span><br />" . $servidor->st_matricula . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Órgão:</span><br />" . $servidor->st_siglaorgao . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Incorp. Org. Origem:</span><br />"; 
                if(!empty($servidor->dt_incorporacao)){
                    \Carbon\Carbon::parse($servidor->dt_incorporacao)->format('d/m/Y');
                }
            $dados_pdf .= "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Cargo/posto/Graduação:</span><br />" . $servidor->st_postograduacao . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Nomeação:</span><br />";
                if(!empty($servidor->dt_nomeacao)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_nomeacao)->format('d/m/Y');
                }
            $dados_pdf .= "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Posse:</span><br />";
                if(!empty($servidor->dt_posse)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_posse)->format('d/m/Y');
                }
            $dados_pdf .= "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Exercício:</span><br />";
                if(!empty($servidor->dt_exercicio)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_exercicio)->format('d/m/Y');
                }
            $dados_pdf .= "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Data inclusão (SESED):</span><br />";
                if(!empty($servidor->dt_inclusao)){
                    $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_inclusao)->format('d/m/Y');
                }
            $dados_pdf .= "</th>
        </tr>
        <tr>";
            $dados_pdf .= "<th colspan='3'><span class='title'>Local de Trabalho:</span><br />" . $servidor->st_setor . "</th>";
            $dados_pdf .= "<th colspan='5'><span class='title'>Função:</span><br />" . $servidor->st_funcao . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Nome de Guerra:</span><br />" . $servidor->st_nomeguerra . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Número de Praça:</span><br />" . $servidor->st_numeropraca . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Quadro Operacional - QO:</span><br />" . $servidor->st_quadrooperacional . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>RG Funcional:</span><br />" . $servidor->st_rgfuncional . "</th>";
        $dados_pdf .= "</tr>
        <tr>";
            $dados_pdf .= "<th colspan='4'><span class='title'>Comportamento:</span><br />" . $servidor->st_comportamento . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>BG do Comportamento:</span><br />" . $servidor->st_bgcomportamento . "</th>";
            $dados_pdf .= "<th colspan='2'><span class='title'>Data do BG do Comportamento:</span><br />";
            if(!empty($servidor->dt_bgcomportamento)){
                $dados_pdf .= \Carbon\Carbon::parse($servidor->dt_bgcomportamento)->format('d/m/Y');
            }
            $dados_pdf .= "</th>";
        $dados_pdf .= "</tr>
        <tr>
            <th class='legandatitulo' colspan='8'>DADOS ACADÊMICOS</th>
        </tr>
        <tr>
            <th colspan='3'><span class='title'>CURSO</span></th>
            <th colspan='3'><span class='title'>NÍVEL</span></th>
            <th colspan='2'><span class='title'>DATA DE CONCLUSÃO</span></th>
        </tr>";
            if(isset($cursos) && count($cursos)>0){
                foreach($cursos as $c){
                    $dados_pdf .= "<tr>";
                        $dados_pdf .= "<th colspan='3'><br />" . $c->st_nome . "</th>";
                        $dados_pdf .= "<th colspan='3'><br />" . $c->st_cursoescolaridade . "</th>";
                        $dados_pdf .= "<th colspan='2'><br />"; 
                        if(!empty($c->dt_conclusao)){
                            $dados_pdf .= \Carbon\Carbon::parse($c->dt_conclusao)->format('d/m/Y');
                        }
                        $dados_pdf .= "</th>";
                    $dados_pdf .= "<tr>";
                }
            }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>FÉRIAS</th>
        </tr>
        <tr>
            <th colspan='1'><span class='title'>INÍCIO</span></th>
            <th colspan='1'><span class='title'>FIM</span></th>
            <th colspan='1'><span class='title'>ANO REFERENTE</span></th>
            <th colspan='5'><span class='title'>OBSERVAÇÃO</span></th>
        </tr>";
        if(isset($ferias) && count($ferias)>0){
            foreach($ferias as $fe){
                if(isset($fe) && count($fe)>0){
                    foreach($fe as $f){
                        $dados_pdf .= "<tr>
                            <th colspan='1'>";
                                if(!empty($f->dt_inicio)){
                                    $dados_pdf .= \Carbon\Carbon::parse($f->dt_inicio)->format('d/m/Y');
                                }
                            $dados_pdf .= "</th>
                            <th colspan='1'>";
                                if(!empty($f->dt_fim)){
                                    $dados_pdf .= \Carbon\Carbon::parse($f->dt_fim)->format('d/m/Y');
                                }
                            $dados_pdf .= "</th>";
                            $dados_pdf .= "<th colspan='1'>" . $f->nu_ano . "</th>";
                            $dados_pdf .= "<th colspan='5'>" . $f->st_descricao . "</th>";
                        $dados_pdf .= "</tr>";
                    }
                }
            }
        }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>LICENÇAS</th>
        </tr>
        <tr>
            <th colspan='3'><span class='title'>TIPO</span></th>
            <th colspan='3'><span class='title'>DOCUMENTO</span></th>
            <th colspan='1'><span class='title'>INÍCIO</span></th>
            <th colspan='1'><span class='title'>FIM</span></th>
        </tr>";
        if(isset($licencas) && count($licencas)>0){
            foreach($licencas as $l){
                $dados_pdf .= "<tr>";
                    $dados_pdf .= "<th colspan='3'>" . $l['4']->st_valor . "</th>";
                    $dados_pdf .= "<th colspan='3'>" . $l['3']->st_valor . "</th>";
                    $dados_pdf .= "<th colspan='1'>";
                        if(!empty($l['1']->st_valor)){
                            $dados_pdf .= \Carbon\Carbon::parse($l['1']->st_valor)->format('d/m/Y');
                        }
                    $dados_pdf .= "</th>
                    <th colspan='1'>";
                        if(!empty($l['2']->st_valor)){
                            $dados_pdf .= \Carbon\Carbon::parse($l['2']->st_valor)->format('d/m/Y');
                        }
                    $dados_pdf .= "</th>
                </tr>";
            }
        }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>PUBLICAÇÕES</th>
        </tr>
        <tr>
            <th colspan='1'><span class='title'>DATA DA PUBLICAÇÃO</span></th>
            <th colspan='3'><span class='title'>TIPO</span></th>
            <th colspan='3'><span class='title'>DOCUMENTO</span></th>
            <th colspan='1'><span class='title'>N° E DATA</span></th>
        </tr>";
        if(isset($publicacoes) && count($publicacoes)>0){
            foreach($publicacoes as $p){
                $dados_pdf .= "<tr>
                    <th colspan='1'>";
                        if(!empty($p['1']->st_valor)){
                            $dados_pdf .= \Carbon\Carbon::parse($p['1']->st_valor)->format('d/m/Y');
                        }
                    $dados_pdf .= "</th>";
                    $dados_pdf .= "<th colspan='3'>" . $p['0']->st_valor . "</th>";
                    $dados_pdf .= "<th colspan='3'>" . $p['2']->st_valor . "</th>";
                    $dados_pdf .= "<th colspan='1'>" . $p['3']->st_valor . "</th>";
                $dados_pdf .= "</tr>";
            }
        }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>HISTÓRICO</th>
        </tr>
        <tr>
            <th><span class='title'>DESCRIÇÃO</span></th>
            <th><span class='title'>ORGÃO</span></th>
            <th><span class='title'>CARGO</span></th>
            <th><span class='title'>DATA DE NOMEAÇÃO</span></th>
            <th><span class='title'>DATA DE EXERCÍCIO</span></th>
            <th><span class='title'>DATA DE POSSE</span></th>
            <th><span class='title'>DATA DA INATIVIDADE</span></th>
            <th><span class='title'>MOTIVO DA INATIVIDADE</span></th>
        </tr>";
        if(isset($historicos) && count($historicos)>0){
            foreach($historicos as $h){
                $dados_pdf .= "<tr>";
                    $dados_pdf .= "<th>";
                        $dados_pdf .= ($h->st_tipo) ? "Entrada" : "Saída";
                    $dados_pdf .= "</th>";
                    $dados_pdf .= "<th>" . $h->orgao . "</th>";
                    $dados_pdf .= "<th>" . $h->cargo . "</th>";
                    $dados_pdf .= "<th>" . ((!empty($h->dt_nomeacao)) ? \Carbon\Carbon::parse($h->dt_nomeacao)->format('d/m/Y') : "") . "</th>";
                    $dados_pdf .= "<th>" . ((!empty($h->dt_exercicio)) ? \Carbon\Carbon::parse($h->dt_exercicio)->format('d/m/Y') : "") . "</th>";
                    $dados_pdf .= "<th>" . ((!empty($h->dt_posse)) ? \Carbon\Carbon::parse($h->dt_posse)->format('d/m/Y') : "") . "</th>";
                    $dados_pdf .= "<th>" . ((!empty($h->dt_inatividade)) ? \Carbon\Carbon::parse($h->dt_inatividade)->format('d/m/Y') : "") . "</th>";
                    $dados_pdf .= "<th>" . $h->st_motivoinatividade . "</th>";
                $dados_pdf .= "</tr>";   
            }
        }else{
            $dados_pdf .= "<tr>
                <th colspan='8'>Não há histórico cadastrado<th>
            </tr>";
        }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>MOVIMENTAÇÕES</th>
        </tr>
        <tr>
            <th colspan='2'><span class='title'>DATA</span></th>
            <th colspan='2'><span class='title'>SETOR</span></th>
            <th colspan='4'><span class='title'>DESCRIÇÃO</span></th>
        </tr>";
        if(isset($movimentacoes) && count($movimentacoes)>0){
            foreach($movimentacoes as $m){
                $dados_pdf .= "<tr>
                    <th colspan='2'>";
                        if(!empty($m['0']->st_valor)){
                            $dados_pdf .= \Carbon\Carbon::parse($m['0']->st_valor)->format('d/m/Y');
                        }
                    $dados_pdf .= "</th>";
                    $dados_pdf .= "<th colspan='2'>" . $m['2']->st_valor . "</th>";
                    $dados_pdf .= "<th colspan='4'>" . $m['1']->st_valor . "</th>";
                $dados_pdf .= "</tr>";
            }
        }else{
            $dados_pdf .= "<tr>
                <th colspan='3'>Não há histórico cadastrado<th>
            </tr>";
        }
    }
    $dados_pdf .= "</table>";
    $footer = "";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
    // $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output();
    exit();
    ?>

</body>

</html> 