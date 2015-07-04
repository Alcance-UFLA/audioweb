<?php
/**
 * Action para alterar imagem da secao de uma aula.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Imagens_Alterar extends Controller_Geral {

	/**
	 * Action para exibir o formulário de alterar imagem.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Alterar Imagem de Seção');
		$this->adicionar_style(URL::cdn('css/audioaula/secoes/imagens/inserir.min.css'));
		$this->adicionar_script(URL::cdn('js/audioaula/secoes/imagens/inserir.min.js'));

		$imagem_secao = $this->obter_imagem_secao();

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $imagem_secao->secao->aula->pk())), 'nome' => 'Preparar Aula', 'icone' => 'list-alt'),
			array('nome' => 'Alterar Imagem de Seção', 'icone' => 'pencil')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['secao'] = $imagem_secao->secao->as_array();
		$dados['secao']['aula'] = $imagem_secao->secao->aula->as_array();
		$dados['form_imagem'] = array();
		$dados['form_imagem']['dados'] = isset($flash_data['imagem_secao']) ? $flash_data['imagem_secao'] : $imagem_secao->as_array();
		$dados['form_imagem']['lista_imagens'] = $this->obter_imagens();

		$this->template->content = View::Factory('audioaula/secoes/imagens/alterar/index', $dados);
	}

	/**
	 * Salvar dados da imagem.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$imagem_secao = $this->obter_imagem_secao();
		$secao = $imagem_secao->secao;
		$aula = $secao->aula;

		if ($this->request->method() != 'POST') {
			HTTP::redirect(Route::url('alterar_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_secao_imagem' => $imagem_secao->pk())) . URL::query(array()));
		}

		$dados_imagem_secao = array(
			'id_imagem' => $this->request->post('id_imagem'),
		);

		$rules = ORM::Factory('Secao_Imagem')->rules();
		$post = Validation::factory($this->request->post())
			->rules('id_imagem', $rules['id_imagem']);

		if ( ! $post->check()) {
			$mensagens = array('atencao' => $post->errors('models/secao/imagem'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem_secao' => $dados_imagem_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('alterar_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_secao_imagem' => $imagem_secao->pk())) . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		$mensagens_sucesso = array();
		try {
			$imagem_secao->id_imagem = $this->request->post('id_imagem');
			$imagem_secao->save();
			$mensagens_sucesso[] = 'Imagem alterada com sucesso.';

			$bd->commit();
		} catch (ORM_Validation_Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem_secao' => $dados_imagem_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('alterar_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_secao_imagem' => $imagem_secao->pk())) . URL::query(array()));
		} catch (Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao alterar a imagem. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem_secao' => $dados_imagem_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('alterar_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_secao_imagem' => $imagem_secao->pk())) . URL::query(array()));
		}

		$mensagens = array('sucesso' => $mensagens_sucesso);
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect(Route::url('listar_secoes', array('id_aula' => $aula->pk())));
	}

	/**
	 * Obtem o objeto da imagem de secao que deve ser alterada.
	 * @return Model_Secao_Imagem
	 */
	private function obter_imagem_secao()
	{
		$id = $this->request->param('id_secao_imagem');

		$imagem_secao = ORM::factory('Secao_Imagem', $id);
		if ( ! $imagem_secao->loaded()) {
			throw new RuntimeException('Imagem da Seção inválida');
		}
		if ($imagem_secao->id_secao != $this->request->param('id_secao')) {
			throw new RuntimeException('Imagem nao pertence à seção informada.');
		}
		if ($imagem_secao->secao->id_aula != $this->request->param('id_aula')) {
			throw new RuntimeException('Seção nao pertence à aula informada.');
		}
		/*
		if ($imagem_secao->secao->aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw new RuntimeException('Aula nao pertence ao usuario logado');
		}
		*/
		return $imagem_secao;
	}

	private function obter_imagens()
	{
		$imagens = ORM::factory('Imagem')
			->cached(20)
			//->where('id_usuario', '=', Auth::instance()->get_usar()->pk())
			->find_all()
			->as_array();

		$lista = array();
		foreach ($imagens as $imagem) {
			$lista[] = array(
				'id_imagem' => $imagem->pk(),
				'nome'      => $imagem->nome,
				'arquivo'   => $imagem->arquivo,
				'id_conta'  => $imagem->usuario->id_conta,
				'altura'    => $imagem->altura,
				'largura'   => $imagem->largura
			);
		}
		return $lista;
	}

}
