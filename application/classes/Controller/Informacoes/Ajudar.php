<?php
/**
 * Action para exibir informações sobre como ajudar com o AudioWeb.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Informacoes_Ajudar extends Controller_Geral {

	/**
	 * Action para exibir o texto de como ajudar o AudioWeb
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$this->definir_title('Quero Ajudar');
		$this->definir_description('Página que apresenta informações sobre como contribuir com o AudioWeb.');
		$this->definir_robots('index,follow');

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Apresentação', 'icone' => 'bullhorn'),
			array('nome' => 'Quero Ajudar', 'icone' => 'heart')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());
		$dados['form_ajudar'] = array();
		$dados['form_ajudar']['dados'] = isset($flash_data['ajudar']) ? $flash_data['ajudar'] : array();
		if (Auth::instance()->logged_in())
		{
			$dados['form_ajudar']['dados']['nome'] = Auth::instance()->get_user()->nome;
			$dados['form_ajudar']['dados']['email'] = Auth::instance()->get_user()->email;
		}

		$this->template->content = View::Factory('informacoes/ajudar/index', $dados);
	}

	/**
	 * Action para receber uma mensagem do usuário e enviá-la aos desenvolvedores
	 * @return void
	 */
	public function action_mensagem()
	{
		$this->requerer_autenticacao(false);
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('informacoes/ajudar' . URL::query(array()));
		}
		try
		{
			$dados_email = array(
				'nome'  => $this->request->post('nome'),
				'email' => $this->request->post('email'),
				'texto' => $this->request->post('texto'),
				'ip'    => Request::$client_ip,
				'data'  => strftime('%d/%m/%Y %H:%m:%s')
			);
			$mensagem_email = View::Factory('informacoes/ajudar/mensagem_email', $dados_email);

			$mail = Helper_Email::factory();
			$mail->addAddress(
				Kohana::$config->load('audioweb.email_sistema'),
				Kohana::$config->load('audioweb.nome_sistema')
			);
			$mail->Subject = 'Comentário AudioWeb';
			$mail->msgHTML($mensagem_email);
			if ( ! $mail->send())
			{
				throw new RuntimeException('Falha ao enviar e-mail');
			}
		}
		catch (Exception $e)
		{
			$flash_data = array(
				'ajudar' => array(
					'nome'  => $this->request->post('nome'),
					'email' => $this->request->post('email'),
					'texto' => $this->request->post('texto')
				)
			);

			$mensagens = array('erro' => 'Erro inesperado ao enviar mensagem. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('informacoes/ajudar' . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Mensagem enviada com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('informacoes/ajudar' . URL::query(array()));
	}
}