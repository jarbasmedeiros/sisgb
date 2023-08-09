<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\rh\Entities\Gratificacao;

class GratificacaoService  extends Controller {

        // Lista todas as gratificacoes ativas
        // Saída - lista os campos [id, st_gratificacao] de gratificacoes
        public function listagratificacoesativas() {
            $gratificacoes = Gratificacao::where('bo_ativo', '1')->orderby('st_gratificacao')->get(['id','st_gratificacao']);
            return $gratificacoes;
        }

    }

?>