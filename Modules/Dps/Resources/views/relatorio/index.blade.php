@extends('adminlte::page')

@section('title', 'Relatório de policiais')
@can('Edita')
@section('content_header')
@stop
@endcan
@section('scripts')
<script type="text/javascript" >
	$("#dt_ferias").datepicker({
		format: "mm/yyyy",
		startView: "months", 
		minViewMode: "months",
		language: "pt-BR"
	});

	function changeSelect(){
		let select = document.getElementById('seletorUnidades');
		let value = "";
		//percorre todos os elementos do Select e verifica se alguma Option está selecionada
		for(i = 0 ; i < select.options.length ; i++){
			if(select.options[i].selected){
				value = select.options[i].value;
				console.log(value);
			}	
		}
		//Verifica se o Value está vazio. Se não tiver seta as o attribute para disable. Se sim, remove o disable.		
		if(value.length == 0){
			for(i = 0 ; i < select.options.length ; i++){ 
				select.options[i].removeAttribute('disabled');
			}
		}else{
			for(i = 0 ; i < select.options.length ; i++){
				select.options[i].setAttribute('disabled', "");
				if(select.options[i].selected){
					select.options[i].removeAttribute('disabled');
				}
			}
		} 
	}
</script>
@stop

@section('content')

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Exportar Relatório</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<form action="{{ url('/dps/relatorios/filtro') }}" method="post">
					{{ csrf_field() }}
					<h3>Escolher informações que deseja extrair do policial inativo:</h3>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Dados</label>
								<select class="form-control select2" name="colunas[]" multiple="multiple" data-placeholder="Selecione os dados" style="width: 100%;">
									@if(isset($dados->colunas))
									@foreach($dados->colunas as $key => $c)
										<option value="{{$key}}">{{$c}}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
					</div>
					<h3>Filtrar policiais por:</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Unidade</label>
								<select class="form-control select2" name="ce_unidade" id="seletorUnidades" multiple="multiple" onchange="changeSelect();" data-placeholder="Selecione Unidade de lotação" style="width: 100%;">
									@can('LISTA_EFETIVO_GERAL')
									<option value="todoEfetivo" id="todoEfetivo">Todo Efetivo PM</option>
									@endcan
									<option value="unidadesFilhas" id="unidadesFilhas">Todas Unidades Subordinadas</option>
									@if(isset($dados->unidades))
										@foreach($dados->unidades as $u)
											<option class="demaisUnidades" value="{{$u->id}}">{{$u->st_nomepais}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							<label>Posto/Graduações</label>
								<select class="form-control select2" name="ce_graduacao[]" multiple="multiple" data-placeholder="Selecione o posto" style="width: 100%;">
								@if(isset($dados->graduacoes))
									@foreach($dados->graduacoes as $g)
										<option value="{{$g->id}}">{{$g->st_postograduacaosigla}}</option>
									@endforeach
								@endif
								</select>
								
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nível</label>
								<select class="form-control select2" name="st_nivel[]" multiple="multiple" data-placeholder="Selecione o nível" style="width: 100%;">
								@if(isset($dados->niveis))
									@foreach($dados->niveis as $key=> $valor)
									<option value="{{$valor}}">{{$valor}}</option>
									@endforeach
								@endif
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Comportamento</label>
								<select class="form-control select2" name="st_comportamento[]" multiple="multiple" data-placeholder="Selecione o comportamento" style="width: 100%;">
								@if(isset($dados->comportamento))
									@foreach($dados->comportamento as $key =>$c)
									<option value="{{$c}}">{{$c}}</option>
									@endforeach
								@endif
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control select2" name="ce_status[]" multiple="multiple" data-placeholder="Selecione os status" style="width: 100%;">
								@if(isset($dados->status))
									@foreach($dados->status as $s)
									<option value="{{$s->id}}">{{$s->st_nome}}</option>
									@endforeach
								@endif
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Escolaridades</label>
								<select class="form-control select2" name="st_escolaridade[]" multiple="multiple" data-placeholder="Selecione as escolaridades" style="width: 100%;">
								@if(isset($dados->escolaridades))
									@foreach($dados->escolaridades as $key => $e)
									<option value="{{$e}}">{{$e}}</option>
									@endforeach
								@endif
								</select>
							</div>
						</div>
					</div>
					<div class="row">
					
					</div>
					<button class="btn btn-primary  center-block"><i class="fa fa-print"></i> Gerar relatório</button>
				</form>
			</div>
			<!-- /.box-body -->
		</div>
	</div>
</div>
@stop