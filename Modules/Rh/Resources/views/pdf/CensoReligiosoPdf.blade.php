<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-type" content="text/html;charset=utf-8">
    <meta charset="utf-8">
    <link rel="icon" type="image/PNG" href="{{url('imgs/sesed.PNG')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{url('/imgs/logo2.png')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>{{$titulo or 'SESED'}}</title>

    <link rel='stylesheet' href="{{url('/assets/css/pdf.css')}}">
</head>


<body>
    <?php
    $contador = 0;
        error_reporting(0);                 // Tira mensagem de erro no chrome
        ini_set('display_errors', 0);       // Tira mensagem de erro no chrome
        define('MPDF_PATH', 'class/mpdf/');
        include('mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->SetTitle($nomeTabela);
        $css = "";
        $css = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($css, 1);
        
        $dados_pdf = "";
        $dados_pdf .= "<table class='table table-responsive' style='margin:auto;'>
            <thead>
            <tr>";
            if($tipo == 'categorias'){
                $dados_pdf .= "<th colspan='2'><h2 style='padding: 40px;'>  QUANTITATIVO DE POLICIAIS POR SEGMENTAÇÃO RELIGIOSA</h2>    </th>"; 
            }elseif($tipo == 'donominacoes'){
                $dados_pdf .= "<th colspan='2'><h2 style='padding: 40px;'>  QUANTITATIVO DE POLICIAIS POR DENOMINAÇÃO RELIGIOSA </h2>    </th>"; 
            }elseif($tipo == 'categoriadetalhada'){
                $dados_pdf .= "<th colspan='2'><h2 style='padding: 40px;'>  QUANTITATIVO DE POLICIAIS POR DENOMINAÇÃO RELIGIOSA DA SEGMENTAÇÃO RELIGIOSA (". strtoupper(strtr($denominacoesReligiosas->st_categoria->st_categoria, LATIN1_LC_CHARS, LATIN1_UC_CHARS)).")</h2>    </th>"; 
            }else{
                $dados_pdf .= "<th></th>"; 
            }
           
            $dados_pdf .= "</tr><tr>";
            if($tipo == 'categorias'){
                $dados_pdf .= "<th>SEGMENTAÇÃO RELIGIOSA</th>"; 
            }elseif($tipo == 'donominacoes'){
                $dados_pdf .= "<th>DENOMINAÇÃO RELIGIOSA</th>"; 
            }elseif($tipo == 'categoriadetalhada'){
                $dados_pdf .= "<th>SEGMENTAÇÃO RELIGIOSA</th>"; 
            }else{
                $dados_pdf .= "<th>QUANTITATIVO DE POLICIAIS QUE REALIZARAM O CENSO RELIGIOSO</th>"; 
            }
           
            $dados_pdf .= "<th>TOTAL DE POLICIAIS</th>
        </tr>
            </thead>
            <tbody>";
            if($tipo == 'donominacoes'){
                if(count($censoReligioso->totalDenomincoesReligiosas)>0){
                    foreach($censoReligioso->totalDenomincoesReligiosas as $d){
                        $dados_pdf .= "<tr>";
                            $dados_pdf .= "<td >" . $d->st_denominacaoreligiosa . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $d->total . "</td>";
                    
                        $dados_pdf .= "</tr>";
                           
                    }
                }else{
                        
                }

            }elseif($tipo == 'categorias'){
                if(count($censoReligioso->totalCategoriasReligiosas)>0){
                    foreach($censoReligioso->totalCategoriasReligiosas as $c){
                        $dados_pdf .= "<tr>";
                            $dados_pdf .= "<td >" . $c->st_categoria . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $c->total . "</td>";
                    
                        $dados_pdf .= "</tr>";
                           
                    }
                }else{
                        
                }

            }elseif($tipo == 'categoriadetalhada'){
                if(count($denominacoesReligiosas->totalDenomincoesReligiosas)>0){
                    foreach($denominacoesReligiosas->totalDenomincoesReligiosas as $d){
                        $dados_pdf .= "<tr>";
                            $dados_pdf .= "<td >" . $d->st_denominacaoreligiosa . "</td>";
                            $dados_pdf .= "<td style='text-align: center;'>" . $d->total . "</td>";
                    
                        $dados_pdf .= "</tr>";
                           
                    }
                }else{
                        
                }

            }
           
            $dados_pdf .= "</tbody>
        </table>";
      
    $footer .= "Informações emitidas em " . date('d/m/Y - H:m:s');
    // $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
        $mpdf->WriteHTML($dados_pdf, 2);
        ob_clean();      // Tira mensagem de erro no chrome
        $mpdf->Output();
        exit();
    ?>
</body>

</html> 