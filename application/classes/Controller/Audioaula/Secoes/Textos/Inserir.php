<?php
/**
 * Action para inserir um texto em uma secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Textos_Inserir extends Controller_Geral {

	public function action_index()
	{
		$aula = $this->obter_aula();
		$secao = $this->obter_secao();

		$this->requerer_autenticacao();
		$this->definir_title('Inserir Texto em Seção');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $this->request->param('id_aula'))), 'nome' => 'Preparar Aula', 'icone' => 'list-alt'),
			array('nome' => 'Inserir Texto em Seção', 'icone' => 'plus')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['aula'] = $aula->as_array();
		$dados['secao'] = $secao->as_array();
		$dados['form_texto'] = array();
		$dados['form_texto']['dados'] = isset($flash_data['texto_secao']) ? $flash_data['texto_secao'] : array();

		$this->template->content = View::Factory('audioaula/secoes/textos/inserir/index', $dados);
	}

	public function action_salvar()
	{
		$aula = $this->obter_aula();
		$secao = $this->obter_secao();

		$this->requerer_autenticacao();
		if ($this->request->method() != 'POST') {
			HTTP::redirect(Route::url('inserir_texto_secao', array('id_aula' => $aula->id_aula, 'id_secao' => $secao->id_secao)) . URL::query(array()));
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

			HTTP::redirect(Route::url('inserir_texto_secao', array('id_aula' => $aula->id_aula, 'id_secao' => $secao->id_secao)) . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		try {
			$texto_secao = ORM::Factory('Secao_Texto');
			$texto_secao->texto  = $this->request->post('texto');
			$texto_secao->posicao = $this->obter_ultima_posicao($secao) + 1;
			$texto_secao->id_secao = $secao->pk();
			$texto_secao->create();

			$bd->commit();
		} catch (ORM_Validation_Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('texto_secao' => $dados_texto_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('inserir_texto_secao', array('id_aula' => $aula->id_aula, 'id_secao' => $secao->id_secao)) . URL::query(array()));
		} catch (Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao cadastrar texto na seção. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('texto_secao' => $dados_texto_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('inserir_texto_secao', array('id_aula' => $aula->id_aula, 'id_secao' => $secao->id_secao)) . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Texto cadastrado com sucesso na Seção.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect(Route::url('listar_secoes', array('id_aula' => $aula->id_aula)));
	}

	private function obter_aula()
	{
		$aula = ORM::Factory('Aula', array('id_aula' => $this->request->param('id_aula')));
		if ( ! $aula->loaded()) {
			throw HTTP_Exception::factory(404, 'Aula inválida');
		}
		/*
		if ($aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		*/
		return $aula;
	}

	private function obter_secao()
	{
		$secao = ORM::Factory('Secao', array('id_secao' => $this->request->param('id_secao')));
		if ( ! $secao->loaded()) {
			throw HTTP_Exception::factory(404, 'Seção inválida');
		}
		/*
		if ($secao->id_aula != $this->request->param('id_aula')) {
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		*/
		return $secao;
	}

	private function obter_ultima_posicao($secao)
	{
		$ultimo_texto = ORM::Factory('Secao_Texto')
			->where('id_secao', '=', $secao->pk())
			->order_by('posicao', 'DESC')
			->limit(1)
			->find();
		$ultima_imagem = ORM::Factory('Secao_Imagem')
			->where('id_secao', '=', $secao->pk())
			->order_by('posicao', 'DESC')
			->limit(1)
			->find();
		$ultima_formula = ORM::Factory('Secao_Formula')
			->where('id_secao', '=', $secao->pk())
			->order_by('posicao', 'DESC')
			->limit(1)
			->find();
		return max(
			$ultimo_texto->loaded()   ? $ultimo_texto->posicao   : 0,
			$ultima_imagem->loaded()  ? $ultima_imagem->posicao  : 0,
			$ultima_formula->loaded() ? $ultima_formula->posicao : 0
		);
	}
}
