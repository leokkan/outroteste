<?php

namespace Controllers;

use Lib\Controller;
use Models\Info;
use Models\InfoConstants;
use Lib\Session;
use Lib\Router;
use Lib\App;

/**
 * Controller de um Contato.
 */
class ContatoController extends Controller{

    /**
     * Retorna o Email e telefone cadastrado no Banco de dados
     * para a exibição da view admin_index.
     */
    public function admin_index() { 
        
        $infos= Info::getByChaves([InfoConstants::EMAIL,InfoConstants::TELEFONE]);
        $this->data['email'] = $infos['email'];
        $this->data['telefone'] = $infos['telefone'];
    }

    /**
     * Retorna para a view os dados do email e telefone(GET) e 
     * filtra a entrada fornecida pela view (POST) para a modificação. 
     * Chama o metodo atualiza do Model\Info. 
     */
    public function admin_atualiza() {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        
        if($request === 'POST'){
            $email = filter_input(INPUT_POST, 'email',FILTER_SANITIZE_STRING);
            $telefone = filter_input(INPUT_POST, 'telefone',FILTER_SANITIZE_STRING);
            
            if($email == FALSE || $telefone == FALSE){
                Session::setFlash('Todos os campos são obrigatórios.');
                Router::redirect(App::getRouter()->getUrl('contato', 'atualiza'));
            }
            $oEmail = new Info(InfoConstants::EMAIL, $email);
            Info::atualiza($oEmail);

            $oTelefone = new Info(InfoConstants::TELEFONE, $telefone);
            Info::atualiza($oTelefone);                    

            Session::setFlash('Contato atualizado com sucesso!');
            Router::redirect(App::getRouter()->getUrl('contato'));
            
        } else{
            $infos= Info::getByChaves([InfoConstants::EMAIL,InfoConstants::TELEFONE]);
            $this->data['email'] = $infos['email'];
            $this->data['telefone'] = $infos['telefone'];

        }
    }

}
