@extends('adminlte::page')

@section('title', 'Lista de Policiais')

@section('css')
<style>
     #ficha, #cr {
        margin-top: 2px;
    }
    th, td {
        text-align: center;
    }
</style>
@endsection


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
        <div class="panel-body">
        <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                    @php
                    $contador = 0;
                    if(isset($contador_incial)){
                        $contador = $contador + $contador_incial;
                    }
                    
                    @endphp 
                        <tr class="bg-primary">
                        @if(isset($status)) 
                           <th colspan = "9">LISTA DE POLICIAIS</th>
                        @else
                        <th colspan = "11">LISTA DE POLICIAIS  </th>
                        @endif
                           @if(isset($status))                            
                            <th>
                            

                                    <div class="col-md-1">
                                    @if(isset($unidadesubordinada))
                                        <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("rh/policiais/".$unidadesubordinada."/".$status."/excel/") }}' >
                                    @elseif(isset($efetivoGeral))   

                                        <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("rh/policiais/efetivogeral/excel/ativo") }}' >
                                    @elseif(isset($PoliciaisPorUnidade))  
                                    
                                        <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="GET" action='{{url("rh/policiais/listaPoliciais/".$idGraduacao."/unidade/".$idUnidade."/excel")}}'>
                                    @else
                                        <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("rh/policiais/".$status."/excel/") }}' >
                                    @endif(isset($unidade))
                                             {{csrf_field()}}
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>                                                                                        
                                        </form>
                                    </div>
                       <!--              <div class="col-md-1">
                                        <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{ url("rh/policiais/unidadesubordinada/".$status."/excel/") }}' >
                                            {{csrf_field()}}
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel subordinadas</button>                                                                                        
                                        </form>
                                    </div> -->
                            </th>                                                       
                           <th>
                               @if(!isset($efetivoGeral))
                                <div class="col-md-1">
                                @if(isset($unidadesubordinada))
                                    <form id="listaFuncionarioFilter" class="form-horizontal" role="form"  method="POST" action='{{ url("rh/policiais/".$unidadesubordinada."/".$status."/pdf/") }}'>
                               
                                @elseif(isset($PoliciaisPorUnidadePDF))
                                
                                <form id="listaFuncionarioFilter" class="form-horizontal" role="form"  method="GET" action='{{url ("rh/policiais/listaPoliciais/".$idGraduacao."/unidade/".$idUnidade."/pdf") }}'>
                                @else
                                    <form id="listaFuncionarioFilter" class="form-horizontal" role="form"  method="POST" action='{{ url("rh/policiais/".$status."/pdf/") }}'>
                                @endif       
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print" target="_blank"></span>  Gerar PDF</button>                                    
                                    </form>
                                </div>
                           </th>
                           @endif
                           @endif
                        </tr>
                        <tr>
                            <th class="col-md-1">ORDEM</th>
                            <th class="col-md-1">POSTO / GRADUAÇÃO</th>
                            <th class="col-md-1">NÚMERO DE PRAÇA</th>
                            <th class="col-md-1">RG MILITAR</th>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-1">MATRÍCULA</th>
                            <th class="col-md-1">CPF</th>
                            <th class="col-md-1">TELEFONE</th>
                            <th class="col-md-1">UNIDADE</th>
                            <th class="col-md-1">STATUS</th>
                            @can('Leitura')
                                <th class="col-md-3">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                    @php 
                        //recebe apenas os números do cpf do usuário logado
                        $cpf = preg_replace('/[^0-9]/', '', auth()->user()->st_cpf);
                        //recebe as unidades vinculadas do policial logado
                        $unidadesFilhasPolicialLogado = auth()->user()->unidadesvinculadas;
                    @endphp
                        @if(isset($policiais))
                            @forelse($policiais as $p)
                            @php 
                                $contador ++;
                            @endphp 
                            <tr>
                                <td>{{$contador}}</td>
                                <td>{{$p->st_postograduacaosigla}}</td>
                                <td>{{$p->st_numpraca}}</td>
                                <td>{{$p->st_rgmilitar}}</td>
                                <td class="text-left">{{$p->st_nome}}</td>
                                <td>{{$p->st_matricula}}</td>
                                @can('Administrador')
                                    <td> <a href="{{ URL::route('buscarUsuario', ['st_parametro' => $p->st_cpf]) }}"  title="link para Administração/Usuário" >{{$p->st_cpf}}</a> </td>
                                @endcan
                                @cannot('Administrador')
                                    <td>{{$p->st_cpf}}</td>
                                @endcannot
                                <td>{{$p->st_telefonecelular}}</td>
                                <td>{{$p->st_unidade}}</td>
                                <td>{{($p->bo_ativo == 0) ? 'INATIVO' : 'ATIVO'}}</td>
                                <td>
                                    {{-- verifica se o usuário logado tem a permissão 'Consulta_ficha' ou se o cpf do usuário logado = ao cpf do policial  --}}
                                    @if( auth()->user()->can('Consulta_ficha') )
                                        @if (auth()->user()->can('qualquerUnidade') || auth()->user()->can('CONSULTA_QUALQUER _UNIDADE'))
                                            <a class="btn btn-primary col-md-12" href="{{url('rh/policiais/edita/'.$p->id.'/dados_pessoais')}}"><i class="fa fa-folder-open"></i> Abrir</a>
                                            <a id="cr" class="btn btn-primary col-md-12" href='{{url("rh/policiais/".$p->id."/cadernetaDeRegistro")}}' title="Gerar Caderneta de Registro PDF" target="_blank"><i class="fa fa-fw fa-print"></i>CR</a>
                                             {{-- verifica se o policial é praça --}}
                                            @if($p->ce_graduacao < 8 )
                                                <a id="ficha" class="btn btn-primary col-md-12" href='{{url("rh/policiais/".$p->id."/fichaDisciplinarPdf")}}' title="Gerar Ficha Disciplinar PDF" target="_blank"><i class="fa fa-fw fa-print"></i>Ficha</a>
                                            @endif
                                        @elseif ( isset($unidadesFilhasPolicialLogado) && count($unidadesFilhasPolicialLogado) > 0 )
                                            @if (in_array($p->ce_unidade, $unidadesFilhasPolicialLogado))
                                                <a class="btn btn-primary col-md-12" href="{{url('rh/policiais/edita/'.$p->id.'/dados_pessoais')}}"><i class="fa fa-folder-open"></i> Abrir</a>
                                                <a id="cr" class="btn btn-primary col-md-12" href='{{url("rh/policiais/".$p->id."/cadernetaDeRegistro")}}' title="Gerar Caderneta de Registro PDF" target="_blank"><i class="fa fa-fw fa-print"></i>CR</a>
                                                {{-- verifica se o policial é praça --}}
                                                @if($p->ce_graduacao < 8 )
                                                    <a id="ficha" class="btn btn-primary col-md-12" href='{{url("rh/policiais/".$p->id."/fichaDisciplinarPdf")}}' title="Gerar Ficha Disciplinar PDF" target="_blank"><i class="fa fa-fw fa-print"></i>Ficha</a>
                                                @endif
                                            @endif
                                        @endif
                                    @elseif (( auth()->user()->can('ACESSAR_MEUS_DADOS') && $cpf == $p->st_cpf ))
                                        <a id="cr" class="btn btn-primary col-md-12" href='{{url("rh/policiais/".$p->id."/cadernetaDeRegistro")}}' title="Gerar Caderneta de Registro PDF" target="_blank"><i class="fa fa-fw fa-print"></i>CR</a>
                                        {{-- verifica se o policial é praça --}}
                                        @if($p->ce_graduacao < 8 )
                                            <a id="ficha" class="btn btn-primary col-md-12" href='{{url("rh/policiais/".$p->id."/fichaDisciplinarPdf")}}' title="Gerar Ficha Disciplinar PDF" target="_blank"><i class="fa fa-fw fa-print"></i>Ficha</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Nenhum policial encontrado.</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
                @if(isset($policiais) && count($policiais)>0 && (!is_array($policiais)))
                    {{$policiais->links()}}
                @endif
        </div>
        </div>
        </div>

        <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
            <i class="glyphicon glyphicon-arrow-left"></i> Voltar
        </a>


    
    </div>
</div>

    
@stop






