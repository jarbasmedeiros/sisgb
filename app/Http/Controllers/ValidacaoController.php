<?php

namespace App\Http\Controllers;

use Modules\Api\Services\ValidacaoService;

use DateTime;
use Illuminate\Http\Request;



/**
 *  Controller de validação
 *  Utilizar para validação pública de um documento emitido pelo sistema
 *  .
 */
class ValidacaoController extends Controller
{
 

     /**
     *
     * @return void
     */
    public function __construct(ValidacaoService $validacaoService){
        
        $this->validacaoService = $validacaoService;          
    }

    /**
     * @autor Jazon - #267
     * valida um RG 
     */
    public function validarRg($localizador)
    {   
        //por padrão é false
        $rgValido = false;
      
        try {       
               
            $rg = $this->validacaoService->validarRg($localizador);
            //dd($erro);
            //caso exista retorno válido
            $rgValido = true;
            return view('validacao.validar_rg', compact('rg','rgValido'));
         } catch (\Throwable  $th) {
            // dd($rgValido);
            $erro =  $th->getmessage();
            return view('validacao.validar_rg', compact('rgValido','erro'));
         }
        
        
    }

}