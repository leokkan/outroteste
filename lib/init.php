<?php

set_include_path(ROOT);
spl_autoload_extensions('.php');
spl_autoload_register();

require_once ROOT . DS . 'config' . DS . 'config.php';

/**
 * Chamada simplificada para tradução
 * @param String $key Chave de tradução
 * @param String $default String padrão
 * @return String String traduzida
 */
function __($key, $default = '') {
    return \Lib\Lang::get($key, $default);
}
