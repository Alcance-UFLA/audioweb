<?php
/**
 * Action para alterar uma secao de uma aula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Alterar extends Controller_Geral {

	public function action_index()
	{
		$aula = $this->obter_aula();

		$this->requerer_autenticacao();
		$this->definir_title('Alterar Seção');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $this->request->param('id_aula'))), 'nome' => 'Preparar Aula', 'icone' => 'list-alt'),
			array('nome' => 'Alterar Seção', 'icone' => 'pencil')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['aula'] = $aula->as_array();
		$dados['form_secao'] = array();
		$dados['form_secao']['dados'] = isset($flash_data['secao']) ? $flash_data['secao'] : $this->obter_dados_secao();
		$dados['form_secao']['lista_niveis'] = array(
			'1' => '1 (mais relevante)',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6 (menos relevante)',
		);

		$this->template->content = View::Factory('audioaula/secoes/alterar/index', $dados);
	}

	public function action_salvar()
	{
		$id_secao = $this->request->param('id_secao');
		$aula = $this->obter_aula();

		$this->requerer_autenticacao();
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('audioaula/secoes/' . $aula->id_aula . '/alterar/' . $id_secao . URL::query(array()));
		}

		$dados_secao = array(
			'id_secao' => $id_secao,
			'titulo'   => $this->request->post('titulo'),
			'nivel'    => $this->request->post('nivel'),
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

			HTTP::redirect('audioaula/secoes/' . $aula->id_aula . '/alterar/' . $id_secao . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		try
		{
			$secao = $this->obter_secao();
			$secao->titulo  = $this->request->post('titulo');
			$secao->nivel   = $this->request->post('nivel');
			$secao->save();

			$bd->commit();
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('secao' => $dados_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioaula/secoes/' . $aula->id_aula . '/alterar/' . $id_secao . URL::query(array()));
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao alterar seção. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('secao' => $dados_secao);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioaula/secoes/' . $aula->id_aula . '/alterar/' . $id_secao . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Seção alterada com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('audioaula/secoes/' . $aula->id_aula);
	}

	private function obter_secao()
	{
		$secao = ORM::Factory('Secao', array('id_secao' => $this->request->param('id_secao')));
		if ( ! $secao->loaded())
		{
			throw HTTP_Exception::factory(404, 'Seção inválida');
		}
		if ($secao->id_aula != $this->request->param('id_aula'))
		{
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		return $secao;
	}

	private function obter_dados_secao()
	{
		return $this->obter_secao()->as_array();
	}

	private function obter_aula()
	{
		$aula = ORM::Factory('Aula', array('id_aula' => $this->request->param('id_aula')));
		if ( ! $aula->loaded())
		{
			throw HTTP_Exception::factory(404, 'Aula inválida');
		}
		/*
		if ($aula->id_usuario != Auth::instance()->get_user()->pk())
		{
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		*/
		return $aula;
	}
}
