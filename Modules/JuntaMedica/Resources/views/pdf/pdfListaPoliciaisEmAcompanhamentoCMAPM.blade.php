<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }};">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- PDF -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/pdf_boletim.css') }}"> -->
    <style>
        th, td{text-align: center;}       
    </style>

    <title>Aguardando Publicação em BG</title>
</head>


<div class="container">
    <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan = "6">Lista de Policiais Militares em Acompanhamento pela CMAPM </th>                            
                    </tr>
                    <tr>
                        <th class="col-md-4">Nome</th>
                        <th class="col-md-2">Nome de Guerra</th>
                        <th class="col-md-1">Sexo</th>
                        <th class="col-md-1">Posto/Graduação</th>
                        <th class="col-md-1">Matrícula</th>
                        <th class="col-md-1">OPM</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($policiaisEmAcompanhamento))
                        @forelse($policiaisEmAcompanhamento as $p)
                        <tr>
                            <td>{{$p->st_nome}}</td>
                            <td>{{$p->st_nomeguerra}}</td>
                            <td>{{$p->st_sexo}}</td>
                            <td>{{$p->ce_graduacao}}</td>
                            <td>{{$p->st_matricula}}</td>
                            <td>{{$p->st_unidade}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">Nenhum policial encontrado.</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</html>