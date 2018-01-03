<?php

namespace Controllers;

use Lib\Controller;
use Models\Slide;
use Lib\Session;
use Lib\Router;
use Lib\App;

/**
 * Controller de um Slide.
 */
class SlideController extends Controller{

    /**
     * Retorna todos os Slides cadastrados no Banco de dados
     * para a exibição da view admin_index.
     */
    public function admin_index() {
        $this->data['slides'] = Slide::getSlides();
    }

    /**
     * Filtra a entrada fornecida pela view admin_insere.php e 
     * chama o metodo insere do Model\slide.
     */
    public function admin_insere() {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            $imagem = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);         
            $ordem = filter_input(INPUT_POST, 'ordem',FILTER_SANITIZE_NUMBER_INT);

            if ($imagem == FALSE || $ordem == FALSE){
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('slide', 'insere'));
            }

            $slide = new Slide(0, $imagem, $ordem);
            Slide::insere($slide);

            Session::flash('Parceiro inserido com sucesso.');
            Router::redirect(App::getRouter()->getUrl('slide'));
        }
    }

    /**
     * Retorna para a view os dados fornecidos através do Id passado(GET) e 
     * filtra a entrada fornecida pela view (POST) para a modificação. 
     * Chama o metodo atualiza do Model\Slide.
     */
    public function admin_atualiza($id) {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        if ($request === 'POST') {
            $idSlide = filter_input(INPUT_POST, 'idSlide', FILTER_SANITIZE_NUMBER_INT);
            $imagem = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);
            $ordem = filter_input(INPUT_POST,'ordem',FILTER_SANITIZE_NUMBER_INT);

            if ($idSlide == FALSE || $idSlide <= 0) {
                Session::setFlash('Slide não encontrado.');
                Router::redirect(App::getRouter()->getUrl('slide'));
            } else if ($imagem == FALSE ||$ordem == FALSE) {
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('slide', 'atualiza', [$idSlide]));
            }                

            $slide = new Slide($idSlide, $imagem, $ordem);
            Slide::atualiza($slide);

            Session::flash('Slide atualizado com sucesso.');
            Router::redirect(App::getRouter()->getUrl('slide'));


        } else if ($request === 'GET') {
            $idSlide = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            if ($idSlide == FALSE || $idSlide < 0) {
                Session::setFlash('Slide não encontrado.');
                Router::redirect(App::getRouter()->getUrl('slide'));
            }

            $this->data['slide'] = Slide::getById($idSlide);
        }
    }

    /**
     * Verifica se o id passado é valido e chama o metodo Deleta
     * do models\Slide.
     */
    public function admin_deleta($id) {
        $idSlide = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($idSlide == FALSE || $idSlide < 0) {
            Session::setFlash('Slide não encontrado.');
            Router::redirect(App::getRouter()->getUrl('slide'));
        }

        Slide::deleta($idSlide);
        Session::setFlash('Slide Deletado com Sucesso.');
        Router::redirect(App::getRouter()->getUrl('slide'));
    }

}
