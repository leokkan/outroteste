<?php

use Lib\DB;

/**
 * Cria as tabelas do projeto
 * - Cria tabela de Produtos, Funcionarios, Parceiros, Slides e Informações
 */
class Migration_20171220184000 extends Lib\Migration {

    public function __construct() {
        $this->desc = 'Cria as tabelas bases do projeto';
    }

    public function apply() {
        $queries = [];

        // Desativa verificações de integridade para que as queries possam ser executadas
        $queries[] = "SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;";
        $queries[] = "SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;";
        $queries[] = "SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';";

        // ==== Queries ====
        
        // Tabela Produto
        $queries[] = 
                "CREATE TABLE IF NOT EXISTS `Produto` (
                    `idProduto` BIGINT NOT NULL AUTO_INCREMENT,
                    `nome` VARCHAR(255) NOT NULL,
                    `imagem` VARCHAR(255) NOT NULL,
                    `descricao` TEXT NOT NULL,
                    PRIMARY KEY (`idProduto`))
                ENGINE = InnoDB;";

        // Tabela Funcionario
        $queries[] =
                "CREATE TABLE IF NOT EXISTS `Funcionario` (
                    `idFuncionario` BIGINT NOT NULL AUTO_INCREMENT,
                    `nome` VARCHAR(255) NOT NULL,
                    `imagem` VARCHAR(255) NOT NULL,
                    `cargo` VARCHAR(100) NOT NULL,
                    PRIMARY KEY (`idFuncionario`))
                ENGINE = InnoDB;";
        
        // Tabela Parceiro
        $queries[] =
                "CREATE TABLE IF NOT EXISTS `Parceiro` (
                    `idParceiro` BIGINT NOT NULL AUTO_INCREMENT,
                    `nome` VARCHAR(100) NOT NULL,
                    `imagem` VARCHAR(255) NOT NULL,
                    `site` VARCHAR(255) NOT NULL,
                    `ordem` TINYINT NOT NULL,
                    PRIMARY KEY (`idParceiro`))
                ENGINE = InnoDB;";


        // Tabela Slide
        $queries[] = 
                "CREATE TABLE IF NOT EXISTS `Slide` (
                    `idSlide` BIGINT NOT NULL AUTO_INCREMENT,
                    `imagem` VARCHAR(255) NOT NULL,
                    `ordem` TINYINT NOT NULL,
                    PRIMARY KEY (`idSlide`))
                ENGINE = InnoDB;";

        // Tabela Info
        $queries[] =
                "CREATE TABLE IF NOT EXISTS `Info` (
                    `chave` VARCHAR(255) NOT NULL,
                    `conteudo` TEXT NOT NULL,
                    PRIMARY KEY (`chave`),
                    UNIQUE INDEX `chave_UNIQUE` (`chave` ASC),
                    INDEX `chave_INDEX` (`chave` ASC))
                ENGINE = InnoDB;";


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