<?php

namespace Models;
use Lib\DB;
use Lib\Model;

/**
 * Modelo de um funcionario
 */
class Funcionario {
    /**
     * ID do funcionario
     * @var integer
     */
	private $idFuncionario;
    /**
     * Nome do funcionario
     * @var string
     */
	private $nome;
    /**
     * diretorio Imagem
     * @var string
     */
	private $imagem;
    /**
     * Cargo do funcionário
     * @var string
     */
	private $cargo;

	public function __construct($idFuncionario, $nome, $imagem, $cargo) {
		$this->idFuncionario = $idFuncionario;
		$this->nome = $nome;
		$this->imagem = $imagem;
		$this->cargo = $cargo; 
	}

    /**
     * Retorna um funcionario a partir de seu id
     * @param integer $id ID do Funcionario
     * @return Funcionario
     * @throws \Exception
     */
	public static function getById($idFuncionario) {
		$conn = DB::getConnection();
            
        $query = "SELECT `idFuncionario`, `nome`, `imagem`, `cargo` FROM `Funcionario` WHERE `idFuncionario` = ?;";
        
        $stmt = $conn->prepare($query);            
        if($stmt === FALSE){
            throw new \Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }            
        if($stmt->bind_param("i", $idFuncionario) === FALSE){
            throw new \Exception("Falha ao associar parâmetros. Erro: {$stmt->error} ");
        }
        
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }            
        $result = $stmt->get_result();            
       
        if($row = $result->fetch_assoc()){
            $funcionario = new Funcionario($row['idFuncionario'], $row['nome'], $row['imagem'], $row['cargo']);
        } else {
            $funcionario = NULL;
        }
        $result->close();             
        return $funcionario;
	}

    /**
     * Retorna uma lista de todos funcionarios
     * @return Funcionarios
     * @throws \Exception
     */
	public static function getFuncionarios() {
        $funcionarios = [];

		$conn = DB::getConnection();
            
        $query = "SELECT `idFuncionario`, `nome`, `imagem`, `cargo` FROM `Funcionario`;";
        
        $result = $conn->query($query);
         
        if($result === FALSE){
            throw new \Exception("Falha ao carregar lista de funcionários. Erro: {$conn->error} ");
        }
        while($row = $result->fetch_assoc()){
            $funcionarios[] = new Funcionario($row['idFuncionario'], $row['nome'], $row['imagem'], $row['cargo']);
        }
        $result->close();
         
        return $funcionarios;            
	}

    /**
     * Insere um funcionario no banco de dados     
     * @param $funcionario objeto funcionario
     * @throws \Exception
     */
	public static function insere($funcionario) {
		$conn = DB::getConnection();   
            
        $query = 'INSERT INTO `Funcionario` (`nome`, `imagem`, `cargo`) VALUES (?,?,?);';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }

        $nome = $funcionario->getNome();	
        $imagem = $funcionario->getImagem();	
        $cargo = $funcionario->getCargo();

        if($stmt->bind_param("sss", $nome, $imagem, $cargo) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
    }

    /**
     * Atualiza um funcionario no banco de dados     
     * @param $funcionario objeto funcionario
     * @throws \Exception
     */
	public static function atualiza($funcionario) {
		$conn = DB::getConnection();   
            
        $query = 'UPDATE `Funcionario` SET `nome` = ?, `imagem`=?, `cargo`=? WHERE `idFuncionario` = ?;';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }

        $idFuncionario = $funcionario->getIdFuncionario();
        $nome = $funcionario->getNome();	
        $imagem = $funcionario->getImagem();	
        $cargo = $funcionario->getCargo();	
        
        if($stmt->bind_param("sssi", $nome, $imagem, $cargo, $idFuncionario) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

    /**
     * Deleta um funcionario do banco de dados     
     * @param integer $idFuncionario ID do Funcionario
     * @throws \Exception
     */
	public static function deleta($idFuncionario) {
		$conn = DB::getConnection();   
            
        $query = 'DELETE FROM `Funcionario` WHERE `idFuncionario` = ?;';
        $stmt = $conn->prepare($query);
        if($stmt == FALSE){
            throw new Exception("Falha ao preparar query. Erro: {$conn->error} ");
        }
        if($stmt->bind_param("i",  $idFuncionario) === FALSE){
            throw new \Exception("Falha ao assossiar parâmetros. Erro: {$stmt->error}");
        }
        if($stmt->execute() === FALSE){
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error} ");
        }      
        $stmt->close();
	}

	public function getIdFuncionario(){
		return $this->idFuncionario;
	}

	public function setIdFuncionario($idFuncionario){
		$this->idFuncionario = $idFuncionario;
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

	public function getCargo(){
		return $this->cargo;
	}

	public function setCargo($cargo){
		$this->cargo = $cargo;
	}
}
