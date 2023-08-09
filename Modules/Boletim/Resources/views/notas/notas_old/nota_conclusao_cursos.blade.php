<fieldset class="scheduler-border">
	<legend class="scheduler-border">INFORMAÇÕES DO CURSO</legend>
	<div class="form-group">
		<div class="form-row{{$errors->has('tipo_curso') ? 'has-error' : ''}} col-md-2">
			<label for="tipo_curso" class="control-label">Tipo do Curso</label>
			<select id="tipo_curso" name="tipo_curso" class="form-control" style="width: 100%;">
				<option value="" selected>Selecione</option>
				<option>Formação / Aperfeiçoamento</option>
				<option>Aprimoramento Acadêmico</option>
				<option>Aplicado a CASERNA</option>
				<option>Outros</option>
			</select>
			@if($errors->has('tipo_curso'))
				<span class="help-block">
					<strong>{{$errors->first('tipo_curso')}}</strong>
				</span>
			@endif
		</div>
		<div class="form-row{{$errors->has('tipo_academico') ? 'has-error' : ''}} col-md-2">
			<label for="tipo_academico" class="control-label">Tipo Acadêmico</label>
			<select id="tipo_academico" name="tipo_academico" class="form-control" style="width: 100%;">
				<option value="" selected>Selecione</option>
				<option>Formação / Aperfeiçoamento</option>
				<option>Aprimoramento Acadêmico</option>
				<option>Aplicado a CASERNA</option>
				<option>Outro</option>
			</select>
			@if($errors->has('tipo_academico'))
				<span class="help-block">
					<strong>{{$errors->first('tipo_academico')}}</strong>
				</span>
			@endif
		</div>
		<div class="form-row{{$errors->has('nome_curso') ? 'has-error' : ''}} col-md-3">
			<label for="nome_curso" class="control-label">Curso</label>
			<input id="nome_curso" type="text" class="form-control" name="nome_curso" value="" placeholder="Digite seu Curso">
			@if($errors->has('nome_curso'))
				<span class="help-block">
					<strong>{{$errors->first('nome_curso')}}</strong>
				</span>
			@endif
		</div>
		<div class="form-row{{$errors->has('selecionar_curso') ? 'has-error' : ''}} col-md-3">
			<label for="selecionar_curso" class="control-label">Curso</label>
			<select id="selecionar_curso" name="selecionar_curso" class="form-control" style="width: 100%;">
				<option value="" selected>Selecione</option>
				<optgroup label="Anteriores">
					<option>CFSD - Curso de Soldado</option>
					<option>CFC - Curso de Cabo</option>
					<option>CNP - Curso de Nivelamento</option>
					<option>EHS - Estágio de Habalitação de Sargento</option>
				</optgroup>
				<optgroup label="Atuais">
					<option>CFP - Curso de Formação de Praça</option>
					<option>CFS - Curso de Formação de Sargento</option>
					<option>CAS - Curso de Aperfeiçoamento de Sargento</option>
				</optgroup>
			</select>
			@if($errors->has('selecionar_curso'))
				<span class="help-block">
					<strong>{{$errors->first('selecionar_curso')}}</strong>
				</span>
			@endif
		</div>
	</div>
	<div class="form-group">
		<div class="form-row{{$errors->has('dt_inicio') ? 'has-error' : ''}} col-md-2">
			<label for="dt_inicio" class="control-label">Data de Início</label>
			<input id="dt_inicio" type="date" class="form-control" name="dt_inicio" value="">
			@if($errors->has('dt_inicio'))
				<span class="help-block">
					<strong>{{$errors->first('dt_inicio')}}</strong>
				</span>
			@endif
		</div>
		<div class="form-row{{$errors->has('dt_termino') ? 'has-error' : ''}} col-md-2">
			<label for="dt_termino" class="control-label">Data de Término</label>
			<input id="dt_termino" type="date" class="form-control" name="dt_termino" value="">
			@if($errors->has('dt_termino'))
				<span class="help-block">
					<strong>{{$errors->first('dt_termino')}}</strong>
				</span>
			@endif
		</div>
		<div class="form-row{{$errors->has('carga_horaria') ? 'has-error' : ''}} col-md-1">
			<label for="carga_horaria" class="control-label">Carga Horária</label>
			<input id="carga_horaria" type="number" class="form-control" name="carga_horaria" value="5">
			@if($errors->has('carga_horaria'))
				<span class="help-block">
					<strong>{{$errors->first('carga_horaria')}}</strong>
				</span>
			@endif
		</div>
		<div class="form-row{{$errors->has('instituicao') ? 'has-error' : ''}} col-md-5">
			<label for="instituicao" class="control-label">Instituição</label>
			<input id="instituicao" type="text" class="form-control" name="instituicao" value="" placeholder="Digite seu Curso">
			@if($errors->has('instituicao'))
				<span class="help-block">
					<strong>{{$errors->first('instituicao')}}</strong>
				</span>
			@endif
		</div>
	</div>
</fieldset>
<fieldset class="scheduler-border">
	<legend class="scheduler-border">NOTA DE CONCLUSÃO DE CURSO</legend>
	@include('boletim::notas/addPolicial')
</fieldset>