@extends('rh::policial.Form_edita_policial')
@section('title', 'Listar Férias')
@section('tabcontent')
    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Férias - {{ strtoupper($policial->st_nome) }}</h4>
        <hr class="separador">
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="7">Férias</th>
                       
                    </tr>
                    <tr>
                        <th>Início</th>
                        <th>Dias</th>
                        <th>Fim</th>
                        <th>Ano referência</th>
                        <th>Observações</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($ferias))
                        @foreach($ferias as $fe)
                            <tr>
                                <td>{{date('d/m/Y', strtotime($fe->dt_inicio))}}</td>
                                <td>{{$fe->nu_dias}}</td>
                                <td>{{date('d/m/Y', strtotime($fe->dt_termino))}}</td>
                                <td>{{$fe->st_anoreferencia}}</td>
                                <td>{{$fe->st_obs}}</td>
                                <td>Foram usufruídos {{$fe->nu_dias_gozadas}} dias</td>
                                <td>
                                    <a href="{{url('rh/historicoferias/lista/' . $policial->id . '/' . $fe->id)}}" title="Histórico férias"><i class="btn btn-success fa fa-list"></i></a>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">Não há férias cadastradas</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection