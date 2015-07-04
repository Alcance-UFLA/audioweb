<?php
/**
 * Action para inserir uma imagem em uma secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Imagens_Inserir extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Inserir Imagem em Seção');
		$this->adicionar_style(URL::cdn('css/audioaula/secoes/imagens/inserir.min.css'));
		$this->adicionar_script(URL::cdn('js/audioaula/secoes/imagens/inserir.min.js'));

		$secao = $this->obter_secao();

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $secao->aula->pk())), 'nome' => 'Preparar Aula', 'icone' => 'list-alt'),
			array('nome' => 'Inserir Imagem em Seção', 'icone' => 'plus')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['secao'] = $secao->as_array();
		$dados['secao']['aula'] = $secao->aula->as_array();
		$dados['form_imagem'] = array();
		$dados['form_imagem']['dados'] = isset($flash_data['imagem_secao']) ? $flash_data['imagem_secao'] : array();
		$dados['form_imagem']['lista_imagens'] = $this->obter_imagens();

		$this->template->content = View::Factory('audioaula/secoes/imagens/inserir/index', $dados);
	}

	public function action_salvar()
	{
		$secao = $this->obter_secao();
		$aula = $secao->aula;

		$this->requerer_autenticacao();
		if ($this->request->method() != 'POST') {
			HTTP::redirect(Route::url('inserir_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())) . URL::query(array()));
		}

		$dados_imagem_secao = array(
			'id_imagem' => $this->request->post('id_imagem')
		);

		$rules = ORM::Factory('Secao_Imagem')->rules();
		$post = Validation::factory($this->request->post())
			->rules('id_imagem', $rules['id_imagem']);

		if ( ! $post->check()) {
			$mensagens = array('atencao' => $post->errors('models/secao/imagem'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem_secao' => $dados_imagem_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('inserir_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())) . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		try {
			$imagem_secao = ORM::Factory('Secao_Imagem');
			$imagem_secao->id_imagem  = $this->request->post('id_imagem');
			$imagem_secao->posicao    = $secao->quantidade_itens() + 1;
			$imagem_secao->id_secao   = $secao->pk();
			$imagem_secao->create();

			$bd->commit();
		} catch (ORM_Validation_Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem_secao' => $dados_imagem_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('inserir_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())) . URL::query(array()));
		} catch (Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao cadastrar imagem na seção. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem_secao' => $dados_imagem_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect(Route::url('inserir_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())) . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Imagem cadastrada com sucesso na Seção.');
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
