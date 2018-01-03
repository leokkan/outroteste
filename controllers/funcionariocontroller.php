<?php

namespace Controllers;

use Lib\App;
use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Models\Funcionario;
/**
 * Controla funcionalidades relacionadas aos funcionários.
 */
class FuncionarioController extends Controller{

	/**
	 * Exibe funcionários cadastrados.
	 */
	public function admin_index() {
		$this->data['funcionarios'] = Funcionario::getFuncionarios();
	}

	/**
	 * Insere funcionários no sistema.
	 */
	public function admin_insere() {
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST'){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);	
            $imagem = 'NAN';
            $cargo = filter_input(INPUT_POST, 'cargo',FILTER_SANITIZE_STRING);                      
            
            if($nome == FALSE || $cargo == FALSE || $imagem == FALSE){
                Session::setFlash('Preencha todos os campos obrigatórios!');
                Router::redirect(App::getRouter()->getUrl('Funcionario', 'insere'));
            }
            $funcionario = new Funcionario(0, $nome, $imagem, $cargo);
            Funcionario::insere($funcionario);
            
            Session::flash('Funcionário cadastrado com sucesso!');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        }
	}

	/**
	 * Atualiza funcionários cadastrados.
     * @param integer $id ID do Funcionario
	 */
	public function admin_atualiza($id) {
		$request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if($request === 'POST'){            
            $idFuncionario = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);	
            $imagem = 'NAN';
            $cargo = filter_input(INPUT_POST, 'cargo',FILTER_SANITIZE_STRING);
            
            if($idFuncionario == FALSE || $idFuncionario <= 0){
                Session::setFlash('Funcionário não encontrado!');
                Router::redirect(App::getRouter()->getUrl('funcionario'));                
            }else if($nome == FALSE || $cargo == FALSE || $imagem == FALSE){
                Session::setFlash('Preencha todos os campos obrigatórios!');
                Router::redirect(App::getRouter()->getUrl('funcionario', 'atualiza', [$idFuncionario]));
            }
            $funcionario = new Funcionario(0, $nome, $imagem, $cargo);
            Funcionario::atualiza($funcionario);
            
            Session::flash('Funcionário atualizado com sucesso!');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        } else{
            $idFuncionario = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            
            if($idFuncionario == FALSE || $idFuncionario < 0){
                Session::setFlash('Funcionário não encontrado!');
                Router::redirect(App::getRouter()->getUrl('funcionario'));
            }
            
            $this->data['funcionario'] = Funcionario::getById($id);
        }
	}

	/**
	 * Deleta funcionários cadastrados.
     * @param integer $id ID do Funcionario
	 */
	public function admin_deleta($id) {
		$idFuncionario = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        
        if($idFuncionario == FALSE || $idFuncionario < 0){
            Session::setFlash('Funcionário não encontrado!');
            Router::redirect(App::getRouter()->getUrl('funcionario'));
        }
        
        Funcionario::deleta($idFuncionario);
        Session::setFlash('Funcionário excluído com sucesso!');
        Router::redirect(App::getRouter()->getUrl('funcionario'));
    }
	

}
