<?php

namespace Lib;

/**
 * Classe resolvedora de URLs (Rotas)
 */
class Router {

    /**
     * O Controller que deve ser carregado
     * @var String
     */
    protected $controller;

    /**
     * O Método que será executado
     * @var String
     */
    protected $action;

    /**
     * A rota que será usada
     * @var String
     */
    protected $route;

    /**
     * O prefixo do método
     * @var String
     */
    protected $methodPrefix;

    /**
     * O idioma da página
     * @var String
     */
    protected $language;

    /**
     * A lista de parãmetros da página
     * @var Array
     */
    protected $params;

    /**
     * Retorna o controller
     * @return String
     */
    function getController() {
	return $this->controller;
    }

    /**
     * Retorna o método
     * @return String
     */
    function getAction() {
	return $this->action;
    }

    /**
     * Retorna a rota
     * @return String
     */
    function getRoute() {
	return $this->route;
    }

    /**
     * Retorna o prefixo
     * @return String
     */
    function getMethodPrefix() {
	return $this->methodPrefix;
    }

    /**
     * Retorna o idioma
     * @return String
     */
    function getLanguage() {
	return $this->language;
    }

    /**
     * Define o controller
     * @param String $controller O controller
     */
    function setController($controller) {
	$this->controller = $controller;
    }

    /**
     * Define o método
     * @param String $action O método
     */
    function setAction($action) {
	$this->action = $action;
    }

    /**
     * Define a rota
     * @param String $route A Rota
     */
    function setRoute($route) {
	$this->route = $route;
    }

    /**
     * Define o prefixo do método
     * @param String $methodPrefix O prefixo
     */
    function setMethodPrefix($methodPrefix) {
	$this->methodPrefix = $methodPrefix;
    }

    /**
     * Define o idioma
     * @param String $language O idioma
     */
    function setLanguage($language) {
	$this->language = $language;
    }

    /**
     * Retorna a lista de parâmetros
     * @return Array
     */
    function getParams() {
	return $this->params;
    }

    /**
     * Define a lista de parâmetros
     * @param String $params Lista de Parametros
     */
    function setParams($params) {
	$this->params = $params;
    }

    /**
     * Processa a URL, define os atributos e retorna os parâmetros
     * @param Array $routes Lista de Rotas
     * @param String $uri URL
     * @return Array Lista de parâmetros
     */
    protected function parseFriendlyUri($routes, $uri) {
	$uri_parts = explode('?', $uri);

	// site/lang/route/controller/action/param1/param2/..../paramN?
	// site/route/controller/action/param1/param2/..../paramN?
	// site/controller/action/param1/param2/..../paramN?
	$path = $uri_parts[0];
	$path_parts = explode('/', $path);

	// Reverte o array por performance
	$path_parts = array_reverse($path_parts);

	// Idioma
	$language = end($path_parts);
	if ($language != FALSE && in_array($language, Config::get('languages'))) {
	    $this->language = $language;
	    array_pop($path_parts);
	}

	// Route
	$route = end($path_parts);
	if ($route != FALSE && isset($routes[$route])) {
	    $this->route = $route;
	    $this->methodPrefix = $routes[$route];
	    array_pop($path_parts);
	}

	// Modulo/Controller
	$module = end($path_parts);
	if ($module != FALSE) {
	    $this->controller = strtolower($module);
	    array_pop($path_parts);
	}


	// Action
	$action = end($path_parts);
	if ($action != FALSE) {
	    $this->action = strtolower($action);
	    array_pop($path_parts);
	}

	// Desfaz o reverse para manter a ordem dos parâmetros
	return array_reverse($path_parts);
    }

    /**
     * Cria um novo Router a partir da URL
     */
    function __construct() {
	// Carrega Padrões
	$routes = Config::get('routes');

	$this->route = Config::get('default_route');
	$this->methodPrefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
	$this->controller = Config::get('default_controller');
	$this->action = Config::get('default_action');
	$this->language = Config::get('default_language');

	$uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
	$uri = substr($uri, strlen(Config::get('base_uri')));
	$this->params = $this->parseFriendlyUri($routes, $uri);
    }

    /**
     * Redireciona o carregamento para outra página
     * @param String $url a URL
     */
    public static function redirect($url) {
	header("location:$url");
	exit();
    }

    /**
     * Cria uma URL a partir dos parametros dados
     * @param String $module controller
     * @param String $action método
     * @param Array $params parametros
     * @param String $route rota
     * @param String $lang idioma
     * @return String a URL
     */
    public function getUrl($module = '', $action = '', $params = [], $route = '', $lang = '') {
	$routes = Config::get('routes');
	if ($lang == '' || in_array($lang, Config::get('languages')) == FALSE) {
	    $lang = $this->language;
	}

	if ($route == '' && $this->route != Config::get('default_route')) {
	    $route = $this->route;
	} else if ($route != '' && isset($routes[$route]) == FALSE) {
	    $route = '';
	}

	$url = Config::get('base_uri');
	if ($lang != '' && $lang != Config::get('default_language')) {
	    $url .= "{$lang}/";
	}
	if ($route != '' && $route != Config::get('default_route')) {
	    $url .= "{$route}/";
	}
	if ($module != '') {
	    $url .= "{$module}/";
	    if ($action != '') {
		$url .= "{$action}/";

		foreach ($params as $paramName => $paramValue) {
		    $url .= "{$paramValue}/";
		}
	    }
	}

	return $url;
    }

    /**
     * Retorna a URL de um recurso
     * @param String $resource recurso
     * @return String a URL do recurso
     */
    public function getResourceUrl($resource) {
	return Config::get('base_uri') . $resource;
    }

}
