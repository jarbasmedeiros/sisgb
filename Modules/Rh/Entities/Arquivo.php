<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{

    protected $fillable = ['ce_funcionario', 'st_path', 'st_nome'];

    public $timestamps = false;

    protected $table = 'arquivos';
}