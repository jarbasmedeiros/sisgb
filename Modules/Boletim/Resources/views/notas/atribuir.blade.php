@extends('boletim::boletim.template_boletim')

@section('title', 'Atribuir Notas')

@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Atribuir Notas</div>
                <div class="panel-body">
                    <div class="container col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">{{count($notas)}} Nota(s) para Atribuir</legend>
                            <div class="control-group">
                                <fieldset class="scheduler-border">
                                    <div class="form-group ">
                        
                            
                        @if(count($notas)>0)
                            @foreach($notas as $p)
                            <fieldset class="scheduler-border" style="margin-top:20px;">
                                <div class="control-group col-12"><strong style='text-decoration: underline; margin-bottom: 20px'> {{$p->st_assunto}}<br/></strong></div>
                                <div class="control-group" > {!!$p->st_materia!!}</div>
                                <div class="col-12">
                                    <form class="form-group" method="post"  action="{{url('boletim/atribuirnotas/'.$idBoletim.'/'.$p->id)}}">
                                    {{csrf_field()}}
                                        <select id="ce_tipo"  required name="ce_topico" class="form-control select2" >
                                        @foreach($topicos as $t)
                                            <option value="{{$t->id}}">{{$t->st_topico}}</option>
                                        @endforeach
                                        
                                        </select>
                                        <div>
                                        <button type="submit" name="button" class="btn btn-primary" style='margin-bottom: 30px' title="Atribuir Nota">Atribuir</button>
                                       
                                </div>
                                    </form>
                                </div>
                            </fieldset>
                            @endforeach
                            
                        @else
                            <div class="control-group">Não Há notas disponíveis para boletim.</div>
                        @endif
                                    
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <div class="col-md-2 mb-05">
                                <a href='{{ url("boletim/edit/" . $idBoletim)}}' class="btn btn-warning"  title="Voltar">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

@stop

<style>
    .mb-05{
        margin-bottom: 05px;
    }
</style>
