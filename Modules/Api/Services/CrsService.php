<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\rh\Entities\Cr;

    class CrsService  extends Controller {

        // Lista as Crs do funcionário de desejado
        // Entrada - id do funcionário
        // Saída - lista todas as Crs do funcionário desejado
        public function listacrs($id) {
            $cr = Cr::where([['ce_funcionario', $id],['bo_ativo', 1]])->get();
            return $cr;
        }

    }

?>