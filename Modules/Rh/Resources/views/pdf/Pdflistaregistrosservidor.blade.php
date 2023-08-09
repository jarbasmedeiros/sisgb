@section('title', 'Férias')

<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=utf-8">
    </head>
    <body>
        <?php
            $contador = 0;
            $id_crs = null;
            $caderneta =NULL;
            $id_crs = 1;

            error_reporting(0);                 // Tira mensagem de erro no chrome
            ini_set('display_errors', 0);       // Tira mensagem de erro no chrome
            define('MPDF_PATH', 'class/mpdf/');
            include('mpdf/mpdf.php');
            $mpdf = new mPDF();
            $mpdf->SetTitle('Lista de CR');
            $css = "";
            $css = file_get_contents('assets/css/pdf.css');
            $mpdf->WriteHTML($css, 1);
               
            if(isset($registros)){ 
                $nomesdositens = $registros[0]->registros;
            }
            $dados_pdf = "";
            $dados_pdf .= "<table class='table table-responsive'>
                <thead>";
                    if(isset($registros)){
                        $dados_pdf .= "<tr>";
                        $dados_pdf .= "<th colspan=" . count($nomesdositens) . ">Lista de " . $registros[0]->st_tiporegistro . " - " . $servidor->st_nome . "</th>";
                        $dados_pdf .= "</tr>";
                    }
                    $dados_pdf .= "<tr>";
                        if(isset($registros)){
                            foreach($nomesdositens as $item){
                                if($item->st_nomedoitem != "Altera Status?"){
                                    $dados_pdf .= "<th>" . $item->st_nomedoitem . "</th>";
                                }
                            }
                        }
                    $dados_pdf .= "</tr>
                </thead>
                <tbody>";
                    if(isset($registros)){
                        foreach($registros as $r){
                            $dados_pdf .= "<tr>";
                                $caderneta = $r->registros;
                                $id_crs = $r->id;
                                foreach($caderneta as $valor){
                                    if($valor->tipoitem == 'Data'){
                                        $dados_pdf .= "<th>";
                                        if($valor->st_valor != "NULL"){
                                            $dados_pdf .= \Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y');
                                        }
                                        $dados_pdf .= "</th>";
                                    } elseif($valor->tipoitem == "Texto longo"){
                                        $dados_pdf .= "<th>" . $valor->st_valor . "</th>";
                                    } else{
                                        if($valor->st_nomedoitem != "Altera Status?"){
                                            if($valor->st_nomedoitem != "Setor"){
                                                $dados_pdf .= "<th>" . $valor->st_valor . "</th>";
                                            }else{
                                                $dados_pdf .= "<th>" . $listSetor->find($valor->st_valor)->st_sigla . "</th>";
                                            }
                                        }
                                    }
                                }
                            $dados_pdf .= "</tr>";
                        }
                    }
                $dados_pdf .= "</tbody>
            </table>";
            $mpdf->WriteHTML($dados_pdf, 2);
            ob_clean();      // Tira mensagem de erro no chrome
            $mpdf->Output();
            exit();
        ?>
    </body>

</html>