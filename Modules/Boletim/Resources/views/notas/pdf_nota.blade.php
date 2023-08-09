<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }};">
</head>
<body>
<?php
    $txtNotas = '';
    if(isset($nota->st_assunto)){
        $txtNotas = $txtNotas.'<div><h4>'.$nota->st_assunto.'</h4></div>';
    }

    if(isset($nota->st_notacompleta) && ($nota->st_notacompleta != null)){
        $txtNotas = $txtNotas.'<div class="notaCompleta">'.$nota->st_notacompleta.'</div>';
        $txtNotas = $txtNotas.'<br/>';
    }else{
        $txtNotas = $txtNotas.'<div style="font-size: 11pt">';
        $txtNotas = $txtNotas.'<div style="font-size: 11pt">'.$nota->st_materia.'</div>';
        if(isset($nota->policiais) && count($nota->policiais) > 0){
            $txtNotas = $txtNotas.'<br/><b>POLICIAIS DA NOTA</b>';
            switch($nota->ce_tipo){
                case 17:
                    $txtNotas = $txtNotas.'<table class="tabela_pm" >
                        <thead class="cabecalho_tabela_pm">
                            <tr class="body_tabela_pm">
                                <th class="text-center">Ord.</th>
                                <th class="text-center">Post/Grad</th>
                                <th class="text-center">Matrícula</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Origem</th>
                                <th class="text-center">Destino</th>
                                <th class="text-center">A contar de</th>
                        </tr>
                    </thead>
                    <tbody class="body_tabela_pm">';
                    $conta = 0; 
                    foreach($policiaisDaNota as $policial){
                        $conta++; 
                        $txtNotas = $txtNotas.'<tr>
                            <td class="celula_tabela_pm">'.$conta.'</td>
                            <td class="celula_tabela_pm">'.$policial->st_postograduacaosigla.'</td>
                            <td class="celula_tabela_pm">'.$policial->st_matricula.'</td>
                            <td class="td-left">'.$policial->st_nome.'</td>
                            <td class="celula_tabela_pm">'.$policial->st_siglaopmorigem.'</td>
                            <td class="celula_tabela_pm">'.$policial->st_siglaopmdestino.'</td>
                            <td class="celula_tabela_pm">'.date('d/m/Y', strtotime($policial->dt_acontar)).'</td>
                        </tr>';
                    }
                    $txtNotas = $txtNotas.'</tbody></table>';
                    break;
                case 18:
                    $txtNotas = $txtNotas.'<table class="tabela_pm" >
                        <thead class="cabecalho_tabela_pm cor-do-fundo font-size-10">
                            <tr>
                                <th class="text-center">Ord.</th>
                                <th class="text-center">Post/Grad</th>
                                <th class="text-center">Matrícula</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">OPM Origem</th>
                                <th class="text-center">Função atual</th>
                                <th class="text-center">OPM Destino</th>
                                <th class="text-center">Nova função</th>
                                <th class="text-center">A contar de</th>
                            </tr>
                        </thead>
                        <tbody class="body_tabela_pm">';
                            $conta = 0; 
                            foreach($policiaisDaNota as $policial){
                                $conta++;
                                $txtNotas = $txtNotas.'<tr class="body_tabela_pm">
                                    <td class="celula_tabela_pm_ord">'.$conta.'</td>
                                    <td class="text-center">'.$policiais->st_postograduacaosigla.'</td>
                                    <td class="text-center">'.$policiais->st_matricula.'</td>
                                    <td class="td-left">'.$policiais->st_nome.'</td>
                                    <td class="text-center">'.$policiais->st_siglaopmorigem.'</td>
                                    <td class="text-center">'.$policiais->st_funcaoatual.'</td>
                                    <td class="text-center">'.$policiais->st_siglaopmdestino.'</td>
                                    <td class="text-center">'.$policiais->st_novafuncao.'</td>
                                    <td class="text-center">'.date('d/m/Y', strtotime($policiais->dt_acontar)).'</td>
                                </tr>';
                            }
                        $txtNotas = $txtNotas.'</tbody></table>';
                    break;
                //geralmente nota do tipo 2, mas caso seja uma exceção esse será o código de exibição
                default:
                    $txtNotas = $txtNotas.'<table class="tabela_pm">
                        <thead class="cabecalho_tabela_pm">
                            <tr class="body_tabela_pm">
                                <th class="celula_tabela_pm">Ord.</th>
                                <th class="celula_tabela_pm">Post/Grad</th>
                                <th class="celula_tabela_pm">Matrícula</th>
                                <th class="celula_tabela_pm">Nome</th>
                            </tr>
                        </thead>
                        <tbody class="body_tabela_pm">';
                        foreach($policiaisDaNota as $key => $policiais){
                            $ordem = $key+1;
                            $txtNotas = $txtNotas.'<tr class="body_tabela_pm">
                                <td class="celula_tabela_pm">'.$ordem.'</td>
                                <td class="celula_tabela_pm">'.$policiais->st_postograduacaosigla.'</td>
                                <td class="celula_tabela_pm">'.$policiais->st_matricula.'</td>
                                <td class="td_left">'.$policiais->st_nome.'</td>
                            </tr>';
                        }
                        $txtNotas = $txtNotas.'</tbody></table>';
            }         
        }
        $txtNotas = $txtNotas.'</div><br/>';
    }

   
   
    $css = file_get_contents('assets/css/pdf_nota.css');


    ini_set("pcre.backtrack_limit", "5000000");
    ob_clean();
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->useSubstitutions=false; 
    $mpdf->simpleTables = true;
    $mpdf->WriteHTML($css, 1);
    $footer =  'Pag. {PAGENO} de {nb}'; 
    if($nota->st_status != "PUBLICADA"){
        $marcadagua = "Rascunho por: " .Auth::user()->st_cpf;
    }else{
        //Verica se tem um objeto boletim vinculado a nota
        if(isset($nota->st_boletim->st_tipo)){
            //verifica se o tipo de boletim é aditamento
            if($nota->st_boletim->ce_tipo == 7){
                $footer =  '<div style="display: inline; width: 100%; text-align: left;"> Publicado no  '.$nota->st_boletim->st_sigla.' ao '.$nota->st_boletim->pai->st_sigla.'-'.$nota->st_boletim->pai->nu_sequencial.'/'.$nota->st_boletim->pai->nu_ano.' / SISGP</div>           Pag. {PAGENO} de {nb}'; 
            }else{

                 $footer =  '<div style="display: inline; width: 100%; text-align: left;"> Publicado no  '.$nota->st_boletim->st_sigla.' '.$nota->st_boletim->nu_sequencial.'/'.$nota->st_boletim->nu_ano.' / SISGP</div>           Pag. {PAGENO} de {nb}'; 
            }
        }
        $marcadagua = "";
    }

    $mpdf->SetWatermarkText($marcadagua,0.2);
    $mpdf->showWatermarkText  = true;

    $contador = 1;
    $contadorTopicos = 1;
    
    $mpdf->setTitle('Nota_'.$nota->id);  

    $mpdf->WriteHTML($txtNotas); 
    $mpdf->SetFooter($footer);

    ob_end_clean();
    $mpdf->Output('Nota_'.$nota->id.'.pdf',\Mpdf\Output\Destination::INLINE);
    exit();
?>
</body>
</html>