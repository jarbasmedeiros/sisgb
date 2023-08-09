@extends('promocao::quadroDeAcesso.templateJpms')
@section('title', 'SOLDADO - Convocação Para Junta Médica')
@section('tabcontent')

    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Dados da Portaria</legend>
        <br>
        <div class="row">
            <div class="form-group">
                @if($atividade->ce_nota == null)
                    <label>Início da nota</label>
                    <textarea class="form-control ckeditor" rows="3" id="st_portaria" name="st_portaria" placeholder="Digite os Dados de Portaria..." required>{{ $atividade->st_portaria }}</textarea>
                    <label>Fechamento da nota</label>
                    <textarea class="form-control ckeditor" rows="3" id="st_fechamento" name="st_fechamento" placeholder="Digite os Dados de Portaria..." required>{{ $atividade->st_fechamento }}</textarea>
                @else
                    <div class="panel panel-default">
                        <div class="panel-heading">Início da nota</div>
                        <div class="panel-body">
                            {!! $atividade->st_portaria !!}
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Fechamento da nota</div>
                        <div class="panel-body">
                            {!! $atividade->st_fechamento !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </fieldset>
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Lista de Soldado</legend>
        <br>
        <div class="row">
            <div class="form-group">
                @php
                    $contadorChamados = $contadorDispensados = 1;
                @endphp
                <label for="comment">A - Lista para Junta Médica</label>
                <table class="table table-bordered" id="tabelaChamados">
                    <thead>
                        <tr class="bg-primary">
                            <th>Ord</th>
                            <th>Post / Grad</th>
                            <th>Nº Praça</th>
                            <th>Nome</th>
                            <th>Matrícula</th>
                            <th>Unidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($soldadosConvocados->count() > 0)
                            @foreach($soldadosConvocados as $soldado)
                                <tr>
                                    <th>{{$contadorChamados}}</th>
                                    <th>{{$soldado->st_postgrad}}</th>
                                    <th>{{$soldado->st_numpraca}}</th>
                                    <th>{{$soldado->st_policial}}</th>
                                    <th>{{$soldado->st_matricula}}</th>
                                    <th>{{$soldado->st_unidade}}</th>
                                </tr>
                                @php
                                    $contadorChamados++;
                                @endphp
                            @endforeach
                        @else
                            <tr><th colspan="6">Não há policiais cadastrados</th></tr>
                        @endif
                    </tbody>
                </table>
                {{$soldadosConvocados->links()}}
                <br />
                <label for="comment">B - Deixa de Convocar por está apto</label>
                <table class="table table-bordered" id="tabelaDispensados">
                    <thead>
                        <tr class="bg-primary">
                            <th>Ord</th>
                            <th>Post / Grad</th>
                            <th>Nº Praça</th>
                            <th>Nome</th>
                            <th>Matrícula</th>
                            <th>Unidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($soldadosAptos->count() > 0)
                            @foreach($soldadosAptos as $soldado)
                                <tr>
                                    <th>{{$contadorDispensados}}</th>
                                    <th>{{$soldado->st_postgrad}}</th>
                                    <th>{{$soldado->st_numpraca}}</th>
                                    <th>{{$soldado->st_policial}}</th>
                                    <th>{{$soldado->st_matricula}}</th>
                                    <th>{{$soldado->st_unidade}}</th>
                                </tr>
                                @php
                                    $contadorDispensados++;
                                @endphp
                            @endforeach
                        @else
                            <tr><th colspan="6">Não há policiais cadastrados</th></tr>
                        @endif
                    </tbody>
                </table>
                {{$soldadosAptos->links()}}
            </div>
        </div>
    </fieldset>

@endsection