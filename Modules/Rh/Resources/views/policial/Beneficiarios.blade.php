@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Declaração Anual de Beneficiários')
@section('tabcontent')

<div class="tab-pane active" id="cursos">
    <h4 class="tab-title">Lista de Declarações Anuais de Beneficiários de <span style='text-decoration: underline'>{{ $policial->st_nome}}</span></h4>
    <hr class="separador">
</div>
<div class="container-fluid">
    <div class="row">
        @if(!empty($declaracoes))
        <table class="table table-bordered">
            <thead>            
                <tr class="bg-primary">
                    <th colspan="3" style="text-align: center;">Lista de Declarações Anuais de Beneficiários</th>
                    <th colspan="2" style="text-align: center">
                        <a class="btn btn-primary" href='{{url("rh/policiais/" . $policial->id ."/cadastra/declaracaoanual")}}' title="Criar Declaração Anual">Criar Declaração Anual</a>
                    </th>
                </tr>
                    <tr>
                        <th class="col-md-1">Ano</th>
                        <th class="col-md-2">Unidade</th>
                        <th class="col-md-2">Responsável</th>
                        <th class="col-md-2" style="text-align: center">Ações</th>
                    </tr>
            </thead>
            <tbody>
                @foreach($declaracoes as $declaracao)
                <tr>
                    <td>{{ $declaracao->st_ano }}</td>
                    <td>{{ $declaracao->unidade->st_sigla }}</td>
                    <td>{{ $declaracao->sargenteante->graduacao->st_postograduacaosigla }} {{ $declaracao->sargenteante->st_nomeguerra }}</td>
                    <td style="text-align: right">
                        @if((empty($declaracao->st_assinaturapolicial) || empty($declaracao->st_assinaturaresponsavel)) && date("Y") == $declaracao->st_ano && $declaracao->st_status!='FECHADO')
                            <a href='{{ url("rh/policiais/" . $policial->id ."/cadastra/beneficiarios/$declaracao->id") }}' class="btn btn-primary btn-sm" @if($declaracao->bo_todosbeneficiariosok != true) title="Falta Realizar o Upload de Documentos!" @else title="Adicionar Beneficiários" @endif ><i class="fa fa-fw fa-user-plus"></i> @if($declaracao->bo_todosbeneficiariosok != true) <i style='color:red' class="fa fa-fw fa-cloud-upload"></i> @endif </a>
                            @if($declaracao->bo_todosbeneficiariosok == true)
                            <a href="" onclick="mudaCertidao(this)" data-st_assinaturaresponsavel="{{ $declaracao->st_asinaturaresponsavel }}" data-st_assinaturapolicial="{{ $declaracao->st_assinaturapolicial }}" data-idcertidao="{{ $declaracao->id }}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default" title="Assinar a Declaração">Assinar</a>
                            @endif
                        @endif
                        @if($declaracao->st_status == "FECHADO" && date("Y") == $declaracao->st_ano)
                            <a onclick="return confirm('Você realmente quer anular as assinaturas e editar a certidão?');" href="{{ route('reabrirDeclaracao',['idPolicial'=>$policial->id, 'idDeclaracao'=>$declaracao->id]) }}" class="btn btn-success btn-sm">Editar</a>
                        @endif
                        @if($declaracao->st_status == "FECHADO")
                            <a target="_blank" href="{{ route('imprimeCertidao',['idPolicial'=>$policial->id, 'idDeclaracao'=>$declaracao->id]) }}" class="btn btn-primary btn-sm" title="Imprimir Declaração"><i class="fa fa-fw fa-print"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else 
        <table class="table table-bordered">
            <thead>            
                <tr class="bg-primary">
                    <th style="text-align: center;">Lista de Declarações Anuais de Beneficiários</th>
                    <th style="text-align: center">
                        <a class="btn btn-primary" href='{{url("rh/policiais/" . $policial->id ."/cadastra/declaracaoanual")}}' title="Criar Declaração Anual">Criar Declaração Anual</a>
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

<!-- MODAL UPLOAD -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Assinar Declaração</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formulario" name="formulario" action='{{ url("rh/policiais/beneficiarios/assinar/") }}' method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <p>Obs: Devem assinar a Declaração tanto o Sargenteante quanto o Policial beneficiado.</p>
                        <label for="assinante">Selecione o Assinante</label>
                        <select name="assinante" class='form-control' id="assinante" required>
                            <option></option>
                            <option id="sargenteante" value="responsavel">Responsável pela Certidão</option>
                            <option id="policialreferido" value="policial">{{ $policial->st_nome}} - Solicitante</option>
                        </select>
                        <br>
                        <label for="senha">Senha</label>
                        <input name="senha" type="password" class="form-control" id="senha" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Assinar Certidão</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function mudaCertidao(componente){
        idCertidao = componente.getAttribute("data-idcertidao");
        st_assinaturapolicial = componente.getAttribute("data-st_assinaturapolicial");
        st_assinaturaresponsavel = componente.getAttribute("data-st_assinaturaresponsavel");
        idCertidao = componente.getAttribute("data-idcertidao");
        document.getElementById('formulario').action = "/sisgp/rh/policiais/beneficiarios/assinar/"+idCertidao;
        if(st_assinaturapolicial){
            $( "#policialreferido" ).hide();
        } else {
            $( "#policialreferido" ).show();
        }
        if(st_assinaturaresponsavel){
            $( "#sargenteante" ).hide();
        } else {
            $( "#sargenteante" ).show();
        }
        
        //alert(document.getElementById('formulario').action);        
    }
</script>
@endsection