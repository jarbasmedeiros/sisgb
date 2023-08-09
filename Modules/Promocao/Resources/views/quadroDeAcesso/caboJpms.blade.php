@extends('promocao::quadroDeAcesso.templateJpms')
@section('title', 'CABO - Convocação Para Junta Médica')
@section('tabcontent')
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Dados da Portaria</legend>
        <br>
        <div class="row">
            <div class="form-group">
                @if($atividade->ce_nota == null)
                    <label>Início da nota</label>
                    <textarea class="form-control ckeditor" rows="3" id="st_portaria2" name="st_portaria2" placeholder="Digite os Dados de Portaria..." required>{{ $atividade->st_portaria2 }}</textarea>
                    <label>Fechamento da nota</label>
                    <textarea class="form-control ckeditor" rows="3" id="st_fechamento2" name="st_fechamento2" placeholder="Digite os Dados de Portaria..." required>{{ $atividade->st_fechamento2 }}</textarea>    
                @else
                    <div class="panel panel-default">
                        <div class="panel-heading">Início da nota</div>
                        <div class="panel-body">
                            {!! $atividade->st_portaria2 !!}
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Fechamento da nota</div>
                        <div class="panel-body">
                            {!! $atividade->st_fechamento2 !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </fieldset>
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Lista de Cabos</legend>
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
                        @if($cabosConvocados->count() > 0)
                            @foreach($cabosConvocados as $cabo)
                                <tr>
                                    <th>{{$contadorChamados}}</th>
                                    <th>{{$cabo->st_postgrad}}</th>
                                    <th>{{$cabo->st_numpraca}}</th>
                                    <th>{{$cabo->st_policial}}</th>
                                    <th>{{$cabo->st_matricula}}</th>
                                    <th>{{$cabo->st_unidade}}</th>
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
                        @if($cabosAptos->count() > 0)
                            @foreach($cabosAptos as $cabo)
                                <tr>
                                    <th>{{$contadorDispensados}}</th>
                                    <th>{{$cabo->st_postgrad}}</th>
                                    <th>{{$cabo->st_numpraca}}</th>
                                    <th>{{$cabo->st_policial}}</th>
                                    <th>{{$cabo->st_matricula}}</th>
                                    <th>{{$cabo->st_unidade}}</th>
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
            </div>
        </div>
    </fieldset>
</form>
@endsection