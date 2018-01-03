<?php

namespace Lib;

/**
 * Classe para renderizar Views
 */
class View {

    /**
     * Dados para a view
     * @var array
     */
    protected $data;
    /**
     * Caminho da view
     * @var string
     */
    protected $path;

    /**
     * Retorna o caminho padrão da view
     * @return string
     */
    protected static function getDefaultViewPath() {
	$router = App::getRouter();

	if (!$router) {
	    return false;
	}

	$controller_dir = $router->getController();
	$template_name = $router->getMethodPRefix() . $router->getAction() . '.php';

	return VIEW_PATH . DS . $controller_dir . DS . $template_name;
    }

    /**
     * Cria uma nova View
     * @param array() $data
     * @param string $path
     * @throws \Exception
     */
    public function __construct($data = array(), $path = null) {
	if (!$path) {
	    $path = self::getDefaultViewPath();
	}

	if (!file_exists($path)) {
	    throw new \Exception("Template não foi encontrado: {$path}");
	}

	$this->data = $data;
	$this->path = $path;
    }

    /**
     * Cria o código de renderização
     * @return string
     */
    public function render() {
	$data = $this->data;

	ob_start();
	include $this->path;
	$content = ob_get_clean();

	return $content;
    }

}
