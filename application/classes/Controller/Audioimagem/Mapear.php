<?php
/**
 * Action para mapear uma imagem.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Mapear extends Controller_Geral {

	/**
	 * Action para exibir o formulário de mapear imagens.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Mapear Imagem');

		$dados = array();
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_imagem'] = array();
		$dados['form_imagem']['dados'] = isset($flash_data['imagem']) ? $flash_data['imagem'] : $this->obter_dados_imagem();

		$this->template->content = View::Factory('audioimagem/mapear/index', $dados);
	}

	/**
	 * Salvar dados de mapeamento da imagem.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$id = $this->request->param('id');

		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('audioimagem/mapear/' . $id . URL::query(array()));
		}

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
			throw new RuntimeException('Imagem nao pertence ao usuario logado');
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
		$dados_imagem['id_imagem'] = $imagem->pk();
		$dados_imagem['nome']      = $imagem->nome;
		$dados_imagem['arquivo']   = $imagem->arquivo;
		$dados_imagem['id_conta']  = $imagem->usuario->id_conta;
		$dados_imagem['regioes']   = array();

		foreach ($imagem->regioes->order_by('posicao')->find_all() as $regiao)
		{
			$dados_imagem['regioes'][] = array(
				'id_imagem_regiao' => $regiao->pk(),
				'nome'             => $regiao->nome,
				'descricao'        => $regiao->descricao,
				'posicao'          => $regiao->posicao,
				'tipo_regiao'      => $regiao->tipo_regiao,
				'coordenadas'      => $regiao->coordenadas
			);
		}

		return $dados_imagem;
	}
}
