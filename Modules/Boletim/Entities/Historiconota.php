<?php

namespace Modules\Boletim\Entities;

use Illuminate\Database\Eloquent\Model;

class Historiconota extends Model
{
    protected $fillable = [
        'ce_nota', 'ce_usuario', 'dt_cadastro','st_status', 'st_msg', 'st_obs',
    ];
    
    protected $table = 'boletim.historiconotas';
    public $timestamps = false;
}
