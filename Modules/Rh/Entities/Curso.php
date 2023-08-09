<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

    protected $fillable = ['ce_funcionario', 'st_nome', 'ce_escolaridade', 'bo_ativo', 'dt_conclusao'];
    
    public $timestamps = false;

    protected $table = 'cursos';
}
