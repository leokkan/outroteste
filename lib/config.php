<?php

namespace Lib;

/**
 * Classe de configurações do sistema
 */
class Config {

    /**
     * Array de configurações
     * @var String[]
     */
    protected static $settings = [];

    /**
     * Retorna o valor de uma configuração
     * @param String $key nome da configuração
     * @return Any valor da configuração ou NULL se não existir
     */
    public static function get($key) {
	return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    /**
     * Define o valor de uma configuração
     * @param String $key nome da configuração
     * @param Any $value valor da configuração
     */
    public static function set($key, $value) {
	self::$settings[$key] = $value;
    }

}
