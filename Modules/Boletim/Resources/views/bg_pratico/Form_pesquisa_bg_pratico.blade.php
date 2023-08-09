@extends('adminlte::page')

@section('title', 'BG Prático')

@section('css')
<style>

    .mb-10{ 
        margin-bottom: 10px;
    }
    .mt-10{ 
        margin-top: 10px;
    }
    #voltar{ 
        margin-left: 30px;
        margin-bottom: 30px;
    }
    

</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">BG Prático</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="{{ route('pesquisarBGPratico') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-8 col-md-offset-2">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Consulta de Publicações</legend>
                                <div class="form-group{{ $errors->has('st_criterio') ? 'has-error' : '' }} mt-10">
                                    <label for="dt_inicio" class="col-md-3 control-label">Critérios de Busca: <span class="text-red">*</span></label>
                                    <div class="col-md-9">
                                        <input id="st_criterio" name="st_criterio" class="form-control" type="text" class="form-control" value="{{ old('st_criterio') }}" placeholder="Informe o critério de busca. Ex: Medalha." required/>
                                        @if ($errors->has('st_criterio'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_criterio') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('st_policial') ? 'has-error' : '' }} ">
                                    <label for="dt_inicio" class="col-md-3 control-label">Dados do Policial:<span class="text-red">*</span></label>
                                    <div class="col-md-9">
                                        <input id="st_policial" name="st_policial" class="form-control" type="number"  class="form-control" value="{{ old('st_policial') }}" placeholder="Informe CPF ou Matrícula. Apenas Números." required/>
                                        @if ($errors->has('st_policial'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_policial') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('dt_inicio') ? 'has-error' : '' }}">
                                    <label for="dt_inicio" class="col-md-3 control-label">Início:</label>
                                    <div class="col-md-9">
                                        <input id="dt_inicio" name="dt_inicio" class="form-control" type="date" class="form-control date" value="{{ old('dt_inicio') }}"  />
                                        @if ($errors->has('dt_inicio'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('dt_inicio') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('dt_fim') ? 'has-error' : '' }}">
                                    <label for="dt_fim" class="col-md-3 control-label">Término:</label>
                                    <div class="col-md-9">
                                        <input id="dt_fim" name="dt_fim" class="form-control" type="date" class="form-control date" value="{{ old('dt_fim') }}" />
                                        @if ($errors->has('dt_fim'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('dt_fim') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-md-offset-5 mb-10">
                                    <button type="submit" class="btn btn-primary" title="Pesquisar">
                                        <i class="fa fa-search"></i> Pesquisar
                                    </button>
                                </div>
                                
                        </fieldset>
                    </div>
                </form>
                @if (isset($publicacoes))
                    {{-- Lista as publicações pesquisadas --}}
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="col-md-12"> {{ $msgTopicos }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($publicacoes as $publicacao)
                                        <tr>
                                            <td class="col-md-12">
                                                <div class="col-md-1">
                                                    @if (isset($publicacao->ce_nota))
                                                        <a href="{{ url('/boletim/nota/visualizar/' . $publicacao->ce_nota) }}" class="btn btn-primary fa fa-eye" title="Visualizar Nota da Publicação" target="blank"> </a>
                                                    @else  
                                                        <a href="" class="btn btn-primary fa fa-eye" title="Publicação Sem Nota" disabled></a>
                                                    @endif
                                                </div>
                                                {{ $publicacao->st_boletim }} de {{ date('d/m/Y', strtotime($publicacao->dt_publicacao)) }}
                                                <br>
                                                <b> {{ $publicacao->st_assunto }} </b>
                                            </td>
                                        </tr>    
                                    @empty
                                        <tr colspan= "2">
                                            <td > Nenhum resultado encontrado, refine o critério de busca </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </fieldset>
                    </div>  
                @endif
            </div>
        </div>
        </div>
    </div>
</div>
    
@endsection
    


