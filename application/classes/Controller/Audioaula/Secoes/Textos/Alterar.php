<?php
/**
 * Action para alterar dados do texto da secao de uma aula.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Textos_Alterar extends Controller_Geral {

	/**
	 * Action para exibir o formulário de alterar texto.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Alterar Texto de Seção');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $this->request->param('id_aula'))), 'nome' => 'Preparar Aula', 'icone' => 'list-alt'),
			array('nome' => 'Alterar Texto de Seção', 'icone' => 'pencil')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['aula'] = $this->obter_aula()->as_array();
		$dados['secao'] = $this->obter_secao()->as_array();
		$dados['form_texto'] = array();
		$dados['form_texto']['dados'] = isset($flash_data['texto_secao']) ? $flash_data['texto_secao'] : $this->obter_texto_secao()->as_array();

		$this->template->content = View::Factory('audioaula/secoes/textos/alterar/index', $dados);
	}

	/**
	 * Salvar dados do texto.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$aula = $this->obter_aula();
		$secao = $this->obter_secao();
		$texto_secao = $this->obter_texto_secao();

		if ($this->request->method() != 'POST') {
			HTTP::redirect(Route::url('alterar_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_secao_texto' => $texto_secao->pk())) . URL::query(array()));
		}

		$dados_texto_secao = array(
			'texto' => $this->request->post('texto'),
		);

		$rules = ORM::Factory('Secao_Texto')->rules();
		$post = Validation::factory($this->request->post())
			->rules('texto', $rules['texto']);

		if ( ! $post->check()) {
			$mensagens = array('atencao' => $post->errors('models/secao/texto'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('texto_secao' => $dados_texto_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('alterar_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_secao_texto' => $texto_secao->pk())) . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		$mensagens_sucesso = array();
		try {
			$texto_secao->texto = $this->request->post('texto');
			$texto_secao->save();
			$mensagens_sucesso[] = 'Texto alterado com sucesso.';

			$bd->commit();
		} catch (ORM_Validation_Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('texto_secao' => $dados_texto_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('alterar_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_secao_texto' => $texto_secao->pk())) . URL::query(array()));
		} catch (Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao alterar o texto. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('texto_secao' => $dados_texto_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('alterar_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_secao_texto' => $texto_secao->pk())) . URL::query(array()));
		}

		$mensagens = array('sucesso' => $mensagens_sucesso);
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect(Route::url('listar_secoes', array('id_aula' => $aula->pk())));
	}

	/**
	 * Obtem o objeto da aula.
	 * @return Model_Aula
	 */
	private function obter_aula()
	{
		$id = $this->request->param('id_aula');

		$aula = ORM::factory('Aula', $id);
		if ( ! $aula->loaded()) {
			throw new RuntimeException('Aula invalida');
		}
		/*
		if ($aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw new RuntimeException('Aula nao pertence ao usuario logado');
		}
		*/
		return $aula;
	}

	/**
	 * Obtem o objeto da secao da aula.
	 * @return Model_Secao
	 */
	private function obter_secao()
	{
		$id = $this->request->param('id_secao');

		$secao = ORM::factory('Secao', $id);
		if ( ! $secao->loaded()) {
			throw new RuntimeException('Secao invalida');
		}
		if ($secao->id_aula != $this->obter_aula()->pk()) {
			throw new RuntimeException('Secao nao pertence a aula informada');
		}
		return $secao;
	}

	/**
	 * Obtem o objeto do texto da secao.
	 * @return Model_Secao_Texto
	 */
	private function obter_texto_secao()
	{
		$id = $this->request->param('id_secao_texto');

		$texto_secao = ORM::factory('Secao_Texto', $id);
		if ( ! $texto_secao->loaded()) {
			throw new RuntimeException('Texto invalido');
		}
		if ($texto_secao->id_secao != $this->obter_secao()->pk()) {
			throw new RuntimeException('Texto nao pertence a secao informada');
		}
		return $texto_secao;
	}

}
