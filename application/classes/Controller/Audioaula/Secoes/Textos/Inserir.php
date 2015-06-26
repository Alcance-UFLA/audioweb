<?php
/**
 * Action para inserir um texto em uma secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Textos_Inserir extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Inserir Texto em Seção');

		$secao = $this->obter_secao();

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $secao->aula->pk())), 'nome' => 'Preparar Aula', 'icone' => 'list-alt'),
			array('nome' => 'Inserir Texto em Seção', 'icone' => 'plus')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['secao'] = $secao->as_array();
		$dados['secao']['aula'] = $secao->aula->as_array();
		$dados['form_texto'] = array();
		$dados['form_texto']['dados'] = isset($flash_data['texto_secao']) ? $flash_data['texto_secao'] : array();

		$this->template->content = View::Factory('audioaula/secoes/textos/inserir/index', $dados);
	}

	public function action_salvar()
	{
		$secao = $this->obter_secao();
		$aula = $secao->aula;

		$this->requerer_autenticacao();
		if ($this->request->method() != 'POST') {
			HTTP::redirect(Route::url('inserir_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())) . URL::query(array()));
		}

		$dados_texto_secao = array(
			'texto' => $this->request->post('texto')
		);

		$rules = ORM::Factory('Secao_Texto')->rules();
		$post = Validation::factory($this->request->post())
			->rules('texto', $rules['texto']);

		if ( ! $post->check()) {
			$mensagens = array('atencao' => $post->errors('models/secao/texto'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('texto_secao' => $dados_texto_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('inserir_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())) . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		try {
			$texto_secao = ORM::Factory('Secao_Texto');
			$texto_secao->texto  = $this->request->post('texto');
			$texto_secao->posicao = $secao->quantidade_itens() + 1;
			$texto_secao->id_secao = $secao->pk();
			$texto_secao->create();

			$bd->commit();
		} catch (ORM_Validation_Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('texto_secao' => $dados_texto_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('inserir_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())) . URL::query(array()));
		} catch (Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao cadastrar texto na seção. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('texto_secao' => $dados_texto_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('inserir_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())) . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Texto cadastrado com sucesso na Seção.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect(Route::url('listar_secoes', array('id_aula' => $aula->pk())));
	}

	private function obter_secao()
	{
		$secao = ORM::Factory('Secao', array('id_secao' => $this->request->param('id_secao')));
		if ( ! $secao->loaded()) {
			throw HTTP_Exception::factory(404, 'Seção inválida');
		}
		if ($secao->id_aula != $this->request->param('id_aula')) {
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		/*
		if ($secao->aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		*/
		return $secao;
	}

}
