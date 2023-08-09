<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }};">


</head>
<body class="marginAll">
<?php
    function numberToRoman($num){    
        // Be sure to convert the given parameter into an integer
        $n = intval($num);
        
        $result = ''; 
        // Declare a lookup array that we will use to traverse the number: 
        $lookup = array(
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ); 
        
        foreach ($lookup as $roman => $value){
            // Look for number of matches
            $matches = intval($n / $value); 
            
            // Concatenate characters
            $result .= str_repeat($roman, $matches); 
            
            // Substract that from the number 
            $n = $n % $value; 
            
            
        } 
        
        return $result; 
    }
    
    function desenharNotasDeUmaParte($parte,$numParte){
        $topicoAtual = '';
        global $contadorTopicos ;
        if(empty($contadorTopicos)){
            $contadorTopicos =1;
        }   
        $tituloParte = array(
            1=>'(Serviços Diários)',
            2=>'(Ensino e Instrução)',
            3=>'(Assuntos Gerais e Administrativos)',
            4=>'(Justiça e Disciplina)');

        $txtNotas = '<div class="parte" style="font-family: "Times New Roman", Times, serif;">
            <div class="centralizado tituloParte">'.$numParte.'ªPARTE</div>
            <div class="centralizado">'.$tituloParte[$numParte].'</div>';

        if(count($parte) > 0){
            foreach($parte as $nota){
            //  dd($nota->st_topico);
                if($topicoAtual != $nota->st_topico){
                    $txtNotas = $txtNotas.'<br/><div class="assunto_nota" style="font-weight:bold;"><div class="row"><div class="col" style="width: 30px; float: left; display: inline-block;"><div class="col" style="width: 12px; float: left; display: inline-block; letter-spacing: -1px;">'.numberToRoman($contadorTopicos).'</div><div class="col" style="width: 20px; float: left; display: inline-block; text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-</div></div><div class="col" style="float: left; display: inline-block;">&nbsp;&nbsp;&nbsp;<span style="text-decoration: underline;">'.$nota->st_topico.'</span></div></div></div>';
                        
                    $topicoAtual = $nota->st_topico;
                    $contadorTopicos++;
                    
                }
                $txtNotas = $txtNotas.'<div class="notaCompleta" style="font-size: 11pt">'.$nota->st_notacompleta.'</div>';
                
                $txtNotas = $txtNotas.'<br/>';
            }
            //$contadorTopicos++;
        }else{                    
            $txtNotas = $txtNotas.'<div class="titulo_parte" style="text-align:center;">Sem Alteração</div><br/>';
        }
        $txtNotas = $txtNotas.'</div>';
        
        return $txtNotas;
    }

    ini_set("pcre.backtrack_limit", "5000000");//aumenta o limite de caracteres na string
    ob_clean();//limpa o buffer de saída

    $parteCapa = '<div class="capa">
    <br/>
        <div class="cabecalho">'
            .$capa->st_cabecalho
        .'</div><br/>
        <div class="centralizado" >
            <img src="data:image/jpg/jpeg/png;base64,'.$img.'" alt="Brasão PMRN" height="327" width="290" style="margin: 0px 0px 0px 0px;">
        </div><br/>
        <div class="centralizado">'
            . strtoupper($boletim->st_nome)        
        .'</div><br/>
        <div class="centralizado">'
            . $capa->st_cidade.'/RN, '.$boletim->dt_porExtenso.'</div><br/>
        <div class="centralizado">('.$boletim->dt_diaDaSemana.')</div><br/>
        <div class="line-heigt-10">'
            .$capa->st_funcoes
        .'</div></div>';
        
        $pageno = '{PAGENO}';
        
        $paginacao = str_pad('{PAGENO}' , 3 , '0' , STR_PAD_LEFT);
        if($paginacao < 10){
            $paginacao = '00'.$paginacao;
        }elseif($paginacao>=10 && $paginacao<100){
            $paginacao = '0'.$paginacao;
        }
        //dd($paginacao);
        $header = '
        <htmlpageheader name="myHeader1">
            <div style="position: absolute; top: 120px; width: 72%;" width="100%">
                <div style="display: inline; width: 100%; text-align: center;">'.$boletim->st_siglaCabecalho.', de '.$boletim->dt_porExtenso.'</div>
                <div class="paginacao" style="display: inline; width: 2%; text-align: right;">'.$pageno.'</div>
            </div>
        </htmlpageheader>
        <htmlpageheader name="myHeader2">
            <table width="100%">
                <tr>
                </tr>
            </table>
        </htmlpageheader>';

    $txtAberturaBg = '<div style="text-align:center;"><strong>Para conhecimento e devida execução, torno público o seguinte:</strong></div><br/>';
    $assinaturaBoletim = '<div style="text-align:center;">Assinado eletronicamente por <br/>'.$boletim->st_responsavelassinatura.', '.$boletim->st_postograduacaoassinante.'<br/>'.$boletim->st_funcaoassinante.'</div>';
    
    $contador = 1;
    $contadorTopicos =1;

    //início do pdf
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetWatermarkText($marcadagua,0.2);
    $mpdf->showWatermarkText  = true;
    
    //funções que reduzem o tempo de processamento do pdf
    $mpdf->useSubstitutions=false; 
    $mpdf->simpleTables = true;
    
    $css = file_get_contents('assets/css/pdf_boletim.css');
    $mpdf->WriteHTML($css, 1); 
    
    $mpdf->setTitle( $boletim->st_siglaCabecalho.'/'.$boletim->nu_ano);
    //$mpdf->setAuthor('SisGp_PM_RN');
    $mpdf->WriteHTML($header);
    $mpdf->WriteHTML($parteCapa);
    //$mpdf->AddPage();

    //$mpdf->AddPage('', '', 1, '', 'on');
    //$mpdf->WriteHTML($txtDaPaginacao);
    $mpdf->WriteHTML($txtAberturaBg);   

    $mpdf->WriteHTML(desenharNotasDeUmaParte($notas->parte1,1));
    $mpdf->WriteHTML(desenharNotasDeUmaParte($notas->parte2,2));
    $mpdf->WriteHTML(desenharNotasDeUmaParte($notas->parte3,3));
    $mpdf->WriteHTML(desenharNotasDeUmaParte($notas->parte4,4)); 
    if($boletim->st_status != 'ABERTO' && $boletim->st_status != 'FINALIZADO'){
        $mpdf->WriteHTML($assinaturaBoletim);  
    }

    ob_end_clean();//limpa o buffer
    $mpdf->Output($boletim->st_siglaCabecalho.'/'.$boletim->nu_ano.'.pdf',\Mpdf\Output\Destination::INLINE);
    //$mpdf->Output();
    exit();

