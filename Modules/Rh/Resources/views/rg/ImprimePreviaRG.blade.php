@extends('rh::layouts.master')
@section('title', 'SISGP - Identidades')
@section('content')

@section('style')
   
@endsection
<head>
<style>
*{
    margin: 0;
    padding: 0;
    border: 0;
}
div {
    border-style: solid;
    border-width: thin;
    
}

#imagemRg {
    float:left;
 }
#conteiner {
    

}
/**
    background-color:#e6f7ff;
    background-image:url({{'http://10.9.192.101/prjSisGp/public/imgs/bg_rg_m2.png'}});
   
    
}
**/
</style>
<h1>Previsualização da Identidade</h1>
<div id="imagemRg">
    <img src="{{url('imgs/bg_rg_m2.png')}}" alt="RG" width="430" height="600"/>  
</div>
<div id="conteiner" >
    <div id="line1_cel1">
        {{$rg->st_rgmilitar}}  {{\Carbon\Carbon::parse($rg->dt_inclusao)->format('d/m/Y')}} 
    </div>
    <div class="row2">
       
    </div>
    <div class="row">
        {{$rg->st_cpf}}
        INDETERMINADA
    </div>
    <div class="row">
        {{strtoupper($rg->st_nome)}}
        {{strtoupper($rg->st_graduacao)}}
        {{strtoupper($rg->st_numpraca)}}

    </div>
    <div class="row">
        {{$rg->st_mae}}
        {{$rg->st_pai}}
    </div>
    <div class="row">
        {{$rg->st_naturalidade}}
        {{\Carbon\Carbon::parse($rg->dt_nascimento)->format('d/m/Y')}}         
     
    </div>
    <div class="row">
        -xxx-
        {{$rg->st_pispasep}}
        {{$rg->dt_promocao}}        
    </div>
    <div class="row">
        {{$rg->st_cnh}}
        {{$rg->st_titulo}}        
        {{$rg->st_fdd}}        
        {{$rg->st_fde}}        
    </div>
    <div class="row">
        documento de origem
    </div>
    <div class="row">
        {{$rg->st_localedata}}        
    </div>
    <div class="row">
        {{$rg->st_signatario}}        
    </div>
</div>

  <!--
<div class='brasao'>
       <img  src="URL::asset('/imgs/bg_rg_m2.png')" width='60' height='60' alt='logo'/>
</div>

<td style="width:400px">350px</td>
<img src="{{url('imgs/bg_rg_m2.png')}}" alt="RG" width="100" height="60"/>  


<table border="1">
<tbody >

<tr>
    <td>
        {{$rg->st_rgmilitar}} {{$rg->dt_inclusao}}
    </td>
    <td>
       imagem
    </td>
</tr>
<tr >
    <td>
        {{$rg->st_tiposanguineo}}
        </td>
    <td>
        {{$rg->st_fatorrh}}
    </td>
    <td>
        {{$rg->st_matricula}}
    </td>
</tr>
<td >350px</td>
<td >350px</td>
<td >350px</td>
<td >350px</td>
<tr>
    <td>
       
    </td>
</tr>
<tr>
    <td>
    fdsfasd
    </td>
</tr>
</tbody>
</table>

      -->
    
                    <img src="https://memegenerator.net/img/images/15161270.jpg" alt="RG" width="50" height="50"/>  
                   
                    <img src="https://media.istockphoto.com/photos/thumb-fingerprint-picture-id490612827" alt="RG" width="40" height="60"/>  
                
    
  
                    <img src="https://www.kaspersky.com/content/en-global/images/repository/isc/2020/9910/a-guide-to-qr-codes-and-how-to-scan-qr-codes-2.png" alt="RG" width="50" height="50"/>      

</div>
<!-- /.tab-pane -->
@endsection