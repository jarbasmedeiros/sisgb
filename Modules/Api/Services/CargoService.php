<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\Rh\Entities\Cargo;
    use DB;

    class CargoService  extends Controller {

        // Lista todos os cargos ativos
        // Saída - lista os campos [id, st_cargo] de cargos
        public function listacargosativos() {
            $cargos = Cargo::where('bo_ativo', 1)->orderBy('st_cargo')->get(['id','st_cargo']);
            return $cargos;
        }

        // Busca cargo por id
        // Entrada - id do cargo desejado
        // Saída - lista todos os campos do cargo caso ele seja encontrado
        public function buscacargo($id) {
            $cargo = Cargo::find($id);
            return $cargo;
        }

        // Cria cargo com dados que recebe
        // Entrada - dados do form
        // Saída - true ou false
        public function createcargo($dados){
            $cargo = Cargo::create($dados);
            return $cargo;
        }

        // Atualiza cargo com dados que recebe
        // Entrada - dados do form e o objeto cargo
        // Saída - true ou false
        public function atualizacargo(Cargo $cargo, $dados){
            $update = $cargo->update($dados);
            return $update;
        }

        // Desativa cargo
        // Entrada - objeto cargo
        // Saída - true ou false
        public function desativacargo(Cargo $cargo){
            $update = $cargo->update(['bo_ativo' => 0]);
            return $update;
        }

    }

?>