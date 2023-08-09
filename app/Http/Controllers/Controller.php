<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @autor jazon - #267
     * @date 3/12/2020
     * remove (se existir) a variável enviada via post do array $request->all()
     */
    public function removerTokenDoRequest($request){
        if(isset($request['_token'])){
            unset($request['_token']);
        }
        return $request;
    }
}
