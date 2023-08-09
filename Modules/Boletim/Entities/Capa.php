<?php

namespace Modules\Boletim\Entities;
use Modules\Boletim\Entities\Nota;

use Illuminate\Database\Eloquent\Model;

class Capa extends Model
{
    protected $fillable = [
        'ce_unidade', 'ce_tipoboletim', 'st_cabecalho', 'st_brasao', 'st_funcoes'
    ];

    protected $table = 'boletim.capas';
    public $timestamps = false;
}
