<?php

namespace Lib;

use Lib\Config;

/**
 * Classe de suporte a aplicação de alterações do BD (Migrações)
 */
abstract class Migration {

    /**
     * Retorna o IP do client
     * @return String ip do client
     */
    private static function getClientIp() {
        // Nothing to do without any reliable information
        if (!filter_input(INPUT_SERVER, 'REMOTE_ADDR')) {
            return NULL;
        }

        // Header that is used by the trusted proxy to refer to
        // the original IP
        $proxy_header = "HTTP_X_FORWARDED_FOR";

        // List of all the proxies that are known to handle 'proxy_header'
        // in known, safe manner
        $trusted_proxies = array("2001:db8::1", "192.168.50.1");

        if (in_array(filter_input(INPUT_SERVER, 'REMOTE_ADDR'), $trusted_proxies)) {

            // Get the IP address of the client behind trusted proxy
            if (array_key_exists($proxy_header, $_SERVER)) {

                // Header can contain multiple IP-s of proxies that are passed through.
                // Only the IP added by the last proxy (last IP in the list) can be trusted.
                $proxy_list = explode(",", filter_input(INPUT_SERVER, $proxy_header));
                $client_ip = trim(end($proxy_list));

                // Validate just in case
                if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
                    return $client_ip;
                } else {
                    // Validation failed - beat the guy who configured the proxy or
                    // the guy who created the trusted proxy list?
                    // TODO: some error handling to notify about the need of punishment
                }
            }
        }

        // In all other cases, REMOTE_ADDR is the ONLY IP we can trust.
        return filter_input(INPUT_SERVER, 'REMOTE_ADDR');
    }

    /**
     * Verifica se pode executar migrações
     * @return boolean TRUE se está permitido
     * @throws \Exception caso não possa executar
     */
    private static function checkAllowed() {
        if (!Config::get('migrate.allow')) {
            throw new \Exception('Migrações estão desabilitadas.');
        }

        if (Config::get('migrate.limit_ip')) {
            $clientIp = self::getClientIp();
            if (!in_array($clientIp, Config::get('migrate.allow_ips'))) {
                throw new \Exception('Cliente não autorizado a realizar migrações.');
            }
        }
    }

    /**
     * Cria a tabela de migrações se não existir.
     */
    private static function checkMigrationsTable() {
        $con = DB::getConnection();

        $query = "CREATE TABLE IF NOT EXISTS `Migration` ("
                . "       `idMigration` BIGINT NOT NULL,"
                . "       `descricao` VARCHAR(255) NULL,"
                . "       PRIMARY KEY (`idMigration`)"
                . ")"
                . "ENGINE = InnoDB";

        if ($con->query($query) === FALSE) {
            throw new \Exception("Falha ao criar tabela de migrações. Erro: " . $con->error);
        }

        return;
    }

    /**
     * Retorna a lista de arquivos de migração
     * @return Array ('id' => 'arquivo')
     */
    private static function getMigrations() {
        $files = array_diff(
                scandir('../migrations'), array('..', '.', 'index.html')
        );

        $migrations = [];

        // {YYYYMMDDHHNNSS}*****
        foreach ($files as $file) {
            $id = substr($file, 0, 14);

            if (is_numeric($id)) {
                $migrations[$id] = $file;
            }
        }

        return $migrations;
    }

    /**
     * Retorna a lista de migrações aplicadas
     * @return Array lista de migrações
     * @throws \Exception
     */
    private static function getAppliedMigrations() {
        $con = DB::getConnection();

        $query = "SELECT `idMigration` FROM `Migration` ORDER BY `idMigration` ASC";

        if (($result = $con->query($query)) == FALSE) {
            throw new \Exception("Falha ao carregar migrações aplicadas. Erro: " . $con->error);
        }

        $migrations = [];
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $migrations[$row["idMigration"]] = true;
        }

        return $migrations;
    }

    /**
     * Adiciona uma migração a lista de migrações aplicadas
     * @param int $id ID da migração
     * @param String $desc Descrição da migração
     * @throws \Exception Caso algo de errado na query
     */
    private static function addAppliedMigration($id, $desc) {
        $con = DB::getConnection();

        $query = "INSERT INTO `Migration` (`idMigration`, `descricao`) VALUES (?, ?)";
        if (($stmt = $con->prepare($query)) === FALSE) {
            throw new \Exception("Falha ao preparar query. Erro: {$con->error}");
        }

        if ($stmt->bind_param('is', $id, $desc) === FALSE) {
            throw new \Exception("Falha ao associar parametros. Erro: {$stmt->error}");
        }

        if ($stmt->execute() === FALSE) {
            throw new \Exception("Falha ao executar query. Erro: {$stmt->error}");
        }

        $stmt->close();
    }

    /**
     * Tenta aplicar a lista de migrações dada, parando caso uma falhe
     * @param Array('id', 'file') $toApply Lista com o ID da migração e o arquivo
     * @return int número de migrações aplicadas
     * @throws \Exception Caso uma migração falhe em ser aplicada.
     */
    private static function applyMigrations($toApply) {
        $count = 0;

        foreach ($toApply as $migration) {
            try {
                include('../migrations/' . $migration['file']);
                $className = 'Migration_' . $migration['id'];
                $mig = new $className();
                $mig->apply();
                self::addAppliedMigration($migration['id'], $mig->getDesc());
                $count++;
            } catch (\Exception $ex) {
                throw new \Exception("Falha ao aplicar '{$migration['file']}'. <b>Erro: </b>{$ex->getMessage()}.");
            }
        }

        return $count;
    }

    /**
     * Aplica as migrações pendentes, se autorizado
     * @return int número de migrações aplicadas.
     * @throws \Exception Caso o processo não possa ser concluído
     */
    public static function migrate() {
        self::checkAllowed();

        self::checkMigrationsTable();

        $migrations = self::getMigrations();
        $applied = self::getAppliedMigrations();

        $toApply = [];
        foreach ($migrations as $id => $file) {
            if (!isset($applied[$id])) {
                $toApply[] = ['id' => $id, 'file' => $file];
            }
        }

        return self::applyMigrations($toApply);
    }

    // ===============================================
    // Parte relacionada a uma migração
    // Para ser usada pelas classes que herdarem essa
    // ===============================================

    /**
     * Descrição da migração (até 255 caractéres)
     * @var String
     */
    protected $desc;

    /**
     * Retorna a descrição dessa migração.
     * @return String
     */
    public function getDesc() {
        // Não deve passar de 255 caractéres (limite do BD)
        return substr($this->desc, 0, 255);
    }

    /**
     * Aplica a migração
     */
    public abstract function apply();
}
