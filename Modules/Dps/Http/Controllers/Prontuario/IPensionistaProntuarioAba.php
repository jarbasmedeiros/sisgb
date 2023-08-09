<?php 

namespace Modules\Dps\Http\Controllers\Prontuario;

use Illuminate\Http\Request;

interface IPensionistaProntuarioAba {
    public function editar(int $pensionistaId);
    public function listar(int $pensionistaId);
    public function criar(int $pensionistaId, Request $dadosForm);
    public function salvar(int $pensionistaId, Request $dadosForm);
    public function consultar(int $pensionistaId);
    public function consultarRegistro(int $pensionistaId, int $registroId);
    public function excluir(int $pensionistaId, Request $dadosForm);
    public function imprimir(int $pensionistaId, Request $dadosForm);
}

?>