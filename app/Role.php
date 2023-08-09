<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
    'st_nome', 'st_label'
];
    public $timestamps = false;
    
   public function permissions(){
       //retornas todas permissões
       return $this->belongsToMany(\App\Permission::class);
   }
}
