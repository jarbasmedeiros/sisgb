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
                        Diretoria de Pessoal<BR/>
                    </div>
                    <div class='brasao'>
                        <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                    </div>
                    <div class='titulocaderneta'>
                        CADERNETA DE REGISTROS (CR)
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
        $dados_pdf .= "</tr>
        <tr>
            <th class='legandatitulo' colspan='8'>CURSOS ACADÊMICOS</th>
        </tr>
        <tr>
            <th colspan='2'><span class='title'>NOME</span></th>
            <th colspan='1'><span class='title'>INSTITUIÇÃO</span></th>
            <th colspan='1'><span class='title'>TIPO</span></th>
            <th colspan='1'><span class='title'>DATA DE CONCLUSÃO</span></th>
            <th colspan='1'><span class='title'>MÉDIA FINAL</span></th>
            <th colspan='1'><span class='title'>PUBLICAÇÃO</span></th>
            <th colspan='1'><span class='title'>DATA DA PUBLICAÇÃO</span></th>
        </tr>";
        if(isset($cadernetaRegistro->cursosacademicos) && count($cadernetaRegistro->cursosacademicos)>0){
                foreach($cadernetaRegistro->cursosacademicos as $c){
                    $dados_pdf .= "<tr>";
                        $dados_pdf .= "<td colspan='2'>" . $c->st_curso . "</td>";
                        $dados_pdf .= "<td colspan='1'>" . $c->st_instituicao . "</td>";
                        $dados_pdf .= "<td colspan='1'>" . $c->st_tipo . "</td>";
                        $dados_pdf .= "<td colspan='1'>"; 
                        if(!empty($c->dt_conclusao)){
                            $dados_pdf .= \Carbon\Carbon::parse($c->dt_conclusao)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>";
                        $dados_pdf .= "<td colspan='1'>" . $c->st_mediafinal . "</td>";
                        $dados_pdf .= "<td colspan='1'>" . $c->st_boletim . "</td>";
                        $dados_pdf .= "<td colspan='1'>"; 
                        if(!empty($c->dt_publicacao)){
                            $dados_pdf .= \Carbon\Carbon::parse($c->dt_publicacao)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>";
                    $dados_pdf .= "</tr>";
                }
            }else{
                $dados_pdf .= " <tr> 
                                    <td colspan='8'>Nenhum curso acadêmico cadastrado para este policial.</span></td>
                                </tr>";
            }

        $dados_pdf .= "
        <tr>
            <th class='legandatitulo' colspan='8'>CURSOS DA CASERNA</th>
        </tr>
        <tr>
            <th colspan='4'><span class='title'>NOME</span></th>
            <th colspan='1'><span class='title'>DATA DE CONCLUSÃO</span></th>
            <th colspan='1'><span class='title'>MÉDIA FINAL</span></th>
            <th colspan='1'><span class='title'>PUBLICAÇÃO</span></th>
            <th colspan='1'><span class='title'>DATA DA PUBLICAÇÃO</span></th>
        </tr>";
            if(isset($cadernetaRegistro->cursos) && count($cadernetaRegistro->cursos)>0){
                foreach($cadernetaRegistro->cursos as $c){
                    $dados_pdf .= "<tr>";
                        $dados_pdf .= "<td colspan='4'>" . $c->st_curso . "</td>";
                        $dados_pdf .= "<td colspan='1'>"; 
                        if(!empty($c->dt_conclusao)){
                            $dados_pdf .= \Carbon\Carbon::parse($c->dt_conclusao)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>";
                        $dados_pdf .= "<td colspan='1'>" . $c->st_mediafinal . "</td>";
                        $dados_pdf .= "<td colspan='1'>" . $c->st_boletim . "</td>";
                        $dados_pdf .= "<td colspan='1'>"; 
                        if(!empty($c->dt_publicacao)){
                            $dados_pdf .= \Carbon\Carbon::parse($c->dt_publicacao)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>";
                    $dados_pdf .= "</tr>";
                }
            }else{
                $dados_pdf .= " <tr> 
                                    <td colspan='8'>Nenhum curso cadastrado para este policial.</span></td>
                                </tr>";
            }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>PROMOÇÕES</th>
        </tr>
        <tr>
            <th colspan='2'><span class='title'>PROMOÇÃO</span></th>
            <th colspan='2'><span class='title'>DATA DA PROMOÇÃO</span></th>
            <th colspan='2'><span class='title'>BG DA PROMOÇÃO</span></th>
            <th colspan='2'><span class='title'>DATA DO BG</span></th>
        </tr>";
            if(isset($cadernetaRegistro->promocoes) && count($cadernetaRegistro->promocoes)>0){
                foreach($cadernetaRegistro->promocoes as $p){
                    $dados_pdf .= "<tr>";
                        $dados_pdf .= "<td colspan='2'>" . $p->st_promocao . "</td>";
                        $dados_pdf .= "<td colspan='2'>"; 
                        if(!empty($p->dt_promocao)){
                            $dados_pdf .= \Carbon\Carbon::parse($p->dt_promocao)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>";
                        $dados_pdf .= "<td colspan='2'>" . $p->st_boletim . "</td>";
                        $dados_pdf .= "<td colspan='2'>"; 
                        if(!empty($p->dt_boletim)){
                            $dados_pdf .= \Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>";
                    $dados_pdf .= "</tr>";
                }
            }else{
                $dados_pdf .= " <tr>
                                    <td colspan='8'>Nenhuma promoção cadastrada para este policial.</span></td>
                                </tr>";
            }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>FÉRIAS</th>
        </tr>
        <tr>
            <th colspan='1'><span class='title'>INÍCIO</span></th>
            <th colspan='1'><span class='title'>FIM</span></th>
            <th colspan='1'><span class='title'>QTD DE DIAS</span></th>
            <th colspan='1'><span class='title'>ANO REFERÊNCIA</span></th>
            <th colspan='4'><span class='title'>OBSERVAÇÃO</span></th>
        </tr>";
        if(isset($cadernetaRegistro->ferias) && count($cadernetaRegistro->ferias)>0){
            foreach($cadernetaRegistro->ferias as $f){
                $dados_pdf .= "<tr>
                    <td colspan='1'>";
                        if(!empty($f->dt_inicio)){
                            $dados_pdf .= \Carbon\Carbon::parse($f->dt_inicio)->format('d/m/Y');
                        }
                    $dados_pdf .= "</th>
                    <td colspan='1'>";
                        if(!empty($f->dt_fim)){
                            $dados_pdf .= \Carbon\Carbon::parse($f->dt_fim)->format('d/m/Y');
                        }
                    $dados_pdf .= "</td>";
                    $dados_pdf .= "<td colspan='1'>" . $f->nu_dias . "</th>";
                    $dados_pdf .= "<td colspan='1'>" . $f->st_anoreferencia . "</td>";
                    $dados_pdf .= "<td colspan='4'>" . $f->st_descricao . "</td>";
                $dados_pdf .= "</tr>";
            }
        }else{
            $dados_pdf .= " <tr>
                                <td colspan='8'>Não existem férias cadastradas para este policial.</span></td>
                            </tr>";
        }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>LICENÇAS</th>
        </tr>
        <tr>
            <th colspan='1'><span class='title'>INÍCIO</span></th>
            <th colspan='1'><span class='title'>FIM</span></th>
            <th colspan='1'><span class='title'>DIAS</span></th>
            <th colspan='2'><span class='title'>TIPO</span></th>
            <th colspan='1'><span class='title'>SITUAÇÃO</span></th>
            <th colspan='2'><span class='title'>OBSERVAÇÕES</span></th>
        </tr>";
        if(isset($cadernetaRegistro->licencas) && count($cadernetaRegistro->licencas)>0){
            foreach($cadernetaRegistro->licencas as $l){
                $dados_pdf .= "<tr>";
                    $dados_pdf .= "<td colspan='1'>";
                        if(!empty($l->dt_inicio)){
                            $dados_pdf .= \Carbon\Carbon::parse($l->dt_inicio)->format('d/m/Y');
                        }
                    $dados_pdf .= "</td>
                    <td colspan='1'>";
                        if(!empty($l->dt_termino)){
                            $dados_pdf .= \Carbon\Carbon::parse($l->dt_termino)->format('d/m/Y');
                        }
                    $dados_pdf .= "</td>
                    <td colspan='1'>" . $l->nu_dias . "</td>
                    <td colspan='2'>" . $l->tipo->st_tipo . "</td>
                    <td colspan='1'> Foram usufruídos "; 
                    if (empty($l->nu_dias_gozadas)) {
                        $dados_pdf .= "0 dias</td>";
                    } else {
                        $dados_pdf .= $l->nu_dias_gozadas . " dias</td>";
                    }
                    $dados_pdf .= "<td colspan='2'>" . $l->st_obs . "</td>
                </tr>";
            }
        }else{
            $dados_pdf .= " <tr>
                                <td colspan='8'>Nenhuma Licença cadastrada para este policial.</span></td>
                            </tr>";
        }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>MEDALHAS</th>
        </tr>
        <tr>
            <th colspan='3'><span class='title'>NOME</span></th>
            <th colspan='1'><span class='title'>TIPO</span></th>
            <th colspan='2'><span class='title'>PUBLICAÇÃO</span></th>
            <th colspan='2'><span class='title'>DATA DA PUBLICAÇÃO</span></th>
        </tr>";
            if(isset($cadernetaRegistro->medalhas) && count($cadernetaRegistro->medalhas)>0){
                foreach($cadernetaRegistro->medalhas as $m){
                    $dados_pdf .= "<tr>";
                        $dados_pdf .= "<td colspan='3'>" . $m->st_nome . "</td>";
                        $dados_pdf .= "<td colspan='1'>" . $m->st_tipo . "</td>";
                        $dados_pdf .= "<td colspan='2'>" . $m->st_publicacao . "</td>";
                        $dados_pdf .= "<td colspan='2'>"; 
                        if(!empty($m->dt_publicacao)){
                            $dados_pdf .= \Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y');
                        }
                        $dados_pdf .= "</td>";
                    $dados_pdf .= "</tr>";
                }
            }else{
                $dados_pdf .= " <tr>
                                    <td colspan='8'>Nenhuma medalha cadastrada para este policial.</span></td>
                                </tr>";
            }
        $dados_pdf .= "<tr>
            <th class='legandatitulo' colspan='8'>PUBLICAÇÕES</th>
        </tr>
        </table>";
        if(isset($cadernetaRegistro->publicacoes) && count($cadernetaRegistro->publicacoes)>0){
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


                 
            }
        }else{
            $dados_pdf .= "
                <div class='col-md-12 border'>
                    <b> Nenhuma publicação cadastrada para este policial. </b>
                </div>
            ";
        }
    }

    $dados_pdf .= "
                </div>
                </div>";

    $footer = "<div>Caderneta de Registros / DP / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
    
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output($cadernetaRegistro->qualificacao->st_nome . ' - Caderneta de Registros.pdf', \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 