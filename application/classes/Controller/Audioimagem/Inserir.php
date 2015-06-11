<?php
/**
 * Action para usuários cadastrarem imagens no sistema.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Inserir extends Controller_Geral {

	/**
	 * Action para exibir o formulário de cadastro de imagens.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Inserir Imagem');
		$this->adicionar_script(URL::cdn('js/audioimagem/inserir.min.js'));

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioimagem')), 'nome' => 'AudioImagem', 'icone' => 'picture'),
			array('nome' => 'Inserir Imagem', 'icone' => 'plus')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_imagem'] = array();
		$dados['form_imagem']['tamanho_limite_upload'] = Kohana::$config->load('audioweb.tamanho_limite_upload');
		$dados['form_imagem']['dados'] = isset($flash_data['imagem']) ? $flash_data['imagem'] : array();
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

		$this->template->content = View::Factory('audioimagem/inserir/index', $dados);
	}

	/**
	 * Salvar dados da imagem.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'audioimagem', 'controller' => 'inserir')) . URL::query(array()));
		}

		$dados_imagem = array(
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
		$files = Validation::factory($_FILES)
			->rule('arquivo', 'Upload::not_empty')
			->rule('arquivo', 'Upload::valid')
			->rule('arquivo', 'Upload::image')
			->rule('arquivo', 'Upload::size', array(':value', Kohana::$config->load('audioweb.tamanho_limite_upload')));

		if ( ! $post->check())
		{
			$mensagens = array('atencao' => $post->errors('models/imagem'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'audioimagem', 'controller' => 'inserir')) . URL::query(array()));
		}

		if ( ! $files->check())
		{
			$mensagens = array('atencao' => $files->errors('models/imagem'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'audioimagem', 'controller' => 'inserir')) . URL::query(array()));
		}

		$image_manipulation = Image::factory($_FILES['arquivo']['tmp_name']);

		$bd = Database::instance();
		$bd->begin();

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

			$imagem = ORM::Factory('Imagem');
			$imagem->nome        = $this->request->post('nome');
			$imagem->descricao   = $this->request->post('descricao');
			$imagem->rotulos     = $this->request->post('rotulos');
			$imagem->arquivo     = $_FILES['arquivo']['name'];
			$imagem->mime_type   = $image_manipulation->mime;
			$imagem->altura      = $image_manipulation->height;
			$imagem->largura     = $image_manipulation->width;
			$imagem->tipo_imagem = $tipo_imagem;
			$imagem->id_usuario  = Auth::instance()->get_user()->pk();
			$imagem->create();

			if ($this->request->post('publico_alvo'))
			{
				$imagem->add('publicos_alvos', $this->request->post('publico_alvo'));
			}

			Model_Util_Armazenamento_Arquivo::salvar(
				$imagem->pk(),
				file_get_contents($_FILES['arquivo']['tmp_name'])
			);

			unlink($_FILES['arquivo']['tmp_name']);

			$bd->commit();
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'audioimagem', 'controller' => 'inserir')) . URL::query(array()));
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao cadastrar imagem. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('acao_padrao', array('directory' => 'audioimagem', 'controller' => 'inserir')) . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Imagem cadastrada com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect(Route::url('listar', array('directory' => 'audioimagem')));
	}
}