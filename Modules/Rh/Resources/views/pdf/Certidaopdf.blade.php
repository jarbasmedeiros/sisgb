<html lang="pt-BR">

<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title>erer</title>
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
$mpdf->SetTitle("Certidão Nada Consta");//titulo da pagina
$css = file_get_contents('assets/css/rh/djd/certidao_Nada_Consta_Pdf.css');

//insere a marca d'agua no PDF com o cpf do usuário logado
$rascunho = 'Rascunho'; 
if($certidao->ce_assinaturachefia == null){
    $mpdf->SetWatermarkText($rascunho, 0.1);
    $mpdf->showWatermarkText = true;
}else{$mpdf->SetWatermarkText(auth()->user()->matricula, 0.1);
$mpdf->showWatermarkText = true;
}       
$mpdf->WriteHTML($css, 1);

$responde = 0;
$header = "";
$dados_pdf = "";
setlocale(LC_TIME, 'portuguese'); //Converte a data para o padrão BR
date_default_timezone_set('America/Sao_Paulo'); //define o local da data
strftime('%d de %B de %Y', strtotime($certidao->dt_emissao));
$emissao = strftime('%d de %B de %Y', strtotime($certidao->dt_emissao)); //recebe a data de hoje


$conteudo_pdf ="";
$dados_pdf .= "
            <div class=' col-md-12'>
            <div class='mt-20'>
                <div class='brasao'>
                    <img class='img-responsive' src=" . URL::asset('/imgs/Brasao_RN.png') . " width='60' height='60' alt='logo'/>
                </div>
                <div class='cab-corpo'>
                    Governo do Estado do Rio Grande do Norte<br/>
                    Secretaria da Segurança Pública e da Defesa Social<br/>
                    Polícia Militar<br/>
                    Diretoria de Justiça e Disciplina da PMRN<BR/>
                </div>
                <div class='brasao'>
                    <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                </div>
                <div class='titulocaderneta'>
                    CERTIDÃO NADA CONSTA 
                </div>
            ";
            $dados_pdf .= "
            <h4>CERTIDÃO Nº $certidao->st_sequencial/$certidao->st_ano/PM - DJD - CMD GERAL </h4>
            ";
        if(count($certidao->procedimentos) > 0) {  
            $dados_pdf .= "
            <div class='conteudo'>
                <p>
                    <b>Certifico</b> para fins de direito e a pedido por escrito  da parte interessada, que após pesquisa realizada no Banco de Dados desta Diretoria para elaboração da presente Certidão, verificou-se que <b>". $policial->st_nome .", </b><b>".$policial->st_postograduacaosigla ." matrícula nº ". $policial->st_matricula ."</b>, atualmente <b>responde</b> a procedimento(s) instaurado(s) no âmbito do Comando Geral da Corporação, conforme a tabela a seguir:
                </p>
            </div>
                ";
            $dados_pdf .= "<table class='table table-responsive'>
            <thead>
                <div >
                <tr class='tbl'>
                    <th>TIPO</th>
                    <th>PORTARIA</th>
                    <th>Nº SEI</th>
                    <th>UNIDADE</th>
                </tr>";
            foreach($certidao->procedimentos as $p){
               
                $dados_pdf .= "<tr class='tbl'><td>". $p->st_tipo ."</td><td>". $p->st_numprocedimento ."</td><td>".$p->st_numsei."</td><td>". $p->st_unidade ."</td></tr>";
               
            }
            $dados_pdf .= "  </div>
            </thead>
            </table>";
        }else{
            $dados_pdf .= "
            <div class='conteudo'>
                <p><b>Certifico</b> para fins de direito e a pedido por escrito da parte interessada, que após pesquisa realizadas no Banco de Dados desta Diretoria para elaboração da presente Certidão, verificou-se que  <b>". $policial->st_nome ."</b>, <b>".$policial->st_postograduacaosigla ." matrícula nº ". $policial->st_matricula ."</b>, atualmente <b>não responde</b> a procedimento(s) instaurado(s) no âmbito do Comando Geral da Corporação.</p>"; 
        }
        //$dados_pdf .= "<div class='conteudot1'><p>DEIXO DE INFORMAR se houve instauração no âmbito interno de outras OPM'S em virtude da Corporação não possuir um Banco de Dados integrado.</p> ";
        $dados_pdf .= "<div class='conteudot4'><p>Natal/RN, $emissao</p></div>";
        
        $dados_pdf .="
        <div class='auxiliar'><h6 >".$certidao->st_assinaturaauxiliar."</h6></div>"; 

        $dados_pdf .= "
        <div class='conteudot5'>
            
            <p>_______________________________________________________</p><h5>Assinatura do Auxiliar</h5>
        </div>";
       if($certidao->ce_assinaturachefia != null){
        $dados_pdf .="
        <div class='chefia'><h6 >".$certidao->st_assinaturachefia."</h6></div>"; 

       } 
       $dados_pdf .= "
        <div class='conteudot5'>
            <p>_______________________________________________________ </p>
            <h5> Assinatura do  Chefe </h5>
        </div>";
        $dados_pdf .= "<div class='conteudot7'><h4><b>[ESTA CERTIDÃO TEM VALIDADE DE 30 (TRINTA) DIAS]</b></h4>
        </div>";
        $footer = "<div>Certidão Nada Consta / DJD / SISGP. Pag. {PAGENO} / {nb}</div>";
        $footer .= "Impresso por " . Auth::user()->name . " - " . date('d/m/Y - H:m:s');
        
        $mpdf->SetFooter($footer);
        $mpdf->WriteHTML($dados_pdf, 2);
        ob_clean();      // Tira mensagem de erro no chrome
        $mpdf->Output($policial->st_nome .' -  Certidao Nada Consta .pdf', \Mpdf\Output\Destination::INLINE);
        exit();
        ?>
    
    </body>
    
    </html>
</body>

</html> 