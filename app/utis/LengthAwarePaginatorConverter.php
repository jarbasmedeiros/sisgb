<?php
namespace App\utis;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Description of LengthAwarePaginatorConverter
 * Recebe um JSON
 * Return objeto LengthAwarePaginator
 * Converte json em LengthAwarePaginator
 * @author Higor, Jazon, Talysson
 */
class LengthAwarePaginatorConverter {
    public static function converterJsonToLengthAwarePaginator($json, $path) {
      try{
        if(isset($json->total)){
          $options = [];
          $total = $json->total;
          $itens = $json->data;
          $perPage = $json->per_page;
          $currentPage = $json->current_page;

          $lengthAwarePaginator = new LengthAwarePaginator($itens, $total, $perPage, $currentPage);
          $lengthAwarePaginator->setPath($path);
          return $lengthAwarePaginator;
        } else{
          throw new Exception(Msg::JSON_NAO_PAGINADO);
        }
      }catch(Exception $e){
        throw new Exception($e->getMessage());
      }
    }
}
            
?>