<!-- .info nota componente -->
<fieldset class="scheduler-border">
        <legend class="scheduler-border">INFORMAÇÕES SOBRE O ASSUNTO DA NOTA</legend>
        <div class="form-group">
            <label for="ce_tipo" class="col-md-2 control-label">Tipo da nota</label>
            <div class="col-md-6">

            @if(isset($tipoNota) && $tipoNota->bo_processo==1)
                <select class="form-control select2" id="ce_tipo" name="ce_tipo" onchange="exibirTipoNotaSelecionado(this)" disabled>                   
            @else
                @if( !isset($nota)  )
                    <select class="form-control select2" id="ce_tipo" name="ce_tipo" onchange="exibirTipoNotaSelecionado(this)" >                   
                @elseif(isset($nota) && $nota->st_status ==  'RASCUNHO') 
                    <select class="form-control select2" id="ce_tipo" name="ce_tipo" onchange="exibirTipoNotaSelecionado(this)" >                   
                @else
                    <select class="form-control select2" id="ce_tipo" name="ce_tipo" onchange="exibirTipoNotaSelecionado(this)" disabled>                   
                @endif
            @endif
                    @if(isset($tipos))                       
                        @foreach($tipos as $t)
                            @if(!isset($nota) )
                                @if($t->bo_processo != 1)
                                    <option value="{{$t->id}}" {{((isset($nota) && ($t->id == $tipoNota->id)) || ($tipoNota != '' && $tipoNota->id == $t->id)) ? 'selected' : ''}}>{{$t->st_tipo}}</option>
                                @endif
                            @else
                                @if($nota->st_status ==  'RASCUNHO')
                                    @if($t->bo_processo != 1)
                                        <option value="{{$t->id}}" {{((isset($nota) && ($t->id == $tipoNota->id)) || ($tipoNota != '' && $tipoNota->id == $t->id)) ? 'selected' : ''}}>{{$t->st_tipo}}</option>
                                    @endif
                                @else
                                    <option value="{{$t->id}}" {{((isset($nota) && ($t->id == $tipoNota->id)) || ($tipoNota != '' && $tipoNota->id == $t->id)) ? 'selected' : ''}}>{{$t->st_tipo}}</option>
                                @endif
                            @endif
                        @endforeach                  
                    @endif
           
                </select>
            </div>
            <span class="fa fa-question-circle primary control-label" data-toggle="tooltip" title="Para cada ASSUNTO existe no sistema um tipo de formulário (denominado Tipo de Nota) específico que ajudará o sistema atualizar automaticamente as fichas dos policiais com as informações da nota quando necessário."></span>
        </div>
        <div class="form-group">
            <label for="st_assunto" class="col-md-2 control-label" >Assunto</label>
            <div class="col-md-6">
                @if($tipoNota->bo_processo==1)
                    <input type="text" class="form-control" name="st_assunto" id="st_assunto" value="{{(isset($nota)) ? $nota->st_assunto : '' }}" 
                    placeholder="Digite um Assunto" disabled   required="required">
                @else 
                    @if(isset($nota))
                        @if($nota->st_status ==  'RASCUNHO')
                            <input type="text" class="form-control" name="st_assunto" id="st_assunto" value="{{(isset($nota)) ? $nota->st_assunto : '' }}" 
                            placeholder="Digite um Assunto"    required="required">
                        @else 
                            <input type="text" class="form-control" name="st_assunto" id="st_assunto" value="{{(isset($nota)) ? $nota->st_assunto : '' }}" 
                                placeholder="Digite um Assunto"  disabled  required="required">
                        @endif
                    @elseif(!isset($nota))
                        <input type="text" class="form-control" name="st_assunto" id="st_assunto" value="{{(isset($nota)) ? $nota->st_assunto : '' }}" 
                            placeholder="Digite um Assunto"    required="required">
                    @else
                        <input type="text" class="form-control" name="st_assunto" id="st_assunto" value="{{(isset($nota)) ? $nota->st_assunto : '' }}" 
                        placeholder="Digite um Assunto" disabled  required="required"> 
                    @endif
                @endif
               
                @if ($errors->has('st_assunto'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $errors->first('st_assunto') }}</strong>
                    </div>
                @endif
            </div>
            <span class="fa fa-question-circle control-label" data-toggle="tooltip" title="O assunto é o tema sobre o qual a discussão ou o texto da nota está sendo tratado."></span>
        </div>
</fieldset>
<!-- /.info nota componente -->
