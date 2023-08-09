<html>
<head>
    <style>
        body{
            margin: 0;
            padding:0;

        }
        #identidade{
            display: block;
            margin: 0 auto;
            position: relative;
            width: 9.6625cm;
            height: 13.4625cm;
                             
           @php 
           $caminho = url("/imgs/identidade.png");
           @endphp
            background-image: url('{{$caminho}}');
            background-repeat: no-repeat;
            background-size: contain;


            font-size: 12px;
            font-weight: bold;
        }
        #identidade div.linha{position: absolute;left: 0.75cm;}
        .coluna{ float: left;}
        .coluna + .coluna{margin-left: 0.1cm;}
        .coluna_numero_registro{width: 5.85cm}
        .coluna_ts{width: 0.6cm; margin-top: -0.05cm;}
        .coluna_fator{width: 0.65cm; margin-top: -0.05cm;}
        .coluna_cpf{width: 2.9cm}
        .coluna_validade{width: 2.5cm; margin-top: 0.05cm;}

                .coluna_validade{font-size: 10px}
        
        .coluna_pertence{width: 8.6cm; font-size: 10.5px; text-align: center}
        .coluna_matricula{width: 4cm; margin-top: -0.05cm;}
        .coluna_filiacao{width: 8.6cm}
        .coluna_nascimento{width: 6.75cm; font-size: 10px; margin-top: 0.05cm;}
        .coluna_ric{width: 2.25cm}
        .coluna_pis{width: 2.5cm; margin-top: 0.05cm;}
        .coluna_prom{width: 1.58cm; margin-top: 0.05cm;}
        .coluna_cnh{width: 2.3cm; margin-top: 0.05cm;}
        .coluna_titulo{width: 2.03cm; margin-top: 0.05cm;}
        #coluna_fd{    width: 1.45cm;
            font-size: 9px;
            margin-left: 0.8cm;
            margin-top: -0.12cm;}
        .coluna_doc_origem{width: 5.05cm;font-size: 9.5px; margin-top: 0.05cm;}
        .coluna_local_data{width: 5.55cm; margin-top: 0.05cm;}
        .coluna_chefe{width: 7.5cm;font-size: 9.2px; margin-top: 0.03cm;}

        #coluna_foto{width: 2.55cm; height: 3.65cm;top: 0.45cm; left: 6.55cm; position: absolute; }
                #coluna_foto{display: none}
        


        .linha1{top: 2.67cm; }
        .linha2{top: 3.3cm;}
        .linha3{top: 3.8cm;}
        .linha4{top: 4.48cm;}
        .linha5{top: 6.8cm;}
        .linha6{top: 7.82cm;}
        .linha7{top: 8.36cm;}
        .linha8{top: 9cm;}
        .linha9{top: 9.65cm;}
        .linha10{top: 10.8cm; font-size: 11px}
        .linha11{top: 11.74cm;}
        #linha_qrcode{top: 7.67cm; left: 10cm}
        #linha_polegar{top: 9.15cm; left: 7cm; -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            transform: rotate(90deg);
            width: 1.95cm;
            height: 2.8cm;
            }
        #linha_polegar{display: none}
        

.btnVoltar {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;

    border-radius: 3px;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: 1px solid transparent;
    background-color: #f39c12;
    border-color: #e08e0b;
}


}
    </style>
</head>

<body>
<div id="identidade">
            

    <div id="coluna_foto">
                <img style="width: 2.55cm; height: 3.65cm;" src="/sisdp/img/default_profile.jpg" alt="">
    </div>

    <div class="linha linha1">
        <div class="coluna coluna_numero_registro">{{$dadosDaIdentidade->st_rgmilitar}} - {{$dadosDaIdentidade->dt_incorporacao}}</div>
    </div>
    <div class="linha linha2">
        <div class="coluna coluna_ts">{{$dadosDaIdentidade->st_tiposanguineo}}</div>
        <div class="coluna coluna_fator">{{$dadosDaIdentidade->st_fatorrh}}</div>
        <div class="coluna coluna_matricula">{{$dadosDaIdentidade->st_matricula}}</div>
    </div>
    <div class="linha linha3">
        <div class="coluna coluna_cpf">{{$dadosDaIdentidade->st_cpf}}</div>
        <div class="coluna coluna_validade">INDETERMINADA</div>
    </div>
    <div class="linha linha4">
        <div class="coluna coluna_pertence">
        {{$dadosDaIdentidade->st_nome}}<br />
        {{$dadosDaIdentidade->st_graduacao}} PM 
       
            @if(in_array($dadosDaIdentidade->st_motivo, array('R1','R2','REFORMAIDADE','REFORMAINVALIDEZ')))
                @if($dadosDaIdentidade->st_motivo == 'R1')
                    R/1
                @elseif($dadosDaIdentidade->st_motivo == 'R2')
                    R/2                
                @else 
                    Reformado
                @endif
            @else 
              {{$dadosDaIdentidade->st_numpraca}}
            @endif       
       
         <br/>
        {{$dadosDaIdentidade->st_naoassinarg}}
    </div>
    </div>
    <div class="linha linha5">
        <div class="coluna coluna_filiacao">
            {{$dadosDaIdentidade->st_mae}}<br />
            {{$dadosDaIdentidade->st_pai}}        
        </div>
    </div>
    <div id="linha_qrcode" class="linha" style="left: 7.43cm">
    {!! QrCode::size(60)->generate($urlValidacao); !!}                                             
        <!-- <img style="width: 1.72cm; height: 1.72cm;" src="{{route('qrcode',['localizador'=>$localizador])}}" alt=""> -->
    </div>
    <div id="linha_polegar" class="linha" style="left: 6.57cm">
                <img class="image" style="width: 100%;" src="/sisdp/img/default_polegar.png" alt="">
    </div>
    <div class="linha linha6">
        <div class="coluna coluna_nascimento">
        {{$dadosDaIdentidade->st_naturalidade}}, {{$dadosDaIdentidade->dt_nascimento}}        </div>
    </div>
    <div class="linha linha7">
        <div class="coluna coluna_ric">
        @if(empty($dadosDaIdentidade->st_ric))
        -xxx-
        @else 
            {{$dadosDaIdentidade->st_ric}}  
        @endif      
        </div>
        <div class="coluna coluna_pis">
        {{$dadosDaIdentidade->st_pispasep}}        </div>
        <div class="coluna coluna_prom">
        {{$dadosDaIdentidade->dt_promocao}}        </div>
    </div>
    <div class="linha linha8">
        <div class="coluna coluna_cnh">
        {{$dadosDaIdentidade->st_cnh}}        </div>
        <div class="coluna coluna_titulo">
        {{$dadosDaIdentidade->st_titulo}}        </div>
        <div class="coluna coluna_fd" id="coluna_fd">
        {{$dadosDaIdentidade->st_fdd}} <br/>
        {{$dadosDaIdentidade->st_fde}}        </div>
    </div>
    <div class="linha linha9">
        <div class="coluna coluna_doc_origem">
        {{$dadosDaIdentidade->st_registrocivil}}
                   </div>
    </div>
    <div class="linha linha10">
        <div class="coluna coluna_local_data">
        {{$dadosDaIdentidade->st_localedata}}        </div>
    </div>
    <div class="linha linha11">
        <div class="coluna coluna_chefe">
        {{$dadosDaIdentidade->st_signatario}}           </div>
    </div>
</div>
<!--
<div >
            <a class="btnVoltar" href="{{url('rh/policiais/'.$idPolicial.'/rg/'.$idRg.'/edit')}}">Voltar</a>
</div>
-->
</body>
</html>