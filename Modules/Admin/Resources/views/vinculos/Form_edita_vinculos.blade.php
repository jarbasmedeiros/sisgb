@extends('adminlte::page')

@section('title', 'Alterar Vínculos')

@section('css')
<style>
    .mt-25{ margin-top: 25px; }
    .mt-10{ margin-top: 10px; }
    th, td { text-align: center; }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Vínculos</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('adicionaVinculoUsuario', ['idUsuario'=> $usuario->id]) }}">
                    {{csrf_field()}}
                        <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Adicionar vínculo</legend>
                            <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }} col-md-5">
                                <label for="ce_unidade" class="text-center col-md-12">Unidade</label>
                                <div class="col-md-12" >
                                    <select class='form-control select2' tabindex="1"  required name='ce_unidade' id='ce_unidade'  >
                                        <option value="">Selecione </option>
                                        @foreach($unidades as $unidade)
                                            <option value="{{$unidade->id}}">{{$unidade->st_nomepais}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ce_unidade'))
                                    <span class="help-block text-center">
                                        <strong>{{ $errors->first('ce_unidade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('ce_perfil') ? ' has-error' : '' }} col-md-3">
                                <label for="ce_perfil" class="text-center col-md-12">Perfil</label>
                                <div class="col-md-12" >  
                                    <select class='form-control select2' tabindex="2" required name='ce_perfil' id='ce_perfil' >
                                        <option value="" >Selecione</option>
                                        @foreach($perfis as $perfil)
                                            @if (($perfil->id == 1) && (auth()->user()->perfil != 1))
                                                {{-- faça nada. pula o perfil Admin --}}
                                            @else
                                                <option value="{{$perfil->id}}">{{$perfil->st_nome}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ce_perfil'))
                                    <span class="help-block text-center">
                                        <strong>{{ $errors->first('ce_perfil') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('ce_funcao') ? ' has-error' : '' }} col-md-3">
                                <label for="ce_funcao" class="text-center col-md-12">Função</label>
                                <div class="col-md-12">
                                    <select class='form-control select2' tabindex="3" required name='ce_funcao' id='ce_funcao'>
                                        <option value="" >Selecione</option>
                                        @foreach($funcoes as $funcao)
                                            <option value="{{$funcao->id}}">{{$funcao->st_nome}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ce_funcao'))
                                    <span class="help-block text-center">
                                        <strong>{{ $errors->first('ce_funcao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-1 mt-25">
                                <button type="submit" class="btn btn-primary" tabindex="4" title="Adicionar vínculo">
                                    <i class="fa fa-plus fa-lg"> </i>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                    <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Vínculos do usuário - <b>{{ $usuario->name or 'Usuário não encontrado' }}, Mat. {{ $usuario->matricula or 'Usuário não encontrado' }}</b></legend>
                        <table class="table table-bordered table-striped table-responsive mt-10">
                            <thead >
                                <tr class="bg-primary">
                                    <th class="col-md-1">Ordem</th>
                                    <th class="col-md-3">Unidade</th>
                                    <th class="col-md-3">Perfil</th>
                                    <th class="col-md-4">Função</th>
                                    <th class="col-md-1">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($vinculosUsuario))
                                    @forelse ($vinculosUsuario as $key => $v)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$v->st_unidade}}</td>
                                            <td class="text-left">{{$v->st_role}}</td>
                                            <td>{{$v->st_funcao}}</td>
                                            <td>
                                                <a onclick="modalDeleta({{$usuario->id}}, {{$v->id}})" class="btn btn-danger btn-sm" title="Excluir vínculo">
                                                    <i class="fa fa-trash fa-sm"> </i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Nenhum vínculo encontrado</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
            <a href="{{ url('admin/usuarios') }}" class="btn btn-warning ">
             <i class="glyphicon glyphicon-arrow-left"></i> Voltar
            </a>
        </div>
        </div>
    </div>

    {{-- início -> modal exclui vínculo --}}
    <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel"><b> Excluir Vínculo </b></h5>
                </div>
                <div class="modal-body ">

                    <h4 class="modal-title" id="exampleModalLabel">
                        Deseja realmente excluir o vínculo?
                    </h4>
                </div>
                <form class="form-inline" id="modalDeleta" method="post" > 
                {{csrf_field()}}
                    <div class="modal-footer bg-danger">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- fim -> modal exclui vínculo --}}

@endsection

@section('js')
<script>
  
    function modalDeleta(idUsuario, idVinculo){
        $("#modalDeleta").attr("action", "{{ url('admin/usuario/vinculo')}}/"+idUsuario+"/deletar/"+idVinculo);
        $('#Modal').modal();        
    };

</script>
@endsection