//   dd($boletim);  
/* $txtNotas = desenharNotasDeUmaParte($notas->parte1,1);
$txtNotas = $txtNotas. desenharNotasDeUmaParte($notas->parte2,2);
$txtNotas = $txtNotas. desenharNotasDeUmaParte($notas->parte3,3);
$txtNotas = $txtNotas. desenharNotasDeUmaParte($notas->parte4,4);   */

/* $pagina =  '<div class="border">';
$pagina = $pagina.$cabecalho;
$pagina = $pagina.$corpoDoPdf;
$pagina= $pagina.$txtNotas;
$pagina = $pagina.'<div>';
$footer = "Dig:      Pag. {PAGENO} de {nb}"; */


//$mpdf->WriteHTML('');
/* $mpdf->line(10,10,200,10,array(0,0,0),1); // linha de cima
$mpdf->line(10,10,10,290,array(0,0,0),1); // linha da esquerda
$mpdf->line(200,10,200,290,array(0,0,0),1); // linha da direita
$mpdf->line(10,290,200,290,array(0,0,0),1); // linha de baixo  */

//$txtNotas = $txtNotas. '<div>';

//$mpdf->WriteHTML($primeiraPagina);

//$mpdf->AddPage(); 
/* $paginas = '<div class="segundapagina">';
$paginas = $paginas.$corpoDoPdf;
$paginas = $paginas.$txtNotas;
 */ 

//$mpdf->WriteHTML('');


 //$mpdf->WriteHTML($corpoDoPdf);
//$mpdf->SetHeader($footer);
//$mpdf->SetHTMLHeader($footer); 
//$mpdf->SetFooter($footer);
//$paginas = $paginas. '</div';

//$mpdf->WriteHTML($paginas);

//$mpdf->SetHeader($footer );


//$mpdf->SetDefaultBodyCSS('border-color','2px solid red');
 // $mpdf->Output('teste.html', \Mpdf\Output\Destination::STRING_RETURN);
 // $mpdf->Output();

?>
</body>
</html>



<!--
//$mpdf->WriteHTML($txtNotas);
//$mpdf->WriteHTML($pagina);
//$mpdf->SetFooter($footer);
//$mpdf->Rect(20, 15, 180, 280, 'D'); //For A4
//adiciona uma página

//$mpdf->WriteHTML($dadospdf, 2);
/* $mpdf->page_script('
if ($PAGE_NUM > 1) {
    $font = null;
    $current_page = $PAGE_NUM-1;
    $total_pages = $PAGE_COUNT-1;
    $pdf->text(225, 75, "{$boletim->st_siglaCabecalho . ", de " .  $boletim->dt_porExtenso}}", $font, 10, array(0,0,0));
    $pdf->text($pdf->get_width() - 85, 75, "$current_page de $total_pages", $font, 10, array(0,0,0));
}
$pdf->line(72,790,540,790,array(0,0,0),1); // linha de baixo
$pdf->line(72,790,72,70,array(0,0,0),1); // linha da esquerda
$pdf->line(72,70,540,70,array(0,0,0),1); // linha de cima
$pdf->line(540,70,540,790,array(0,0,0),1); // linha da direita
'); -->
 
