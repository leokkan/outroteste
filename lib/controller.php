<?php

namespace Lib;

/**
 * Controller base para os demais controllers.
 */
class Controller {

    /**
     * Array com dados que serão passados para a View
     * @var Array
     */
    protected $data;

    /**
     * Retorna a lista de dados
     * @return Array
     */
    function getData() {
	return $this->data;
    }

    /**
     * Define a lista de dados
     * @param Array $data dados
     */
    function setData($data) {
	$this->data = $data;
    }

    /**
     * Cria um novo Controller
     * @param Array $data lista de dados que serão usados pela view
     */
    function __construct($data = array()) {
	$this->data = $data;
    }

}
