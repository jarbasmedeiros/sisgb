<?php

namespace Modules\Boletim\Entities;

use Illuminate\Database\Eloquent\Model;

class Notasdosboletim extends Model
{
    protected $fillable = [
        'ce_boletim', 'ce_nota','st_parte', 
    ];
    
    protected $table = 'boletim.Notasdosboletins';
    public $timestamps = false;
}
