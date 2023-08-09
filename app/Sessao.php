<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    protected $fillable = [
    'ce_boletim', 'ce_nota', 'ce_tipo', 'bo_conferida', 'bo_assinada', 'bo_enviadaboletim', 'nu_sequencial', 'nu_ano', 'st_numsei', 'dt_sessao', 'st_status', 'st_obs'
];
    public $timestamps = false; 
    
    
    
}