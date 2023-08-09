<?php
namespace App\utis;
use Auth;
use App\Log;
use App\Unidade;
use App\Historico;
use App\Regional;
use App\Instituto;
use App\Setor;
use Modules\Api\Services\PolicialService;
use Modules\Api\Services\UnidadeSErvice;
use App\Estado;
use App\Utis\Msg;
use DB;
use Exception;
use Illuminate\Support\Facades\Redirect;



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
class Funcoes {
    
   
    public static function transformaValorArray($data) {
        $valor = strip_tags($data);
      $array = explode(';',$valor);
    print_r($array);
      return $array;

    }

    public static function md5($text){
      return md5($text);
    }
  
    public static function verificaVinculoDoUsuarioComUnidade($idUnidade) {
      try{
      
        $usuario = Auth::user();

        if(empty($usuario->ce_unidade)){
            throw new Exception(MSG::POLICIAL_SEM_UNIDADE);
        }
      
        $unidadesFilhas = $usuario->unidadesvinculadas;
         
        if(!in_array($idUnidade,$unidadesFilhas)){
           throw new Exception(Msg:: USUARIO_SEM_VINCULO_OBJETO);           
        }

      }catch(Exception $e){
        throw new Exception($e->getMessage());
      }
    }

    public static function getunidadesfilhas() {
   
        $unidades = null;                    
        $unidade = Unidade::find(Auth::user()->ce_unidade);
        
        if(!empty($unidade)){             
          $unidades[] = $unidade->id;
          foreach($unidade->filhos as $comment){
            $unidades[] =$comment->id;
            if($comment->filhos->count()){
              foreach($comment->filhos as $reply){
                $unidades[] = $reply->id;
              }
            }
          }

        }
        return $unidades;
    }

    function in_array_field($needle, $needle_field, $haystack, $strict = false) {
      if ($strict) {
          foreach ($haystack as $item)
              if (isset($item->$needle_field) && $item->$needle_field === $needle)
                  return true;
      }
      else {
          foreach ($haystack as $item)
              if (isset($item->$needle_field) && $item->$needle_field == $needle)
                  return true;
      }
      return false;
  }
   
    
    /* 
    @aggeu, issue 215. 
    @transferido por Jazon/Marcos  #311
    Função que converte para maiúsculas o primeiro caractere de cada palavra, 
    fonte: https://www.php.net/manual/pt_BR/function.ucwords.php
    */
    public static function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "dos", "das", "do", "I", "II", "III", "IV", "V", "VI"))
    {
        /*
          * Exceptions in lower case are words you don't want converted
          * Exceptions all in upper case are any words you don't want converted to title case
          *   but should be converted to upper case, e.g.:
          *   king henry viii or king henry Viii should be King Henry VIII
          */
        $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word) {
                if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtoupper($word, "UTF-8");
                } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtolower($word, "UTF-8");
                } elseif (!in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
        }//foreach
        return $string;
    }

    public static function limpaCPF_CNPJ($valor){
      $valor = trim($valor);
      $valor = str_replace(".", "", $valor);
      $valor = str_replace(",", "", $valor);
      $valor = str_replace("-", "", $valor);
      $valor = str_replace("/", "", $valor);
      return $valor;
     }

     /**
         * @author juanMojica - #397
         * @param valor
         * @param máscara
         * Retorna o valor com a máscara, ambos são repassados como parâmetro
         */
        public function mask($val, $mask){
          $maskared = '';
          $k = 0;
          for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
              if ($mask[$i] == '#') {
                  if (isset($val[$k])) {
                      $maskared .= $val[$k++];
                  }
              } else {
                  if (isset($mask[$i])) {
                      $maskared .= $mask[$i];
                  }
              }
          }
          return $maskared;
      }

      public static function converterDataFormatoBr($data){
        return \Carbon\Carbon::parse($data)->format('d/m/Y');
       }

       /**
       * @author juanMojica - #433
       * @param Array
       * Função recursiva para adicionar o addslashes() a cada elemento do array
       */
      public static function addSlashesRecursivo($dados) {
        if (is_array($dados)) {
          return array_map('addslashes', $dados);
        } else {
          return addslashes($dados);
        }
      }

}




?>