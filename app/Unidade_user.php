<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidades_user extends Model
{
    protected $fillable = [
        'user_id', 'unidade_id'
    ];

    public $timestamps = false;

    protected $table = 'unidade_user';

}
