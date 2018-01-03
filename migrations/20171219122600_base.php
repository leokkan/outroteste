<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Lib\DB;

/**
 * Instala a base do framework
 * - Cria tabela de Usuários
 * - Cria um usuário admin com usuário 'admin' e senha '1234'
 */
class Migration_20171219122600 extends Lib\Migration {

    public function __construct() {
        $this->desc = 'Base do Framework';
    }

    public function apply() {
        $queries = [];

        // Desativa verificações de integridade para que as queries possam ser executadas
        $queries[] = "SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;";
        $queries[] = "SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;";
        $queries[] = "SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';";

        $queries[] = "
            CREATE TABLE IF NOT EXISTS `Usuario` (
                `idUsuario` BIGINT NOT NULL AUTO_INCREMENT,
                `nome` VARCHAR(100) NOT NULL,
                `usuario` VARCHAR(30) NOT NULL,
                `senha` VARCHAR(255) NOT NULL,
                `cargo` VARCHAR(45) NOT NULL,
                `ativo` TINYINT NOT NULL DEFAULT 1,
                PRIMARY KEY (`idUsuario`),
                UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC)
            )
            ENGINE = InnoDB;";
        $queries[] = "
            INSERT INTO `Usuario` 
                (`idUsuario`, `nome`, `usuario`, `senha`, `cargo`, `ativo`) 
                VALUES
                (1, 'Admin', 'admin', '$2y$10\$ZB8LqCg2f90AFdOVQM1FtuyyshBd2wkiv5im12O9rKTyKa9J0RpIO', 'admin', 1);
        ";

        // Reativa as verificações de integridade
        $queries[] = "SET SQL_MODE=@OLD_SQL_MODE;";
        $queries[] = "SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;";
        $queries[] = "SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;";

        $con = DB::getConnection();
        foreach ($queries as $query) {
            if ($con->query($query) === FALSE) {
                throw new \Exception($con->error);
            }
        }
    }

}
