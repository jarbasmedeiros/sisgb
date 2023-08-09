@extends('adminlte::page')

@section('title', 'Prontuário')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">CARDENETA DE REGISTRO MÉDICO (CR-MÉDICA)</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('juntamedica/prontuario/cadastrar/') }}">
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Identificação do Paciente</legend>
                                    <div class="form-group">
                                        <label for="st_orgao" class="col-md-2 col-md-offset-1 control-label">Orgão</label>
                                        <div class="col-md-7">
                                            <select id="st_orgao" type="text" class="form-control" name="st_orgao" required>
                                                <option disabled selected>--Selecione--</option>
                                                <option value="PM">PM</option>
                                                <option value="CBOM">CBOM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="st_cpf" class="col-md-2 col-md-offset-1 control-label">CPF</label>
                                        <div class="col-md-7">
                                            <input id="st_cpf" type="text" class="form-control" placeholder="CPF" name="st_cpf" required/>
                                        </div>
                                        <div id="div_btn_consultar_pm" class="col-md-2" hidden>
                                            <a id="btn_consultar_pm" class="btn btn-primary" title="Localizar PM">
                                                <i class="fa fa-search"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="st_matricula" class="col-md-2 col-md-offset-1 control-label">Matrícula</label>
                                        <div class="col-md-7">
                                            <input id="st_matricula" type="text" class="form-control" placeholder="Matrícula" name="st_matricula" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="st_postograduacao" class="col-md-2 col-md-offset-1 control-label">Post/Grad</label>
                                        <div class="col-md-7">
                                            <input id="st_postograduacao" type="text" class="form-control" placeholder="Post/Grad" name="st_postograduacao" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="st_nome" class="col-md-2 col-md-offset-1 control-label">Nome</label>
                                        <div class="col-md-7">
                                            <input id="st_nome" type="text" class="form-control" placeholder="Nome" name="st_nome" required/>
                                            @if ($errors->has('st_nome'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_nome') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="dt_nascimento" class="col-md-2 col-md-offset-1 control-label">Data de nascimento</label>
                                        <div class="col-md-7">
                                            <input id="dt_nascimento" type="date" class="form-control" placeholder="Data de nascimento" name="dt_nascimento" required/>
                                            @if ($errors->has('dt_nascimento'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('dt_nascimento') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="st_unidade" class="col-md-2 col-md-offset-1 control-label">Unidade</label>
                                        <div class="col-md-7">
                                            <input id="st_unidade" type="text" class="form-control" placeholder="Unidade" name="st_unidade" required/>
                                        <br/>
                                        </div>
                                    </div>
                                    <div class="form-group" hidden>
                                        <label for="ce_pessoa" class="col-md-2 col-md-offset-1 control-label">Pessoa</label>
                                        <div class="col-md-7">
                                            <input id="ce_pessoa" type="text" class="form-control" placeholder="Pessoa" name="ce_pessoa"/>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <button class="col-md-4 btn btn-warning">
                                <a href="{{ url('juntamedica/prontuario') }}" id="a-voltar" class="col-md-2" style="color: white;" title="Voltar">
                                    <i class="glyphicon glyphicon-arrow-left"></i>&nbsp&nbsp&nbsp&nbspVoltar
                                </a>
                            </button>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <button type="submit" class="col-md-4 btn btn-primary" title="Salvar">
                                <i class="fa fa-save"></i>&nbsp&nbsp&nbsp&nbspSalvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
    <script>
        $('#st_orgao').change(function(){
            $('#st_cpf').val('');
            $('#st_matricula').val('');
            $('#st_postograduacao').val('');
            $('#st_nome').val('');
            $('#dt_nascimento').val('');
            $('#st_unidade').val('');
            $('#ce_pessoa').val('');
            if($('#st_orgao').val()==="PM"){
                $('#div_btn_consultar_pm').show();
                $('#st_matricula').attr('readonly', true);
                $('#st_postograduacao').attr('readonly', true);
                $('#st_nome').attr('readonly', true);
                $('#dt_nascimento').attr('readonly', true);
                $('#st_unidade').attr('readonly', true);
            }else{
                $('#div_btn_consultar_pm').hide();
                $('#st_matricula').removeAttr('readonly');
                $('#st_postograduacao').removeAttr('readonly');
                $('#st_nome').removeAttr('readonly');
                $('#dt_nascimento').removeAttr('readonly');
                $('#st_unidade').removeAttr('readonly');
            }
        });
        function mCPF(cpf){
            cpf=cpf.replace(/\D/g,"");
            cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2");
            cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2");
            cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
            return cpf;
		};
        $('#btn_consultar_pm').click( function() {
            if($('#st_cpf').val()!==null){
                let cpf = $('#st_cpf').val();
                $.ajax({
                    url: "{{ url('juntamedica/prontuario/policial') }}/"+ cpf,
                    method: "get",
                    dataType: "json",
                }).done(function(data){
                    console.log(data);
                    if(typeof(data.retorno) !== 'undefined'){
                        alert(data.msg);
                    }else{
                        $('#st_cpf').val(mCPF(data.st_cpf));
                        $('#st_matricula').val(data.st_matricula);
                        $('#st_postograduacao').val(data.st_postograduacao);
                        $('#st_nome').val(data.st_nome);
                        $('#dt_nascimento').val(data.dt_nascimento);
                        $('#st_unidade').val(data.st_unidade);
                        $('#ce_pessoa').val(data.ce_pessoa);
                    }
                }).fail(function(data){
                    alert('Não foi possível encontrar o PM.');
                });
            }
        });
    </script>
@endsection
@section("css")
<style>
    th, td {
        text-align: center;
    }

    label {
        margin-top: 06px;
    }

    #a-voltar {
        margin-left: 10px
    }
</style>
@stop