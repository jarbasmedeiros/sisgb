<?php 
namespace Modules\Rh\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Auth;
use App\utis\Msg;


use Modules\Api\Services\MapaForcaService;
use Modules\Api\Services\PolicialService;

class MapaForcaController extends Controller{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    //Tem que mudar para o service correto 
    public function __construct( MapaForcaService $MapaForcaService){        
        $this->MapaForcaService = $MapaForcaService;
    }

    /**
    * Método para listar o quantitativo de vagas
    */
    public function listar(){
        try{ 
              //resgata um policial pelo CPF
              $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
              // Requisição para API
              $p = new PolicialService;

              $policial = $p->findPolicialByCpfMatricula($cpf);
              //$request = $api->get("policiais/matricula-cpf/".$cpf);
              if(empty($policial->ce_unidade)){
                  throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
              }
            //$dadosUsuario = $this->getUnidadesDoUsuario();
            $vagas = $this->MapaForcaService->getInformacoesPorUnidade($policial->ce_unidade);
            $result = $vagas;//Variavel do tipa arry que vai conter os novos dados filtrados
            return view('rh::mapaForca.mapaforca', compact('vagas','policial'));//passa para o front a nova coleção de dados
        }catch(Exception $e){
            return redirect()->back()->with('erroMsg', $e->getMessage());
        }
    }

    public function getPdf(){
           //resgata um policial pelo CPF
           $cpf = preg_replace("/\D+/", "", Auth::user()->st_cpf);
           // Requisição para API
           $p = new PolicialService;

           $policial = $p->findPolicialByCpfMatricula($cpf);
           //$request = $api->get("policiais/matricula-cpf/".$cpf);
           if(empty($policial->ce_unidade)){
               throw new Exception(Msg::POLICIAL_SEM_UNIDADE);
           }
            $vagas = $this->MapaForcaService->getInformacoesPorUnidade($policial->ce_unidade);
                return \PDF::loadView('rh::pdf.MapaForcaPdf', compact('vagas', 'policial'))
                ->stream('mapa_forca.pdf');
    }

    private function getUnidadesDoUsuario(){
        $unidadesViculadas = Auth()->user()->unidadesvinculadas;
        $dadosUsuario = $unidadesViculadas[count($unidadesViculadas)-1];
        //dd(Auth()->user()->name);
        $dadosUsuario["name"] = Auth()->user()->name;
        return $dadosUsuario;
    }
}