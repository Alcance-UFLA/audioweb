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
		$this->adicionar_script(URL::cdn('js/preferencias/alterar.min.js'));

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
		$dados['form_preferencias']['lista_sintetizadores'] = Model_Util_Configuracoes::obter_lista_sintetizadores();

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
			'teclas' => Model_Util_Teclas::obter_teclas_atalho(),
			'configuracoes' => Model_Util_Configuracoes::obter_configuracoes_usuario(),
		);
		foreach ($this->request->post('teclas') as $chave => $dados_tecla) {
			$dados_preferencias['teclas'][$chave]['codigo'] = $dados_tecla['codigo'];
			$dados_preferencias['teclas'][$chave]['shift']  = $dados_tecla['shift'];
			$dados_preferencias['teclas'][$chave]['alt']    = $dados_tecla['alt'];
			$dados_preferencias['teclas'][$chave]['ctrl']   = $dados_tecla['ctrl'];
		}
		foreach ($this->request->post('configuracoes') as $id_configuracao => $dados_configuracao) {
			$dados_preferenciais['configuracoes'][$id_configuracao]['valor'] = $dados_configuracao;
		}

		$erros = false;
		$mensagens = array();
		$mensagens['atencao'] = array();

		// Validar dados
		$this->validar_usuario($mensagens);
		$this->validar_teclas($mensagens);
		$this->validar_configuracoes($mensagens);

		if (!empty($mensagens['atencao'])) {
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('preferencias' => $dados_preferencias);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar')) . URL::query(array()));
		} else {
			unset($mensagens['atencao']);
		}

		// Realizar operacoes
		$bd = Database::instance();
		$bd->begin();

		$mensagens_sucesso = array();
		try {
			$this->salvar_usuario();
			$this->salvar_teclas();
			$this->salvar_sintetizador();

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

	private function validar_usuario(array &$mensagens)
	{
		$rules = ORM::Factory('Usuario')->rules();
		$usuario_post = Arr::get($this->request->post(), 'usuario');

		$post = Validation::factory($usuario_post)
			->rules('nome', $rules['nome'])
			->rules('email', array(array('email')));

		if ( ! $post->check()) {
			$mensagens['atencao'] = array_merge($mensagens['atencao'], $post->errors('models/usuario'));
		}

		$alterou_senha = $usuario_post['senha_atual'] || $usuario_post['senha'] || $usuario_post['senha_confirmacao'];
		if ($alterou_senha) {
			if ( ! Auth::instance()->check_password($usuario_post['senha_atual'])) {
				$mensagens['atencao']['senha_atual'] = 'A senha atual está incorreta.';
			}
			$post = Validation::factory($usuario_post)
				->rules('senha', $rules['senha']);
			if ( ! $post->check()) {
				$mensagens['atencao'] = array_merge($mensagens['atencao'], $post->errors('models/usuario'));
			}
			if ($usuario_post['senha'] != $usuario_post['senha_confirmacao']) {
				$mensagens['atencao']['senha_confirmacao'] = 'A confirmação da senha está incorreta';
			}
		}
	}

	private function validar_teclas(array &$mensagens)
	{
		$operacoes = ORM::factory('Operacao')->cached(3600)->find_all();

		$lista_teclas = Model_Util_Teclas::obter_lista_teclas();

		$teclas_post = $this->request->post('teclas');
		if ( ! is_array($teclas_post)) {
			throw new RuntimeException('Valor inválido para teclas');
		}
		foreach ($operacoes as $operacao) {
			if ( ! isset($teclas_post[$operacao->chave])) {
				throw new RuntimeException('Faltou informar a tecla: ' . $operacao->chave);
			}
			$dados_tecla = $teclas_post[$operacao->chave];
			if (is_array($dados_tecla)) {
				if (
					!isset($dados_tecla['codigo']) ||
					!isset($dados_tecla['shift']) ||
					!isset($dados_tecla['alt']) ||
					!isset($dados_tecla['ctrl'])
				) {
					throw new RuntimeException('Dados da chave inválidos: ' . $chave);
				}
				if ( ! array_key_exists($dados_tecla['codigo'], $lista_teclas)) {
					throw new RuntimeException('Tecla inválida: ' . $dados_tecla['codigo']);
				}
			} else {
				throw new RuntimeException('Dados da chave inválidos: ' . $chave);
			}
		}
	}

	private function validar_configuracoes(array &$mensagens)
	{
		$configuracoes_post = $this->request->post('configuracoes');

		$lista_sintetizadores = array_keys(Model_Util_Configuracoes::obter_lista_sintetizadores());

		if ( ! is_array($configuracoes_post)) {
			throw new RuntimeException('Valor inválido para configuracoes');
		}
		if ( ! isset($configuracoes_post['SINTETIZADOR']['valor'])) {
			throw new RuntimeException('Sintetizador não informado');
		}
		if ($configuracoes_post['SINTETIZADOR']['valor'] != 0 && !in_array($configuracoes_post['SINTETIZADOR']['valor'], $lista_sintetizadores)) {
			throw new RuntimeException('Sintetizador inválido: ' . $configuracoes_post['SINTETIZADOR']['valor']);
		}
	}

	private function salvar_usuario()
	{
		$usuario = Auth::instance()->get_user();
		$usuario->nome  = Arr::get($this->request->post('usuario'), 'nome');
		$usuario->email = Arr::get($this->request->post('usuario'), 'email');
		if (Arr::get($this->request->post('usuario'), 'senha') !== '') {
			$usuario->senha = Arr::get($this->request->post('usuario'), 'senha');
		}
		$usuario->save();
	}

	private function salvar_teclas()
	{
		$usuario = Auth::instance()->get_user();

		$operacoes = ORM::factory('Operacao')->cached(3600)->find_all();

		foreach ($operacoes as $operacao) {

			$operacao_usuario = ORM::factory('Usuario_Operacao')
				->where('id_usuario', '=', $usuario->pk())
				->and_where('id_operacao', '=', $operacao->pk())
				->find();

			$dados_tecla = Arr::get($this->request->post('teclas'), $operacao->chave);

			// Se tecla informada eh igual a padrao
			if (
				$operacao->tecla_padrao == $dados_tecla['codigo']
				&& (bool)$operacao->shift == (bool)$dados_tecla['shift']
				&& (bool)$operacao->alt == (bool)$dados_tecla['alt']
				&& (bool)$operacao->ctrl == (bool)$dados_tecla['ctrl']
			) {
				if ($operacao_usuario->loaded()) {
					$operacao_usuario->delete();
				}

			// Se a tecla informada mudou em relacao ao padrao
			} else {
				if ( ! $operacao_usuario->loaded()) {
					$operacao_usuario = ORM::factory('Usuario_Operacao');
					$operacao_usuario->id_usuario  = $usuario->pk();
					$operacao_usuario->id_operacao = $operacao->pk();
				}
				$operacao_usuario->tecla_personalizada = $dados_tecla['codigo'];
				$operacao_usuario->shift               = $dados_tecla['shift'] ? 1 : 0;
				$operacao_usuario->alt                 = $dados_tecla['alt'] ? 1 : 0;
				$operacao_usuario->ctrl                = $dados_tecla['ctrl'] ? 1 : 0;
				$operacao_usuario->save();
			}
		}
	}

	private function salvar_sintetizador()
	{
		$configuracoes_post = $this->request->post('configuracoes');

		$usuario = Auth::instance()->get_user();

		$configuracao = ORM::Factory('Configuracao')
			->where('chave', '=', 'SINTETIZADOR')
			->find();

		$configuracao_usuario = ORM::Factory('Usuario_Configuracao')
			->where('id_usuario', '=', $usuario->pk())
			->and_where('id_configuracao', '=', $configuracao->pk())
			->find();

		$sintetizador_usuario = json_encode($configuracoes_post['SINTETIZADOR']['valor'] ? $configuracoes_post['SINTETIZADOR']['valor'] : false);
		if ($sintetizador_usuario == $configuracao->valor_padrao) {
			if ($configuracao_usuario->loaded()) {
				$configuracao_usuario->delete();
			}
		} else {
			if ( ! $configuracao_usuario->loaded()) {
				$configuracao_usuario = ORM::factory('Usuario_Configuracao');
				$configuracao_usuario->id_usuario      = $usuario->pk();
				$configuracao_usuario->id_configuracao = $configuracao->pk();
			}
			$configuracao_usuario->valor_personalizado = $sintetizador_usuario;
			$configuracao_usuario->save();
		}
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
		$dados['configuracoes'] = Model_Util_Configuracoes::obter_configuracoes_usuario();
		return $dados;
	}

}
