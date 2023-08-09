@extends('dps::prontuario.abas_prontuario_pensionista')

@section('title', 'Habilitações - Arquivos da Habilitação')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                Formulário de Upload de Arquivo de Prova de Vida
                </div>
                <div class="panel-body">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Cadastro de Arquivos
                        </legend>
                        <form enctype="multipart/form-data" method="post" action=" {{ URL::Route('prontuario_pensionista_id', ['pensionistaId' => $dadosAba->id,'aba' => 'recadastro','acao' => 'uploadprovadevida','idRegistro' => $idProvaDeVida]) }} ">
                            {{ csrf_field() }}
                            
                            <input hidden type="text" name="ce_policial" value={{ $dadosAba->ce_policial }}>
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
                    <a style='margin-bottom:20px' href="{{ url('dps/pensionistas/'.$dadosAba->id.'/recadastro/listar') }}" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
                        <i class="glyphicon glyphicon-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection