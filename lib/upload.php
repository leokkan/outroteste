<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lib;

/**
 * Description of upload
 *
 * @author guilh
 */
class Upload {

    /**
     * Verifica se o nome dado para um arquivo é válido.
     * Esta verificação irá impedir nomes reservados de serem usados
     * @param String $filename nome do arquivo
     */
    private static function validName($filename) {
	return (strcmp($filename, '.htaccess') != 0 &&
		strcmp($filename, 'web.config') != 0 &&
		strcmp($filename, 'index.html') != 0
		);
    }

    /**
     * Valida o upload sendo feito no campo $field
     * @param String $field nome do campo do upload
     * @throws \Exception Caso ocorra um erro de validação
     */
    private static function validate($field) {
	$allowed = array('png', 'jpg', 'gif');
	$extension = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);

	if (!in_array(strtolower($extension), $allowed)) {
	    throw new \Exception('Tipo de arquivo inválido'); /* */
	}

	$filename = $_FILES[$field]['name'];
	if (!self::validName($filename)) {
	    throw new \Exception('Nome de arquivo inválido');
	}

	if ($_FILES[$field]['size'] < 1024 || $_FILES[$field]['size'] > 2097152) {
	    throw new \Exception('Tamanho de arquivo não suportado');
	}
    }

    /**
     * Faz o upload do arquivo no campo $field
     * @param String $field nome do campo
     * @return String caminho do arquivo
     * @throws \Exception Caso ocorra um erro durante o upload
     */
    private static function do_upload($field) {
	$filename = pathinfo($_FILES[$field]['name'], PATHINFO_FILENAME);
	$extension = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);

	$newname = $filename . '_' . uniqid() . '.' . $extension;
	if (move_uploaded_file($_FILES['file']['tmp_name'], 'static/uploads/' . $newname) == FALSE) {
	    throw new \Exception('Não foi possível mover o arquivo');
	}

	return 'static/uploads/' . $newname;
    }

    /**
     * Faz o upload do arquivo no campo $field
     * @param String $field campo a ser feito o upload (Default: file)$field
     * @return array(result,data) informações do upload.
     * Se result for false, data contem a mensagem de erro.
     * Se result for true, data contem o nome da imagem
     */
    public static function upload($field = 'file') {
	try {
	    self::validate($field);
	    $name = self::do_upload($field);
	    return ['result' => true, 'data' => $name];
	} catch (\Exception $ex) {
	    return ['result' => false, 'data' => $ex->getMessage()];
	}
    }

    /**
     * Deleta o arquivo de nome $filename
     * @param String $filename nome do arquivo
     */
    public static function delete($filename) {
	if (self::validName($filename)) {
	    unlink('static/uploads/' . $filename);
	}
    }

    /**
     * Retorna a lista de arquivos upados
     * @return array Lista de arquivos no diretório
     */
    public static function getUploadedFiles() {
	$scan = scandir('static/uploads/');

	// Precisamos remover o que não se trata de imagens
	return array_diff($scan, ['..', '.', 'index.html', '.htaccess', 'web.config']);
    }

}
