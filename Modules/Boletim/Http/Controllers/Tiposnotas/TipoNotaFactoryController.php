<?php

namespace Modules\Boletim\Http\Controllers\Tiposnotas;

use  Modules\Boletim\Http\Controllers\Tiposnotas\Notas\N24InstauracaoProcedimentoController;

use Exception;


class TipoNotaFactoryController 
{
    public  function getTipoNotaController($idTipo){
        try {
            //constroi o tipo de nota desejada
            switch ($idTipo) {
                case 1:
                //  $factory = new N1SimplesSemPm();
                throw new Exception('TipoNotaServiceFactory ' . $idTipo . ' não possui policiais');
                    break;
                case 2:
                   $factory = new N2GenericaComPmService();
                    break;
            /*  case 10:
                    $builder = new NConvocaTafPromocaoBuilder();
                    break;
                case 11:
                    $builder = new NResultadoTafPromocaoBuilder();
                    break;
                case 12:
                    $builder = new NConvocaJPMSPromocaoBuilder();
                    break;
                case 13:
                    $builder = new NResultadoJPMSPromocaoBuilder();
                    break;
                case 15:
                    $builder = new NQaPreliminarPromocaoBuilder();
                    break; */
                case 17:                               
                    $factory = new N17MovimentacaoPracaService();                               
                    break;
                case 18:                               
                  $factory = new N18MovimentacaoOficialService();                               
                    break;
                case 20:                               
                // $factory = new N20PlanoFeriasAnual(); 
                    throw new Exception('TipoNotaServiceFactory ' . $idTipo . ' implementado por processo');                              
                    break;
                case 21:                                         
                    $factory = new N21AtaConclusaoCursoService();                               
                    break;
                case 24:  
                    $factory = new N24InstauracaoProcedimentoController(); 
                    break;
                default:
                    throw new Exception('TipoNotaFactory ' . $idTipo . ' não implementado');
                    break;
            }
            if(empty($factory)){
                throw new Exception('TipoNotaFactory ' . $idTipo . ' não construído');
            }
            return $factory;
            
        } catch (\Exception $th) {
           throw new Exception($th->getmessage());
        }
    }
}
