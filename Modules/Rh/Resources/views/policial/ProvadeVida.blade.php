@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Prova de Vida')
@section('tabcontent')

<div class="tab-pane active" id="cursos">
    <h4 class="tab-title">Lista de Provas de Vida do Policial Inativo</h4>
    <hr class="separador">
</div>
<div class="container-fluid">
    <div class="row">
        @if(!empty($declaracoes))
        <table class="table table-bordered">
            <thead>            
                <tr class="bg-primary">
                    <th colspan="4" style="text-align: center;">Lista de Provas de Vida</th>
                    <th colspan="2" style="text-align: center">
                        <form class="form"  method="post" action='{{ url("rh/policiais/edita/" . $policial->id ."/cadastra") }}'>
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary salvar">Criar Prova de Vida</button>
                        </form>
                    </th>
                </tr>
                    <tr>
                    <td>ID</td>
                        <th class="col-md-1">Ano</th>
                        <th class="col-md-2">Unidade</th>
                        <th class="col-md-2">Responsável</th>
                        <th class="col-md-2">Policial</th>
                        <th class="col-md-2" style="text-align: center">Ações</th>
                    </tr>
            </thead>
            <tbody>
                @foreach($declaracoes as $declaracao)
                <tr>
                    <td>{{ $declaracao->id }}</td>
                    <td>{{ $declaracao->st_ano }}</td>
                    <td>{{ $declaracao->unidade->st_sigla }}</td>
                    <td>{{ $declaracao->sargenteante->graduacao->st_postograduacaosigla }} {{ $declaracao->sargenteante->st_nomeguerra }}</td>
                    <td>{{ $declaracao->policial->graduacao->st_postograduacaosigla }} {{ $declaracao->policial->st_nomeguerra }}</td>
                    <td style="text-align: center">
                     <!-- ADICIONA BENEFICIARIO-->
                    @if(date("Y") == $declaracao->st_ano && $declaracao->st_status!='FECHADO' && !$declaracao->st_caminhoassinaturapolicial)
                        <!--Adiciona beneficiarios -->
                        <a href='{{ url("rh/policiais/" . $policial->id ."/cadastra/provadevida/$declaracao->id") }}'  @if($declaracao->bo_todosbeneficiariosok != true) title="Falta Realizar o Upload de Documentos!" @else title="Adicionar Beneficiários na Prova de Vida" @endif class="btn btn-primary "><i class="fa fa-fw fa-user-plus"></i> @if($declaracao->bo_todosbeneficiariosok != true) <i style='color:red' class="fa fa-fw fa-cloud-upload"></i> @endif</a>
                        @if($declaracao->bo_todosbeneficiariosok == true)
                        <!-- Imprime DECLARAÇÃO não ASSINADA-->
                        <a target="_blank" href='{{ url("rh/policiais/" . $policial->id ."/declaração/".$declaracao->id."/certidao/provadevida") }}' class="btn btn-primary " title="Imprimir Declaração"><i class="fa fa-fw fa-print"></i></a>
                        <!-- UPLOAD declaracao assinada -->
                        <button onclick="mudaIdDeclaracao({{$policial->id}},{{$declaracao->id}})" type="button" class="btn btn-success" data-toggle="modal" data-target="#madalUpload"><i class="fa fa-fw fa-upload"></i> </button>
                        <!-- <a href="" data-toggle="modal" data-target="#madalAssinatura" class="btn btn-success " title="Assinar Declaração"><i class="fa fa-fw fa-edit"></i></a> -->
                        @endif
                    @endif
                    @if($declaracao->st_caminhoassinaturapolicial)
                        <!-- download da declaração assinada -->
                        <a target='_blank' data-toggle="tooltip" title="Comprovante de Prova de Vida Assinada" class="btn btn-warning" href='{{ url("rh/policiais/provadevida/download/" . $declaracao->id . "/" . $policial->id) }}'>
                            <span class="icon fa fa-download fa-lg">
                            </span>
                        </a>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
<div class="modal fade" id="madalUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">Upload de Documento Assinado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form id="formulario" name="formulario" class="form"  method="post" action='{{ url("rh/policiais/" . $policial->id ."/upload/".$declaracao->id."/assinatura") }}' enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <div class="modal-body">
                                <p><strong>Upload de Documento Assinado</strong> 
                                <p>Obs: O tamanho máximo do arquivo é de 3mb.</p>
                                <hr>
                                <div class="form-group">
                                    <label for="st_sugestao" class="col-md-2 control-label">Documento:</label>
                                    <input title="Declaração Assinada" id="comprovante" name="arquivo" type="file" class="form-control" required>
                                </div> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                    </form>
            </div>
        </div>
     </div>
</div>

<div class="modal fade" id="madalAssinatura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
      
        <h5 class="modal-title" id="exampleModalLabel">Assinatura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action='{{ url("rh/policiais/declaracao/" . $policial->id."/beneficiarios/".$declaracao->id."/assinar") }}' method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                            <div class="form-group">
                                    <strong> DESEJA REALMENTE ASSINAR A DECLARAÇÃO? </strong>
                                    <br>
                                  <div class="modal-body">
                        <div class="form-group">
                            <p>Obs: Devem assinar a Declaração tanto o SGT Diante quanto o Policial beneficiado.</p>
                            <label for="assinante">Selecione o Assinante</label>
                            <select name="assinante" class="form-control" id="assinante">
                                <option></option>
                                
                                <option id="sargenteante" value="responsavel" >Responsável pela Certidão</option>
                                
                            <option id="policialreferido" value="policial">{{$policial->st_nome}} - Solicitante</option>
                                
                            </select>
                            <br>
                            <label for="senha">Senha</label>
                            <input name="senha" type="password" class="form-control" id="senha" autocomplete="off">
                        </div>
                    </div>
                            </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Assinar Declaração</button>
                    </div>
                </form>
      </div>
   
    </div>
  </div>
</div>

        @else 
        <table class="table table-bordered">
            <thead>            
                <tr class="bg-primary">
                    <th style="text-align: center;">Lista de Provas de Vida</th>
                    <th colspan="2" style="text-align: center">
                        <form class="form"  method="post" action='{{ url("rh/policiais/edita/" . $policial->id ."/cadastra") }}'>
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary salvar">Criar Prova de Vida</button>
                        </form>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Não há declarações cadastradas para <strong>{{$policial->st_nome}}.</strong></td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>
</div>

<script>
    function mudaIdDeclaracao(idpolicial,idformulario){
        document.getElementById('formulario').action = "/sisgp/rh/policiais/"+idpolicial+"/upload/"+idformulario+"/assinatura";        
    }
</script>

@endsection