<?php
namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = ['st_cargo', 'bo_ativo'];

    public $timestamps = false;

    protected $table = 'cargos';
}
