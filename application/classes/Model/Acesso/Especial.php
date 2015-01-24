<?php
/**
 * Model Acesso_Especial
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Acesso_Especial extends ORM {
	protected $_table_name = 'acessos_especiais';
	protected $_primary_key = 'id_acesso_especial';

	protected $_table_columns = array(
		'id_acesso_especial' => NULL,
		'hash' => NULL,
		'validade' => NULL,
		'id_usuario' => NULL
	);

	protected $_belongs_to = array(
		'usuario' => array('model' => 'Usuario', 'foreign_key' => 'id_usuario'),
	);

	public function rules()
	{
		return array(
			'id_usuario' => array(
				array('not_empty')
			),
			'hash' => array(
				array('not_empty')
			),
			'validade' => array(
				array('not_empty')
			)
		);
	}
}