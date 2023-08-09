@extends('adminlte::page')

@section('title', 'Habilitações - Arquivos da Habilitação')

@section('content')
<!-- Modal da assinatura -->
    <div class="modal bg-danger" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="assinarModalLabel">Assinar Habilitação</h5>
                </div>
                <div class="modal-body bg-danger">
                    <div class="form-group">
                        <strong> DESEJA SOLICITAR A CONCLUSÃO DA HABILITAÇÃO? </strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                    <a class="btn btn-success" href="
                    {{
                        URL::route('finaliza_habilitacao_id', ['idHabilitacao' => $dados->id])
                    }}"
                    class="btn btn-primary">
                        Sim
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                Formulário de Habilitação - Anexar Documentos
                </div>
                <div class="panel-body">
                        <fieldset class="scheduler-border">    	
                            <legend class="scheduler-border">Policial Selecionado</legend>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="st_nomepolicial">Nome</label>
                                    <input disabled type="text" class="form-control"  value="{{ $dados->policial->st_nome }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="st_cpfpolicial">CPF</label>
                                    <input disabled data-mask="000.000.000-00" type="text" class="form-control" value="{{ $dados->policial->st_cpf }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="st_matriculapolicial">Matrícula</label>
                                    <input disabled id="st_matricula" type="text" class="form-control" value="{{ $dados->policial->st_matricula }}">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="bo_vivo">Vivo?</label>
                                    <input disabled type="text" class="form-control" value="@if($dados->policial->bo_vivo == 1) SIM @else NÃO @endif">
                                </div>
                            </div>       
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                Dados do Solicitante
                            </legend>
                            <div class="row">       
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="st_nomesolicitante">
                                            Nome
                                        </label>
                                        <input disabled class="form-control" id="st_nomesolicitante" name="st_nomesolicitante" required type="text" value="{{ $dados->solicitante->st_nome }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="st_cpfsolicitante">
                                            CPF
                                        </label>
                                        <input disabled data-mask="000.000.000-00" class="form-control" id="st_cpf" name="st_cpf" required type="text" value="{{ $dados->solicitante->st_cpf }}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                Dados da Habilitação
                            </legend>
                            <div class="row">   
                                <div class="form-group col-md-3">
                                    <label for="st_protocolo">
                                        Protocolo
                                    </label>
                                    <input disabled class="form-control" type="text" value="{{ $dados->st_protocolo }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="dt_solicitacao">
                                        Data de Solicitação
                                    </label>
                                    <input disabled class="form-control" type="datetime" value="{{ 
                                        date('d/m/Y', strtotime($dados->dt_cadastro))
                                     }}">
                                </div> 
                                <div class="form-group col-md-2">
                                    <label for="dt_solicitacao">
                                        Tipo da Habilitação
                                    </label>
                                    <input disabled class="form-control" type="text"value="{{ ($dados->st_tipo == 'pos-morte') ? 'Pós-Morte' : 'Judicial' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="dt_solicitacao">
                                        Status
                                    </label>
                                    <input disabled class="form-control" type="text"value="{{ $dados->st_status }}">
                                </div> 
                            </div>
                        </fieldset>
                        @if($dados->st_status != 'SOLICITADO')
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">
                                    Cadastro de Arquivos
                                </legend>
                                <form enctype="multipart/form-data" method="post" action=" {{ URL::Route('create_arquivo_habilitacao', ['idHabilitacao' => $dados->id]) }} ">
                                    {{ csrf_field() }}
                                    
                                    <input hidden type="text" name="ce_policial" value={{ $dados->policial->id }}>
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <label for="arquivo">
                                                Documento
                                            </label>
                                            <input required class="form-control" id="st_descricao" name="st_descricao" type="text">
                                            <p class="help-block">
                                                Descrição do Arquivo
                                            </p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="arquivo">
                                                Arquivo
                                            </label>
                                            <input required class="" id="arquivo" name="arquivo" type="file">
                                            <p class="help-block">
                                                Foto, Documento, etc...
                                            </p>
                                        </div>
                                        <button class="btn btn-primary" type="submit" style="margin-top: 20px;">
                                            <span class="fa fa-send">
                                            </span>
                                            Salvar Arquivo
                                        </button>
                                    </div>
                                </form>
                            </fieldset>
                        @endif
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                Lista de Arquivos Anexados
                            </legend>
                            <div class="row">
                                <table class="table table-hover">
                                    <div class="row">
                                        <thead class="bg-primary">
                                            <th class="col-md-5">
                                                Arquivo
                                            </th>
                                            <th class="col-md-5">
                                                Descrição
                                            </th>
                                            <th class="col-md-2">
                                                Ações
                                            </th>
                                        </thead>
                                    </div>
                                    
                                    <tbody>
                                        @foreach($dados->arquivosanexados as $arquivo)
                                            <tr>
                                                <td>
                                                    {{$arquivo->st_nomearquivo}}
                                                </td>
                                                <td>
                                                    {{$arquivo->st_tipodocumento}}
                                                </td>
                                                <td>
                                                        <!-- <a target="_blank" class="btn btn-primary" href="
                                                        {{
                                                            URL::route('get_arquivo_habilitacao', [
                                                                'idHabilitacao' => $dados->id,
                                                                'ano' => substr($arquivo->st_pasta, 0, 4),
                                                                'idArquivo' => $arquivo->id
                                                            ])
                                                        }}">
                                                            <span class="icon fa fa-eye fa-lg"></span>
                                                        </a> -->
                                                        <a target="_blank" class="btn btn-primary" href="
                                                        {{
                                                            URL::route('get_arquivo_habilitacao', [
                                                                'idHabilitacao' => $dados->id,
                                                                'ano' => substr($arquivo->st_pasta, 0, 4),
                                                                'nomeArquivo' => $arquivo->st_arquivo . '.' . $arquivo->st_extensao
                                                            ])
                                                        }}" title='Ver arquivo em outra aba'>
                                                            <span class="icon fa fa-eye fa-lg"></span>
                                                        </a>
                                                        <a class="btn btn-primary" href="
                                                        {{
                                                            URL::route('download_arquivo_habilitacao', [
                                                                'idHabilitacao' => $dados->id,
                                                                'ano' => substr($arquivo->st_pasta, 0, 4),
                                                                'nomeArquivo' => $arquivo->st_arquivo . '.' . $arquivo->st_extensao
                                                            ])
                                                        }}" title='Baixar aquivo para seu pc'>
                                                            <span class="icon fa fa-download fa-lg"></span>
                                                        </a>
                                                        @if($dados->st_status != 'SOLICITADO')
                                                            <a class="btn btn-danger" href="
                                                            {{
                                                                URL::route('delete_arquivo_habilitacao', [
                                                                    'idHabilitacao' => $dados->id,
                                                                    'ano' => substr($arquivo->st_pasta, 0, 4),
                                                                    'nomeArquivo' => $arquivo->st_arquivo . '.' . $arquivo->st_extensao,
                                                                    'idArquivo' => $arquivo->id
                                                                ])
                                                            }}" title='Deletar arquivo'>
                                                                <span class="icon fa fa-trash fa-lg"></span>
                                                            </a>
                                                        @endif
                                                        
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @if(empty($dados->arquivosanexados))
                                            <tr>
                                                <td colspan="8">
                                                    <strong>
                                                        <p style="text-align: center;">
                                                            Nenhum arquivo cadastrado.
                                                        </p>
                                                    </strong>
                                                </td>
                                            </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>   
                        </fieldset>
                    <a href=" {{ URL::route('dps_tela_habilitacoes') }} " class="btn btn-warning" title='Voltar para tela anterior'>
                        <span class="icon fa fa-arrow-left fa-lg"></span>
                        Voltar
                    </a>
                    @if ($dados->st_status != 'ABERTO')
                        <a target='_blank' class="btn btn-primary" href="{{
                                URL::route('dps_tela_pdf_cadastro', [
                                    'idHabilitacao' => $dados->id
                                ])
                         }}" title='Imprimir comprovante de habilitação'>
                            <span class="icon fa fa-file-text-o fa-lg"></span>
                            Imprimir Comprovante
                        </a>
                    @endif
                    
                    @if($dados->st_status != 'SOLICITADO')
                        <a class="btn btn-warning" href="{{ URL::route('dps_tela_editar_solicitante', [
                            'cpf' => $dados->solicitante->st_cpf,
                            'idHabilitacao' => $dados->id
                            ]) 
                        }}">
                            <span class="icon fa fa-pencil fa-lg"></span>
                            Editar Solicitante
                        </a>
                        <a href="#" data-toggle="modal" data-target="#assinarModal" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok"></span>
                            Concluir
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection