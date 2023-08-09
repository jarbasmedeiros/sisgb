@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Prova de Vida')
@section('tabcontent')
<div class="tab-pane active" id="cursos">
    <h4 class="tab-title">Cadastro de Prova de Vida</h4>
    <hr class="separador">
</div>
<div class="modal-content">
  
        <form class="form"  method="post"  action='{{ url("rh/policiais/cadastra/" . $policial->id ."/".$idDeclaracao) }}'>
        {{csrf_field()}}
            <fieldset class="scheduler-border">    	
                <legend class="scheduler-border">Informações de Cadastro da Prova de Vida</legend>
                <div class="policialbeneficiado" >
                    <div class='row'>
                        <div class=" col-md-3">
                            <label >CPF</label>
                            <div class="input-group">
                                <input  type="text" placeholder="CPF do beneficiário" id="st_cpf" name="st_cpf"  class="form-control" required maxlength="14" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);"> 
                                <span class="input-group-btn">
                                    <button type="button" id="search-btn" class="btn btn-flat" onclick="buscaPessoa()">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div id="refresh" style="margin-top:30px; display: none">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>

                    <div class='row'>
                        <div class=" col-md-2">
                            <label >Ordem</label>
                            <select id="st_ordem" name="st_ordem"  class="form-control" style="width: 70%;" required>
                                <option value="">Selecione</option>
                                <optgroup label="Ordem 1">
                                        <option value="Cônjuge">Cônjuge</option>
                                        <option value="Filho">Filho</option>
                                        <option value="Filho Inválido">Filho Inválido</option>
                                        <option value="Enteado">Enteado</option>
                                        <option value="Enteado Inválido">Enteado Inválido</option>
                                        <option value="Pessoa Sob Guarda">Pessoa Sob Guarda</option>
                                        <option value="Pessoa Sob Tutela">Pessoa Sob Tutela</option>
                                    </optgroup>
    
                                    <optgroup label="Ordem 2">
                                        <option value="Pai">Pai</option>
                                        <option value="Mãe">Mãe</option>
                                    </optgroup>
                                    <optgroup label="Ordem 3">
                                        <option value="Irmão Órfão">Irmão Órfão</option>
                                        <option value="Irmão Inválido">Irmão Inválido</option>
                                    </optgroup>
                            </select>
                        </div>
                    
                        <div class="form-group col-md-4">
                            <label >Nome</label>
                            <input placeholder="Nome do beneficiário" id="st_nome" type="text" name="st_nome"  class="form-control" required > 
                        </div>
                        
                        <div class="form-group col-md-2">

                            <label >Sexo</label>
                            <select id="st_sexo" name="st_sexo" class="form-control" required >
                                <option>Selecione</option>
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                            </select>

                        </div>
                        <div class="form-group col-md-2">

                            <label >Nascimento</label>
                            <input id="dt_nascimento" name="dt_nascimento" type="date" class="form-control" required>

                        </div>
                    </div><!--row-->
                    <div class='row'>
                        <div class="form-group col-md-6">

                            <label >Nome da Mãe</label>
                            <input placeholder="Nome da mãe do beneficiário" id="st_mae" name="st_mae" type="text" class="form-control" required>

                        </div>
                    </div><!--row-->
                    <div class="row">
                        <div class="form-group col-md-4">

                            <label>Telefone</label>
                            <input placeholder="Telefone do beneficiário ou do responsável" id="telefone" name="st_telefone" type="text" class="form-control" maxlength="15" required>

                        </div>
                        <div class="form-group col-md-4">

                            <label>Email</label>
                            <input placeholder="Email do beneficiário ou do responsável" id="st_email" name="st_email" type="email" class="form-control">

                        </div>
                    </div>
                    <div class='row'>
                        <br>
                        <div style="text-align: center">
                            <div class="form-group">                
                                <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/provadevida')}}" style='margin-right: 10px;'>
                                <i class="fa fa-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary salvar">Salvar Novo Beneficiário</button>
                            </div>
                        </div>                    
                    </div><!--row-->
                </div>
        </form>
        @if(isset($beneficiarios) && count($beneficiarios)>0)
      
        <hr>
        <table class="table table-hover">
            <thead>
                <tr class="bg-primary">
                    <th colspan = "8">Lista de Beneficiários de {{ $policial->st_nome }} - {{ $policial->st_matricula }}</th>
                </tr>
                <tr>
                    <th style='width:10%'>Ordem</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Documentos e Comprovantes</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beneficiarios as $beneficiario)
               
                <tr>
                    <td>{{ $beneficiario->st_ordem }}</td>
                    <td>{{ $beneficiario->pessoa->st_nome }}</td>
                    <td>{{ $beneficiario->pessoa->st_cpf }}</td>
                    <td>{{ $beneficiario->st_telefone }}</td>
                    <td>
                            @if(is_null($beneficiario->st_caminhoanexo))
                            <button id="{{ $beneficiario->id }}" onclick="mudaBeneficiario(this,1)" data-idbeneficiario="{{ $beneficiario->id }}" data-nome="{{ $beneficiario->pessoa->st_nome }}" data-toggle="modal" data-target="#enviaDocumento" class='btn btn-sm btn-success' type='button' title='Enviar Documento de Vínculo Familiar'>Documento <i class="fa fa-fw fa-cloud-upload"></i></button>
                            @else
                            <a href="{{ route('downloadDocBeneficiario',['idDeclaracao'=>$idDeclaracao, 'idBeneficiario'=>$beneficiario->id, 'tipo'=>'1']) }}" class='btn btn-sm btn-primary' target="_blank" title='Baixar Documento de Vínculo Familiar'>Documento <i class="fa fa-fw fa-download"></i></a>
                            @endif
                            @if(is_null($beneficiario->st_caminhocomprovanteresidencia))
                            <button id="{{ $beneficiario->id }}" onclick="mudaBeneficiario(this,2)" data-idbeneficiario="{{ $beneficiario->id }}" data-nome="{{ $beneficiario->pessoa->st_nome }}" data-toggle="modal" data-target="#enviaDocumento" class='btn btn-sm btn-success' type='button' title='Enviar Comprovante de Residência'>Comprovante <i class="fa fa-fw fa-cloud-upload"></i></button>
                            @else
                            <a href="{{ route('downloadDocBeneficiario',['idDeclaracao'=>$idDeclaracao, 'idBeneficiario'=>$beneficiario->id, 'tipo'=>'2']) }}" class='btn btn-sm btn-primary' target="_blank" title='Baixar Comprovante de Residência'>Comprovante <i class="fa fa-fw fa-download"></i></a>
                            @endif
                        </td>
                        <td>
                                <a href="" onclick="editaBeneficiario(this)" data-idbeneficiario="{{ $beneficiario->id }}" data-idpessoa="{{ $beneficiario->pessoa->id }}" data-cpf="{{ $beneficiario->pessoa->st_cpf }}" data-ordem="{{ $beneficiario->st_ordem }}" data-nome="{{ $beneficiario->pessoa->st_nome }}" data-sexo="{{ $beneficiario->pessoa->st_sexo }}" data-nascimento="{{ $beneficiario->pessoa->dt_nascimento }}" data-mae="{{ $beneficiario->pessoa->st_mae }}" data-telefone="{{ $beneficiario->pessoa->st_telefone }}" data-email="{{ $beneficiario->pessoa->st_email }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-default" title="Editar Beneficiário"><i class="fa fa-fw fa-edit"></i></a>
                            
                                <a href="{{ route('excluirBeneficiarioProvadeVida',['idPolicial'=>$policial->id, 'idDeclaracao'=>$idDeclaracao, 'idBeneficiario'=>$beneficiario->id]) }}" onclick="return confirm('Você realmente quer excluir este beneficiário desta certidão?');" class="btn btn-danger btn-sm" title="Excluir Beneficiário"><i class="fa fa-fw fa-trash"></i></a></td>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- MODAL DE ENVIO DE DOCUMENTO -->
        <div class="modal fade" id="enviaDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Enviar Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formulario" name="formulario" class="form"  method="post" action='{{ url("rh/policiais/cadastrar/beneficiarios/upload/") }}' enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p><strong>Beneficiário:</strong> <span id="nomedobeneficiario">João das Quantas</span></p>
                        <p>Obs: O tamanho máximo do arquivo é de 3 MB.</p>
                        <h3 id="label_tipo" style="color: green">Tipo de Documento</h3>
                        <hr>
                        <div class="form-group">
                            <label for="st_sugestao" class="col-md-2 control-label">Documento:</label>
                            <input title="Certidão de Nascimento, Casamento etc..." id="comprovante" name="arquivo" type="file" class="form-control" required>
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
        
          <!-- MODAL EDITA BENEFICIARIO -->
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title">Editar beneficiário</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formulario2" name="formulario2" action='{{ url("rh/policiais/editar/beneficiario/") }}' method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <label >CPF</label>
                            <input  type="text" required maxlength="14"  placeholder="CPF do beneficiário" id="st_cpf2" name="st_cpf2"  class="form-control"  onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);"> 
                            <label >Ordem</label>
                            <select id="st_ordem2" name="st_ordem2"  class="form-control" required>
                                <option value="">Selecione</option>
                                <optgroup label="Ordem 1">
                                        <option value="Cônjuge">Cônjuge</option>
                                        <option value="Filho">Filho</option>
                                        <option value="Filho Inválido">Filho Inválido</option>
                                        <option value="Enteado">Enteado</option>
                                        <option value="Enteado Inválido">Enteado Inválido</option>
                                        <option value="Pessoa Sob Guarda">Pessoa Sob Guarda</option>
                                        <option value="Pessoa Sob Tutela">Pessoa Sob Tutela</option>
                                    </optgroup>
    
                                    <optgroup label="Ordem 2">
                                        <option value="Pai">Pai</option>
                                        <option value="Mãe">Mãe</option>
                                    </optgroup>
                                    <optgroup label="Ordem 3">
                                        <option value="Irmão Órfão">Irmão Órfão</option>
                                        <option value="Irmão Inválido">Irmão Inválido</option>
                                    </optgroup>
                            </select>
                            <label >Nome</label>
                            <input placeholder="Nome do beneficiário" id="st_nome2" type="text" name="st_nome2"  class="form-control" required> 
                            <label >Sexo</label>
                            <select id="st_sexo2" name="st_sexo2" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                            </select>
                            <label >Nascimento</label>
                            <input id="dt_nascimento2" name="dt_nascimento2" type="date" class="form-control" required>
                            <label >Nome da Mãe</label>
                            <input placeholder="Nome da mãe do beneficiário" id="st_mae2" name="st_mae2" type="text" class="form-control" required>
                            <label>Telefone</label>
                            <input placeholder="Telefone do beneficiário ou do responsável" id="telefone2" name="st_telefone2" type="text" class="form-control" maxlength="15" required>
                            <label>Email</label>
                            <input required placeholder="Email do beneficiário ou do responsável" id="st_email2" name="st_email2" type="email" class="form-control">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



            <!-- fim edita beneficiario -->
        @endif
    </fieldset>

