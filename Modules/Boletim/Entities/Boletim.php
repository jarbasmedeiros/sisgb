<?php

namespace Modules\Boletim\Entities;
use Modules\Boletim\Entities\Nota;

use Illuminate\Database\Eloquent\Model;

class Boletim extends Model
{
    protected $fillable = [
        'ce_unidade', 'ce_tipo', 'dt_cadastro', 'dt_boletim', 'nu_sequencial', 'nu_ano','st_status', 'bo_efetivoatualizado'
    ];

    protected $table = 'boletim.boletins';
    public $timestamps = false;
}
