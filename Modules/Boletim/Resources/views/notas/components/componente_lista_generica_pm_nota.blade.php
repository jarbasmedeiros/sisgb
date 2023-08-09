<!-- .componente lista genérica dos pms da nota  -->
@section('fragmento_listagem_dinamica_policias_notas1')
<br/>
    <table class="table table-striped" >
        <thead>
            <tr class="bg-primary">
                <th>Post/Grads</th>
                <th>Praça</th>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        @if(isset($nota->id))
            <tbody class="addPolicialEncontrado_tbody">
            @if(isset($policiaisDaNota) && count($policiaisDaNota) > 0)
                @foreach($policiaisDaNota as $key => $policiais)                        
                    <tr>
                        <td>{{$policiais->st_postograduacaosigla}}</td>
                        <td>{{$policiais->st_numpraca}}</td>
                        <th>{{$policiais->st_matricula}}</th>
                        <th id="policial_{{$policiais->id}}">{{$policiais->st_nome}}</th>
                        <th>                               
                            @if($nota->st_status == 'RASCUNHO')
                                <a class="btn btn-danger btn-sm removerPolicial" id="{{$policiais->id}}" value="{{$policiais->id}}" data-toggle="modal" data-target="#removerPolicialModal" title="Remover Policial">
                                <span class="fa fa-trash"></span></a>
                            @endif
                        </th>
                    </tr>
                @endforeach
            @endif
            </tbody>
        @endif
    </table>
        
    @if(isset($policiaisDaNota) && count($policiaisDaNota) > 0 )
        <div class="pagination pagination-centered">
            <tr>
                    <th>
                    {{$policiaisDaNota->links()}}
                    </th>
            </tr>
        </div>
    @endif
@endsection
<div class="camposdanota"></div>

<!--  end componente lista genérica dos pms da nota  -->

<script>

function addPmANota(){
   var baseUrl = getBaseUrl()+"/";
    
    dados = {
      idNota: $('#idNota').val(),
      idPolicial: $('#idPolicial').val(),
     _token: $("input[name=_token]").val()
     };    
    $.ajax({
        //Enviando via ajax
        url : baseUrl+"boletim/adicionapolicial",
        data: dados,
        method: 'POST',
        //Verificando se encontrou 0 policial
    }).done(function(data){
        //console.log(data.length);
        if(data == 1){
            alert('Policial adicionado a nota com sucesso!');
            $("[data-dismiss=modal]").trigger({ type: "click" });
            document.location.reload(true);
        }else{
            alert(data);
            //$("[data-dismiss=modal]").trigger({ type: "click" });
        }

    });
 }
</script>
