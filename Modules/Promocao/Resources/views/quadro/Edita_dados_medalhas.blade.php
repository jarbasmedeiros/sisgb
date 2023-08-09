@extends('rh::funcionario.Form_edita_funcionario')

@section('tabcontent')
<div class="tab-pane active" id="dados_pessoais">
    <h4 class="tab-title">Medalhas - {{ strtoupper($servidor->st_nome) }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('/rh/servidor/edita/'.$servidor->id) }}">
        {{ csrf_field() }}
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th>Medalha</th>
                        <th>BG Nº</th>
                        <th>Data BG</th>
                        <th>DOE</th>
                        <th class='col-1' >Ações</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
    </form>
</div>
<!-- /.tab-pane -->
@endsection