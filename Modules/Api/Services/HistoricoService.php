<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\rh\Entities\Historico;

    class HistoricoService  extends Controller {

        // Lista os historicos do funcionário de desejado para a ficha pessoal
        // Entrada - id do funcionário
        // Saída - lista todos os campos dos historcios do funcionário desejado, st_sigla de orgao e st_cargo de cargo
        public function listahistoricosficha($id) {
            $historicos = Historico::where('historicos.ce_funcionario', $id)
                                    ->leftjoin('orgaos', 'orgaos.id', 'historicos.ce_orgao')
                                    ->leftjoin('cargos', 'cargos.id', 'historicos.ce_cargo')
                                    ->select('historicos.*', 'orgaos.st_sigla as orgao', 'cargos.st_cargo as cargo')
                                    ->get();
            return $historicos;
        }

    }

?>