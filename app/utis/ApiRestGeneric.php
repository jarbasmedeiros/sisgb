<?php
namespace App\utis;

use Exception;
use Illuminate\Support\Facades\Auth;

class ApiRestGeneric 
{
    
     const METHOD_GET = "GET";
     const METHOD_POST = "POST";
     const METHOD_PUT = "PUT";
     const METHOD_DELETE = "DELETE";

    protected $protocolo;//http://| https://
    protected $domain;//www9.defesasocial.rn.gov.br
    protected $endPoint; //sisgpws
    protected $version; //v1
    
    protected $pathUrl; //http://www9.defesasocial.rn.gov.br/sisgpws/v1


    protected $requestMethod;//GET,POST, PUT,DELETE
    protected $resource; //vagas | policiais

    protected $key;//key of access
    protected $stringJson;

    protected $parameters;
    protected $statusCode;
    protected $token;
    protected $semente;
    public function __construct() {

       try{
        $this->protocolo = env('API_PROTOCOLO');
        $this->domain = env('API_DOMINIO');
        $this->endPoint = env('API_ENDPOINT');
        $this->version =  env('API_VERSAO');
        $this->requestMethod = 'GET';
        $this->token =  env('API_TOKEN');
        $this->pathUrl = $this->setUrl();
        $this->showUrl = false;
        $this->semente = env('SEMENTE');
       }catch(Exception $e){
           throw new Exception("Erro no construtor da ApiRestGeneric ".$e->getmessage());
        }
      
    }

    private function gerarCabecalho($cpf){
       // $sistema = "SISGP";
        $sistema = $this->semente;
        date_default_timezone_set('America/Fortaleza');
        $ip = ($_SERVER['REMOTE_ADDR'] == "::1") ? "127.0.0.1" : $_SERVER['REMOTE_ADDR'];
        $date = date("Ymd");
        $texto = base64_encode($sistema . '@' . $ip . '@' . $cpf);
        $token = md5($date . $sistema . $texto);
        $cabecalho = array('Content-Type: application/json', 'Accept: application/json', "Token: ".$token . '@' . $texto);
        return $cabecalho;
    }

    private function setUrl() {
    
        if(empty($this->protocolo)){
            throw new Exception( 'Informe o API_PROTOCOLO no env');            
        }
        if(empty($this->domain)){
            throw new Exception( 'Informe o API_DOMINIO no env');            
        }
        if(empty($this->endPoint)){
            throw new Exception( 'Informe o API_ENDPOINT no env');            
        }
        if(empty($this->version)){
            throw new Exception( 'Informe o API_VERSAO no env');            
        }
       
        return $this->protocolo.$this->domain."/".$this->endPoint."/".$this->version.'/';        
    }
    public function setRequestMethod($requestMethod) {
        $this->requestMethod = $requestMethod;
    }

    public function setEndPoint($endPoint) {
        $this->endPoint = "/" . $endPoint;
    }

    public function setKey($key) {
        $this->key = "/" . $key;
    }

    public function setResource($resource) {
       $this->resource = "/" . $resource;
    }

    public function setParameter($parameter) {

        $this->parameters.append($parameter);
    }

    public function setStringJson($stringJson) {
        $this->stringJson = $stringJson;
    }
    public function getStatusCode() {      
        return  $this->statusCode ;
    }
    public function getStringJson() {      
        return  $this->stringJson ;
    }
    private function mountUrl() {
        if(empty($this->key)){
            return $this->pathUrl. $this->resource;
        }else{
            return $this->pathUrl . $this->resource.$this->key;
        }
        
    }

    public function get($path, $data = null){
        return $this->execute($path, 'GET', $data);
    }
    public function put($path, $data = null){
        return $this->execute($path, 'PUT', $data);
    }
    public function post($path, $data = null){
        return $this->execute($path, 'POST', $data);
    }
    public function delete($path, $data = null){
        return $this->execute($path, 'DELETE', $data);
    }
    public function converteStringJson($stringJson){
        try{
            $response = json_decode($stringJson);
            
            if(empty( $response)){
                    if(strpos($stringJson, 'Method Not Allowed')){
                        throw new Exception('Método PUT/DELETE não habilitados.');
                    }elseif(strpos($stringJson, 'Call to undefined method')){
                        throw new Exception('Método consultado indefinido.');
                    }else{
                        throw new Exception($stringJson);
                        throw new Exception('Objeto Não encontrado.');
                    }
            }
            
            if(isset($response->message)){
               // throw new Exception($response->trace);
                
                if(strpos($stringJson, 'Call to undefined method')){
                   // $metodoConsultado = $response->trace;
                    throw new Exception('Método consultado indefinido.');
                }
            }
            if(isset($response->exception)){
                if(isset($response->message) && $response->message == "Too Many Attempts."){
                    throw new Exception(Msg::ERRO_LIMITE_REQUISICOES);
                }else{
                    throw new Exception($stringJson);
                   // throw new Exception(Msg::ERRO_API);
                }
            //}elseif(strpos($stringJson, 'title')){
            //   $title  = para ser tratado
                //throw new Exception(Msg::ERRO_API_NAO_ENCONTRADO);
            }elseif(json_last_error() != JSON_ERROR_NONE){
                /* dd(json_last_error());
                throw new Exception(Msg::JSON_INVALIDO);
    */



                switch (json_last_error()) {
                /*   case JSON_ERROR_NONE:
                        echo ' - No errors';
                    break; */
                    case JSON_ERROR_DEPTH:
                        throw new Exception('Erro Eestouro de pilha');
                    break;
                    case JSON_ERROR_STATE_MISMATCH:
                        throw new Exception('Baixo fluxo');
                    break;
                    case JSON_ERROR_CTRL_CHAR:
                        throw new Exception('Caractere de controle inesperado encontrado');
                    break;
                    case JSON_ERROR_SYNTAX:
                        throw new Exception('Erro de sintaxe, JSON malformado');
                    break;
                    case JSON_ERROR_UTF8:
                        throw new Exception('Caracteres UTF-8 malformados, possivelmente codificados incorretamente');
                    break;
                    default:
                    throw new Exception('Erro desconhecido.');
                    break;
                }
            }

            return $response;
        }catch (Exception $e) {
            throw new Exception($e->getmessage());
        }
    }

