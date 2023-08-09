<html lang="pt-BR">

<head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <link rel="stylesheet" href="{{ asset('assets/css/pdf_nota.css') }}">
    <script src="http://localhost/prjSisGp/public/vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://localhost/prjSisGp/public/vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css">

    <title>
        Nota_{{$nota->id}}
    </title>
</head>

<body>
    @if($nota->st_status != 'PUBLICADA')
    <div id="watermarkNota">
        <p><b>{{'Rascunho por '.Auth::user()->st_cpf}}</b></p>
    </div>
    @else
    <div class="footer">
        <p>{{$nota->st_boletim->st_tipo}} {{sprintf('%03d', $nota->st_boletim->nu_sequencial)}}/{{$nota->st_boletim->nu_ano}}, datado de {{  \Carbon\Carbon::parse($nota->st_boletim->dt_boletim)->format('d/m/Y') }}</p>
    </div>
    @endif
    <div>
        <script type="text/php">
        if ( isset($pdf) ) {
            $font = null;
            $pdf->page_script('
            $pdf->line(72,790,540,790,array(0,0,0),1); // linha de baixo
            $pdf->line(72,790,72,70,array(0,0,0),1); // linha da esquerda
            $pdf->line(72,70,540,70,array(0,0,0),1); // linha de cima
            $pdf->line(540,70,540,790,array(0,0,0),1); // linha da direita
            ');
        }
        </script>
    </div>
    <div> 
        @if(isset($nota->st_assunto))
            <div>
                <h5>{{$nota->st_assunto}}</h5> 
            </div>
        @endif
        <div>
            <p>{!!$nota->st_materia!!}</p>
        </div>
    </div>
    
    
    @if(isset($policiaisDaNota) && count($policiaisDaNota) > 0)
    
        <div class="esquerda20">
        <!--<p class="newpage"></p>-->
        @switch($nota->ce_tipo)
            @case(17)
                <table style="width:100%" class="table-sm table-bordered ">
                    <thead class="font-size-10">
                        <tr>
                            <th class="text-center">Ord.</th>
                            <th class="text-center">Post/Grad</th>
                            <th class="text-center">Matrícula</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">Origem</th>
                            <th class="text-center">Destino</th>
                            <th class="text-center">A contar de</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($policiaisDaNota as $key => $policiais)
                        @php $ordem = $key+1; @endphp
                        <tr>
                            <td class="text-center">{{$ordem}}</td>
                            <td class="text-center">{{$policiais->st_postograduacaosigla}}</td>
                            <td class="text-center">{{$policiais->st_matricula}}</td>
                            <td class="text-center">{{$policiais->st_nome}}</td>
                            <td class="text-center">{{$policiais->st_siglaopmorigem}}</td>
                            <td class="text-center">{{$policiais->st_siglaopmdestino}}</td>
                            <td class="text-center">{{date('d/m/Y', strtotime($policiais->dt_acontar))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @break
            @case(18)
                <table style="width:100%" class="table-sm table-bordered ">
                    <thead class="font-size-10">
                        <tr>
                            <th class="text-center">Ord.</th>
                            <th class="text-center">Post/Grad</th>
                            <th class="text-center">Matrícula</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">OPM Origem</th>
                            <th class="text-center">Função Atual</th>
                            <th class="text-center">OPM Destino</th>
                            <th class="text-center">Nova Função</th>
                            <th class="text-center">A contar de</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($policiaisDaNota as $key => $policiais)
                        @php $ordem = $key+1; @endphp
                        <tr>
                            <td class="text-center">{{$ordem}}</td>
                            <td class="text-center">{{$policiais->st_postograduacaosigla}}</td>
                            <td class="text-center">{{$policiais->st_matricula}}</td>
                            <td class="text-center">{{$policiais->st_nome}}</td>
                            <td class="text-center">{{$policiais->st_siglaopmorigem}}</td>
                            <td class="text-center">{{$policiais->st_funcaoatual}}</td>
                            <td class="text-center">{{$policiais->st_siglaopmdestino}}</td>
                            <td class="text-center">{{$policiais->st_novafuncao}}</td>
                            <td class="text-center">{{date('d/m/Y', strtotime($policiais->dt_acontar))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @break
            @default
                <p class="h4 text-center font-weight-bold">POLICIAIS DA NOTA</p>   
                <table style="width:100%" class="table-sm table-bordered table-striped">
                    <thead class="font-size-10">
                        <tr>
                            <th class="text-center">Ord.</th>
                            <th class="text-center">Post/Grad</th>
                        
                            <th class="text-center">Nome</th>
                            <th class="text-center">Matrícula</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($policiaisDaNota as $key => $policiais)
                        @php $ordem = $key+1; @endphp
                        <tr>
                            <td class="text-center">{{$ordem}}</td>
                            <td class="text-center">{{$policiais->st_postograduacaosigla}}</td>
                     
                            <td class="text-left">{{$policiais->st_nome}}</td>
                            <td class="text-center">{{$policiais->st_matricula}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        @endswitch
    </div>
    @endif

</body>

</html> 