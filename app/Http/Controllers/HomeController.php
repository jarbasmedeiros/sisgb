<?php

namespace App\Http\Controllers;
use Modules\Api\Services\UnidadeService;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\HomeService;
use Modules\Api\Services\MuralService;
use DB;
use DateTime;
use Illuminate\Http\Request;
use App\Cr;
use Auth;

/**
 *  Controller da página Home
 *  Listagem de férias e licenças que inicializar nos próximos 15 dias; Listagem de férias e licenças que finalizam nos próximos 15 dias.
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeService $homeService, MuralService $muralService)
    {
        $this->middleware('auth');
        $this->homeService = $homeService;
        $this->muralService = $muralService;
    }

    /**
     * @author Marcos #311
     * @revisor Jazon
     * Show a lista de notícias caso existam
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Auth::user());
        try {
             $mural = $this->muralService->listarMural();
             return view('home', compact('mural')); 
 
         } catch (Exception $e) {
             return view('home', compact('mural'))->with('erroMsg', $e->getMessage());  
         }
    }

    //retorna página em Desenvolvimento
    public function emDesenvolvimento()
    {      
        return view('errors.desenvolvimento');
    }

    /* Autor: @aggeu. Issue 207, Implementar listagem de ferias e licença para os proximos quinze dias (Tela home). */
    public function listaFeriasLicencas15Dias(){        

        try {
          
           /*  $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
            $policial = $this->PolicialService->buscaPolicialCpf($cpf);
            $feriaslicencas = $this->PolicialService->listaFeriasLicencas15Dias($policial->ce_unidade); */
            $mural = $this->HomeService->listaMural();
            return view('home', compact('mural')); 

        } catch (Exception $e) {
            
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

}
