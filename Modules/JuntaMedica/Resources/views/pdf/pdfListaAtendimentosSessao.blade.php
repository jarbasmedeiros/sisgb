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
    $css = file_get_contents('assets/css/sessaoJPMS.css');
    $mpdf->WriteHTML($css, 1);
    setlocale(LC_TIME, 'portuguese'); //Converte a data para o padrão BR
    date_default_timezone_set('America/Sao_Paulo'); //define o local da data
    
    $header = "";
    $dados_pdf = "";
    $dados_pdf .= "
                    <div class='cab-corpo-jpms'>
                        RIO GRANDE DO NORTE<br/>
                        SECRETARIA DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL<br/>
                        POLÍCIA MILITAR<br/>
                        DIRETORIA DE SAÚDE<br/>
                        <span style='font-weight:bold; text-decoration: underline;'>
                        JUNTA POLICIAL MILITAR DE SAÚDE</span><br/><br/>
                        ATA DE INSPEÇÃO DE SAÚDE<br/><br/>
                        <span style='font-weight:bold;'> 
                            SESSÃO ".$sessao->nu_sequencial."/".$sessao->nu_ano."
                        </span> de ".strftime('%d de %B de %Y', strtotime(($sessao->dt_sessao)))."<br/><br/>
                    </div>
                    <div class='cab-descricao'>
                        A junta de Saúde da Polícia Militar, reunida na sala das Sessões, inspecionou os 
                        <span style='font-weight:bold;'>Policiais Militares</span> abaixo declarados
                         que lhe foram devidamente apresentados e sobre o seu estado de saúde proferiu o seguinte:
                    </div>
                    
                    
                ";

    
    $dados_pdf .= "<table class='table-jpms'>";
        $dados_pdf .= "<tr class='table-title'>
            <th colspan='3'>Nome</th>
            <th colspan='1'>Posto/Grad</th>
            <th colspan='1'>Matrícula</th>
            <th colspan='1'>Unidade</th>
            <th colspan='1'>CID</th>
            <th colspan='1'>Parecer</th>
            <th colspan='1'>Restrição</th>
            <th colspan='1'>Causa/Efeito</th>
            <th colspan='1'>OBS</th>
        </tr>";     
    
        if(isset($sessao->atendimentosMedicos) && count($sessao->atendimentosMedicos) > 0){
            foreach($sessao->atendimentosMedicos as $a){
                    $restricoes = ""; 
            $dados_pdf .= "<tr>
                <td colspan='3'>".$a->st_nome."</td>
                <td colspan='1'>".$a->st_postograduacao." ".$a->st_orgao."</td>
                <td colspan='1'>".$a->st_matricula."</td>
                <td colspan='1'>".$a->st_unidade."</td>
                <td colspan='1'>".$a->st_cid."</td>
                <td colspan='1'>".$a->st_parecer."</td>";
                foreach($a->restricoes as $r){ 
                    if(end($a->restricoes) == $r){
                        $restricoes .= $r->st_restricao . "."; 
                    }else{
                        $restricoes .= $r->st_restricao . ", "; 
                    }
                }                                       
                if(strlen($restricoes) > 0){
                    $dados_pdf .= "<td colspan='1'>".$restricoes."</td>";
                }else{
                    $dados_pdf .= "<td colspan='1'>Sem restrição.</td>";
                }
                $dados_pdf .= "<td colspan='1'>".$a->st_causaefeito."</td>
                <td colspan='1'>".$a->st_obs."</td>
            </tr>";
            }
        }
    $dados_pdf .= "</table>";
    $dados_pdf .= "
        <div class='cab-corpo-jpms'> Assinado Eletronicamente por:</div></br></br></br>";
        if (isset($assinaturasSessao) && count($assinaturasSessao) > 0) {
            foreach ($assinaturasSessao as $a) {
                $dados_pdf .= "<div class='assinatura-nome'> ".$a->st_nomeassinante." - ".$a->st_postograd."</div></br>";
                $dados_pdf .= "<div class='assinatura-funcao'> ".$a->st_funcao."</div></br>";
                $dados_pdf .= "<div class='cab-corpo-jpms'> "."Assinado em ".strftime('%d de %B de %Y', strtotime(($a->dt_assinatura)))."</div></br>";
            }
            
        }
        
        
    


/* </tbody>
</table>
<table class="table-sm table-bordered" style="width: max-content;">
<thead>
    <tr class="bg-primary">
        <th colspan="12">Assinaturas da Sessão {{$sessao->nu_sequencial}}/{{$sessao->nu_ano}} de {{strftime('%d de %B de %Y', strtotime(($sessao->dt_sessao)))}}</th>                            
    </tr>
    <tr class="header-color">
        <th colspan="1">Ordem</th>
        <th colspan="5">Nome</th>
        <th colspan="4">Posto/Grad</th>
        <th colspan="2">Função</th>
    </tr>
</thead>
<tbody>
    @if(isset($assinaturasSessao) && count($assinaturasSessao) > 0)
        @php $contador = 0 @endphp
        @forelse($assinaturasSessao as $a)
        @php $contador++ @endphp
        <tr>
            <td colspan="1">{{$contador}}</td>
            <td colspan="5">{{$a->st_nomeassinante}}</td>
            <td colspan="4">{{$a->st_postograd}}</td>
            <td colspan="2">{{$a->st_funcao}}</td>                                        
        </tr>
        @empty
        <tr>
            <td colspan="12">Ata não assinada.</td>
        </tr>
        @endforelse
    @endif
</tbody> */
    

    $dados_pdf .= "</table>";
    $footer = "
        <div>Junta Policial Militar de Saúde em Natal, SESSÃO ".$sessao->nu_sequencial."/".$sessao->nu_ano." / SISGP. Pag. {PAGENO} / {nb}</div></br></br>";
    $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
    // $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output("Sessão ".$sessao->nu_sequencial."_".$sessao->nu_ano." JPMS.pdf", \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 