<?php

   namespace Modules\rh\Entities;

    use Illuminate\Database\Eloquent\Model;

    class HistoricoFerias extends Model{

        protected $fillable = ['dt_inicio', 'dt_fim', 'nu_dias', 'nu_ano', 'st_descricao', 'ce_crs', 'st_tipo', 'dt_inicio_gozo', 'dt_final_gozo', 'ce_historicoferias', 'st_status', 'dt_cadastro', 'bo_ativo'];

        public $timestamps = false;

        protected $table = 'historicoferias';
    }

?>