<?php
namespace App\Ldap;
use iluminate\contracts\filesystem\ErrorException;
use Illuminate\Support\Facades\Auth;
//use App\Log;

//use Illuminate\Support\Facades\Redirect;



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author medeiros
 * 
 */







class Authldap {
    protected $ldap_dn;
    protected $ldap_password;
    protected $ldap_con;
   // protected $nome_ad = 'sesed.interno';
    protected $nome_ad = 'pm.govrn'; //'sesed.interno';;
    //protected $ldap_ip ='';
    protected $ldap_ip = 'ldap://10.9.192.95';
    protected $login_credencial_name = 'st_cpf';
    protected $password_credencial_name = 'password';

 public function __construct(){
				//$this->nome_ad = 'sesed.interno';
                //$this->ldap_ip = '';
                //$this->ldap_con = ldap_connect($this->nome_ad);
	
		 
        if(env('AD_HOST')){
			
            //seta configurações baseado no tipo de AD
            if(env('AD_HOST')=='SESED'){
                //ad da sesed
                $this->nome_ad = 'sesed.interno';
                $this->ldap_ip = '';
                $this->ldap_con = ldap_connect($this->nome_ad);
            }else{
                //ad da pm
                $this->nome_ad = 'pm.govrn';
                $this->ldap_ip = 'ldap://10.9.192.95';
                $this->ldap_con = ldap_connect($this->ldap_ip);
            }
        }else{
            throw new \Exception("Não encontrada a variável AD_HOST no arquivo .env");            
        }
    }

    /**
     * Este método Deve ser excluído após refatorar o sistema para consumir o método autenticar na hora de verificar as credenciais no AD
     */

    public function autentica($credenciais) {
        $this->ldap_dn = $this->get_user_name($credenciais);
        $this->ldap_password = $credenciais[$this->password_credencial_name];
        try{
            ldap_bind($this->ldap_con, $this->ldap_dn, $this->ldap_password);
        }catch(\ErrorException $e){
            return false;
        }
        

        if(ldap_bind($this->ldap_con, $this->ldap_dn, $this->ldap_password)){
            return true;
        }else{
            return false;
        }
        
         
        $ldapbind = ldap_bind($this->ldap_con, $this->ldap_dn, $this->ldap_password) ;
      
    }
   
    protected function get_user_name($credenciais){
        $cpf = $credenciais['st_cpf'];
        //return $credenciais[$this->login_credencial_name].'@'.$this->nome_ad;
        //return '00899101410'.'@'.$this->nome_ad;
        $cpf = preg_replace("/\D+/", "", $cpf); // remove qualquer caracter não numérico
        
        return $cpf.'@'.$this->nome_ad;
        
    }
      

}
