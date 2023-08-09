@extends('rh::funcionario.Form_edita_funcionario')
@section('tabcontent')
    <div class="tab-pane active" id="arquivos">
        <h4 class="tab-title">Arquivos - {{ strtoupper($servidor->st_nome) }}</h4>
        <hr class="separador">
        @can('Edita')
            <span data-toggle="modal" data-placement="top">
                <a onclick='modalAnexaPDF()' data-toggle="tooltip" title="Anexa PDF" class="btn btn-primary" style="margin: 2px;">
                <i class="fa fa-fw fa-file-pdf-o"></i>Anexar PDF</a>
            </span>
            <span data-toggle="modal" data-placement="top">
                <a onclick='modalAnexaFoto()' data-toggle="tooltip" id="btFoto" title="Anexa Foto" class="btn btn-primary" style="margin: 2px;">
                <i class="fa fa-fw fa-file-picture-o"></i>Anexar Foto</a>
            </span>
        @endcan
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12">
                <table class="table table-bordered">
                    @if(isset($arquivos) && count($arquivos)>0)
                    <thead>
                        <tr>
                            <th>NOME DO ARQUIVO</th>
                            @can('Admin')
                                <th>AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($arquivos as $arq)
                            <tr>
                                <th><span data-toggle="modal" data-placement="top">
                                        <a href="{{url('rh/arquivo/openArquivo/' . $arq->id)}}"  target="_blank">{{$arq->st_nome}}</a>
                                    </span>
                                </th>
                                @can('Edita')
                                    <th>
                                        <input type="submit" value="Salvar" style="display: none;" id="{{$arq->id}}" class="btn-sm btn-primary">
                                        <span data-toggle="modal" data-placement="top">
                                            <a onclick='modalDesativa({{$arq->id}})' data-toggle="tooltip" title="Deletar" class="btn btn-sm btn-danger" style="margin: 2px;">
                                            <i class="fa fa-trash"></i></a>
                                        </span>
                                    </th>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                    @else
                        <tr>
                            <td class="col-md-12 bg-danger">Não existe arquivos para este funcinário </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <!--Modal Desativa Arquivo -->
    <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Arquivo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR O ARQUIVO?</b>
                    </h4>
                    <form class="form-inline" id="modalDesativa" method="post"> {{csrf_field()}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Excluir</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Modal Anexa PDF -->
    <div class="modal fade-lg" id="ModalPdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ANEXAR PDF</h5>
                </div>
                <div class="modal-body">
                <form role="form" class="form-inline" id="anexaPdf" method="POST" action=""  enctype="multipart/form-data"> {{csrf_field()}}
                    <input id="st_path" type="file" class="form-control-file" name="st_path" accept="application/pdf" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Modal Anexa Foto -->
    <div class="modal fade-lg" id="ModalFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ANEXAR FOTO</h5>
                </div>
                <div class="modal-body">
                <form role="form" class="form-inline" id="anexaFoto" method="POST" action=""  enctype="multipart/form-data"> {{csrf_field()}}
                    @if(isset($servidor->st_caminhofoto))
                            <input id="st_path1" type="file" class="form-control-file" style="margin:5px;" name="st_path" accept="image/*" required>
                            <img class="" src="{{url( 'rh/imagem/'.$servidor->st_caminhofoto )}}">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger " style="margin:5px;" id="bt_alteraFoto" onclick="displayInput()">Alterar Foto?</button>
                            <button type="submit" id="bt_submit" class="btn btn-primary">Salvar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    @else
                        <input id="st_path" type="file" class="form-control-file" style="margin:5px;" name="st_path" accept="image/*" required>
                        <span class="label label-warning">Não existe foto cadastrada ainda.</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // $(staticAncestors).on('click', '#btFoto', function() {
        //     $("#st_path").hide();
        //     $("#bt_submit").hide();
        // });

        function modalDesativa(id) {
            $("#modalDesativa").attr("action", "{{ url('rh/arquivo/destroy')}}/" + id);
            $('#Modal').modal();
        };

        function modalAnexaPDF() {
            $("#anexaPdf").attr("action", "{{ url('/rh/servidor/edita/'.$servidor->id.'/lista_arquivos') }}");
            $('#ModalPdf').modal();
        };

        function modalAnexaFoto() {
        
            $("#anexaFoto").attr("action", "{{ url('/rh/servidor/edita/'.$servidor->id.'/foto') }}");
            $('#ModalFoto').modal();
            $("#st_path1").hide();
            $("#bt_submit").hide();
            $("#bt_alteraFoto").show();
        };

        function displayInput(){
            $("#bt_alteraFoto").hide();
            $("#st_path1").show();
            $("#bt_submit").show();
        }

    </script>
@endsection