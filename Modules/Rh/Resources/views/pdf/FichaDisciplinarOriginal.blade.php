 <!-- Bootstrap 3.3.7 -->
 <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="/sisdp/css/bootstrap.css"/>
<style>
    #impressao {
        margin-top: 50px;
        line-height: normal;
    }
    #impressao [class*="span"] {
        float: left;
        min-height: 1px;
        margin-left: 0px;


    }
    #impressao .row {margin-left: 0px}
    #impressao p {margin-left: 5px}

    .dadospessoais, .dadosfuncionais, .dadosescolares {
        border: 1px solid;
        margin-bottom: 40px
    }    


    .fotoimpressao {      
        height: 150px;
        width: 159px;
        margin: auto;
    }
    .fotoimpressao img {display: block; margin: 5px auto;}
    .infopessoais1 {

    }
    .titulo {font-size: 0.6em; margin-bottom: 2px}
    .titulovalue {}
    .borderright {border-right: 1px solid}
    .borderleft {border-left: 1px solid}
    .bordertop {border-top: 1px solid}
    .borderbotton {border-bottom: 1px solid}
    .borderbottonright{border-bottom: 1px solid; border-right: 1px solid}
    .borderfull {border: 1px solid}


</style>

<div class="container" id="impressao">
    <div class="dadospessoais">

        <div class="span12">
            <div class="span2 fotoimpressao">
                            </div>
            <div class="span10 infopessoais1">
                <div class="row borderbotton">
                    <div class="span7 borderleft borderright">
                        <p class="titulo">NOME</p>
                        <p class="titulovalue">SEBASTIÃO CARLOS DE MEDEIROS</p>

                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">DATA NASCIMENTO</p>
                        <p class="titulovalue">20/01/1983</p>
                    </div>
                    <div class="span1_5">
                        <p class="titulo">SEXO</p>
                        <p class="titulovalue">MASCULINO</p>
                    </div>
                </div>
                <div class="row borderbotton borderleft">
                    <div class="span2 borderright">
                        <p class="titulo">TIPO SANGUÍNEO</p>
                        <p class="titulovalue">O</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">FATOR RH</p>
                        <p class="titulovalue">+</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">NACIONALIDADE</p>
                        <p class="titulovalue">BRASILEIRA</p>
                    </div>
                    <div class="span3 borderright" style="width : 290px">
                        <p class="titulo">NATURALIDADE</p>
                        <p class="titulovalue">CAICÓ</p>
                    </div>
                    <div class="span1">
                        <p class="titulo">UF</p>
                        <p class="titulovalue">RN</p>
                    </div>
                </div>

                <div class="row borderbotton borderleft">
                    <div class="span10">
                        <p class="titulo">FILIAÇÃO - NOME DO PAI</p>
                        <p class="titulovalue">DOMINGOS VALE DE MEDEIROS&nbsp;</p>
                    </div>
                </div>
                <div class="row  borderleft">
                    <div class="span10">
                        <p class="titulo">FILIAÇÃO - NOME DA MÃE</p>
                        <p class="titulovalue">ANA MARIA DE MEDEIROS&nbsp;</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="row borderbotton">
            <div class="span7 borderright bordertop">
                <p class="titulo">ENDEREÇO</p>
                <p class="titulovalue">Adeodato José dos Reis&nbsp;</p>
            </div>
            <div class="span1 borderright bordertop">
                <p class="titulo">NUMERO</p>
                <p class="titulovalue">50&nbsp;</p>
            </div>
            <div class="span4 bordertop" style="width : 336px">
                <p class="titulo">COMPLEMENTO</p>
                <p class="titulovalue">&nbsp;</p>
            </div>
        </div>
        <div class="row borderbotton">
            <div class="span5 borderright">
                <p class="titulo">BAIRRO</p>
                <p class="titulovalue">Nova Parnamirim&nbsp;</p>
            </div>
            <div class="span2 borderright" style="width: 90px">
                <p class="titulo">CEP</p>
                <p class="titulovalue">59.152-820&nbsp;</p>
            </div>
            <div class="span5 borderright">
                <p class="titulo">CIDADE</p>
                <p class="titulovalue">PARNAMIRIM&nbsp;</p>
            </div>
            <div class="span">
                <p class="titulo">UF</p>
                <p class="titulovalue">RN&nbsp;</p>
            </div>
        </div>

        <div class="row borderbotton">
            <div class="span2 borderright">
                <p class="titulo">TELEFONE RESIDENCIAL</p>
                <p class="titulovalue">&nbsp;</p>
            </div>
            <div class="span2 borderright">
                <p class="titulo">TELEFONE CELULAR</p>
                <p class="titulovalue">99843-0777 &nbsp;</p>
            </div>
            <div class="span">
                <p class="titulo">E-MAIL</p>
                <p class="titulovalue">SMEDEIRORN@HOTMAIL.COM&nbsp;</p>
            </div>

        </div>

        <div class="row borderbotton">
            <div class="span3 borderright">
                <p class="titulo">CPF</p>
                <p class="titulovalue">00899101410&nbsp;</p>
            </div>
            <div class="span3 borderright">
                <p class="titulo">REGISTRO GERAL</p>
                <p class="titulovalue">&nbsp;</p>
            </div>
            <div class="span3 borderright">
                <p class="titulo">ORGÃO EMISSOR</p>
                <p class="titulovalue">&nbsp;</p>
            </div>

            <div class="span">
                <p class="titulo">DATA DE EMISSÃO</p>
                <p class="titulovalue">&nbsp;</p>
            </div>

        </div>

        <div class="row borderbotton">
            <div class="span5 borderright">
                <p class="titulo">ESTADO CIVIL</p>
                <p class="titulovalue">Casado&nbsp;</p>
            </div>            
            <div class="span">
                <p class="titulo">CÔNJUGUE</p>
                <p class="titulovalue">MÔNICA JANAÍNA DA SILVA&nbsp;</p>
            </div>

        </div>

        <div class="row borderbotton">
            <div class="span3 borderright">
                <p class="titulo">TÍTULO ELEITORAL</p>
                <p class="titulovalue">020938591643&nbsp;</p>
            </div>
            <div class="span1 borderright">
                <p class="titulo">ZONA</p>
                <p class="titulovalue">025&nbsp;</p>
            </div>
            <div class="span1 borderright">
                <p class="titulo">SESSÃO</p>
                <p class="titulovalue">058&nbsp;</p>
            </div>
            <div class="span5 borderright">
                <p class="titulo">CIDADE</p>
                <p class="titulovalue">CAICÓ&nbsp;</p>
            </div>
            <div class="span1 borderright">
                <p class="titulo">UF</p>
                <p class="titulovalue">RN&nbsp;</p>
            </div>
            <div class="span">
                <p class="titulo">DATA DE EMISSÃO</p>
                <p class="titulovalue">12/11/2015&nbsp;</p>
            </div>

        </div>

        <div class="row">
            <div class="span3 borderright">
                <p class="titulo">CNH</p>
                <p class="titulovalue">03645285362&nbsp;</p>
            </div>
            <div class="span1 borderright">
                <p class="titulo">CATEGORIA</p>
                <p class="titulovalue">AB&nbsp;</p>
            </div>
            <div class="span2 borderright">
                <p class="titulo">DATA DE EMISSÃO</p>
                <p class="titulovalue">12/07/2013&nbsp;</p>
            </div>
            <div class="span2 borderright">
                <p class="titulo">DATA DE VALIDADE</p>
                <p class="titulovalue">04/07/2018&nbsp;</p>
            </div>            
            <div class="span1 borderright">
                <p class="titulo">UF</p>
                <p class="titulovalue">RN&nbsp;</p>
            </div>
            <div class="span">
                <p class="titulo">NIS (PIS/PASEP)</p>
                <p class="titulovalue">19020649194&nbsp;</p>
            </div>

        </div>

    </div>
    <!-- FIM DOS DADOS PESSOAIS -->

    <!-- INICIO DOS DADOS FUNCIONAIS -->
    <h4>DADOS FUNCIONAIS</h4>
    <div class="dadosfuncionais">
        <div class="row show-grid borderbotton">
            <div class="span2 borderright">
                <p class="titulo">MATRÍCULA</p>
                <p class="titulovalue">1761480&nbsp;</p>
            </div>
            <div class="span3 borderright">
                <p class="titulo">NOME DE GUERRA</p>
                <p class="titulovalue">C. MEDEIROS&nbsp;</p>
            </div>
            <div class="span1_5 borderright" style="width : 110px">
                <p class="titulo">POSTO/GRADUAÇÃO</p>
                <p class="titulovalue">3º Sargento PM&nbsp;</p>
            </div>
            <div class="span3 borderright">
                <p class="titulo">ESPECIALIZAÇÃO</p>
                <p class="titulovalue">QPMP-0-COMBATENTE&nbsp;</p>
            </div>       
            <div class="span">
                <p class="titulo">COMPORTAMENTO</p>
                <p class="titulovalue">EXCEPCIONAL&nbsp;</p>
            </div>       

        </div>

        <div class="row ">
            <div class="span2 borderright">
                <p class="titulo">DATA DE INCORPORAÇÃO (PM)</p>
                <p class="titulovalue">06/12/2004&nbsp;</p>
            </div>
            <div class="span2 borderright">
                <p class="titulo">DATA DE INCLUSÃO</p>
                <p class="titulovalue">&nbsp;</p>
            </div>      
            <div class="span2 borderright">
                <p class="titulo">NÚMERO DE PRAÇA</p>
                <p class="titulovalue">20040056&nbsp;</p>
            </div>
            <div class="span6">
                <p class="titulo">OPM</p>
                <p class="titulovalue">SESED -> SESED - ADM&nbsp;</p>
            </div>            


        </div>

    </div>
    <!--  -->
    <h4>DADOS ACADÊMICOS</h4>
    <p style='margin-bottom : 30px'>Nenhuma curso cadastrado para este funcionário.</p>
    <h4>FÉRIAS</h4>
    <p>Nenhuma Férias Lançada</p>
    <h4>LICENÇAS</h4>
    <p>Nenhuma Licença Lançada</p>

            <h4>DADOS DISCIPLINARES</h4>
        <div class="dadosescolares" style="border-bottom : none">
                <div class="row borderbotton">
                    <div class="span2 borderright">
                        <p class="titulo">TIPO</p>
                        <p class="titulovalue">Movimentação&nbsp;</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">BG</p>
                        <p class="titulovalue">171/2007</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">DATA DO BG</p>
                        <p class="titulovalue">10/09/2007</p>
                    </div>                           
                    <div class="span">
                        <p class="titulo">OBSERVAÇÃO</p>
                        <p class="titulovalue">Portaria n.º 2605/2007-DP-2 datada de 10 de setembro de 2007.
                            O CHEFE DO ESTADO-MAIOR GERAL DA POLÍCIA MILITAR usando das atribuições que lhe confere o artigo 12, alínea “c”, do Decreto Nº 8.330, de 02 de fevereiro de 1982, resolve movimentar os policiais-militares abaixo relacionados:</p>
                    </div>                           
                </div>

                <div class="row borderbotton">
                    <div class="span2 borderright">
                        <p class="titulo">TIPO</p>
                        <p class="titulovalue">Movimentação&nbsp;</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">BG</p>
                        <p class="titulovalue">165/2016</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">DATA DO BG</p>
                        <p class="titulovalue">02/09/2016</p>
                    </div>                           
                    <div class="span">
                        <p class="titulo">OBSERVAÇÃO</p>
                        <p class="titulovalue">MOVIMENTAÇÕES DE PRAÇAS
                        O CHEFE DO ESTADO-MAIOR GERAL DA POLÍCIA MILITAR DO ESTADO DO RIO GRANDE DO NORTE, usando das atribuições que lhe confere o artigo 11, § 2º, da Lei Complementar Nº 090, de 04 de janeiro de 1991, combinado com o artigo 5º, §1º, letra “b”, item 2, e artigo 12, alínea “c”, do Decreto Estadual Nº 8.330, de 02 de fevereiro de 1982;
                            Considerando a necessidade de efetuar ajustes para um melhor funcionamento das Organizações Policiais Militares, a fim de adequar o quantitativo de recursos humanos disponíveis, garantindo a funcionalidade de tais unidades.</p>
                    </div>                           
                </div>

                <div class="row borderbotton">
                    <div class="span2 borderright">
                        <p class="titulo">TIPO</p>
                        <p class="titulovalue">Movimentação&nbsp;</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">BG</p>
                        <p class="titulovalue">168/2016</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">DATA DO BG</p>
                        <p class="titulovalue">09/09/2016</p>
                    </div>                           
                    <div class="span">
                        <p class="titulo">OBSERVAÇÃO</p>
                        <p class="titulovalue">MOVIMENTAÇÃO DE PRAÇAS
                            O CHEFE DO ESTADO-MAIOR GERAL DA POLÍCIA MILITAR DO ESTADO DO RIO GRANDE DO NORTE, usando das atribuições que lhe confere o artigo 11, § 2º, da Lei Complementar Nº 090, de 04 de janeiro de 1991, combinado com o artigo 5º, §1º, letra “b”, item 2, e artigo 12, alínea “c”, do Decreto Estadual Nº 8.330, de 02 de fevereiro de 1982;</p>
                    </div>                           
                </div>

                <div class="row borderbotton">
                    <div class="span2 borderright">
                        <p class="titulo">TIPO</p>
                        <p class="titulovalue">Movimentação&nbsp;</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">BG</p>
                        <p class="titulovalue">042</p>
                    </div>
                    <div class="span2 borderright">
                        <p class="titulo">DATA DO BG</p>
                        <p class="titulovalue">06/03/2017</p>
                    </div>                           
                    <div class="span">
                        <p class="titulo">OBSERVAÇÃO</p>
                        <p class="titulovalue">AGREGAÇÃO DE PRAÇAS: O DIRETOR DE PESSOAL DA POLÍCIA MILITAR DO ESTADO DO RIO GRANDE DO NORTE, usando das atribuições que lhe confere o artigo 15, da Lei Complementar N° 090, de 04 de janeiro de 1991, combinado com o § 1º, inciso I, e § 2º, do artigo 77 e § 1º, artigo 79, da Lei N° 4.630, de 16 de dezembro de 1976 e com o inciso I, artigo 1º, da Resolução Administrativa Nº 005/2016-GCG, de 21 de julho de 2016, publicada no Diário Oficial do Estado de 22 de julho de 2016 – Edição 13.727, transcrita no BG Nº 135, de 22 de julho de 2016,
                        RESOLVE:
                        1. AGREGAR ao respectivo quadro o militar abaixo, a contar de 04 de janeiro de 2017, por haver passado à disposição da Secretaria de Estado da Segurança Pública e da Defesa Social - SESED, ficando adido à Diretoria de Pessoal – DP/2, conforme publicação no Boletim Geral Nº 003, de 04 de janeiro de 2017.
                        - Cabo QPMP-0 (Combatente) Nº 2004.0056 Sebastião Carlos de Medeiros, Matrícula nº 176.148-0.
                        2. À Ajudância Geral a publicação em BG, e, em seguida, à Diretoria de Pessoal - DP/2 para fins de arquivamento.</p>
                    </div>                           
                </div>

            </div>
    </div>
