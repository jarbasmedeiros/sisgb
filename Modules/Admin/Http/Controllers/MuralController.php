<?php

namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Modules\Api\Services\MuralService;
use DateTime;
use Illuminate\Http\Request;
use Auth;

/** @author: Marcos Paulo #329
 *  Controller da página Mural
 */
class MuralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MuralService $muralService)
    {
        $this->middleware('auth');
        //$this->authorize('Admin');
        $this->muralService = $muralService;
    }

    public function listarNoticias(){
        try {
            $this->authorize('Administrador');
            $mural = $this->muralService->listarNoticias();
            return view('admin::mural.noticias', compact('mural')); 

        } catch (Exception $e) {
            return view('admin::mural.noticias', compact('mural'))->with('erroMsg', $e->getMessage());  
        }
    }

    public function criandoNoticia(){
        try {
            $this->authorize('Administrador');
            return view('admin::mural.criarnoticia'); 
        } catch (Exception $e) {
            return view('admin::mural.criarnoticia')->with('erroMsg', $e->getMessage());  
        }
    }

    public function criarNoticia(Request $request){
        try {
            $this->authorize('Administrador');
            $dadosForm = $this->removerTokenDoRequest($request->all());
            $retorno = $this->muralService->criarNoticia($dadosForm); 
            return redirect('admin/noticias')->with('sucessoMsg', $retorno); 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }

    public function editandoNoticia($id){
        try {
            $this->authorize('Administrador');
            $noticia = $this->muralService->editandoNoticia($id);
            return view('admin::mural.editarnoticia', compact('noticia')); 
        } catch (Exception $e) {
            return view('admin::mural.editarnoticia', compact('noticia'))->with('erroMsg', $e->getMessage());  
        }
    }

    public function updateNoticia($id, Request $request){
        try {
            $this->authorize('Administrador');
            $dadosForm = $this->removerTokenDoRequest($request->all());
            $retorno = $this->muralService->updateNoticia($id, $dadosForm); 
            return redirect('admin/noticias')->with('sucessoMsg', $retorno); 
        } catch (Exception $e) {
            return redirect()->back()->with('erroMsg', $e->getMessage());  
        }
    }
    public function historicoAtualizacao(){
        return view('admin::atualizacao.historicoAtualizacao');  
    }
}
