<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Qpmp extends Model
{
    //

    protected $fillable = ['st_qpmp', 'st_sigla', 'st_descricao'];

    public $timestamps = false;

    protected $table = 'qpmps';
}
