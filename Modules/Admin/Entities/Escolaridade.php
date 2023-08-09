<?php

    namespace Modules\Admin\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Escolaridade extends Model{
        protected $fillable = [
            'st_escolaridade'
        ];
        public $timestamps = false;
        
        protected $table = 'escolaridades';
    }

?>