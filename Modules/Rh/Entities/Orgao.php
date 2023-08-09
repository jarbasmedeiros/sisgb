<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{
    protected $fillable = [
        'st_sigla', 'st_orgao','st_descricao', 'bo_ativo'
    ];

    //Regras para Validar dados
    public $rules = [
        'st_sigla' => 'max:50|required|unique:orgaos',
        'st_orgao' => 'max:100|required',
        'st_descricao' => 'max:300|required',
        'bo_ativo' => 'required|max:1',
    ];

    public $timestamps = false;
}
