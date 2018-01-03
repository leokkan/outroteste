<?php

/**
 * Este arquivo contem as configurações que ficam salvas no repositório
 * NÃO coloque senhas e configurações locais aqui, invés disso, duplique
 * o arquivo "config.template.php" e nomeie-o como "config.local.php"
 * nesta mesma pasta e copie as configurações que deseja alterar para lá 
 * e então altere-as nele.
 */

use Lib\Config;

// =========== Configurações Gerais ===========
Config::set('site_name', 'JJMA');	// Nome do Site
Config::set('base_uri', '/Projeto-JJMA-Embalagens/');		// Diretório para a raiz do framework
Config::set('production', false);		// Esta instalação está sendo usada em produção?
										// Quando true, irá esconder detalhes dos erros.
Config::set('log_errors', true);		// Registrar erros em arquivo de log?

// ========== Configurações de Idioma =========
Config::set('languages', [			// Idiomas aceitos
    'pt_br', 'en'
]);
Config::set('default_language', 'pt_br');	// Idioma Padrão

// ========== Configurações de Rotas  =========
// IMPORTANTE: Todas as rotas devem ter um prefixo, caso contrário
//		irá permitir acessar páginas fora do seu direito de
//		acesso. (Veja Issue #9)
Config::set('routes', [				// Rotas e seus prefixos
    'default' => '_',
    'admin' => 'admin_'
]);
Config::set('default_route', 'default');	// Rota Padrão

// ========== Padrões de Roteamento  ==========
Config::set('default_controller', 'site');	// Controller Padrão
Config::set('default_action', 'index');		// Ação (método) Padrão

// ======= Definições de Banco de Dados =======
Config::set('db.host', 'localhost');		// Servidor do BD
Config::set('db.user', 'root');			// Usuário do BD
Config::set('db.password', 'vertrigo');		// Senha do BD
Config::set('db.name', 'framework');		// Nome do BD

// ======= Definições de Migrations =======
Config::set('migrate.allow', true);                 // Permitir migrações?
Config::set('migrate.limit_ip', true);              // Limitar IPs que podem realizar migrações?
Config::set('migrate.allow_ips',  [                 // IPs que podem fazer migrações
        '127.0.0.1', // Local
        '207.97.227.', '50.57.128.', '108.171.174.', '50.57.231.', '204.232.175.', '192.30.252.', // GitHub
    ]);

// =========== Configurações Email ===========

// Configuração do Servidor SMTP
Config::set('mail.SMTPDebug', 0);					  			 // Debug do SMTP (Veja: https://github.com/PHPMailer/PHPMailer/wiki/SMTP-Debugging)
Config::set('mail.Host','smtp1.example.com;smtp2.example.com');  // Servidores de SMTP (principal;auxiliar), o auxiliar é opcional
Config::set('mail.SMTPAuth',true);                     			 // Utilizar SMTP autenticado?
Config::set('mail.Username','user@example.com');       			 // Usuário do SMTP
Config::set('mail.Password','secret');                			 // Senha do SMTP
Config::set('mail.SMTPSecure','tls');                 			 // Tipo de criptografia (tls/ssl)
Config::set('mail.Port','587');                        			 // Porta de conexão do SMTP

// Configurações do Remetente dos e-mails
Config::set('mail.fromAddress','user@example.com');	// Endereço que envia o e-mail
Config::set('mail.fromName','nomeExemplo');			// Nome que envia o e-mail

// Opções adicionais do servidor
Config::set('mail.SMTPOptions', null);
// Alguns servidor (ex: gmail) podem não funcionar e ser resolvido com esta configuração:
/*
	['ssl' => [
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
	]];
*/

// E-mail para onde as mensagens de contato são enviadas
Config::set('mail.contactTitle', 'Mensagem do Site');
Config::set('mail.contactAddress','user@example.com');

// Carrega as configurações locais
if (file_exists(ROOT . DS . "config" . DS . "config.local.php")) {
    include ROOT . DS . "config" . DS . "config.local.php";
}

