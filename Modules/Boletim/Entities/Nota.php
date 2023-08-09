<?php

namespace Modules\Boletim\Entities;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = [
        'ce_tipo', 'ce_unidade', 'dt_cadastro','nu_sequencial', 'nu_ano', 'st_materia', 'st_assunto', 'bo_ativo', 'st_status', 'dt_nota', 'st_obs', 'bo_enviado', 'bo_assinada'
    ];
    
    protected $table = 'boletim.notas';
    public $timestamps = false;
}
