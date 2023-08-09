@extends('dps::prontuario.abas_prontuario_pensionista')

@section('title', 'SISGP - Dados do Pensionista')

@section('tabcontent')

<div class="tab-pane active" id="dados_pensao">
    <h4 class="tab-title">Dados da Pensão - {{ $dadosAba->pessoa->st_nome }}</h4>
    <hr class="separador">
    <fieldset class="scheduler-border">
            <legend class="scheduler-border">
                Policial Responsável
            </legend>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="st_nome">Nome</label>
                        <input type="text" disabled name="st_nome" class="form-control" value="{{ $dadosAba->policial->st_nome }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                    <label for="st_nome">Matrícula</label>
                        <input type="text" disabled name="st_matricula" class="form-control" value="{{ $dadosAba->policial->st_matricula }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                    <label for="st_nome">Pos/Grad</label>
                        <input type="text" disabled class="form-control" value="{{ $dadosAba->policial->graduacao->st_postograduacao }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="st_nome">Unidade</label>
                        <input type="text" disabled class="form-control" value="{{ $dadosAba->policial->st_unidade }}">
                    </div>
                </div>

            </div>
        </fieldset>
    <form role="form" method="POST" action=" {{ URL::route('salvar_prontuario_pensionista', [
        'pensionistaId' => $dadosAba->id,
        'aba' => 'dados_pensao',
        'acao' => 'salvar'
    ]) }} ">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">
                Dados da Pensão
            </legend>
            <div class="row">
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="st_tipo">Tipo</label>
                        <select required class="form-control" name="st_tipo" id="st_tipo">
                            <option value="">--Selecione--</option>
                            <option {{ $dadosAba->st_tipo == 'POS_MORTE' ? 'selected' : '' }} value="POS_MORTE">Pós-Morte</option>
                            <option {{ $dadosAba->st_tipo == 'JUDICIAL' ? 'selected' : '' }} value="JUDICIAL">Judicial</option>
                        </select>
                    </div>
                </div>

                

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="st_vinculo">Vínculo</label>
                        <select required class="form-control" name="st_vinculo" id="st_vinculo">
                            <option value="">--Selecione--</option>
                            <option {{ $dadosAba->st_vinculo == 'Pai/Mãe' ? 'selected' : '' }} value="Pai/Mãe">PAI/MÃE</option>
                            <option {{ $dadosAba->st_vinculo == 'Filhos' ? 'selected' : '' }} value="Filhos">FILHOS</option>
                            <option {{ $dadosAba->st_vinculo == 'Conjuge' ? 'selected' : '' }} value="Conjuge">CONJUGE</option>
                            <option {{ $dadosAba->st_vinculo == 'Companheiro' ? 'selected' : '' }} value="companheiro">COMPANHEIRO/A</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="vl_pensao">Valor</label>
                        <input type="text" name="vl_pensao" class="form-control" value="{{ $dadosAba->vl_pensao }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="vl_pensao">Legislação</label>
                        <input type="text" name="st_legislacao" maxlength="300" class="form-control" value="{{ $dadosAba->st_legislacao }}" >
                    </div>
                </div>

                

            </div>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">
                Dados da Situação da Pensão
            </legend>
            <div class="row">
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="st_situacao">Situação</label>
                        <select name="st_situacao" class="form-control" id="st_situacao" required>
                            <option value="">Selecione a situação</option>
                            <option @php echo $dadosAba->st_situacao == "bloqueado" ? "selected" : "" @endphp value="bloqueado">Bloqueado</option>
                            <option @php echo $dadosAba->st_situacao == "finalizado" ? "selected" : "" @endphp value="finalizado">Finalizado</option>
                            <option @php echo $dadosAba->st_situacao == "implantado" ? "selected" : "" @endphp value="implantado">Implantado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="st_duracao">Duração</label>
                        <select name="st_duracao" class="form-control" id="st_duracao" required>
                            <option value="">Selecione a duração</option>
                            <option @php echo $dadosAba->st_duracao == "temporaria" ? "selected" : "" @endphp value="temporaria">Temporária</option>
                            <option @php echo $dadosAba->st_duracao == "vitalicia" ? "selected" : "" @endphp value="vitalicia">Vitalícia</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="dt_inicio">Início</label>
                        <input class="form-control" name="dt_inicio" type="date" name="dt_termino" value={{$dadosAba->dt_inicio}}>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="dt_termino">Término</label>
                        <input class="form-control" name="dt_termino" type="date" name="dt_termino" value={{$dadosAba->dt_termino}}>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="st_motivotermino">Motivo do Término</label>
                        <input type="text" name="st_motivotermino" class="form-control" value="{{ $dadosAba->st_motivotermino }}">
                    </div>
                </div>

            </div>
        </fieldset>

        <div class="row">
            <div class="form-group">                
                               
                <div class="col-md-1" style='text-align: center;'>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-fw fa-save"></i> Salvar
                    </button>                
                </div>                            
            </div>
        </div>
            
    </form>
</div>


<!-- /.tab-pane -->
@endsection