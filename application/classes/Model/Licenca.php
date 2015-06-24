<?php
/**
 * Licença de utilização do sistema
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Licenca extends ORM {
	protected $_table_name = 'licencas';
	protected $_primary_key = 'id_licenca';

	protected $_table_columns = array(
		'id_licenca' => NULL,
		'nome' => NULL,
	);

	protected $_has_many = array(
		'contas' => array('model' => 'Conta', 'foreign_key' => 'id_licenca'),
		'restricoes' => array('model' => 'Restricao_Licenca', 'foreign_key' => 'id_licenca'),
	);

	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty', null),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128))
			),
		);
	}

	/**
	 * Obtem o valor de uma restricao pela chave
	 * @param string $chave
	 * @return mixed
	 */
	public function obter_restricao($chave)
	{
		// Obter a restricao padrao da aplicacao
		$restricao_aplicacao = ORM::factory('Restricao_Aplicacao');
		$restricao_aplicacao
			->where('chave', '=', $chave)
			->find();
		if ( ! $restricao_aplicacao->loaded()) {
			throw new InvalidArgumentException('Chave de Restricao invalida');
		}
		$valor_json = $restricao_aplicacao->valor_padrao;

		// Obter a restricao especifica da licenca, caso exista
		$restricao_licenca = ORM::factory('Restricao_Licenca');
		$restricao_licenca
			->where('id_licenca', '=', $this->pk())
			->and_where('id_restricao_aplicacao', '=', $restricao_aplicacao->pk())
			->find();

		if ($restricao_licenca->loaded()) {
			$valor_json = $restricao_licenca->valor_personalisado;
		}

		// Decodificar valor JSON
		$valor = json_decode($valor_json);

		if (json_last_error() != JSON_ERROR_NONE) {
			throw new RuntimeException('Chave com valor JSON invalido');
		}

		return $valor;
	}

}
