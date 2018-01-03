<?php

namespace Controllers;

use Lib\Controller;
use Models\Parceiro;
use Models\Funcionario;
use Models\Slide;
use Models\Produto;
use Models\InfoConstants;
use Models\Info;
use Lib\Router;
use Lib\App;
use Lib\Config;
use Lib\Email;

/**
 * Controller do Site.
 */
class SiteController extends Controller {

	/**
	 * Retorna para a view as informaçoes de slides,
     * produtos, funcionarios,parceiros e infos.
	 */
	public function _index() {
            
            $this->data['slides'] = Slide::getSlides();
            $this->data['produtos'] = Produto::getProdutos();
            $this->data['funcionarios'] = Funcionario::getFuncionarios();
            $this->data['parceiros'] = Parceiro::getParceiros();
            $infos = Info::getByChaves([InfoConstants::SOBRE,InfoConstants::MISSAO,
                InfoConstants::VISAO,InfoConstants::VALORES, InfoConstants::EMAIL,
                InfoConstants::TELEFONE]);
            $this->data['missao'] = isset($infos['missao']) ? $infos['missao'] : '';
            $this->data['sobre'] = isset($infos['sobre']) ? $infos['sobre'] : '';
            $this->data['visao'] = isset($infos['visao']) ? $infos['visao'] : '';
            $this->data['valores'] = isset($infos['valores']) ? $infos['valores'] : '';
            $this->data['email'] = isset($infos['email']) ? $infos['email'] : '';
            $this->data['telefone'] = isset($infos['telefone']) ? $infos['telefone'] : '';
    }
    
    /**
	 * Envia email do campo de formulário contato
	 */
	public function _contato() {
        $request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if($request === 'POST'){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email',FILTER_SANITIZE_EMAIL);
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['result' => false, 'msg' => 'Por favor, forneça um e-mail válido!']);
				exit();
            }
            $telefone = filter_input(INPUT_POST, 'telefone',FILTER_SANITIZE_STRING);
            $mensagem = filter_input(INPUT_POST, 'mensagem',FILTER_SANITIZE_STRING);
            
            if($nome == FALSE || $email == FALSE || $mensagem == FALSE){
                echo json_encode(['result' => false, 'msg' => 'Preencha todos os campos!']);
				exit();
            }
            $body  = "<b>Nome:</b> {$nome}<br />";
            $body .= "<b>Email:</b> {$email}<br />";
            $body .= "<b>Telefone:</b> {$telefone}<br /><br />";
            $body .= "<b>Mensagem:</b> <br /> {$mensagem}<br />";

            try {
                Email::send(Config::get('mail.toAddress'), Config::get('mail.toName'), Config::get('mail.contactTitle'), $body);
            } catch (\Exception $ex) {
                // Nesse caso não podemos deixar o erro passar, pois será o resultado do envio
                if (Config::get('log_errors')) {
                    error_log("Erro inesperado ao enviar e-mail: {$ex->getMessage()}");
                }
                echo json_encode(['result' => false, 'msg' => 'Um problema ocorreu enquanto sua mensagem era enviada, se este problema persistir, tente novamente mais tarde.']);
                exit();
            }
			
			echo json_encode(['result' => true, 'msg' => 'Email enviado com sucesso!']);
			exit();
        }
        
        exit();
    }
}
