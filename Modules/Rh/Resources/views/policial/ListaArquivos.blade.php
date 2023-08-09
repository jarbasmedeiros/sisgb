@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Arquivos')
@section('tabcontent')
<div class="tab-pane active" id="envio_documentos">
<h4 class="tab-title">Envio de Arquivos - {{ $policial->st_nome}}</h4>
<hr class="separador">
<fieldset class="scheduler-border "> 
<legend class="scheduler-border ">Cadastrar Arquivo</legend> 
<form role="form" method="POST" action="{{url('rh/policiais/'.$policial->id.'/arquivo/cadastra')}}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row"  style="margin-top: 20px;">
 
                    <div class="col-md-5" >
                        <span>
                            <input id='arquivo' type="file" class="form-control-file" name='arquivo' accept="application/pdf"  required>
                            <label for='arquivo'>O arquivo deve ser em formato PDF. Tamanho máximo: 1 MB.</label>
                        </span>
                    </div>
                    <div class="col-md-5" style="margin-top: 2px;">
                        <input id="st_descricao" type="text" class="form-control" placeholder="Digite aqui a descrição do arquivo" name="st_descricao" value="" required>    
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px;">
                        <i class="fa fa-send"></i> Enviar
                    </button> 
                </div>
                </div> 
                    
</form>

</fieldset>
<fieldset class="scheduler-border  md-1">  
<table class="table table-bordered">
                    <thead>
                    <tr class="bg-primary">
                        <th style='text-align: center;' colspan="5">Lista de arquivos cadastrados</th>
                    </tr>
                        <tr>
                            <th class="col-md-2">DOCUMENTO</th>
                            <th class="col-md-2">DESCRIÇÃO</th>
                            @can('Edita')
                                <th class="col-md-1" style="text-align: center">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($arquivos))
                            @forelse($arquivos as $a)
                                <tr>
                                    <td>
                                    <span>
                                        <a href="{{url('rh/policiais/'.$policial->id.'/arquivo/'.$a->id.'/download')}}">{{$a->st_arquivo}}.{{$a->st_extensao}}</a>
                                        <input id="arquivo" type="text" class="form-control-file" name="arquivo" value="{{$a->id}}" hidden>
                                    </span>
                                    </td>
                                    <td>{{$a->st_descricao}}</td>
                                    <td style="text-align: center">
                                        @can('Deleta')
                                            <a onclick="modalDeleta({{$policial->id}}, {{$a->id}})" data-toggle="modal" data-placement="top" title="Deletar Arquivo" class="btn btn-danger fa fa fa-trash"></a> 
                                        @endcan  
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center;">Nenhum Arquivo Encontrado.</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>   
                </table>
</fieldset>


<!-- Modal Excluir curso -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Arquivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR O ARQUIVO?</b>
                </h4>
                <form class="form-inline" id="modalDeleta" method="post" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function modalDeleta(idpolicial, idArquivo){
        var url = idpolicial+'/arquivo/'+idArquivo+'/deleta';                      
        $("#modalDeleta").attr("action", "{{ url('rh/policiais/')}}/"+url);
        $('#Modal').modal();        
    };
</script>


@endsection






                                            
                                    