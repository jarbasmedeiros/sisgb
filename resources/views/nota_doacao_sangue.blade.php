@extends('boletim::notas/template_nota')

@section('title', 'Criar Nota')

@section('nota_doacao_sangue')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/boletim/store') }}">
        {{csrf_field()}}
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Informações da doação</legend>
            <div class="form-row">
                <div class="form-group col-xs-3" style="margin-right:29%;">
                    <label for="inputPolicial">Policial</label>
                    <input type="text" class="form-control" id="inputPolicial" placeholder="Matrícula ou CPF">
                </div>
                <div class="form-group col-xs-3" style="margin-left:auto;">
                    <label for="inputData">Data da doação</label>
                    <input type="date" name="inputData" class="form-control" id="inputData"/>
                </div>
                <div class="form-group col-xs-3" style="margin-left:auto;">
                    <label for="inputPolicial">Local da doação</label>
                    <input type="text" class="form-control" id="inputPolicial">
                </div>
            </div>
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Post/Grad</th>
                    <th>Praça</th>
                    <th>Matrícula</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($modelos))
                    @foreach($modelos as $m)
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        </fieldset>
    </form>
@stop
