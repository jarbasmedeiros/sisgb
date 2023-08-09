<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class StatusFuncao extends Model
{
    protected $fillable = ['st_status', 'bo_ativo'];

    public $timestamps = false;

    protected $table = 'statusfuncoes';
}
