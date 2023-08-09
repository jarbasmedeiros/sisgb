<?php

namespace Modules\Boletim\Http\Controllers\Tiposnotas;

use Modules\Boletim\Http\Controllers\Tiposnotas\TipoNotaFactoryController;
use Exception;


class TipoNotaFacadeController //extends Controller
{
   
    protected $tipoNotaController ;


    public  function __construct($idTipo)
    {
        try{
            //cria a fabrica de tipos de notas
            $factory = new TipoNotaFactoryController();
            //constroe o tipo de nota desejada
            $this->tipoNotaController  = $factory->getTipoNotaController($idTipo);
        }catch(Exception $e){
            throw new Exception($e->getmessage());
        }
    }


    public  function listarPolicialParaCadaTipoNota($dadosForm)
    {
        try{
            //implmenta a regra específicas desse tipo de nota e que são necessárias antes de executar a ação
            $policiaisDaNota =  $this->tipoNotaController->listarPolicialParaCadaTipoNota($dadosForm);
            return $policiaisDaNota;
        }catch(Exception $e){
            throw new Exception($e->getmessage());
        }
    }

    public  function addPolicialParaCadaTipoNota($dadosForm)
    {
        try{
            //implmenta a regra específicas desse tipo de nota e que são necessárias antes de executar a ação
            $resultado =  $this->tipoNotaController->addPolicialParaCadaTipoNota($dadosForm);
            return $resultado;
        }catch(Exception $e){
            throw new Exception($e->getmessage());
        }
    }

    public  function delPolicialParaCadaTipoNota($dadosForm)
    {
        try{
            //implmenta a regra específicas desse tipo de nota e que são necessárias antes de executar a ação
            $policiaisDaNota =  $this->tipoNotaController->delPolicialParaCadaTipoNota($dadosForm);
            return $policiaisDaNota;
        }catch(Exception $e){
            throw new Exception($e->getmessage());
        }
    }
    public  function atualizarNotaParaCadaTipoNota($dadosForm)
    {
        try{
           // dd('fdsfadf');
            //implmenta a regra específicas desse tipo de nota e que são necessárias antes de executar a ação
            $policiaisDaNota =  $this->tipoNotaController->atualizarNotaParaCadaTipoNota($dadosForm);
            return $policiaisDaNota;
        }catch(Exception $e){
            throw new Exception($e->getmessage());
        }
    }
    
    
    


}
