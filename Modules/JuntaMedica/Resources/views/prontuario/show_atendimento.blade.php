@extends('adminlte::page')
<?php
use App\utis\Funcoes;
?>
@section('title', 'Visualizar Atendimento')

@section('content')
<div class="row">


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">VISUALIZAÇÃO DO ATENDIMENTO
            </div>
            <div class="panel-body">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Informações do Paciente</legend>
                    <div class="col-md-12">
                        <label class="col-md-3 text-right">Matrícula</label>
                        @if(isset($atendimento->st_matricula))
                            {{$atendimento->st_matricula}}
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <label class="col-md-3 text-right">Post/Grad</label>
                        @if(isset($atendimento->st_postograduacao))
                            {{$atendimento->st_postograduacao}}
                        @endif
                    </div>
                    <div class="col-md-12">
                        <label class="col-md-3 text-right">Paciente</label>
                        @if(isset($atendimento->st_nome))
                            {{$atendimento->st_nome}}
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <label class="col-md-3 text-right">CPF</label>
                        @if(isset($atendimento->st_cpf))
                            {{$atendimento->st_cpf}}
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <label class="col-md-3 text-right">Data do Nascimento</label>
                        @if(isset($atendimento->dt_nascimento))
                        @php $data = date_create($atendimento->dt_nascimento); @endphp
                            {{date_format($data, 'd/m/Y')}}
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <label class="col-md-3 text-right">CIA</label>
                        @if(isset($atendimento->st_unidade))
                            {{$atendimento->st_unidade}}
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <label class="col-md-3 text-right">Orgão</label>
                        @if(isset($atendimento->st_orgao))
                            {{$atendimento->st_orgao}}
                        @endif
                    </div>
                </fieldset>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Informações do Atendimento</legend>
                    <div class="col-md-12">
                        <label for="ce_sessao" class="col-md-3 text-right">Sessão</label>
                        @if(isset($atendimento->st_tiposessao))
                            {{$atendimento->st_tiposessao.' - '.$atendimento->nu_sequencialsessao.'/'.$atendimento->nu_anosessao}}
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                    <label for="dt_parecer" class="col-md-3 text-right">Data do Parecer</label>
                        @if(isset($atendimento->dt_parecer))
                            @php $data = date_create($atendimento->dt_parecer); @endphp
                            {{date_format($data, 'd/m/Y')}}
                        @endif
                    </div>

                    <div class="col-md-12">
                    <label for="st_parecer" class="col-md-3 text-right">Parecer</label>
                        @if(isset($atendimento->st_parecer))
                            {{$atendimento->st_parecer}}
                        @endif           
                    </div>
                    
                    <div class="col-md-12">
                        <label class="col-md-3 text-right">Causa/efeito</label>
                        @if(isset($atendimento->st_causaefeito))
                            {{$atendimento->st_causaefeito}}
                        @endif
                    </div>
                
                    <div class="col-md-12">
                    <label for="st_restricao" class="col-md-3 text-right">Restrições</label>
                        @if(isset($atendimento->restricoes) && count($atendimento->restricoes) > 0 )
                            @php $total = count($atendimento->restricoes);
                                $contador = 0;
                            @endphp
                            @foreach ($atendimento->restricoes as $restricao)
                                @php ++$contador @endphp
                                @if ($contador < $total)
                                    {{$restricao->st_restricao}},
                                @else
                                    {{$restricao->st_restricao}}.
                                @endif
                            @endforeach
                        @else
                            Sem restrições
                        @endif
                    </div>
                
                    <div class="col-md-12">
                    <label for="ce_cid" class="col-md-3 text-right">CID</label>
                        @if(isset($atendimento->st_cid))
                            {{$atendimento->st_cid}}
                        @endif                                              
                    </div>

                    <div class="col-md-12">
                    <label for="dt_inicio" class="col-md-3 text-right">Início</label>
                        @if(isset($atendimento->dt_inicio))
                            @php $data = date_create($atendimento->dt_inicio); @endphp
                            {{date_format($data, 'd/m/Y')}}
                        @endif  
                    </div>

                    <div class="col-md-12">
                    <label for="nu_dias" class="col-md-3 text-right">Duração</label>
                        @if(isset($atendimento->nu_dias))
                            {{$atendimento->nu_dias}}
                        @endif 
                    </div>

                    <div class="col-md-12">
                    <label for="dt_termino" class="col-md-3 text-right">Término</label>
                        @if(isset($atendimento->dt_termino))
                            @php $data = date_create($atendimento->dt_termino); @endphp
                            {{date_format($data, 'd/m/Y')}}
                        @endif
                    </div>

                    <div class="col-md-12">
                    <label for="ce_perito" class="col-md-3 text-right">Médico</label>
                        @if(isset($atendimento->st_perito))
                            {{$atendimento->st_perito}}
                        @endif                                          
                    </div>

                    <div class="col-md-12">
                    <label for="st_obs" class="col-md-3 text-right">Observações</label>
                        @if(isset($atendimento->st_obs))
                            {{$atendimento->st_obs}}
                        @endif
                    </div>
                </fieldset>

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
                                        <th class="col-md-3">Descrição</th>
                                        <th class="col-md-1">...</th>
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
                                                <a id="verAnexo" target="_blank" href="{{ route('verAnexo', ['idArquivo' => $anexo->id]) }}" class="verAnexo btn btn-primary"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </fieldset>          
                @endif

                <div class="col-md-3 col-md-offset-2">
                    <br/>
                    <a class="btn btn-warning" title="Voltar" href="javascript:history.back();">
                    <i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
                </div>                       
            </div>
        </div>
    </div>
</div>   
@stop
@section('css')
<style>
    th, td {
        text-align: center;
        vertical-align: center;
    }
</style>
@endsection