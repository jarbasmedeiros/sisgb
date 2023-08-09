@extends('adminlte::page')
@section('title', 'Pendências CPP')
@section('content')
<div class="container-fluid">
    <div class="row">


        <div class="panel panel-primary container-fluid">
            
            <div class="panel-heading row">
                <div>
                    <label>Pesquisar Policial no QA</label>
                </div>
            </div>

                <div class="panel-body">
                    <div class="col-12" id="alertSucesso"></div>

                        <div class="form-row form-inline">

                        <form method="post" action="{{url('promocao/pendencias/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)}}">
                            {{csrf_field()}}
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Consultar</legend>
                        <br />
                            <div class="form-row">
                                <div class="form-group col-xs-12 col-md-12 col-sm-12" style="margin-left:auto; padding-top:10px;">
                                    <label style="padding: 2%;">
                                        <strong>Localizar Policial</strong>
                                    </label>
                                        <input type="text" class="form-control" id="st_policial" name="st_parametro" placeholder="Matrícula ou CPF" required>

                                        <button type="submit" class="btn btn-primary glyphicon glyphicon-search" title="Localizar Polcial" style="margin-bottom:7px;"></button>

                                </div>
                            </div>
                            </fieldset>
                        </form>
                        </div>

                </div>
                    
        </div>

        @if(isset($policialQuadro))

        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div>
                    <label>Informações do Policial no Quadro de Acesso</label>
                </div>
            </div>
            <div class="panel-body">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Dados do Policial</legend>
                        <br />
                        <div class="form-row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-2">Graduação</th>
                                        <th class="col-xs-2">QPMP</th>
                                        <th class="col-xs-2">Matrícula</th>
                                        <th class="col-xs-2">Nº Praça </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th><span class="form-control">{{$policialQuadro->st_postgrad}}</span></th>
                                    <th><span class="form-control">{{$policialQuadro->ce_qpmp}}</span></th>
                                    <th><span class="form-control">{{$policialQuadro->st_matricula}}</span></th>
                                    <th><span class="form-control">{{$policialQuadro->st_numpraca}}</span></th>
                                </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-6">Nome</th>
                                        <th class="col-xs-4">OPM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><span class="form-control">{{$policialQuadro->st_policial}}</span></th>
                                        <th><span class="form-control">{{$policialQuadro->ce_unidade}}</span></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>



                <form id="form" class="form-contact" role="form" method="POST" action="{{url('promocao/pendencias/'.$idQuadro.'/'.$idAtividade.'/'.$policialQuadro->ce_policial.'/competencia/'.$competencia)}}">
                    {{csrf_field()}}


                                        <!-- FICHA -->

                    										<!-- CONSTA NO QA -->
                                                            <fieldset class="scheduler-border">
                        <legend class="scheduler-border">CONSTA NO QA</legend>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Consta no QA</th>
                                                <th class="col-xs-10">Motivo Saída</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    <select name="bo_constanoqa" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_constanoqa == '1')
                                                        <option value="{{$policialQuadro->bo_constanoqa}}" selected>SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @elseif($policialQuadro->bo_constanoqa == '0')
                                                        <option value="{{old('bo_constanoqa', $policialQuadro->bo_constanoqa)}}" selected>NÃO</option>
                                                        <option value="1" >SIM</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="1" >SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @endif
                                                    </select>
                                                </th>
                                                 <th class="col-xs-8">
                                                <textarea name="st_motivosaidadoqa" class="form-control camposObrigatorios" maxlength="500" rows="3">{{old('st_motivosaidadoqa', $policialQuadro->st_motivosaidadoqa)}}</textarea>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>

                                    
                    </fieldset>
                    <!-- CONSTA NO QA -->

                    					<!-- FICHA -->
                                        <fieldset class="scheduler-border">
                        <legend class="scheduler-border">FICHA</legend>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Enviada</th>
                                                <th>Homologada</th>
                                                <th class="col-xs-8">Pendência</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    <select name="bo_fichaenviada" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_fichaenviada == '1')
                                                        <option value="{{$policialQuadro->bo_fichaenviada}}" selected>SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @elseif($policialQuadro->bo_fichaenviada == '0')
                                                        <option value="{{$policialQuadro->bo_fichaenviada}}" selected>NÃO</option>
                                                        <option value="1" >SIM</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="1" >SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @endif
                                                    </select>
                                                </th>
                                                <th class="form-inline">
                                                    <select name="bo_fichahomologada" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_fichahomologada == '1')
                                                        <option value="{{$policialQuadro->bo_fichahomologada}}" selected>SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @elseif($policialQuadro->bo_fichahomologada == '0')
                                                        <option value="{{$policialQuadro->bo_fichahomologada}}" selected>NÃO</option>
                                                        <option value="1" >SIM</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="1" >SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @endif
                                                    </select>
                                                </th>
                                                <th class="col-xs-8">
                                                <textarea name="st_pendenciaficha" class="form-control camposObrigatorios" rows="3">{{$policialQuadro->st_pendenciaficha}}</textarea>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>

                                    
                    </fieldset>


                    <!-- JPMS -->
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">JPMS</legend>
                        


                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Inspecionado</th>
                                                <th>Tipo de Convocação</th>
                                                <th>Data Inspeção</th>
                                                <th>Parecer</th>
                                                <th>Validade</th>
                                                <th class="col-xs-5">Obs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <th class="form-inline">
                                                    <select name="bo_inspecionadojunta" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_inspecionadojunta == '1')
                                                        <option value="{{$policialQuadro->bo_inspecionadojunta}}" selected>SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @elseif($policialQuadro->bo_inspecionadojunta == '0')
                                                        <option value="{{$policialQuadro->bo_inspecionadojunta}}" selected>NÃO</option>
                                                        <option value="1" >SIM</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="1" >SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @endif
                                                     </select>
                                                </th>
                                                <th class="form-inline">
                                                    <select name="st_tipoconvocacaojpms" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->st_tipoconvocacaojpms == 'REGULAR')
                                                        <option value="{{$policialQuadro->st_tipoconvocacaojpms}}" selected>{{$policialQuadro->st_tipoconvocacaojpms}}</option>
                                                        <option value="EXTRA" >EXTRA</option>
                                                        @elseif($policialQuadro->st_tipoconvocacaojpms == 'Extraordinária')
                                                        <option value="{{$policialQuadro->st_tipoconvocacaojpms}}" selected>{{$policialQuadro->st_tipoconvocacaojpms}}</option>
                                                        <option value="REGULAR" >REGULAR</option>
                                                        @else<option value="" selected>Selecione...</option>
                                                        <option value="REGULAR" >REGULAR</option>
                                                        <option value="EXTRA" >EXTRA</option>
                                                        @endif

                                                     </select>
                                                </th>
                                                <th>
                                                    <input name="dt_inspecaosaude" class="form-control camposObrigatorios " type="date" value="{{$policialQuadro->dt_inspecaosaude}}" >
                                                </th>
                                                <th class="form-inline">
                                                    <select name="st_inspecaojuntaparecer" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->st_inspecaojuntaparecer == 'APTO')
                                                        <option value="{{$policialQuadro->st_inspecaojuntaparecer}}" selected>{{$policialQuadro->st_inspecaojuntaparecer}}</option>
                                                        <option value="APTO COM RESTRIÇÃO" >APTO COM RESTRIÇÃO</option>
                                                        <option value="INAPTO" >INAPTO</option>
                                                        <option value="FALTOU" >FALTOU</option>
                                                        @elseif($policialQuadro->st_inspecaojuntaparecer == 'APTO COM RESTRIÇÃO')
                                                        <option value="{{$policialQuadro->st_inspecaojuntaparecer}}" selected>{{$policialQuadro->st_inspecaojuntaparecer}}</option>
                                                        <option value="APTO" >APTO</option>
                                                        <option value="INAPTO" >INAPTO</option>
                                                        <option value="FALTOU" >FALTOU</option>
                                                        @elseif($policialQuadro->st_inspecaojuntaparecer == 'INAPTO')
                                                        <option value="{{$policialQuadro->st_inspecaojuntaparecer}}" selected>{{$policialQuadro->st_inspecaojuntaparecer}}</option>
                                                        <option value="APTO" >APTO</option>
                                                        <option value="APTO COM RESTRIÇÃO" >APTO COM RESTRIÇÃO</option>
                                                        <option value="FALTOU" >FALTOU</option>
                                                        @elseif($policialQuadro->st_inspecaojuntaparecer == 'FALTOU')
                                                        <option value="{{$policialQuadro->st_inspecaojuntaparecer}}" selected>{{$policialQuadro->st_inspecaojuntaparecer}}</option>
                                                        <option value="APTO" >APTO</option>
                                                        <option value="APTO COM RESTRIÇÃO" >APTO COM RESTRIÇÃO</option>
                                                        <option value="INAPTO" >INAPTO</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="APTO" >APTO</option>
                                                        <option value="APTO COM RESTRIÇÃO" >APTO COM RESTRIÇÃO</option>
                                                        <option value="INAPTO" >INAPTO</option>
                                                        <option value="FALTOU" >FALTOU</option>
                                                        @endif
                                                    </select>
                                                </th>
                                                <th>
                                                    <input name="dt_validadeinspecaosaude" class="form-control camposObrigatorios " type="date" value="{{$policialQuadro->dt_validadeinspecaosaude}}" >
                                                </th>
                                                <th class="col-xs-5">
                                                <textarea name="st_inspecaojuntaobs" class="form-control camposObrigatorios" maxlength="300" rows="3">{{$policialQuadro->st_inspecaojuntaobs}}</textarea>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>

                                    
                    </fieldset>
                    <!-- JPMS -->

                    <!-- TAF -->
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">TAF</legend>
                        


                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Inspecionado</th>
                                                <th>Data Inspeção</th>
                                                <th>Parecer</th>
                                                <th>Validade</th>
                                                <th class="col-xs-6">Obs</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    <select name="bo_inspecionadotaf" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_inspecionadotaf == '1')
                                                        <option value="{{$policialQuadro->bo_inspecionadotaf}}" selected>SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @elseif($policialQuadro->bo_inspecionadotaf == '0')
                                                        <option value="{{$policialQuadro->bo_inspecionadotaf}}" selected>NÃO</option>
                                                        <option value="1" >SIM</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="1" >SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @endif

                         
                                                    </select>
                                                </th>
                                                <th>
                                                    <input name="dt_taf" class="form-control camposObrigatorios " type="date" value="{{$policialQuadro->dt_taf}}" >
                                                </th>
                                                <th class="form-inline">
                                                    <select name="st_inspecaotafparecer" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->st_inspecaotafparecer == 'APTO')
                                                        <option value="{{$policialQuadro->st_inspecaotafparecer}}" selected>{{$policialQuadro->st_inspecaotafparecer}}</option>
                                                        <option value="INAPTO" >INAPTO</option>
                                                        <option value="FALTOU" >FALTOU</option>
                                                        @elseif($policialQuadro->st_inspecaotafparecer == 'INAPTO')
                                                        <option value="{{$policialQuadro->st_inspecaotafparecer}}" selected>{{$policialQuadro->st_inspecaotafparecer}}</option>
                                                        <option value="APTO" >APTO</option>
                                                        <option value="FALTOU" >FALTOU</option>
                                                        @elseif($policialQuadro->st_inspecaotafparecer == 'FALTOU')
                                                        <option value="{{$policialQuadro->st_inspecaotafparecer}}" selected>{{$policialQuadro->st_inspecaotafparecer}}</option>
                                                        <option value="APTO" >APTO</option>
                                                        <option value="INAPTO" >INAPTO</option>
                                                        @else
                                                        <option value="{{$policialQuadro->st_inspecaotafparecer}}" selected>{{$policialQuadro->st_inspecaotafparecer}}</option>
                                                        <option value="APTO" >APTO</option>
                                                        <option value="INAPTO" >INAPTO</option>
                                                        <option value="Faltou" >FALTOU</option>
                                                        @endif

                                                    </select>
                                                </th>
                                                <th>
                                                    <input name="dt_validadeinspecaotaf" class="form-control camposObrigatorios " type="date" value="{{$policialQuadro->dt_validadeinspecaotaf}}" >
                                                </th>
                                                <th class="col-xs-6">
                                                <textarea name="st_inspecaotafobs" class="form-control camposObrigatorios" maxlength="300" rows="3">{{$policialQuadro->st_inspecaotafobs}}</textarea>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>

                    </fieldset>
                    <!-- TAF -->

										<!-- RECURSO -->
                                        <fieldset class="scheduler-border">
                        <legend class="scheduler-border">RECURSO</legend>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Recorreu</th>
                                                <th class="col-xs-2">Protocolo Recurso</th>
												<th class="col-xs-2">Recurso</th>
                                                <th>Recurso Analisado</th>
                                                <th>Parecer Recurso</th>
												<th class="col-xs-2">Resposta Recurso</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    <select name="bo_recorreu" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_recorreu == '1')
                                                        <option value="{{$policialQuadro->bo_recorreu}}" selected>SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @elseif($policialQuadro->bo_recorreu == '0')
                                                        <option value="{{$policialQuadro->bo_recorreu}}" selected>NÃO</option>
                                                        <option value="1" >SIM</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="1" >SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @endif
                                                    </select>
                                                </th>
                                                <th class="col-xs-2">
                                                <textarea name="st_protocolorecurso" class="form-control camposObrigatorios" maxlength="50" rows="3">{{$policialQuadro->st_protocolorecurso}}</textarea>
                                                </th>
                                                </th>
                                                 <th class="col-xs-2">
                                                <textarea name="st_recurso" class="form-control camposObrigatorios" maxlength="500" rows="3">{{$policialQuadro->st_recurso}}</textarea>
                                                </th>

													<th class="form-inline">
                                                    <select name="bo_recursoanalisado" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_recursoanalisado == '1')
                                                        <option value="{{$policialQuadro->bo_recursoanalisado}}" selected>SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @elseif($policialQuadro->bo_recursoanalisado == '0')
                                                        <option value="{{$policialQuadro->bo_recursoanalisado}}" selected>NÃO</option>
                                                        <option value="1" >SIM</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="1" >SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @endif
                                                    </select>
                                                </th>
                                                <th class="form-inline">
                                                    <select name="st_parecerrecurso" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_recursoanalisado == 'DEFERIDO')
                                                        <option value="{{$policialQuadro->st_parecerrecurso}}" selected>{{$policialQuadro->bo_recursoanalisado}}</option>
                                                        <<option value="INDEFERIDO" >INDEFERIDO</option>
                                                        <option value="AGUARDANDO" >AGUARDANDO</option>
                                                        @elseif($policialQuadro->bo_recursoanalisado == 'INDEFERIDO')
                                                        <option value="{{$policialQuadro->st_parecerrecurso}}" selected>{{$policialQuadro->bo_recursoanalisado}}</option>
                                                        <option value="DEFERIDO" >DEFERIDO</option>
                                                        <option value="AGUARDANDO" >AGUARDANDO</option>
                                                        @elseif($policialQuadro->bo_recursoanalisado == 'AGUARDANDO')
                                                        <option value="{{$policialQuadro->st_parecerrecurso}}" selected>{{$policialQuadro->bo_recursoanalisado}}</option>
                                                        <option value="DEFERIDO" >DEFERIDO</option>
                                                        <option value="INDEFERIDO" >INDEFERIDO</option>
                                                        @else
                                                        <option value="" selected>Selecione...'</option>
                                                        <option value="DEFERIDO" >DEFERIDO</option>
                                                        <option value="INDEFERIDO" >INDEFERIDO</option>
                                                        <option value="AGUARDANDO" >AGUARDANDO</option>
                                                        @endif
                                                    </select>
                                                </th>
												<th class="col-xs-2">
                                                <textarea name="st_respostarecurso" class="form-control camposObrigatorios" maxlength="500" rows="3">{{$policialQuadro->st_respostarecurso}}</textarea>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>

                                    
                    </fieldset>
                    <!-- RECURSO -->


										<!-- DOCUMENTAÇÃO -->
                                        <fieldset class="scheduler-border">
                        <legend class="scheduler-border">DOCUMENTAÇÃO</legend>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Pendente</th>
                                                <th class="col-xs-10">Documento</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    <select name="bo_documentos" class="form-control select2-container camposObrigatorios" >
                                                        @if($policialQuadro->bo_documentos == '1')
                                                        <option value="{{$policialQuadro->bo_documentos}}" selected>SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @elseif($policialQuadro->bo_documentos == '0')
                                                        <option value="{{$policialQuadro->bo_documentos}}" selected>NÃO</option>
                                                        <option value="1" >SIM</option>
                                                        @else
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="1" >SIM</option>
                                                        <option value="0" >NÃO</option>
                                                        @endif
                                                    </select>
                                                 <th class="col-xs-10">
                                                <textarea name="st_documentospendentes" class="form-control camposObrigatorios" maxlength="200" rows="3">{{$policialQuadro->st_documentospendentes}}</textarea>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>

                                    
                    </fieldset>
                    <!-- DOCUMENTAÇÃO -->

										<!-- OBSERVAÇÃO CPP -->
                                        <fieldset class="scheduler-border">
                        <legend class="scheduler-border">OBSERVAÇÃO INTERNA CPP</legend>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
												<th>Observação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
												<th class="col-xs-2">
                                                <textarea name="st_obsinternacpp" class="form-control camposObrigatorios " rows="3">{{$policialQuadro->st_obsinternacpp}}</textarea>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>

                                    
                    </fieldset>
                    <!-- OBSERVAÇÃO CPP -->

@else
@endif
                    <a href="{{url('promocao/quadro/cronograma/'.$idQuadro.'/competencia/'.$competencia)}}" title="Voltar" class="btn btn-warning">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>
@if(isset($policialQuadro))
                    <button type="submit" title="Salvar" class="btn btn-primary">
                        <i class="fa fa-fw fa-save"></i> Salvar
                    </button>
                </form>
@else
@endif
            </div>
        </div>
    </div>
</div>


@stop
@section('css')
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }
    div {
        overflow-x:auto;
    }
    fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
    }
    .intensAlteracao
    {
        border: solid 1px red;
    }
</style>
@stop
