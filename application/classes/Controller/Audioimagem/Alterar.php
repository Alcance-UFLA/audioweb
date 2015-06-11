<?php
/**
 * Action para alterar dados de uma imagem.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Alterar extends Controller_Geral {

	/**
	 * Action para exibir o formulário de alterar imagens.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Alterar Imagem');
		$this->adicionar_script(URL::cdn('js/audioimagem/alterar.min.js'));

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioimagem')), 'nome' => 'AudioImagem', 'icone' => 'picture'),
			array('nome' => 'Alterar Imagem', 'icone' => 'pencil')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_imagem'] = array();
		$dados['form_imagem']['tamanho_limite_upload'] = Kohana::$config->load('audioweb.tamanho_limite_upload');
		$dados['form_imagem']['dados'] = isset($flash_data['imagem']) ? $flash_data['imagem'] : $this->obter_dados_imagem();
		$dados['form_imagem']['lista_id_tipo_imagem'] = ORM::Factory('Tipo_Imagem')
			->cached(3600)
			->order_by('id_tipo_imagem')
			->find_all()
			->as_array('id_tipo_imagem', 'nome');
		$dados['form_imagem']['lista_id_publico_alvo'] = ORM::Factory('Publico_Alvo')
			->cached(3600)
			->order_by('id_publico_alvo')
			->find_all()
			->as_array('id_publico_alvo', 'nome');

		$this->template->content = View::Factory('audioimagem/alterar/index', $dados);
	}

	/**
	 * Salvar dados da imagem.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$id = $this->request->param('id');
		$enviou_arquivo = $_FILES['arquivo']['error'] !=  UPLOAD_ERR_NO_FILE;

		if ($this->request->method() != 'POST')
		{
			HTTP::redirect(Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'alterar', 'id' => $id)) . URL::query(array()));
		}

		$dados_imagem_atual = $this->obter_dados_imagem();

		$dados_imagem = array(
			'id_imagem'      => $id,
			'nome'           => $this->request->post('nome'),
			'descricao'      => $this->request->post('descricao'),
			'id_tipo_imagem' => $this->request->post('id_tipo_imagem'),
			'rotulos'        => $this->request->post('rotulos'),
			'publico_alvo'   => $this->request->post('publico_alvo'),
		);

		$rules = ORM::Factory('Imagem')->rules();
		$post = Validation::factory($this->request->post())
			->rules('nome', $rules['nome'])
			->rules('descricao', $rules['descricao'])
			->rules('rotulos', $rules['rotulos'])
			->rules('id_tipo_imagem', $rules['id_tipo_imagem']);

		if ($enviou_arquivo)
		{
			$files = Validation::factory($_FILES)
				->rule('arquivo', 'Upload::not_empty')
				->rule('arquivo', 'Upload::valid')
				->rule('arquivo', 'Upload::image')
				->rule('arquivo', 'Upload::size', array(':value', Kohana::$config->load('audioweb.tamanho_limite_upload')));
		}

		if ( ! $post->check())
		{
			$mensagens = array('atencao' => $post->errors('models/imagem'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'alterar', 'id' => $id)) . URL::query(array()));
		}

		if ($enviou_arquivo && ! $files->check())
		{
			$mensagens = array('atencao' => $files->errors('models/imagem'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'alterar', 'id' => $id)) . URL::query(array()));
		}

		if ($enviou_arquivo)
		{
			$image_manipulation = Image::factory($_FILES['arquivo']['tmp_name']);
		}

		$bd = Database::instance();
		$bd->begin();

		$mensagens_sucesso = array();
		try
		{
			// Obter/Validar tipo de imagem
			$tipo_imagem = ORM::Factory('Tipo_Imagem', $this->request->post('id_tipo_imagem'));
			if ( ! $tipo_imagem->loaded())
			{
				throw new RuntimeException('Tipo de imagem invalida');
			}

			// Obter/Validar publicos-alvo
			if ($this->request->post('publico_alvo'))
			{
				$ids_publico_alvo = ORM::Factory('Publico_Alvo')
					->cached(3600)
					->order_by('id_publico_alvo')
					->find_all()
					->as_array('id_publico_alvo', 'id_publico_alvo');
				foreach ($this->request->post('publico_alvo') as $id_publico_alvo)
				{
					if ( ! isset($ids_publico_alvo[$id_publico_alvo]))
					{
						throw new RuntimeException('Publico-alvo invalido');
					}
				}
			}

			$imagem = $this->obter_imagem();
			$imagem->nome        = $this->request->post('nome');
			$imagem->descricao   = $this->request->post('descricao');
			$imagem->rotulos     = $this->request->post('rotulos');
			$imagem->tipo_imagem = $tipo_imagem;
			if ($enviou_arquivo)
			{
				$imagem->arquivo   = $_FILES['arquivo']['name'];
				$imagem->mime_type = $image_manipulation->mime;
				$imagem->altura    = $image_manipulation->height;
				$imagem->largura   = $image_manipulation->width;
			}
			$imagem->save();
			$mensagens_sucesso[] = 'Imagem alterada com sucesso.';

			$publicos_alvos_atuais = $dados_imagem_atual['publico_alvo'];
			$publicos_alvos_solicitados = $this->request->post('publico_alvo') ? $this->request->post('publico_alvo') : array();

			// Remover os publicos-alvos que foram desmarcados
			$publicos_alvos_remover = array();
			foreach ($publicos_alvos_atuais as $id_publico_alvo_atual)
			{
				if ( ! in_array($id_publico_alvo_atual, $publicos_alvos_solicitados))
				{
					$publicos_alvos_remover[] = $id_publico_alvo_atual;
				}
			}
			if ($publicos_alvos_remover)
			{
				$imagem->remove('publicos_alvos', $publicos_alvos_remover);
			}

			// Adicionar os publicos-alvos novos que foram solicitados
			$publicos_alvos_adicionar = array();
			foreach ($publicos_alvos_solicitados as $id_publico_alvo_solicitado)
			{
				if ( ! in_array($id_publico_alvo_solicitado, $publicos_alvos_atuais))
				{
					$publicos_alvos_adicionar[] = $id_publico_alvo_solicitado;
				}
			}
			if ($publicos_alvos_adicionar)
			{
				$imagem->add('publicos_alvos', $publicos_alvos_adicionar);
			}

			if ($enviou_arquivo)
			{
				Model_Util_Armazenamento_Arquivo::salvar(
					$imagem->pk(),
					file_get_contents($_FILES['arquivo']['tmp_name'])
				);
				unlink($_FILES['arquivo']['tmp_name']);
				$mensagens_sucesso[] = 'Arquivo de imagem modificado.';
			}
			else
			{
				$mensagens_sucesso[] = 'Arquivo de imagem mantido.';
			}

			$bd->commit();
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'alterar', 'id' => $id)) . URL::query(array()));
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao alterar a imagem. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'alterar', 'id' => $id)) . URL::query(array()));
		}

		$mensagens = array('sucesso' => $mensagens_sucesso);
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect(Route::url('listar', array('directory' => 'audioimagem')));
	}

	/**
	 * Obtem o objeto da imagem que deve ser alterada.
	 * @return Model_Imagem
	 */
	private function obter_imagem()
	{
		$id = $this->request->param('id');

		$imagem = ORM::factory('Imagem', $id);
		if ( ! $imagem->loaded())
		{
			throw new RuntimeException('Imagem invalida');
		}
		if ($imagem->id_usuario != Auth::instance()->get_user()->pk())
		{
			//throw new RuntimeException('Imagem nao pertence ao usuario logado');
		}
		return $imagem;
	}

	/**
	 * Retorna os dados da imagem que deve ser alterada, para usar no formulario.
	 * @return array
	 */
	private function obter_dados_imagem()
	{
		$imagem = $this->obter_imagem();
		$dados_imagem = array();
		$dados_imagem['id_imagem']      = $imagem->pk();
		$dados_imagem['nome']           = $imagem->nome;
		$dados_imagem['descricao']      = $imagem->descricao;
		$dados_imagem['id_tipo_imagem'] = $imagem->id_tipo_imagem;
		$dados_imagem['rotulos']        = $imagem->rotulos;
		$dados_imagem['publico_alvo']   = array();

		foreach ($imagem->publicos_alvos->find_all() as $publico_alvo)
		{
			$dados_imagem['publico_alvo'][] = $publico_alvo->id_publico_alvo;
		}
		return $dados_imagem;
	}
}
