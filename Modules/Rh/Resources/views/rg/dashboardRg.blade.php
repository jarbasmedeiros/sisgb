@extends('adminlte::page')

@section('title', 'Dashboard de RG')
@can('Administrador')
@section('content_header')
<!--
    <a href="{{url('rh/orgao/create1')}}"><h1 class="btn btn-primary">Novo Órgão</h1></a>
    <a href="{{url('rh/orgaos/pdf')}}"><h1 class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Imprimir listagem</h1></a>
    -->
@stop
@endcan

@section('content')
    <div class="content">
        <div class="row">
        <section class="content-header">
      <h1>
        Dashboard
        <small>Identidades</small>
      </h1>
      
    </section>
        <section class="content" style="height: auto !important; min-height: 0px !important;">
      <!-- Small boxes (Stat box) -->
      <div class="row">
    
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$dashboard->nu_cedulasdisponiveis}}<sup style="font-size: 15px"> de {{$dashboard->nu_cedulas}}</sup></h3>

              <p>Cédulas disponíveis</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$dashboard->nu_rgsprontos}}</h3>

              <p>RGs prontos</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$dashboard->nu_impressoescomerro}}</h3>

              <p>Emissões com erros</p>
            </div>
            <div class="icon">
              <i class="fa fa-warning"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$dashboard->nu_emissoeshoje}}</h3>

              <p>RG emitidos hoje</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      </div>


       
    </div>

    <!--Modal Desativa órgão -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Exculir Órgão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR O ÓRGÃO?</b>
                    </h4>
                    <form class="form-inline" id="modalDesativa" method="post" > {{csrf_field()}}
    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Excluir</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
  
            function modalDesativa(id){
               
               $("#modalDesativa").attr("action", "{{ url('rh/orgao/destroy')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>

@stop