<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = ['ce_tipoitem', 'ce_tiporegistro', 'st_nome', 'nu_sequencia_form' , 'nu_sequencia_impressao', 
    'bo_obrigatorio', 'st_valorfixo', 'bo_dinamico', 'bo_mestre', 'bo_detalhe', 'st_tabelaorigem', 'st_tabelaorigem', 'st_colunawhere',
    'st_colunatabela', 'bo_ativo', 'st_iddetalhe'];

    public $timestamps = false;

    protected $table = 'itens';
}
