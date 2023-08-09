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
    $css = file_get_contents('assets/css/dal/pdf_lista_quantitativo_fardamentos.css');
    $mpdf->WriteHTML($css, 1);
    setlocale(LC_TIME, 'portuguese'); //Converte a data para o padrão BR
    date_default_timezone_set('America/Sao_Paulo'); //define o local da data
    
    $header = ""; 
    $dados_pdf = "";
    $dados_pdf .= "
                <div class='brasao-rn'>
                    <img class='img-responsive' src=" . URL::asset('/imgs/Brasao_RN.png') . " width='60' height='60' alt='logo'/>
                </div>
                <div class='cab-corpo'>
                    RIO GRANDE DO NORTE<br/>
                    SECRETARIA DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL<br/>
                    POLÍCIA MILITAR<br/>
                    DIRETORIA DE APOIO LOGÍSTICO<br/>
                </div>
                <div class='brasao-pm'>
                    <img class='img-responsive' src=" . URL::asset('/imgs/brasao_pmrn.png') . " width='60' height='60' alt='logo'/>
                </div>
                <div class='titulo mb-10'>
                    Quantitativo de Fardamentos - ".$unidadeConsultada."
                </div>
                
                <div class='row'>";
                   if(isset($quantitativoFardamentos)){
    $dados_pdf .= "      <div class='left ml-15'>
                            <table class='table '>
                                <thead>
                                    <tr>
                                        <th colspan='2' class='table-title'> Coberturas </th>
                                    </tr>
                                    <tr>
                                        <th class=''>Tamanho</th>
                                        <th class=''>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        if (isset($quantitativoFardamentos->cobertura) & count($quantitativoFardamentos->cobertura) > 0) {
                            foreach($quantitativoFardamentos->cobertura as $c){
                                $dados_pdf .= "<tr>";
                                    $dados_pdf .= "<td>".$c->st_cobertura."</td>";
                                    $dados_pdf .= "<td>".$c->qtd_cobertura."</td>
                                              </tr>";                                                 
                            }
                        } else {
                            $dados_pdf .="  <tr>
                                                <td>Nenhum cadastro de quantidade de cobertura encontrado.</td>
                                            </tr>";
                        }
                   }
        $dados_pdf .="
                                </tbody>
                            </table>
                        </div>";
                        
                
    $dados_pdf .= "      <div class='left'>
                            <table class='table '>
                                <thead>
                                    <tr class=' '>
                                        <th colspan='2' class='table-title'> Gandolas e Canículas </th>
                                    </tr>
                                    <tr>
                                        <th class=''>Tamanho</th>
                                        <th class=''>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        if (isset($quantitativoFardamentos->gandolacanicola) & count($quantitativoFardamentos->gandolacanicola) > 0) {
                            foreach($quantitativoFardamentos->gandolacanicola as $c){
                                $dados_pdf .= "<tr>";
                                    $dados_pdf .= "<td>".$c->st_gandolacanicola."</td>";
                                    $dados_pdf .= "<td>".$c->qtd_gandolacanicola."</td>
                                              </tr>";                                                 
                            }
                        } else {
                            $dados_pdf .="  <tr>
                                                <td>Nenhum cadastro de quantidade de cobertura encontrado.</td>
                                            </tr>";
                        }
                   
        $dados_pdf .="
                                </tbody>
                            </table>
                        </div>";
                        
                
    $dados_pdf .= "      <div class='left'>
                            <table class='table '>
                                <thead>
                                    <tr class=' '>
                                        <th colspan='2' class='table-title'> Camisas Internas </th>
                                    </tr>
                                    <tr>
                                        <th class=''>Tamanho</th>
                                        <th class=''>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        if (isset($quantitativoFardamentos->camisainterna) & count($quantitativoFardamentos->camisainterna) > 0) {
                            foreach($quantitativoFardamentos->camisainterna as $c){
                                $dados_pdf .= "<tr>";
                                    $dados_pdf .= "<td>".$c->st_camisainterna."</td>";
                                    $dados_pdf .= "<td>".$c->qtd_camisainterna."</td>
                                              </tr>";                                                 
                            }
                        } else {
                            $dados_pdf .="  <tr>
                                                <td>Nenhum cadastro de quantidade de cobertura encontrado.</td>
                                            </tr>";
                        }
                   
        $dados_pdf .="
                                </tbody>
                            </table>
                        </div>";
                        
                
    $dados_pdf .= "      <div class='left'>
                            <table class='table '>
                                <thead>
                                    <tr class=' '>
                                        <th colspan='2' class='table-title'> Calças e Saias </th>
                                    </tr>
                                    <tr>
                                        <th class=''>Tamanho</th>
                                        <th class=''>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        if (isset($quantitativoFardamentos->calcasaia) & count($quantitativoFardamentos->calcasaia) > 0) {
                            foreach($quantitativoFardamentos->calcasaia as $c){
                                $dados_pdf .= "<tr>";
                                    $dados_pdf .= "<td>".$c->st_calcasaia."</td>";
                                    $dados_pdf .= "<td>".$c->qtd_calcasaia."</td>
                                              </tr>";                                                 
                            }
                        } else {
                            $dados_pdf .="  <tr>
                                                <td>Nenhum cadastro de quantidade de cobertura encontrado.</td>
                                            </tr>";
                        }
                   
        $dados_pdf .="
                                </tbody>
                            </table>
                        </div>";
                        
                
    $dados_pdf .= "      <div class='left'>
                            <table class='table '>
                                <thead>
                                    <tr class=' '>
                                        <th colspan='2' class='table-title'> Coturnos e Sapatos </th>
                                    </tr>
                                    <tr>
                                        <th class=''>Tamanho</th>
                                        <th class=''>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        if (isset($quantitativoFardamentos->coturnosapato) & count($quantitativoFardamentos->coturnosapato) > 0) {
                            foreach($quantitativoFardamentos->coturnosapato as $c){
                                $dados_pdf .= "<tr>";
                                    $dados_pdf .= "<td>".$c->st_coturnosapato."</td>";
                                    $dados_pdf .= "<td>".$c->qtd_coturnosapato."</td>
                                              </tr>";                                                 
                            }
                        } else {
                            $dados_pdf .="  <tr>
                                                <td>Nenhum cadastro de quantidade de cobertura encontrado.</td>
                                            </tr>";
                        }
                   
        $dados_pdf .="
                                </tbody>
                            </table>
                        </div>";
                        
                
    $dados_pdf .= "      <div class='left'>
                            <table class='table '>
                                <thead>
                                    <tr class=' '>
                                        <th colspan='2' class='table-title' > Cintos </th>
                                    </tr>
                                    <tr>
                                        <th class=''>Tamanho</th>
                                        <th class=''>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        if (isset($quantitativoFardamentos->cinto) & count($quantitativoFardamentos->cinto) > 0) {
                            foreach($quantitativoFardamentos->cinto as $c){
                                $dados_pdf .= "<tr>";
                                    $dados_pdf .= "<td>".$c->st_cinto."</td>";
                                    $dados_pdf .= "<td>".$c->qtd_cinto."</td>
                                              </tr>";                                                 
                            }
                        } else {
                            $dados_pdf .="  <tr>
                                                <td>Nenhum cadastro de quantidade de cobertura encontrado.</td>
                                            </tr>";
                        }
                   
        $dados_pdf .="
                                </tbody>
                            </table>
                        </div>
                    </div>";
                        
                

    $footer = "
        <div>Diretoria de Apoio Logístico / SISGP. Pag. {PAGENO} / {nb}</div>";
    $footer .= "Impresso por " . Auth::user()->name . " em " . date('d/m/Y - H:m:s');
    // $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->WriteHTML($dados_pdf, 2);
    ob_clean();      // Tira mensagem de erro no chrome
    $mpdf->Output("Parecer Apto - JPMS", \Mpdf\Output\Destination::INLINE);
    exit();
    ?>

</body>

</html> 