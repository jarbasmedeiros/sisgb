<?php

namespace Mudules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
   

    public $timestamps = false;
    
    protected $fillable = [
        'st_descricao', 'st_sigla', 'bo_ativo', 'ce_pai'
    ];

    public function filhos (){
        return $this->hasMany('Modules\Admin\Entities\Unidade', 'ce_pai');
    }
    public function isFather(){
       
         return is_null($this->attributes['ce_pai']);
     }

     
    
}

