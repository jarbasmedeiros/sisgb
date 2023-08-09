<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\Rh\Entities\Orgao;
    use DB;

    class OrgaoService  extends Controller {

        // Lista todos os orgaos ativos
        // Saída - lista os campos [id, st_orgao] de orgaos
        public function listaorgaosativos() {
            $orgaos = Orgao::where('bo_ativo', 1)->orderBy('st_orgao')->get(['id','st_orgao']);
            return $orgaos;
        }

        // Lista todos os orgaos ativos
        // Saída - lista os campos [id, st_sigla] de orgaos
        public function listaorgaosativossiglas() {
            $orgaos = Orgao::where('bo_ativo', 1)->orderBy('st_sigla')->get(['id','st_sigla']);
            return $orgaos;
        }

        // Busca orgão por id
        // Entrada - id do orgão desejado
        // Saída - lista todos os campos do orgao caso ele seja encontrado
        public function buscaorgao($id) {
            $orgaos = Orgao::find($id);
            return $orgaos;
        }

    }

?>