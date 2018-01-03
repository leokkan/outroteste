<?php
namespace Controllers;

use Lib\App;
use Lib\Controller;
use Lib\Session;
use Lib\Router;
use Models\Info;
use Models\InfoConstants;
/**
 * Controla funcionalidades relacionadas à seção sobre.
 */
class SobreController extends Controller{
	/**
	 * Exibe todos Infos relevantes a seção sobre
	 */
	public function admin_index() {
		$infos = Info::getByChaves([InfoConstants::SOBRE,InfoConstants::MISSAO,InfoConstants::VISAO,InfoConstants::VALORES]);
		$this->data['missao'] = $infos['missao'];
		$this->data['sobre'] = $infos['sobre'];
		$this->data['visao'] = $infos['visao'];
		$this->data['valores'] = $infos['valores'];
	}
	/**
	 * Atualiza a parte Sobre
	 */
	public function admin_atualiza_sobre() {
		$request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if($request === 'POST'){
            $conteudo = filter_input(INPUT_POST, 'sobre',FILTER_SANITIZE_STRING);
            
            if($conteudo == FALSE){
                Session::setFlash('Preencha o campo de conteúdo!');
                Router::redirect(App::getRouter()->getUrl('sobre', 'atualiza_sobre'));
            }
            $info = new Info(InfoConstants::SOBRE, $conteudo);
            Info::atualiza($info);
            
            Session::flash('Campo Sobre atualizado com sucesso!');
            Router::redirect(App::getRouter()->getUrl('sobre'));
        } else{     
            $this->data['sobre'] = Info::getByChave(InfoConstants::SOBRE);
        }
	}
	/**
	 * Atualiza Missão/Visão/Valores
	 */
	public function admin_atualiza_mvv() {
		$request = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        if($request === 'POST'){
            $missao = filter_input(INPUT_POST, 'missao',FILTER_SANITIZE_STRING);
            $visao = filter_input(INPUT_POST, 'visao',FILTER_SANITIZE_STRING);
            $valores = filter_input(INPUT_POST, 'valores',FILTER_SANITIZE_STRING);
            
            if($missao == FALSE || $visao == FALSE || $valores == FALSE){
                Session::setFlash('Preencha todos os campos!');
                Router::redirect(App::getRouter()->getUrl('sobre', 'atualiza_mvv'));
            }
            $info_missao = new Info(InfoConstants::MISSAO, $missao);
            Info::atualiza($info_missao);

            $info_visao = new Info(InfoConstants::VISAO, $visao);
            Info::atualiza($info_visao);

            $info_valores = new Info(InfoConstants::VALORES, $valores);
            Info::atualiza($info_valores);                       

            Session::flash('Campo Sobre atualizado com sucesso!');
            Router::redirect(App::getRouter()->getUrl('sobre'));
        } else{
			$infos = Info::getByChaves([InfoConstants::MISSAO,InfoConstants::VISAO,InfoConstants::VALORES]);    
            $this->data['missao'] = $infos['missao'];
			$this->data['visao'] = $infos['visao'];
			$this->data['valores'] = $infos['valores'];
        }
	}
}
