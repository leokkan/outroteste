<?php

namespace Controllers;

use Lib\Controller;
use Models\Produto;
use Lib\Session;
use Lib\Router;
use Lib\App;

/**
 * Controller de um Produto.
 */
class ProdutoController extends Controller {

    /**
     * Retorna todos os Produtos cadastrados no Banco de dados
     * para a exibição da view admin_index.
     */
    public function admin_index() {
        $this->data['produtos'] = Produto::getProdutos();
    }

    /**
     * Filtra a entrada fornecida pela view admin_insere.php e 
     * chama o metodo insere do Model\Produto. 
     */
    public function admin_insere() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $imagem = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);          

            if ($nome == FALSE || $imagem == FALSE || $descricao == FALSE){
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('produto', 'insere'));
            }

            $produto = new Produto(0, $nome, $imagem, $descricao);
            Produto::insere($produto);

            Session::flash('Produto inserido com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }
    }

    /**
     * Retorna para a view os dados fornecidos através do Id passado(GET) e 
     * filtra a entrada fornecida pela view (POST) para a modificação. 
     * Chama o metodo atualiza do Model\Produto.
     */
    public function admin_atualiza($id) {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        if ($request === 'POST') {
            $idProduto = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $imagem = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, 'descricao',FILTER_SANITIZE_STRING);

            if ($idProduto == FALSE || $idProduto <= 0) {
                Session::setFlash('Produto não encontrado.');
                Router::redirect(App::getRouter()->getUrl('produto'));
            } else if ($nome == FALSE || $imagem == FALSE ||$descricao == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('produto', 'atualiza', [$idProduto]));
            }                

            $produto = new Produto($idProduto, $nome, $imagem, $descricao);
            Produto::atualiza($produto);

            Session::flash('Produto atualizado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('produto'));


        } else if ($request === 'GET') {
            $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            if ($idProduto == FALSE || $idProduto < 0) {
                Session::setFlash('Parceiro não encontrado.');
                Router::redirect(App::getRouter()->getUrl('produto'));
            }

            $this->data['produto'] = Produto::getById($idProduto);
        }
    }

    /**
     * Verifica se o id passado é valido e chama o metodo Deleta
     * do models\Produto.
     */
    public function admin_deleta($id) {
        $idProduto = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idProduto == FALSE || $idProduto < 0) {
            Session::setFlash('Produto não encontrado.');
            Router::redirect(App::getRouter()->getUrl('produto'));
        }

        Produto::deleta($idProduto);
        Session::setFlash('Produto Deletado com Sucesso.');
        Router::redirect(App::getRouter()->getUrl('produto'));
    }

}
