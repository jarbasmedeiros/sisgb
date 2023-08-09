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
                            <th colspan = "8">Lista de Policiais Militares atendidos pela CMAPM (Aguardando Publicação em BG) </th>                             
                        </tr>
                        <tr>
                            <th class="col-md-1">Nº</th>
                            <th class="col-md-1">Nome</th>
                            <th class="col-md-1">Matrícula</th>
                            <th class="col-md-1">Parecer</th>
                            <th class="col-md-1">Motivo</th>
                            <th class="col-md-1">Restrição</th>
                            <th class="col-md-1">Início</th>
                            <th class="col-md-1">Término</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($atendimentosAguardandoPublicacao))
                            @forelse($atendimentosAguardandoPublicacao as $a)
                            @php $restricoesConcatenadas = ' '; @endphp
                                @if(count($a->restricoes) > 0)
                                    @foreach($a->restricoes as $r)
                                        @if(!$loop->last)
                                            @php $restricoesConcatenadas .= $r->st_restricao.', '; @endphp 
                                        @else
                                            @php $restricoesConcatenadas .= $r->st_restricao.'.'; @endphp
                                        @endif
                                    @endforeach                                               
                                @endif
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$a->policial->st_nome}}</td>
                                <td>{{$a->policial->st_matricula}}</td>
                                <td>{{$a->st_parecer}}</td>
                                <td>{{$a->st_motivo}}</td>
                                <td>{{$restricoesConcatenadas}}</td>
                                <td>{{\Carbon\Carbon::parse($a->dt_inicio)->format('d/m/Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($a->dt_termino)->format('d/m/Y')}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">Nenhum policial encontrado.</td>
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