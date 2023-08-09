<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Graduacao extends Model
{
    protected $fillable = [
    'st_graduacao'
];
    public $timestamps = false;
    
    protected $table = 'graduacoes';
}
