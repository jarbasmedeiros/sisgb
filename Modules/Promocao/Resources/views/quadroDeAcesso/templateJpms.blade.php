@extends('adminlte::page')
@section('title', 'Edição de Servidor')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Convocação para Junta Médica</div>
                <div class="panel-body">
                    @if(isset($soldadosConvocados))
                        <form role="form" method="POST" action="{{url('/promocao/convocarparajpms/storeSoldado/' . $idQuadro . '/' . $idAtividade. '/competencia/'.$competencia)}}">
                    @elseif(isset($cabosConvocados))
                        <form role="form" method="POST" action="{{url('/promocao/convocarparajpms/storeCabo/' . $idQuadro . '/' . $idAtividade. '/competencia/'.$competencia)}}">
                    @elseif(isset($sargentosConvocados))
                        <form role="form" method="POST" action="{{url('/promocao/convocarparajpms/storeSargento/' . $idQuadro . '/' . $idAtividade. '/competencia/'.$competencia)}}">
                    @endif
                        {{csrf_field()}}
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="nav-item {{ (isset($soldadosConvocados)) ? 'active' : '' }}">
                                    <a class="nav-link" href="{{url('promocao/convocarparajpms/soldado/'.$idQuadro.'/'.$idAtividade. '/competencia/'.$competencia)}}">
                                        <b>SOLDADO</b>
                                    </a>
                                </li>
                                <li class="nav-item {{ (isset($cabosConvocados)) ? 'active' : '' }} ">
                                    <a class="nav-link" href="{{url('promocao/convocarparajpms/cabo/'.$idQuadro.'/'.$idAtividade. '/competencia/'.$competencia)}}">
                                        <b>CABO</b>
                                    </a>
                                </li>
                                <li class="nav-item {{ (isset($sargentosConvocados)) ? 'active' : '' }}">
                                    <a class="nav-link" href="{{url('promocao/convocarparajpms/sargento/'.$idQuadro.'/'.$idAtividade. '/competencia/'.$competencia)}}">
                                        <b>SARGENTO</b>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                @yield('tabcontent')
                            </div>
                            <div class="form-row text-center">
                                <a href="{{ url('promocao/quadro/cronograma/' . $idQuadro. '/competencia/'.$competencia) }}" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>
                                @if($atividade->dt_atividade == null && $atividade->ce_nota == null)
                                    <button type="submit" class=" btn btn-primary">
                                        <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                                    </button>
                                @endif
                                @if($atividade->st_portaria != null && $atividade->st_portaria2 != null && $atividade->st_portaria3 != null && $atividade->ce_nota == null)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gerarNotaModal">Gerar Nota para BG</button>
                                @endif
                                @if($atividade->ce_nota != null)
                                    <a href='{{ url("boletim/nota/visualizar/" . $atividade->ce_nota)}}' class="btn btn-primary">
                                        <span class="fa fa-file-pdf-o"></span> Visualizar Nota
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Moldal para botão gerar nota -->
<div class="modal fade" id="gerarNotaModal" tabindex="-1" role="dialog" aria-labelledby="gerarNotaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="gerarNotaModalLabel">Gerar Nota</h5>
            </div>
            <div class="modal-body bg-danger">
                <div>
                    <strong> DESEJA REALMENTE GERAR A NOTA? </strong>
                    <p> Após gerar a nota, a convocação não poderá mais ser editada. </p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#assinarModal">Sim</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Moldal Assinar Nota -->
<div class="modal fade" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-sm">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="assinarModalLabel">Assinar Nota</h5>
            </div>

            <div class="modal-body">
            <form action="{{ url('promocao/convocarparajpms/gerarNota/' . $idQuadro . '/' . $idAtividade. '/competencia/'.$competencia) }}" method="POST">
                {{csrf_field()}}
                <p><strong> Digite sua senha para assinar eletronicamente </strong></p><br/>
                <div class="form-group">
                    <label for="pass" class="control-label">Senha:</label>
                    <div class="">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Assinar</button>
                </div>
            </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
<style>
    th{text-align:center;}
    a, button{margin:5px;}
</style>
@endsection
@section('js')
    <!-- Javascript para o modulo promocao -->
    <script src="{{ asset('js/promocao.js') }}"></script>
   
@stop