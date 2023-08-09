            <div class="form-row form-inline">
                <div class="form-group col-xs-3" style="margin-right:29%;">
                    <div class="form-group col-xs-6"><strong>Policial</strong></div>
                    <input type="text" class="form-control" id="st_policial" placeholder="Matrícula ou CPF">
                    <button type="button" onclick="buscaPolicialParaNota()" class="btn btn-primary glyphicon glyphicon-search" title= "Localizar Polcial"></button>
                </div>
               
            </div>
            <table class="table table-bordered", id="policiais">
            <thead>
                <tr>
                    <th>Post/Grad</th>
                    <th>Praça</th>
                    <th>Matrícula</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($modelos))
                    @foreach($modelos as $m)
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        @section('scripts')
    <script>
        function buscaPolicialParaNota(){
            var dadoPolicial = $('#st_policial').val();
            if(dadoPolicial != null && dadoPolicial != undefined && dadoPolicial != ""){
            
                    $.ajax({
                        url : "{{url('boletim/buscapolicialparanota')}}" + "/" + dadoPolicial,
                        type : 'get',
                    beforeSend : function(){
                        $("#resultado").html("ENVIANDO...");
                    }
                }).done(function(msg){
                    if(msg == 0){
                       alert('Policial não encontrado');
                    }else{
                        $("#policiais tbody").append(
                            "<tr>"+
                            "<th>"+msg.ce_graduacao+"</th>"+
                            "<th>"+msg.st_numeropraca+"</th>"+
                            "<th>"+msg.st_matricula+"</th>"+
                            "<th>"+msg.st_nome+"</th>"+
                            "</tr>");
                        
                        alert(msg.st_nome);
                        alert('existe Policial');

                    
                    }
                    
                    }).fail(function(jqXHR, textStatus, msg){
                        alert(msg);
                    })

            }else{
                alert('informe a Matrícula ou cpf do policial');
            }

 
          
        }

    </script>
@stop
     
