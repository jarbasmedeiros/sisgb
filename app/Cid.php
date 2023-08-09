<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cid extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'st_cid', 'st_doenca','st_descricao'
    ];

    protected $table = 'junta.cids';
    public $timestamps = false; 
}
