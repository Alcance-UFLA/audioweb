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
		$this->definir_title('Inserir Imagem');

		$dados = array();
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_imagem'] = array();
		$dados['form_imagem']['dados'] = isset($flash_data['imagem']) ? $flash_data['imagem'] : array();
		$dados['form_imagem']['lista_id_tipo_imagem'] = array(1 => 'a', 2 => 'b');

		$this->template->content = View::Factory('audioimagem/inserir/index', $dados);
	}

	/**
	 * Salvar dados da imagem.
	 * @return void
	 */
	public function action_salvar()
	{
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('audioimagem/inserir' . URL::query(array()));
		}

		$dados_imagem = array(
			'nome'           => $this->request->post('nome'),
			'descricao'      => $this->request->post('descricao'),
			'id_tipo_imagem' => $this->request->post('id_tipo_imagem'),
			'rotulos'        => $this->request->post('rotulos')
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
			->rule('arquivo', 'Upload::size', array(':value', '2M'));

		if ( ! $post->check())
		{
			$mensagens = array('atencao' => $post->errors('models/imagem'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioimagem/inserir' . URL::query(array()));
		}

		if ( ! $files->check())
		{
			$mensagens = array('atencao' => $files->errors('models/imagem'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioimagem/inserir' . URL::query(array()));
		}

		$image_manipulation = Image::factory($_FILES['arquivo']['tmp_name']);

		$bd = Database::instance();
		$bd->begin();

		try
		{
			$imagem = ORM::Factory('Imagem');
			$imagem->nome              = $this->request->post('nome');
			$imagem->descricao         = $this->request->post('descricao');
			$imagem->rotulos           = $this->request->post('rotulos');
			$imagem->arquivo           = $_FILES['arquivo']['name'];
			$imagem->mime_type         = $image_manipulation->mime;
			$imagem->altura            = $image_manipulation->height;
			$imagem->largura           = $image_manipulation->width;
			$imagem->id_tipo_imagem    = $this->request->post('id_tipo_imagem');
			$imagem->id_usuario        = Auth::instance()->get_user()->pk();
			$imagem->create();

			$arquivo = ORM::Factory('Arquivo_Imagem');
			$arquivo->id_imagem = $imagem->pk();
			$arquivo->conteudo  = file_get_contents($_FILES['arquivo']['tmp_name']);
			$arquivo->create();

			$bd->commit();
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioimagem/inserir' . URL::query(array()));
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao cadastrar imagem. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioimagem/inserir' . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Imagem cadastrada com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('audioimagem/listar');
	}
}