@extends('adminlte::page')
@section('title', 'Relatório de Atendimento')
@can('Edita')
@section('content_header')
@stop
@endcan


@section('content')

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Exportar Relatório de Atendimentos Concluídos</h3>
			</div>

			<!-- Data Inicial: -->
			<div class="box-body">
			<div class="row">
			<form action="{{url('juntamedica/relatorio/atendimentos/listagem/atendimento/lista') }}" method="get">
			{{ csrf_field() }}
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<div class="col-md-4">
                                        <label for="dt_inicio" class="col-md-4 ">Data Inicial:</label>
                                        <div class="col-md-2">
                                            <input type="date"  name="dt_inicio"  class="form-inline" required="true">
                                            @if ($errors->has('dt_inicio'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dt_inicio') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>     
							</div>
						</div>
						<!-- Data término: -->
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<div class="col-md-4">
                                        <label for="dt_termino" class="col-md-4 ">Data término:</label>
                                        <div class="col-md-2">
                                            <input type="date" name="dt_termino" class="form-inline" required="true">
                                            @if ($errors->has('dt_termino '))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dt_termino') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>     
							</div>
						</div>
						<!-- Comorbidade -->
						<div class="row">
							<div class="col-md-4 ">
								<div class=	"form-group col-lg-10"   style="   margin-left: 80px;  margin-top: 13px; ">
									<label>Cid:</label>
									<select class="form-control select2" name="ce_cid[]" multiple="multiple" data-placeholder="Selecione um ou mais cids" >
												@if(isset($relatorioAtendimento))
													@foreach($relatorioAtendimento  as $c)
														<option value="{{ $c->id}}">{{$c->st_cid}}</option>
													@endforeach
												@endif
								      </select>
								</div>
							</div>
						</div>
					
					<div class="row "  style=" padding-left: 65%; margin-right: 2%;">
						<button class="btn btn-primary center-block" ><i class="fa fa-print"></i> Gerar relatório</button>
					</div>
				</form>
			</div>
			<!-- /.box-body -->
		</div>
	</div>
</div>
@stop