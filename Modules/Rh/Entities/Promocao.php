<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Promocao extends Model
{

    protected $fillable = ['ce_policial', 'st_curso', 'dt_cadastro', 'st_promocao', 'dt_promocao', 'st_boletim', 'dt_boletim', 'st_doe', 'dt_doe'];
    
    public $timestamps = false;

    protected $table = 'promocao';
}