@extends('adminlte::page')
@section('title', 'SISGP - Opção Religiosa')
@section('content')

<div class="tab-pane active">
    <h4 class="tab-title">Opção Religiosa</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('rh/religiao/censo') }}" >
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Informe a Sua Religião</legend>
            <div class="row">
                    <div class="form-group col-md-3">
                        <label for="categoria">Segmentação religiosa</label>     
                        <select id='categoria' name="ce_categoriareligiosa" class='form-control' required>
                            <option>Selecione</option>
                            @foreach($categorias as $categoria)    
                            <option @if(($idCategoria == $categoria->id) || (isset($verificado->ce_categoriareligiosa) && empty($idCategoria) && $verificado->ce_categoriareligiosa == $categoria->id)) selected @endif value="{{ $categoria->id}}">{{ $categoria->st_categoria}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="denominacao">Denominação religiosa</label>     
                        <select  onchange='verificaDetalhe()' id='st_denominacao' name="st_denominacaoreligiosa" class='form-control' required>
                            <option></option>
                    @if($denominacoes)
                            @foreach($denominacoes as $denominacao) 
                                @if(!empty($verificado->st_denominacaoreligiosa)) 
                                    <option id="{{$denominacao->bo_detalhe}}" @if($verificado->st_denominacaoreligiosa == $denominacao->st_denominacaoreligiosa) selected @endif value="{{ $denominacao->st_denominacaoreligiosa}}">{{ $denominacao->st_denominacaoreligiosa}}</option>
                                @else   
                                    <option  id="{{$denominacao->bo_detalhe}}" value="{{ $denominacao->st_denominacaoreligiosa}}">{{ $denominacao->st_denominacaoreligiosa}}</option>
                                @endif
                            @endforeach
                    @endif
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <div style="display: none;" id="inputdetalhe" class="form-group{{ $errors->has('st_funcao') ? ' has-error' : '' }}">
                                <label for="st_funcao" class="control-label">Outra denominação religiosa</label>

                                    @if(isset($verificado->st_detalhe))
                                    <input id="st_detalhe" type="text" class="form-control" required="true" placeholder="infrome a denominação religiosa" name="st_detalhe" value="{{ $verificado->st_detalhe }}"> 
                                    @else
                                    <input id="st_detalhe"  type="text" class="form-control" required="true" placeholder="infrome a denominação religiosa" name="st_detalhe" value="{{ old('st_detalhe') }}"> 
                                    @endif
                                    @if ($errors->has('st_detalhe'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_detalhe') }}</strong>
                                    </span>
                                    @endif
                        </div>
                    </div>
                   
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-4">
                <a class="btn btn-warning" href="{{url('/')}}" style='margin-right: 10px;'>
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Salvar
                </button>
            </div>
        </div>
        <!-- Definindo o metodo de envio -->
    </form>
</div>
@endsection
@section('js')
<script>
   /*  $(document).ready(function() {
        var inputdetalhe = $("#st_detalhe").val(); 
       if(inputdetalhe != null && inputdetalhe != undefined  && inputdetalhe != ''){
            $('#inputdetalhe').show();
       }

        $('#categoria').change(function() {
            $('#inputdetalhe').hide();
            $("#st_detalhe").val(''); 
            $('#st_detalhe').attr("required", false);
            if(this.value > 0){
                window.location.href="{{url('rh/religiao/censo')}}"+'/'+this.value;
            } else {
                window.location.href="{{ url('rh/religiao/censo') }}";
            }
            //window.location.href="{{ url('rh/religiao/censo') }}";
            // window.location.href="{{url('rh/religiao/censo')}}"+'/'+this.value;
            //window.location.href = getBaseUrl()+"/religiao/censo/"+this.value;
        });
       
       
    });
 */
$(document).ready(function() {
        var inputdetalhe = $("#st_detalhe").val(); 
        if(inputdetalhe != null && inputdetalhe != undefined  && inputdetalhe != ''){
                $('#inputdetalhe').show();
        }
        $('#categoria').change(function() {
             $('#inputdetalhe').hide();
            $("#st_detalhe").val(''); 
            $('#st_detalhe').attr("required", false);
            if(this.value > 0){
                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                baseUrl += "/";
       
                $.ajax({
                    //Enviando via ajax
                    url : baseUrl+"rh/religiao/denomincao/"+this.value ,
                    method: 'get',
                    //Verificando se encontrou 0 policial
                }).done(function(data){
                    var options = $('#st_denominacao');

                    options.find('option').remove();
                    if(data.length > 0){
                        $('#st_denominacao').prop('disabled', false);
                        $('#st_denominacao').prop('required', true);
                        $("#st_denominacao").show();
                        $.each(data, function (i, d) {
                           // $('<option>').val(d.st_denominacaoreligiosa).text(d.st_denominacaoreligiosa).appendTo(options);
                            $('<option>',{
                                value: d.st_denominacaoreligiosa,
                                text: d.st_denominacaoreligiosa,
                                id: d.bo_detalhe
                            }).appendTo(options);
                        });
                    }else{
                        $('#st_denominacao').prop('disabled', true);
                        $("#st_denominacao").hide();
                    }
                    
                });
               // window.location.href="{{url('rh/religiao/censo')}}"+'/'+this.value;
            } else {
                alert('Categoria inválida.'); 
            }
            //window.location.href="{{ url('rh/religiao/censo') }}";
            // window.location.href="{{url('rh/religiao/censo')}}"+'/'+this.value;
            //window.location.href = getBaseUrl()+"/religiao/censo/"+this.value;
        });
    });

    function verificaDetalhe() {

        var detalhe =  $('#st_denominacao option:selected').attr('id');
        if(detalhe == 1){
            $('#inputdetalhe').show();
            $('#st_detalhe').attr("disabled", false);
            $('#st_detalhe').attr("required", true);
        }else{
            $('#inputdetalhe').hide();
            $("#st_detalhe").val(''); 
            $('#st_detalhe').attr("required", false);

        }
     
        };
   
   

</script>
@endsection




