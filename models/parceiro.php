<?php

namespace Models;

use Lib\Model;
use Lib\DB;

/**
 * Modelo de um Parceiro
 */
class Parceiro extends Model{
    /**
     * ID do Parceiro
     * @var integer
     */
	private $idParceiro;
    /**
     * nome do parceiro
     * @var string
     */
	private $nome;
    /**
     * diretorio Imagem
     * @var string
     */
	private $imagem;
    /**
     * URL site
     * @var string
     */
	private $site;
    /**
     * número de ordem
     * @var integer
     */
	private $ordem;

	public function __construct($idParceiro, $nome, $imagem, $site, $ordem) {
		$this->idParceiro = $idParceiro;
		$this->nome = $nome;
		$this->imagem = $imagem;
		$this->site = $site;
		$this->ordem = $ordem;
	}

    /**
     * Retorna um slide a partir de seu id
     * @param integer $idParceiro ID do Parceiro
     * @return Parceiro
     * @throws \Exception
     */
	public static function getById($idParceiro) {
		$conn = DB::getConnection();
            
        $query = "SELECT `idParceiro`, `nome`, `imagem`, `site`, `ordem` FROM `Parceiro` WHERE `idParceiro` = ?;";
        
        $stmt = $conn->prepare($query);            
        if($stmt === FALSE){
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }            
        if($stmt->bind_param("i", $idParceiro) === FALSE){
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error} ");
        }
        
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }            
        $result = $stmt->get_result();            
       
        if($row = $result->fetch_assoc()){
            $parceiro = new Parceiro($row['idParceiro'], $row['nome'], $row['imagem'], $row['site'], $row['ordem']);
        } else {
            $parceiro = NULL;
        }
        $result->close();             
        return $parceiro;
	}

    /**
     * Retorna uma lista de todos os parceiros
     * @return Parceiros
     * @throws \Exception
     */
	public static function getParceiros() {
		$conn = DB::getConnection();
            
        $parceiros = [];
        $query = "SELECT `idParceiro`, `nome`, `imagem`, `site`, `ordem` FROM `Parceiro`;";
        
        $result = $conn->query($query);
         
        if($result === FALSE){
            throw new \Exception("Falha ao carregar lista de parceiros. Erro: {$conn->error} ");
        }
        while($row = $result->fetch_assoc()){
            $parceiros[] = new Parceiro($row['idParceiro'], $row['nome'], $row['imagem'], $row['site'], $row['ordem']);
        }
        $result->close();
         
        return $parceiros; 
	}

    /**
     * Insere um Parceiro no banco de dados     
     * @param $parceiro objeto Parceiro
     * @throws \Exception
     */
	public static function insere($parceiro) {
		$conn = DB::getConnection();   
            
        $query = 'INSERT INTO `Parceiro` (`nome`, `imagem`, `site`, `ordem`) VALUES (?,?,?,?);';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }

        $nome = $parceiro->getNome();	
        $imagem = $parceiro->getImagem();	
        $site = $parceiro->getSite();
        $ordem = $parceiro->getOrdem();

        if($stmt->bind_param("sssi", $nome, $imagem, $site, $ordem) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

    /**
     * Atualiza um Parceiro no banco de dados     
     * @param $parceiro objeto Parceiro
     * @throws \Exception
     */
	public static function atualiza($parceiro) {
		$conn = DB::getConnection();   
            
        $query = 'UPDATE `Parceiro` SET `nome` = ?, `imagem`=?, `site`=?, `ordem`=? WHERE `idParceiro` = ?;';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }

        $idParceiro = $parceiro->getIdParceiro();
        $nome = $parceiro->getNome();	
        $imagem = $parceiro->getImagem();	
        $site = $parceiro->getSite();
        $ordem = $parceiro->getOrdem();

        if($stmt->bind_param("sssii", $nome, $imagem, $site, $ordem, $idParceiro) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

    /**
     * Deleta um Parceiro no banco de dados     
     * @param integer $idParceiro ID do Parceiro
     * @throws \Exception
     */
	public static function deleta($idParceiro) {
		$conn = DB::getConnection();   
            
        $query = 'DELETE FROM `Parceiro` WHERE `idParceiro` = ?;';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }
        if($stmt->bind_param("i",  $idParceiro) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

	public function getIdParceiro(){
		return $this->idParceiro;
	}

	public function setIdParceiro($idParceiro){
		$this->idParceiro = $idParceiro;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getImagem(){
		return $this->imagem;
	}

	public function setImagem($imagem){
		$this->imagem = $imagem;
	}

	public function getSite(){
		return $this->site;
	}

	public function setSite($site){
		$this->site = $site;
	}

	public function getOrdem(){
		return $this->ordem;
	}

	public function setOrdem($ordem){
		$this->ordem = $ordem;
	}
}
