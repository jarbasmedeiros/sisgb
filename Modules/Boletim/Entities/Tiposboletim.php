<?php

namespace Modules\Boletim\Entities;

use Illuminate\Database\Eloquent\Model;

class Tiposboletim extends Model
{
    protected $fillable = [
        'st_tipo', 'st_descricao', 'st_sigla'
    ];
    
    protected $table = 'boletim.tiposboletins';
    public $timestamps = false;
}
