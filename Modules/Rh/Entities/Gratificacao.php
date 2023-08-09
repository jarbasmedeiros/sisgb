<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Gratificacao extends Model
{
    protected $table = 'gratificacoes';

    protected $fillable = [
        'st_gratificacao', 'vl_gratificacao','nu_vagas', 'dt_cadastro', 'bo_ativo'
    ];

    //Regras para Validar dados
    public $rules = [
        'st_gratificacao' => 'max:50|required|unique:gratificacoes',
        'vl_gratificacao' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        'nu_vagas' => 'required|integer',
        'dt_cadastro' => 'required|date_format:"Y-d-m H:m:s"',
        'bo_ativo' => 'required|max:1',
    ];

    public $timestamps = false;
}
