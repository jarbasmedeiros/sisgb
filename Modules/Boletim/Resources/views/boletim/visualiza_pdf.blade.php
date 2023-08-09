<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }};">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- PDF -->
    <link rel="stylesheet" href="{{ asset('assets/css/pdf_boletim.css') }}">

    <style type="text/css">

@page{
    margin: 120px 78px 58px 100px;
}

/** 
* Define the width, height, margins and position of the watermark.
**/
#watermarkBoletim {
    position: fixed;
    top: 20%;
    width: 100%;
    text-align: center;
    opacity: .2;
    transform: rotate(-50deg);
    transform-origin: 50% 50%;
    z-index: -1000;
    font-size: 95px;
    font-family: "Times New Roman", Times, serif;
}
#watermarkNota {
    position: fixed;
    top: 20%;
    width: 100%;
    text-align: center;
    opacity: .2;
    transform: rotate(-50deg);
    transform-origin: 50% 50%;
    z-index: -1000;
    font-size: 95px;
    font-family: "Times New Roman", Times, serif;
}
div {
    font-family: "Times New Roman", Times, serif;
}
#anexo{
    text-align: center;
    margin-bottom: 0px;
}
th{
    text-align: center;
    
}
td{
    text-align: center;
    font-weight: normal;
}
.parte {
    font-size: 16px;
}
.newpage {
    page-break-after: always;
}
.esquerda20 {
  margin-left: 20px;    
}
.direita20 {
  margin-right: 100px;    
}
.estiloTabela{
    width: 617px; 
    margin-bottom: 10px;
}
.capa{
    font-size: 20px;
    margin-bottom: 5px;
}
.tabela-boletim{
    width: 617px; 
    padding: 0px;
    border: solid 1 black;
}
.cor-do-fundo{
    background-color: darkgray;
}
.font-size-10{
    font-size: 10px;
}
.line-heigt-8 {
    LINE-HEIGHT: 8px;
}
.line-heigt-10 {
    LINE-HEIGHT: 10px;
}
.assinatura {
    font-size: 14px;
    text-align: center;
    margin-top: 20px;
    line-height: 16px;
}
.inferior20 {
    margin-bottom: 20px;    
  }



    </style>







    <title>{{ $boletim->st_nome }}</title>
</head>
<body>
@php
    $contadorparte4 = 1;
    $contadorparte3 = 1;
    $contadorparte2 = 1;
    $contadorparte1 = 1;
    $contador = 1;
