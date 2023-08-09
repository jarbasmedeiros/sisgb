@extends('dps::prontuario.abas_prontuario_pensionista')

@section('title', 'SISGP - Dados do Pensionista')

@section('tabcontent')
    <div class="tab-pane active" id="dados_pensao">
        <h4 class="tab-title">Arquivos do Pensionista - {{ $dadosAba->pessoa->st_nome }}</h4>
        <hr class="separador">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        {{-- <fieldset class="scheduler-border">
            <legend class="scheduler-border">
                Arquivos da Pensão
            </legend> --}}
            <div class="row">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        Arquivos do Pensionista
                    </legend>
                    <form enctype="multipart/form-data" method="post" action=" {{ URL::Route('salvar_prontuario_pensionista', ['pensionistaId' => $dadosAba->id, 'aba' => 'arquivos', 'acao' => 'salvar']) }} ">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="arquivo">
                                    Documento
                                </label>
                                <input placeholder="Descrição do Arquivo" required class="form-control" id="st_descricao" name="st_descricao" type="text">
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
                                Anexar Arquivo
                            </button>
                        </div>
                    </form>

                    <div class="row">
                        @if($arquivos>0)
                        <table class="table table-hover">
                            <div class="row">
                                <thead class="bg-primary">
                                    <th class="col-md-5">
                                        Arquivos Anexados
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
                                @foreach($arquivos as $arquivo)
                                    <tr>
                                        <td>
                                            {{$arquivo->st_nomearquivo}}
                                        </td>
                                        <td>
                                            {{$arquivo->st_tipodocumento}}
                                        </td>
                                        <td>
                                            <a target='_blank' data-toggle="tooltip" title="Documento do Pensionista" class="btn btn-primary" href="{{ URL::route('prontuario_pensionista_id', [
                                                'pensionistaId' => $dadosAba->id,
                                                'aba' => 'recadastro',
                                                'acao' => 'consultarDocumento',
                                                'idRegistro' => $arquivo->id
                                            ]) }}">
                                        <span class="icon fa fa-download fa-lg">
                                        </span>
                                        </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @if(empty($arquivos))
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
                    @endif
                    </div>
                </fieldset>
                {{-- <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        Lista de Arquivos Anexados
                    </legend> --}}
                    
                {{-- </fieldset> --}}
            </div>
        {{-- </fieldset> --}}
    </div>
<!-- /.tab-pane -->
@endsection