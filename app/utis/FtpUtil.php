<?php
namespace App\utis;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Exception;

/**
 * envia um arquivo para o ftp
 * @author Jazon
 */
class FtpUtil
{

    public static function enviarArquivo(array $arquivo,string $caminhoArmazenamento, array $extensoesAceitas)
    {
        try {
                // verifica se o arquivo é válido
                if($arquivo['st_path']->isValid()){ 
                    $extensaoArquivo = $arquivo['st_path']->getClientOriginalExtension();

                    // verifica se a extensão é um dos tipos aceitos
                    if(in_array($extensaoArquivo ,$extensoesAceitas)){ 
                       
                        try{
                            //testa se existe o diretorio do funcionario
                            if(!Storage::disk('ftp')->exists($caminhoArmazenamento)){ 
                                //creates directory
                                Storage::disk('ftp')->makeDirectory($caminhoArmazenamento, 0775, true); 
                            }
                            //gera hash a partir do arquivo
                            $hashNome = hash_file('md5', $arquivo['st_path']); 

                            //novo nome do arquivo com base no hash
                            $novoNome = $arquivo['st_descricao'].$hashNome.'.'.$extensaoArquivo; 
                               
                            //salva arquivo no ftp
                            $resposta = Storage::disk('ftp')->put($caminhoArmazenamento.$novoNome, fopen( $arquivo['st_path'], 'r+')); 
                            if($resposta){
                                return $arquivo = array('caminho'=>$caminhoArmazenamento,'nome'=>$novoNome,'extensao'=>$extensaoArquivo);
                            }else{
                                throw new Exception('Falha ao realizar o upload do arquivo');
                            }
                
                        }catch(\RuntimeException $e){
                            throw new Exception($e->getMessage());
                        }
                    }else{
                        throw new Exception('Falha ao realizar o upload, algum dos arquivos não tem o formato esperado '.implode(', ',$extensoesAceitas));
                    }
                }else{
                    throw new Exception('Falha ao realizar o upload, o arquivo não é válido.');
                }
            
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
 
 
}
