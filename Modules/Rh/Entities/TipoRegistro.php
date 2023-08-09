<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class TipoRegistro extends Model
{
    protected $table = 'tiposregistro';

    public $timestamps = false;
    
    protected $fillable = [
        'st_tipo', 'st_descricao', 'bo_ativo'
    ];
}
