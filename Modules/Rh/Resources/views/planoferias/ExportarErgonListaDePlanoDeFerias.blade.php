 @if(isset($relacao) && count($relacao) > 0)
             @foreach($relacao as $r)
                  {{$r->st_matricula}};
                  {{$r->st_vinculo}};
                  {{$r->st_cpf}};
                  {{$r->dt_inicioperiodoaquisitorio}};
                  {{$r->dt_fimperiodoaquisitorio}};
                  {{$r->dt_inicio}};
                  {{$r->dt_fim}};
                  {{$r->st_nome}};
                  <br/>
             @endforeach
 @else 
    echo 'nenhum registro localizado.'
 @endif
