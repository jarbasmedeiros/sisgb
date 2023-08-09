<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
    'st_nome', 'st_label'
];
    public $timestamps = false; 
    
    public function roles()
    {
        return $this->belongsToMany(\App\Role::class);   
      
    }
    
}