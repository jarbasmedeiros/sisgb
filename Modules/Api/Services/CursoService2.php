<?php

    namespace Modules\Api\Services;
    use App\Http\Controllers\Controller;
    use Modules\rh\Entities\Curso;

    class CursoService  extends Controller {

        // Lista todos os cursos e escolaridade de determinado funcionário
        // Entrada - id do funcionário
        // Saída - lista todos cursos do funcionário desejado com os campos de cursos e escolaridade referente ao curso
        public function listacursosfuncionario($id) {
            $cursos = Curso::where([['bo_ativo', 1], ['ce_funcionario', $id]])
                            ->leftjoin('escolaridades', 'escolaridades.id', 'ce_escolaridade')
                            ->select('cursos.*', 'escolaridades.st_escolaridade as st_cursoescolaridade')
                            ->orderBy('st_nome')->get();
            return $cursos;
        }

        // Busca curso pelo id
        // Entrada - valor do id
        // Saída - Curso com o id correspondente ou false caso não exista
        public function buscacursoid($id){
            $curso = Curso::find($id);
            return $curso;
        }

        // Cria curso com dados que recebe
        // Entrada - dados do form
        // Saída - true ou false
        public function createcurso($dados){
            $curso = Curso::create($dados);
            return $curso;
        }

        // Atualiza curso com dados que recebe
        // Entrada - dados do form e curso a ser alterado
        // Saída - true ou false
        public function atualizacurso(Curso $curso, $dados){
            $update = $curso->update($dados);
            return $update;
        }

        // Desativa o curso
        // Entrada - curso a ser desativado
        // Saída - true ou false
        public function desativacurso(Curso $curso){
            $destroy = $curso->update(['bo_ativo' => 0]);
            return $destroy;
        }


        

    }

?>