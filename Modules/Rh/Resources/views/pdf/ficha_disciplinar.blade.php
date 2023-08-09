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
    $mpdf = new mPDF('c', 'A4-L');
    $css = "";
    $css = file_get_contents('assets/css/rh/ficha_disciplinar.css');

    //insere a marca d'agua no PDF com o cpf do usuário logado
    $mpdf->SetWatermarkText(auth()->user()->matricula, 0.1);
    $mpdf->showWatermarkText = true;

    $mpdf->WriteHTML($css, 1);
    setlocale(LC_TIME, 'portuguese'); //Converte a data para o padrão BR
    date_default_timezone_set('America/Sao_Paulo'); //define o local da data
    
    $header = ""; 
    $dados_pdf = "";
    $dados_pdf .= "
        <div class='borda'>
            <div class='brasao mt-10'>
                <img class='img-responsive' src=" . URL::asset('/imgs/Brasao_RN.png') . " width='60' height='60' alt='logo'/>
            </div>
            <div class='cab-corpo'>
                RIO GRANDE DO NORTE<br/>
                SECRETARIA DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL<br/>
                POLÍCIA MILITAR<br/>
                DIRETORIA DE PESSOAL<br/>
               <b> FICHA DISCIPLINAR - PMRN </b><br/>
            </div>
            <div class='brasao'>
                <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
            </div>                
            <div class='row mt-10'>
                <div class='col-md-12 head'>
                    DADOS PESSOAIS
                </div>
                <div class='col-md-6 borda'>
                    <div class='row'>
                        <div class='col-md-12 borda'>
                            <div class='d-inline'>
                                <strong >Nome: </strong>{$fichaDisciplinar->qualificacao->st_nome}
                                
                            </div>
                        </div>
                        <div class='col-md-12 borda'>
                            <div class='col-md-12'>
                                
                                    <div class='text-center'><strong >Filiação </strong></div>
                                    <div><strong >Mãe: </strong>{$fichaDisciplinar->qualificacao->st_mae}</div>
                                    <div><strong >   Pai: </strong>{$fichaDisciplinar->qualificacao->st_pai}</div>
                                
                            </div>
                            
                        </div>
                            <div class='col-md-6 borda'><strong >   SEXO : </strong>{$fichaDisciplinar->qualificacao->st_sexo}</div>
                            <div class='borda'><strong >   NASCIDO EM : </strong>"; 
                            if (empty($fichaDisciplinar->qualificacao->dt_nascimento)) {
                                $dados_pdf .= "</div>";
                            } else {
                                $dados_pdf .= \Carbon\Carbon::parse($fichaDisciplinar->qualificacao->dt_nascimento)->format('d/m/Y')."</div>";
                            }
    $dados_pdf .=      "<div class='col-md-6 borda'><strong >   NATATURAL DE : </strong>{$fichaDisciplinar->qualificacao->st_naturalidade}</div>
                        <div class='borda'><strong >   ESTADO CIVIL : </strong>{$fichaDisciplinar->qualificacao->st_estadocivil}</div>
                        <div class='col-md-4 borda'><strong >   ALTURAL : </strong>{$fichaDisciplinar->qualificacao->st_altura}</div>
                        <div class='col-md-4 borda'><strong >   COR : </strong>{$fichaDisciplinar->qualificacao->st_cor}</div>
                        <div class='borda'><strong >   OLHOS : </strong>{$fichaDisciplinar->qualificacao->st_olhos}</div>
                        <div class='col-md-6 borda'><strong >   CABELOS : </strong>{$fichaDisciplinar->qualificacao->st_cabelos}</div>
                        <div class='col-md-12 borda'><strong >   GRAU DE INSTRUÇÃO : </strong>{$fichaDisciplinar->qualificacao->st_escolaridade}</div>
                        <div class='col-md-6 borda'><strong >   TIPO SANGUINEO : </strong>{$fichaDisciplinar->qualificacao->st_tiposanguineo}{$fichaDisciplinar->qualificacao->st_fatorrh}</div>
                        <div class='borda'><strong >  NOME DE GUERRA : </strong>{$fichaDisciplinar->qualificacao->st_nomeguerra}</div>
                        
                        <div class='col-md-12 head'>INCLUSÃO E EXCLUSÃO</div>
                        <div class='col-md-6'><strong >DATA DE INCLUSAO: </strong>";
                        if (empty($fichaDisciplinar->qualificacao->dt_incorporacao)) {
                            $dados_pdf .= "</div>";
                        } else {
                            $dados_pdf .= \Carbon\Carbon::parse($fichaDisciplinar->qualificacao->dt_incorporacao)->format('d/m/Y')."</div>";
                        }
    $dados_pdf .=      "<div class=''><strong >PROCEDÊNCIA: </strong>...</div>
                        <div class='col-md-6'><strong >DATA DE EXCLUSÃO: </strong>";
                        if (empty($fichaDisciplinar->qualificacao->dt_inatividade)) {
                            $dados_pdf .= "</div>";
                        } else {
                            $dados_pdf .= \Carbon\Carbon::parse($fichaDisciplinar->qualificacao->dt_inatividade)->format('d/m/Y')."</div>";
                        }

    $dados_pdf .=      "<div class='col-md-12 head'>DOCUMENTOS APRESENTADOS</div>
                        <div class='col-md-12'><strong >RG CIVIL N°: </strong>{$fichaDisciplinar->qualificacao->st_rgcivil}</div>
                        <div class='col-md-12'><strong >CPF N°: </strong>{$fichaDisciplinar->qualificacao->st_cpf}</div>
                        <div class='col-md-12'><strong >PIS/PASEP N°: </strong>{$fichaDisciplinar->qualificacao->st_pispasep}</div>
                               
                    </div>
                </div>";
    //Coluna 02 da primeira página
    $dados_pdf .=  
       "<div class='col-md-6-right'>
            <div class='col-md-4 borda'><strong >POST/GRAD: <br></br></strong>{$fichaDisciplinar->qualificacao->st_postograduacaosigla}</div>
            <div class='col-md-4 borda'><strong >NÚMERO DE PRAÇA: </strong>";
            if($fichaDisciplinar->qualificacao->ce_graduacao < 7){
                $dados_pdf .= $fichaDisciplinar->qualificacao->st_numpraca;
            } 
    $dados_pdf .= "</div>
            <div class='borda'><strong >COMPORTAMENTO ATUAL: </strong>{$fichaDisciplinar->qualificacao->st_comportamento} </div>
            <div class='col-md-6 borda'><strong >MATRÍCULA: </strong>{$fichaDisciplinar->qualificacao->st_matricula}</div>
            <div class='borda'><strong >RG PM N°: </strong>{$fichaDisciplinar->qualificacao->st_rgmilitar}</div>
            <div class='col-md-6 borda'><strong >TELEFONE: </strong>{$fichaDisciplinar->qualificacao->st_telefonecelular}</div>
            <div class='borda'><strong >EMAIL: </strong>{$fichaDisciplinar->qualificacao->st_email}</div>
            
            <table class='table borda'>
                <thead>
                    <tr>
                        <th class='col-md-3'>CURSOS</th>
                        <th class='col-md-3'>BOLETIM Nº</th>
                        <th class='col-md-3'>DATA</th>
                        <th>GRAU</th>
                    </tr>
                </thead>
                <tbody>
            ";

            if (isset($fichaDisciplinar->cursos) & count($fichaDisciplinar->cursos) > 0) {
                foreach ($fichaDisciplinar->cursos as $c) {
                    $dados_pdf .= "
                    <tr>
                        <td class='col-md-3'>{$c->st_curso}</td>
                        <td class='col-md-3'>{$c->st_boletim}</td>
                        <td class='col-md-3'>";
                        if (empty($c->dt_publicacao)) {
                            $dados_pdf .= "</td>";
                        } else {
                            $dados_pdf .= \Carbon\Carbon::parse($c->dt_publicacao)->format('d/m/Y')."</td>";
                        }
                        $dados_pdf .= "
                            <td>{$c->st_mediafinal}</td>
                    </tr>";
                }
            } else {
                $dados_pdf .= "
                <tr>
                    <td colspan='4'>Nenhum curso encontrado.</td>
                </tr> 
                ";
            }
    $dados_pdf .= "
        </tbody></table>

        <div class='col-md-12 borda'>
            <strong>ESPECIALIDADE:</strong> {$fichaDisciplinar->qualificacao->st_qpmp}
        </div>";
        if (!empty($imagem)) {
            $dados_pdf .= "
                <div class='imagem'>
                    <img id='img' class='img' src='data:image/png;data:image/jpeg;base64,{!! $imagem !!}'>
                </div>
            ";
        }

        $dados_pdf .= "
        <div class='col md-10'>
        <table class='table borda'>
            <thead>
                <tr>
                    <th class='col-md-3'>PROMOÇÕES</th>
                    <th class='col-md-2'>BOLETIM Nº</th>
                    <th class='col-md-2'>DATA</th>
                    <th class='col-md-2'>A CONTAR</th>
                </tr>
            </thead>
            <tbody>
    ";
    
    if (isset($fichaDisciplinar->promocoes) & count($fichaDisciplinar->promocoes) > 0) {
        foreach ($fichaDisciplinar->promocoes as $c) {
            $dados_pdf .= "
            <tr>
                <td class='col-md-3'>{$c->st_promocao}</td>
                <td class='col-md-2'>{$c->st_boletim}</td>
                <td class='col-md-2'>";
                if (empty($c->dt_boletim)) {
                    $dados_pdf .= "</td>";
                } else {
                    $dados_pdf .= \Carbon\Carbon::parse($c->dt_boletim)->format('d/m/Y')."</td>";
                }
                $dados_pdf .= "<td class='col-md-2'>";
                if (empty($c->dt_promocao)) {
                    $dados_pdf .= "</td>";
                } else {
                    $dados_pdf .= \Carbon\Carbon::parse($c->dt_promocao)->format('d/m/Y')."</td>";
                }
            $dados_pdf .= "
            <tr>";
        }
    } else {
        $dados_pdf .= "
        <tr>
            <td colspan='4'>Nenhuma promoção encontrada.</td>
        </tr> 
        ";
    }
    $dados_pdf .= "</tbody></table></div>";
   
    $dados_pdf .= "</div>
        <div class='col-md-12'>
            <div class='col-md-12 head'>HISTÓRICO DE PUNIÇÕES</div>
            <table class='table borda'>
                <thead>
                    <tr>
                        <th class='col-md-1'>BOLETIM Nº</th>
                        <th class='col-md-1'>DATA</th>
                        <th class='col-md-5'>DESCRIÇÃO</th>
                        <th class='col-md-2'>COMPORTAMENTO</th>
                        <th class='col-md-3-right'>OBSERVAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
    ";
   
    if (isset($fichaDisciplinar->punicoes) & count($fichaDisciplinar->punicoes) > 0) {
        foreach ($fichaDisciplinar->punicoes as $p) {
            if ($p->st_status == 'ANULADA') {
                //faça nada
            } else {
                $dados_pdf .= "
                <tr>
                    <td class='col-md-1'>{$p->st_boletim}</td>
                    <td class='col-md-1'>
                    ";

                    if (empty($p->dt_boletim)) {
                        $dados_pdf .= "</td>";
                    } else {
                        $dados_pdf .= \Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y')."</td>";
                    }

                    if (isset($p->st_campopersonalizado)) {
                        $observacao = strip_tags($p->st_campopersonalizado);
                    } else {
                        $observacao = strip_tags($p->st_materia);
                    }

                    if ($p->st_status == 'CANCELADA') {
                        $dados_pdf .= "<td> <div class='punicao-cancelada'>CANCELADACANCELADACANCELADACANCELADA</div></td>";
                    } else {
                        $dados_pdf .= "<td class='col-md-5' style='text-align: justify;'>&nbsp;&nbsp;&nbsp;&nbsp;{$observacao}</td>";
                    }

                    $dados_pdf .= "    
                        <td class='col-md-2'>{$p->st_comportamento}</td>
                        <td class='col-md-3-right' style='text-align: justify;'>&nbsp;&nbsp;&nbsp;&nbsp;
                    ";
                    if ($p->st_status != "ATIVA") {
                        $dados_pdf .= "Punição {$p->st_status}, no dia";
                        if (empty($p->dt_cancelamentoanulacao)) {
                            //faço nada
                        } else {
                            $dados_pdf .= \Carbon\Carbon::parse($p->dt_cancelamentoanulacao)->format('d/m/Y').", conforme {$p->st_boletimcancelamentoanulacao}, datado de ";
                        }
                        if (empty($p->dt_boletimcancelamentoanulacao)) {
                            //faço nada
                        } else {
                            $dados_pdf .= \Carbon\Carbon::parse($p->dt_boletimcancelamentoanulacao)->format('d/m/Y').".";
                        }
                    }
                    $dados_pdf .= " 
                        </td>
                </tr>";
            }
        }
    
    } else {
        $dados_pdf .= "
        <tr>
            <td colspan='5'>Nenhuma punição encontrada.</td>
        </tr>";
    }
    $dados_pdf.= "</tbody></table>

            <div class='col-md-12 head'>HISTÓRICO DE MEDALHAS</div>
            
            <table class='table borda'>
                <thead>
                    <tr>
                        <th class='col-md-3'>MEDALHA</th>
                        <th class='col-md-3'>TIPO</th>
                        <th class='col-md-3'>PUBLICAÇÃO</th>
                        <th class='col-md-3-right'>DATA DA PUBLICAÇÃO</th>
                    </tr>
                </thead>
                <tbody>";

    if (isset($fichaDisciplinar->medalhas) & count($fichaDisciplinar->medalhas) > 0) {
        foreach ($fichaDisciplinar->medalhas as $m) {
            $dados_pdf .= "
                <tr>
                    <td class='col-md-3'>{$m->st_nome}</td>
                    <td class='col-md-3'>{$m->st_tipo}</td>
                    <td class='col-md-3'>{$m->st_publicacao}</td>
                    <td class='col-md-3-right'>
                ";
                    if (empty($m->dt_publicacao)) {
                        //faça nada
                    } else {
                        $dados_pdf .= \Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y'); 
                    }
                    $dados_pdf .= "</td>
                </tr>";
        }
    } else {
        $dados_pdf .= "
        <tr>
            <td colspan='4'>Nenhuma medalha encontrada.</td>
        </tr>";
    }
    
    $dados_pdf .= "</tbody></table>

    <div class='col-md-12 head'>HISTÓRICO DE ELOGIOS</div>
            
    <table class='table borda'>
        <thead>
            <tr>
                <th class='col-md-2'>BOLETIM Nº</th>
                <th class='col-md-2'>DATA</th>
                <th class='col-md-8'>DESCRIÇÃO</th>
            </tr>
        </thead>
        <tbody>";

        if (isset($fichaDisciplinar->elogios) & count($fichaDisciplinar->elogios) > 0) {
            foreach ($fichaDisciplinar->elogios as $e) {
                $dados_pdf .= "
                    <tr>
                        <td class='col-md-2'>{$e->st_boletim}</td>
                        <td class='col-md-2'>";
                
                if (empty($e->dt_publicacao)) {
                    //faça nada
                } else {
                    $dados_pdf .= \Carbon\Carbon::parse($e->dt_publicacao)->format('d/m/Y');
                }

                if (isset($e->st_campopersonalizado)) {
                    $observacao = strip_tags($e->st_campopersonalizado);
                } else {
                    $observacao = strip_tags($e->st_materia);
                }

                $dados_pdf .= "
                        </td>
                        <td class='col-md-8' style='text-align: justify;'>&nbsp;&nbsp;&nbsp;&nbsp;{$observacao}</td>
                    </tr>
                ";
            }   
        } else {
            $dados_pdf .= "
                <tr>
                    <td colspan='3'>Nenhum elogio encontrado.</td>
                </tr>";
        }
    $dados_pdf .= "</tbody></table>

    <div class='col-md-12 head'>HISTÓRICO DE COMPORTAMENTOS</div>
            
    <table class='table borda'>
        <thead>
            <tr>
                <th class='col-md-2'>COMPORTAMENTO</th>
                <th class='col-md-1'>DATA</th>
                <th class='col-md-2'>BOLETIM Nº</th>
                <th class='col-md-3'>MOTIVO</th>
                <th class='col-md-4'>OBSERVAÇÃO</th>
            </tr>
        </thead>
        <tbody>";

        if (isset($fichaDisciplinar->comportamentos) & count($fichaDisciplinar->comportamentos) > 0) {
            foreach ($fichaDisciplinar->comportamentos as $c) {
                $dados_pdf .= "
                    <tr>
                        <td class='col-md-2'>{$c->st_comportamento}</td>
                        <td class='col-md-1'>";
                
                            if (empty($c->dt_boletim)) {
                                //faça nada
                            } else {
                                $dados_pdf .= \Carbon\Carbon::parse($c->dt_boletim)->format('d/m/Y');
                            }

                $dados_pdf .= "
                        </td>
                        <td class='col-md-2'>{$c->st_boletim}</td>
                        <td class='col-md-3'>&nbsp;&nbsp;&nbsp;&nbsp;{$c->st_motivo}</td>
                        <td class='col-md-4' style='text-align: justify;'>&nbsp;&nbsp;&nbsp;&nbsp;{$c->st_obs}</td>
                    </tr>
                ";
            }   
        } else {
            $dados_pdf .= "
                <tr>
                    <td colspan='5'>Nenhum comportamento encontrado.</td>
                </tr>";
        }
        
    $dados_pdf .= "</tbody></table>
        </div>";
    
    $dados_pdf .= "
       
                            
        </div>                    
        </div>";                    


    $footer = "
        <div>Ficha Disciplinar / DP / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " em " . date('d/m/Y - H:m:s');
    // $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output("Ficha Disciplinar - " . auth()->user()->matricula, \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 