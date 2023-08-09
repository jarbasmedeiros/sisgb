@extends('adminlte::dashboardTemplate')
@php
    $titulo = 'lalaa';   
@endphp

@section('title', 'Dashboard do DJD')
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
                    <small>Diretoria de Justiça e Disciplina</small>
                </h1>
            </section>
            <section class="content" style="height: auto !important; min-height: 0px !important;">
                <!-- Small boxes (Stat box) -->
                <fieldset class="scheduler-border">
                <legend class="scheduler-border">Total por situação</legend>
                <br>

                <div class="row ">       
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3>0</h3>
                    {{-- dados --}}
                    <p>Procedimentos</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                  <h3>0</h3>
                    <p>Abertos</p>
                  </div>
                  <div class="icon">
                  
                    <i class="fa fa-folder-open"></i>
                  </div>
                  <a href="" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>0</h3>
                    <p>Prorrogados</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-exclamation-triangle"></i>
                  </div>
                  {{-- @if($dashboard->nu_inativos_reformados >0) --}}
                  <a href="" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                  <div class="inner">
                  <h3>0</h3>
                    <p>Atrasados</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-hourglass-end"></i>
                  </div>
                  {{-- @if($dashboard->nu_inativos_mortos >0) --}}
                  <a href="" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </section>
            <section class="content">
                <fieldset class="scheduler-border">
                <legend class="scheduler-border">Total por dados</legend>
                <br>
                    <div>
                        <div class="col-md-8">
                                                  
                            <br>
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Novos procedimentos instaurados</h3>

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
                                            <th>TIPO</th>
                                            <th>N° SEI</th>
                                            <th>Origem</th>
                                            <th>Encarregado</th>
                                            <th>Unidade</th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                            {{-- foreach --}}
                                            @foreach($procedimentos as $value)
                                                <tr>
                                                    <td>{{$value->st_tipo}}</td>  
                                                    <td>{{$value->st_numsei}}</td>
                                                    <td>{{$value->st_origem}}</td>
                                                    <td>{{$value->st_nomeencarregado}}</td>
                                                    <td>{{$value->unidade->st_sigla}}</td>
                                                </tr>  
                                            @endforeach
                                            {{-- ENDforeach --}}
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                        
                        </div>
                        <div class="col-md-4">
                            <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Total por tipo de procedimento</legend>
                            <br>
                                <div class="info-box bg-aqua">
                                    <span class="info-box-icon"><i class="fa fa-gavel"></i></span>        
                                    <div class="info-box-content">
                                        <span class="info-box-text">CJ</span>
                                        <span class="info-box-number"></span>     
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 20%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Conselho de Justificação
                                        </span>
                                    </div>
                                </div>
                                <div class="info-box bg-aqua">
                                    <span class="info-box-icon"><i class="fa fa-gavel"></i></span>        
                                    <div class="info-box-content">
                                        <span class="info-box-text">CD</span>
                                        <span class="info-box-number"></span>     
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 20%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Conselho de Disciplina
                                        </span>
                                    </div>
                                </div>
                                <div class="info-box bg-aqua">
                                    <span class="info-box-icon"><i class="fa fa-gavel"></i></span>        
                                    <div class="info-box-content">
                                        <span class="info-box-text">PAD</span>
                                        <span class="info-box-number"></span>     
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 20%"></div>
                                        </div>
                                        <span class="progress-description">
                                           Processo Administrativo Disciplinar
                                        </span>
                                    </div>
                                </div>
                                <div class="info-box bg-yellow">
                                    <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>        
                                    <div class="info-box-content">
                                        <span class="info-box-text">PADS</span>
                                        <span class="info-box-number"></span>     
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 20%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Processo Administrativo Disciplinas Sumário
                                        </span>
                                    </div>
                                </div>
                                <div class="info-box bg-yellow">
                                    <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>        
                                    <div class="info-box-content">
                                        <span class="info-box-text">IPM</span>
                                        <span class="info-box-number"></span>     
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 20%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Inquérito Policial Militar
                                        </span>
                                    </div>
                                </div>
                                <div class="info-box bg-yellow">
                                    <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>        
                                    <div class="info-box-content">
                                        <span class="info-box-text">SINDICÂNCIA</span>
                                        <span class="info-box-number"></span>     
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 20%"></div>
                                        </div>
                                        <span class="progress-description">
                                            20% Increase in 30 Days
                                        </span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
            </section>
        </div>
    </div>

@stop