</div>
</div>

<script src="{{ asset('js/cpf_mascara.js' ) }}"></script>
<script src="{{ asset('js/telefone_mascara.js' ) }}"></script>
 <script>

    function buscaPessoa(){
        var cpf = $('#st_cpf').val();
        if(cpf){
            $('#refresh').show();
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                baseUrl += "/";
            $.ajax({
                url : baseUrl + "rh/policiais/pessoa/ajax/"+cpf,
                type : 'get'
            }).done(function(resposta){
                console.log(resposta);
                $('#refresh').hide();
                if(resposta == 0){
                    alert('Nenhum resultado encontrado!');
                    $("#st_nome").val("");
                    $("#st_sexo").val("");
                    $("#dt_nascimento").val("");
                    $("#st_mae").val("");
                } else {
                    var data = JSON.parse(resposta);
                    var st_nome = data.st_nome;
                    var st_sexo = data.st_sexo;
                    var dt_nascimento = data.dt_nascimento;
                    var st_mae = data.st_mae;
                    var st_telefone = data.st_telefone;
                    var st_email = data.st_email;
                    $("#st_nome").val(st_nome);
                    $("#st_sexo").val(st_sexo);
                    $("#dt_nascimento").val(dt_nascimento);
                    $("#st_mae").val(st_mae);
                    $("#telefone").val(st_telefone);
                    $("#st_email").val(st_email);
                }                    
            }).fail(function(jgXHR, textStatus, resposta){
                alert('erro ' + resposta);
            })
        } else {
            alert("Digite o CPF para realizar a busca!");
        }
    }


    function mudaBeneficiario(componente,tipo){
        idBeneficiario = componente.getAttribute("data-idbeneficiario");
       
        nomeBeneficiario = componente.getAttribute("data-nome");
        $("#nomedobeneficiario").html(nomeBeneficiario);
        if(tipo==1){
            $("#label_tipo").html("Documento de Vínculo Familiar");
        } else if(tipo==2){
            $("#label_tipo").html("Comprovante de Residência");
        }        
        document.getElementById('formulario').action = "/sisgp/rh/policiais/beneficiarios/upload/"+idBeneficiario+"/{{$idDeclaracao}}/"+tipo;
           //alert(document.getElementById('formulario').action);     
    }

    function editaBeneficiario(componente){
        idPessoa = componente.getAttribute("data-idpessoa");
        idBeneficiario = componente.getAttribute("data-idbeneficiario");
        idDeclaracao = {{ $idDeclaracao}};
        cpf = componente.getAttribute("data-cpf");
        $("#st_cpf2").val(cpf);
        ordem = componente.getAttribute("data-ordem");
        $("#st_ordem2").val(ordem);
        nome = componente.getAttribute("data-nome");
        $("#st_nome2").val(nome);
        sexo = componente.getAttribute("data-sexo");
        $("#st_sexo2").val(sexo);
        nascimento = componente.getAttribute("data-nascimento");
        $("#dt_nascimento2").val(nascimento);
        mae = componente.getAttribute("data-mae");
        $("#st_mae2").val(mae);
        telefone = componente.getAttribute("data-telefone");
        $("#telefone2").val(telefone);
        email = componente.getAttribute("data-email");
        $("#st_email2").val(email);
        document.getElementById('formulario2').action = "/sisgp/rh/policiais/beneficiario/editar/"+idDeclaracao+"/"+idBeneficiario+"/"+idPessoa;
        //alert(document.getElementById('formulario2').action);
    }


</script>

@endsection

