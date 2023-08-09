<?php

namespace Modules\rh\Entities;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    public $timestamps = false;
    
    protected $fillable = [
        'bo_ativo', 'dt_cadastro', 'st_nome', 'dt_nascimento', 'st_sexo', 'st_tiposanguineo', 'st_fatorh', 'st_nacionalidade', 'st_naturalidade', 'st_ufnaturalidade', 'st_pai', 'st_mae', 'st_cpf', 'st_matricula', 'st_logradouro', 'st_numeroresidencia', 'st_bairro', 'st_complemento', 'st_cep', 'st_cidade', 'st_uf', 'st_telefoneresidencial', 'st_telefonecelular', 'st_email', 'st_estadocivil', 'st_conjuge', 'st_codigobanco', 'st_nomebanco', 'st_agencia', 'st_conta', 'ce_orgao', 'ce_unidade', 'ce_graduacao', 'st_nomeguerra', 'st_tipoinclusao', 'st_numerodocumentoposse', 'dt_doe', 'dt_posse', 'dt_nomeacao', 'dt_exercicio', 'dt_inclusao', 'ce_cargo', 'st_nivel', 'st_folha', 'ce_funcao', 'ce_setor', 'ce_status', 'ce_gratificacao', 'st_horariotrabalho', 'st_tipoinatividade', 'dt_devolucao', 'dt_ultimacessao', 'st_rg', 'st_orgaorg', 'dt_emissaorg', 'nu_titulo', 'nu_zonatitulo', 'nu_secaotitulo', 'st_municipiotitulo', 'st_uftitulo', 'dt_emissaotitulo', 'st_cnh', 'st_categoriacnh', 'dt_vencimentocnh', 'st_ufcnh', 'dt_emissaocnh', 'st_carteiratrabalho', 'st_seriecarteiratrabalho', 'st_ufcarteiratrabalho', 'nu_pis_pasep', 'st_certificadomilitar', 'ce_escolaridade', 'st_altura', 'st_cor', 'st_olhos', 'st_cabelos', 'dt_incorporacao', 'st_numeropraca', 'st_quadrooperacional', 'st_rgfuncional', 'st_comportamento', 'st_bgcomportamento', 'dt_bgcomportamento', 'st_caminhofoto'
    ];
    //protected $hidden = ['bo_ativo', 'id'];

    public static function getExcludeColumns($excludedColumns = []) {
        $columns = [
            'bo_ativo', 'dt_cadastro', 'st_nome', 'dt_nascimento', 'st_sexo', 'st_tiposanguineo', 'st_fatorh', 'st_nacionalidade', 'st_naturalidade', 'st_ufnaturalidade', 'st_pai', 'st_mae', 'st_cpf', 'st_matricula', 'st_logradouro', 'st_numeroresidencia', 'st_bairro', 'st_complemento', 'st_cep', 'st_cidade', 'st_uf', 'st_telefoneresidencial', 'st_telefonecelular', 'st_email', 'st_estadocivil', 'st_conjuge', 'st_codigobanco', 'st_nomebanco', 'st_agencia', 'st_conta', 'ce_orgao', 'ce_graduacao', 'st_nomeguerra', 'st_tipoinclusao', 'st_numerodocumentoposse', 'dt_doe', 'dt_posse', 'dt_nomeacao', 'dt_exercicio', 'dt_inclusao', 'ce_cargo', 'st_nivel', 'st_folha', 'ce_funcao', 'ce_setor', 'ce_status', 'ce_gratificacao', 'st_horariotrabalho', 'st_tipoinatividade', 'dt_devolucao', 'dt_ultimacessao', 'st_rg', 'st_orgaorg', 'dt_emissaorg', 'nu_titulo', 'nu_zonatitulo', 'nu_secaotitulo', 'st_municipiotitulo', 'st_uftitulo', 'dt_emissaotitulo', 'st_cnh', 'st_categoriacnh', 'dt_vencimentocnh', 'st_ufcnh', 'dt_emissaocnh', 'st_carteiratrabalho', 'st_seriecarteiratrabalho', 'st_ufcarteiratrabalho', 'nu_pis_pasep', 'st_certificadomilitar', 'ce_escolaridade', 'st_altura', 'st_cor', 'st_olhos', 'st_cabelos', 'dt_incorporacao', 'st_numeropraca', 'st_quadrooperacional', 'st_rgfuncional', 'st_comportamento', 'st_bgcomportamento', 'dt_bgcomportamento'
        ];
        return array_diff($columns , $excludedColumns);
    }

    public static function renameColumns($columns) {

        foreach($columns as &$c) {
            $c = str_replace(["st_","ce_","nu_"], "", $c);
            $c = str_replace("dt_","data de ", $c);
        }

        $columns = array_map('strtoupper', $columns);

        return array_map('strtoupper', $columns);
    }

    public static function subs($columns) {

        foreach($columns as &$c) {
            $c =  substr_replace($c, 'funcionarios.', 0, 0);
        }
        return $columns;
    }
}