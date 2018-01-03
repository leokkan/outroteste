<?php

namespace Controllers;

use Lib\App;
use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Models\Usuario;

/**
 * Controla funcionalidades relacioandas ao usuário.
 */
class UsuarioController extends Controller {

    /**
     * Tela de Login
     */
    public function admin_login() {
	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
	    // Tratamento dos campos
	    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
	    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

	    // Validação
	    if ($login == FALSE || $senha == FALSE) {
		Session::setFlash('Todos os campos são obrigatórios.');
		Router::redirect(App::getRouter()->getUrl('usuario', 'login', [], 'admin'));
	    }

	    // Verificação de login
	    $usuario = Usuario::getByLogin($login);
	    if ($usuario == NULL || password_verify($senha, $usuario->getSenha()) == FALSE) {
		Session::setFlash('Não foi possível encontrar um usuário com os dados informados.');
	    } else if ($usuario->getAtivo() == FALSE) {
		Session::setFlash('Usuário está desativado.');
	    } else {
		// Tudo certo, logado!
		Session::set('usuario', $usuario);
	    }

	    Router::redirect(App::getRouter()->getUrl('', '', [], 'admin'));
	}
    }

    /**
     * Ação de logout
     */
    public function admin_logout() {
	Session::destroy();
	Router::redirect(App::getRouter()->getUrl('', '', [], 'admin'));
    }

}
