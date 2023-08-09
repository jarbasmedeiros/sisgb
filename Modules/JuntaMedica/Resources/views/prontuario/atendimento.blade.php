@extends('adminlte::page')
<?php
use App\utis\Funcoes;
?>
@section('title', 'Novo Atendimento')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">ATENDIMENTO MÉDICO DA JUNTA MÉDICA</div>
            <div class="panel-body">
                <fieldset class="scheduler-border">
                    @if ($bo_correcao)
                    <legend class="scheduler-border">Formulário para correção do atendimento</legend>
                    @else
                    <legend class="scheduler-border">Formulário para conclusão do atendimento</legend>
                    @endif
                    <br/>                                           
                    <form id="formAtend" enctype="multipart/form-data" class="form-horizontal" method="POST" role="form" action="{{ url('juntamedica/atendimento/'.$atendimento->ce_prontuario.'/'.$atendimento->id.'/salvar') }}">
                    {{ csrf_field() }}
                        <input hidden name="bo_correcao" value="{{$bo_correcao}}"/>
                        @if(isset($idSessao))
                        <input hidden name="idSessao" value="{{$idSessao}}"/>
                        @endif
                        <div id="ce_sessao" class="form-group{{ $errors->has('ce_sessao') ? ' has-error' : '' }}">
                            <label for="ce_sessao" class="col-md-4 control-label">Tipo da Sessão</label>
                            <div class="col-md-6">
                                <select id="ce_sessao" type="text" name="ce_sessao" class="form-control" required>
                                    @if(count($sessoesabertas)<1)
                                        <option value="" selected="selected" disabled>Não há sessões abertas.</option>
                                    @endif
                                    @foreach ($sessoesabertas as $tiposessao)
                                        @if(!$tiposessao->bo_conferida)
                                            @if ($tiposessao->id == $atendimento->ce_sessao)
                                                <option value="{{$tiposessao->id}}" selected="selected">{{"Sessão ".$tiposessao->nu_sequencial." (".$tiposessao->st_tipo.")"}}</option>
                                            @else
                                                <option value="{{$tiposessao->id}}">{{"Sessão ".$tiposessao->nu_sequencial." (".$tiposessao->st_tipo.")"}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>                           
                            </div>
                            @if ($errors->has('ce_sessao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ce_sessao') }}</strong>
                                </span>
                            @endif
                        </div>    

                        <!-- Date -->
                        <div class="form-group{{ $errors->has('dt_parecer') ? ' has-error' : '' }}">
                            <label for="dt_parecer" class="col-md-4 control-label">Data do Parecer</label>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="dt_parecer" name="dt_parecer" type="date" value="{{$atendimento->dt_parecer}}" class="form-control pull-right" required/>
                                </div>
                            </div>
                            @if ($errors->has('dt_parecer'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_parecer') }}</strong>
                                </span>
                            @endif 
                        </div>

                        <div class="form-group{{ $errors->has('st_parecer') ? ' has-error' : '' }}">
                            <label for="st_parecer" class="col-md-4 control-label">Parecer</label>
                            <div class="col-md-6">   
                                <select id="st_parecer" name="st_parecer" class="form-control" onchange="RemoverCampos()" required>
                                    <option value="" selected="selected" disabled>--Selecionar--</option>
                                    <option value="APTO">APTO</option>
                                    <option value="APTO COM RESTRIÇÃO">APTO COM RESTRIÇÃO</option>
                                    <option value="APTO COM RESTRIÇÃO (EM DEFINITIVO)">APTO COM RESTRIÇÃO (EM DEFINITIVO)</option>
                                    <option value="LTS">LTS</option>
                                </select>                            
                            </div>
                            @if ($errors->has('st_parecer'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_parecer') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div id="div_st_causaefeito" class="form-group{{ $errors->has('st_causaefeito') ? ' has-error' : '' }}">
                            <label for="st_causaefeito" class="col-md-4 control-label">Causa/efeito</label>
                            <div class="col-md-6">   
                                <select id="st_causaefeito" name="st_causaefeito" class="form-control">
                                    <option value="" selected="selected" disabled>--Selecionar--</option>
                                    <option value="R">R ou APD</option>
                                    <option value="PR">PR ou APPI</option>
                                    <option value="NR">NR ou DNRP</option>
                                </select>                            
                            </div>
                            @if ($errors->has('st_causaefeito'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_causaefeito') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                    <div id="div_st_restricao" class="form-group{{ $errors->has('st_restricao') ? ' has-error' : '' }}">
                            <label for="st_restricao" class="col-md-4 control-label">Restrições</label>
                            <div class="col-md-6">
                                <select id="st_restricao" type="text" class="form-control select2"  name="st_restricao[]" multiple="multiple" data-placeholder=" Selecione os dados" style="width: 100%;">
                                    @if(isset($restricoes))
                                        @foreach ($restricoes as $restricao)
                                            @if (in_array($restricao->id, $restricoesSelecionadas))
                                                <option value="{{$restricao->id}}" selected>{{$restricao->st_restricao}}</option>
                                            @else
                                                <option value="{{$restricao->id}}">{{$restricao->st_restricao}}</option>
                                            @endif
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            @if ($errors->has('st_restricao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_restricao') }}</strong>
                                </span>
                            @endif
                        </div>
                    
                        <div id="div_ce_cid" class="form-group{{ $errors->has('ce_cid') ? ' has-error' : '' }}">
                            <label for="ce_cid" class="col-md-4 control-label">CID</label>
                            <div class="col-md-6">
                                <select id="ce_cid" type="search" name="ce_cid" class="form-control">
                                    <option value="" selected="selected" disabled>--Selecionar--</option>
                                    @foreach ($cids as $cid)
                                    @if ($cid->id == $atendimento->ce_cid)
                                        <option value="{{$cid->id}}" selected>{{$cid->st_cid." - ".$cid->st_doenca}}</option>
                                    @else
                                        <option value="{{$cid->id}}">{{$cid->st_cid." - ".$cid->st_doenca}}</option>
                                    @endif
                                    @endforeach
                                </select>                           
                            </div>
                            @if ($errors->has('ce_cid'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ce_cid') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div id="div_dt_inicio" class="form-group{{ $errors->has('dt_inicio') ? ' has-error' : '' }}">
                            <label for="dt_inicio" class="col-md-4 control-label">Início</label>
                            <div class="col-md-6">
                                <input id="dt_inicio" name="dt_inicio" type="date" class="form-control" value="{{$atendimento->dt_inicio}}" onchange="datafim()"/> 
                            </div>
                            @if ($errors->has('dt_inicio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_inicio') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div id="div_nu_dias" class="form-group{{ $errors->has('nu_dias') ? 'has-error' : '' }}">
                            <label for="nu_dias" class="col-md-4 control-label">Duração</label>
                            <div class="col-md-6">
                                <input id="nu_dias" name="nu_dias" type="number" class="form-control" value="{{$atendimento->nu_dias}}" onchange="datafim()" placeholder="total de dias" onkeypress='return SomenteNumero(event)'/> 
                            </div>
                            @if ($errors->has('nu_dias'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nu_dias') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div id="div_dt_termino" class="form-group{{ $errors->has('dt_termino') ? 'has-error' : '' }}">
                            <label for="dt_termino" class="col-md-4 control-label">Término</label>
                            <div class="col-md-6">
                                <input id="dt_termino" name="dt_termino" type="date" value="{{$atendimento->dt_termino}}" class="form-control" readonly="true"/>
                            </div>
                            @if ($errors->has('dt_termino'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_termino') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div id="div_ce_perito" class="form-group{{ $errors->has('ce_perito') ? 'has-error' : '' }}">
                            <label for="ce_perito" class="col-md-4 control-label">Médico</label>
                            <div class="col-md-6">
                                <select id="ce_perito" type="text" name="ce_perito" class="form-control" required>
                                    <option value="" selected="selected" disabled>--Selecionar--</option>
                                    @php $cpfUsuario = Funcoes::limpaCPF_CNPJ($cpfUsuario); @endphp
                                    @foreach ($peritos as $perito)
                                        @if($perito->st_cpf==$cpfUsuario)
                                            <option value="{{$perito->id}}" selected>{{$perito->st_nome." - ".$perito->st_conselho}}</option>
                                        @else
                                            <option value="{{$perito->id}}">{{$perito->st_nome." - ".$perito->st_conselho}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('ce_perito'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ce_perito') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('st_obs') ? ' has-error' : '' }}">
                            <label for="st_obs" class="col-md-4 control-label">Observações</label>
                            <div class="col-md-6">
                                <textarea rows="4" cols="63" id="st_obs" name="st_obs" class="form-control" placeholder="Observações ...">{{$atendimento->st_obs}}</textarea>
                            </div>
                            @if ($errors->has('st_obs'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_obs') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-8 col-md-offset-5 mb-10">               
                            <button id="salvarForm" type="submit" class="btn btn-primary">
                                <i class="fa fa-fw fa-save"></i> Salvar Parecer
                            </button>
                        </div>
                    </form>
                </fieldset>
                @if (isset($atendimento->st_parecer) && !empty($atendimento->st_parecer))
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Anexar documento</legend>
                        <form id="formAnexo" enctype="multipart/form-data" method="POST" role="form" action="{{ url('juntamedica/atendimento/'.$atendimento->ce_prontuario.'/'.$atendimento->id.'/'.$atendimento->ce_pessoa.'/salvar/anexo') }}"> 
                            {{ csrf_field() }}
                            <div class="table-responsive form-group{{ $errors->has('anexos') ? ' has-error' : '' }}">
                                <table id="tb_anexos" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2">Data do Documento</th>
                                            <th class="col-md-4">Tipo de Documento</th>
                                            <th class="col-md-3">Descrição</th>
                                            <th class="col-md-1">Arquivo</th>
                                            <th class="col-md-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr_anexos1">
                                            <td>
                                                <div class="form-group{{ $errors->has('dt_documento') ? ' has-error' : '' }}">
                                                    <input id="dt_documento" name="dt_documento" type="date" class="form-control"/>
                                                    @if ($errors->has('dt_documento'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('dt_documento') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group{{ $errors->has('st_tipodocumento') ? ' has-error' : '' }}">
                                                    <select id="st_tipodocumento" type="text" name="st_tipodocumento" class="form-control">
                                                        <option value="" selected="selected" disabled>-Selecione-</option>
                                                        <option value="Atestado Médico">Atestado Médico</option>
                                                        <option value="Laudo Médico">Laudo Médico</option>
                                                        <option value="Exame">Exame</option>
                                                        <option value="Outros">Outros</option>
                                                    </select>
                                                    @if ($errors->has('st_tipodocumento'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_tipodocumento') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                                                    <input id="st_descricao" name="st_descricao" type="text" class="form-control"/>
                                                    @if ($errors->has('st_descricao'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_descricao') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fileUpload">
                                                    <input id="arquivo1" name="arquivo" type="file" class="form-control file"/>
                                                    {{-- fake arquivo para tirar o botão que ocupava um espaço desnecessário na tabela --}}
                                                    <div class="fakeFile">
                                                        <button id="btn-file" class="btn btn-default">Selecionar Arquivo</button>
                                                        <input class="form-control" id="fakeArquivo1" name="st_nomearquivo"/>
                                                    </div>
                                                    <p>Apenas imagem/PDF.</p>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="submit" id="anexar" class="docRequired btn btn-primary">
                                                    <i class="fa fa-fw fa-save"></i>Salvar Anexos
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </fieldset>
                @endif
                <br>
                <div class="row">
                            <div class="col-md-2">
                                @if ($bo_correcao)
                                        <a class="btn btn-warning" title="Voltar" href="{{url('juntamedica/sessoes/'.$idSessao.'/view')}}">
                                @else
                                    <a class="btn btn-warning" title="Voltar" href="{{url('juntamedica/atendimentosabertos')}}">
                                @endif
                                <i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
                            </div>
                            <div class="col-md-5 col-md-offset-5">
                                @if (isset($atendimento->st_parecer) && !empty($atendimento->st_parecer))
                                    <a href="{{url('/juntamedica/atendimentosAbertos/imprimirPdf/'.$atendimento->id)}}" title="Visualizar PDF" class="btn btn-primary" target="_blank" rel="noopener">
                                        <i class="glyphicon glyphicon-print"></i> Visualizar PDF
                                    </a>
                                    @if (($atendimento->st_parecer == 'APTO'))
                                        <a id="concluir" title="Concluir Atendimento" href="{{isset($idSessao) ? url('juntamedica/atendimento/'.$atendimento->ce_prontuario.'/'.$atendimento->id.'/concluir?idSessao='.$idSessao) : url('juntamedica/atendimento/'.$atendimento->ce_prontuario.'/'.$atendimento->id.'/concluir')}}" class="btn btn-success"><i class="fa fa-check"></i> Concluir Atendimento</a>
                                    @else
                                        @if (isset($atendimento->ce_cid) && !empty($atendimento->ce_cid))
                                            <a id="concluir" title="Concluir Atendimento" href="{{isset($idSessao) ? url('juntamedica/atendimento/'.$atendimento->ce_prontuario.'/'.$atendimento->id.'/concluir?idSessao='.$idSessao) : url('juntamedica/atendimento/'.$atendimento->ce_prontuario.'/'.$atendimento->id.'/concluir')}}" class="btn btn-success"><i class="fa fa-check"></i> Concluir Atendimento</a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        <br><br>
                    
                @if(isset($anexos) && $anexos!=[])
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Documentos anexados</legend>
                        <div class="form-group">
                            <table id="tb_anexos" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Data do Documento</th>
                                        <th class="col-md-3">Tipo de Documento</th>
                                        <th class="col-md-2">Arquivo</th>
                                        <th class="col-md-2">Descrição</th>
                                        <th class="col-md-2">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anexos as $anexo)
                                        <tr id="tr_anexos">
                                            <td>
                                                {{date('d/m/Y', strtotime($anexo->dt_arquivo))}} 
                                            </td>
                                            <td>
                                                {{$anexo->st_tipodocumento}}
                                            </td>
                                            <td>
                                                {{$anexo->st_nomearquivo}}
                                            </td>
                                            <td>
                                                {{$anexo->st_descricao}}
                                            </td>
                                            <td>
                                                <a id="verAnexo" target="_blank" title="Visualizar Documento" href="{{ route('verAnexo', ['idArquivo' => $anexo->id]) }}" class="verAnexo btn btn-primary"><i class="fa fa-eye"></i></a>
                                                <a type="submit" id="apagar" title="Excluir Documento" class="excluirDocumento btn btn-danger" href="{{ route('deletarAnexo', ['idAtendimento' => $atendimento->id, 'idArquivo' => $anexo->id]) }}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </fieldset>          
                @endif
            </div>
        </div>
    </div>
</div>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

<script src="{{asset('js/juntamedica.js') }}"></script>
<script src="{{asset('js/functions.js') }}"></script>

@stop
@section('js')
<script>

    $('.docRequired').click(function(event) {
        $('#dt_documento').attr("required", true);
        $('#st_tipodocumento').attr("required", true);
        $('#arquivo1').attr("required", true);
        $('#st_descricao').attr("required", true);

    });

    $('#salvarForm').click(function (){
        $('#dt_documento').attr("required", false);
        $('#st_tipodocumento').attr("required", false);
        $('#arquivo1').attr("required", false);
        $('#st_descricao').attr("required", false);
    });

    $('div.fileUpload').hover(
        function(){
        if($('#arquivo1').val()!==''){
            $('div.fakeFile>input').hide();
            $('div.fakeFile').prepend($( "<button class='btn btn-default'>Alterar Arquivo</button>"));
        }
        }, function(){
        if($('#arquivo1').val()!==''){
            $(this).find("button").last().remove();
            $(this).find("button").last().remove();
            $('div.fakeFile>input').show();
        }
    });

    $('.file').change(function(){
        $('#btn-file').hide();
        $('#fakeArquivo1').show();
        //nomeArquivo recebe o último valor depois da barra que seria o nome do arquivo
        var nomeArquivo = $(this).val().split('\\')[$(this).val().split('\\').length -1];
        //pega o nome do id do elemento qual o arquivo foi alterado e tira o nome arquivo para pegar apenas o número para alterar o fake arquivo
        $('#fakeArquivo'+$(this).attr('id').split('arquivo')[1]).val(nomeArquivo);
    });


    $(function(){
        
        $('#ce_cid').select2({
            minimumInputLength: 3
        });
        
        let parecer = {!!json_encode($atendimento->st_parecer)!!}
        $('#st_parecer').val(parecer);

        let causaefeito = {!!json_encode($atendimento->st_causaefeito)!!}
        $('#st_causaefeito').val(causaefeito);

        RemoverCampos();
    });
    function SomenteNumero(e) {
        var tecla = (window.event) ? event.keyCode : e.which;
        if ((tecla > 47 && tecla < 58)) return true;
        else {
            if (tecla == 8 || tecla == 0) return true;
            else return false;
        }
    }
    function RemoverCampos() {
        var parecer = document.getElementById("st_parecer").value;
        if (parecer == "APTO") {
            $('#div_st_causaefeito').hide();
            $('#div_st_restricao').hide();
            $('#div_ce_cid').hide();
            $('#div_dt_inicio').hide();
            $('#div_nu_dias').hide();
            $('#div_dt_termino').hide();
        } else if (parecer == "APTO COM RESTRIÇÃO") {
            $('#div_st_causaefeito').show();
            $('#div_st_restricao').show();
            $('#div_ce_cid').show();
            $('#div_dt_inicio').show();
            $('#div_nu_dias').show();
            $('#div_dt_termino').show();
        } else if (parecer == "APTO COM RESTRIÇÃO (EM DEFINITIVO)") {
            $('#div_st_causaefeito').show();
            $('#div_st_restricao').show();
            $('#div_ce_cid').show();
            $('#div_dt_inicio').show();
            $('#div_nu_dias').hide();
            $('#div_dt_termino').hide();
        } else if (parecer == "LTS") {
            $('#div_st_causaefeito').show();
            $('#div_st_restricao').show();
            $('#div_ce_cid').show();
            $('#div_dt_inicio').show();
            $('#div_nu_dias').show();
            $('#div_dt_termino').show();
        }
    }
    $('#nu_dias').change(function() {
        if($('#nu_dias').val()===''){
            $('#nu_dias').val('0');
            datafim();
        }
    })
    function datafim(){
        var dias = $('#nu_dias').val();
        var dt_ini = $('#dt_inicio').val();
        if(dias && dt_ini){
            $('#dt_termino').val(calcData(parseInt(dias)+1, dt_ini));
        }
    }
</script>
@endsection
@section('css')
    <style>
        div.fileUpload{
            position: relative;
        }
        .ff{
            width: 150px;
        }
        .file {
            position: relative;
            width: 150px;
            text-align: right;
            -moz-opacity: 0;
            /* filter: alpha(opacity: 0); */
            opacity: 0;
            z-index: 2;
        }
        div.fakeFile{
            position: absolute;
            top: 0px;
            width: auto;
            z-index: 1;
        }
        div.fakeFile>button{
            border-width: 1px;
            border-color: black;
            background-color: #3c8dbc;
            color: white;
        }
        div.fakeFile>input{
            display: none;
        }
        th, td{
            text-align: center;
            vertical-align: center;
            }
        .mb-10{
            margin-bottom: 10px;
        }
    </style>
@endsection