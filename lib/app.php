<?php

namespace Lib;

use Lib\Router;
use Lib\View;
use Lib\Lang;

/**
 * Classe principal do Site
 */
class App {

    /**
     * Router desta execução
     * @var Router
     */
    protected static $router;

    /**
     * Retorna o Router desta execução
     * @return Router router
     */
    static function getRouter() {
	return self::$router;
    }

    /**
     * Processa uma requisição para a página
     * @throws \Exception Algo deu errado
     */
    public static function run() {
	// Carrega o router e o idioma
	self::$router = new Router();
	Lang::load(self::$router->getLanguage());

	// Carrega informações do controller
	$controller_class = 'Controllers\\' . ucfirst(self::$router->getController()) . 'Controller';
	$controller_method = strtolower(self::$router->getMethodPrefix() . self::$router->getAction());

	// Verifica a necessidade de autenticação
	$layout = self::$router->getRoute();
	if ($layout == 'admin' &&
		(Session::get('usuario') == NULL || Session::get('usuario')->getCargo() != 'admin')
	) {
	    if ($controller_method != 'admin_login') {
		Router::redirect(self::$router->getUrl('usuario', 'login', [], 'admin'));
	    }
	}

	// Chama o controller
	$controller = new $controller_class();
	if (method_exists($controller, $controller_method)) {
	    $view_path = $controller->$controller_method(...self::$router->getParams());
	    $view_object = new View($controller->getData(), $view_path);

	    // Renderiza a view interna
	    $content = $view_object->render();
	} else {
	    throw new \Exception("Método {$controller_method} da classe {$controller_class} não existe.");
	}

	// Renderiza a página final e exibe
	$layout_path = VIEW_PATH . DS . $layout . '.php';
	$layout_view_object = new View(compact('content'), $layout_path);
	echo $layout_view_object->render();
    }

}
