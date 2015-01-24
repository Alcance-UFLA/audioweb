<?php
/**
 * Helper para envio de e-mail
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Helper_Email extends PHPMailer {

	/**
	 * Retorna uma instancia
	 * @return self
	 */
	public static function factory()
	{
		$mail = new self();
		$mail->setFrom(
			Kohana::$config->load('audioweb.email_sistema'),
			Kohana::$config->load('audioweb.nome_sistema')
		);
		$mail->Charset = 'UTF-8';
		return $mail;
	}
}