<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Medalha extends Model
{

    protected $fillable = ['ce_policial', 'dt_cadastro', 'dt_medalha', 'st_tipo', 'st_nome', 'st_publicacao', 'dt_publicao'];
    
    public $timestamps = false;

    protected $table = 'medalhas';
}