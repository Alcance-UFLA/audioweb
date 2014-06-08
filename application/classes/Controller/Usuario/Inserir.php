<?php
/**
 * Action para inserir usuários
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Usuario_Inserir extends Controller_Geral {

	private $usuario;
	private $mensagens;

	public function action_index()
	{
		$this->usuario = ORM::Factory('usuario');
		$this->mensagens = array();
		$this->exibir_form();
	}

	private function exibir_form()
	{
		$this->definir_title('Adicionar Usuário');

		$view = View::Factory('usuario/inserir/index');
		$view->set('usuario', $this->usuario);
		$view->set('mensagens', $this->mensagens);
		$this->template->content = $view;
	}

	/**
	 * Salvar dados do usuário
	 * @return void
	 */
	public function action_salvar()
	{
		$this->usuario = ORM::Factory('usuario');
		$this->mensagens = array();

		$dados = $this->request->post();

		$regras_extras = Validation::factory($dados);
		$regras_extras->rule('usuario', 'Model_Usuario::usuario_unico');

		try
		{
			$this->usuario->values($dados, array('usuario', 'nome'));
			$this->usuario->create($regras_extras);

			$this->mensagens['sucesso'][] = 'Usuário cadastrado com sucesso.';
			Session::instance()->set('flash_message', $this->mensagens);

			HTTP::redirect('usuario/listar');
		}
		catch (ORM_Validation_Exception $e)
		{
			$this->mensagens['erro'] = $e->errors('models', TRUE);
			if (isset($this->mensagens['erro']['_external'])) {
				$erros_extras = $this->mensagens['erro']['_external'];
				unset($this->mensagens['erro']['_external']);
				$this->mensagens['erro'] = array_merge($this->mensagens['erro'], $erros_extras);
			}
			$this->exibir_form();
		}
	}
}