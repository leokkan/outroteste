<?php
namespace Lib;

require ROOT . DS . 'Lib' . DS . 'PHPMailer' . DS . 'src' . DS . 'PHPMailer.php';
require ROOT . DS . 'Lib' . DS . 'PHPMailer' . DS . 'src' . DS . 'Exception.php';
require ROOT . DS . 'Lib' . DS . 'PHPMailer' . DS . 'src' . DS . 'OAuth.php';
require ROOT . DS . 'Lib' . DS . 'PHPMailer' . DS . 'src' . DS . 'POP3.php';
require ROOT . DS . 'Lib' . DS . 'PHPMailer' . DS . 'src' . DS . 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Lib\Config;

/**
 * Classe com funções de email
 */
class Email {
	/**
	 * Envia email utilizando a biblioteca PHPmailer
	 * @param String $toAddress endereço para enviar
	 * @param String $toName nome
	 * @param String $title titulo da mensagem	 
	 * @param String $body mensagem
	 */
	public static function send($toAddress, $toName, $title, $body) {		

		$mail = new PHPMailer(true);
		try {
			// Configurações do Servidor
		    $mail->SMTPDebug = Config::get('mail.SMTPDebug');
		    $mail->isSMTP();
		    $mail->Host = Config::get('mail.Host');
		    $mail->SMTPAuth = Config::get('mail.SMTPAuth');
		    $mail->Username = Config::get('mail.Username');
		    $mail->Password = Config::get('mail.Password');
		    $mail->SMTPSecure = Config::get('mail.SMTPSecure');
			$mail->Port = Config::get('mail.Port');
			if (Config::get('mail.SMTPOptions') != null) {
				$mail->SMTPOptions = Config::get('mail.SMTPOptions');
			}

			// Configuração de Envio
		    $mail->setFrom(Config::get('mail.fromAddress'),Config::get('mail.fromName'));
		    $mail->addAddress($toAddress, $toName);

		    // Conteúdo
		    $mail->isHTML(true);
		    $mail->Subject = $title;
		    $mail->Body    = $body;
		    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		} catch (Exception $e) {
		    throw new Exception("Erro ao enviar email: {$e->getMessage()}.");
		}
	}
}
