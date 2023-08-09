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
        <table class="table table-responsive">
            <thead>
                    <tr>
                        @if($tiporegistro == 1)
                            <th colspan="7">{{$nomeLista}}</th>
                        @endif
                        @if($tiporegistro == 2)
                            <th colspan="6">{{$nomeLista}}</th>
                        @endif
                    </tr>
                    <tr>
                        <th class="col-md-3">NOME DO FUNCIONÁRIO</th>
                        <th class="col-md-2">SETOR</th>
                        <th class="col-md-2">FUNÇÃO</th>
                        <th class="col-md-2">ÓRGÃO</th>
                        <th class="col-md-2">INÍCIO</th>
                        <th class="col-md-2">FIM</th>
                        @if($tiporegistro == 1)
                            <th class="col-md-1">ANO REFERENTE</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(isset($listRegistros) && count($listRegistros) > 0)
                        @foreach($listRegistros as $r)
                            <tr>
                                <th>{{$r->st_nomefuncionario}}</th>
                                <th>{{$r->st_siglasetor}}</th>
                                <th>{{$r->st_funcao}}</th>
                                <th>{{$r->st_orgao}}</th>
                                @foreach($r->listRegistros as $key => $valor)
                                    @if($valor->st_nomeitem == 'Início')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                    @endif
                                    @if($valor->st_nomeitem == 'Fim')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}</th>
                                    @endif
                                    @if($valor->st_nomeitem == 'Referente')
                                        <th>{{$valor->st_valor}}</th>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                </tbody>
        </table>
    </body>
</html>