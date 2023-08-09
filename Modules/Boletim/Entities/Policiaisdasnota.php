<?php

namespace Modules\Boletim\Entities;

use Illuminate\Database\Eloquent\Model;

class policiaisdasnota extends Model
{
    protected $fillable = [
        'ce_policial', 'ce_nota', 'dt_insercao'
    ];
    
    protected $table = 'boletim.policiaisdasnotas';
    public $timestamps = false;
}
