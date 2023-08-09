<?php
namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    protected $fillable = ['st_funcao', 'bo_ativo', 'dt_cadastro'];

    public $timestamps = false;

    protected $table = 'funcoes';
}
