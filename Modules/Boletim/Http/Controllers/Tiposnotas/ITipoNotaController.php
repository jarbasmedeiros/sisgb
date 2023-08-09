<?php
namespace App\Http\Services\TiposNotas\Core;

use App\Http\Imp\Notas\ITipoNotaCommandImp;
use App\Http\Imp\PolicialImp;
//use App\Http\Imp\NotaImp;

use Exception;



/**
 * @author Jazon #198
 */
abstract class ITipoNotaController implements ITipoNotaCommandController
{

    protected $nota;  
    protected $boletim;
    protected $policialImp;
    protected $tipoNotaImp;
   // protected $notaImp;

    public function __construct(){
        $this->policialImp = new PolicialImp();
     //   $this->notaImp = new NotaImp();
    }

    public function setBoletim(Boletim $boletim){
        $this->boletim = $boletim;
    }

    public  function setNota(Nota $nota){
        $this->nota = $nota;
    }

    protected  function getPoliciasImportados($dadosForm){
        //verifica se existe  
        if(!isset($dadosForm['lotepoliciais'])){
            throw new Exception("Favor informar os policiais");
        }
        //recupera o valor 
        $policiaisImportados = $dadosForm['lotepoliciais'];
        //verifica se é um array
         if(!is_array($policiaisImportados)){
            throw new Exception("Informe uma lista de policiais válida");
        } 
        //verifica se o array está fazia
        if(count($policiaisImportados)<1){
            throw new Exception("Lista de policiais vazia");
        }
        return $policiaisImportados;
    }

    public abstract function listarPolicialParaCadaTipoNotas($dadosForm);
    public abstract function addPolicialParaCadaTipoNota($dadosForm);
    public abstract function delPolicialParaCadaTipoNota($dadosForm);

}