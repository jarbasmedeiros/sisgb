@extends('promocao::abas')
@section('title', 'Escriturar Ficha')
@php
    use app\utis\Funcoes;
@endphp
@section('tabcontent')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div class="col-md-10">
                    <h4>Recursos não avaliados da ficha de reconhecimento</h4>
                </div>
                <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: '.$nota->st_status : ''}}</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    <div class="form-row form-inline">
                        <form method="post" action="{{url('promocao/listaanalisarrecurso/buscasgt/'.$quadro->id.'/'.$atividade->id.'/0' . '/competencia/'.$competencia)}}">
                            {{csrf_field()}}
                            <div class="form-group col-xs-12 col-md-12 col-sm-12" style="margin-left:auto; padding-top:10px;">
                                <label style="padding: 2%;">
                                    <strong>Localizar Policial</strong>
                                </label>
                                <select class="form-control" name="criterio" required>
                                    <option value="st_matricula" selected>Matrícula</option>
                                    <option value="st_cpf">CPF</option>
                                    <option value="st_policial">Nome</option>
                                </select>
                                <input type="text" class="form-control" id="st_filtro" name="st_filtro" placeholder="Matrícula ou CPF" required>
                                @if(isset($nota))
                                    <input type="hidden" class="form-control" id="idNota" value="{{$nota->id}}">
                                @endif
                                <button type="submit" class="btn btn-primary glyphicon glyphicon-search" title="Localizar Polcial" style="margin-bottom:7px;"></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table striped" id="policiais">
                        <thead>
                            <tr>
                                <th>Ordem</th>
                                <th>Post/Grad</th>
                                <th>Praça</th>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($policiaisQuadro) && count($policiaisQuadro) > 0)  
                                @php
                                    $ordem = 0;
                                @endphp
                                @foreach($policiaisQuadro as $policial)
                                    @php
                                        $ordem++
                                    @endphp
                                    <tr>
                                        <th>{{$ordem}}</th>
                                        <th>{{$policial->st_postgrad}}</th>
                                        <th>{{$policial->st_numpraca}}</th>
                                        <th>{{$policial->st_matricula}}</th>
                                        <th>{{$policial->st_policial}}</th>
                                        <th>
                                            @if($policial->bo_recursoanalisado != 1 && $policial->bo_recorreu == 1)
                                                <a href="{{url('promocao/analisarrecurso/'.$quadro->id.'/atividade/'.$atividade->id.'/policial/'.$policial->ce_policial. '/competencia/'.$competencia)}}" class="btn bg-red" title="Avaliar Recurso">
                                                    <span class="fa fa-fw fa-balance-scale"></span> Recurso
                                                </a>
                                            @endif
                                            <a href="{{url('promocao/escrituradaFicha/recurso/'.$quadro->id.'/atividade/'.$atividade->id.'/policial/'.$policial->ce_policial. '/competencia/'.$competencia.'/pdf')}}" class="btn bg-red" title="Visualizar PDF do Recurso">
                                                <span class="fa fa-print"></span>
                                            </a>
                                            <a href="{{url('promocao/escriturarfichadereconhecimento/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial. '/competencia/'.$competencia.'/pdf')}}" class="btn btn-primary" title="Visualizar PDF da Ficha">
                                                <span class="fa fa-print"></span>
                                            </a>
                                        </th>
                                    </tr>   
                                @endforeach
                            @else
                                <tr>
                                    <th colspan="8">Nenhum policial encontrado</th>
                                </tr>    
                            @endif
                        </tbody>
                    </table>
                    @if(isset($policiaisQuadro) && (count($policiaisQuadro) > 0) )
                        {{$policiaisQuadro->links()}}
                    @endif
                </div>
            </div>
        </div>
        <div class="form-row">
            <a href="{{url('promocao/quadro/cronograma/'.$quadro->id . '/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>
        </div>
    </div>
</div>
@stop