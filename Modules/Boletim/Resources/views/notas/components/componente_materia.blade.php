<!-- .materia componente -->
<fieldset class="scheduler-border">
    <legend class="scheduler-border">MATÉRIA DA NOTA</legend>
    <div class="form-group">
        <div class="col-md-12">
        @if(isset($tipoNota) && $tipoNota->bo_processo==1) 
            <!--  exibe apenas o texto 
            {!!$nota->st_materia!!}
        -->
            Clique na opção VISUALIZAR para ter acesso ao texto da nota que foi gerada por um processo específico.
        @else  
            <!--  exibe area para edição -->   
            
            @if(isset($nota))
                @if($nota->st_status ==  'RASCUNHO')
                    <textarea class="ckeditor"  id="st_materia" name="st_materia" >{{(isset($nota)) ? $nota->st_materia : '' }}</textarea>
                @else
                    <textarea class="ckeditor" disabled id="st_materia" name="st_materia" >{{(isset($nota)) ? $nota->st_materia : '' }}</textarea>
                @endif
                {{-- atribuição feita para usar no CKEDITOR.replace na linha 40 --}}
                @php $notaId = $nota->id @endphp
            @else
                <textarea class="ckeditor"  id="st_materia" name="st_materia" >{{(isset($nota)) ? $nota->st_materia : '' }}</textarea>
                 {{-- atribuição feita para usar no CKEDITOR.replace na linha 40 --}}
                 @php $notaId = -1 @endphp 
            @endif  
        @endif  
        @if ($errors->has('st_materia'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $errors->first('st_materia') }}</strong>
                </div>
        @endif
        </div>
    </div>
</fieldset>

<!--  end materia componente -->
