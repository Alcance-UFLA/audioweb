<?php
/**
 * Action para recuperar o acesso de algum usuário.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Autenticacao_Recuperar extends Controller_Geral {

	/**
	 * Exibe o formulário.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$this->definir_title('Recuperar acesso');
		$this->definir_description('Página para recuperar o acesso ao sistema AudioWeb.');
		$this->definir_canonical(URL::site('autenticacao/recuperar'));

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Apresentação', 'icone' => 'bullhorn'),
			array('url' => Route::url('acao_padrao', array('directory' => 'autenticacao', 'controller' => 'autenticar')), 'nome' => 'Acessar o AudioWeb', 'icone' => 'log-in'),
			array('nome' => 'Recuperar acesso', 'icone' => 'lock')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$flash_data = Session::instance()->get_once('flash_data', array());
		$dados['form_recuperar'] = array();
		$dados['form_recuperar']['dados'] = isset($flash_data['recuperar']) ? $flash_data['recuperar'] : array();

		$this->template->content = View::Factory('autenticacao/recuperar/index', $dados);
	}

	/**
	 * Recebe os dados de recuperação de autenticação.
	 * @return void
	 */
	public function action_processar()
	{
		$this->requerer_autenticacao(false);
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('autenticacao/recuperar' . URL::query(array()));
		}

		$usuario = ORM::factory('Usuario')
			->where('email', '=', $this->request->post('email'))
			->find();

		if ( ! $usuario->loaded())
		{
			$flash_data = array(
				'recuperar' => array(
					'email' => $this->request->post('email')
				)
			);

			$mensagens = array('erro' => 'Usuário inválido.');
			Session::instance()->set('flash_message', $mensagens);
			Session::instance()->set('flash_data', $flash_data);
			HTTP::redirect('autenticacao/recuperar' . URL::query(array()));
			return;
		}

		$bd = Database::instance();
		$bd->begin();

		try
		{

			// Gerar registro de acesso por chave aleatória
			$acesso = ORM::Factory('Acesso_Especial');
			$acesso->hash     = uniqid(md5(microtime(true)));
			$acesso->validade = strftime('%Y-%m-%d %H:%M:%S', strtotime('+7day', $_SERVER['REQUEST_TIME']));
			$acesso->usuario  = $usuario;

			$acesso->save();

			// Preparar e-mail
			$dados_email = array();
			$dados_email['acesso_especial'] = $acesso->as_array();
			$mensagem_email = View::Factory('autenticacao/recuperar/mensagem_email', $dados_email);

			// Enviar e-mail
			$mail = Helper_Email::factory();
			$mail->addAddress($usuario->email, $usuario->nome);
			$mail->Subject = 'Recuperar acesso - AudioWeb';
			$mail->msgHTML($mensagem_email);
			if ( ! $mail->send())
			{
				throw new RuntimeException('Falha ao enviar e-mail');
			}

			$bd->commit();
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$flash_data = array(
				'recuperar' => array(
					'email' => $this->request->post('email')
				)
			);

			$mensagens = array('erro' => 'Erro inesperado ao recuperar acesso. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('autenticacao/recuperar' . URL::query(array()));
		}

		// Garbage collector de acessos expirados
		if (ORM::factory('Acesso_Especial')->count_all() > 3)
		{
			$acessos_expirados = ORM::factory('Acesso_Especial')
				->where('validade', '<', strftime('%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']))
				->find_all();
			foreach ($acessos_expirados as $acesso_expirado)
			{
				$acesso_expirado->delete();
			}
		}

		$mensagens = array('sucesso' => 'E-mail enviado com as instruções para recuperação do acesso.');
		Session::instance()->set('flash_message', $mensagens);
		HTTP::redirect('autenticacao/recuperar' . URL::query(array()));
	}

}