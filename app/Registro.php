<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
   

    public $timestamps = false;
    
    protected $fillable = [
        'dt_registro', 'ce_item', 'bo_ativo', 'ce_crs', 'st_valor'
    ];

    public function crs(){
        return $this->belongsTo('App\Cr');
    }
    public function item(){
        return $this->hasOne('App\Item', 'id', 'ce_item');
    }
}

