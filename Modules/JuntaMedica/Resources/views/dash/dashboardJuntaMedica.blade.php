@extends('adminlte::page')

@section('title', 'Dashboard da Junta Médica')
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
          <small>Junta Médica</small>
        </h1>
        </section>
        <section class="content" style="height: auto !important; min-height: 0px !important;">

       
          <!-- Small boxes (Stat box) -->
        <fieldset class="scheduler-border">
        <legend class="scheduler-border">Estatísticas dos pacientes em acompanhamentos</legend>
        </br>
       
          <div class="row">
        
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$dashboard->nu_acompanamentototal}}</h3>

                  <p>Em acompanhamento</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{url('/juntamedica/dash/prontuarios/emAcompanhamento')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                <h3>{{$dashboard->nu_acompanamentoclinico}}</h3>

                  <p>Clinica  Médica</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-md"></i>
                </div>
                <a href="{{url('/juntamedica/dash/prontuarios/clinicaMedica')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{$dashboard->nu_acompanamentoortopetico}}</h3>

                  <p>Ortopedia</p>
                </div>
                <div class="icon">
                  <i class="fa fa-wheelchair"></i>
                </div>
                <a href="{{url('/juntamedica/dash/prontuarios/ortopedia')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                <h3>{{$dashboard->nu_acompanamentopsiquiatrico}}</h3>

                  <p>Psiquiatria</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-md"></i>
                </div>
                <a href="{{url('/juntamedica/dash/prontuarios/psiquiatria')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
      </div>

      
    <fieldset>
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Estatísticas mensais dos atendimentos</legend>
    </br>

<!-- inicio-->
<div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->
          
          <!-- /.box -->
          <div class="row">
            <div class="col-md-6">
              <!-- DIRECT CHAT -->
              
              <!--/.direct-chat -->
            </div>
            <!-- /.col -->

            <div class="col-md-6">
              <!-- USERS LIST -->
              
              <!--/.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Produtividade mensal por especialidade/órgão</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Especialidade</th>
                    <th>LTS</th>
                    <th>Restrição</th>
                    <th>Órgão</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($dashboard->atendimentos as $atendimento)   
                    <tr>
                        <td>{{$atendimento->st_especialidade}}</td>  
                        <td>{{$atendimento->st_lts}}</td>
                        <td>{{$atendimento->st_restricoes}}</td>
                        <td>{{$atendimento->st_orgao}}</td>
                    </tr>
                  @endforeach   
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
           
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
            <!-- /.info-box -->
            <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-stethoscope"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sessões</span>
              <span class="info-box-number">{{$dashboard->nu_sessoes}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: 20%"></div>
              </div>
              <span class="progress-description">
                    20% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- Info Boxes Style 2 -->
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-user-md"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Atendimentos</span>
              <span class="info-box-number">{{$dashboard->nu_atendimentos}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
              <span class="progress-description">
                    50% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
    
          <!-- /.info-box -->
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">LTS</span>
              <span class="info-box-number">{{$dashboard->nu_lts}}</span> 

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
              <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Restrições</span>
              <span class="info-box-number">{{$dashboard->nu_restricoes}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: 40%"></div>
              </div>
              <span class="progress-description">
                    40% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->

          
          <!-- /.box -->

          <!-- PRODUCT LIST -->
          
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
<!-- meio -->

<!-- fim-->

        <fieldset>
       
    </div>

@stop