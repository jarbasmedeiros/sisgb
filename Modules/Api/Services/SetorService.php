<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\Rh\Entities\Setor;
    use DB;

    class SetorService  extends Controller {

        // Lista todos os setores ativos
        // Saída - lista os campos [id, st_sigla] de setores
        public function listasetoresativos() {
            $setores = Setor::where('setores.bo_ativo', 1)->orderBy('setores.st_sigla')->get(['id','st_sigla']);
            return $setores;
        }

    }

?>