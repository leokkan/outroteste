<?php

namespace Models;

use Lib\DB;
use Lib\Model;

/** 
* Modelo de um usuário
*/
class Usuario extends Model {

    /**
     * ID do Usuário
     * @var integer
     */
    private $idUsuario;

    /**
     * Nome
     * @var string
     */
    private $nome;

    /**
     *
     * @var string
     */
    private $usuario;

    /**
     *
     * @var string
     */
    private $senha;

    /**
     *
     * @var string
     */
    private $cargo;

    /**
     *
     * @var boolean
     */
    private $ativo;

    /**
     * Retorna um usuário a partir de seu nome de usuário
     * @param string $login nome de usuário
     * @return Usuario
     * @throws \Exception
     */
    public static function getByLogin($login) {
	$conn = DB::getConnection();

	$query = 'SELECT `idUsuario`, `nome`, `usuario`, `senha`, `cargo`, `ativo` FROM `Usuario` WHERE `usuario` = ?';
	$stmt = $conn->prepare($query);
	if ($stmt === FALSE) {
	    throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
	}

	if ($stmt->bind_param('s', $login) === FALSE) {
	    throw new \Exception("Falha ao associar parametros. Erro: {$stmt->error}");
	}

	if ($stmt->execute() === FALSE) {
	    throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
	}

	$result = $stmt->get_result();
	if ($row = $result->fetch_assoc()) {
	    $usuario = new Usuario($row['idUsuario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo'], $row['ativo']);
	} else {
	    $usuario = NULL;
	}

	$result->close();
	$stmt->close();

	return $usuario;
    }

    /**
     * Retorna um usuário a partir do ID
     * @param integer $id ID do Usuário
     * @return Usuario
     * @throws \Exception
     */
    public static function getById($id) {
	$conn = DB::getConnection();

	$query = 'SELECT `idUsuario`, `nome`, `usuario`, `senha`, `cargo`, `ativo` FROM `Usuario` WHERE `idUsuario` = ?';
	$stmt = $conn->prepare($query);
	if ($stmt === FALSE) {
	    throw new \Exception("Falha ao preparar query. Erro: {$conn->error}");
	}

	if ($stmt->bind_param('i', $id) === FALSE) {
	    throw new \Exception("Falha ao associar parametros. Erro: {$stmt->error}");
	}

	if ($stmt->execute() === FALSE) {
	    throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
	}

	$result = $stmt->get_result();
	if ($row = $result->fetch_assoc()) {
	    $usuario = new Usuario($row['idUsuario'], $row['nome'], $row['usuario'], $row['senha'], $row['cargo'], $row['ativo']);
	} else {
	    $usuario = NULL;
	}

	$result->close();
	$stmt->close();

	return $usuario;
    }

    /**
     * Retorna o id do usuário
     * @return integer ID do Usuari
     */
    function getIdUsuario() {
	return $this->idUsuario;
    }

    /**
     * Retorna o nome do usuário
     * @return string Nome do usuário
     */
    function getNome() {
	return $this->nome;
    }

    /**
     * Retorna o login do usuário
     * @return string login do usuário
     */
    function getUsuario() {
	return $this->usuario;
    }

    /**
     * Retorna a senha do usuário
     * @return string senha do usuário
     */
    function getSenha() {
	return $this->senha;
    }

    /**
     *  Retorna o cargo do usuário
     * @return string cargo
     */
    function getCargo() {
	return $this->cargo;
    }

    /**
     * Retorna se o usuário está ativo
     * @return boolean usuário ativo
     */
    function getAtivo() {
	return $this->ativo;
    }

    /**
     * Define o id do usuário
     * @param integer $idUsuario id do usuário
     */
    function setIdUsuario($idUsuario) {
	$this->idUsuario = $idUsuario;
    }

    /**
     * Define o nome do usuário
     * @param string $nome nome do usuário
     */
    function setNome($nome) {
	$this->nome = $nome;
    }

    /**
     * Define o login do usuário
     * @param string $usuario login do usuário
     */
    function setUsuario($usuario) {
	$this->usuario = $usuario;
    }

    /**
     * Define a senha do usuário
     * @param string $senha senha do usuário
     */
    function setSenha($senha) {
	$this->senha = $senha;
    }

    /**
     * Define o cargo do usuário
     * @param string $cargo cargo do usuário
     */
    function setCargo($cargo) {
	$this->cargo = $cargo;
    }

    /**
     * Define se o usuário está ativo
     * @param boolean $ativo usuário ativo
     */
    function setAtivo($ativo) {
	$this->ativo = $ativo;
    }

    /**
     * Cria um objeto usuário
     * @param integer $idUsuario id do usuário
     * @param string $nome nome do usuário
     * @param string $usuario login do usuário
     * @param string $senha senha do usuário
     * @param string $cargo cargo do usuário
     * @param boolean $ativo se o usuário está ativo
     */
    function __construct($idUsuario, $nome, $usuario, $senha, $cargo, $ativo) {
	$this->idUsuario = $idUsuario;
	$this->nome = $nome;
	$this->usuario = $usuario;
	$this->senha = $senha;
	$this->cargo = $cargo;
	$this->ativo = $ativo;
    }

}
