<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    //

    protected $fillable = ['st_sigla', 'st_descricao', 'bo_ativo'];

    public $timestamps = false;

    protected $table = 'setores';
}
