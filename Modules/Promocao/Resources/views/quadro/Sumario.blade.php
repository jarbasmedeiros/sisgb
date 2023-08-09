@extends('adminlte::page')

@section('title', 'Sumário')
@section('content_header')
    <h1 class="btn btn-primary">Sumário - Total de Servidores: {{$servidores}}</h1>
@stop
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-2">Orgão</th>
                                <th class="col-md-2">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($orgaos))
                                @forelse($orgaos as $o)
                                    <tr>
                                        <th>{{$o->st_sigla}}</th>
                                        <th><a href="{{url('rh/servidores/sumario/orgaos/'.$o->id)}}">{{$o->qtde}}</a></th>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Nenhum servidor cadastrado</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="box">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-2">Cargos</th>
                                <th class="col-md-2">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($cargos))
                                @forelse($cargos as $c)
                                    <tr>
                                        <th>{{$c->st_cargo}}</th>
                                        <th><a href="{{url('rh/servidores/sumario/cargos/'.$c->id)}}">{{$c->qtde}}</a></th>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Nenhum servidor cadastrado</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-2">Função</th>
                                <th class="col-md-2">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($funcoes))
                                @forelse($funcoes as $f)
                                    <tr>
                                        <th>{{$f->st_funcao}}</th>
                                        <th><a href="{{url('rh/servidores/sumario/funcoes/'.$f->id)}}">{{$f->qtde}}</a></th>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Nenhum servidor cadastrado</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-2">Posto/Graduação</th>
                                <th class="col-md-2">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($graduacoes))
                                @forelse($graduacoes as $g)
                                    <tr>
                                        <th>{{$g->st_postograduacao}}</th>
                                        <th><a href="{{url('rh/servidores/sumario/graduacao/'.$g->id)}}">{{$g->qtde}}</a></th>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Nenhum servidor cadastrado</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="box">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-2">Status</th>
                                <th class="col-md-2">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($status))
                                @forelse($status as $s)
                                    <tr>
                                        <th>{{$s->st_status}}</th>
                                        <th><a href="{{url('rh/servidores/sumario/status/'.$s->id)}}">{{$s->qtde}}</a></th>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Nenhum servidor cadastrado</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop