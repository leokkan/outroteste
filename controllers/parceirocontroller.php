<?php

namespace Controllers;

use Lib\Controller;
use Models\Parceiro;
use Lib\Session;
use Lib\Router;
use Lib\App;

/**
 * Controller de um Parceiro.
 */
class ParceiroController extends Controller {

    /**
     * Retorna todos os Parceiros cadastrados no Banco de dados
     * para a exibição da view admin_index.
     */
    public function admin_index() { 
        $this->data['parceiros'] = Parceiro::getParceiros();  
    }

    /**
     * Filtra a entrada fornecida pela view admin_insere.php e 
     * chama o metodo insere do Model\Parceiro. 
     */
    public function admin_insere() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $imagem = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);
            $site = filter_input(INPUT_POST, 'site',FILTER_SANITIZE_STRING);          
            $ordem = filter_input(INPUT_POST, 'ordem',FILTER_SANITIZE_NUMBER_INT);

            if ($nome == FALSE || $imagem == FALSE || $site == FALSE || $ordem == FALSE){
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('parceiro', 'insere'));
            }

            $parceiro = new Parceiro(0, $nome, $imagem, $site, $ordem);
            Parceiro::insere($parceiro);

            Session::flash('Parceiro inserido com sucesso.');
            Router::redirect(App::getRouter()->getUrl('parceiro'));
        }
    }

    /**
     * Retorna para a view os dados fornecidos através do Id passado(GET) e 
     * filtra a entrada fornecida pela view (POST) para a modificação. 
     * Chama o metodo atualiza do Model\Parceiro. 
     */
    public function admin_atualiza($id) {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        if ($request === 'POST') {
            $idParceiro = filter_input(INPUT_POST, 'idParceiro', FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $imagem = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);
            $site = filter_input(INPUT_POST, 'site',FILTER_SANITIZE_STRING);
            $ordem = filter_input(INPUT_POST,'ordem',FILTER_SANITIZE_NUMBER_INT);

            if ($idParceiro == FALSE || $idParceiro <= 0) {
                Session::setFlash('Parceiro não encontrado.');
                Router::redirect(App::getRouter()->getUrl('parceiro'));
            } else if ($nome == FALSE || $imagem == FALSE ||$site == FALSE ||$ordem == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('parceiro', 'atualiza', [$idParceiro]));
            }                

            $parceiro = new Parceiro($idParceiro, $nome, $imagem, $site, $ordem);
            Parceiro::atualiza($parceiro);

            Session::flash('Parceiro atualizado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('parceiro'));


        } else if ($request === 'GET') {
            $idParceiro = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            if ($idParceiro == FALSE || $idParceiro < 0) {
                Session::setFlash('Parceiro não encontrado.');
                Router::redirect(App::getRouter()->getUrl('parceiro'));
            }

            $this->data['parceiro'] = Parceiro::getById($idParceiro);
        }
    }

    /**
     * Verifica se o id passado é valido e chama o metodo Deleta
     * do models\parceiro.
     */
    public function admin_deleta($id) {

        $idParceiro = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idParceiro == FALSE || $idParceiro < 0) {
            Session::setFlash('Parceiro não encontrado.');
            Router::redirect(App::getRouter()->getUrl('parceiro'));
        }

        Parceiro::deleta($idParceiro);
        Session::setFlash('Parceiro Deletado com Sucesso.');
        Router::redirect(App::getRouter()->getUrl('parceiro'));
    }

}
