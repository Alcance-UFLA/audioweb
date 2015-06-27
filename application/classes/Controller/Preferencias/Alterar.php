<?php
/**
 * Action para alterar preferencias do usuario.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Preferencias_Alterar extends Controller_Geral {

	/**
	 * Action para exibir o formulário de alterar preferencias.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Alterar Preferências');

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('nome' => 'Alterar Preferências', 'icone' => 'wrench')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_preferencias'] = array();
		$dados['form_preferencias']['dados'] = isset($flash_data['preferencias']) ? $flash_data['preferencias'] : $this->obter_preferencias();
		$dados['form_preferencias']['lista_teclas'] = Model_Util_Teclas::obter_lista_teclas();

		$this->template->content = View::Factory('preferencias/alterar/index', $dados);
	}

	/**
	 * Salvar preferencias.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();

		if ($this->request->method() != 'POST') {
			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar')) . URL::query(array()));
		}

		$dados_preferencias = array(
			'usuario' => $this->request->post('usuario'),
			'teclas' => Model_Util_Teclas::obter_teclas_atalho()
		);
		foreach ($this->request->post('teclas') as $chave => $dados_tecla) {
			$dados_preferencias['teclas'][$chave]['codigo'] = $dados_tecla['codigo'];
			$dados_preferencias['teclas'][$chave]['shift']  = $dados_tecla['shift'];
			$dados_preferencias['teclas'][$chave]['alt']    = $dados_tecla['alt'];
			$dados_preferencias['teclas'][$chave]['ctrl']   = $dados_tecla['ctrl'];
		}

		$erros = false;
		$mensagens = array();
		$mensagens['atencao'] = array();

		// Validar dados de usuario
		$rules = ORM::Factory('Usuario')->rules();
		$usuario_post = Arr::get($this->request->post(), 'usuario');

		$post = Validation::factory($usuario_post)
			->rules('nome', $rules['nome'])
			->rules('email', array(array('email')));

		if ( ! $post->check()) {
			$erros = true;
			$mensagens['atencao'] = array_merge($mensagens['atencao'], $post->errors('models/usuario'));
		}

		// Validar senha
		$alterou_senha = $usuario_post['senha_atual'] || $usuario_post['senha'] || $usuario_post['senha_confirmacao'];
		if ($alterou_senha) {
			if ( ! Auth::instance()->check_password($usuario_post['senha_atual'])) {
				$erros = true;
				$mensagens['atencao']['senha_atual'] = 'A senha atual está incorreta.';
			}
			$post = Validation::factory($usuario_post)
				->rules('senha', $rules['senha']);
			if ( ! $post->check()) {
				$erros = true;
				$mensagens['atencao'] = array_merge($mensagens['atencao'], $post->errors('models/usuario'));
			}
			if ($usuario_post['senha'] != $usuario_post['senha_confirmacao']) {
				$erros = true;
				$mensagens['atencao']['senha_confirmacao'] = 'A confirmação da senha está incorreta';
			}
		}

		if ($erros) {
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('preferencias' => $dados_preferencias);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar')) . URL::query(array()));
		} else {
			unset($mensagens['atencao']);
		}

		$bd = Database::instance();
		$bd->begin();

		$mensagens_sucesso = array();
		try {
			// Salvar Usuario / Senha
			$usuario = Auth::instance()->get_user();
			$usuario->nome  = Arr::get($this->request->post('usuario'), 'nome');
			$usuario->email = Arr::get($this->request->post('usuario'), 'email');
			if ($alterou_senha) {
				$usuario->senha = Arr::get($this->request->post('usuario'), 'senha');
			}
			$usuario->save();

			// Salvar teclas
			foreach ($this->request->post('teclas') as $chave => $dados_tecla) {
				$operacao = ORM::Factory('Operacao')
					->where('chave', '=', $chave)
					->find();

				$operacao_usuario = ORM::Factory('Usuario_Operacao')
					->where('id_usuario', '=', $usuario->pk())
					->and_where('id_operacao', '=', $operacao->pk())
					->find();

				// Se tecla informada eh igual a padrao
				if (
					$operacao->tecla_padrao == $dados_tecla['codigo']
					&& $operacao->shift == $dados_tecla['shift']
					&& $operacao->alt == $dados_tecla['alt']
					&& $operacao->ctrl == $dados_tecla['ctrl']
				) {
					if ($operacao_usuario->loaded()) {
						$operacao_usuario->delete();
					}

				// Se a tecla informada mudou em relacao ao padrao
				} else {
					if ( ! $operacao_usuario->loaded()) {
						$operacao_usuario = ORM::Factory('Usuario_Operacao');
						$operacao_usuario->id_usuario  = $usuario->pk();
						$operacao_usuario->id_operacao = $operacao->pk();
					}
					$operacao_usuario->tecla_personalizada = $dados_tecla['codigo'];
					$operacao_usuario->shift               = $dados_tecla['shift'];
					$operacao_usuario->alt                 = $dados_tecla['alt'];
					$operacao_usuario->ctrl                = $dados_tecla['ctrl'];
					$operacao_usuario->save();
				}
			}

			$mensagens_sucesso[] = 'Dados alterados com sucesso.';

			$bd->commit();
		} catch (ORM_Validation_Exception $e) {
			$bd->rollback();
			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('preferencias' => $dados_preferencias);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar')) . URL::query(array()));
		} catch (Exception $e) {
			$bd->rollback();
			$mensagens = array('erro' => 'Erro inesperado ao alterar as preferências. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('preferencias' => $dados_preferencias);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar')) . URL::query(array()));
		}

		$mensagens = array('sucesso' => $mensagens_sucesso);
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect(Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar')) . URL::query(array()));
	}

	/**
	 * Obtem os dados de preferencias.
	 * @return array
	 */
	private function obter_preferencias()
	{
		$dados = array();
		$dados['usuario'] = Auth::instance()->get_user()->as_array();
		$dados['teclas'] = Model_Util_Teclas::obter_teclas_atalho();
		return $dados;
	}

}
