@extends('adminlte::page')

@section('title', 'Movimentações')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
             <div class="panel-heading">
                Efetivo para movimentação em lote
             </div>
            <div class="panel-body">
                <div style='text-align:left;background-color:lightgray;padding:10px;border-radius:5px;'>
                    <form action="{{ route('importaEfetivoParaMovimentacaoExcel') }}" role="form" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <p><strong>Faça o upload da planilha padrão (Excel): anexando-a e clicando em "Enviar Planilha".</strong>
                            <br>
                            <br>
                                 O nome da planilha deve ser <b> movimentacao_efetivo_em_lote.xlsx </b>
                            <br>
                            <br>
                            <input id='arquivo' type="file" class="form-control-file" name='arquivo' required>
                         <br>
                        <div style='text-align: center'>
                        <button type='submit' class='btn btn-primary'>Enviar Planilha</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection