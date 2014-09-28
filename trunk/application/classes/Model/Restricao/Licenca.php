<?php
/**
 * Restrição de uma licença.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Restricao_Licenca extends ORM {
	protected $_table_name = 'restricoes_licencas';
	protected $_primary_key = 'id_restricao_licenca';

	protected $_table_columns = array(
		'id_restricao_licenca' => NULL,
		'valor_personalisado' => NULL,
		'id_licenca' => NULL,
		'id_restricao_aplicacao' => NULL
	);

	protected $_belongs_to = array(
		'licenca' => array('model' => 'Licenca', 'foreign_key' => 'id_licenca'),
		'restricao_aplicacao' => array('model' => 'Restricao_Licenca', 'foreign_key' => 'id_restricao_aplicacao')
	);

	public function rules()
	{
		return array(
			'valor_personalisado' => array(
				array('not_empty')
			)
		);
	}

}
