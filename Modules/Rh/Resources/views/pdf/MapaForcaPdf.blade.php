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
        $mpdf = new mPDF('utf-8','A4-L');
        $mpdf->SetTitle("Mapa Força".$dadosUsuario['st_descricao']);//titulo da pagina
        $css = "";
        $css = file_get_contents('assets/css/pdf.css');
        $mpdf->WriteHTML($css, 1);
        
        $dados_pdf = "";
        $dados_pdf .= "<table class='table table-responsive'>
            <thead>
                <tr>";
                    $dados_pdf .= "<td colspan='14' style='text-align: center;'><b>QUADRO ORGANIZACIONAL - MAPA FORÇA ( {$policial->st_unidade} )</b>"; //titulo da tabela
                    $dados_pdf .= "</td>
                <tr style='background-color: #d9def7; color: #000'>
                                            <td class='col-md-3' style='text-align: center;'><b>Posto/Grad</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Previsto</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Existente</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Claros</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Excedente</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>JPMS</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Licença Especial</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Férias</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>À dispocição</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Curso</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Força Nacional</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Outros Destinos</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Pronto c/ Restrição</b></td>
                                            <td class='col-md-3' style='text-align: center;'><b>Pronto Emprego</b></td>
                                        </tr>
            </thead>
            <tbody>";
                if(isset($vagas)){
                    foreach ($vagas as $v){
                        $t_nu_previsto += $v->nu_previsto;
                        $t_nu_existente += $v->nu_existente;
                        $t_nu_claros += $v->nu_claros;
                        $t_nu_excedente += $v->nu_excedente;
                        $t_nu_jpms += $v->nu_jpms;
                        $t_nu_licencaespecial += $v->nu_licencaespecial;
                        $t_nu_ferias += $v->nu_ferias;
                        $t_nu_adisposicao += $v->nu_adisposicao;
                        $t_nu_emcurso += $v->nu_emcurso;
                        $t_nu_naforca += $v->nu_naforca;
                        $t_nu_outros += $v->nu_outros;
                        $t_nu_aptocomrestricao += $v->nu_aptocomrestricao;
                        $t_nu_pronto += $v->nu_pronto;

                        $dados_pdf .= "<tr>
                            <td style='text-align: center'>$v->st_postograduacao</td>
                            <td style='text-align: center'>$v->nu_previsto</td>
                            <td style='text-align: center'>$v->nu_existente</td>
                            <td style='text-align: center'>$v->nu_claros</td>
                            <td style='text-align: center'>$v->nu_excedente</td>
                            <td style='text-align: center'>$v->nu_jpms</td>
                            <td style='text-align: center'>$v->nu_licencaespecial</td>
                            <td style='text-align: center'>$v->nu_ferias</td>
                            <td style='text-align: center'>$v->nu_adisposicao</td>
                            <td style='text-align: center'>$v->nu_emcurso</td>
                            <td style='text-align: center'>$v->nu_naforca</td>
                            <td style='text-align: center'>$v->nu_outros</td>
                            <td style='text-align: center'>$v->nu_aptocomrestricao</td>
                            <td style='text-align: center'>$v->nu_pronto</td>
                            </tr>";
                    }  
                            $dados_pdf .= "<tr>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>TOTAL</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_previsto</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_existente</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_claros</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_excedente</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_jpms</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_licencaespecial</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_ferias</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_adisposicao</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_emcurso</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_naforca</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_outros</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_aptocomrestricao</b></center></th>
                                            <th style='background-color: #D9EDF7; color: #000'><h5><center><b>$t_nu_pronto</b></center></th>
                                        </tr>";   
                }
            $dados_pdf .= "</tbody>
            <footer>
                SISGP - Impresso em ".date("d/m/Y \à\s H:i")." por {$dadosUsuario['name']}
            </footer>
        </table>";
        $mpdf->WriteHTML($dados_pdf, 2);
        ob_clean();      // Tira mensagem de erro no chrome
        $mpdf->Output("mapaforca_".$dadosUsuario['st_descricao'],'I'); //Nome do arquivo
        exit();
    ?>
</body>

</html> 