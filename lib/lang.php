<?php

namespace Lib;

/**
 * Classe que lida com a localização (idiomas).
 */
class Lang {

    /**
     * Lista de valores de tradução
     * @var Array
     */
    protected static $data;

    /**
     * Carrega o arquivo de tradução do idioma
     * @param String $lang_code idioma
     * @throws \Exception
     */
    public static function load($lang_code) {
	$lang_path = ROOT . DS . 'lang' . DS . strtolower($lang_code) . '.php';

	if (file_exists($lang_path)) {
	    self::$data = include $lang_path;
	} else {
	    throw new \Exception("Arquivo de idioma não foi encontrado: {$lang_path}");
	}
    }

    /**
     * Retorna a tradução de uma String a partir da chave
     * @param String $key chave da frase
     * @param String $default Valor padrão
     * @return String
     */
    public static function get($key, $default = '') {
	return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default;
    }

}
