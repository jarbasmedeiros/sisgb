<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
   protected $fillable = [
    'st_acao', 'st_browser', 'st_url', 'st_ip', 'st_msg', 'st_antes', 'st_depois', 'ce_tipo', 'ce_usuario', 'dt_acao', 'ce_registro'
];
  
   public $timestamps = false;
}
