<?php

namespace Lib;

/**
 * Classe para trabalhar com Sessões
 */
class Session {

    /**
     * Define um valor para um chave na sessão
     * @param string $key chave
     * @param mixed $val valor
     */
    public static function set($key, $val) {
	$_SESSION[$key] = $val;
    }

    /**
     * Retorna o valor para uma chave na sessão
     * @param string $key chave
     * @return mixed
     */
    public static function get($key) {
	return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
    }

    /**
     * Deleta um valor da sessão
     * @param string $key chave
     */
    public static function delete($key) {
	if (isset($_SESSION[$key])) {
	    unset($_SESSION[$key]);
	}
    }

    /**
     * Define uma mensagem Flash
     * @param string $message mensagem
     */
    public static function setFlash($message) {
	Session::set('flash_message', $message);
    }

    /**
     * Retorna se existe uma mensagem flash
     * @return boolean
     */
    public static function hasFlash() {
	return !is_null(Session::get('flash_message'));
    }

    /**
     * Mostra a mensagem flash
     */
    public static function flash() {
	if (Session::hasFlash()) {
	    echo Session::get('flash_message');
	    Session::delete('flash_message');
	}
    }

    /**
     * Destrói a sessão do usuario
     */
    public static function destroy() {
	session_destroy();
    }

}
