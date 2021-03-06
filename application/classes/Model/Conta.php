<?php
/**
 * Conta usuários
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Conta extends Model_Base {
	protected $_table_name = 'contas';
	protected $_primary_key = 'id_conta';

	protected $_table_columns = array(
		'id_conta' => NULL,
		'id_licenca' => NULL,
	);

	protected $_belongs_to = array(
		'licenca' => array('model' => 'Licenca', 'foreign_key' => 'id_licenca'),
	);

	protected $_has_many = array(
		'usuarios' => array('model' => 'Usuario', 'foreign_key' => 'id_conta', 'far_key' => 'id_usuario'),
	);

	public function rules()
	{
		return array(
			'id_licenca' => array(
				array('not_empty'),
			),
		);
	}

}
