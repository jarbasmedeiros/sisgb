function SomenteNumero(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla > 47 && tecla < 58)) return true;
    else {
        if (tecla == 8 || tecla == 0) return true;
        else return false;
    }
}

function RemoverCampos() {
    var parecer = document.getElementById("st_parecer").value;
    if (parecer == "APTO") {
        $("#st_restricao").empty();
        $("#st_motivo").empty();
        $("#dt_inicio").empty();
        $("#nu_dias").empty();
        $("#dt_termino").empty();
        $('#div_st_restricao').hide();
        $('#div_st_motivo').hide();
        $('#div_dt_inicio').hide();
        $('#div_nu_dias').hide();
        $('#div_dt_termino').hide();
    } else if (parecer == "APTO COM RESTRIÇÃO") {
        $("#st_restricao").empty();
        $("#st_restricao").append('<option value="">--Selecionar--</option>')
        $("#st_restricao").append('<option value="Usar arma">Usar arma</option>')
        $("#st_restricao").append('<option value="Serviço ostensivo">Serviço ostensivo</option>')
        $("#st_restricao").append('<option value="Serviço noturno">Serviço noturno</option>')
        $("#st_restricao").append('<option value="Instrução">Instrução</option>')
        $("#st_restricao").append('<option value="Educação física">Educação física</option>')
        $("#st_restricao").append('<option value="Escala">Escala</option>')
        $("#st_restricao").append('<option value="Esforço físico">Esforço físico</option>')
        $("#st_restricao").show();
        $("#st_motivo").empty();
        $("#dt_inicio").empty();
        $("#nu_dias").empty();
        $("#dt_termino").empty();
        $('#div_st_motivo').hide();
        $('#div_dt_inicio').hide();
        $('#div_nu_dias').hide();
        $('#div_dt_termino').hide();
    } else if (parecer == "LICENÇA A. FAMILIAR" || parecer == "INAPTO") {
        $("#st_restricao").empty();
        $("#st_restricao").append('<option value="">--Selecionar--</option>')
        $("#st_restricao").append('<option value="Usar arma">Usar arma</option>')
        $("#st_restricao").append('<option value="Serviço ostensivo">Serviço ostensivo</option>')
        $("#st_restricao").append('<option value="Serviço noturno">Serviço noturno</option>')
        $("#st_restricao").append('<option value="Instrução">Instrução</option>')
        $("#st_restricao").append('<option value="Educação física">Educação física</option>')
        $("#st_restricao").append('<option value="Escala">Escala</option>')
        $("#st_restricao").append('<option value="Esforço físico">Esforço físico</option>')
        $("#st_restricao").show();
        $("#st_motivo").empty();
        $("#st_motivo").append('<option value="">--Selecionar--</option>')
        $("#st_motivo").append('<option value="CARDÍACO">CARDÍACO</option>')
        $("#st_motivo").append('<option value="ORTOPÉTICO">ORTOPÉTICO</option>')
        $("#st_motivo").append('<option value="CIRÚRGICO">CIRÚRGICO</option>')
        $("#st_motivo").append('<option value="PSICOLÓGICO">PSICOLÓGICO</option>')
        $("#st_motivo").append('<option value="OUTROS">OUTROS</option>')
        $('#div_st_restricao').show();
        $('#div_st_motivo').show();
        $('#div_dt_inicio').show();
        $('#div_nu_dias').show();
        $('#div_dt_termino').show();
    }
}

function setIdAnotacao(id) {
    $("#nu_anotacaoselecionada").attr("value", id);
}

function modalExcluirAnotacao(policialId, anotacaoId) {

    $("#form_excluir_anotacao").attr("action", "{{ url('junta/cr/')}}/" + policialId + "/del/" + anotacaoId);
    $('#modalExluirAnotacao').modal();
};

function modalExcluirAtendimento(idAtendimento) {

    $("#form_excluir_atendimento").attr("action", "{{ url('juntamedica/atendimento')}}/" + idAtendimento +
        "/deleta");
    $('#modalExluirAtendimento').modal();
};