<?php

namespace Models;
use Lib\DB;
use Lib\Model;
/**
 * Modelo de um Produto
 */
class Produto extends Model{
    /**
     * ID do produto
     * @var integer
     */
	private $idProduto;
    /**
     * Nome do produto
     * @var string
     */
	private $nome;
    /**
     * diretorio Imagem
     * @var string
     */
	private $imagem;
    /**
     * descrição do produto
     * @var string
     */
	private $descricao;

	public function __construct($idProduto, $nome, $imagem, $descricao) {
		$this->idProduto = $idProduto;
		$this->nome = $nome;
		$this->imagem = $imagem;
		$this->descricao = $descricao;
	}

    /**
     * Retorna um produto a partir de seu id
     * @param integer $idProduto ID do Produto
     * @return Produto
     * @throws \Exception
     */
	public static function getById($idProduto) {
		$conn = DB::getConnection();
            
        $query = "SELECT `idProduto`, `nome`, `imagem`, `descricao` FROM `produto` WHERE `idProduto` = ?;";
        
        $stmt = $conn->prepare($query);            
        if($stmt === FALSE){
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }            
        if($stmt->bind_param("i", $idProduto) === FALSE){
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error} ");
        }
        
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }            
        $result = $stmt->get_result();            
       
        if($row = $result->fetch_assoc()){
            $produto = new Produto($row['idProduto'], $row['nome'], $row['imagem'], $row['descricao']);
        } else {
            $produto = NULL;
        }
        $result->close();             
        return $produto;
	}

    /**
     * Retorna uma lista de todos produtos
     * @return Produtos
     * @throws \Exception
     */
	public static function getProdutos() {	
         $produtos = [];	
		$conn = DB::getConnection();
            
        $query = "SELECT `idProduto`, `nome`, `imagem`, `descricao` FROM `Produto`;";
        
        $result = $conn->query($query);
         
        if($result === FALSE){
            throw new \Exception("Falha ao carregar lista de produtos. Erro: {$conn->error} ");
        }
        while($row = $result->fetch_assoc()){
            $produtos[] = new Produto($row['idProduto'], $row['nome'], $row['imagem'], $row['descricao']);
        }
        $result->close();
         
        return $produtos; 
	}

    /**
     * Insere um Produto no banco de dados     
     * @param $produto objeto Produto
     * @throws \Exception
     */
	public static function insere($produto) {
		$conn = DB::getConnection();   
            
        $query = 'INSERT INTO `Produto` (`nome`, `imagem`, `descricao`) VALUES (?,?,?);';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }

        $nome = $produto->getNome();	
        $imagem = $produto->getImagem();	
        $descricao = $produto->getDescricao();

        if($stmt->bind_param("sss", $nome, $imagem, $descricao) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

    /**
     * Atualiza um Produto no banco de dados     
     * @param $produto objeto Produto
     * @throws \Exception
     */    
	public static function atualiza($produto) {
		$conn = DB::getConnection();   
            
        $query = 'UPDATE `Produto` SET `nome` = ?, `imagem`=?, `descricao`=? WHERE `idProduto` = ?;';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }

        $idProduto = $produto->getIdProduto();
        $nome = $produto->getNome();	
    	$imagem = $produto->getImagem();	
    	$descricao = $produto->getDescricao();	
        
        if($stmt->bind_param("sssi", $nome, $imagem, $descricao, $idProduto) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

    /**
     * Deleta um Produto do banco de dados     
     * @param integer $idProduto ID do Produto
     * @throws \Exception
     */
	public static function deleta($idProduto) {
		$conn = DB::getConnection();   
            
        $query = 'DELETE FROM `Produto` WHERE `idProduto` = ?;';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }
        if($stmt->bind_param("i",  $idProduto) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

	public function getIdProduto(){
		return $this->idProduto;
	}

	public function setIdProduto($idProduto){
		$this->idProduto = $idProduto;
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

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
}
