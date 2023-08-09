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
                        <th colspan="3">RELAÇÃO DE UNIDADES </th>
                    </tr>
                    <tr>
                        <th >SIGLA</th>
                        <th >DESCRIÇÃO</th>
                        <th >SUBORDINAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($unidades))
                    @foreach($unidades as $s)
                <tr>
                    <th>{{$s->st_sigla}}</th>
                    <th>{{$s->st_descricao}}</th>
                    <th>{{$s->hierarquia}}</th>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </body>
</html>