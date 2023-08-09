@extends('adminlte::page')

@section('title', 'Listagem de Beneficiários')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Formulário de Habilitação - Solicitante
                </div>
                <div class="panel-body">
                    <fieldset class="scheduler-border">    	
                        <legend class="scheduler-border">Policial Selecionado</legend>
                
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="st_nome">Nome</label>
                                <input disabled id="st_nome" type="text" class="form-control" placeholder="Digite o nome" name="st_nome" value="{{ $policial->st_nome }}">
                            </div>
                            
                            <div class="form-group col-md-2">
                                <label for="st_cpf">CPF</label>
                                <input disabled id="st_cpf" type="text" class="form-control" placeholder="Digite o nome" name="st_cpf" value="{{ $policial->st_cpf }}">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="bo_vivo">Vivo?</label>
                                <input disabled id="bo_vivo" type="text" class="form-control" placeholder="Digite o nome" name="bo_vivo" value="@if($policial->bo_vivo == 1) SIM @else NÃO @endif">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="st_matricula">Matrícula</label>
                                <input disabled id="st_matricula" type="text" class="form-control" placeholder="Digite o nome" name="st_matricula" value="{{ $policial->st_matricula }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="st_graduacao">Graduação</label>
                                <input disabled id="bo_vivo" type="text" class="form-control" placeholder="Digite o nome" name="bo_vivo" value="{{ $policial->st_postograduacao }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="st_nivel">Nível da Graduação</label>
                                <input disabled id="st_nivel" type="text" class="form-control" placeholder="Digite o nome" name="st_nivel" value="{{ $policial->st_nivel }}">
                            </div>
                        </div>        
                    </fieldset>
                    <a href="{{ URL::route('dps_tela_novo_solicitante', ['idPolicial' => $policial->id]) }}" class="btn btn-primary btn-md">
                        <span class="glyphicon glyphicon-plus"></span>
                        Cadastrar Solicitante
                    </a>
                        
                    <hr>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Lista de Beneficiários da Última Declaração
                        </legend>
                        <table class="table table-hover">
                            <thead class="bg-primary">
                                <div class="row">
                                    <th class="col-md-4">
                                        Nome
                                    </th>
                                    <th class="col-md-2">
                                        Ordem
                                    </th>
                                    <th class="col-md-2">
                                        CPF
                                    </th>
                                    <th class="col-md-2">
                                        Sexo
                                    </th>
                                    <th class="col-md-1">
                                        Ações
                                    </th>
                                </div>
                            </thead>
                            <tbody>
                            @empty($beneficiarios)
                            @else
                                @foreach($beneficiarios->beneficiarios as $b)       
                                    <tr>
                                        <td>
                                            {{ $b->pessoa->st_nome }}
                                        </td>
                                        <td>
                                            {{ $b->st_ordem }}
                                        </td>
                                        <td>
                                            {{ $b->pessoa->st_cpf }}
                                        </td>
                                        <td>
                                            {{ $b->pessoa->st_sexo == "M" ? "Masculino" : "Feminino" }}
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href=" {{ URL::Route('dps_tela_dados_solicitacao', [$policial->id, $b->pessoa->id]) }} ">
                                                <span class="glyphicon glyphicon-ok"></span>
                                                Selecionar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endempty
                            </tbody>
                            @empty($beneficiarios)
                            <tfoot>
                                <tr>
                                    <td colspan=6>
                                        <strong>
                                            <p style="text-align:center;">
                                            Nenhum beneficiário encontrado.
                                            </p>
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                            @endempty
                        </table>                        
                    </fieldset>
                    <div class="form-group">
                        <a href="{{ URL::route('dps_tela_pesquisar_policial') }}" class="btn btn-warning">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                            Voltar
                        </a>
                        <a href="{{ URL::route('dps_tela_habilitacoes') }}" class="btn btn-danger btn-md">
                            <span class="glyphicon glyphicon-remove"></span>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection