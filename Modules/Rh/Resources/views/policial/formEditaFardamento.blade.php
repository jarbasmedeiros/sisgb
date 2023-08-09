<fieldset class="scheduler-border">
<legend class="scheduler-border">Tamanho do Fardamento</legend>
    <div class="row">
        <div class="form-group{{ $errors->has('st_cobertura') ? ' has-error' : '' }} col-md-2">
            <label for="st_cobertura">Cobertura <br> ( cm )</label>
            <select class="form-control" id="st_cobertura" name="st_cobertura" style="width: 100%;" required>
                <option value="">Selecione</option>  
                @for ($i = 52; $i < 65; $i++)
                    <option value={{$i}} {{ ($policial->st_cobertura == $i) ? 'selected' : ''}} >{{ $i }}</option>    
                @endfor      
            </select>
            @if ($errors->has('st_cobertura'))
            <span class="help-block">
                <strong>{{ $errors->first('st_cobertura') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_gandolacanicola') ? ' has-error' : '' }} col-md-2">
            <label for="st_gandolacanicola">Gandola e Canícula (numeração)</label>
            <select class="form-control" id="st_gandolacanicola" name="st_gandolacanicola" style="width: 100%;" required>
                <option value="">Selecione</option>  
                @for ($i = 1; $i < 11; $i++)
                    <option value={{$i}} {{ ($policial->st_gandolacanicola == $i) ? 'selected' : ''}} >{{ $i }}</option>    
                @endfor      
            </select>
            @if ($errors->has('st_gandolacanicola'))
            <span class="help-block">
                <strong>{{ $errors->first('st_gandolacanicola') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_camisainterna') ? ' has-error' : '' }} col-md-2">
            <label for="st_camisainterna">Camisa Interna </br></br></label>
            <select class="form-control" id="st_camisainterna" name="st_camisainterna" style="width: 100%;" required>
                <option value="">Selecione</option>    
                <option value="P" {{ ($policial->st_camisainterna == "P") ? 'selected' : ''}} >P</option>    
                <option value="M" {{ ($policial->st_camisainterna == "M") ? 'selected' : ''}} >M</option>    
                <option value="G" {{ ($policial->st_camisainterna == "G") ? 'selected' : ''}} >G</option>    
                <option value="GG" {{ ($policial->st_camisainterna == "GG") ? 'selected' : ''}} >GG</option>    
                <option value="XGG" {{ ($policial->st_camisainterna == "XGG") ? 'selected' : ''}} >XGG</option>    
                    
            </select>
            @if ($errors->has('st_camisainterna'))
            <span class="help-block">
                <strong>{{ $errors->first('st_camisainterna') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_calcasaia') ? ' has-error' : '' }} col-md-2">
            <label for="st_calcasaia">Calça e Saia <br>(numeração)</label>
            <select class="form-control" id="st_calcasaia" name="st_calcasaia" style="width: 100%;" required>
                <option value="">Selecione</option>  
                @for ($i = 35; $i < 71; $i++)
                    <option value={{$i}} {{ ($policial->st_calcasaia == $i) ? 'selected' : ''}} >{{ $i }}</option>    
                @endfor      
            </select>
            @if ($errors->has('st_calcasaia'))
            <span class="help-block">
                <strong>{{ $errors->first('st_calcasaia') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_coturnosapato') ? ' has-error' : '' }} col-md-2">
            <label for="st_coturnosapato">Coturno e Sapato <br>(numeração)</label>
            <select class="form-control" id="st_coturnosapato" name="st_coturnosapato" style="width: 100%;" required>
                <option value="">Selecione</option>  
                @for ($i = 33; $i < 51; $i++)
                    <option value={{$i}} {{ ($policial->st_coturnosapato == $i) ? 'selected' : ''}} >{{ $i }}</option>    
                @endfor      
            </select>
            @if ($errors->has('st_coturnosapato'))
            <span class="help-block">
                <strong>{{ $errors->first('st_coturnosapato') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_cinto') ? ' has-error' : '' }} col-md-2">
            <label for="st_cinto">Cinto <br>( cm )</label>
            <select class="form-control" id="st_cinto" name="st_cinto" style="width: 100%;" required>
                <option value="">Selecione</option>  
                @for ($i = 85; $i < 146; $i += 10)
                    <option value={{$i}} {{ ($policial->st_cinto == $i) ? 'selected' : ''}} >{{ $i }}</option>    
                @endfor      
            </select>
            @if ($errors->has('st_cinto'))
            <span class="help-block">
                <strong>{{ $errors->first('st_cinto') }}</strong>
            </span>
            @endif
        </div>
    </div>
</fieldset>
<fieldset class="scheduler-border">
    <legend class="scheduler-border">Orientações para o preenchimento do tamanho do fardamento</legend>
    <fieldset class="scheduler-border">
        <div class="col-md-6 center mt5">
            <img class='img-responsive borda' src="{{ asset('imgs/fardamento/medida_cabeca.jpeg') }}" width="95%" />
        </div>
        <div class="col-md-6 center mt5">
            <img class='img-responsive borda' src="{{ asset('imgs/fardamento/gandola_canicula.jpeg') }}" width="50%" />
        </div>
        <div class="col-md-12 center m5">
            <img class='img-responsive borda' src="{{ asset('imgs/fardamento/tabela_gandola_canicula.jpeg') }}" width="90%" />
        </div>
    </fieldset>
    <fieldset class="scheduler-border">
        <div class="col-md-6 center mt5">
            <img class='img-responsive borda' src="{{ asset('imgs/fardamento/calca.jpeg') }}" />
        </div>
        <div class="col-md-6 center mt5">
            <img class='img-responsive borda' src="{{ asset('imgs/fardamento/calca_altura_largura_pernas.jpeg') }}" width="97%" />
        </div>
        <div class="col-md-12 center m5">
            <img class='img-responsive borda' src="{{ asset('imgs/fardamento/tabela_calca.jpeg') }}"  width="90%" />
        </div>
    </fieldset>
</fieldset>