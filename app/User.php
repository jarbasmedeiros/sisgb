<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Permission;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','perfil', 'st_cpf','matricula',  'bo_ativo', 'st_pathimgem', 'id', 'perfis', 'permissoes', 'unidadesvinculadas', 'ce_vinculo', 'vinculos', 'ce_unidade'
    ];

    public $timestamps = false; 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //Regras para Validar dados
    static $rules = [
            'name' => 'required|max:255',
            'matricula' => 'required',
            'st_cpf' => 'required|min:14|max:14|unique:users',
            'email' => 'required|email|max:255|unique:users',
           
        
    ];
//    Recupera todas as roles do usuario, ou seja todos os perfis
    public function roles()
    {
       
        return $this->belongsToMany(\App\Role::class); 
        
    }
    //Retornando todas as funções que estao vinculadas a determinada permissão
    public function hasPermission(Permission $permission){
        return $this->hasAnyRoles($permission->roles); 
    }
    //Verifica se o usário tem as permissões exigidas na ação.
    public function hasAnyRoles($roles){
        if(is_array($roles)|| is_object($roles)){
            foreach ($roles as $role){
//                return $this->hasAnyRoles($roles);
                
                return !! $roles->intersect($this->roles)->count();
                
            }
        }
        return $this->roles->contains('st_nome', $roles);
    }

    public function setores()
    {       
        return $this->belongsToMany(\App\Setor::class);         
    }
    public function unidadesvinculadas()
    {       
        return $this->belongsToMany(\App\Unidade::class);         
    }
}
