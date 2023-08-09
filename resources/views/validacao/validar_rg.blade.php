
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    <title>
        Validação de Identidade | SISDP
    </title>

    <link href="/sisdp/favicon.ico" type="image/x-icon" rel="icon"/>
    <link href="/sisdp/favicon.ico" type="image/x-icon" rel="shortcut icon"/>   
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/sisgp/css/validacao.css"/>



</head>
<body>
<div id="wrap">

    <div class="container validacao-identidade">
        <div class="row">
            <div class="col-xs-12">
                <img class="" src="/sisdp/img/logo_pmrn.PNG" alt="">
                <h2>Validação de Identidade</h2>
                <div class="cadastro" >
                @if(isset($erro) && $erro != 'Registro não encontrado')
                    <div class="alert alert-danger">
                        <strong>{{$erro}}</strong> Ops, problema na validação, retorne em outro momento.
                    </div>  
                @else
                    @if($rgValido)
                        <div class="alert alert-success">
                            <strong>Identidade confirmada!</strong> Esta identidade foi gerada pela Diretoria de Pessoal da PM-RN.
                        </div>
                        <div>
                            @if(isset($rg->st_fotorg))
                             <!--   <img class="img-thumbnail" src="url('{{$rg->st_fotorg}}')" alt="">
                                falta colocar a foto
                                -->
                                <img class="img-thumbnail" src="/prjSisGp/public/imgs/medeiros.jpg" alt="">
                            @else                             
                                <img class="img-thumbnail" src="/prjSisGp/public/imgs/default_profile.jpg" alt="">
                            @endif
                            <h4>{{$rg->st_nome}} {{$rg->st_postograduacao}} PM {{$rg->st_numpraca}}</h4>
                        </div>
                    @else 
                        <div class="alert alert-danger">
                            <strong>Identidade não encontrada!</strong> Não achamos esta identidade nos nossos registros!
                        </div>                    
                    @endif

              @endif
                    
                    <div class="alert alert-info margintop50">
                        Para maiores esclarecimentos, entre em contato com a Diretoria de Pessoal pelo telefone (84) 3232-6369
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- /container -->
    <div id="push"></div>
</div>


</body>
</html>
