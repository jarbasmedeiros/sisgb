<?php

namespace App\Http\Controllers;

use DB;
use App\Cid;
use Illuminate\Http\Request;

use Auth;

class ScriptController extends Controller
{
    //@Author: Marcos Paulo #332
    //Controller e método unicamente pensado para popular no banco, como o processo de um seed, a partir de um txt da junta médica
    public function getCIDs(Request $request){
        $cont = 0;
        try{
            DB::beginTransaction();
            $file_handle = fopen("C:\inetpub\wwwroot\sisGp\storage\app\cid10n4a.txt", "r");
            while (!feof($file_handle)) {
                ++$cont;
                $line = fgets($file_handle);
                $cid = explode(' ', $line)[0];
                $doencaParte = explode('  ', $line)[1];
                //dd($doencaParte);
                $doenca = utf8_encode(explode('|', $doencaParte)[0]);
                $doenca = utf8_encode(explode('&', $doencaParte)[0]);

                //$doenca = 
                $pos = strripos($line, '&');
                if($pos){
                    $descricao = utf8_encode(explode('&', $line)[1]);
                    //echo $cid.'--'.$doenca.'--'.$descricao.'<br/>';
                }else{
                    $descricao = null;
                }
                //echo($cid.'--'.$doenca.'--'.$descricao.'<br/>');
                $objeto = ['st_cid' => $cid, 'st_doenca' => $doenca, 'st_descricao' => $descricao];
                dd($objeto);
                //$objeto = 'cid '.$cid.'doenca '.$doenca.'descricao '.$descricao;
                Cid::create($objeto);
                DB::commit();
                //echo($objeto.'<br/>');
            }
            echo('ok');
            fclose($file_handle);
        } catch(\Exception $e) {
            DB::rollback();
            dd("linha:".$cont.' '.$e->getMessage());
        }
    }
}
