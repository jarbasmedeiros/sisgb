<?php
namespace App\utis;
use Auth;
use App\Log;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author medeiros
 */
class MyLog {
    
    public static function info($msg) {
     
        $depois ="";
        $d = "";
        if(isset($msg['depois'])){
          $depois =$msg['depois'];
          foreach ($depois as $key => $value) {
             $d = $d.$key.' : '.$value.', '; 
          }
        }
        $antes ="";
        $a = "";
        if(isset($msg['antes'])){
          $antes =$msg['antes'];
          
          foreach ($antes as $key => $value) {
             $a = $a.$key.' : '.$value.', '; 
          }
        }
        $registro = "";
        if(isset($msg['registro'])){
            $registro = $msg['registro'];
        }
        $ms = $msg['msg'];
        $acao = $msg['acao'];
        
      
                $cad_Log = Log::create([
                            'st_acao' => $acao,
                            'dt_acao' => date('Y-d-m H:i:s'),
                           'st_browser' =>$_SERVER['HTTP_USER_AGENT'],
                            'st_url' =>$_SERVER['REQUEST_URI'],
                            'st_ip' => ($_SERVER["REMOTE_ADDR"]=='::1')? '127.0.0.1' : $_SERVER["REMOTE_ADDR"],
                            'st_msg' => $ms,
                            'st_antes' =>$a,
                            'st_depois' =>$d,
                            'ce_usuario' => Auth::user()->st_cpf,
                            
                ]);
                
        
        }
        
        
    public static function alert($msg) {
        
        //inserindo dados na tabela registro (Tabela pai)
                $cad_Log = Log::create([
                            'st_acao' => 'slkfjs',
                            'dt_acao' => date('Y-m-d h:i:s'),
                            'st_browser' =>$_SERVER['HTTP_USER_AGENT'],
                            'st_url' =>$_SERVER['REQUEST_URI'],
                            'st_ip' => $_SERVER["REMOTE_ADDR"],
                            'st_msg' => "Foram alterados os campos: ".$msg,
                            'st_antes' => 'Rascunho',
                            'st_depois' => 'Rascunho',
                            'ce_tipo' => 'Edit',
                            'ce_usuario' => Auth::user()->st_cpf,
                            
                ]);
        
    }
    public static function error($param) {}



}
