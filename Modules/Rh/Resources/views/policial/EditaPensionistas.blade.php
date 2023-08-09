
@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP -  Pensionistas')
@section('tabcontent')

    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Pensionistas - {{ $policial->st_nome}}</h4>
        <hr class="separador">
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="8">Pensionistas</th>
                    </tr>
                    <tr>
                         <th>Nome</th>
                        <th>Tipo de pensão</th>
                        <th>Vínculo</th>
                        <th>Situação</th>
                        <th>Data Início</th>
                        <th>Data de término</th>
                        <th>Data de cadastro</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($pensionistas)>0)               
                    @foreach($pensionistas as $p) 
                    <tr>
                        <td>{{$p->pessoa->st_nome}}</td>
                        <td>{{$p->st_tipo}}</td>
                        <td>{{$p->st_vinculo}}</td>
                        <td>{{$p->st_situacao}}</td>
                        <td>{{\Carbon\Carbon::parse($p->dt_inicio)->format('d/m/Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($p->dt_termino)->format('d/m/Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($p->dt_cadastro)->format('d/m/Y')}}</td>

                        <td class="text-center">
                        <a target="_blank" class="btn btn-primary" href="{{
                            URL::route('prontuario_pensionista', [
                                'pensionistaId' => $p->id,
                                'aba' => 'dados_pessoais',
                                'acao' => 'editar'
                            ])
                        }}">
                            <span class="fa fa-folder-open fa-lg"></span>
                            Abrir
                        </a>
                        </td>
                    @endforeach 
                    </tr> 
                    @else
                    <tr>
                        <td colspan="6" class="text-center">Não há pensionistas vinculados a este policial.</td>
                    </tr>
                    @endif              
                </tbody>
            </table>
        </div>
    </div>  

           

    
@endsection
