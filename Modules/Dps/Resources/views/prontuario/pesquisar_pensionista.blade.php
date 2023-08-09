@extends('adminlte::page')

@section('title', 'SISGP - Pesquisar Pensionista')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Pesquisa de Prontuário do Pensionista
                </div>
                <div class="panel-body">

                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Pesquisar Pensionista
                        </legend>
                        <form method="post" action=" {{ URL::route('pesquisar_pensionista') }}">
                            {{ csrf_field() }}
                            <div class="form-group col-md-6">
                                <label for="st_parametro">CPF/Nome do Pensionista</label>
                                <div class="input-group">
                                    <input required id="st_parametro" class="form-control" name="st_parametro" type="text">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                    @empty($pensionistas)
                    @else
                    <hr>
                    
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Prontuários de Pensionistas Localizados
                        </legend>
                        <table class="table table-hover">
                            <thead class="bg-primary">
                                <th >
                                    BENEFICIÁRIO
                                </th>
                                <th >
                                    POLICIAL
                                </th>
                                <th >
                                    VÍNCULO
                                </th>
                                <th>
                                    SITUAÇÃO
                                </th>
                                <th>
                                    OBS
                                </th>
                                <th>
                                    AÇÕES
                                </th>
                            </thead>
                            <tbody>
                                @foreach($pensionistas as $p)
                                    <tr>
                                        <td>
                                            {{ $p->pessoa->st_nome }}
                                        </td>
                                        <td>
                                        {{ $p->policial->graduacao->st_postograduacaosigla }} {{ $p->policial->st_nome }}
                                        </td>
                                        <td class="col-md-1">
                                            {{ $p->st_vinculo }}
                                        </td>
                                        <td class="col-md-1">
                                            {{ $p->st_situacao }}
                                        </td>
                                        <td class="col-md-1">
                                            {{ $p->st_obs }}
                                        </td>
                                        <td class="col-md-1">
                                            <a class="btn btn-primary" href="{{
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
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                
                            </tfoot>
                        </table>
                    </fieldset>
                    @endempty
                </div>
            </div>
        </div>
    </div>
@endsection