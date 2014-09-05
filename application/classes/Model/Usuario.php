<?php
/**
 * Usuário do sistema
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Usuario extends ORM {

	protected $_table_name = 'usuarios';
	protected $_primary_key = 'id_usuario';

	protected $_table_columns = array(
		'id_usuario' => NULL,
		'nome' => NULL,
		'email' => NULL,
		'senha' => NULL,
		'id_conta' => NULL,
	);

	protected $_belongs_to = array(
		'conta' => array('model' => 'Conta', 'foreign_key' => 'id_conta'),
	);

	protected $_has_many = array(
		'tokens' => array('model' => 'Usuario_Token'),
	);

	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128))
			),
			'email' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128)),
				array('email'),
				array(array($this, 'unique'), array('email', ':value'))
			),
			'senha' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128))
			),
			'id_conta' => array(
				array('not_empty'),
				array(array($this, 'unique'), array('email', ':value')),
			)
		);
	}

	public function filters()
	{
		return array(
			'nome' => array(
				array('trim')
			),
			'email' => array(
				array('trim')
			),
			'senha' => array(
				array(array(Auth::instance(), 'hash'), array(':value'))
			)
		);
	}

	public function complete_login() {}

}
