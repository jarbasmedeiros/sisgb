@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Promoções')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 193, implementar aba de promoções. -->
<div class="tab-pane active" id="dados_medalhas">
    <h4 class="tab-title">Promoções - {{ $policial->st_nome }}</h4>
    <hr class="separador">
        {{ csrf_field() }}
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan = "6">PROMOÇÕES</th>
                       
                    </tr>
                    <tr>   
                        <th class = "col-md-2">PROMOÇÃO</th>
                        <th class = "col-md-2">DATA DA PROMOÇÃO</th>
                        <th class = "col-md-2">PUBLICAÇÃO</th>
                        <th class = "col-md-2">DATA DA PUBLICAÇÃO</th>
                        <th class = "col-md-2">DOE</th>
                        <th class = "col-md-2">DATA DOE</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($promocao))
                        @forelse($promocao as $p)
                        <tr>
                            <td>{{$p->st_promocao}}</td>
                            <td>{{\Carbon\Carbon::parse($p->dt_promocao)->format('d/m/Y')}}</td>
                            <td>{{$p->st_boletim}}</td>
                            <td>
                                @if(!empty($p->dt_boletim))
                                    {{\Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y')}}
                                @endif
                            </td>
                            <td>{{$p->st_doe}}</td>
                            <td> 
                                @if(!empty($p->dt_doe))
                                    {{\Carbon\Carbon::parse($p->dt_doe)->format('d/m/Y')}}
                                @endif
                            </td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Nenhuma promoção encontrada.</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-offset-0">
            <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/dados_pessoais')}}">
                    <i class="fa fa-arrow-left"></i> Voltar
            </a>
        </div>
</div>

<!-- Modal Excluir-->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Promoção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">
                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR A PROMOÇÃO?</b>
                </h4>
            </div>
            <form class="form-inline" id="modalDesativa" method="get" > 
            {{csrf_field()}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Função JS que chama a rota para excluir medalha -->
<script>
    function modalDesativa(idPolicial, idPromocao){
        var url = idPolicial+'/promocao/'+idPromocao+'/deleta';                      
        $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
        $('#Modal').modal();        
    };
</script>

<!-- /.tab-pane -->
@endsection