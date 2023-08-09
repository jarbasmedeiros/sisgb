<?php

namespace Modules\Boletim\Entities;

use Illuminate\Database\Eloquent\Model;

class Tiposnota extends Model
{
    protected $fillable = [
        'st_tipo', 'st_descricao', 'st_assunto', 'st_tela'
    ];
    
    protected $table = 'boletim.tiposnotas';
    public $timestamps = false;
}
