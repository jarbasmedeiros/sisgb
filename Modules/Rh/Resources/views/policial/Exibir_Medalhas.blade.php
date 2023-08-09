@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Medalhas')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 197, crude de medalhas de um policial. -->
<div class="tab-pane active" id="dados_medalhas">
    <h4 class="tab-title">Medalhas - {{ $policial->st_nome}}</h4>
    <hr class="separador">
        {{ csrf_field() }}
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan = "3">LISTA DE MEDALHAS</th>
                        
                    </tr>
                    <tr>   
                        <th class = "col-md-3">MEDALHA</th>
                        <th class = "col-md-3">PUBLICAÇÃO</th>
                        <th class = "col-md-3">DATA DA PUBLICAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($medalha))
                        @forelse($medalha as $m)
                        <tr>
                            <td>{{$m->st_nome}}</td>
                            <td>{{$m->st_publicacao}}</td>
                            <td>{{\Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y')}}</td>
                           
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Nenhuma medalha encontrada.</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-offset-0">
            <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/dados_pessoais')}}">
                    <i class="fa fa-arrow-left"></i> Voltar
            </a>
        </div>
</div>

@endsection