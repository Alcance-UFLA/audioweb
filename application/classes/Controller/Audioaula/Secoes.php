<?php
/**
 * Action para listar as sessoes de uma aula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Preparar Aula');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('nome' => 'Preparar Aula', 'icone' => 'list-alt')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$aula = $this->obter_aula();

/*
		if ($aula->id_usuario != Auth::instance()->get_user()->pk())
		{
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
*/

		$secoes = ORM::Factory('Secao')
			->where('id_aula', '=', $aula->id_aula)
			->order_by('posicao');

		$lista_secoes = array();
		$lista = $secoes->find_all();

		$numero = array(
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0
		);
		$ultima_secao = null;
		foreach ($lista as $secao)
		{
			if ($ultima_secao && $ultima_secao->nivel > $secao->nivel)
			{
				for ($i = $secao->nivel + 1; $i <= 6; $i++) {
					$numero[$i] = 0;
				}
			}

			$numero[$secao->nivel] += 1;

			$dados_secao = $secao->as_array();
			$dados_secao['numero'] = implode(
				'.',
				array_slice($numero, 0, $secao->nivel)
			) . '.';

			$lista_secoes[] = $dados_secao;

			$ultima_secao = $secao;
		}

		$dados['aula'] = $aula->as_array();
		$dados['secoes'] = array(
			'lista' => $lista_secoes
		);

		$this->template->content = View::Factory('audioaula/secoes/index', $dados);
	}

	public function action_inserir()
	{
		$aula = $this->obter_aula();

		if ($this->request->param('opcao1') == 'salvar')
		{
			$this->requerer_autenticacao();
			if ($this->request->method() != 'POST')
			{
				HTTP::redirect('audioaula/secoes/' . $aula->id_aula . '/inserir' . URL::query(array()));
			}

			$dados_secao = array(
				'titulo' => $this->request->post('titulo'),
				'nivel'  => $this->request->post('nivel'),
			);

			$rules = ORM::Factory('Secao')->rules();
			$post = Validation::factory($this->request->post())
				->rules('titulo', $rules['titulo'])
				->rules('nivel', $rules['nivel']);

			if ( ! $post->check())
			{
				$mensagens = array('atencao' => $post->errors('models/secao'));
				Session::instance()->set('flash_message', $mensagens);
				$flash_data = array('secao' => $dados_secao);
				Session::instance()->set('flash_data', $flash_data);

				HTTP::redirect('audioaula/secoes/' . $aula->id_aula . '/inserir' . URL::query(array()));
			}

			$bd = Database::instance();
			$bd->begin();

			try
			{
				$ultima_secao = ORM::Factory('Secao')
					->where('id_aula', '=', $aula->id_aula)
					->order_by('posicao', 'DESC')
					->limit(1)
					->find();

				$secao = ORM::Factory('Secao');
				$secao->titulo  = $this->request->post('titulo');
				$secao->nivel   = $this->request->post('nivel');
				$secao->id_aula = $aula->pk();
				$secao->posicao = $ultima_secao->loaded() ? $ultima_secao->posicao + 1 : 1;
				$secao->create();

				$bd->commit();
			}
			catch (ORM_Validation_Exception $e)
			{
				$bd->rollback();

				$mensagens = array('erro' => $e->errors('models', TRUE));
				Session::instance()->set('flash_message', $mensagens);
				$flash_data = array('secao' => $dados_secao);
				Session::instance()->set('flash_data', $flash_data);

				HTTP::redirect('audioaula/secoes/' . $aula->id_aula . '/inserir' . URL::query(array()));
			}
			catch (Exception $e)
			{
				$bd->rollback();

				$mensagens = array('erro' => 'Erro inesperado ao cadastrar seção. Por favor, tente novamente mais tarde.');
				Session::instance()->set('flash_message', $mensagens);
				$flash_data = array('secao' => $dados_secao);
				Session::instance()->set('flash_data', $flash_data);

				HTTP::redirect('audioaula/secoes/' . $aula->id_aula . '/inserir' . URL::query(array()));
			}

			$mensagens = array('sucesso' => 'Seção cadastrada com sucesso.');
			Session::instance()->set('flash_message', $mensagens);

			HTTP::redirect('audioaula/secoes/' . $aula->id_aula);
		}

		$this->requerer_autenticacao();
		$this->definir_title('Inserir Seção');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('alterar', array('directory' => 'audioaula', 'controller' => 'secoes', 'id' => $this->request->param('id'))), 'nome' => 'Preparar Aula', 'icone' => 'list-alt'),
			array('nome' => 'Inserir Seção', 'icone' => 'plus')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['aula'] = $this->obter_aula()->as_array();
		$dados['form_secao'] = array();
		$dados['form_secao']['dados'] = isset($flash_data['secao']) ? $flash_data['secao'] : array();
		$dados['form_secao']['lista_niveis'] = array(
			'1' => '1 (mais relevante)',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6 (menos relevante)',
		);

		$this->template->content = View::Factory('audioaula/secoes/inserir/index', $dados);
	}

	private function obter_aula()
	{
		$aula = ORM::Factory('Aula', array('id_aula' => $this->request->param('id')));
		if ( ! $aula->loaded())
		{
			throw HTTP_Exception::factory(404, 'Aula inválida');
		}
		return $aula;
	}
}
