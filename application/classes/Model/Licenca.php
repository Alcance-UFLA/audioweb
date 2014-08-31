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
		'contas' => array('model' => 'Conta'),
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

}
