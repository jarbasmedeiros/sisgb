
@extends('adminlte::page')
@section('title', 'Sobre')
@section('content')


<div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>Sobre o SISGP</h2>
        <h6 class="card-subtitle mb-1 text-muted"> SISGP - Sistema Integrado de Gestão Policial </h6>
        <h6 class="card-subtitle mb-1 text-muted">Versão Atual: 2.0</h6>
      <div class="box box-solid">
      <div class="panel panel-primary">
                <legend class="scheduler-border">Novidades do sistema</legend>
      <div class="panel box box-primary">
          <div class="box-header with-border" >
              <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                      Novidades da Release 2.0  ( 16/12/2021)
                    </a>
              </h4>
          </div>
<div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
         <div class="box-body">
           
                <div class="box-header with-border">
                  <b class="box-title">Ajustes no prontuário policial</b> 
                  <div class="box-subtitle">
                     <li>Adicionado botão de excluir na aba de punição.</li>
                     <li>Padronização dos botões de editar e excluir.</li>
                     <li>Padronização das listagens.</li>
                     <li>Implantada movimentação automática integrada pelo boletim (bloqueada a movimentação manual).</li>
                     </div>
                </div>

              <div class="box-header with-border">
                  <b class="box-title">Classificador</b> 
                  <div class="box-subtitle">
                     <li>Implantada listagem que classifica policiais por ordem de antiguidade (aguardando atualização pela DP).</li>
                  </div>
              </div>

              <div class="box-header with-border">
                  <b class="box-title">Histórico de atualização</b> 
                  <div class="box-subtitle">
                    <li>Descreve as alterações no SISGP em cada atualização.</li>
                  </div>
              </div>

              <div class="box-header with-border">
                  <b class="box-title">Cadastro de dependente</b> 
                  <div class="box-subtitle">
                    <li>Disponibilizada tela para cadastro de dependentes.</li>
                  </div>
              </div>
 
  
              <div class="box-header with-border">
                  <b class="box-title">Plano de férias</b> 
                  <div class="box-subtitle">
                    <li>Criado nota de plano anual de férias integrado com prontuário do policial.</li>
                    <li>Inserção automática das turmas do plano anual de férias.</li>

                  </div>
              </div>
              <!--
              <div class="box-header with-border">
                  <b class="box-title">BG Prático</b> 
                  <div class="box-subtitle">
                    <li>Implantada  a funcionalidade que pesquisa publicações em boletins (do antigo BG prático).</li>
                  </div>  
              </div>
              -->
              <div class="box-header with-border">
                  <b class="box-title">Sugestões</b> 
                  <div class="box-subtitle">
                    <li>Implantado serviço que permite aos usuários cadastrarem sugestões de melhorias e/ou votarem naquelas mais importantes.</li>
                  </div>
              </div>
              <div class="box-header with-border">
                  <b class="box-title">Todas as Notas</b> 
                  <div class="box-subtitle">
                    <li>Adicionado o rodapé às notas de boletins.</li>
                  </div>
              </div>
              <div class="box-header with-border">
                  <b class="box-title">Alterações na nota genérica com policial  </b> 
                  <div class="box-subtitle">
                    <li>Adicionado campo personalizado que será exibido na ficha do policial.</li>
                    <li>Adicionado funcionalidade de adicionar policias em lote à nota.</li>
                    <li>Adicionado funcionalidade de excluir policiais em lote.</li>
                  </div>
              </div>
 </div>
 </div> 
 </div>     
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                      Novidades da Release 1.0
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                  
                  <div class="box-subtitle">
                    <p>  Todas as funcionalidades anteriores já implementadas.</p>
                  </div>
                  
                
               
              </div>

@endsection