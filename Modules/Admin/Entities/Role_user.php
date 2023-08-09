<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
    protected $hidden = [
        'role_id', 'usuario_id'
    ];
}
