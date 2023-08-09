@extends('boletim::boletim.template_boletim')

@section('title', 'Edção da Capa do Boletim')

@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                @if(empty($capa))
                    <div class="panel-heading">Formulário para criar capa do Boletim</div>
                    <div class="panel-body">
                        <form id="formulario" class="form-horizontal" role="form" method="POST" action='{{url("/boletim/capa/store/$tipoBoletim")}}' enctype="multipart/form-data"> 
                @else
                    <div class="panel-heading">Formulário para editar capa do Boletim</div>
                    <div class="panel-body">
                        <form id="formulario" class="form-horizontal" role="form" method="POST" action='{{url("/boletim/capa/update/".$idBoletim."/".$capa->id)}}' enctype="multipart/form-data">
                @endif
                    {{csrf_field()}}
                        <div class="camposdanota"></div>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Cabeçalho</legend>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea class="ckeditor" config.width = 500; id="st_cabecalho" name="st_cabecalho">{{(!empty($capa)) ? $capa->st_cabecalho : '' }}</textarea>
                                    @if ($errors->has('st_cabecalho'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_cabecalho') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                       
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Brasão</legend>
                            <div class="form-group">
                                @if($img != "")
                                    <div class="col-md-2">
                                        <img id="img" class='img-responsive' src='data:image/jpeg;base64,{{$img}}'  style="width: 150px; height: 150px;"/>
                                    </div>
                                @endif
                                <div class="col-md-4" style="margin-top: 5%;">
                                    <input type="file" id="input_img" name="input_img">
                                    <p class="help-block">Insira um novo brasão.</p>
                                    @if ($errors->has('input_img') && empty($capa))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('input_img') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Cidade do boletim</legend>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input  class="col-md-4" type="text"  id="st_cidade" name="st_cidade" value="{{(!empty($capa)) ? $capa->st_cidade : '' }}"/>
                                    @if ($errors->has('st_cidade'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_cidade') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Funções e responsaveis</legend>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea class="ckeditor" id="st_funcoes" name="st_funcoes">{{(!empty($capa)) ? $capa->st_funcoes : '' }}</textarea>
                                    @if ($errors->has('st_funcoes'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_funcoes') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group col-md-12">
                            <a href="{{ url()->previous() }}" class="col-md-2 btn btn-danger" style="margin: 5px">
                                <span class="glyphicon glyphicon-arrow-left"></span> Cancelar
                            </a>
                            <button id="enviar" type="submit" class="col-md-2 btn btn-primary" style="margin: 5px" disabled>
                                <i class="fa fa-save"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

<script>
    //função para fazer a preview da foto do policial
   $(function(){
       //pegando uma var do php para o js
        var capa = {!! json_encode($capa) !!};
        //se capa estiver vazia, essa blade vai servir para criar a capa e não editar
        if(capa == ''){
            $('fieldset').change(function(){
                //essa condição é para não permitir salvar a capa sem cidade ou sem imagem
                if(($('#input_img').val() != '') && ($('#st_cidade').val() != '')){
                    document.querySelector("#enviar").disabled = false;
                }else{
                    document.querySelector("#enviar").disabled = true;
                }
            });
        }else{
            document.querySelector("#enviar").disabled = false;
        }
        $('#input_img').change(function(){
            const file = $(this)[0].files[0];
            //teste de arquivo vazio com extensão de imagem, pode ocorrer quando arquivo vem corrompido
            if(file.size == 0){
                alert('Imagem corrompida, por favor escolha outra imagem');
                if(capa == ''){
                    //se for na criação e a imagem for de 0bytes ela está corrompida
                    //na edição a validação disso vai ser pelo controller
                    $('#input_img').val('');
                }
            //teste de tamanho, maior que 2MB não passa pelo php
            }else if(file.size > 2048000){
                alert('Imagem maior que 2MB não será salva, por favor escolha outra imagem');
                if(capa == ''){
                    //se for na criação e a imagem for maior que 2MB ignora a imagem selecionada
                    //na edição a validação disso vai ser pelo controller
                    $('#input_img').val('');
                }
            }else{
                const fileReader = new FileReader()
                fileReader.onloadend = function(){
                    $('#img').attr('src', fileReader.result)
                }
                fileReader.readAsDataURL(file)
            }
        });
   })
</script>
@endsection