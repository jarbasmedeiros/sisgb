@extends('rh::policial.Form_edita_policial')
@section('title', 'Listar Licenças')
@section('tabcontent')
    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Licenças - {{ strtoupper($policial->st_nome) }}</h4>
        <hr class="separador">
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="6">Licenças</th>
                        
                    </tr>
                    <tr>
                        <th>Início</th>
                        <th>Dias</th>
                        <th>Fim</th>
                        <th>Tipo</th>
                        <th>Observações</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($licenca))
                        @foreach($licenca as $li)
                            <tr>
                                <td>{{date('d/m/Y', strtotime($li->dt_inicio))}}</td>
                                <td>{{$li->nu_dias}}</td>
                                <td>{{date('d/m/Y', strtotime($li->dt_termino))}}</td>
                                <td>{{$li->tipo->st_tipo}}</td>
                                <td>{{$li->st_obs}}</td>
                                <td>Foram usufruídos {{(empty($li->nu_dias_gozadas)) ? '0' : $li->nu_dias_gozadas}} dias</td>
                               
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">Não há licença cadastradas</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    
@endsection