    public function showUrl($showUrl){
        $this->showUrl = $showUrl;
    }
    private function execute($path, $method, $data = null){
        try{
            $url = $this->mountUrl() . $path;
            if(strpos($url, "usuarios") > 0){
                $cpf = "-";
                $cabecalho = $this->gerarCabecalho($cpf);
            }else{
                //TODO
                if(isset(Auth()->user()->st_cpf)){
                    $cpf = Auth()->user()->st_cpf;
                    $cabecalho = $this->gerarCabecalho($cpf);
                } else {
                    $urlacesso = explode("/",$_SERVER["REQUEST_URI"]);
                    if($urlacesso[2]=="validacao"){
                        $cpf = "000000000";
                        $cabecalho = $this->gerarCabecalho($cpf);
                    } else {
                        throw new Exception('Erro na requisição GET: Usuário não logado!');
                    }
                    
                }
            }
            switch ($method) {
                case 'GET':
                    try{                     
                        $curl = curl_init();

                        if($this->showUrl){
                            print($url);
                        }
                        curl_setopt_array($curl, [
                            CURLOPT_RETURNTRANSFER  => true,
                            CURLOPT_CUSTOMREQUEST   => $method,
                            CURLOPT_URL             => $url,
                            CURLOPT_HTTPHEADER      => $cabecalho,
                            CURLOPT_SSL_VERIFYPEER => false
                            ]);

                        if($data != null){
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                            curl_setopt($curl, CURLOPT_POST, 1);
                        }else{
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array()));
                        }
                        $response = curl_exec($curl);
                        curl_close($curl);
                        if(!$response){
                            throw new Exception('Parâmetros da requisição inválidos');
                        }
                        return  $response;

                        }catch(Exception $e){                          
                            throw new Exception('erro na chamada GET: '.$e->getMessage());
                        }
                    break;
                case 'POST':
                    try{
                        $curl = curl_init();
                        if($this->showUrl){
                            print($url);
                        }
                        curl_setopt_array($curl, [
                            CURLOPT_RETURNTRANSFER  => true,
                            CURLOPT_CUSTOMREQUEST   => $method,
                            CURLOPT_URL             => $url,
                            CURLOPT_HTTPHEADER      => $cabecalho,
                            CURLOPT_SSL_VERIFYPEER => false
                            ]);
                        
                        if($data != null){
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                            curl_setopt($curl, CURLOPT_POST, 1);
                        }else{
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array()));
                        }
                        $response = curl_exec($curl);
                        curl_close($curl);
                        return  $response;
                    }catch(Exception $e){
                        throw new Exception('erro na chamada POST '.$e->getMessage());
                    }
                    break;
                case 'PUT':
                    try{
                        $curl = curl_init();
                        if($this->showUrl){
                            print($url);
                        }
                        curl_setopt_array($curl, [
                            CURLOPT_RETURNTRANSFER  => true,
                            CURLOPT_CUSTOMREQUEST   => $method,
                            CURLOPT_URL             => $url,
                            CURLOPT_HTTPHEADER      => $cabecalho,
                            CURLOPT_SSL_VERIFYPEER => false
                            ]);
                            
                        if($data != null){
                            curl_setopt($curl, CURLOPT_POSTFIELDS , json_encode($data));
                            curl_setopt($curl, CURLOPT_POST, 1);
                        }else{
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array()));
                        }
                        $response = curl_exec($curl);
                        curl_close($curl);
                        return  $response;
                }catch(Exception $e){
                    throw new Exception('erro na chamada PUT '.$e->getMessage());
                }

                    break;
                case 'DELETE':
                    try{
                       $curl = curl_init();
                       if($this->showUrl){
                        print($url);
                    }
                        curl_setopt_array($curl, [
                            CURLOPT_RETURNTRANSFER  => true,
                            CURLOPT_CUSTOMREQUEST   => $method,
                            CURLOPT_URL             => $url,
                            CURLOPT_HTTPHEADER      => $cabecalho,
                            CURLOPT_SSL_VERIFYPEER => false
                            ]);
                       
                        if($data != null){
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                            curl_setopt($curl, CURLOPT_POST, 1);
                        }else{
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array()));
                        }
                        $response = curl_exec($curl);
                        curl_close($curl);
                        return  $response;
                    }catch(Exception $e){
                        throw new Exception('erro na chamada DELETE '.$e->getMessage());
                    }

                    break;
                default:
                    throw new Exception('Method não implementado na interface cliente da API');
            }
        } catch (Exception $e) {
            return $e->getmessage();
        }
    }

    private function excecuteCurl($url, $method, $dados = null){
        $token = "lsfkjl";
        $curl = curl_init();
        $cabecalho = array('Content-Type: application/json', 'Accept: application/json', 'Content-Length: 0');
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CUSTOMREQUEST   => $method,
            CURLOPT_URL             => $url,
            CURLOPT_HTTPHEADER      => $cabecalho
            ]);
        
        if($dados != null){
            // dd($dados);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($curl, CURLOPT_POST, 1);
        }
        // dd($dados);
        $response = curl_exec($curl);
        curl_close($curl);
        return  $response;
    }
}
?>