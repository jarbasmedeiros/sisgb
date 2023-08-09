@extends('adminlte::page')

@section('title', 'Habilitações - Formulário de Habilitação')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Formulário de Habilitação -
                    @empty($policiais)
                        busca do policial
                    @else
                        seleção do policial
                    @endempty
                </div>
                <div class="panel-body">

                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Encontrar Policial
                        </legend>
                        <form method="post" action=" {{ URL::route('get_dados_policial') }}">
                            {{ csrf_field() }}
                            <div class="form-group col-md-6">
                                <label for="st_parametro">CPF/Matrícula/Nome do Policial</label>
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
                    @empty($policiais)
                    @else
                    <hr>
                    
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Dados do Policial
                        </legend>
                        <table class="table">
                            <thead class="bg-primary">
                                <th>
                                    Nome
                                </th>
                                <th>
                                    Matrícula
                                </th>
                                <th>
                                    CPF
                                </th>
                                <!-- <th>
                                    Status
                                </th> -->
                                <th>
                                    Ações
                                </th>
                            </thead>
                            <tbody>
                                @foreach($policiais as $p)
                                    <tr>
                                        <td>
                                            {{ $p->st_nome }}
                                        </td>
                                        <td>
                                            {{ $p->st_matricula }}
                                        </td>
                                        <td>
                                            {{ $p->st_cpf }}
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href=" {{ URL::route('dps_tela_beneficiarios_policial', $p->id) }} ">
                                                <span class="glyphicon glyphicon-ok"></span>
                                                Selecionar
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
                    
                    <a href=" {{ URL::route('dps_tela_habilitacoes') }} " class="btn btn-danger">
                        <span class="glyphicon glyphicon-remove"></span>
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection