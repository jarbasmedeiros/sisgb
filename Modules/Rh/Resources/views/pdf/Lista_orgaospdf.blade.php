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
                            <th colspan="2">RELAÇÃO DE ÓRGÃOS</th>
                        </tr>
                        <tr>
                            <th >NOME</th>
                            <th >SIGLA</th>
                         
                          
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($orgaos))
                            @forelse ($orgaos as $org)
                            <tr>
                                <th>{{$org->st_orgao}}</th>
                                <th>{{$org->st_sigla}}</th>
                               
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Nenhum Órgão Cadastrado</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
               
   </body>
   </html>

