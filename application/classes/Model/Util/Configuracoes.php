<?php
/**
 * Classe responsavel por obter as preferencias do usuario
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Util_Configuracoes {

	/**
	 * Obtem as configuracoes do usuario
	 * @return array
	 */
	public static function obter_configuracoes_usuario()
	{
		$configuracoes = array();

		// Obter configuracoes padrao
		$configuracoes_padrao = ORM::Factory('Configuracao')->cached(3600)->find_all();
		foreach ($configuracoes_padrao as $configuracao) {
			$configuracoes[$configuracao->chave] = array(
				'id_configuracao' => $configuracao->pk(),
				'chave'           => $configuracao->chave,
				'nome'            => $configuracao->nome,
				'valor'           => json_decode($configuracao->valor_padrao, true)
			);
		}

		if (Auth::instance()->get_user()) {
			$configuracoes_usuario = ORM::Factory('Usuario_Configuracao')
				->where('id_usuario', '=', Auth::instance()->get_user()->pk())
				->find_all();
			foreach ($configuracoes_usuario as $configuracao_usuario) {
				$configuracoes[$configuracao_usuario->configuracao->chave]['valor'] =
					json_decode($configuracao_usuario->valor_personalizado, true);
			}
		}

		return $configuracoes;
	}

	public static function obter_lista_sintetizadores()
	{
		return array(
			'espeak'  => 'Espeak',
			'acapela' => 'Acapela',
			'ispeech' => 'Ispeech'
		);
	}
}