<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style>
@media print {

@page {size: A4 landscape; }

}
.borda {
border: 1px solid;
border-color: #D3D3D3;
font-family: "Times New Roman";
font-size: 12px;
}
.head {
border: 1px solid;
border-color: #D3D3D3;
background: #EEE9E9;
text-align: center;
font-weight: bold;
}
.cabecalho{
	text-align: center;
	border: 1px solid;
	border-color: #D3D3D3;
}
.strong{
	text-align: center;
	border: 1px solid;
}
.seminfo{
	text-align: center;
	font-weight: bold;
	padding-top: 100px;
	padding-bottom: 10px;
}


</style>
<div class="borda">
	<div class="row">
		<div class="col-md-12 cabecalho">
			<div class="col-md-12">ESTADO DO RIO GRANDE DO NORTE</div>
			<div class="col-md-12">SECRETARIA DE SEGURANÇA PUBLICA</div>
			<div class="col-md-12">POLICIA MILITAR</div>
			<div class="col-md-12">DIRETORIA DE PESSOAL</div>
			<div class="col-md-12">FICHA DISCIPLINAR - PMRN</div>
		</div>
	</div>
	<div class="row">
	<div class="col-md-12 head">
					
						DADOS PESSOAIS
						  
					
				</div>
	<!--coluna 01 da primeira página -->
		<div class="col-md-6 borda">
			<div class="row">
				<div class="col-md-12 borda">
					<div class="d-inline">
						<strong >Nome: </strong>{{$fichaDisciplinar->qualificacao->st_nome}}
						  
					</div>
				</div>
				<div class="col-md-12 borda">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-2"><strong >Filiação: </strong></div>
							<div class="col-md-10"><strong >Mãe: </strong>{{$fichaDisciplinar->qualificacao->st_mae}}</div>
							<div class="col-md-2"><strong ></strong></div>
							<div class="col-md-10"><strong >   Pai: </strong>{{$fichaDisciplinar->qualificacao->st_pai}}</div>
						</div>
					</div>
					
				</div>
				<div class="col-md-6 borda"><strong >   SEXO : </strong>{{$fichaDisciplinar->qualificacao->st_sexo}}</div>
				<div class="col-md-6 borda"><strong >   NASCIDO EM : </strong>{{empty($fichaDisciplinar->qualificacao->dt_nascimento) ? '' : \Carbon\Carbon::parse($fichaDisciplinar->qualificacao->dt_nascimento)->format('d/m/Y')}}  </div>
				<div class="col-md-6 borda"><strong >   NATATURAL DE : </strong>{{$fichaDisciplinar->qualificacao->st_naturalidade}}</div>
				<div class="col-md-6 borda"><strong >   ESTADO CIVIL : </strong>{{$fichaDisciplinar->qualificacao->st_estadocivil}}</div>
				<div class="col-md-4 borda"><strong >   ALTURAL : </strong>{{$fichaDisciplinar->qualificacao->st_altura}}</div>
				<div class="col-md-4 borda"><strong >   COR : </strong>{{$fichaDisciplinar->qualificacao->st_cor}}</div>
				<div class="col-md-4 borda"><strong >   OLHOS : </strong>{{$fichaDisciplinar->qualificacao->st_olhos}}</div>
				<div class="col-md-6 borda"><strong >   CABELOS : </strong>{{$fichaDisciplinar->qualificacao->st_cabelos}}</div>
				<div class="col-md-12 borda"><strong >   GRAU DE INSTRUÇÃO : </strong>{{$fichaDisciplinar->qualificacao->st_escolaridade}}</div>
				<div class="col-md-6 borda"><strong >   TIPO SANGUINEO : </strong>{{$fichaDisciplinar->qualificacao->st_tiposanguineo}}{{$fichaDisciplinar->qualificacao->st_fatorrh}}</div>
				<div class="col-md-6 borda"><strong >  NOME DE GUERRA : </strong>{{$fichaDisciplinar->qualificacao->st_nomeguerra}}</div>
				<div class="col-md-12">
						<div class="row">
							<div class="col-md-12 head">INCLUSÃO E EXCLUSÃO</div>
							<div class="col-md-6"><strong >DATA DE INCLUSAO: </strong>{{empty($fichaDisciplinar->qualificacao->dt_incorporacao) ? '' : \Carbon\Carbon::parse($fichaDisciplinar->qualificacao->dt_incorporacao)->format('d/m/Y')}}</div>
							<div class="col-md-6"><strong >PROCEDÊNCIA: </strong>...</div>
							<div class="col-md-6"><strong >DATA DE EXCLUSÃO: </strong>{{empty($fichaDisciplinar->qualificacao->dt_inatividade) ? '' : \Carbon\Carbon::parse($fichaDisciplinar->qualificacao->dt_inatividade)->format('d/m/Y')}}</div>
						</div>
				</div>
				<div class="col-md-12">
						<div class="row">
							<div class="col-md-12 head">DOCUMENTOS APRESENTADOS</div>
							<div class="col-md-12"><strong >RG CIVIL N°: </strong>{{$fichaDisciplinar->qualificacao->st_rgcivil}}</div>
							<div class="col-md-12"><strong >CPF N°: </strong>{{$fichaDisciplinar->qualificacao->st_cpf}}</div>
							<div class="col-md-12"><strong >PIS/PASEP N°: </strong>{{$fichaDisciplinar->qualificacao->st_pispasep}}</div>
						</div>
				</div>
			</div>
		</div>
		
		<!--coluna 02 da primeira página -->
		<div class="col-md-6">
			<div class="form-group">
				<div class="row">
				  <div class="col-md-4 borda"><strong >POST/GRAD: </strong>{{$fichaDisciplinar->qualificacao->st_postograduacaosigla}}</div>
				  <div class="col-md-4 borda"><strong >NÚMERO DE PRAÇA: </strong>@if($fichaDisciplinar->qualificacao->ce_graduacao < 7){{$fichaDisciplinar->qualificacao->st_numpraca}} @endif</div>
				  <div class="col-md-4 borda"><strong >COMPORTAMENTO ATUAL: </strong>{{$fichaDisciplinar->qualificacao->st_comportamento}} </div>
				  <div class="col-md-6 borda"><strong >MATRÍCULA: </strong>{{$fichaDisciplinar->qualificacao->st_matricula}}</div>
				  <div class="col-md-6 borda"><strong >RG PM N°: </strong>{{$fichaDisciplinar->qualificacao->st_rgmilitar}}</div>
				  <div class="col-md-6 borda"><strong >TELEFONE: </strong>{{$fichaDisciplinar->qualificacao->st_telefonecelular}}</div>
				  <div class="col-md-6 borda"><strong >EMAIL: </strong>{{$fichaDisciplinar->qualificacao->st_email}}</div>
				</div>
				<div class="row">
				  <div class="col-sm-3 head">          
					CURSOS
				  </div>
				   <div class="col-md-3 head">
					BG N°
					</div>
					<div class="col-md-3 head">
						DATA
					</div>
					<div class="col-md-3 head">
						GRAU
					</div>
					@if(isset($fichaDisciplinar->cursos))
                            @forelse($fichaDisciplinar->cursos as $c)
							<div class="col-md-3 borda">
								{{$c->st_curso}}
							</div>
							<div class="col-md-3 borda">
							{{$c->st_boletim}}
							</div>
							<div class="col-md-3 borda">
							{{empty($c->dt_publicacao) ? '' : \Carbon\Carbon::parse($c->dt_publicacao)->format('d/m/Y')}}
							</div>
							<div class="col-md-3 borda">
							{{$c->st_mediafinal}}
							</div>
							@empty
							<div class="col-md-12 seminfo borda">
							Nenhuma Curso Encontrado.
							</div>
                               
                            @endforelse
                            @endif
					
					<div class="col-md-12 borda">
						ESPECIALIDADE: QPMP-0-COMBATENTE
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-9"> 
						<div class="row">
							<div class="col-md-3 head">
								PROMOCOES
							</div>
							<div class="col-md-3 head">
								BOLETIM N°
							</div>
							<div class="col-md-3 head">
								DATA
							</div>
							<div class="col-md-3 head">
								ACONTAR
							</div>
						@if(isset($fichaDisciplinar->promocoes))
                            @forelse($fichaDisciplinar->promocoes as $p)
							<div class="col-md-3 borda">
								{{$p->st_promocao}}
							</div>
							<div class="col-md-3 borda">
							{{$p->st_boletim}}
							</div>
							<div class="col-md-3 borda">
							{{empty($p->dt_boletim) ? '' : \Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y')}}
							</div>
							<div class="col-md-3 borda">
							{{empty($p->dt_promocao) ? '' : \Carbon\Carbon::parse($p->dt_promocao)->format('d/m/Y')}}
							</div>
							@empty 
							<div class="col-md-12 seminfo borda">
							Nenhuma Promoção Encontrada.
							</div>
                               
                            @endforelse
                            @endif
						</div>
					</div>
					<div class="col-sm-3 borda"> 
						<div class="row">
							@if(!empty( $imagem))
                            <img id="img" class="img" src="data:image/png;data:image/jpeg;base64,{!! $imagem !!}"  width='100' height='120' style="border:1px solid #999;">
							@endif
						</div>		
					
					</div>
				</div>
				
			</div>
		</div>
	</div>
			
	<!--SEGUNDA página -->
	<!--PUNIÇÕES -->
	<div class="row">
		<div class="col-md-12">
			
			
		
			<div class="row">
				<div class="col-md-12 head">HISTÓRICO DE PUNIÇÕES</div>
							<div class="col-md-1 head">
									BOLETIM N°
							</div>
							<div class="col-md-1 head">
								DATA
							</div>
							<div class="col-md-6 head">
								DESCRIÇÃO
							</div>
							<div class="col-md-1 head">
								COMPORTAMENTO
							</div>
							<div class="col-md-3 head">
								OBSERVAÇÃO
							</div>
							
							@if(isset($fichaDisciplinar->punicoes))
                            @forelse($fichaDisciplinar->punicoes as $p)
							<div class="col-md-1 borda">
								{{$p->st_boletim}}
							</div>
						
							<div class="col-md-1 borda">
							{{empty($p->dt_boletim) ? '' : \Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y')}}
							</div>
							<div class="col-md-6 borda">
							{!!$p->st_materia!!}
							</div>
						
							<div class="col-md-1 borda">
							{{$p->st_comportamento}}
							</div>
							<div class="col-md-3 borda">
							@if($p->st_status != "ATIVA")
							Punicão {{$p->st_status}}, no dia
							{{empty($p->dt_cancelamentoanulacao) ? '' : \Carbon\Carbon::parse($p->dt_cancelamentoanulacao)->format('d/m/Y')}}, conforme {{$p->st_boletimcancelamentoanulacao}} , datado de 
							{{empty($p->dt_boletimcancelamentoanulacao) ? '' : \Carbon\Carbon::parse($p->dt_boletimcancelamentoanulacao)->format('d/m/Y')}}
							@endif
							</div>
							@empty
							<div class="col-md-12 seminfo borda">
							Nenhuma Punição Encontrada.
							</div>
                               
                            @endforelse
							
                            @endif
							
						</div>
		</div>
	</div>
			
	<!--SEGUNDA página -->
	<!--PUNIÇÕES -->
	<div class="row">
		<div class="col-md-12">
			
			
		
			<div class="row">
				<div class="col-md-12 head">HISTÓRICO DE MEDALHAS</div>
							<div class="col-md-3 head">
								MEDALHA
							</div>
							<div class="col-md-3 head">
								TIPO
							</div>
							<div class="col-md-3 head">
								PUBLICAÇÃO
							</div>
							<div class="col-md-3 head">
								DATA DA PUBLICAÇÃO
							</div>
							@if(isset($fichaDisciplinar->medalhas))
                            @forelse($fichaDisciplinar->medalhas as $m)
							<div class="col-md-3 borda">
								{{$m->st_nome}}
							</div>
							<div class="col-md-3 borda">
								{{$m->st_tipo}}
							</div>
							<div class="col-md-3 borda">
							{{$m->st_publicacao}}
							</div>
						
							<div class="col-md-3 borda">
							{{empty($m->dt_publicacao) ? '' : \Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y')}}
							</div>
							@empty
							<div class="col-md-12 seminfo borda">
							Nenhuma Medalhas Encontrada.
							</div>
                               
                            @endforelse

                            @endif
					
							
						</div>
		</div>
	</div>
	
	<!--ELOGIO -->
	<div class="row">
		<div class="col-md-12">
			
			
		
			<div class="row">
				<div class="col-md-12 head">HISTÓRICO DE ELOGIOS</div>
							<div class="col-md-2 head">
								BG N°
							</div>
							<div class="col-md-2 head">
								DATA
							</div>
						
							<div class="col-md-8 head">
								DESCRIÇÃO
							</div>
							
							@if(isset($fichaDisciplinar->elogios))
                            @forelse($fichaDisciplinar->elogios as $e)
							<div class="col-md-2 borda">
								{{$e->st_boletim}}
							</div>
							<div class="col-md-2 borda">
							{{empty($e->dt_publicacao) ? '' : \Carbon\Carbon::parse($e->dt_publicacao)->format('d/m/Y')}}
							</div>
							<div class="col-md-8 borda">
							{!!$e->st_materia!!}
							</div>
							@empty
							<div class="col-md-12 seminfo borda">
							Nenhuma referência elogiosa Encontrada.
							</div>
                               
                            @endforelse

                            @endif
							
							
							
						</div>
		</div>
	</div>
	
			
</div>


			
			
			
			
			