@extends('adminlte::page')
@section('title', 'Pesquisar prontuário')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">PESQUISA DE PRONTUÁRIO MÉDICO</div>
            <div class="panel-body">
                <div class="col-md-8 col-md-offset-2">
                    <form class="form-contact" role="form" method="POST" action="{{url('/juntamedica/prontuario')}}">
                        {{csrf_field()}}                
                        
                        <div class="form-group{{ $errors->has('criterio') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input name="criterio" id="criterio" type="text" class="form-control" required="true" placeholder="Digite aqui o CPF, Matrícula ou Nome" value="{{ old('criterio') }}"> 
                                @if ($errors->has('criterio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('criterio') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group">
                            <button type="submit" class="col-md-2 btn btn-primary">
                                <i class="glyphicon glyphicon-search"> </i> Pesquisar
                            </button>
                        </div>
                    </form>
                    <br/><br/><br/>
                </div>    

                <!--inicio do bloco que só exibe quando o existir um pm selecionado-->
                            
                @if(isset($prontuarios))
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="6">Resultado da pesquisa de prontuários</th>
                            <th colspan="2"><a href="{{url('/juntamedica/prontuario/criar/')}}" class="btn btn-primary">Criar prontuário</a></th>
                        </tr>
                        <tr>
                            <th class="col-md-1">CPF</th>
                            <th class="col-md-1">Matrícula</th>
                            <th class="col-md-1">Post/Grad</th>
                            <th class="col-md-4">Nome</th>
                            <th class="col-md-1">Acompanhamento</th>
                            <th class="col-md-2">Unidade</th>
                            <th class="col-md-1">Orgão</th>
                            @can('JPMS')
                            <th class="col-md-1">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($prontuarios))
                            @if(empty($prontuarios))        
                                <tr>
                                    <th colspan="7">Nenhum resultado encontrado</th>
                                </tr>
                            @else
                                @foreach($prontuarios as $p)
                                <tr>
                                    <td>{{$p->st_cpf}}</td>
                                    <td>{{$p->st_matricula}}</td>
                                    <td>{{$p->st_postograduacao}}</td>
                                    <td class="text-left">{{$p->st_nome}}</td>
                                    @if($p->bo_acompanhamento)
                                        <td><span class="label label-danger">Sim</span></td>
                                    @else
                                        <td><span class="label label-success">Não</span></td>
                                    @endif
                                    <td>{{$p->st_unidade}}</td>
                                    <td>{{$p->st_orgao}}</td>
                                    @can('JPMS')
                                    <td><a class="btn btn-primary"  title="Abrir Prontuário" href="{{url('/juntamedica/prontuario/show/'.$p->id)}}"> 
                                    <i class="glyphicon glyphicon-folder-open"></i></a>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach        
                            @endif
                        @endif
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
    <style>
        th, td, input{text-align: center;}
        .foot{text-align: right;}
    </style>
@stop
