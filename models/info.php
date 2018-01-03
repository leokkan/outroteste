<?php
 
namespace Models;
use Lib\DB;
use Lib\Model;
 
/**
 * Modelo de Info
 */
class Info {
    /**
     * chave da Info
     * @var integer
     */
    private $chave;
    /**
     *
     * @var string
     */
    private $conteudo;
 
    public function __construct($chave, $conteudo) {       
        $this->chave = $chave;
        $this->conteudo = $conteudo;
    }
 
    /**
     * Retorna Info a partir de sua chave
     * @param integer $chave chave da info
     * @return Info
     * @throws \Exception
     */
    public static function getByChave($chave) {
        $conn = DB::getConnection();
           
        $query = "SELECT `chave`, `conteudo` FROM `Info` WHERE `chave` = ?;";
       
        $stmt = $conn->prepare($query);            
        if($stmt === FALSE){
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }            
        if($stmt->bind_param("s", $chave) === FALSE){
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error} ");
        }        
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }            
        $result = $stmt->get_result();            
       
        if($row = $result->fetch_assoc()){
            $info = new Info($row['chave'], $row['conteudo']);
        } else {
            $info = NULL;
        }
        $result->close();            
        return $info;
    }
 
    /**
     * Retorna lista de Infos a partir de suas chaves
     * @param integer $chaves
     * @return Infos
     * @throws \Exception
     */
    public static function getByChaves($chaves) {
        $conn = DB::getConnection();
       
        $bindClause = implode(',', array_fill(0, count($chaves), '?'));
        $bindString = str_repeat('s', count($chaves));
           
        $query = "SELECT `chave`, `conteudo` FROM `Info` WHERE `chave` IN (" . $bindClause . ");";
        
        $stmt = $conn->prepare($query);

        if($stmt === FALSE){
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }          
        if($stmt->bind_param($bindString, ...$chaves) === FALSE){
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error} ");
        }        
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }            
        $result = $stmt->get_result();
        //var_dump($result); die();
        $infos =[];
        while($row = $result->fetch_assoc()){
            $infos[$row['chave']] = new Info($row['chave'], $row['conteudo']);
        }
        $result->close();
        return $infos;
    }
 
    /**
     * atualiza ou insere info caso não exista
     * @param integer $chaves
     * @return Infos
     * @throws \Exception
     */
    public static function atualiza($info) {
        $conn = DB::getConnection();  
           
        $query = 'REPLACE INTO `Info`(`chave`,`conteudo`) VALUES (?,?);';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }
 
        $chave = $info->getChave();
        $conteudo = $info->getConteudo();  
       
        if($stmt->bind_param("ss", $chave, $conteudo) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
    }
 
    public function getChave(){
        return $this->chave;
    }
 
    public function setChave($chave){
        $this->chave = $chave;
    }
 
    public function getConteudo(){
        return $this->conteudo;
    }
 
    public function setConteudo($conteudo){
        $this->conteudo = $conteudo;
    }
}