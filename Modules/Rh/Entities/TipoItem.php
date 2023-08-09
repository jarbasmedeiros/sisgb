<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class TipoItem extends Model
{
    protected $table = 'tipositens';
    
    protected $fillable = [
        'st_item', 'st_descricao', 'bo_ativo'
    ];

    //Regras para Validar dados
    static $rules = [
        'st_item' => 'required|max:50|unique:tipositens',
        'st_descricao' => 'max:300',
        'bo_ativo' => 'required|max:1',
    ];

    public $timestamps = false;
}
