<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{

    protected $fillable = ['ce_funcionario', 'ce_orgao', 'ce_cargo', 'ce_cr', 'dt_nomeacao' , 'dt_inatividade', 'st_motivoinatividade', 'dt_exercicio', 'dt_posse', 'st_tipo'];

    public $timestamps = false;

    protected $table = 'historicos';
}