@endphp
    <div id="watermarkBoletim">
        <p><strong>{!!$marcadagua!!}</strong></p>
    </div>
    <div class="border">
        <div class="line-heigt-10">
            {!!$capa->st_cabecalho!!}
        </div>
        <div class="text-center">
            <img src="data:image/jpeg;base64,{!!$img!!}" alt="Brasão PMRN" height="337" width="300" style="margin: 25px 0px 0px 0px;">
            <div class="capa">{{strtoupper($boletim->st_nome)}}</div>    
            <div class="capa">{{$capa->st_cidade}}/RN, {{$boletim->dt_porExtenso}}</div>
            <div class="capa">({{$boletim->dt_diaDaSemana}})</div>
        </div>
        <div class="line-heigt-8">
            {!!$capa->st_funcoes!!}
        </div>
        
        
        <!-- Notas -->
        <div class="parte">
            <div class="text-center" style="margin-bottom:10px;"><strong>Para conhecimento e devida execução, torno público o seguinte:</strong></div>
            <div class="titulo_parte" style="text-align:center;">1ª PARTE</div>
            <div class="titulo_parte" style="text-align:center;">(Serviços Diários)</div>
            @if(count($notas->parte1) > 0)
                @foreach($notas->parte1 as $nota)
                @if($contadorparte1 != $nota->st_topico)
                    <div class="assunto_nota" style="font-weight:bold;"><p>{{numberToRoman($contador)}} - <span style="text-decoration: underline;">{{$nota->st_topico}}</span></p></div>
               
              
                @php
                    $contador++;
                    $contadorparte1 = $nota->st_topico;
                @endphp
                @endif
                    <div>{!! $nota->st_materia !!}</div>
                    @if(isset($nota->policiais) && count($nota->policiais) > 0)
                    @if($nota->ce_tipo == 17)
                        <table  style="width:100%" class='table-sm table-bordered'>
                            <thead class="cor-do-fundo font-size-10">
                                <tr>
                                    <th>ORD.</th>
                                    <th>POSTO/GRAD.</th>
                                    <th>NOME</th>
                                    <th>MATRÍCULA</th>
                                    <th>ORIGEM</th>
                                    <th>DESTINO</th>
                                    <th>ACONTAR DE</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-10">
                                @php $conta = 0; @endphp
                                @foreach($nota->policiais as $policial)
                                    @php $conta++; @endphp
                                    <tr>
                                        <td class="text-center">{{$conta}}</td>
                                        <td class="text-center">{{$policial->st_postograduacaosigla}}</td>
                                        <td class="text-center">{{$policial->st_matricula}}</td>
                                        <td class="text-center">{{$policial->st_nome}}</td>
                                        <td class="text-center">{{$policial->st_siglaopmorigem}}</td>
                                        <td class="text-center">{{$policial->st_siglaopmdestino}}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($policial->dt_acontar))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <table style="width:100%" class='table-sm table-bordered'>
                            <thead class="cor-do-fundo font-size-10">
                                <tr>
                                    <th>ORD.</th>
                                    <th>POSTO/GRAD.</th>
                                    <th>Nº</th>
                                    <th>NOME</th>
                                    <th>MATRÍCULA</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-10">
                                @php $conta = 0; @endphp
                                @foreach($nota->policiais as $policial)
                                    @php $conta++; @endphp
                                    <tr>
                                        <td>{{$conta}}</td>
                                        <td>{{$policial->st_postograduacaosigla}} PM</td>
                                        <td>{{$policial->st_numpraca}}</td>
                                        <td>{{$policial->st_nome}}</td>
                                        <td>{{$policial->st_matricula}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    @endif    
                   
                    <br></br>
                <br></br>
                @endforeach
            @else
                <p style="text-align:center;"><strong>Sem Alteração</strong></p>
            @endif
        </div>
        <div class="parte">
            <div class="titulo_parte" style="text-align:center;">2ª PARTE</div>
            <div class="titulo_parte" style="text-align:center;">(Ensino e Instrução)</div>
            @if(count($notas->parte2) > 0)
                @foreach($notas->parte2 as $nota)
                    
                @if($contadorparte2 != $nota->st_topico)
                    <div class="assunto_nota" style="font-weight:bold;"><p>{{numberToRoman($contador)}} - <span style="text-decoration: underline;">{{$nota->st_topico}}</span></p></div>
                    
                    @php
                    $contador++;
                    $contadorparte2 = $nota->st_topico;
                    @endphp
                @endif
                    <div>{!! $nota->st_materia !!}</div>
                    @if(isset($nota->policiais) && count($nota->policiais) > 0)
                    @if($nota->ce_tipo == 17)
                        <table  style="width:100%" class='table-sm table-bordered'>
                            <thead class="cor-do-fundo font-size-10">
                                <tr>
                                    <th>ORD.</th>
                                    <th>POSTO/GRAD.</th>
                                    <th>NOME</th>
                                    <th>MATRÍCULA</th>
                                    <th>ORIGEM</th>
                                    <th>DESTINO</th>
                                    <th>ACONTAR DE</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-10">
                                @php $conta = 0; @endphp
                                @foreach($nota->policiais as $policial)
                                    @php $conta++; @endphp
                                    <tr>
                                        <td class="text-center">{{$conta}}</td>
                                        <td class="text-center">{{$policial->st_postograduacaosigla}}</td>
                                        <td class="text-center">{{$policial->st_matricula}}</td>
                                        <td class="text-center">{{$policial->st_nome}}</td>
                                        <td class="text-center">{{$policial->st_siglaopmorigem}}</td>
                                        <td class="text-center">{{$policial->st_siglaopmdestino}}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($policial->dt_acontar))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <table style="width:100%" class='table-sm table-bordered'>
                            <thead class="cor-do-fundo font-size-10">
                                <tr>
                                    <th>ORD.</th>
                                    <th>POSTO/GRAD.</th>
                                    <th>Nº</th>
                                    <th>NOME</th>
                                    <th>MATRÍCULA</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-10">
                                @php $conta = 0; @endphp
                                @foreach($nota->policiais as $policial)
                                    @php $conta++; @endphp
                                    <tr>
                                        <td>{{$conta}}</td>
                                        <td>{{$policial->st_postograduacaosigla}} PM</td>
                                        <td>{{$policial->st_numpraca}}</td>
                                        <td>{{$policial->st_nome}}</td>
                                        <td>{{$policial->st_matricula}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    @endif
                  
                    <br></br>
                <br></br>
                @endforeach
            @else
                <p style="text-align:center;"><strong>Sem Alteração</strong></p>
            @endif
        </div>
        <div class="parte">
            <div class="titulo_parte" style="text-align:center;">3ª PARTE</div>
            <div class="titulo_parte" style="text-align:center;">(Assuntos Gerais e Administrativos)</div>
            @if(count($notas->parte3) > 0)
                @foreach($notas->parte3 as $nota)
                @if($contadorparte3 != $nota->st_topico)
                    <div class="assunto_nota" style="font-weight:bold;"><p>{{numberToRoman($contador)}} - <span style="text-decoration: underline;">{{$nota->st_topico}}</span></p></div>
                    
                    @php
                    $contador++;
                    $contadorparte3 = $nota->st_topico;
                    @endphp
                @endif
                    <div>{!! $nota->st_materia !!}</div>
                <br></br>
                <br></br>
                    @if(isset($nota->policiais) && count($nota->policiais) > 0)
                        @if($nota->ce_tipo == 17)
                        <table  style="width:100%" class='table-sm table-bordered'>
                            <thead class="cor-do-fundo font-size-10">
                                <tr>
                                    <th>ORD.</th>
                                    <th>POSTO/GRAD.</th>
                                    <th>NOME</th>
                                    <th>MATRÍCULA</th>
                                    <th>ORIGEM</th>
                                    <th>DESTINO</th>
                                    <th>ACONTAR DE</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-10">
                                @php $conta = 0; @endphp
                                @foreach($nota->policiais as $policial)
                                    @php $conta++; @endphp
                                    <tr>
                                        <td class="text-center">{{$conta}}</td>
                                        <td class="text-center">{{$policial->st_postograduacaosigla}}</td>
                                        <td class="text-center">{{$policial->st_matricula}}</td>
                                        <td class="text-center">{{$policial->st_nome}}</td>
                                        <td class="text-center">{{$policial->st_siglaopmorigem}}</td>
                                        <td class="text-center">{{$policial->st_siglaopmdestino}}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($policial->dt_acontar))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <table style="width:100%" class='table-sm table-bordered'>
                            <thead class="cor-do-fundo font-size-10">
                                <tr>
                                    <th>ORD.</th>
                                    <th>POSTO/GRAD.</th>
                                    <th>Nº</th>
                                    <th>NOME</th>
                                    <th>MATRÍCULA</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-10">
                                @php $conta = 0; @endphp
                                @foreach($nota->policiais as $policial)
                                    @php $conta++; @endphp
                                    <tr>
                                        <td>{{$conta}}</td>
                                        <td>{{$policial->st_postograduacaosigla}} PM</td>
                                        <td>{{$policial->st_numpraca}}</td>
                                        <td>{{$policial->st_nome}}</td>
                                        <td>{{$policial->st_matricula}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    @endif
                 
                    <br></br>
                <br></br>
                @endforeach
            @else
                <p style="text-align:center;"><strong>Sem Alteração</strong></p>
            @endif
        </div>
        <div class="parte">
            <div class="titulo_parte" style="text-align:center;">4ª PARTE</div>
            <div class="titulo_parte" style="text-align:center;">(Justiça e Disciplina)</div>
            @if(count($notas->parte4) > 0)
                @foreach($notas->parte4 as $nota)
                @if($contadorparte4 != $nota->st_topico)
                    <div class="assunto_nota" style="font-weight:bold;"><p>{{numberToRoman($contador)}} - <span style="text-decoration: underline;">{{$nota->st_topico}}</span></p></div>
                    
                    @php
                    $contador++;
                    $contadorparte4 = $nota->st_topico;
                    @endphp
                @endif
                    <div>{!! $nota->st_materia !!}</div>
                                        
                    @if(isset($nota->policiais) && count($nota->policiais) > 0)
                    @if($nota->ce_tipo == 17)
                        <table  style="width:100%" class='table-sm table-bordered'>
                            <thead class="cor-do-fundo font-size-10">
                                <tr>
                                    <th>ORD.</th>
                                    <th>POSTO/GRAD.</th>
                                    <th>NOME</th>
                                    <th>MATRÍCULA</th>
                                    <th>ORIGEM</th>
                                    <th>DESTINO</th>
                                    <th>ACONTAR DE</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-10">
                                @php $conta = 0; @endphp
                                @foreach($nota->policiais as $policial)
                                    @php $conta++; @endphp
                                    <tr>
                                        <td class="text-center">{{$conta}}</td>
                                        <td class="text-center">{{$policial->st_postograduacaosigla}}</td>
                                        <td class="text-center">{{$policial->st_matricula}}</td>
                                        <td class="text-center">{{$policial->st_nome}}</td>
                                        <td class="text-center">{{$policial->st_siglaopmorigem}}</td>
                                        <td class="text-center">{{$policial->st_siglaopmdestino}}</td>
                                        <td class="text-center">{{date('d/m/Y', strtotime($policial->dt_acontar))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <table style="width:100%" class='table-sm table-bordered'>
                            <thead class="cor-do-fundo font-size-10">
                                <tr>
                                    <th>ORD.</th>
                                    <th>POSTO/GRAD.</th>
                                    <th>Nº</th>
                                    <th>NOME</th>
                                    <th>MATRÍCULA</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-10">
                                @php $conta = 0; @endphp
                                @foreach($nota->policiais as $policial)
                                    @php $conta++; @endphp
                                    <tr>
                                        <td>{{$conta}}</td>
                                        <td>{{$policial->st_postograduacaosigla}} PM</td>
                                        <td>{{$policial->st_numpraca}}</td>
                                        <td>{{$policial->st_nome}}</td>
                                        <td>{{$policial->st_matricula}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    @endif
                   
                <br></br>
                <br></br>
                @endforeach
            @else
                <p style="text-align:center;"><strong>Sem Alteração</strong></p>
            @endif
        </div>
        @if(!empty($boletim->st_responsavelassinatura) && ($boletim->st_status == 'ASSINADO' || $boletim->st_status == 'PUBLICADO'))
        <div class="assinatura">
            <div class="inferior20">Assinado Eletronicamente por</div>
            <div>{{$boletim->st_responsavelassinatura}}, {{$boletim->st_postograduacaoassinante}} PM</div>
            <div>{{$boletim->st_funcaoassinante}}</div>
        </div>
        @endif
    </div>
    <script type="text/php"> // Função para o cabeçalho
        if ( isset($pdf) ) {
            $font = null;
            $pdf->page_script('
                if ($PAGE_NUM > 1) {
                    $font = null;
                    $current_page = $PAGE_NUM-1;
                    $total_pages = $PAGE_COUNT-1;
                    $pdf->text(225, 75, "{{$boletim->st_siglaCabecalho . ", de " .  $boletim->dt_porExtenso}}", $font, 10, array(0,0,0));
                    $pdf->text($pdf->get_width() - 85, 75, "$current_page de $total_pages", $font, 10, array(0,0,0));
                }
                $pdf->line(72,790,540,790,array(0,0,0),1); // linha de baixo
                $pdf->line(72,790,72,70,array(0,0,0),1); // linha da esquerda
                $pdf->line(72,70,540,70,array(0,0,0),1); // linha de cima
                $pdf->line(540,70,540,790,array(0,0,0),1); // linha da direita
            ');
        }
    </script> 
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/jquery.inputmask.bundle.js') }}"></script>
    @php
        /**
            * Converts a number to its roman presentation.
            **/ 
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
        
            foreach ($lookup as $roman => $value)  
            {
                // Look for number of matches
                $matches = intval($n / $value); 
        
                // Concatenate characters
                $result .= str_repeat($roman, $matches); 
        
                // Substract that from the number 
                $n = $n % $value; 
            } 

            return $result; 
        }
    @endphp
</body>
</html>
