<?php
namespace App\Modules\Boletim\Http\Controller\Tiposnotas;

interface ITipoNotaCommandController
{
    public function listarPolicialParaCadaTipoNotas($dadosForm);
    public function addPolicialParaCadaTipoNota($dadosForm);
    public function delPolicialParaCadaTipoNota($dadosForm);
}