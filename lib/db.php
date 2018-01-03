<?php

namespace Lib;

/**
 * Classe com fuções de Banco de Dados
 */
class DB {

    /**
     * Conexão ativa
     * @var \mysqli
     */
    protected $connection;

    /**
     * Instância ativa
     * @var DB
     */
    protected static $instance;

    /**
     * Cria uma nova conexão com o BD
     * @param String $host host do BD
     * @param String $user usuario do BD
     * @param String $password senha do BD
     * @param String $db_name nome do BD
     * @throws \Exception Não foi possível conectar
     */
    private function __construct($host, $user, $password, $db_name) {
	$this->connection = new \mysqli($host, $user, $password, $db_name);

	if (mysqli_connect_error()) {
	    throw new \Exception("Não foi possível conectar ao Banco de Dados. Erro: " . mysqli_connect_error() . ".");
	}
    }

    /**
     * Retorna uma conexão
     * @return \mysqli conexão
     */
    public static function getConnection() {
	if (self::$instance == NULL) {
	    self::$instance = new DB(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.name'));
	}
	return self::$instance->connection;
    }

    /**
     * Fecha a conexão aberta (se existir)
     */
    public static function close() {
	if (self::$instance != NULL) {
	    if (self::$instance->connection) {
		self::$instance->connection->close();
	    }
	}
    }

}
