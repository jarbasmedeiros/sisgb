<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Cr extends Model
{

    protected $fillable = ['ce_funcionario', 'dt_registro', 'ce_tiporegistro', 'bo_ativo', 'ce_setor'];

    public $timestamps = false;

    public function registros(){
        return $this->hasMany('App\Registro', 'ce_crs','id');
    }

   
}
